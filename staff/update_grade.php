<?php
require_once 'processes/server/conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted data
    $submission_id = isset($_POST['submission_id']) ? $_POST['submission_id'] : null;
    $score = isset($_POST['score']) ? $_POST['score'] : null;
    $comments = isset($_POST['comments']) ? $_POST['comments'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    // Check if all required fields are provided
    if ($submission_id && is_numeric($score)) {
        try {
            // Check if the submission ID exists
            $stmt_check = $pdo->prepare("SELECT id FROM activity_submissions WHERE id = :submission_id");
            $stmt_check->execute(['submission_id' => $submission_id]);
            if ($stmt_check->rowCount() > 0) {
                // Update the grade, comments, and status for the specified submission ID
                $stmt = $pdo->prepare("
                    UPDATE activity_submissions
                    SET score = :score, feedback = :feedback, status = :status
                    WHERE id = :submission_id
                ");
                $stmt->execute([
                    'score' => $score,
                    'feedback' => $comments,
                    'status' => $status,
                    'submission_id' => $submission_id
                ]);

                // Redirect back to the referer (previous page)
                $referer = $_SERVER['HTTP_REFERER'] ?? 'grades.php'; // Default to 'grades.php' if no referer
                header("Location: $referer");
                exit();
            } else {
                echo "Submission ID not found.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid data or missing fields.";
    }
}
?>
