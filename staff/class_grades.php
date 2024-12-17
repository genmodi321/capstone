<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    $_SESSION['STATUS'] = "TEACHER_NOT_LOGGED_IN";
	header("Location: ../login/index.php");
}
include('processes/server/conn.php');
include('processes/server/automatic_grader_cron.php');
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
    }

    .btn-csms {
        background-color: #709775;
        color: white;
    }

    .btn-csms:hover {
        border: 1px solid #709775;
    }
</style>


<body>
    <div class="wrapper">
        <?php
        function convertToNumericalRatingg($percentage)
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
        include('sidebar.php')
            ?>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <img src="external/img/ccs_logo-removebg-preview.png" class="logo-small">
                <span class="text-white">WMSU - Comprehensive Student Management System </span>
                <div class="navbar-collapse collapse">
					<?php include('top-bar.php') ?>
				</div>
            </nav>
            <main class="content">

                <div id="page-content-wrapper">
                    <div class="card bg-light border-0 shadow-sm"
                        style="background-color: white !important; padding: 5px;">
                        <div class="container">
                            <div class="card-body">
                                <a href="class_management.php" class="d-flex align-items-center mb-3">
                                    <i class="bi bi-arrow-left-circle"
                                        style="font-size: 1.5rem; margin-right: 5px;"></i>
                                    <p class="m-0">Back</p>
                                </a>



                                <?php
                                // Get the class_id from the URL parameter
                                $class_id = $_GET['class_id'];

                                // Prepare the SQL statement to fetch the class details
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
                                    $type = $class['type'];

                                    // Now, fetch all 'types' for the same subject
                                    $stmt2 = $pdo->prepare("SELECT DISTINCT type, id 
    FROM classes 
    WHERE subject = :subject");
                                    $stmt2->bindParam(':subject', $subject, PDO::PARAM_STR);
                                    $stmt2->execute();
                                    $types = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                    // Check if the subject has multiple types like Lecture and Laboratory
                                    $hasLaboratory = false;
                                    $hasLecture = false;
                                    $laboratoryClassId = null; // Variable to store the class_id of the laboratory class
                                    $lectureClassId = null; // Variable to store the class_id of the laboratory class
                                
                                    foreach ($types as $typeRow) {
                                        if (strcasecmp($typeRow['type'], 'lecture') == 0) {
                                            $hasLecture = true;
                                            $lectureClassId = $typeRow['id'];
                                        }
                                        if (strcasecmp($typeRow['type'], 'laboratory') == 0) {
                                            $hasLaboratory = true;
                                            $laboratoryClassId = $typeRow['id']; // Store the class_id of the laboratory
                                        }
                                    }
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
                                        <h3><b><i class="bi bi-calendar" style="margin-right: 5px;"></i> Subject
                                                Year:</b> <span><?php echo htmlspecialchars($type); ?></span></h3>
                                        <h3><b><i class="bi bi-calendar3" style="margin-right: 5px;"></i> Semester:</b>
                                            <span><?php echo htmlspecialchars($semester); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-calendar-range" style="margin-right: 5px;"></i> School
                                                Year:</b> <span><?php echo htmlspecialchars($school_year); ?></span>
                                        </h3>
                                    </div>
                                    <div class="col">
                                        <?php if ($hasLecture && $hasLaboratory): ?>
                                            <!-- If both Lecture and Laboratory types exist, show buttons to go to the opposite class type -->
                                            <div class="d-flex align-items-center">
                                                <div class="ms-auto" aria-hidden="true">
                                                    <!-- If the current class is Lecture, link to Laboratory -->
                                                    <?php if (strcasecmp($type, 'lecture') == 0): ?>
                                                        <a
                                                            href="class_grades.php?class_id=<?php echo $laboratoryClassId ?>&semester_id=<?php echo $_GET['semester_id'] ?>">
                                                            <button class="btn btn-warning">Go to Laboratory</button>
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- If the current class is Laboratory, link to Lecture -->
                                                    <?php if (strcasecmp($type, 'laboratory') == 0): ?>
                                                        <a
                                                            href="class_grades.php?class_id=<?php echo $lectureClassId ?>&semester_id=<?php echo $_GET['semester_id'] ?>">
                                                            <button class="btn btn-primary">Go to Lecture</button>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        <?php endif; ?>

                                    </div>
                                </div>

                                <hr>




                                <div class="d-flex align-items-center">
                                    <h3 class="text-center bold">Student Grades</h3>
                                    <?php
                                    // Assuming class_id is passed via GET or POST
                                    $class_id = isset($_GET['class_id']) ? (int) $_GET['class_id'] : null;

                                    if ($class_id) {
                                        try {

                                            // Check for 6 quizzes (only for regular classes)
                                            if ($type != 'laboratory') {
                                                $quizStmt = $pdo->prepare("SELECT COUNT(*) FROM activities WHERE class_id = :class_id AND type = 'quiz'");
                                                $quizStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                                $quizStmt->execute();
                                                $quizCount = $quizStmt->fetchColumn();
                                            } else {
                                                $quizCount = 0;  // No quizzes needed for laboratory classes
                                            }



                                            // Check for activity
                                            $activityStmt = $pdo->prepare("SELECT COUNT(*) FROM activities WHERE class_id = :class_id AND type = 'activity'");
                                            $activityStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                            $activityStmt->execute();
                                            $activityCount = $activityStmt->fetchColumn();



                                            // Check for attendance
                                            $attendanceStmt = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE class_id = :class_id");
                                            $attendanceStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                            $attendanceStmt->execute();
                                            $attendanceCount = $attendanceStmt->fetchColumn();



                                            // Check for midterm and final exams
                                            $examStmt = $pdo->prepare("SELECT COUNT(*) FROM activities WHERE class_id = :class_id AND type = 'exam' AND term IN ('midterm', 'final')");
                                            $examStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                            $examStmt->execute();
                                            $examCount = $examStmt->fetchColumn();

                                            // Check for projects 
                                            $projectStmt = $pdo->prepare("SELECT COUNT(*) FROM activities WHERE class_id = :class_id AND type = 'project'");
                                            $projectStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                            $projectStmt->execute();
                                            $projectCount = $projectStmt->fetchColumn();
                                            echo $projectCount;
           
           
                                            // Check if all conditions are met based on class type
                                            if ($type == 'Laboratory') {

                                                // For laboratory class, only check for activity, attendance, and exams
                                                $allConditionsMet = ($activityCount >= 1 && $attendanceCount >= 1 && $examCount == 2 && $projectCount >= 1);

                                            } else {
                                                // For regular class, check for quizzes, activity, attendance, and exams
                                                $allConditionsMet = ($quizCount == 6 && $activityCount >= 1 && $attendanceCount >= 1 && $examCount == 2);
                                            }
                                        } catch (PDOException $e) {
                                            echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                                        }
                                    } else {
                                        echo "<p class='error'>Class not found.</p>";
                                    }
                                    ?>

                                    <!-- Button display logic -->
                                    <div class="ms-auto" aria-hidden="true">
                                        <?php if ($allConditionsMet): ?>
                                            <?php if ($type == 'Laboratory'): ?>
                                                <!-- For Laboratory class, show the link for laboratory view -->
                                                <a href="lab_class_grades_tabular.php?id=<?php echo $_GET['class_id'] ?>">
                                                    <button class="btn btn-primary">View Laboratory Grades in Tabular
                                                        Format</button>
                                                </a>
                                            <?php elseif ($type == 'Lecture'): ?>
                                                <!-- For Lecture class, show the link for lecture view -->
                                                <a href="lecture_class_grades_tabular.php?id=<?php echo $_GET['class_id'] ?>">
                                                    <button class="btn btn-primary">View Lecture Grades in Tabular
                                                        Format</button>
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p class="text-warning">
                                                All necessary components (6 quizzes, 1 activity, attendance, 1 or more projects and 2 exams)
                                                must be present to view in tabular format.
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                </div>


                                <br>

                                <?php
                                $stmt = $pdo->prepare("SELECT student_id FROM students_enrollments WHERE class_id = :class_id");
                                $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                $stmt->execute();
                                $enrolledStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($enrolledStudents) {
                                    // Start the accordion container
                                    echo '<div class="accordion" id="gradesAccordion">';

                                    $studentCounter = 1; // Counter to generate unique IDs for each student
                                
                                    foreach ($enrolledStudents as $enrollment) {
                                        $student_id = $enrollment['student_id'];

                                        // Prepare the query to get the full name of the student
                                        $studentStmt = $pdo->prepare("SELECT fullName FROM students WHERE student_id = :student_id");
                                        $studentStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                        $studentStmt->execute();
                                        $student = $studentStmt->fetch(PDO::FETCH_ASSOC);

                                        if ($student) {
                                            // Dynamically generate unique IDs for each accordion section
                                            $accordionId = 'collapseStudent' . $studentCounter;
                                            $headingId = 'headingStudent' . $studentCounter;

                                            // Prepare the query to fetch activities for this class
                                            $activityStmt = $pdo->prepare("SELECT * FROM activities WHERE class_id = :class_id");
                                            $activityStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                            $activityStmt->execute();
                                            $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

                                            // Initialize arrays to group activities by type
                                            $quizzes = [];
                                            $activitiesList = [];
                                            $projects = [];
                                            $exams = [];

                                            // Group activities based on type
                                            foreach ($activities as $activity) {
                                                switch ($activity['type']) {
                                                    case 'quiz':
                                                        $quizzes[] = $activity;
                                                        break;
                                                    case 'activity':
                                                        $activitiesList[] = $activity;
                                                        break;
                                                    case 'project':
                                                        $projects[] = $activity;
                                                        break;
                                                    case 'exam':
                                                        $exams[] = $activity;
                                                        break;
                                                }
                                            }

                                            ?>

                                            <!-- Student Accordion Item -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#<?php echo $accordionId; ?>"
                                                        aria-expanded="true" aria-controls="<?php echo $accordionId; ?>">
                                                        <?php echo 'Student ' . $studentCounter . ' - ' . htmlspecialchars($student['fullName']); ?>
                                                    </button>
                                                </h2>
                                                <div id="<?php echo $accordionId; ?>" class="accordion-collapse collapse"
                                                    aria-labelledby="<?php echo $headingId; ?>" data-bs-parent="#gradesAccordion">
                                                    <div class="accordion-body">

                                                        <?php
                                                        // Display Quizzes
                                                        if (count($quizzes) > 0) {
                                                            echo '<h5 class="mt-3">Quizzes</h5>';
                                                            $quizCounter = 1; // Counter for quizzes
                                                            echo '<div class="row mb-3">';
                                                            foreach ($quizzes as $index => $activity) {
                                                                $activity_id = $activity['id'];
                                                                $scoreStmt = $pdo->prepare("SELECT score FROM activity_submissions WHERE activity_id = :activity_id AND student_id = :student_id");
                                                                $scoreStmt->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
                                                                $scoreStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                                                $scoreStmt->execute();
                                                                $score = $scoreStmt->fetch(PDO::FETCH_ASSOC);

                                                                // Display quiz in a maximum of two columns per row
                                                                echo '<div class="col-md-6">';
                                                                echo '<div class="card shadow-sm border-primary">';
                                                                echo '<div class="card-body">';
                                                                echo '<h6 class="card-title">Quiz ' . $quizCounter . ' (' . htmlspecialchars($activity['title']) . ')</h6>';
                                                                if ($score) {
                                                                    echo '<p class="card-text">Score: <strong>' . $score['score'] . '</strong> / ' . $activity['max_points'] . '</p>';
                                                                } else {
                                                                    echo '<p class="card-text">No score available.</p>';
                                                                }
                                                                echo '</div>';
                                                                echo '</div>';
                                                                echo '</div>';

                                                                // Only start a new row after every two items
                                                                if (($index + 1) % 2 == 0) {
                                                                    echo '</div><div class="row mb-3">'; // Start new row
                                                                }

                                                                $quizCounter++; // Increment the quiz counter
                                                            }
                                                            echo '</div>'; // Close the last row
                                                        }

                                                        // Display Activities
                                                        if (count($activitiesList) > 0) {
                                                            echo '<h5 class="mt-3">Activities</h5>';
                                                            $activityCounter = 1; // Counter for activities
                                                            echo '<div class="row mb-3">';
                                                            foreach ($activitiesList as $index => $activity) {
                                                                $activity_id = $activity['id'];
                                                                $scoreStmt = $pdo->prepare("SELECT score FROM activity_submissions WHERE activity_id = :activity_id AND student_id = :student_id");
                                                                $scoreStmt->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
                                                                $scoreStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                                                $scoreStmt->execute();
                                                                $score = $scoreStmt->fetch(PDO::FETCH_ASSOC);

                                                                // Display activity in a maximum of two columns per row
                                                                echo '<div class="col-md-6">';
                                                                echo '<div class="card shadow-sm border-primary">';
                                                                echo '<div class="card-body">';
                                                                echo '<h6 class="card-title">Activity ' . $activityCounter . ' (' . htmlspecialchars($activity['title']) . ')</h6>';
                                                                if ($score) {
                                                                    echo '<p class="card-text">Score: <strong>' . $score['score'] . '</strong> / ' . $activity['max_points'] . '</p>';
                                                                } else {
                                                                    echo '<p class="card-text">No score available.</p>';
                                                                }
                                                                echo '</div>';
                                                                echo '</div>';
                                                                echo '</div>';

                                                                // Only start a new row after every two items
                                                                if (($index + 1) % 2 == 0) {
                                                                    echo '</div><div class="row mb-3">'; // Start new row
                                                                }

                                                                $activityCounter++; // Increment the activity counter
                                                            }
                                                            echo '</div>'; // Close the last row
                                                        }

                                                        // Display Projects
                                                        if (count($projects) > 0) {
                                                            echo '<h5 class="mt-3">Projects</h5>';
                                                            $projectCounter = 1; // Counter for projects
                                                            echo '<div class="row mb-3">';
                                                            foreach ($projects as $index => $activity) {
                                                                $activity_id = $activity['id'];
                                                                $scoreStmt = $pdo->prepare("SELECT score FROM activity_submissions WHERE activity_id = :activity_id AND student_id = :student_id");
                                                                $scoreStmt->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
                                                                $scoreStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                                                $scoreStmt->execute();
                                                                $score = $scoreStmt->fetch(PDO::FETCH_ASSOC);

                                                                // Display project in a maximum of two columns per row
                                                                echo '<div class="col-md-6">';
                                                                echo '<div class="card shadow-sm border-primary">';
                                                                echo '<div class="card-body">';
                                                                echo '<h6 class="card-title">Project ' . $projectCounter . ' (' . htmlspecialchars($activity['title']) . ')</h6>';
                                                                if ($score) {
                                                                    echo '<p class="card-text">Score: <strong>' . $score['score'] . '</strong> / ' . $activity['max_points'] . '</p>';
                                                                } else {
                                                                    echo '<p class="card-text">No score available.</p>';
                                                                }
                                                                echo '</div>';
                                                                echo '</div>';
                                                                echo '</div>';

                                                                // Only start a new row after every two items
                                                                if (($index + 1) % 2 == 0) {
                                                                    echo '</div><div class="row mb-3">'; // Start new row
                                                                }

                                                                $projectCounter++; // Increment the project counter
                                                            }
                                                            echo '</div>'; // Close the last row
                                                        }

                                                        // Display Exams
                                                        if (count($exams) > 0) {
                                                            echo '<h5 class="mt-3">Exams</h5>';
                                                            $examCounter = 1; // Counter for exams
                                                            echo '<div class="row mb-3">';
                                                            foreach ($exams as $index => $activity) {
                                                                $activity_id = $activity['id'];
                                                                $scoreStmt = $pdo->prepare("SELECT score FROM activity_submissions WHERE activity_id = :activity_id AND student_id = :student_id");
                                                                $scoreStmt->bindParam(':activity_id', $activity_id, PDO::PARAM_INT);
                                                                $scoreStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                                                $scoreStmt->execute();
                                                                $score = $scoreStmt->fetch(PDO::FETCH_ASSOC);

                                                                // Display exam in a maximum of two columns per row
                                                                echo '<div class="col-md-6">';
                                                                echo '<div class="card shadow-sm border-primary">';
                                                                echo '<div class="card-body">';
                                                                echo '<h6 class="card-title">Exam ' . $examCounter . ' (' . htmlspecialchars($activity['title']) . ')</h6>';
                                                                if ($score) {
                                                                    echo '<p class="card-text">Score: <strong>' . $score['score'] . '</strong> / ' . $activity['max_points'] . '</p>';
                                                                } else {
                                                                    echo '<p class="card-text">No score available.</p>';
                                                                }
                                                                echo '</div>';
                                                                echo '</div>';
                                                                echo '</div>';

                                                                // Only start a new row after every two items
                                                                if (($index + 1) % 2 == 0) {
                                                                    echo '</div><div class="row mb-3">'; // Start new row
                                                                }

                                                                $examCounter++; // Increment the exam counter
                                                            }
                                                            echo '</div>'; // Close the last row
                                                        }

                                                        ?>

                                                        <!-- GPA -->

                                                        <?php
                                                        // Assuming you have the $class_id and $student_id available
                                                        $class_id = $_GET['class_id'];  // Get class_id from URL (or elsewhere)
                                                        $student_id = $enrollment['student_id'];  // Assuming you have $enrollment containing student details
                                            
                                                        // Fetch the grades for the student in the specific class
                                                        $stmt = $pdo->prepare("SELECT midterm_grade, final_grade FROM student_grades WHERE student_id = :student_id AND class_id = :class_id");
                                                        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                                                        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                                                        $stmt->execute();

                                                        // Fetch the result
                                                        $grades = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        // Function to convert percentage to numerical rating
                                            
                                                        // Check if grades exist and display them
                                                        if ($grades) {
                                                            $midtermGrade = $grades['midterm_grade'];  // No need to cast, leave as string
                                                            $finalGrade = $grades['final_grade'];      // No need to cast, leave as string
                                            
                                                            // Check for special grades ('AW', 'UW', 'INC')
                                                            if (in_array($midtermGrade, ['AW', 'UW', 'INC'])) {
                                                                $midtermGradeDisplay = $midtermGrade;
                                                            } else {
                                                                // If the grade is not special, calculate percentage
                                                                $midtermGradeDisplay = (float) $midtermGrade;  // Convert grade to float for percentage calculation
                                                            }

                                                            if (in_array($finalGrade, ['AW', 'UW', 'INC'])) {
                                                                $finalGradeDisplay = $finalGrade;
                                                            } else {
                                                                // If the grade is not special, calculate percentage
                                                                $finalGradeDisplay = (float) $finalGrade;  // Convert grade to float for percentage calculation
                                                            }

                                                            // Calculate the overall percentage and convert it to numerical rating
                                                            // Only calculate if grades are numerical
                                                            if (is_numeric($midtermGradeDisplay) && is_numeric($finalGradeDisplay)) {
                                                                $overallPercentage = round(($midtermGradeDisplay * 0.4) + ($finalGradeDisplay * 0.6), 2);
                                                                $overallRating = convertToNumericalRatingg($overallPercentage);
                                                            } else {
                                                                // If one of the grades is not numeric (i.e. AW, UW, or INC), set overall percentage and rating to "Not Available"
                                                                $overallPercentage = "Not Available";
                                                                $overallRating = "Not Available";
                                                            }
                                                        } else {
                                                            $midtermGradeDisplay = "Not Available";
                                                            $finalGradeDisplay = "Not Available";
                                                            $overallPercentage = "Not Available";
                                                            $overallRating = "Not Available";
                                                        }

                                                        ?>

                                                        <div class="text-center">
                                                            <p><b>Midterm Grade:</b> <?php echo $midtermGradeDisplay ?></p>
                                                            <p><b>Final Grade:</b> <?php echo $finalGradeDisplay ?></p>
                                                            <p><b>Overall Percentage:</b> <?php echo $overallPercentage ?>%</p>
                                                            <p><b>GPA Rating:</b> <?php echo $overallRating ?></p>
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $studentCounter++; // Increment the student counter
                                        } else {
                                            // Handle case where the student is not found in the 'students' table
                                            echo '<h2 class="view-person"><i class="bi bi-person icon"></i> Student not found</h2>';
                                        }
                                    }

                                    // Close the accordion container
                                    echo '</div>';
                                } else {
                                    echo '<h2 class="view-person">No students enrolled in this class.</h2>';
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>
            </main>


        </div>


        <script src="js/app.js"></script>
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