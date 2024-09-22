<?php
include('processes/server/conn.php');

$data = json_decode(file_get_contents('php://input'), true);

$class = $data['class'];
$subjects = $data['subjects'];

try {
    $sql = "DELETE FROM class_subjects WHERE class = :class";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['class' => $class]);

    $sql = "INSERT INTO class_subjects (class, subject_id) VALUES (:class, :subject_id)";
    $stmt = $pdo->prepare($sql);

    foreach ($subjects as $subjectId) {
        $stmt->execute(['class' => $class, 'subject_id' => $subjectId]);
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
