<?php
require_once 'conn.php'; // Database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $_SESSION['STATUS'] = "PASSWORDS_DO_NOT_MATCH";
        header("Location: reset_password_form.php?token=$token&status=passwords_do_not_match");
        exit();
    }

    try {
        // Check if the token is valid
        $query = "SELECT * FROM students WHERE reset_token = :token";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch();

        if ($user) {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update the password in the database
            $query = "UPDATE students SET password = :password, reset_token = NULL WHERE reset_token = :token";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':password' => $hashed_password, ':token' => $token]);

            $_SESSION['STATUS'] = "PASSWORD_RESET_SUCCESS";
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['STATUS'] = "INVALID_TOKEN";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
