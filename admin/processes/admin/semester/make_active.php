<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $semester_id = $_GET['id'];

    try {
        // Begin transaction to ensure consistency
        $pdo->beginTransaction();

        // Set all other semesters to 'inactive'
        $updateOthersStmt = $pdo->prepare("UPDATE semester SET status = 'inactive' WHERE id != :id");
        $updateOthersStmt->bindParam(':id', $semester_id);
        $updateOthersStmt->execute();

        // Set the selected semester as 'active'
        $setActiveStmt = $pdo->prepare("UPDATE semester SET status = 'active' WHERE id = :id");
        $setActiveStmt->bindParam(':id', $semester_id);
        $setActiveStmt->execute();

        // Commit the transaction
        $pdo->commit();

        // Redirect back to the page or display success message
        header("Location: semesters.php?success=Semester activated successfully");
        exit();
    } catch (PDOException $e) {
        // Rollback transaction if something went wrong
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: semesters.php?error=Invalid request");
    exit();
}
?>
