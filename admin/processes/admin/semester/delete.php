<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM semester WHERE id = :id");
        
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            header("Location: ../../admin/semesters.php?success=Semester deleted successfully");
            exit;
        } else {
            header("Location: ../../admin/semesters.php?error=Failed to delete semester");
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
