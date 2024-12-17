<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    $_SESSION['STATUS'] = "STUDENT_NOT_LOGGED_IN";
	header("Location: ../login/index.php");
}

date_default_timezone_set('Asia/Manila'); // Set the timezone for the script
require('../vendor/phpqrcode/qrlib.php');

$class_id = $_GET['class_id'];
$classAttendanceId = $_GET['classAttendanceId'];
$semester_id = $_GET['semesterId'];
include('processes/server/conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WMSU - CCS | Comprehensive Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>

<style>
    table.dataTable {
        font-size: 12px;
    }

    td {
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid black;
    }

    .btn-csms {
        background-color: #709775;
        color: white;
    }

    .btn-csms:hover {
        border: 1px solid #709775;
    }

    .meeting-day {
        background-color: rgba(40, 167, 69, 0.5) !important;
        /* Light green background */
    }
</style>

<body>
    <div class="wrapper">
        <?php
        include('sidebar.php')
            ?>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <img src="external/img/ccs_logo-removebg-preview.png" class="logo-small">
                <span class="text-white">WMSU - Comprehensive Student Management System </span>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">4</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    4 New Notifications
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-danger" data-feather="alert-circle"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Update completed</div>
                                                <div class="text-muted small mt-1">Restart server 12 to complete the
                                                    update.</div>
                                                <div class="text-muted small mt-1">30m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-warning" data-feather="bell"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Lorem ipsum</div>
                                                <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate
                                                    hendrerit et.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-primary" data-feather="home"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Login from 192.186.1.8</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-success" data-feather="user-plus"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">New connection</div>
                                                <div class="text-muted small mt-1">Christina accepted your request.
                                                </div>
                                                <div class="text-muted small mt-1">14h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="img/avatars/avatar-5.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Vanessa Tucker</div>
                                                <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu
                                                    tortor.</div>
                                                <div class="text-muted small mt-1">15m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="img/avatars/avatar-2.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="William Harris">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">William Harris</div>
                                                <div class="text-muted small mt-1">Curabitur ligula sapien euismod
                                                    vitae.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="img/avatars/avatar-4.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Christina Mason">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Christina Mason</div>
                                                <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.
                                                </div>
                                                <div class="text-muted small mt-1">4h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="img/avatars/avatar-3.jpg"
                                                    class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                                            </div>
                                            <div class="col-10 ps-2">
                                                <div class="text-dark">Sharon Lessman</div>
                                                <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed,
                                                    posuere ac, mattis non.</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown">
                                <span class="text-light">Admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1"
                                        data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.html"><i class="align-middle me-1"
                                        data-feather="settings"></i> Settings & Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1"
                                        data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>



            <main class="content">
                <div id="page-content-wrapper">
                    <div class="container-fluid">

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Optional card header content -->
                            </div>
                            <div class="card-body mb-4">

                                <a href="student_dashboard.php" class="d-flex align-items-center mb-3">
                                    <i class="bi bi-arrow-left-circle"
                                        style="font-size: 1.5rem; margin-right: 5px;"></i>
                                    <p class="m-0">Back</p>
                                </a>

                                <?php
                                // Prepare statement to get meeting data
                                $stmt = $pdo->prepare("SELECT id, date, class_id, status, start_time, end_time, type FROM classes_meetings WHERE id = :id");
                                $stmt->bindParam(':id', $classAttendanceId, PDO::PARAM_INT);
                                $stmt->execute();
                                $meetingData = $stmt->fetch(PDO::FETCH_ASSOC);

                                $date = new DateTime($meetingData['date']);


                                $class_id = $_GET['class_id'] ?? null;
                                $semester = $_GET['semester'] ?? null;

                                $meeting_id = $_GET['classAttendanceId'];
                                $classData = null;
                                if ($class_id) {
                                    // Query database to get class details
                                    $stmt = $pdo->prepare("SELECT name, subject, teacher, semester FROM classes WHERE id = :class_id LIMIT 1");
                                    $stmt->execute(['class_id' => $class_id]);
                                    $classData = $stmt->fetch(PDO::FETCH_ASSOC);
                                }

                                // QR Code generation
                                if ($meetingData) {
                                    $startTime = $meetingData['start_time']; // Get start time from meeting data
                                    $endTime = $meetingData['end_time']; // Get start time from meeting data
                                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                                    $host = $_SERVER['HTTP_HOST'];
                                    $scriptPath = dirname($_SERVER['PHP_SELF']); // Get the directory of the current script
                                    // $protocol . $host . $scriptPath . 
                                    $baseUrl = 'https://172.20.10.2/capstone/staff/attendance_student_scanning.php'; // Adjust path if necessary
                                
                                    // Concatenate the data for the QR code
                                    $qrData = "$baseUrl?class_id={$meetingData['class_id']}&date=" . $date->format('Y-m-d') . "&start_time=$startTime&end_time=" . $endTime . "&meetingId=" . $meeting_id;


                                    $qrImagePath = 'qr_image.png'; // Path to save the QR code image
                                    QRcode::png($qrData, $qrImagePath); // Generate the QR code
                                }

                                $classAttendanceId = $_GET['classAttendanceId'] ?? null; // Get the meeting ID from the URL
                                
                                if ($classAttendanceId) {
                                    // Prepare statement to get meeting data
                                    $stmt = $pdo->prepare("SELECT id, date, class_id, status, start_time, end_time, type FROM classes_meetings WHERE id = :id");
                                    $stmt->bindParam(':id', $classAttendanceId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $meetingData = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $date = new DateTime($meetingData['date']);
                                }
                                ?>

                                <div class="row">
                                    <h2 class="bold" style="margin-bottom: 20px; text-align:center;">Class Attendance
                                        for <?php echo $date->format('F j, Y') ?></h2>
                                    <h2>Class Details</h2>
                                    <div class="col">
                                        <h3><b><i class="bi bi-person-circle" style="margin-right: 5px;"></i>
                                                Teacher:</b>
                                            <span><?php echo htmlspecialchars($classData['teacher'] ?? 'Not Assigned'); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-book" style="margin-right: 5px;"></i> Subject:</b>
                                            <span><?php echo htmlspecialchars($classData['subject'] ?? 'No Subject'); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-building" style="margin-right: 5px;"></i> Year and
                                                Section:</b>
                                            <span><?php echo htmlspecialchars($classData['name'] ?? 'Not Available'); ?></span>
                                        </h3>
                                    </div>
                                    <div class="col">
                                        <h3><b><i class="bi bi-calendar3" style="margin-right: 5px;"></i> Semester:</b>
                                            <span><?php echo htmlspecialchars($classData['semester'] ?? 'No Semester'); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-calendar-range" style="margin-right: 5px;"></i> School
                                                Year:</b>
                                            <span>2023-2024</span> <!-- Replace with actual school year if dynamic -->
                                        </h3>

                                    </div>

                                    <?php
                                    // Get the current timestamp and the end time for comparison
                                    $currentDateTime = new DateTime();
                                    $classEndDateTime = new DateTime($date->format('Y-m-d') . ' ' . $meetingData['end_time']); // Replace $meetingData with the actual array containing end_time
                                    
                                    // Check if the meeting date and time have passed
                                    $isClassFinished = $currentDateTime > $classEndDateTime;

                                    // Display content based on the date and time
                                    $isToday = $date->format('Y-m-d') === date('Y-m-d');
                                    if ($isClassFinished) {
                                        // If the class has ended based on date and end time
                                        ?>
                                        <div class="col text-end">
                                            <div class="text-center mb-3">
                                                <h4>Attendance Closed</h4>
                                                <p>The attendance period for this class has ended.</p>
                                            </div>
                                        </div>
                                        <?php
                                    } elseif ($isToday && isset($qrImagePath) && file_exists($qrImagePath)) {
                                        // If the class date is today and the QR code exists
                                        ?>
                                        <div class="col text-end">
                                            <!-- QR Code Display -->
                                            <div class="text-center mb-3">
                                                <h4>Scan the QR Code for Attendance</h4>
                                                <img src="<?php echo htmlspecialchars($qrImagePath); ?>"
                                                    alt="Class Attendance QR Code" style="width: 200px; height: auto;">
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        // If it's not today or the QR code is not available
                                        ?>
                                        <div class="col text-end">
                                            <!-- QR Code Notice -->
                                            <div class="text-center mb-3">
                                                <h4>QR Code for Attendance</h4>
                                                <p>The QR code will be generated on the day of the class.</p>
                                                <p>Class Date: <?php echo $date->format('F j, Y'); ?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>


                                </div>

                                <br>
                                <div class="row">
                                    <h2>Meeting Details</h2>
                                    <div class="col">
                                        <!-- Display meeting details -->
                                        <h3><b><i class="bi bi-clock" style="margin-right: 5px;"></i> Start Time:</b>
                                            <span><?php echo htmlspecialchars($meetingData['start_time'] ?? 'N/A'); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-clock-history" style="margin-right: 5px;"></i> End
                                                Time:</b>
                                            <span><?php echo htmlspecialchars($meetingData['end_time'] ?? 'N/A'); ?></span>
                                        </h3>
                                    </div>
                                    <Div class="col">
                                        <h3><b><i class="bi bi-bar-chart-line" style="margin-right: 5px;"></i>
                                                Status:</b>
                                            <span><?php echo htmlspecialchars($meetingData['status'] ?? 'N/A'); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-list-task" style="margin-right: 5px;"></i> Type:</b>
                                            <span><?php echo htmlspecialchars($meetingData['type'] ?? 'N/A'); ?></span>
                                        </h3>
                                    </Div>

                                </div>
                                <hr>



                                <!-- Attendance List -->

                                <?php

                                $class_id = $_GET['class_id'] ?? null; // Get the class ID from the URL
                                


                                $students = [];
                                if ($class_id) {
                                    $stmt = $pdo->prepare("SELECT se.student_id FROM students_enrollments se WHERE se.class_id = :class_id");
                                    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $enrolledStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Fetch student details based on student_id
                                    foreach ($enrolledStudents as $enrollment) {


                                        $studentId = $enrollment['student_id'];


                                        $stmt = $pdo->prepare("SELECT id, fullName FROM students WHERE student_id = :student_id");
                                        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
                                        $stmt->execute();

                                        $studentData = $stmt->fetch(PDO::FETCH_ASSOC);


                                        if ($studentData) {
                                            // Fetch attendance status from the attendance table
                                            $attendanceStatus = getAttendanceStatus($studentId, $class_id); // Function to determine attendance status
                                
                                            $students[] = [
                                                'id' => $studentData['id'],
                                                'fullName' => $studentData['fullName'],
                                                'status' => $attendanceStatus,
                                            ];
                                        }
                                    }
                                }

                                // Function to determine attendance status based on your application logic
                                function getAttendanceStatus($studentId, $classId)
                                {
                                    global $pdo; // Use the global PDO connection
                                    $stmt = $pdo->prepare("SELECT status FROM attendance WHERE student_id = :student_id AND class_id = :class_id ORDER BY timestamp DESC LIMIT 1");
                                    $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
                                    $stmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $attendanceRecord = $stmt->fetch(PDO::FETCH_ASSOC);
                                    return $attendanceRecord ? $attendanceRecord['status'] : 'none'; // Return 'none' if no record found
                                }

                                // Function to determine attendance status based on your application logic
                                ?>



                                <!-- JavaScript to print a specific div -->
                                <script>
                                    function printDiv(divId) {
                                        var printContents = document.getElementById(divId).innerHTML;
                                        var originalContents = document.body.innerHTML;

                                        document.body.innerHTML = printContents;
                                        window.print();
                                        document.body.innerHTML = originalContents;
                                    }
                                </script>


                            </div>
                        </div>

                    </div>
                </div>
            </main>

        </div>


        <script src="js/app.js"></script>
        <?php
        include('processes/server/modals.php');
        ?>




        <script>
            function getTime() {
                const now = new Date();
                const newTime = now.toLocaleString();

                document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
            }
            setInterval(getTime, 100);
        </script>



        <!-- Add this modal to your HTML for creating a new class meeting -->



        <div class="modal fade" id="createClassModal" tabindex="-1" aria-labelledby="createClassModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createClassModalLabel">Create Class Meeting on <span
                                id="createModalDate"></span></h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createClassForm">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" value="<?php echo $subjectName ?>"
                                    readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Late">Ongoing</option>
                                    <option value="Make-up">Ended</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="startTime" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="startTime" value="<?php echo $startTime ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="endTime" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="endTime" value="<?php echo $endTime ?>"
                                    required>
                            </div>


                            <button type="submit" class="btn btn-primary">Create Meeting</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal modal-lg fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="classModalLabel">Classes on <span id="modalDate"></span></h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="classDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editClassModalLabel">Edit Class Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editClassForm">
                            <input type="hidden" id="editClassId" name="classId">
                            <div class="mb-3">
                                <label for="status" class="form-label">Class Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Rescheduled">Rescheduled</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#attendanceTable').DataTable(); // Initialize DataTable
            });
        </script>


</html>



<?php
include('processes/server/alerts.php');
?>