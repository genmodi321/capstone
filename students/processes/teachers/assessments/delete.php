<?php
session_start();
require_once '../../server/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the assessment ID from the URL
    $assessment_id = $_GET['id'];

    // Fetch the file associated with the assessment
    $sql_get_file = "SELECT attachment FROM assessments WHERE id = :id";
    $stmt_get_file = $pdo->prepare($sql_get_file);
    $stmt_get_file->bindParam(':id', $assessment_id, PDO::PARAM_INT);
    $stmt_get_file->execute();
    $file_to_delete = $stmt_get_file->fetchColumn();

    // Delete the assessment from the database
    $sql_delete = "DELETE FROM assessments WHERE id = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $assessment_id, PDO::PARAM_INT);
    $stmt_delete->execute();

    // Delete the uploaded file from the server
    if ($file_to_delete && file_exists('../../../../uploads/files/' . $file_to_delete)) {
        unlink('../../../../uploads/files/' . $file_to_delete);
    }

    $_SESSION['STATUS'] = "ASSESSMENT_DELETE_SUCCESS";
    header('Location: ../../../teacher_subject_management_activity_dashboard.php?id=' . $_GET['subjectId']);
    exit();
}
