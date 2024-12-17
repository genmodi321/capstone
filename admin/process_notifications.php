<?php
require 'processes/server/conn.php'; // Adjust the path

if ($_POST['action'] === 'set_all_false') {
    $query = "UPDATE admin_notifications SET status = 'false'";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Failed";
    }
}

if ($_POST['action'] === 'set_individual') {
    // Example for managing individual notifications (further logic needed here)
    echo "Manage individual notifications logic here.";
}
?>
