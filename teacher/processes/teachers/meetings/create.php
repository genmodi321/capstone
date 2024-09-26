<?php
session_start();
require_once '../../server/conn.php';
$selectedDate = $_GET['date'];

if (isset($_GET['class_id'])) {
    $classId = $_GET['class_id'];

    try {
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM classes_meetings WHERE class_id = :class_id AND date = :date");
        $checkStmt->bindParam(':class_id', $classId);
        $checkStmt->bindParam(':date', $selectedDate);
        $checkStmt->execute();

        $exists = $checkStmt->fetchColumn();

        if ($exists > 0) {
            $_SESSION['STATUS'] = "DATE_ALREADY_EXISTS";
            header("Location: ../../../teacher_class_attendance.php?id=$classId&date=$selectedDate");
            exit();
        } else {
            $stmt = $pdo->prepare("SELECT student_id FROM students_enrollments WHERE class_id = :class_id");
            $stmt->bindParam(':class_id', $classId);
            $stmt->execute();
            $studentIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $insertStmt = $pdo->prepare("INSERT INTO classes_meetings (class_id, date, student_id, attendance) VALUES (:class_id, :date, :student_id, 'absent')");
            foreach ($studentIds as $studentId) {
                $insertStmt->bindParam(':class_id', $classId);
                $insertStmt->bindParam(':date', $selectedDate);
                $insertStmt->bindParam(':student_id', $studentId);
                $insertStmt->execute();
            }
            $_SESSION['STATUS'] = "NEW_DATE_ADDED";
            header("Location: ../../../teacher_class_attendance.php?id=$classId&date=$selectedDate");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Class ID not found in session.";
}
