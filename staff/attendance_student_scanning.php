<?php
session_start();
require_once 'processes/server/conn.php'; // Make sure the path is correct
date_default_timezone_set('Asia/Manila'); // Set the timezone for the script

// Check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate login credentials (you should replace this with your actual login logic)
    $stmt = $pdo->prepare("SELECT student_id FROM students WHERE email = :email AND password = :password"); // Replace with your real query
    $stmt->execute([
        ':email' => $email,
        ':password' => $password,
    ]);

    if ($stmt->rowCount() > 0) {
        // Login successful
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['student_id'] = $user['student_id'];
    } else {
        // Login failed
        $loginError = "Invalid username or password.";
    }
}

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    // Show login form if not logged in
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WMSU - CCS | Comprehensive Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="external/css/login.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="external/img/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>
    </head>
    <body>
        <?php if (isset($loginError)) { echo "<p style='color:red;'>$loginError</p>"; } ?>
        <div class="container-fluid login-container">

        <div class="actual-login-container">
            <small><a href="index.html" class="gb"><i class="bi bi-arrow-left-circle-fill"></i> Go back</a></small>
            <img src="external/img/wmsu_Logo-removebg-preview.png" class="img-fluid big-logo">
            <h5 class="bold">STUDENT LOGIN</h5>

            <div class="container login-container-with-input">
                <form method="POST" >
                    <label style="text-align: left !important;" class="bold">EMAILS</label>
                    <input class="form-control" name="email" type="email" placeholder="Email" required>
                    <br>
                    <label style="text-align: left !important;" class="bold">PASSWORD</label>
                    <input class="form-control" name="password" type="password" placeholder="Password" required>
            </div>

            <div class="button-linkers d-flex justify-content-between">
                <a href="student_create_account.php" class="gb-link me-auto" class="gb">Create an Account</a>
                <a data-bs-toggle="modal" data-bs-target="#resetPasswordModal" class="gb-link">Forgot your password?</a>

            </div>
            <div class="container login-container-with-input">
                <input type="submit" value="Login" class="login-btn">
            </div>
        </div>

        </form>
    </div>
    </body>
    </html>
    <?php
    exit();
}

// Extract student information from the session
$studentId = $_SESSION['student_id'];

// Extract QR data from the URL
$classId = $_GET['class_id'] ?? null;
$date = $_GET['date'] ?? null;
$startTime = $_GET['start_time'] ?? null;
$endTime = $_GET['end_time'] ?? null; // New line to extract end_time
$meetingId = $_GET['meetingId'] ?? null;

// Validate QR data
if ($classId && $date && $startTime && $endTime) { // Added endTime validation
    // Call the function to mark attendance
    markAttendance($studentId, $classId, $date, $startTime, $endTime, $meetingId); // Pass endTime to the function
} else {
    // Set error message for invalid data
    $_SESSION['status_message'] = "Invalid attendance data.";
    header('Location: ../students/attendance_status.php');
    exit();
}

function markAttendance($studentId, $classId, $date, $startTime, $endTime, $meetingId) {
    global $pdo; // Ensure you use your PDO connection
    $currentTime = date('h:i A'); 
    $currentTimestamp = strtotime($currentTime);
    $startTimeStamp = strtotime($date . ' ' . $startTime); 
    $endTimeStamp = strtotime($date . ' ' . $endTime); 

    $stmt = $pdo->prepare("SELECT status FROM attendance WHERE student_id = :student_id AND class_id = :class_id AND date = :date AND meeting_id = :meeting_id");
    $stmt->execute([
        ':student_id' => $studentId,
        ':class_id' => $classId,
        ':date' => $date,
        ':meeting_id' => $meetingId,
    ]);

    // Check if any record exists
    if ($stmt->rowCount() > 0) {
        // A record exists, fetch the existing status
        $existingRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['status_message'] = "Attendance already recorded as: " . htmlspecialchars($existingRecord['status']);
        header('Location: ../students/attendance_status.php'); // Redirect to the status page
        exit(); // Stop further execution
    }

    // Determine attendance status
    $status = 'absent'; // Default status
    if ($currentTimestamp >= $startTimeStamp && $currentTimestamp <= ($startTimeStamp + (5 * 60))) {
        $status = 'present'; // Present if within 5 minutes after start time
    } elseif ($currentTimestamp > ($startTimeStamp + (5 * 60)) && $currentTimestamp <= $endTimeStamp) { // After 5 minutes but before end time
        $status = 'late'; // Late if after 5 minutes but before end time
    } elseif ($currentTimestamp > $endTimeStamp) {
        $status = 'absent'; // After end time, mark as absent
    }

    // Insert attendance record into the database
    $stmt = $pdo->prepare("INSERT INTO attendance (student_id, meeting_id, class_id, date, status) VALUES (:student_id, :meeting_id, :class_id, :date, :status)");
    $stmt->execute([
        ':student_id' => $studentId,
        ':meeting_id' => $meetingId,
        ':class_id' => $classId,
        ':date' => $date,
        ':status' => $status,
    ]);

    // Set success message
    $_SESSION['status_message'] = "Attendance marked successfully as: " . htmlspecialchars($status);
    header('Location: ../students/attendance_status.php'); // Redirect to the status page
    exit();
}
?>
