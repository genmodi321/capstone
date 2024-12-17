<?php
require '../../../processes/server/conn.php'; // Include the database connection

// Check if form data is posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $class = $_POST['class'];
    $subjectName = $_POST['subjectName'];
    $teacher = $_POST['teacher'];
    $semester = $_POST['semester'];
    $classDesc = $_POST['classDesc'];
    
    // Validate form data
    if (empty($class) || empty($subjectName) || empty($teacher) || empty($semester) || empty($classDesc)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    try {
        // Prepare SQL statement to insert data into the classes table
        $stmt = $pdo->prepare("INSERT INTO classes (name, subject, teacher, semester, description, studentTotal) VALUES (:name, :subject, :teacher, :semester, :classDesc, 0)");
        
        // Bind parameters
        $stmt->bindParam(':name', $class);
        $stmt->bindParam(':subject', $subjectName);
        $stmt->bindParam(':teacher', $teacher);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':classDesc', $classDesc);
        
        // Execute statement
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
