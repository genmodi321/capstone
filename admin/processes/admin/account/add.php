<?php
require '../../server/conn.php'; // Ensure you include the PDO connection

session_start(); // Start session to manage status messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password before storing
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'] ?? ''; // Handle optional middle name
    $lastName = $_POST['last_name'];
    $phoneNumber = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $dateCreated = date('Y-m-d H:i:s'); // Get current timestamp for date_created

    try {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $duplicateCount = $stmt->fetchColumn();

        if ($duplicateCount > 0) {
            // If duplicate is found, set session status and redirect
            $_SESSION['STATUS'] = "ADMIN_DUPLICATE_ACCOUNT";
        } else {
            // Prepare SQL query to insert admin
            $stmt = $pdo->prepare("
                INSERT INTO admin (username, email, password, first_name, middle_name, last_name, phone_number, gender, date_created) 
                VALUES (:username, :email, :password, :first_name, :middle_name, :last_name, :phone_number, :gender, :date_created)
            ");
            
            // Bind parameters to the prepared statement
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $middleName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':date_created', $dateCreated, PDO::PARAM_STR);

            // Execute the statement
            if ($stmt->execute()) {
                // Set session status for success
                $_SESSION['STATUS'] = "ACCOUNT_C_SUCCESFUL";
            } else {
                // Set session status for failure
                $_SESSION['STATUS'] = "ADMIN_CREATE_FAILED";
            }
        }
    } catch (PDOException $e) {
        // Catch any exceptions (e.g., connection issues)
        $_SESSION['STATUS'] = "ADMIN_CREATE_ERROR: " . $e->getMessage();
    }

    // Redirect back to the admin management page (or wherever you want)
    header("Location: ../../../admin_management.php");
    exit;
}
?>
