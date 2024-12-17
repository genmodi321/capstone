<?php
// Include database connection file
require 'conn.php';
session_start();

// Check if email and password are submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // First, check if the user is an admin
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            // Set session variables for admin
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['email'] = $admin['email'];
            $_SESSION['user_type'] = 'admin';
            $_SESSION['name'] = $admin['first_name'] . ' ' . $admin['last_name'];
            $_SESSION['STATUS'] = "ADMIN_LOGIN_SUCCESFUL";
            echo json_encode(['status' => 'success', 'user_type' => 'admin']);
            header('Location: ../../admin/index.php');
            exit;
        }

        // Check if the user is a staff
        $stmt = $pdo->prepare("SELECT * FROM staff_accounts WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($staff && password_verify($password, $staff['password'])) {
            // Set session variables for staff
            $_SESSION['user_id'] = $staff['id'];
            $_SESSION['teacher_id'] = $staff['id'];
            $_SESSION['teacher_name'] = $staff['fullName'];
            $_SESSION['email'] = $staff['email'];
            $_SESSION['user_type'] = 'staff';
            $_SESSION['name'] = $staff['fullName'];
            $_SESSION['STATUS'] = "TEACHER_LOGIN_SUCCESFUL";
          header('Location: ../../staff/index.php');
            exit;
        }

        // Check if the user is a student
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student && password_verify($password, $student['password'])) {
            // Set session variables for student
            $_SESSION['user_id'] = $student['student_id'];
            $_SESSION['fullName'] = $student['fullName'];
            $_SESSION['name'] = $student['fullName'];
            $_SESSION['student_id'] = $student['student_id'];
            $_SESSION['user_type'] = 'student';
            $_SESSION['course'] = $student['course'];
            $_SESSION['year_level'] = $student['year_level'];
            $_SESSION['STATUS'] = "STUDENT_LOGIN_SUCCESFUL";
            header('Location: ../../students/student_dashboard.php');
            exit;
        }

        // If no match is found, return an error
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
