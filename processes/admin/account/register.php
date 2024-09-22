<?php
include('../../server/conn.php');
session_start();
date_default_timezone_set('Asia/Manila');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $first_name = htmlspecialchars($_POST['first_name']);
        $middle_name = htmlspecialchars($_POST['middle_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $phone_number = htmlspecialchars($_POST['phone_number']);
        $gender = htmlspecialchars($_POST['gender']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        echo $username . " " . $email  . " " . $first_name . " " . $middle_name . " " . $last_name;
        echo $phone_number . " " . $gender . " " . $password;
        $sql = "INSERT INTO admin (username, email, password, first_name, middle_name, last_name, phone_number, gender) 
                VALUES (:username, :email, :password, :first_name, :middle_name, :last_name, :phone_number, :gender)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':middle_name', $middle_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':gender', $gender);

        if ($stmt->execute()) {
          $_SESSION['STATUS'] = "ACCOUNT_C_SUCCESFUL";
          header('Location: ../../../admin_login_page.php');
        } else {
            echo "There was an error creating the account.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
