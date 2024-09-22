<?php
require '../../../processes/server/conn.php';

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
        $stmt = $pdo->prepare("INSERT INTO classes (name, subject, teacher, semester, description, studentTotal) VALUES (:name, :subject, :teacher, :semester, :classDesc, 0)");
        
        $stmt->bindParam(':name', $class);
        $stmt->bindParam(':subject', $subjectName);
        $stmt->bindParam(':teacher', $teacher);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':classDesc', $classDesc);

        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "ADDED_NEW_CLASS_SUCCESS";
            header('Location: ../../../class_management.php');
        } 
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ADDED_NEW_CLASS_FAILED";
        header('Location: ../../../class_management.php');
    }
}
?>
