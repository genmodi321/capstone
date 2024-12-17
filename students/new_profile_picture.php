<?php
session_start();
require 'processes/server/conn.php'; // Include your PDO connection setup


// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePicture'])) {
    
    // Get the file info
    $file = $_FILES['profilePicture'];
    $fileName = $_FILES['profilePicture']['name'];
    $fileTmpName = $_FILES['profilePicture']['tmp_name'];
    $fileSize = $_FILES['profilePicture']['size'];
    $fileError = $_FILES['profilePicture']['error'];
    $fileType = $_FILES['profilePicture']['type'];

    // Allowed file extensions
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    
    // Get the file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file type is allowed
    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // Max size: 5MB (5000000 bytes)
                // Generate a unique file name to avoid conflicts
                $newFileName = uniqid('', true) . '.' . $fileExt;
                
                // Upload the file to the desired directory
                $uploadDirectory = '../uploads/profile_pictures/'; // Folder where profile pictures will be saved
                $uploadPath = $uploadDirectory . $newFileName;
                
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Update the profile picture path in the database
                    $userId = $_SESSION['user_id']; // Assuming you're storing user_id in session
                    
                    // Prepare the SQL query to update the profile picture path
                    $stmt = $pdo->prepare("UPDATE student_info SET picture = :profile_picture WHERE student_id = :user_id");
                    $stmt->execute([
                        ':profile_picture' => $newFileName,
                        ':user_id' => $userId
                    ]);

                    // Redirect or notify success
                    $_SESSION['profile_picture'] = $uploadPath; // Update session variable for instant UI update
                    header("Location: student_dashboard.php"); // Change this to your desired page
                    exit();
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "File size is too large. Maximum size is 5MB.";
            }
        } else {
            echo "There was an error uploading your file.";
        }
    } else {
        echo "You cannot upload files of this type. Allowed types are JPG, JPEG, PNG, GIF.";
    }
}
header("Location: student_dashboard.php"); // Change this to your desired page
?>
