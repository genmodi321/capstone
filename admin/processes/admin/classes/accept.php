<?php
require '../../../processes/server/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $classId = $_GET['id']; 

    try {
        $stmt = $pdo->prepare("UPDATE classes SET status = 'accepted' WHERE id = :id");
        $stmt->execute([':id' => $classId]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['STATUS'] = 'CLASS_STATUS_ACCEPTED';
        } else {
            $_SESSION['STATUS'] = 'CLASS_STATUS_ERROR';
        }

        header("Location: ../../pages-blank.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = 'Database error: ' . $e->getMessage();
        
        header("Location: ../../pages-blank.php");
        exit();
    }
} else {
    $_SESSION['STATUS'] = 'CLASS_STATUS_ERROR';
    
    header("Location: ../../pages-blank.php");
    exit();
}
