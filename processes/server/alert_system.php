<?php
require 'processes/server/conn.php'; // Adjust the path based on your directory structure
session_start();
// Get today's date in 'Y-m-d' format
$today = (new DateTime())->format('Y-m-d');

try {
    // Check if 'semester_transition' flag is false
    $flagQuery = "SELECT status FROM admin_auto_notifications WHERE name = 'semester_transition'";
    $flagStmt = $pdo->prepare($flagQuery);
    $flagStmt->execute();
    $flag = $flagStmt->fetch(PDO::FETCH_ASSOC);

    if ($flag && $flag['status'] === 'false') {
        // Fetch current active semester where today's date matches the end_date
        $sql = "SELECT id, name FROM semester WHERE end_date = :today AND status = 'active' LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':today', $today);
        $stmt->execute();
        $currentSemester = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($currentSemester) {
            // Begin a transaction
            $pdo->beginTransaction();

            // Archive the current semester
            $archiveStmt = $pdo->prepare("UPDATE semester SET status = 'archived' WHERE id = :id");
            $archiveStmt->bindParam(':id', $currentSemester['id']);
            $archiveStmt->execute();

            // Archive classes associated with this semester
            $disableClassStmt = $pdo->prepare("UPDATE classes SET status = 'archived' WHERE semester = :semester_name");
            $disableClassStmt->bindParam(':semester_name', $currentSemester['name']);
            $disableClassStmt->execute();

            // Insert end notification
            $type = 'semester';
            $title = 'Semester Has Ended: ' . htmlspecialchars($currentSemester['name']);
            $description = 'The semester "' . htmlspecialchars($currentSemester['name']) . '" has ended.';
            $date = date('Y-m-d H:i:s');
            $link = 'link_to_semester_details.php?id=' . $currentSemester['id'];

            $insertQuery = "INSERT INTO admin_notifications (type, title, description, date, link, icon) VALUES (:type, :title, :description, :date, :link)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->execute(compact('type', 'title', 'description', 'date', 'link'));

            // Update flag to prevent re-processing
            $updateFlagQuery = "UPDATE admin_auto_notifications SET status = 'true' WHERE name = 'semester_transition'";
            $pdo->prepare($updateFlagQuery)->execute();

            // Commit the transaction
            $pdo->commit();

        } else {

        }
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error during transition: " . $e->getMessage();
}

// **2. Process semester_near_ending**
try {
    // Fetch the current status of the 'semester_near_ending' flag
    $flagQuery = "SELECT status FROM admin_auto_notifications WHERE name = 'semester_near_ending'";
    $flagStmt = $pdo->prepare($flagQuery);
    $flagStmt->execute();
    $flag = $flagStmt->fetch(PDO::FETCH_ASSOC);

    if ($flag && strtolower($flag['status']) === 'false') { // Ensure case-insensitive comparison
        $oneWeekLater = (new DateTime())->modify('+7 days');
        $oneWeekLaterStr = $oneWeekLater->format('Y-m-d');
        $currentDateStr = (new DateTime())->format('Y-m-d');

        // Fetch active semesters ending in the next week
        $query = "SELECT * FROM semester WHERE end_date BETWEEN :currentDate AND :oneWeekLater AND status = 'active'";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':currentDate' => $currentDateStr,
            ':oneWeekLater' => $oneWeekLaterStr,
        ]);
        $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($semesters) { // Only insert notifications if semesters exist
            foreach ($semesters as $semester) {

                $type = 'semester';
                $title = 'Semester Ending Soon: ' . htmlspecialchars($semester['name']);
                $endDate = (new DateTime($semester['end_date']))->format('F j, Y'); // Format as "Month day, Year" (e.g., December 20, 2024)
                $description = 'The semester "' . htmlspecialchars($semester['name']) . '" is ending on ' . $endDate . '.';

                $link = 'localhost/capstone/admin/semester_management.php'; // Typecast to prevent injection

                // Insert the notification into the admin_notifications table
                $insertQuery = "INSERT INTO admin_notifications (type, title, description, link) 
                                VALUES (:type, :title, :description, :link)";
                $insertStmt = $pdo->prepare($insertQuery);
                $insertStmt->execute([
                    ':type' => $type,
                    ':title' => $title,
                    ':description' => $description,
                    ':link' => $link,
                ]);
                $_SESSION['STATUS'] = "SEMESTER_NEAR_ENDING_NOTICE";
            }

            // Update flag status to prevent duplicate processing
            $updateFlagQuery = "UPDATE admin_auto_notifications SET status = 'true' WHERE name = 'semester_near_ending'";
            $pdo->prepare($updateFlagQuery)->execute();
        }
    }
} catch (PDOException $e) {
    // Log the error message and prevent exposing sensitive data
    error_log("Error in 'semester_near_ending': " . $e->getMessage());
}


// **3. Process semester_ending_notice**
try {
    $flagQuery = "SELECT status FROM admin_auto_notifications WHERE name = 'semester_ending_notice'";
    $flagStmt = $pdo->prepare($flagQuery);
    $flagStmt->execute();
    $flag = $flagStmt->fetch(PDO::FETCH_ASSOC);

    if ($flag && $flag['status'] === 'false') {
        // Placeholder for future actions for 'semester_ending_notice'

        // Update flag to prevent re-processing
        $updateFlagQuery = "UPDATE admin_auto_notifications SET status = 'true' WHERE name = 'semester_ending_notice'";
        $pdo->prepare($updateFlagQuery)->execute();
        $_SESSION['STATUS'] = "SEMESTER_ENDED_NOTICE";
    }
} catch (PDOException $e) {
    echo "Error processing 'semester_ending_notice': " . $e->getMessage();
}
?>