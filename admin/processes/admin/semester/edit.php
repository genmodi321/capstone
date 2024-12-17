<?php
require '../../server/conn.php';
session_start(); // Start session for status messages

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];

    // Check for empty fields
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
                $_SESSION['STATUS'] = "SEMESTER_UPDATE_SUCCESS";
            } else {
                $_SESSION['STATUS'] = "SEMESTER_UPDATE_FAILED";
            }
        } catch (PDOException $e) {
            $_SESSION['STATUS'] = "SEMESTER_UPDATE_ERROR";
            $_SESSION['ERROR_MESSAGE'] = $e->getMessage();
        }
    } else {
        $_SESSION['STATUS'] = "SEMESTER_FIELDS_EMPTY";
    }

    // Redirect to semesters.php with session-based SweetAlert
    header("Location: ../../../semester_management.php");
    exit;
} else {
    header("Location: ../../../semester_management.php");
    exit;
}
