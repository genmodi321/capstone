<?php
session_start();
require_once '../../server/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $dueTime = $_POST['dueTime'];
    $points = $_POST['points'];
    $passingPoints = $_POST['passingPoints'];
    $assessmentType = $_POST['assessment_type'];
    $subject_id = $_GET['id']; 
    $attachment = null; 

    // File upload logic
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileInput']['tmp_name'];
        $fileName = $_FILES['fileInput']['name'];
        $fileSize = $_FILES['fileInput']['size'];
        $fileType = $_FILES['fileInput']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions
        $allowedFileExtensions = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'mp4', 'mpeg');

        // Check if file has a valid extension
        if (in_array($fileExtension, $allowedFileExtensions)) {
            // Specify upload directory
            $uploadFileDir = '../../../../uploads/files/';
            $dest_path = $uploadFileDir . $subject_id . "_" . $fileName;

            // Move uploaded file to the destination directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $attachment = $subject_id . "_" . $fileName;
            } else {
                $_SESSION['STATUS'] = "ASSESSMENT_FILE_PATHING_ERROR";
                header("Location: ../../../teacher_subject_management_activity.php?id=$subject_id");
                exit; // End script execution after redirection
            }
        } else {
            $_SESSION['STATUS'] = "ASSESSMENT_FILE_HANDLING_ERROR";
            header("Location: ../../../teacher_subject_management_activity.php?id=$subject_id");
            exit; // End script execution after redirection
        }
    }

    // Insert the assessment data into the database
    try {
        $sql = "INSERT INTO assessments (subject_id, type, name, max_points, passing_points, description, attachment, due_date, due_time)
                VALUES (:subject_id, :type, :name, :max_points, :passing_points, :description, :attachment, :due_date, :due_time)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $assessmentType, PDO::PARAM_STR);
        $stmt->bindParam(':name', $title, PDO::PARAM_STR);
        $stmt->bindParam(':max_points', $points, PDO::PARAM_INT);
        $stmt->bindParam(':passing_points', $passingPoints, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':attachment', $attachment, PDO::PARAM_STR);
        $stmt->bindParam(':due_date', $dueDate, PDO::PARAM_STR);
        $stmt->bindParam(':due_time', $dueTime, PDO::PARAM_STR);

        $stmt->execute();

        $_SESSION['STATUS'] = "ASSESSMENT_ADD_SUCCESS";
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = "ASSESSMENT_ADD_ERROR";
    }

    // Redirect after operation
    header("Location: ../../../teacher_subject_management.php?id=$subject_id");
    exit; // End script execution after redirection
}
?>
