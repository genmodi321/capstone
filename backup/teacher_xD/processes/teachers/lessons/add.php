<?php 
session_start();
require_once '../../server/conn.php'; // Ensure correct path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $subject_id = $_GET['id']; // Assuming the subject_id is passed as a GET parameter
    $title = $_POST['title'];
    $uploadDate = date('Y-m-d'); // Get the current date
    $fileType = null;
    $fileName = null;

    // Debug: Check if subject_id is being received correctly
    if (!$subject_id) {
        echo "Error: Subject ID is missing.";
        exit();
    }

    // Check if a file was uploaded
    if (isset($_FILES['resourceFile']) && $_FILES['resourceFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['resourceFile']['tmp_name'];
        $fileName = $_FILES['resourceFile']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps)); // Extract the file extension as the type

        // Define allowed file extensions
        $allowedFileExtensions = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'mp4');

        if (in_array($fileExtension, $allowedFileExtensions)) {
            // Generate unique file name to prevent collisions
            $newFileName = 'subject_' . $subject_id . '_' . time() . '.' . $fileExtension;

            // Set the upload directory
            $uploadFileDir = '../../../../uploads/files/';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the uploaded file to the server directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $fileType = $fileExtension; // Set the file type based on the extension
                $fileName = $newFileName; // Store the new file name
            } else {
                $_SESSION['STATUS'] = 'FILE_UPLOAD_ERROR';
                echo "File upload error.";
                exit();
            }
        } else {
            $_SESSION['STATUS'] = 'INVALID_FILE_TYPE';
            echo "Invalid file type.";
            exit();
        }
    } else {
        $_SESSION['STATUS'] = 'NO_FILE_UPLOADED';
        echo "No file uploaded.";
        exit();
    }

    // Insert the uploaded resource data into the database
    try {
        $sql = "INSERT INTO lectures (subject_id, title, type, file, date) 
                VALUES (:subject_id, :title, :type, :file, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':type', $fileType, PDO::PARAM_STR);
        $stmt->bindParam(':file', $fileName, PDO::PARAM_STR);
        $stmt->bindParam(':date', $uploadDate, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $_SESSION['STATUS'] = 'RESOURCE_UPLOAD_SUCCESS';
            header('Location: ../your_success_page.php');
            exit();
        } else {
            throw new Exception("Database insertion failed.");
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = 'DATABASE_ERROR';
        echo "Database Error: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>
