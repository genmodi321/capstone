<?php
session_Start();
$host = 'localhost';
$dbname = 'csms_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_name = $_SESSION['teacher_name'];
    $reminder_content = $_POST['reminder_content'];

    $sql = "INSERT INTO teacher_reminders (teacher_name, reminder_content, created_at) VALUES (:teacher_name, :reminder_content, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':teacher_name', $teacher_name, PDO::PARAM_STR);
    $stmt->bindParam(':reminder_content', $reminder_content, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect back to the main page
    } else {
        echo "Error adding reminder.";
    }
}
?>
