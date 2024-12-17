<?php
session_start();
require 'processes/server/conn.php'; // Include your PDO connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentPhone = $_POST['studentPhone'];
    $courseYear = $_POST['courseYear'];
    $studentAddress = $_POST['studentAddress'];
    $emergencyContact = $_POST['emergencyContact'];
    $studentGender = $_POST['studentGender'];

    // Check if student already exists in the database
    $checkSql = "SELECT COUNT(*) FROM student_info WHERE student_id = :studentId";
    
    try {
        $stmt = $pdo->prepare($checkSql);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // If student exists, update the record
            $sql = "UPDATE student_info SET
                        full_name = :studentName,
                        email = :studentEmail,
                        phone_number = :studentPhone,
                        course_year = :courseYear,
                        address = :studentAddress,
                        emergency_contact = :emergencyContact,
                        gender = :studentGender
                    WHERE student_id = :studentId"; // Use student_id to identify the record

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':studentId', $studentId);
            $stmt->bindParam(':studentName', $studentName);
            $stmt->bindParam(':studentEmail', $studentEmail);
            $stmt->bindParam(':studentPhone', $studentPhone);
            $stmt->bindParam(':courseYear', $courseYear);
            $stmt->bindParam(':studentAddress', $studentAddress);
            $stmt->bindParam(':emergencyContact', $emergencyContact);
            $stmt->bindParam(':studentGender', $studentGender);

            // Execute the update statement
            $stmt->execute();
            echo "Profile updated successfully.";
        } else {
            // If student does not exist, insert a new record
            $insertSql = "INSERT INTO student_info (student_id, full_name, email, phone_number, course_year, address, emergency_contact, gender)
                          VALUES (:studentId, :studentName, :studentEmail, :studentPhone, :courseYear, :studentAddress, :emergencyContact, :studentGender)";

            $stmt = $pdo->prepare($insertSql);
            $stmt->bindParam(':studentId', $studentId);
            $stmt->bindParam(':studentName', $studentName);
            $stmt->bindParam(':studentEmail', $studentEmail);
            $stmt->bindParam(':studentPhone', $studentPhone);
            $stmt->bindParam(':courseYear', $courseYear);
            $stmt->bindParam(':studentAddress', $studentAddress);
            $stmt->bindParam(':emergencyContact', $emergencyContact);
            $stmt->bindParam(':studentGender', $studentGender);

            // Execute the insert statement
            $stmt->execute();
            echo "Profile created successfully.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
header("Location: student_dashboard.php"); // Change this to your desired page
?>
