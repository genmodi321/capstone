<?php
require_once 'conn.php'; // Include your database connection
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate password confirmation
    if ($password !== $confirm_password) {
        $_SESSION['STATUS'] = "PASSWORD_NOT_SAME";
        header("Location: ../index.php?error=PasswordNotSame");
    }

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $emailCheckQuery = "
        SELECT COUNT(*) FROM admin WHERE email = :email_admin
        UNION ALL
        SELECT COUNT(*) FROM staff_accounts WHERE email = :email_staff
        UNION ALL
        SELECT COUNT(*) FROM students WHERE email = :email_student
    ";
        $emailCheckStmt = $pdo->prepare($emailCheckQuery);
        $emailCheckStmt->execute([
            ':email_admin' => $email,
            ':email_staff' => $email,
            ':email_student' => $email
        ]);


        $emailCount = array_sum($emailCheckStmt->fetchAll(PDO::FETCH_COLUMN));
        if ($emailCount > 0) {
            $_SESSION['STATUS'] = "EMAIL_ALREADY_EXISTS";
            header("Location: ../index.php?error=Email already exists!");
            exit();
        }

        // Handle data based on the role
        if ($role === "admin") {
            // Insert into admin table
            $query = "INSERT INTO admin (username, email, password, first_name, middle_name, last_name, date_created, phone_number, gender) 
                      VALUES (:username, :email, :password, :first_name, :middle_name, :last_name, NOW(), :phone_number, :gender)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':username' => $_POST['username'] ?? '',
                ':email' => $email,
                ':password' => $hashed_password,
                ':first_name' => $_POST['first_name'] ?? '',
                ':middle_name' => $_POST['middle_name'] ?? '',
                ':last_name' => $_POST['last_name'] ?? '',
                ':phone_number' => $_POST['phone_number'] ?? '',
                ':gender' => $_POST['gender'] ?? ''
            ]);
            header("Location: ../index.php?success=Registration successful!");
        } elseif ($role === "staff") {
            // Insert into staff_accounts table
            $query = "INSERT INTO staff_accounts (fullName, email, password, department, class, date_created, phone_number, gender, role) 
                      VALUES (:fullName, :email, :password, :department, :class, NOW(), :phone_number, :gender, 'Staff')";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':fullName' => $fullName,
                ':email' => $email,
                ':password' => $hashed_password,
                ':department' => $_POST['department'] ?? '',
                ':class' => $_POST['class'] ?? '',
                ':phone_number' => $_POST['phone_number'] ?? '',
                ':gender' => $_POST['gender'] ?? ''
            ]);
            $_SESSION['STATUS'] = "REGISTRATION_SUCCESSFUL_ACTIVATION_PLEASE";
        } elseif ($role === "student") {
            // Validate WMSU email
            if (!str_ends_with($email, '@wmsu.edu.ph')) {
                $_SESSION['STATUS'] = "EMAIL_NOT_WMSU";
                header("Location: ../index.php?error=Only WMSU emails are allowed!");
                exit();
            }

            // Check if student_id exists
            $studentIdCheckQuery = "SELECT COUNT(*) FROM students WHERE student_id = :student_id";
            $studentIdCheckStmt = $pdo->prepare($studentIdCheckQuery);
            $studentIdCheckStmt->execute([':student_id' => $_POST['student_id'] ?? '']);
            $studentIdExists = $studentIdCheckStmt->fetchColumn();

            if ($studentIdExists > 0) {
                $_SESSION['STATUS'] = "STUDENT_ID_EXISTS";
                header("Location: ../index.php?error=Student ID already exists!");
                exit();
            }

            // Insert into students table
            $query = "INSERT INTO students (fullName, student_id, gender, course, year_level, email, password, role) 
                      VALUES (:fullName, :student_id, :gender, :course, :year_level, :email, :password, 'Student')";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':fullName' => $fullName,
                ':student_id' => $_POST['student_id'] ?? '',
                ':gender' => $_POST['gender'] ?? '',
                ':course' => $_POST['course'] ?? '',
                ':year_level' => $_POST['year_level'] ?? '',
                ':email' => $email,
                ':password' => $hashed_password
            ]);

            $_SESSION['STATUS'] = "REGISTRATION_SUCCESSFUL_ACTIVATION_PLEASE";
            // Redirect after success
            header("Location: sendActivationEmail.php?email=$email&name=$fullName");
        }


        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>