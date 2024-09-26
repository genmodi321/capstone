<?php
session_start();
require_once '../../server/conn.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the entered class code and current student ID from the session
    $classCode = trim($_POST['classCode']);
    $studentId = $_SESSION['student_id'];

    // Check if the class exists with the provided class code
    $stmt = $pdo->prepare("SELECT * FROM classes WHERE classCode = ?");
    $stmt->execute([$classCode]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($class) {
        // Check if the student is already enrolled in the class
        $classId = $class['id'];
        $subjectId = $class['subject']; // Assuming 'subject' stores subject_id

        $stmt = $pdo->prepare("SELECT * FROM students_enrollments WHERE class_id = ? AND student_id = ?");
        $stmt->execute([$classId, $studentId]);
        $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($enrollment) {
            // If the student is already enrolled, display an error message
            $_SESSION['error'] = "You are already enrolled in this class.";
            header("Location: ../../../student_dashboard.php");
            exit();
        } else {
            // Enroll the student in the class
            $stmt = $pdo->prepare("INSERT INTO students_enrollments (class_id, student_id) VALUES (?, ?)");
            if ($stmt->execute([$classId, $studentId])) {

                $stmt = $pdo->prepare("UPDATE classes SET studentTotal = studentTotal + 1 WHERE id = ?");
                $stmt->execute([$classId]);

                // Success, redirect with a success message
                $_SESSION['success'] = "You have successfully joined the class!";
                header("Location: ../../../student_dashboard.php");
                exit();
            } else {
                // If there was a problem with the insertion
                $_SESSION['error'] = "Failed to join the class. Please try again.";
                header("Location: ../../../student_dashboard.php");
                exit();
            }
        }
    } else {
        // If class not found
        $_SESSION['error'] = "Invalid class code. Please check and try again.";
        header("Location: ../../../student_dashboard.php");
        exit();
    }
} else {
    // Redirect if accessed without submitting the form
    header("Location: ../../../student_dashboard.php");
    exit();
}
