<?php
session_start();
require_once '../../server/conn.php'; // Ensure this path is correct

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullName'] = $user['fullName'];
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['course'] = $user['course'];
        $_SESSION['year_level'] = $user['year_level'];

        // Redirect to the dashboard or home page
        header("Location: ../../../student_dashboard.php"); // Change to your dashboard file
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
