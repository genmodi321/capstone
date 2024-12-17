<?php
session_start();
require '../../server/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectName = !empty($_POST['subjectName']) ? htmlspecialchars($_POST['subjectName']) : null;
    $subjectCode = !empty($_POST['subjectCode']) ? htmlspecialchars($_POST['subjectCode']) : null;
    $type = !empty($_POST['type']) ? htmlspecialchars($_POST['type']) : null;
    $semester = !empty($_POST['semester']) ? htmlspecialchars($_POST['semester']) : null;
    $course = !empty($_POST['course']) ? htmlspecialchars($_POST['course']) : null;
    $yearLevel = !empty($_POST['year_level']) ? htmlspecialchars($_POST['year_level']) : null;

    // Process meeting days, start time, and end time
    $meetingDays = !empty($_POST['meeting_days']) ? $_POST['meeting_days'] : [];
    $startTime = !empty($_POST['start_time']) ? $_POST['start_time'] : null;
    $endTime = !empty($_POST['end_time']) ? $_POST['end_time'] : null;

    // Ensure meeting days, start time, and end time are valid
    try {
        // Check if the subject already exists
        $checkSubjectStmt = $pdo->prepare("SELECT * FROM subjects WHERE (name = :name OR code = :code) AND type = :type");
        $checkSubjectStmt->bindParam(':name', $subjectName);
        $checkSubjectStmt->bindParam(':code', $subjectCode);
        $checkSubjectStmt->bindParam(':type', $type);
        $checkSubjectStmt->execute();

        if ($checkSubjectStmt->rowCount() > 0) {
            // Subject already exists
            $_SESSION['STATUS'] = "ADMIN_SUBJECT_EXISTS";
            header('Location: ../../../subject_management.php');
            exit;
        }

        // Insert the subject with the new fields for course and year level
        $sql = "INSERT INTO subjects (name, type, code, semester, course, year_level) VALUES (:name, :type, :code, :semester, :course, :year_level)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $subjectName);
        $stmt->bindParam(':code', $subjectCode);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':course', $course); // Bind the course field
        $stmt->bindParam(':year_level', $yearLevel); // Bind the year level field

        if ($stmt->execute()) {
            // Get the last inserted subject ID
            $subjectId = $pdo->lastInsertId();

            // Insert schedules
            foreach ($meetingDays as $day) {
                $insertScheduleSql = "INSERT INTO subjects_schedules (subject_id, meeting_days, start_time, end_time) VALUES (:subject_id, :meeting_days, :start_time, :end_time)";
                $scheduleStmt = $pdo->prepare($insertScheduleSql);
                $scheduleStmt->bindParam(':subject_id', $subjectId);
                $scheduleStmt->bindParam(':meeting_days', $day);
                $scheduleStmt->bindParam(':start_time', $startTime);
                $scheduleStmt->bindParam(':end_time', $endTime);
                $scheduleStmt->execute();
            }

            $_SESSION['STATUS'] = "ADMIN_SUBJECT_ADD_SUCCESS";
            header('Location: ../../../subject_management.php');
        } else {
            $_SESSION['STATUS'] = "ADMIN_SUBJECT_ADD_FAIL";
            header('Location: ../../../subject_management.php');
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['STATUS'] = "ADMIN_SUBJECT_ADD_FAIL";
    header('Location: ../../../subject_management.php');
}
?>
