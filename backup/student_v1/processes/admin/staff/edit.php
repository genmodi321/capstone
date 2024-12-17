<?php
// Include your database connection
include('../../server/conn.php'); // Adjust the path based on your folder structure
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $class = $_POST['class'];
    try {

        // Check for existing email
        $sql = "SELECT id FROM staff_accounts WHERE email = :email AND id != :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['STATUS'] = "STAFF_EMAIL_REGISTERED";
            exit();
        }

        // Prepare the SQL update query
        if ($password) {
            // If password is provided, update it along with other details
            $sql = "UPDATE staff_accounts SET fullName = :full_name, email = :email, department = :department, password = :password, class = :class WHERE id = :id";
        } else {
            // If no password is provided, update without changing the password
            $sql = "UPDATE staff_accounts SET fullName = :full_name,  email = :email, department = :department, class = :class WHERE id = :id";
        }

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', var: $email);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':class', $class);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($password) {
            $stmt->bindParam(':password', $password);
        }

        // Execute the update query
        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "STAFF_ACCOUNT_UPDATED";
            header('Location: ../../../staff_management.php');
            exit();
        } else {
            $_SESSION['STATUS'] = "STAFF_ACCOUNT_FAIL_UPDATE";
            header('Location: ../../../staff_management.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['STATUS'] = "STAFF_ACCOUNT_FAIL_UPDATE";
    header('Location: ../../../staff_management.php');
}
?>
