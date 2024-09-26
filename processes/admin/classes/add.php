<?php
require '../../../processes/server/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = $_POST['class'];
    $subjectName = $_POST['subjectName'];
    $teacher = $_POST['teacher'];
    $semester = $_POST['semester'];
    $classDesc = $_POST['classDesc'];

    if (empty($class) || empty($subjectName) || empty($teacher) || empty($semester) || empty($classDesc)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    try {
        $checkClassStmt = $pdo->prepare("SELECT * FROM classes WHERE name = :name LIMIT 1");
        $checkClassStmt->bindParam(':name', $class);
        $checkClassStmt->execute();

        if ($checkClassStmt->rowCount() > 0) {
            // Class already exists
            $_SESSION['STATUS'] = "NEW_CLASS_EXISTS";
            header('Location: ../../../class_management.php');
            exit;
        }

        $classCode = generateClassCode();

        $stmt = $pdo->prepare("INSERT INTO classes (name, subject, teacher, semester, description, studentTotal, classCode) 
                               VALUES (:name, :subject, :teacher, :semester, :classDesc, 0, :classCode)");

        $stmt->bindParam(':name', $class);
        $stmt->bindParam(':subject', $subjectName);
        $stmt->bindParam(':teacher', $teacher);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':classDesc', $classDesc);
        $stmt->bindParam(':classCode', $classCode);

        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "ADDED_NEW_CLASS_SUCCESS";
            header('Location: ../../../class_management.php');
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ADDED_NEW_CLASS_FAILED";
        header('Location: ../../../class_management.php');
    }
}

function generateClassCode($length = 6)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $classCode = '';
    for ($i = 0; $i < $length; $i++) {
        $classCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $classCode;
}
