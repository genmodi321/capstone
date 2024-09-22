<?php

session_start();
date_default_timezone_set('Asia/Manila');
include('../../server/conn.php');

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data and sanitize it
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $level = htmlspecialchars($_POST['status']);    
        $due_date = $_POST['due_date'];
        $due_time = $_POST['due_time'];

        // Prepare an SQL statement to insert the data
        $sql = "INSERT INTO admin_reminders (title, description, level, due_date, due_time, datetime_created) 
                VALUES (:title, :description, :level, :due_date, :due_time, NOW())";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters to the statement
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':due_time', $due_time);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Reminder added successfully!";
        } else {
            echo "There was an error adding the reminder.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
