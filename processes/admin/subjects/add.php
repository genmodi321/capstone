<?php
session_start();
require '../../server/conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subjectName = !empty($_POST['subjectName']) ? htmlspecialchars($_POST['subjectName']) : null;
    $subjectCode = !empty($_POST['subjectCode']) ? htmlspecialchars($_POST['subjectCode']) : null;
    $class = !empty($_POST['class']) ? htmlspecialchars($_POST['class']) : null;
    $teacher = !empty($_POST['teacher']) ? ($_POST['teacher']) : null;
    $semester = !empty($_POST['semester']) ? htmlspecialchars($_POST['semester']) : null;

 
    if ($subjectName && $subjectCode && $class && $teacher && $semester) {
        try {
        
            $sql = "INSERT INTO subjects (name, code, class, teacher, semester) VALUES (:name, :code, :class, :teacher, :semester)";
            $stmt = $pdo->prepare($sql);

      
            $stmt->bindParam(':name', $subjectName);
            $stmt->bindParam(':code', $subjectCode);
            $stmt->bindParam(':class', $class);
            $stmt->bindParam(':teacher', $teacher);
            $stmt->bindParam(':semester', $semester);

    
            if ($stmt->execute()) {
                $_SESSION['STATUS'] = "ADMIN_SUBJECT_ADD_SUCCESS";
                header('Location: ../../../subject_management.php');
            } else {
                $_SESSION['STATUS'] = "ADMIN_SUBJECT_ADD_FAIL";
                header('Location: ../../../subject_management.php');
            }
        } catch (PDOException $e) {
        
            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['STATUS'] = "ADMIN_SUBJECT_ADD_FAIL";
                header('Location: ../../../subject_management.php');
    }
}
?>
