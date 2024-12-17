<?php
require 'processes/server/conn.php';

if (isset($_POST['class'])) {
    $class = $_POST['class'];

    try {
        $stmt = $pdo->prepare("SELECT fullName FROM staff_accounts WHERE class = :class");
        $stmt->execute(['class' => $class]);
        $adviser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($adviser) {
            echo json_encode(['fullName' => $adviser['fullName']]);
        } else {
            echo json_encode(['fullName' => 'No adviser assigned']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error fetching adviser: ' . $e->getMessage()]);
    }
}
