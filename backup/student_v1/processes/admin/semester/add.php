<?php

session_start();
date_default_timezone_set('Asia/Manila');
include('../../server/conn.php');


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data and sanitize it
        $name = htmlspecialchars($_POST['semName']);
        $start_date = htmlspecialchars($_POST['semStartDate']);
        $end_date = htmlspecialchars($_POST['semEndDate']);
        $description = htmlspecialchars($_POST['semDesc']);

        // Prepare an SQL statement to insert the data
        $sql = "INSERT INTO semester (name, start_date, end_date, description) 
                VALUES (:name, :start_date, :end_date, :description)";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters to the statement
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':description', $description);

        // Execute the statement
        if ($stmt->execute()) {
            echo "add";
            $_SESSION['STATUS'] = "ADD_SEMESTER_SUCCESFUL";
            header('Location: ../../../semester_management.php');
        } else {
            echo "fail";
            $_SESSION['STATUS'] = "ADD_SEMESTER_FAIL";
            header('Location: ../../../semester_management.php');
        }
    }

