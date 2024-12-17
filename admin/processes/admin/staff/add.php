<?php
include('../../server/conn.php'); 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $class = !empty($_POST['class']) ? $_POST['class'] : 'None'; // Handle empty class
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $_SESSION['STATUS'] = "PASSWORD_MISMATCH";
        header('Location: ../../../teacher_management.php');
        exit;
    }

    try {
        // Check if email already exists in the database
        $checkEmailSql = "SELECT * FROM staff_accounts WHERE email = :email";
        $checkStmt = $pdo->prepare($checkEmailSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // Email already exists
            $_SESSION['STATUS'] = "STAFF_EMAIL_EXISTS";
            header('Location: ../../../teacher_management.php');
            exit;
        }

        // Check if the class already exists for the same department
        if ($class !== 'None') {  // Skip this check for 'None' value in class
            $checkClassSql = "SELECT * FROM staff_accounts WHERE department = :department AND class = :class";
            $checkClassStmt = $pdo->prepare($checkClassSql);
            $checkClassStmt->bindParam(':department', $department);
            $checkClassStmt->bindParam(':class', $class);
            $checkClassStmt->execute();

            if ($checkClassStmt->rowCount() > 0) {
                // Class already exists in this department
                $_SESSION['STATUS'] = "CLASS_DUPLICATE";
                header('Location: ../../../teacher_management.php');
                exit;
            }
        }

        // SQL query to insert a new staff account
        $sql = "INSERT INTO staff_accounts (fullName, department, email, password, class, phone_number, gender) 
                VALUES (:fullName, :department, :email, :password, :class, :phone_number, :gender)";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':class', $class);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':gender', $gender);

        // Execute and handle result
        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "STAFF_ADDED_SUCCESSFULLY";
            header('Location: ../../../teacher_management.php');
        } else {
            $_SESSION['STATUS'] = "STAFF_ADDED_ERROR";
            header('Location: ../../../teacher_management.php');
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "STAFF_ADDED_ERROR";
        // Optionally, log or echo the error during development
        // echo "Error: " . $e->getMessage();
        header('Location: ../../../teacher_management.php');
    }
}
