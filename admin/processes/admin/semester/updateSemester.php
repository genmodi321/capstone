<?php
session_start();

// Include the database connection file
require '../../server/conn.php'; // Ensure this file includes PDO connection

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;  // Cast to integer
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Validate the inputs (you can add more validation based on your needs)
    if (empty($name) || empty($start_date) || empty($end_date)) {
        // Return an error if required fields are empty
        echo json_encode(['success' => false, 'message' => 'All fields are required!']);
        exit();
    }

    try {
        // Prepare SQL to update semester using directly embedded variables in the query
        $sql = "UPDATE semester 
                SET name = '$name', start_date = '$start_date', end_date = '$end_date', description = '$description', updated_at = NOW()
                WHERE id = $id";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Execute the statement
        if ($stmt->execute()) {
            // If the update is successful
            echo json_encode(['success' => true, 'message' => 'Semester updated successfully!']);
            $_SESSION['STATUS'] = "SEMESTER_UPDATE_SUCCESS";
        } else {
                $_SESSION['STATUS'] =  "SEMESTER_UPDATE_FAILED";
         
            echo json_encode(['success' => false, 'message' => 'An error occurred while updating the semester.']);
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] =  "SEMESTER_UPDATE_ERROR";
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        $_SESSION['ERROR_MESSAGE'] = $e->getMessage();
    }
} else {
    $_SESSION['STATUS'] =  "SEMESTER_UPDATE_FAILED";
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
header('Location: ../../../semester_management.php')
?>