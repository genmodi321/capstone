<?php
require_once '../../server/conn.php'; // Adjust the path based on your folder structure

session_start(); // Start the session to access session variables
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : null;
$class_id = $_GET['class_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted data
    $activity_id = isset($_POST['activity_id']) ? $_POST['activity_id'] : null;
    $submission_file = isset($_FILES['submission_file']) ? $_FILES['submission_file'] : null;
    $submission_date = date('Y-m-d H:i:s'); // Get today's date and time

    if ($activity_id && $student_id) {
        try {
            // Check if the file was uploaded
            if ($submission_file && $submission_file['error'] === UPLOAD_ERR_OK) {
                // Define the directory to store uploaded files
                $upload_dir = '../../../../uploads/submissions/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
                }

                // Generate a unique filename for the submission
                $original_file_name = basename($submission_file['name']);
                $unique_file_name = uniqid('submission_', true) . '_' . $original_file_name;
                $target_file = $upload_dir . $unique_file_name;

                // Move the uploaded file to the target directory
                if (!move_uploaded_file($submission_file['tmp_name'], $target_file)) {
                    echo "Failed to move the uploaded file.";
                    exit;
                }

                // Set the file path
                $file_path = $unique_file_name;
            } else {
                // If no file was uploaded, set the file path as null
                $file_path = null;
            }

            // Check if a record already exists for this activity and student
            $stmt_check = $pdo->prepare("
                SELECT id FROM activity_submissions
                WHERE activity_id = :activity_id AND student_id = :student_id
            ");
            $stmt_check->execute([
                'activity_id' => $activity_id,
                'student_id' => $student_id
            ]);
            $existing_submission = $stmt_check->fetch();

            if ($existing_submission) {
                // Update the existing submission
                $stmt_update = $pdo->prepare("
                    UPDATE activity_submissions
                    SET submission_date = :submission_date,
                        status = 'submitted',
                        file_path = :file_path
                    WHERE activity_id = :activity_id AND student_id = :student_id
                ");
                $stmt_update->execute([
                    'submission_date' => $submission_date,
                    'file_path' => $file_path, // It can be null here
                    'activity_id' => $activity_id,
                    'student_id' => $student_id
                ]);
            } else {
                // Insert a new submission if no record exists
                $stmt_insert = $pdo->prepare("
                    INSERT INTO activity_submissions (activity_id, student_id, submission_date, status, file_path)
                    VALUES (:activity_id, :student_id, :submission_date, 'submitted', :file_path)
                ");
                $stmt_insert->execute([
                    'activity_id' => $activity_id,
                    'student_id' => $student_id,
                    'submission_date' => $submission_date,
                    'file_path' => $file_path // It can be null here
                ]);
            }

     $_SESSION['STATUS'] = "FILE_SUBMISSION_SUCCESS";

            exit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            $_SESSION['STATUS'] = "FILE_SUBMISSION_ERROR";
        }
    } else {
        echo "Activity ID, student ID, or file missing.";
        $_SESSION['STATUS'] = "FILE_SUBMISSION_ERROR";
    }
} else {
    echo "Invalid request method.";
    $_SESSION['STATUS'] = "FILE_SUBMISSION_ERROR";
}


header("Location: ../../../student_classes.php?class_id=" . $class_id);