<?php
require 'processes/server/conn.php'; // Ensure this points to your database connection file

// Get the JSON data
$data = json_decode(file_get_contents('php://input'), true);
$classId = $data['classId'] ?? null;
$status = $data['status'] ?? null;

if ($classId && $status) {
    try {
        // Prepare the update statement
        $stmt = $pdo->prepare("UPDATE classes_meetings SET status = :status WHERE id = :classId");
        $stmt->execute(['status' => $status, 'classId' => $classId]);

        echo json_encode(['success' => true, 'message' => 'Class status updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>
