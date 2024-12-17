<?php
include('processes/server/conn.php');

// Function to calculate attendance score
function calculateAttendance($class_id, $student_id, $pdo)
{
    try {
        $stmt = $pdo->prepare("
            SELECT cm.id AS meeting_id, 
                   COUNT(a.id) AS total_attendance, 
                   SUM(CASE WHEN a.status = 'present' THEN 1 
                            WHEN a.status = 'late' THEN 0.5 ELSE 0 END) AS total_score
            FROM classes_meetings cm
            LEFT JOIN attendance a 
            ON cm.id = a.meeting_id 
            AND a.class_id = :class_id1 
            AND a.student_id = :student_id
            WHERE cm.class_id = :class_id2
            GROUP BY cm.id
        ");
        $stmt->bindParam(':class_id1', $class_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':class_id2', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalMeetings = count($results);
        $totalScore = 0;

        // Display attendance details
        foreach ($results as $row) {
            $totalScore += $row['total_score'];
        }

        $attendancePercentage = $totalMeetings > 0 ? ($totalScore / $totalMeetings) * 100 : 0;

        return $attendancePercentage;  // Returning the percentage
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        return 0;
    }
}

// Get the class_id from the URL parameter
$class_id = isset($_GET['class_id']) ? (int) $_GET['class_id'] : null;

if ($class_id) {
    try {
        // Fetch class details and types
        $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = :class_id");
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $class = $stmt->fetch();

        if ($class) {
            $subject = $class['subject'];

            // Fetch all types for the same subject
            $stmt2 = $pdo->prepare("SELECT DISTINCT type, id FROM classes WHERE subject = :subject");
            $stmt2->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt2->execute();
            $types = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            // Initialize variables to track if the subject has lecture or laboratory
            $hasLecture = false;
            $hasLaboratory = false;

            // Determine if the subject has lecture or laboratory
            foreach ($types as $typeRow) {
                if (strcasecmp($typeRow['type'], 'lecture') == 0) {
                    $hasLecture = true;
                }
                if (strcasecmp($typeRow['type'], 'laboratory') == 0) {
                    $hasLaboratory = true;
                }
            }

            // Determine weights based on whether the subject has lecture and/or laboratory
            $lectureWeight = $hasLaboratory ? 60 : 60;
            $labWeight = $hasLaboratory ? 40 : 40;

            // Function to calculate grades for a term
           // Function to calculate grades for a term, now considering max_points
function calculateTermGrades($class_id, $term, $lectureWeight, $labWeight, $pdo, $hasLecture, $hasLaboratory)
{
    // Fetch activities and grades, including max_points
    $stmt = $pdo->prepare("
        SELECT a.id AS activity_id, a.type, a.max_points, s.student_id, s.score
        FROM activities a
        LEFT JOIN activity_submissions s ON a.id = s.activity_id
        WHERE a.class_id = :class_id AND a.term = :term
    ");
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->bindParam(':term', $term, PDO::PARAM_STR);
    $stmt->execute();
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grades = [];
    foreach ($activities as $activity) {
        $student_id = $activity['student_id'];
        $type = $activity['type'];
        $score = $activity['score'] ?? 0;
        $max_points = $activity['max_points'];  // Default to 100 if max_points is null

        // Ensure grades array is initialized for each student
        if (!isset($grades[$student_id])) {
            $grades[$student_id] = [
                'lecture' => [
                    'exam' => [],
                    'quiz' => [],
                    'activity' => [],
                ],
                'laboratory' => [
                    'exam' => [],
                    'exercise' => [],
                    'activity' => [],
                ]
            ];
        }

        // Normalize the score by dividing by max_points to get percentage score
        $percentageScore = $score / $max_points * 100;

        // Categorize scores by type (lecture or laboratory)
        if (strcasecmp($type, 'exam') == 0) {
            $grades[$student_id]['lecture']['exam'][] = $percentageScore;
        } elseif (strcasecmp($type, 'quiz') == 0) {
            $grades[$student_id]['lecture']['quiz'][] = $percentageScore;
        } elseif (strcasecmp($type, 'activity') == 0) {
            $grades[$student_id]['lecture']['activity'][] = $percentageScore;
        }
    }

    $termGrades = [];
    foreach ($grades as $student_id => $studentScores) {
        // Calculate lecture score averages using percentage scores
        $lectureExamAvg = !empty($studentScores['lecture']['exam']) ? array_sum($studentScores['lecture']['exam']) / count($studentScores['lecture']['exam']) : 0;
        $lectureQuizAvg = !empty($studentScores['lecture']['quiz']) ? array_sum($studentScores['lecture']['quiz']) / count($studentScores['lecture']['quiz']) : 0;
        $lectureActivityAvg = !empty($studentScores['lecture']['activity']) ? array_sum($studentScores['lecture']['activity']) / count($studentScores['lecture']['activity']) : 0;

        // Attendance score (from previous function)
        $attendancePercentage = calculateAttendance($class_id, $student_id, $pdo);
        $attendanceScore = ($attendancePercentage / 100) * 30;  // 30% weight for attendance in lecture

        // Calculate the final lecture grade considering weighted components
        $lectureGrade = ($lectureExamAvg * 0.4) + ($lectureQuizAvg * 0.3) + ($lectureActivityAvg * 0.3) + $attendanceScore;

        // Add calculated grade to term grades
        $termGrades[$student_id] = [
            'percentage' => round($lectureGrade, 2),
            'numerical_rating' => convertToNumericalRating($lectureGrade),
        ];
    }

    return $termGrades;
}


            // Function to convert percentage to numerical rating
            function convertToNumericalRating($percentage)
            {
                if ($percentage >= 99)
                    return 1.0;
                if ($percentage >= 95)
                    return 1.25;
                if ($percentage >= 90)
                    return 1.5;
                if ($percentage >= 85)
                    return 1.75;
                if ($percentage >= 80)
                    return 2.0;
                if ($percentage >= 75)
                    return 2.25;
                if ($percentage >= 70)
                    return 2.5;
                if ($percentage >= 65)
                    return 2.75;
                if ($percentage >= 60)
                    return 3.0;
                return 5.0;
            }

            // Calculate Midterm and Final Grades
            $midtermGrades = calculateTermGrades($class_id, 'midterm', $lectureWeight, $labWeight, $pdo, $hasLecture, $hasLaboratory);
            $finalGrades = calculateTermGrades($class_id, 'final', $lectureWeight, $labWeight, $pdo, $hasLecture, $hasLaboratory);

            // Combine Midterm and Final Grades
            $overallGrades = [];
            foreach ($midtermGrades as $student_id => $midtermGrade) {
                $finalGrade = $finalGrades[$student_id] ?? 0;
                $overallPercentage = round(($midtermGrade['percentage'] * 0.4) + ($finalGrade['percentage'] * 0.6), 2);
                $overallRating = convertToNumericalRating($overallPercentage);

                $overallGrades[$student_id] = [
                    'percentage' => $overallPercentage,
                    'numerical_rating' => $overallRating
                ];
            }

            // Display Grades
            echo "<h3>Grades</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Student ID</th><th>Midterm Percentage</th><th>Midterm Rating</th><th>Final Percentage</th><th>Final Rating</th><th>Overall Percentage</th><th>Overall Rating</th></tr>";
            foreach ($overallGrades as $student_id => $overallGrade) {
                $midtermGrade = $midtermGrades[$student_id];
                $finalGrade = $finalGrades[$student_id];
                echo "<tr><td>{$student_id}</td>
                        <td>{$midtermGrade['percentage']}</td><td>{$midtermGrade['numerical_rating']}</td>
                        <td>{$finalGrade['percentage']}</td><td>{$finalGrade['numerical_rating']}</td>
                        <td>{$overallGrade['percentage']}</td><td>{$overallGrade['numerical_rating']}</td></tr>";
            }
            echo "</table>";

        } else {
            echo "<p class='error'>Class not found.</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p class='error'>No class selected.</p>";
}
?>
