<?php
require '../../server/conn.php'; // Ensure this points to your database connection file

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = $_POST['title'];
        $type = $_POST['type'];
        $message = $_POST['message'];
        $due_date = $_POST['due_date'];
        $due_time = $_POST['due_time'];
        $min_points = $_POST['min_points'];
        $max_points = $_POST['max_points'];
        $class_id = $_POST['class_id']; // Ensure this is passed in the form
        $subject_id = $_POST['subject_id']; // Ensure this is passed in the form
        $term = $_POST['term'];

        $due_time_12hr = date("h:iA", strtotime($due_time));
        $current_time = date('Y-m-d H:i:s');

        // Check for duplicate activity
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM activities WHERE title = ? AND class_id = ? AND subject_id = ?");
        $stmt->execute([$title, $class_id, $subject_id]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['STATUS'] = "ACT_ERROR_SAME";
            $referrer = $_SERVER['HTTP_REFERER'] ?? '../../../teacher_dashboard.php';
            header("Location: $referrer");
            exit;
        }

        // Insert activity
        $stmt = $pdo->prepare("INSERT INTO activities (title, type, message, due_date, due_time, min_points, max_points, class_id, subject_id, created_at, updated_at, term) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $type, $message, $due_date, $due_time_12hr, $min_points, $max_points, $class_id, $subject_id, $current_time, $current_time, $term])) {
            $activity_id = $pdo->lastInsertId();

            // Add submissions for each student in the class
            $stmt = $pdo->prepare("SELECT student_id FROM students_enrollments WHERE class_id = ?");
            $stmt->execute([$class_id]);
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($students as $student) {
                $student_id = $student['student_id'];

                $stmt = $pdo->prepare("INSERT INTO activity_submissions (activity_id, student_id, submission_date, score, feedback, status) VALUES (?, ?, NULL, 0, NULL, 'pending')");
                $stmt->execute([$activity_id, $student_id]);
            }

            // Handle file upload if exists
            if (!empty($_FILES['attachment']['tmp_name'])) {
                $file_name = $_FILES['attachment']['name'];
                $file_tmp_path = $_FILES['attachment']['tmp_name'];
                $upload_dir = '../../../../uploads/files/';
                $new_file_name = uniqid() . '-' . $file_name;
                $destination = $upload_dir . $new_file_name;

                if (!is_dir($upload_dir))
                    mkdir($upload_dir, 0755, true);

                if (move_uploaded_file($file_tmp_path, $destination)) {
                    $stmt = $pdo->prepare("INSERT INTO activity_attachments (activity_id, file_name, file_path, uploaded_at) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$activity_id, $file_name, $destination, $current_time]);
                } else {
                    $_SESSION['STATUS'] = "ACT_ATTACHMENT_ERROR";
                    throw new Exception("Failed to upload the attachment.");
                }
            }

            $_SESSION['STATUS'] = "ACT_ADDED_SUCCESS";
            $referrer = $_SERVER['HTTP_REFERER'] ?? '../../../teacher_dashboard.php';
            header("Location: $referrer");
            exit;
        } else {
            throw new Exception("Failed to create activity.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    // Handle invalid request method (GET)
    $_SESSION['STATUS'] = "ACT_ERROR";
    $referrer = $_SERVER['HTTP_REFERER'] ?? '../../../teacher_dashboard.php';
    header("Location: $referrer");
    exit;
}
?>