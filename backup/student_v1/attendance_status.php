<?php
session_start();
echo  $_SESSION['student_id'];
// Check if there's a status message in the session
$statusMessage = $_SESSION['status_message'] ?? '';

// Clear the status message after displaying it
unset($_SESSION['status_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Status</title>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>
<body>
    <h1>Attendance Status</h1>

    <!-- Include SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    
    <script>
        // Check if there's a message to display
        <?php if (!empty($statusMessage)): ?>
            // Show SweetAlert with the status message
            swal({
                title: "Attendance Status",
                text: "<?php echo addslashes($statusMessage); ?>", // Escape quotes for JavaScript
                icon: "<?php echo strpos($statusMessage, 'success') !== false ? 'success' : 'error'; ?>",
                button: "OK",
            }).then((value) => {
                // Redirect to dashboard after closing the alert
                window.location.href = "192.168.1.10/capstone/student/student_dashboard.php";
            });
        <?php else: ?>
            // Redirect to dashboard if there's no message
            window.location.href = "192.168.1.10/capstone/student/student_dashboard.php";
        <?php endif; ?>
    </script>
</body>
</html>
