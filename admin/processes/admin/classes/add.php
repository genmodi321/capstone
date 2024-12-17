<?php
require '../../../processes/server/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $class = $_POST['class'];
    $subjectName = $_POST['subjectName'];
    $subjectType = $_POST['subjectType'];  // Added this line to fetch the subjectType
    $teacher = $_POST['teacher'];
    $semester = $_POST['semester'];
    $classDesc = $_POST['classDesc'];  
    $status = "accepted";

    // Check for empty fields
    if (empty($class) || empty($subjectName) || empty($subjectType) || empty($teacher) || empty($semester) || empty($classDesc)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    
    // Get the subject code and id for the given subject name
    $sql = "SELECT id AS subject_id, type, code FROM subjects WHERE name = :subjectName";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':subjectName', $subjectName, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $subjectCode = $result['code'];
        $type = $result['type'];
        $subject_id = $result['subject_id'];  // Get subject_id here
    } else {
        echo json_encode(['success' => false, 'message' => 'Subject not found.']);
        exit;
    }

    // Generate a unique class code
    function generateClassCode($length = 6)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $classCode = '';
        for ($i = 0; $i < $length; $i++) {
            $classCode .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $classCode;
    }

    try {
        // Check if the class already exists (with both name and type)
        $checkClassStmt = $pdo->prepare("SELECT * FROM classes WHERE name = :name AND type = :type LIMIT 1");
        $checkClassStmt->bindParam(':name', $class, PDO::PARAM_STR);
        $checkClassStmt->bindParam(':type', $subjectType, PDO::PARAM_STR);
        $checkClassStmt->execute();

        if ($checkClassStmt->rowCount() > 0) {
            // Class already exists
            $_SESSION['STATUS'] = "NEW_CLASS_EXISTS";
            header('Location: ../../../class_management.php');
            exit;
        }

        // Generate a unique class code
        $classCode = generateClassCode();

        // Insert the new class into the classes table
        $stmt = $pdo->prepare("INSERT INTO classes (name, code, type, subject, subject_id, teacher, semester, description, studentTotal, classCode, status) 
                               VALUES (:name, :code, :type, :subject, :subject_id, :teacher, :semester, :classDesc, 0, :classCode, :status)");
        $stmt->bindParam(':name', $class, PDO::PARAM_STR);
        $stmt->bindParam(':code', $subjectCode, PDO::PARAM_STR);
        $stmt->bindParam(':type', $subjectType, PDO::PARAM_STR);  // Insert the subjectType here
        $stmt->bindParam(':subject', $subjectName, PDO::PARAM_STR);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);  // Insert the subject_id here
        $stmt->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_STR);
        $stmt->bindParam(':classDesc', $classDesc, PDO::PARAM_STR);
        $stmt->bindParam(':classCode', $classCode, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['STATUS'] = "ADDED_NEW_CLASS_SUCCESS";
            header('Location: ../../../class_management.php');
        } else {
            $_SESSION['STATUS'] = "ADDED_NEW_CLASS_FAILED";
            header('Location: ../../../class_management.php');
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ADDED_NEW_CLASS_FAILED";
        echo 'Error: ' . $e->getMessage();  // For debugging, log this in production
        header('Location: ../../../class_management.php');
    }
}
