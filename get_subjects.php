<?php
include('processes/server/conn.php');
if (isset($_POST['class'])) {
    $selectedClass = $_POST['class'];

    // Database query to get subjects based on class and semester
    $sql = "SELECT * FROM subjects WHERE class = :class";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':class' => $selectedClass,
    ]);

    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any subjects for the selected class and semester
    if (empty($subjects)) {
        echo "<option value='' disabled>No subjects available for this class and semester</option>";
    } else {
        // Loop through the subjects and populate the dropdown
        foreach ($subjects as $subject) {
            echo "<option value='" . htmlspecialchars($subject['id']) . "'>" . htmlspecialchars($subject['name']) . " (" . htmlspecialchars($subject['code']) . ")</option>";
        }
    }
} else {
    echo "<option value='' disabled>Please select a class and semester first</option>";
}
?>
