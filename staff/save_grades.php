<?php
// Include your PDO connection file or database configuration
require 'processes/server/conn.php'; // Ensure this points to your database connection file

if (isset($_GET['class_id']) && isset($_POST['action'])) {
    $class_id = (int) $_GET['class_id']; // Ensure class_id is an integer
    $action = $_POST['action']; // Get action (save, submit, or revert)

    // Process form submission when grades are saved or submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($action === 'save') {
            // Save grades without changing the status
            foreach ($_POST['grades'] as $studentId => $grades) {
                $midtermGrade = $grades['midterm'];
                $finalGrade = $grades['final'];

                try {
                    // Update grades without changing the status
                    $stmt = $pdo->prepare(
                        "UPDATE student_grades 
                         SET midterm_grade = :midterm_grade, final_grade = :final_grade 
                         WHERE student_id = :student_id AND class_id = :class_id"
                    );
                    $stmt->bindParam(':midterm_grade', $midtermGrade);
                    $stmt->bindParam(':final_grade', $finalGrade);
                    $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
                    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                    $stmt->execute();

                } catch (PDOException $e) {
                    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            }
            // Redirect back to the previous page
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=grades_saved");
            exit;
        } elseif ($action === 'submit') {
            // Save grades and change status to 'submitted'
            foreach ($_POST['grades'] as $studentId => $grades) {
                $midtermGrade = $grades['midterm'];
                $finalGrade = $grades['final'];

                try {
                    // Update grades and set status to 'submitted'
                    $stmt = $pdo->prepare(
                        "UPDATE student_grades 
                         SET midterm_grade = :midterm_grade, final_grade = :final_grade, status = 'submitted'
                         WHERE student_id = :student_id AND class_id = :class_id"
                    );
                    $stmt->bindParam(':midterm_grade', $midtermGrade);
                    $stmt->bindParam(':final_grade', $finalGrade);
                    $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
                    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                    $stmt->execute();

                } catch (PDOException $e) {
                    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            }
            // Redirect back to the previous page
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=grades_submitted");
            exit;
        } else {
            // Code to revert grades back to 'for_approval'
            $stmt = $pdo->prepare("UPDATE student_grades SET status = 'for_approval' WHERE class_id = :class_id AND status = 'submitted'");
            $stmt->execute([':class_id' => $class_id]);
            echo "<p class='success'>Grades reverted to 'for approval'.</p>";

            header("Location: " . $_SERVER['HTTP_REFERER']);

            exit;
        }
    }
} else {
    echo "<p class='error'>Invalid request. Please select a valid class and action.</p>";
}
header("Location: " . $_SERVER['HTTP_REFERER']);
?>
