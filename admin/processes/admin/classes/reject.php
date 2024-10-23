<?php
require '../../../processes/server/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classId = $_GET['id']; // Get the class ID from the form
    $reason = $_POST['reason']; // Get the selected reason from the dropdown

    // If "Other" was selected, use the provided reason from the textarea
    if ($reason === 'Other') {
        $reason = $_POST['other_reason'];
    }

    try {
        // Update the class status to 'disapproved' and store the reason
        $stmt = $pdo->prepare("UPDATE classes SET status = 'disapproved', reason = :reason WHERE id = :id");
        $stmt->execute([':id' => $classId, ':reason' => $reason]);

        // Check if the class was successfully updated
        if ($stmt->rowCount() > 0) {
            $_SESSION['STATUS'] = 'CLASS_STATUS_DISAPPROVED';
        } else {
            $_SESSION['STATUS'] = 'CLASS_STATUS_DISAPPROVE_ERROR';
        }
    } catch (PDOException $e) {
        $_SESSION['STATUS'] = 'CLASS_STATUS_DISAPPROVE_ERROR';
    }

    // Redirect back to the previous page or dashboard
    header('Location: ../../dashboard.php');
    exit();
}
?>
