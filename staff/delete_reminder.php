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
    $reminder_id = $_POST['reminder_id'];

    $sql = "DELETE FROM teacher_reminders WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $reminder_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        http_response_code(500);
        echo "Error deleting reminder.";
    }
}
?>
