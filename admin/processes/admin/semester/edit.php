<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];

    if (!empty($name) && !empty($start_date) && !empty($end_date) && !empty($description)) {
        try {
            // Prepare the update statement
            $stmt = $pdo->prepare("UPDATE semester SET name = :name, start_date = :start_date, end_date = :end_date, description = :description WHERE id = :id");
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $id);
            
            // Execute the statement
            if ($stmt->execute()) {
                header("Location: ../../admin/semesters.php?success=Semester updated successfully");
                exit;
            } else {
                header("Location: ../../admin/semesters.php?error=Failed to update semester");
                exit;
            }
        } catch (PDOException $e) {
            header("Location: ../../admin/semesters.php?error=" . $e->getMessage());
            exit;
        }
    } else {
        header("Location: ../../admin/semesters.php?error=All fields are required");
        exit;
    }
} else {
    header("Location: ../../admin/semesters.php");
    exit;
}
?>
