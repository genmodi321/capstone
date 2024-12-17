<?php
session_start();
include '../../server/conn.php'; // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected semester ID from the form
    $semester = $_POST['semester'];

    if ($semester) {
        try {
            // Start transaction
            $pdo->beginTransaction();

            // Delete the old current semester
            $sqlDelete = "DELETE FROM current_semester";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->execute();

            // Insert the new current semester
            $sqlInsert = "INSERT INTO current_semester (semester) VALUES (:semester)";
            $stmtInsert = $pdo->prepare($sqlInsert);

            // Bind the new semester ID
            $stmtInsert->bindParam(':semester', $semester, PDO::PARAM_INT);

            // Execute the insert query
            $stmtInsert->execute();

            // Commit transaction
            $pdo->commit();

            $_SESSION['STATUS'] = "UPDATE_SEMESTER_SUCCESSFUL";
            header("Location: ../../../dashboard.php");
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $pdo->rollBack();
            $_SESSION['STATUS'] = "UPDATE_SEMESTER_ERROR";
            header("Location: ../../../dashboard.php");
        }
    } else {
        $_SESSION['STATUS'] = "UPDATE_SEMESTER_ERROR";
        header("Location: ../../../dashboard.php");
    }
} else {
    $_SESSION['STATUS'] = "UPDATE_SEMESTER_ERROR";
    header("Location: ../../../dashboard.php");
}
