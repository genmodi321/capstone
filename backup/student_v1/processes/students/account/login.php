<?php
session_start();
require_once '../../server/conn.php'; // Ensure this path is correct

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Directly check if the user exists
    if ($user) {
        // User exists, set session variables
        $_SESSION['user_id'] = $user['student_id'];
        $_SESSION['fullName'] = $user['fullName'];
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['course'] = $user['course'];
        $_SESSION['year_level'] = $user['year_level'];

        // Redirect to the dashboard or home page
        header("Location: ../../../student_dashboard.php"); // Change to your dashboard file
        exit();
    } else {
        $error = "User not found.";
    }
}
?>
