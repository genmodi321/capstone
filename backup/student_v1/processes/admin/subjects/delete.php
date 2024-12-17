<?php
session_start();
require '../../server/conn.php';

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    // Get the subject ID from the query parameter
    $id = intval($_GET['id']);

    // Prepare the delete statement
    $sql = "DELETE FROM subjects WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Bind the 'id' parameter
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['STATUS'] = "ADMIN_SUBJECT_DELETE_SUCCESS";
        header('Location: ../../../subject_management.php');
        exit();
    } else {
        $_SESSION['STATUS'] = "ADMIN_SUBJECT_DELETE_ERROR";
        header('Location: ../../../subject_management.php');
        exit();
    }
} else {
    // If 'id' is not set, redirect to the subjects list
    header('Location: subjects_list.php');
    exit();
}
