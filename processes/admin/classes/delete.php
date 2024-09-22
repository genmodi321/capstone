<?php
require '../../server/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM classes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "DELETE_CLASS_SUCCESS";
            header('Location: ../../../class_management.php');
        } else {
            $_SESSION['STATUS'] = "DELETE_CLASS_FAIL";
            header('Location: ../../../class_management.php');
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . htmlspecialchars($e->getMessage())]);
    }
}
