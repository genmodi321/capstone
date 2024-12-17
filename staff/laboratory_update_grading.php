<?php
// Include database connection (replace with actual database connection code)
require 'processes/server/conn.php';
// Fetch input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['class_id'], $data['major_exam'], $data['laboratory_exercises'], $data['assignments'], $data['attendance'])) {
    $class_id = $data['class_id'];
    $major_exam = $data['major_exam'];
    $laboratory_exercises = $data['laboratory_exercises'];
    $assignments = $data['assignments'];
    $attendance = $data['attendance'];

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM laboratory_rubrics WHERE class_id = :class_id");
        $stmt->execute([':class_id' => $class_id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $stmt = $pdo->prepare("UPDATE laboratory_rubrics SET 
                                   major_exam = :major_exam, 
                                   laboratory_exercises = :laboratory_exercises, 
                                   assignments = :assignments, 
                                   attendance = :attendance 
                                   WHERE class_id = :class_id");
            $stmt->execute([
                ':major_exam' => $major_exam,
                ':laboratory_exercises' => $laboratory_exercises,
                ':assignments' => $assignments,
                ':attendance' => $attendance,
                ':class_id' => $class_id
            ]);
            echo json_encode(['success' => true, 'message' => 'Grading updated successfully!']);
        } else {
            $stmt = $pdo->prepare("INSERT INTO laboratory_rubrics (class_id, major_exam, laboratory_exercises, assignments, attendance) 
                                   VALUES (:class_id, :major_exam, :laboratory_exercises, :assignments, :attendance)");
            $stmt->execute([
                ':class_id' => $class_id,
                ':major_exam' => $major_exam,
                ':laboratory_exercises' => $laboratory_exercises,
                ':assignments' => $assignments,
                ':attendance' => $attendance
            ]);
            echo json_encode(['success' => true, 'message' => 'Grading rubric created successfully!']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
}

?>
