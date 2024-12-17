<?php
include('../../server/conn.php');
session_start(); 
date_default_timezone_set('Asia/Manila');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = htmlspecialchars($_POST['username_email']);
    $password_account = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM admin WHERE username = :username_or_email OR email = :username_or_email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username_or_email', $username_or_email);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password_account, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['email'] = $admin['email'];
            $_SESSION['STATUS'] = "ADMIN_LOGIN_SUCCESFUL";

            header("Location: ../../../dashboard.php");
            exit;
        } else {
            $_SESSION['STATUS'] = 'ADMIN_INVALID_LOGIN';
            
            header("Location: ../../../admin_login_page.php"); 
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
