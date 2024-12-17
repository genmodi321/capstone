<?php
session_start();
include_once '../../server/conn.php'; // Ensure the correct path to your connection file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM admin WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "ADMIN_DELETE_SUCCESS";
            header('Location: ../../../admin_management.php');
            exit();
        } else {
            $_SESSION['STATUS'] = "ADMIN_DELETE_ERROR";
            header('Location: ../../../admin_management.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ADMIN_DELETE_ERROR";
        header('Location: ../../../admin_management.php');
        exit();
    }
} else {
    $_SESSION['STATUS'] = "ADMIN_DELETE_ERROR";
    header('Location: ../../../admin_management.php');
    exit();
}
?>
