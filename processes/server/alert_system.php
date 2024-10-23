<?php require 'processes/server/conn.php'; // Adjust the path based on your directory structure

// Get the current date
$currentDate = new DateTime();
$currentDateStr = $currentDate->format('Y-m-d'); // Format current date
$oneWeekLater = (clone $currentDate)->modify('+7 days');
$oneWeekLaterStr = $oneWeekLater->format('Y-m-d'); // Format one week later

// Query to get semesters that are ending in the next week
$query = "SELECT * FROM semester WHERE end_date BETWEEN :currentDate AND :oneWeekLater";
$stmt = $pdo->prepare($query);

// Bind parameters
$stmt->bindParam(':currentDate', $currentDateStr);
$stmt->bindParam(':oneWeekLater', $oneWeekLaterStr);

// Execute the statement
$stmt->execute();

// Fetch the semesters
$semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Loop through each semester and create notifications
foreach ($semesters as $semester) {
    // Prepare the notification data
    $type = 'semester';
    $title = 'Semester Ending Soon: ' . htmlspecialchars($semester['name']);
    $description = 'The semester "' . htmlspecialchars($semester['name']) . '" is ending on ' . htmlspecialchars($semester['end_date']) . '.';
    $date = date('Y-m-d H:i:s'); // Current date and time
    $link = 'link_to_semester_details.php?id=' . $semester['id']; // Link to the semester details page

    // Choose an icon based on the notification type
    $icon = 'bi bi-exclamation-circle'; // Example icon for "ending soon"

    // Insert the notification into the database
    $insertQuery = "INSERT INTO admin_notifications (type, title, description, date, link, icon) VALUES (:type, :title, :description, :date, :link, :icon)";
    $insertStmt = $pdo->prepare($insertQuery);
    
    // Use variables for binding
    $insertStmt->bindParam(':type', $type);
    $insertStmt->bindParam(':title', $title);
    $insertStmt->bindParam(':description', $description);
    $insertStmt->bindParam(':date', $date);
    $insertStmt->bindParam(':link', $link);
    $insertStmt->bindParam(':icon', $icon); // Bind the icon variable

    // Execute the insertion
    $insertStmt->execute();
}

echo "Notifications have been added for semesters ending soon.";
?>
