<?php
session_start();
require_once '../../server/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_GET['id'];
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $gender = htmlspecialchars(trim($_POST['gender']));

    $sql = "SELECT * FROM admin WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    // Fetch results
    if ($stmt->rowCount() > 0) {
        // If there's a duplicate
        $_SESSION['STATUS'] = "DUPLICATE_ACCOUNT";
        header('Location: ../../../admin_management.php');
        exit;
    }


    try {
        $sql = "UPDATE admin 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    username = :username, 
                    email = :email, 
                    gender = :gender 
                WHERE id = :admin_id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':admin_id', $admin_id);

        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "ADMIN_EDIT_SUCCESFULLY";
            header('Location: ../../../admin_management.php');
        } else {
            $_SESSION['STATUS'] = "ADMIN_EDIT_ERROR";
            header('Location: ../../../admin_management.php');
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ADMIN_EDIT_ERROR";
        header('Location: ../../../admin_management.php');
    }
} else {
    $_SESSION['STATUS'] = "ADMIN_EDIT_ERROR";
    header('Location: ../../../admin_management.php');
}
