<?php
session_start();
require '../../server/conn.php';

// Check if semester ID is passed in URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Begin a transaction to ensure atomicity
        $pdo->beginTransaction();

        // Step 1: Set the selected semester as active
        $sql_update_active = "UPDATE semester SET status = 'active' WHERE id = :id";
        $stmt_active = $pdo->prepare($sql_update_active);
        $stmt_active->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_active->execute();

        // Step 2: Set all other semesters to inactive
        $sql_update_inactive = "UPDATE semester SET status = 'inactive' WHERE id != :id";
        $stmt_inactive = $pdo->prepare($sql_update_inactive);
        $stmt_inactive->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_inactive->execute();

        // Commit the transaction
        $pdo->commit();

        // Redirect back with a success message
        $_SESSION['STATUS'] = "SEMESTER_ACTIVATED";
        header("Location: ../../../semester_management.php");
        exit();
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();

        // Error handling
        $_SESSION['error'] = 'An error occurred while updating the semester: ' . $e->getMessage();
        header("Location: ../../../semester_management.php");
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid semester ID.';
    header("Location: ../../../semester_management.php");
    exit();
}
?>