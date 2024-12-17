<?php
// Connect to the database
require 'processes/server/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate input data
$date = !empty($data['date']) ? htmlspecialchars($data['date']) : null;
$subject = !empty($data['subject']) ? htmlspecialchars($data['subject']) : null;
$startTime = !empty($data['start_time']) ? (new DateTime($data['start_time']))->format('g:i A') : null;
$endTime = !empty($data['end_time']) ? (new DateTime($data['end_time']))->format('g:i A') : null;
$classId = !empty($data['class_id']) ? intval($data['class_id']) : null;
$type = !empty($data['type']) ? htmlspecialchars($data['type']) : "null";

// Check if the provided date is today, and set status accordingly
$today = (new DateTime())->format('Y-m-d');
if ($date === $today) {
    $status = "Ongoing";
} else {
    $status = "Scheduled"; // Default to "Scheduled" if not today
}


    // Ensure all required fields are present
    if ($date && $subject && $startTime && $endTime && $classId && $type) {
        try {
            // Prepare the SQL statement to insert the meeting
            $stmt = $pdo->prepare("INSERT INTO classes_meetings (date, status, start_time, 
            end_time, class_id, type) VALUES (:date, :status, :start_time, :end_time, :class_id, :type)");

            // Bind parameters
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':start_time', $startTime);
            $stmt->bindParam(':end_time', $endTime);
            $stmt->bindParam(':class_id', $classId);
            $stmt->bindParam(':type', $type);

            // Execute the statement
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create class meeting']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
