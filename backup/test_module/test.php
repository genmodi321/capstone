<?php
require 'vendor/phpqrcode/qrlib.php';

// Variables for class, date, and start time
$classId = $_GET['class_id'] ?? '123'; // Replace with actual data
$date = $_GET['date'] ?? date('Y-m-d'); // Replace with actual data
$startTime = '15:00'; // Example start time 3:00 PM

// Dynamically create base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$scriptPath = dirname($_SERVER['PHP_SELF']); // Get the directory of the current script
$baseUrl = $protocol . $host . $scriptPath . '/scan.php'; // Adjust path if necessary

// Concatenate the data for the QR code
$qrData = "$baseUrl?class_id=$classId&date=$date&start_time=$startTime";

// Generate the QR code image
$qrImagePath = 'qr_image.png';
QRcode::png($qrData, $qrImagePath);

// Display QR code on the page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code for Class Attendance</title>
</head>
<body>
    <h1>Class Attendance QR Code</h1>
    <p>Scan this QR code to mark attendance for Class ID: <?php echo htmlspecialchars($classId); ?> on <?php echo htmlspecialchars($date); ?>.</p>
    <img src="<?php echo $qrImagePath; ?>" alt="Class QR Code">
</body>
</html>
