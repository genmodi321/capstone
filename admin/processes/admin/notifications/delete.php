<?php 
// delete.php
session_start();
require '../../server/conn.php'; // Adjust the path based on your directory structure

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    // Delete the notification from the database
    $stmt = $pdo->prepare("DELETE FROM admin_notifications WHERE id = ?");
    $stmt->execute([$id]);
    // Redirect or return a success message
    header('Location: /path/to/notifications'); // Change to your redirect path
}

?>