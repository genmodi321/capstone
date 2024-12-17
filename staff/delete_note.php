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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $note_id = $_POST['note_id'];

    try {
        // Delete the note from the database
        $sql = "DELETE FROM teacher_notes WHERE id = :note_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':note_id', $note_id, PDO::PARAM_INT);
        $stmt->execute();

        echo 'Note deleted successfully!';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
