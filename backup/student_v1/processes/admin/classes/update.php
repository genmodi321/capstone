<?php
require '../../server/conn.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $class = $_POST['class'];
    $subjectName = $_POST['subjectName'];
    $teacher = $_POST['teacher'];
    $semester = $_POST['semester'];
    $classDesc = $_POST['classDesc'];

    echo $teacher;

    // Validate data (basic example, adjust as needed)
    if (empty($id) || empty($class) || empty($subjectName) || empty($teacher) || empty($semester)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare and execute the update query
    try {
        $stmt = $pdo->prepare("UPDATE classes SET name = :class, subject = :subjectName, teacher = :teacher, semester = :semester, description = :description WHERE id = :id");
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt->bindParam(':subjectName', $subjectName, PDO::PARAM_STR);
        $stmt->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_STR);
        $stmt->bindParam(':description', $classDesc, PDO::PARAM_STR);

        $stmt->execute();

        // Redirect or display a success message
        $_SESSION['STATUS'] = "EDIT_CLASS_SUCCESS";
        header('Location: ../../../class_management.php');
        exit;

    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "EDIT_CLASS_ERROR";
        header('Location: ../../../class_management.php');
    }
}
?>
