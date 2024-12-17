<?php
include('../../server/conn.php');
session_start();
date_default_timezone_set('Asia/Manila');

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data and sanitize it
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $first_name = htmlspecialchars($_POST['first_name']);
        $middle_name = htmlspecialchars($_POST['middle_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $phone_number = htmlspecialchars($_POST['phone_number']);
        $gender = htmlspecialchars($_POST['gender']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        // Prepare an SQL statement to insert the data
        $sql = "INSERT INTO admin (username, email, password, first_name, middle_name, last_name, phone_number, gender) 
                VALUES (:username, :email, :password, :first_name, :middle_name, :last_name, :phone_number, gender)";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters to the statement
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':middle_name', $middle_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':gender', $gender);

        // Execute the statement
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
