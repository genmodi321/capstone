<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    $_SESSION['STATUS'] = "TEACHER_NOT_LOGGED_IN";
	header("Location: ../login/index.php");
}
include('processes/server/conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WMSU - CCS | Comprehensive Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>


</head>

<style>
    table.dataTable {
        font-size: 12px;
    }

    td {
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid black;
        border: 1px solid black
    }

    .btn-csms {
        background-color: #709775;
        color: white;
    }

    .btn-csms:hover {
        border: 1px solid #709775;
    }

    .grey-bg {
        background-color: grey;
        color: white;
    }

    .small-logo {
        height: 125px;
        width: 125px;
    }
</style>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="d-flex align-items-center">
                    <a href="class_grades.php?class_id=<?php echo $_GET['id'] ?>"
                        class="d-flex align-items-center mb-3">
                        <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-right: 5px;"></i>
                        <p class="m-0">Back</p>
                    </a>
                    <div class="ms-auto" aria-hidden="true">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#gradingModal">
                            Update Grading
                        </button>

                    </div>
                </div>

                <div class="modal fade" id="gradingModal" tabindex="-1" aria-labelledby="gradingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gradingModalLabel">Update Laboratory Grading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Grading Form -->
                <form id="gradingForm">
                    <div class="mb-3">
                        <label for="exam" class="form-label">Exam</label>
                        <input type="number" class="form-control" id="exam" placeholder="Enter percentage" required>
                    </div>
                    <div class="mb-3">
                        <label for="exercises" class="form-label">Exercises</label>
                        <input type="number" class="form-control" id="exercises" placeholder="Enter percentage" required>
                    </div>
                    <div class="mb-3">
                        <label for="assignment" class="form-label">Assignments</label>
                        <input type="number" class="form-control" id="assignment" placeholder="Enter percentage" required>
                    </div>
                    <div class="mb-3">
                        <label for="attendance" class="form-label">Attendance</label>
                        <input type="number" class="form-control" id="attendance" placeholder="Enter percentage" required>
                    </div>
                    <!-- Hidden input to pass class_id, if necessary -->
                    <input type="hidden" id="classId" value="<?php echo $_GET['id']; ?>" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitGrading()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<?php
// Get the class ID from the query string
$classId = $_GET['id'];

// Fetch the rubric data from the database for the specific class
$stmt = $pdo->prepare("SELECT * FROM laboratory_rubrics WHERE class_id = :class_id");
$stmt->execute(['class_id' => $classId]);

// Fetch the rubrics as an associative array
$rubrics = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if rubrics data is found for the given class ID
if ($rubrics) {
    // Retrieve rubric percentages (use default values if not set)
    $examPercentage = isset($rubrics['exam']) ? floatval($rubrics['exam']) : 0;
    $exercisesPercentage = isset($rubrics['exercises']) ? floatval($rubrics['exercises']) : 0;
    $assignmentPercentage = isset($rubrics['assignment']) ? floatval($rubrics['assignment']) : 0;
    $attendancePercentage = isset($rubrics['attendance']) ? floatval($rubrics['attendance']) : 0;

    // Calculate the total percentage (this is optional)
    $totalPercentage = $examPercentage + $exercisesPercentage + $assignmentPercentage + $attendancePercentage;

    // Output (can be used to display or further process the data)
    echo "Exam: $examPercentage%\n";
    echo "Exercises: $exercisesPercentage%\n";
    echo "Assignments: $assignmentPercentage%\n";
    echo "Attendance: $attendancePercentage%\n";
    echo "Total Percentage: $totalPercentage%\n";
} else {
    // Message if no rubric data is found
    echo "No rubrics found for this class.";
}
?>

<!-- HTML Modal and form for grading input -->
<script>
    // Function to submit updated grading to the server
    function submitGrading() {
        // Retrieve user input for the grading percentages
        const exam = document.getElementById("exam").value;
        const exercises = document.getElementById("exercises").value;
        const assignment = document.getElementById("assignment").value;
        const attendance = document.getElementById("attendance").value;
        const classId = document.getElementById("classId").value;

        // Ensure all required fields are filled
        if (exam && exercises && assignment && attendance) {
            // Prepare data for sending through AJAX
            fetch('laboratory_update_grading.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    class_id: classId,
                    exam: exam,
                    exercises: exercises,
                    assignment: assignment,
                    attendance: attendance
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Grading updated successfully!');
                        location.reload(); // Reload the page after updating
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error updating grading:', error);
                    alert('Error updating grading. Try again!');
                });
        } else {
            // Display an error if any fields are missing
            alert('All fields are required.');
        }
    }
</script>



                <div id="printTable">
                    <div id="page-content-wrapper">
                        <div class="card bg-light border-0 shadow-sm"
                            style="background-color: white !important; padding: 5px;">

                            <div class="card-body">
                                <div
                                    class="container text-center d-flex align-items-center justify-content-center my-3">
                                    <div class="row w-100 d-flex align-items-center justify-content-center">
                                        <div class="col-2 d-flex justify-content-center">
                                            <img src="../external/img/wmsu_Logo-removebg-preview.png"
                                                class="img-fluid small-logo">
                                        </div>
                                        <div class="col-8 text-center">
                                            <h5 class="bold mb-1">Western Mindanao State University</h5>
                                            <h5 class="mb-1">College of Computing Studies</h5>
                                            <h5>Zamboanga City</h5>
                                        </div>
                                        <div class="col-2 d-flex justify-content-center">
                                            <img src="../external/img/ccs_logo-removebg-preview.png"
                                                class="img-fluid small-logo">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <?php

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
                                $class_id = isset($_GET['id']) ? (int) $_GET['id'] : null;

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
                                                // Modify the grade calculation logic to account for UW, INC, or AW
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

                                                    // Pass all the required arguments to convertToNumericalRating
                                                    $numericalRating = convertToNumericalRating($lectureGrade, $student_id, $class_id, $pdo);

                                                    // Add calculated grade to term grades
                                                    $termGrades[$student_id] = [
                                                        'percentage' => round($lectureGrade, 2),
                                                        'numerical_rating' => $numericalRating
                                                    ];
                                                }

                                                return $termGrades;
                                            }


                                            // Function to convert percentage to numerical rating
                                            function convertToNumericalRating($percentage, $student_id, $class_id, $pdo)
                                            {
                                                // Query to get the midterm and final grades for the student in the given class
                                                $stmt = $pdo->prepare("SELECT midterm_grade, final_grade FROM student_grades WHERE student_id = :student_id AND class_id = :class_id");
                                                $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                                $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                                $stmt->execute();
                                                $grades = $stmt->fetch(PDO::FETCH_ASSOC);  // Retrieve both midterm_grade and final_grade
                                
                                                // Check if grades were fetched and then check for special statuses
                                                if ($grades) {
                                                    if ($grades['midterm_grade'] == 'UW' || $grades['final_grade'] == 'UW') {
                                                        return 'UW';  // Unofficial Withdrawal
                                                    } elseif ($grades['midterm_grade'] == 'INC' || $grades['final_grade'] == 'INC') {
                                                        return 'INC';  // Incomplete
                                                    } elseif ($grades['midterm_grade'] == 'AW' || $grades['final_grade'] == 'AW') {
                                                        return 'AW';  // Authorized Withdrawal
                                                    }
                                                }

                                                // If no special status, proceed with the regular numerical rating conversion
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
                                                $overallRating = convertToNumericalRating($overallPercentage, $student_id, $class_id, $pdo);

                                                $overallGrades[$student_id] = [
                                                    'percentage' => $overallPercentage,
                                                    'numerical_rating' => $overallRating
                                                ];
                                            }

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

                                <?php
                                // Get the class_id from the URL parameter
                                $class_id = $_GET['id'];


                                // Prepare the SQL statement
                                $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = :class_id");

                                // Bind the class_id parameter
                                $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);

                                // Execute the query
                                $stmt->execute();

                                // Fetch the result
                                $class = $stmt->fetch();

                                if ($class) {
                                    // Extract the class details from the fetched data
                                    $adviser = $class['teacher'];
                                    $subject = $class['subject'];
                                    $year_section = $class['code']; // Assuming 'code' is for year/section
                                    $semester = $class['semester'];
                                    $school_year = date('Y', strtotime($class['datetime_added']));
                                } else {
                                    // If no class is found, display a message
                                    echo "Class not found.";
                                    exit;
                                }

                                ?>

                                <!-- HTML Structure -->
                                <div class="row">
                                    <div class="col">
                                        <h3><b><i class="bi bi-person-circle" style="margin-right: 5px;"></i>
                                                Adviser:</b> <span><?php echo htmlspecialchars($adviser); ?></span></h3>
                                        <h3><b><i class="bi bi-book" style="margin-right: 5px;"></i> Subject:</b>
                                            <span><?php echo htmlspecialchars($subject); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-building" style="margin-right: 5px;"></i> Year and
                                                Section:</b> <span><?php echo htmlspecialchars($year_section); ?></span>
                                        </h3>
                                    </div>
                                    <div class="col">
                                        <h3><b><i class="bi bi-calendar3" style="margin-right: 5px;"></i> Semester:</b>
                                            <span><?php echo htmlspecialchars($semester); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-calendar-range" style="margin-right: 5px;"></i> School
                                                Year:</b> <span><?php echo htmlspecialchars($school_year); ?></span>
                                        </h3>
                                    </div>
                                </div>


                                <hr>

                                <?php
                                // Database connection
                                
                                // Fetch class_id from request (or set it statically for now)
                                $class_id = $_GET['id'] ?? 1;

                                // Query to get students grouped by gender
                                $stmt = $pdo->prepare("
    SELECT 
        se.student_id,
        s.fullName AS student_name,
        s.gender
    FROM 
        students_enrollments se
    JOIN 
        students s ON se.student_id = s.student_id
    WHERE 
        se.class_id = :class_id
    ORDER BY 
        s.gender, s.fullName
");
                                $stmt->execute(['class_id' => $class_id]);

                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                $males = [];
                                $females = [];

                                foreach ($students as $student) {
                                    if (strtolower($student['gender']) === 'male') {
                                        $males[] = $student;
                                    } elseif (strtolower($student['gender']) === 'female') {
                                        $females[] = $student;
                                    }
                                }

                                // Original query to get activity counts and points
                                $query = "
SELECT 
    a.type,
    COUNT(a.id) AS activity_count,  -- Count distinct activity IDs
    SUM(a.max_points) AS total_points,  -- Sum the max points for each activity type
    GROUP_CONCAT(a.max_points ORDER BY a.id) AS max_points_list -- Concatenate max_points for each activity type
FROM 
    activities a
WHERE 
    a.class_id = :class_id
GROUP BY 
    a.type
ORDER BY 
    a.type
";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute(['class_id' => $class_id]);

                                $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Initialize data array to store activity details
                                $data = [
                                    'quiz' => ['count' => 0, 'total' => 0, 'max_points_list' => []],
                                    'activity' => ['count' => 0, 'total' => 0, 'max_points_list' => []],
                                    'project' => ['count' => 0, 'total' => 0, 'max_points_list' => []],
                                    'exam' => ['count' => 0, 'total' => 0, 'max_points_list' => []],
                                    'attendance' => ['count' => 0, 'total' => 0, 'max_points_list' => []],
                                ];

                                // Iterate over the fetched results and populate the data array
                                foreach ($activities as $activity) {
                                    $type = strtolower($activity['type']);

                                    // Check if the type exists in the data array
                                    if (isset($data[$type])) {
                                        $data[$type]['count'] = $activity['activity_count'];  // Set the count for this type
                                        $data[$type]['total'] = $activity['total_points'];    // Set the total points
                                        $data[$type]['max_points_list'] = explode(',', $activity['max_points_list']); // Parse max points list
                                    }
                                }



                                $attendance_query = "
SELECT 
    COUNT(DISTINCT cm.id) AS attendance_count  -- Count distinct meetings attended
FROM 
    classes_meetings cm
WHERE 
    cm.class_id = :class_id
    AND cm.status = 'Finished'   
";

                                $attendance_stmt = $pdo->prepare($attendance_query);
                                $attendance_stmt->execute(['class_id' => $class_id]);
                                $attendance = $attendance_stmt->fetch(PDO::FETCH_ASSOC);

                                // Add attendance data to the data array
                                $data['attendance']['count'] = $attendance['attendance_count'];  // Set the attendance count
                                


                                $query = "
    SELECT COUNT(id) AS total_meetings
    FROM classes_meetings
    WHERE class_id = :class_id
";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute(['class_id' => $class_id]);
                                // Get the total number of class meetings
                                $totalMeetings = $stmt->fetchColumn();

                                // If totalMeetings is empty or zero, set it to 1
                                if (empty($totalMeetings)) {
                                    $totalMeetings = 1;
                                }

                                $attendancePercentage = 10; // Example: attendance is worth 10%
                                $percentagePerMeeting = $attendancePercentage / $totalMeetings; // Percentage per meeting
                                

                                // Initialize totals for each field
                                $totalQuizzes = 0;
                                $totalActivities = 0;
                                $totalProjects = 0;
                                $totalExams = 0;
                                $totalAttendance = 0;

                                $query = "
                                SELECT 
                                    cm.id AS meeting_id,
                                    cm.class_id,
                                    cm.status AS meeting_status,
                                    a.student_id,
                                    a.status AS attendance_status
                                FROM 
                                    classes_meetings cm
                                LEFT JOIN 
                                    attendance a ON cm.id = a.meeting_id
                                WHERE 
                                    cm.class_id = :class_id
                                ORDER BY 
                                    a.student_id, cm.id;
                            ";

                                $classId = $_GET['id'];  // Get class ID from URL or other source
                                $stmt = $pdo->prepare($query);
                                $stmt->execute(['class_id' => $classId]);

                                // Fetch the attendance data
                                $attendanceDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Initialize data structure for storing activity details
                                $activityData = [
                                    'quiz' => ['submissionCount' => 0, 'totalMaxPoints' => 0, 'maxPointsPerActivity' => [], 'studentScores' => []],
                                    'activity' => ['submissionCount' => 0, 'totalMaxPoints' => 0, 'maxPointsPerActivity' => [], 'studentScores' => []],
                                    'attendance' => ['submissionCount' => 0, 'totalMaxPoints' => 0, 'maxPointsPerActivity' => [], 'studentScores' => []],
                                    'project' => ['submissionCount' => 0, 'totalMaxPoints' => 0, 'maxPointsPerActivity' => [], 'studentScores' => []],
                                    'exam' => ['submissionCount' => 0, 'totalMaxPoints' => 0, 'maxPointsPerActivity' => [], 'studentScores' => []],

                                ];

                                // Initialize a structure to store attendance data for each student
                                $attendanceData = [];

                                // Process attendance results and populate the attendance data structure
                                foreach ($attendanceDetails as $attendance) {
                                    $studentId = $attendance['student_id'];
                                    $meetingId = $attendance['meeting_id'];
                                    $status = $attendance['attendance_status'] ?? 'Absent';  // Default to 'Absent' if no record
                                
                                    if (!isset($attendanceData[$studentId])) {
                                        $attendanceData[$studentId] = [];
                                    }

                                    // Store attendance status for each student by meeting
                                    $attendanceData[$studentId][$meetingId] = $status;
                                }

                                // Fetching activity scores (quiz, project, etc.) and inserting them into activityData
                                $query = "
                                SELECT 
                                    a.type,
                                    a.id AS activity_id,
                                    asub.student_id,
                                    COALESCE(asub.score, 0) AS score,
                                    a.max_points
                                FROM 
                                    activities a
                                LEFT JOIN 
                                    activity_submissions asub
                                ON 
                                    a.id = asub.activity_id
                                WHERE 
                                    a.class_id = :class_id
                                ORDER BY 
                                    a.type, asub.student_id, a.id;
                            ";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute(['class_id' => $classId]);

                                // Fetch the activity scores
                                $scoreDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Process fetched results and populate the activity data structure
                                foreach ($scoreDetails as $detail) {
                                    $activityType = strtolower($detail['type']);
                                    if (isset($activityData[$activityType])) {
                                        // Count unique activities
                                        $activityData[$activityType]['submissionCount'] += 1;
                                        $activityData[$activityType]['totalMaxPoints'] += $detail['max_points'];
                                        $activityData[$activityType]['maxPointsPerActivity'][] = $detail['max_points'];

                                        // Group scores by student
                                        if (!isset($activityData[$activityType]['studentScores'][$detail['student_id']])) {
                                            $activityData[$activityType]['studentScores'][$detail['student_id']] = [];
                                        }
                                        $activityData[$activityType]['studentScores'][$detail['student_id']][$detail['activity_id']] = $detail['score'];
                                    }
                                }

                                // Example: Displaying the scores along with attendance for each student
                                foreach ($activityData['attendance']['studentScores'] as $studentId => $attendanceRecords) {


                                    foreach ($attendanceRecords as $meetingId => $status) {

                                    }

                                    // You can now loop through the other activities like quiz, project, etc.
                                    // For example, for quizzes:
                                    if (isset($activityData['quiz']['studentScores'][$studentId])) {

                                        foreach ($activityData['quiz']['studentScores'][$studentId] as $activityId => $score) {

                                        }
                                    }


                                }

                                ?>


                                <table class="print-text" id="class" style="width: 100%; border: 1px solid black;">
                                    <thead style="border: 1px solid black;">
                                        <tr class="text-center">
                                            <td class="text-center bold">Worksheets</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table Header -->
                                        <tr style="border: 1px solid black;">
                                            <td class="text-center bold" colspan="2">Criteria</td>

                                            <!-- Quizzes -->


                                            <!-- Activities -->
                                            <td class="text-center bold"
                                                colspan="<?php echo $data['activity']['count']; ?>">Activities (10%)
                                            </td>
                                            <td class="text-center bold">Total</td>

                                            <!-- Attendance -->
                                            <td class="text-center bold">Attendance (10%)</td>
                                            <td class="text-center bold">Total</td>

                                            <!-- Projects -->
                                            <td class="text-center bold"
                                                colspan="<?php echo $data['project']['count']; ?>">Projects (10%)</td>
                                            <td class="text-center bold">Totals <?php echo $data['project']['count']; ?>
                                            </td>

                                            <!-- Exams -->
                                            <td class="text-center bold"
                                                colspan="<?php echo $data['exam']['count']; ?>">Exams (40%)</td>
                                            <td class="text-center bold">Total</td>


                                            <!-- GPA -->
                                            <td class="text-center bold">GPA</td>
                                        </tr>


                                        <tr>
                                            <td class="text-center bold">No.</td>
                                            <td class="text-center bold">Names of Students</td>



                                            <?php
                                            $activitypts = 0;

                                            // Loop through the max_points_list dynamically for activities
                                            foreach ($data['activity']['max_points_list'] as $i => $max_points):
                                                $activitypts += $max_points; ?>
                                                <td class="text-center bold">ACT. <?php echo $i + 1; ?> <br>
                                                    (<?php echo $max_points; ?>)</td>
                                            <?php endforeach; ?>
                                            <td><?php echo $activitypts; ?></td>


                                            <!-- Attendance -->
                                            <td class="text-center bold">
                                                <?php echo $totalMeetings; ?> meetings <br>

                                            </td>
                                            <td class="text-center bold">
                                                <?php echo $totalMeetings; ?> <br>

                                            </td>



                                            <?php
                                            $projectpts = 0;

                                            // Loop through the max_points_list dynamically for projects
                                            foreach ($data['project']['max_points_list'] as $i => $max_points):
                                                $projectpts += $max_points; ?>
                                                <td class="text-center bold">P. <?php echo $i + 1; ?> <br>
                                                    (<?php echo $max_points; ?>)</td>
                                            <?php endforeach; ?>
                                            <td><?php echo $projectpts; ?></td>


                                            <?php
                                            $exampoints = 0;

                                            // Loop through the max_points_list dynamically for exams
                                            foreach ($data['exam']['max_points_list'] as $i => $max_points):
                                                $exampoints += $max_points; ?>
                                                <td class="text-center bold">
                                                    <?php echo ($i == 0) ? 'Midterms' : 'Finals'; ?> <br>
                                                    (<?php echo $max_points; ?>)
                                                </td>
                                            <?php endforeach; ?>
                                            <td><?php echo $exampoints; ?></td>


                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>

                                        <!-- Males -->
                                        <tr>
                                            <td class="text-center grey-bg" colspan="2">Male</td>
                                        </tr>
                                        <?php foreach ($males as $index => $male): ?>
                                            <tr>
                                                <!-- Display student number -->
                                                <td><?php echo $index + 1; ?>.)</td>

                                                <!-- Display student name -->
                                                <td><?php echo htmlspecialchars($male['student_name']); ?></td>

                                                <?php
                                                // Initialize total scores for each activity type
                                                $totalQuiz = 0;
                                                $totalActivity = 0;
                                                $totalAttendance = 0;
                                                $totalProject = 0;
                                                $totalExam = 0;

                                                // Loop through each activity type (quiz, project, etc.)
                                                foreach ($activityData as $activityType => $details):
                                                    // Get the scores for this student for the current activity type
                                                    $scores = $details['studentScores'][$male['student_id']] ?? [];
                                                    $totalActivityType = 0;



                                                    // Handle Activity activity
                                                    if ($activityType == 'activity') {
                                                        foreach ($scores as $score) {
                                                            echo "<td class='text-center'>" . ($score !== null ? $score : '-') . "</td>";
                                                            $totalActivityType += $score; // Sum up the total for activity
                                                        }
                                                        echo "<td class='text-center'>" . $totalActivityType . "</td>";
                                                        $totalActivity = $totalActivityType;
                                                    }
                                                    // Handle Attendance activity
                                                    if ($activityType == 'attendance') {
                                                        $query = "
        SELECT 
            cm.id AS meeting_id,
            cm.class_id,
            a.student_id,
            a.status AS attendance_status
        FROM 
            classes_meetings cm
        LEFT JOIN 
            attendance a ON cm.id = a.meeting_id
        INNER JOIN 
            students_enrollments se ON cm.class_id = se.class_id
        WHERE 
            se.class_id = :class_id AND cm.status = 'Finished'
        ORDER BY 
            a.student_id, cm.id;
    ";

                                                        $classId = $_GET['id'];  // Get class ID from URL or other source
                                                        $stmt = $pdo->prepare($query);
                                                        $stmt->execute(['class_id' => $classId]);

                                                        // Fetch the attendance data
                                                        $attendanceDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        // Initialize a structure to store attendance data for each student
                                                        $attendanceData = [];
                                                        $meetingCount = 0;

                                                        // Process attendance results and populate the attendance data structure
                                                        foreach ($attendanceDetails as $attendance) {
                                                            $studentId = $attendance['student_id'];
                                                            $meetingId = $attendance['meeting_id'];
                                                            $status = $attendance['attendance_status'] ?? 'absent';  // Default to 'Absent' if no status
                                            
                                                            // Ensure the student exists in the $attendanceData array
                                                            if (!isset($attendanceData[$studentId])) {
                                                                $attendanceData[$studentId] = [];
                                                            }

                                                            // Store only 'Present' or 'Late' status, others are treated as 'Absent'
                                                            if ($status == 'present' || $status == 'late') {
                                                                $attendanceData[$studentId][$meetingId] = $status;  // Store 'Present' or 'Late'
                                                            } else {
                                                                $attendanceData[$studentId][$meetingId] = 'absent';  // Treat other statuses as 'Absent'
                                                            }
                                                        }

                                                        // Count the total attendance for the student, considering only 'Present' or 'Late'
                                                        $totalAttendance = isset($attendanceData[$male['student_id']]) ?
                                                            count(array_filter($attendanceData[$male['student_id']], fn($status) => in_array($status, ['present', 'late']))) : 0;

                                                        // Display the individual attendance count for the student
                                                        echo "<td class='text-center'>" . $totalAttendance . "</td>";
                                                        echo "<td class='text-center'>" . $totalAttendance . "</td>";
                                                    }



                                                    // Handle Project activity
                                                    if ($activityType == 'project') {
                                                        foreach ($scores as $score) {
                                                            echo "<td class='text-center'>" . ($score !== null ? $score : '-') . "</td>";
                                                            $totalActivityType += $score; // Sum up the total for project
                                                        }
                                                        echo "<td class='text-center'>" . $totalActivityType . "</td>";
                                                        $totalProject = $totalActivityType;
                                                    }

                                                    // Handle Exam activity
                                                    if ($activityType == 'exam') {
                                                        foreach ($scores as $score) {
                                                            echo "<td class='text-center'>" . ($score !== null ? $score : '-') . "</td>";
                                                            $totalActivityType += $score; // Sum up the total for exam
                                                        }
                                                        echo "<td class='text-center'>" . $totalActivityType . "</td>";
                                                        $totalExam = $totalActivityType;
                                                    }
                                                endforeach;

                                                // Display the overall grade once after all activity sections
                                                echo "<td class='text-center'>{$overallGrades[$male['student_id']]['numerical_rating']}</td>";
                                                ?>

                                            </tr>
                                        <?php endforeach; ?>




                                        <!-- Females -->
                                        <tr>
                                            <td class="text-center grey-bg" colspan="2">Female</td>
                                        </tr>
                                        <?php foreach ($females as $index => $female): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?>.)</td>
                                                <td><?php echo htmlspecialchars($female['student_name']); ?></td>
                                                <?php
                                                // Initialize total scores for each activity type
                                                $totalQuiz = 0;
                                                $totalActivity = 0;
                                                $totalAttendance = 0;
                                                $totalProject = 0;
                                                $totalExam = 0;

                                                // Loop through each activity type (quiz, project, etc.)
                                                foreach ($activityData as $activityType => $details):
                                                    // Get the scores for this student for the current activity type
                                                    $scores = $details['studentScores'][$female['student_id']] ?? [];
                                                    $totalActivityType = 0;


                                                    // Handle Activity activity
                                                    if ($activityType == 'activity') {
                                                        foreach ($scores as $score) {
                                                            echo "<td class='text-center'>" . ($score !== null ? $score : '-') . "</td>";
                                                            $totalActivityType += $score; // Sum up the total for activity
                                                        }
                                                        echo "<td class='text-center'>" . $totalActivityType . "</td>";
                                                        $totalActivity = $totalActivityType;
                                                    }
                                                    // Handle Attendance activity
                                                    if ($activityType == 'attendance') {
                                                        $query = "
            SELECT 
                cm.id AS meeting_id,
                cm.class_id,
                a.student_id,
                a.status AS attendance_status
            FROM 
                classes_meetings cm
            LEFT JOIN 
                attendance a ON cm.id = a.meeting_id
            INNER JOIN 
                students_enrollments se ON cm.class_id = se.class_id
            WHERE 
                se.class_id = :class_id AND cm.status = 'Finished'
            ORDER BY 
                a.student_id, cm.id;
        ";

                                                        $classId = $_GET['id'];  // Get class ID from URL or other source
                                                        $stmt = $pdo->prepare($query);
                                                        $stmt->execute(['class_id' => $classId]);

                                                        // Fetch the attendance data
                                                        $attendanceDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        // Initialize a structure to store attendance data for each student
                                                        $attendanceData = [];
                                                        $meetingCount = 0;

                                                        // Process attendance results and populate the attendance data structure
                                                        foreach ($attendanceDetails as $attendance) {
                                                            $studentId = $attendance['student_id'];
                                                            $meetingId = $attendance['meeting_id'];
                                                            $status = $attendance['attendance_status'] ?? 'absent';  // Default to 'Absent' if no status
                                            
                                                            // Ensure the student exists in the $attendanceData array
                                                            if (!isset($attendanceData[$studentId])) {
                                                                $attendanceData[$studentId] = [];
                                                            }

                                                            // Store only 'Present' or 'Late' status, others are treated as 'Absent'
                                                            if ($status == 'present' || $status == 'late') {
                                                                $attendanceData[$studentId][$meetingId] = $status;  // Store 'Present' or 'Late'
                                                            } else {
                                                                $attendanceData[$studentId][$meetingId] = 'absent';  // Treat other statuses as 'Absent'
                                                            }
                                                        }

                                                        // Count the total attendance for the student, considering only 'Present' or 'Late'
                                                        $totalAttendance = isset($attendanceData[$female['student_id']]) ?
                                                            count(array_filter($attendanceData[$female['student_id']], fn($status) => in_array($status, ['present', 'late']))) : 0;

                                                        // Display the individual attendance count for the student
                                                        echo "<td class='text-center'>" . $totalAttendance . "</td>";
                                                        echo "<td class='text-center'>" . $totalAttendance . "</td>";
                                                    }



                                                    // Handle Project activity
                                                    if ($activityType == 'project') {
                                                        foreach ($scores as $score) {
                                                            echo "<td class='text-center'>" . ($score !== null ? $score : '-') . "</td>";
                                                            $totalActivityType += $score; // Sum up the total for project
                                                        }
                                                        echo "<td class='text-center'>" . $totalActivityType . "</td>";
                                                        $totalProject = $totalActivityType;
                                                    }

                                                    // Handle Exam activity
                                                    if ($activityType == 'exam') {
                                                        foreach ($scores as $score) {
                                                            echo "<td class='text-center'>" . ($score !== null ? $score : '-') . "</td>";
                                                            $totalActivityType += $score; // Sum up the total for exam
                                                        }
                                                        echo "<td class='text-center'>" . $totalActivityType . "</td>";
                                                        $totalExam = $totalActivityType;
                                                    }
                                                endforeach;

                                                // Display the overall grade once after all activity sections
                                                echo "<td class='text-center'>{$overallGrades[$female['student_id']]['numerical_rating']}</td>";
                                                ?>

                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <button onclick="printDiv('printTable')" class="btn btn-primary mb-3">
                    <i class="bi bi-printer"></i> Print
                </button>
            </main>


        </div>


        <script src="js/app.js"></script>

        <script>
            function printDiv(divId) {
                var content = document.getElementById(divId).innerHTML;
                var printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`
        <html>
            <head>
                <title>Print Content</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .text-center { text-align: center; }
                    .bold { font-weight: bold; }
                    .grey-bg { background-color: #f8f9fa; }
                    table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
                    .grade { background: none; border: none; cursor: pointer; color: inherit; }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                ${content}
            </body>
        </html>
    `);
                printWindow.document.close();
            }
        </script>
        <?php
        include('processes/server/modals.php');
        ?>




        <script>
            function getTime() {
                const now = new Date();
                const newTime = now.toLocaleString();
                console.log(newTime);
                document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
            }
            setInterval(getTime, 100);
        </script>

</html>

<?php
include('processes/server/alerts.php');
?>