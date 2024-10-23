<?php
require '../../server/conn.php'; // Adjust the path based on your directory structure

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];

    if (!empty($name) && !empty($start_date) && !empty($end_date) && !empty($description)) {
        try {
            // Check if the start and end dates are the same
            if ($start_date === $end_date) {
                header("Location: ../../admin/semesters.php?error=Start date and end date must not be the same");
                exit;
            }

            // Check if the semester name already exists and is not archived
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM semester WHERE name = :name AND status != 'Archived'");
            $checkStmt->bindParam(':name', $name);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                header("Location: ../../admin/semesters.php?error=Semester name already exists and is not archived");
                exit;
            }

            // Prepare the insert statement
            $stmt = $pdo->prepare("INSERT INTO semester (name, start_date, end_date, description) VALUES (:name, :start_date, :end_date, :description)");
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':description', $description);
            
            // Execute the statement
            if ($stmt->execute()) {
                header("Location: ../../admin/semesters.php?success=Semester created successfully");
                exit;
            } else {
                header("Location: ../../admin/semesters.php?error=Failed to create semester");
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
