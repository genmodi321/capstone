<?php
// Include your database connection file
include('../../server/conn.php'); // Adjust the path based on your folder structure
session_start();


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare the SQL delete query
        $sql = "DELETE FROM staff_accounts WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Bind the ID parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "STAFF_DELETE_SUCCESS";
            header('Location: ../../../staff_management.php');
            exit();
        } else {
            $_SESSION['STATUS'] = "STAFF_DELETE_ERROR";
            header('Location: ../../../staff_management.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "STAFF_DELETE_ERROR";
        header('Location: ../../../staff_management.php');
    }
} else {
    $_SESSION['STATUS'] = "STAFF_DELETE_ERROR";
        header('Location: ../../../staff_management.php');
    exit();
}
?>
