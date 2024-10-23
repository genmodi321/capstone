<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

try {
    $stmt = $pdo->prepare("DELETE FROM admin_notifications");
    $stmt->execute();
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
