<?php
require 'processes/server/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Fetch the subject_id based on the subjectName
        $subject_name = $_POST['subjectName'];
        $subject_query = "SELECT id FROM subjects WHERE name = :subject_name";
        $subject_stmt = $pdo->prepare($subject_query);
        $subject_stmt->bindParam(':subject_name', $subject_name);
        $subject_stmt->execute();

        // Check if the subject exists
        $subject = $subject_stmt->fetch(PDO::FETCH_ASSOC);
        if (!$subject) {
            echo "Error: Subject not found.";
            exit;
        }

        $subject_id = $subject['id'];

        // Generate class code dynamically (example: use class name and a random number)
        $class_name = $_POST['class'];
        $class_code = strtoupper(substr($class_name, 0, 4)) . '-' . rand(1000, 9999);

        // Prepare the SQL statement for insertion
        $sql = "INSERT INTO classes (
                    name, type, subject, subject_id, code, teacher, semester, 
                    studentTotal, description, classCode, requestor, status, 
                    reason, datetime_added, is_archived
                ) VALUES (
                    :name, :type, :subject, :subject_id, :code, :teacher, :semester, 
                    :studentTotal, :description, :classCode, :requestor, :status, 
                    :reason, :datetime_added, :is_archived
                )";

        $stmt = $pdo->prepare($sql);

        // Bind the form data to the statement
        $stmt->bindParam(':name', $_POST['class']);
        $stmt->bindValue(':type', 'Class'); // Assuming "type" is static
        $stmt->bindParam(':subject', $_POST['subjectName']);
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->bindParam(':code', $class_code);
        $stmt->bindParam(':teacher', $_POST['teacher']);
        $stmt->bindParam(':semester', $_POST['semester']);
        $stmt->bindValue(':studentTotal', 0); // Default value
        $stmt->bindParam(':description', $_POST['classDesc']);
        $stmt->bindParam(':classCode', $class_code);
        $stmt->bindParam(':requestor', $_POST['assignedAdviser']); // Logged-in adviser
        $stmt->bindValue(':status', 'Active'); // Default status
        $stmt->bindValue(':reason', null); // Default null
        $stmt->bindValue(':datetime_added', date('Y-m-d H:i:s')); // Current datetime
        $stmt->bindValue(':is_archived', 0); // Default not archived

        // Execute the statement
        $stmt->execute();

        // Success message
        echo "Class successfully added.";
    } catch (PDOException $e) {
        // Error message
        echo "Error: " . $e->getMessage();
    }
}
?>
