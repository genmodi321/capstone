<?php
session_start();
require '../../../processes/server/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get the form data
        $student_id = $_POST['student_id'];
        $class_id = $_GET['class_id'];

        // Validate input
        if (empty($student_id) || empty($class_id)) {
            throw new Exception("Missing required parameters.");
        }

        // Check if the student is already enrolled in the class
        $checkEnrollmentStmt = $pdo->prepare("
            SELECT 1 
            FROM students_enrollments 
            WHERE student_id = :student_id AND class_id = :class_id
        ");
        $checkEnrollmentStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $checkEnrollmentStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $checkEnrollmentStmt->execute();

        if ($checkEnrollmentStmt->rowCount() > 0) {
            $_SESSION['STATUS'] = "STUDENT_ALREADY_ENROLLED";
            echo "Error: Student is already enrolled in this class.";
            exit;
        }

        // Insert the enrollment record into `students_enrollments`
        $enrollStmt = $pdo->prepare("
            INSERT INTO students_enrollments (student_id, class_id) 
            VALUES (:student_id, :class_id)
        ");
        $enrollStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $enrollStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $enrollStmt->execute();

        // Insert the initial grades record into `student_grades`
        $gradesStmt = $pdo->prepare("
            INSERT INTO student_grades (student_id, class_id) 
            VALUES (:student_id, :class_id)
        ");
        $gradesStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $gradesStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $gradesStmt->execute();

        // Enroll the student into activities by inserting into `activity_submissions`
        $getActivityStmt = $pdo->prepare("SELECT id FROM activities");
        $getActivityStmt->execute();
        $activityIds = $getActivityStmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($activityIds)) {
            $insertActivityStmt = $pdo->prepare("
                INSERT INTO activity_submissions (student_id, activity_id)
                VALUES (:student_id, :activity_id)
            ");

            foreach ($activityIds as $activityId) {
                $insertActivityStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                $insertActivityStmt->bindParam(':activity_id', $activityId, PDO::PARAM_INT);
                $insertActivityStmt->execute();
            }
        }

           // Fetch all meeting IDs from `classes_meetings` for the class
           $getMeetingsStmt = $pdo->prepare("
           SELECT id AS meeting_id 
           FROM classes_meetings 
           WHERE class_id = :class_id
       ");
       $getMeetingsStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
       $getMeetingsStmt->execute();
       $meetingIds = $getMeetingsStmt->fetchAll(PDO::FETCH_COLUMN);

       if (!empty($meetingIds)) {
           // Prepare the query to insert attendance records
           $insertAttendanceStmt = $pdo->prepare("
               INSERT INTO attendance (student_id, class_id, meeting_id, status, timestamp, date)
               VALUES (:student_id, :class_id, :meeting_id, 'absent', NOW(), CURDATE())
           ");

           // Loop through all meeting IDs and insert attendance records
           foreach ($meetingIds as $meeting_id) {
               $insertAttendanceStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
               $insertAttendanceStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
               $insertAttendanceStmt->bindParam(':meeting_id', $meeting_id, PDO::PARAM_INT);
               $insertAttendanceStmt->execute();
           }
       }

        // Success
        $_SESSION['STATUS'] = "STUDENT_ENROLL_SUCCESSFUL";
        echo "Student enrolled successfully!";
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['STATUS'] = "DATABASE_ERROR";
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        // Handle general errors
        $_SESSION['STATUS'] = "ENROLL_ERROR";
        echo "Error: " . $e->getMessage();
    }
}

// Redirect back to the referring page
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
