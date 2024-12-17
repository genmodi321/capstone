<?php
session_start();
require_once '../../server/conn.php'; // Ensure correct path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $resourceTitle = filter_input(INPUT_POST, 'resource_title', FILTER_SANITIZE_STRING);
    $resourceDescription = filter_input(INPUT_POST, 'resource_description', FILTER_SANITIZE_STRING);
    $resourceType = filter_input(INPUT_POST, 'resource_type', FILTER_SANITIZE_STRING);
    
    // File upload configuration
    $uploadDir = '../../../uploads/'; // Ensure this directory exists and is writable
    $file = $_FILES['resource_file'];
    $fileName = basename($file['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Allowed file types
    $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'mp4', 'mp3'];
    
    if (in_array($fileType, $allowedTypes)) {
        // Move uploaded file to the server directory
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            try {
                // Insert data into the database
                $stmt = $pdo->prepare(
                    "INSERT INTO learning_resources (class_id, subject_id, resource_name, resource_type, resource_description, resource_url)
                    VALUES (:class_id, :subject_id, :resource_name, :resource_type, :resource_description, :resource_url)"
                );
                $stmt->execute([
                    ':class_id' => $_GET['class_id'], // Pass class_id from form or session
                    ':subject_id' => $_GET['subject_id'], // Pass subject_id from form or session
                    ':resource_name' => $resourceTitle,
                    ':resource_type' => $resourceType,
                    ':resource_description' => $resourceDescription,
                    ':resource_url' => $fileName,

                    
                ]);
                
                echo "Resource uploaded successfully!";
            } catch (PDOException $e) {
                echo "Failed to upload resource: " . $e->getMessage();
            }
        } else {
            echo "Failed to upload the file. Please try again.";
        }
    } else {
        echo "Invalid file type. Only " . implode(', ', $allowedTypes) . " files are allowed.";
    }
}
?>
