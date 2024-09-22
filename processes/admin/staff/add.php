<?php
include('../../server/conn.php'); 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $class = $_POST['class'];

    try {
 
        $sql = "INSERT INTO staff_accounts (fullName, department, email, password, class) 
                VALUES (:fullName, :department, :email, :password, :class)";

        $stmt = $pdo->prepare($sql);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':class', $class);

   
        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "STAFF_ADDED_SUCCESFULLY";
            header('Location: ../../../staff_management.php');
        } else {
            $_SESSION['STATUS'] = "STAFF_ADDED_ERROR";
            header('Location: ../../../staff_management.php');
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "STAFF_ADDED_ERROR";
        header('Location: ../../../staff_management.php');
    }
}
