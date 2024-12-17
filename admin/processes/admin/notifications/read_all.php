<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

// Assuming you have a `status` column in your `admin_notifications` table
try {
    $stmt = $pdo->prepare("UPDATE admin_notifications SET status = 'read' WHERE status = 'unread'");
    $stmt->execute();
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    header('Location: ../../index.php'); // Fallback if no referrer
    exit();
}
?>
