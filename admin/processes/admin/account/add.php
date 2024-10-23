<?php
session_start();
include_once '../../server/conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = trim($_POST['first_name']);
    $middleName = trim($_POST['middle_name']);
    $lastName = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $phoneNumber = trim($_POST['phone_number']);
    $gender = $_POST['gender'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        die('Passwords do not match.');
    }

    try {
        // Check if username or email already exists
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

        // If no duplicate, proceed to insert new admin
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (first_name, middle_name, last_name, username, email, password, phone_number, gender)
                VALUES (:first_name, :middle_name, :last_name, :username, :email, :password, :phone_number, :gender)";

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':middle_name', $middleName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':gender', $gender);

        // Execute and handle result
        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "ADMIN_ADDED_SUCCESFULLY";
            header('Location: ../../../admin_management.php');
        } else {
            $_SESSION['STATUS'] = "ADMIN_ADDED_ERROR";
            header('Location: ../../../admin_management.php');
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ADMIN_ADDED_ERROR";
        header('Location: ../../../admin_management.php');
    }
}
