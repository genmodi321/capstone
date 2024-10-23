<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare the update statement
        $stmt = $pdo->prepare("UPDATE semester SET status = 'Inactive' WHERE id = :id");
        
        // Bind parameters
        $stmt->bindParam(':id', $id);
        
        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../../admin/semesters.php?success=Semester made inactive successfully");
            exit;
        } else {
            header("Location: ../../admin/semesters.php?error=Failed to make semester inactive");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: ../../admin/semesters.php?error=" . $e->getMessage());
        exit;
    }
} else {
    header("Location: ../../admin/semesters.php");
    exit;
}
?>
