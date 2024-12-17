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
                    <div class="container-fluid">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2>Class Advising</h2>
                            </div>
                            <div class="card-body">
                                <p>Manage student advising and assign them to appropriate classes.</p>
                                <!-- Additional class advising functionalities can go here -->
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h1>Teacher Dashboard Overview</h1>
                                <p>Welcome back, [Teacher's Name]! Here's an overview of your schedule and tasks.</p>

                                <!-- Dashboard Summary -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">Today’s Classes</h5>
                                                <ul>
                                                    <li>BSIT-1A - Introduction to IT - 10:00 AM</li>
                                                    <li>BSIT-2B - Web Development - 2:00 PM</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">Attendance Summary</h5>
                                                <p>Classes Taken: 3</p>
                                                <p>Average Attendance Rate: 92%</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">Pending Assignments</h5>
                                                <p>Assignments to Grade: 5</p>
                                                <p>Upcoming Deadlines: 3</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Class Management Section -->

                        <?php
                        // Assuming you have already established the $pdo connection
                        
                        // Step 1: Get the teacher's full name
                        $teacher_id = $_SESSION['teacher_id']; // Get the teacher ID from the session
                        $teacher_stmt = $pdo->prepare("SELECT fullName FROM staff_accounts WHERE id = :teacher_id");
                        $teacher_stmt->execute(['teacher_id' => $teacher_id]);
                        $teacher = $teacher_stmt->fetch(PDO::FETCH_ASSOC);

                        $teacher_name = $teacher['fullName'];


                        // Step 2: Get classes for the teacher
                        $class_stmt = $pdo->prepare("
    SELECT 
            c.id AS id,
        c.classCode AS class_code,
        c.name AS class_section,
        c.subject AS subject_name,
        c.code AS subject_code,
        c.subject_Id as subject_id,
        c.semester AS semester,
          c.is_archived AS class_archived,
        s.is_archived AS subject_archived
    FROM classes c
    JOIN subjects s ON c.subject_id = s.id
    WHERE c.teacher = :teacherName
");
                        $class_stmt->execute(['teacherName' => $teacher_name]);
                        $classes = $class_stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get the teacher's full name or set a default
                        $teacher_name = $teacher ? htmlspecialchars($teacher['fullName']) : "Unknown Teacher";

                        foreach ($classes as &$class) {
                            $semester_name = $class['semester'];

                            // Query to get semester ID based on semester name
                            $semester_stmt = $pdo->prepare("SELECT id FROM semester WHERE name = :semester_name");
                            $semester_stmt->execute(['semester_name' => $semester_name]);
                            $semester = $semester_stmt->fetch(PDO::FETCH_ASSOC);

                            // Store the semester ID in the class array
                            $class['semester_id'] = $semester ? $semester['id'] : null;
                        }
                        ?>



                        <div class="card">
                            <div class="card-body">
                                <h2>Class Management</h2>
                                <div class="table-responsive">
                                    <table id="classesTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Class Code</th>
                                                <th>Class Section</th>
                                                <th>Subject Name</th>
                                                <th>Subject Code</th>
                                                <th>Semester</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($classes as $class): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($class['class_code']) ?></td>
                                                    <td><?= htmlspecialchars($class['class_section']) ?></td>
                                                    <td><?= htmlspecialchars($class['subject_name']) ?></td>
                                                    <td><?= htmlspecialchars($class['subject_code']) ?></td>
                                                    <td><?= htmlspecialchars($class['semester']) ?></td>
                                                    <td>
                                                        <?php if ($class['class_archived'] == 1): ?>
                                                            <span class="text-danger">Class is archived</span>
                                                            <!-- Show archived message -->
                                                        <?php else: ?>
                                                            <a
                                                                href="class_attendance.php?class_id=<?= urlencode($class['id']) ?>&semester_id=<?php echo $class['semester_id'] ?>">
                                                                <button class="btn btn-primary btn-sm">
                                                                    <i class="bi bi-calendar-check"></i> Classes
                                                                </button>
                                                            </a>
                                                            <a
                                                                href="class_grades.php?class_id=<?= urlencode($class['id']) ?>&semester_id=<?php echo $class['semester_id'] ?>">
                                                                <button class="btn btn-success btn-sm">
                                                                    <i class="bi bi-bar-chart-line"></i> Grades
                                                                </button>
                                                            </a>
                                                            <a
                                                                href="subject_activities.php?url=people&class_id=<?= urlencode($class['id']) ?>&subject_id=<?php echo $class['subject_id'] ?>">
                                                                <button class="btn btn-warning btn-sm">
                                                                    <i class="bi bi-pencil-square"></i> Manage
                                                                </button>
                                                            </a>
                                                            <a
                                                                href="class_posts.php?class_id=<?= urlencode($class['class_code']) ?>">
                                                                <button class="btn btn-info btn-sm">
                                                                    <i class="bi bi-chat-dots"></i> Posts
                                                                </button>
                                                            </a>
                                                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#detailsModal"
                                                                data-class="<?= htmlspecialchars($class['class_code']) ?>">
                                                                <i class="bi bi-info-circle"></i> Details
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createClassModal"><i class="bi bi-plus-circle-fill"></i> Add a
                                        Class to Teach</button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="createClassModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Create a Class</b></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addClassForm" action="processes/teachers/classes/add.php"
                                            method="POST">
                                            <div class="mb-3">
                                                <label for="class" class="form-label bold">Select Class:</label>
                                                <select class="form-select" name="class" required>
                                                    <option selected disabled>Select a class</option>
                                                    <optgroup label="Department of Information Technology">
                                                        <option value="BSIT-1A">BSIT - 1A</option>
                                                        <option value="BSIT-1B">BSIT - 1B</option>
                                                        <option value="BSIT-2A">BSIT - 2A</option>
                                                        <option value="BSIT-2B">BSIT - 2B</option>
                                                        <option value="BSIT-3A">BSIT - 3A</option>
                                                        <option value="BSIT-3B">BSIT - 3B</option>
                                                        <option value="BSIT-4A">BSIT - 4A</option>
                                                        <option value="BSIT-4B">BSIT - 4B</option>
                                                    </optgroup>
                                                    <optgroup label="Department of Computer Science">
                                                        <option value="BSCS-1A">BSCS - 1A</option>
                                                        <option value="BSCS-1B">BSCS - 1B</option>
                                                        <option value="BSCS-2A">BSCS - 2A</option>
                                                        <option value="BSCS-2B">BSCS - 2B</option>
                                                        <option value="BSCS-3A">BSCS - 3A</option>
                                                        <option value="BSCS-3B">BSCS - 3B</option>
                                                        <option value="BSCS-4A">BSCS - 4A</option>
                                                        <option value="BSCS-4B">BSCS - 4B</option>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="mb-3">


                                                <div class="mb-3">
                                                    <label for="adviser" class="form-label bold">Assigned
                                                        Adviser:</label>
                                                    <input type="text" class="form-control" id="assignedAdviser"
                                                        name="assignedAdviser" value="Adviser name logged on" readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="subjectName" class="form-label bold">Select Subject
                                                        Name: </label>
                                                    <?php
                                                    try {
                                                        $stmt = $pdo->prepare("SELECT id, name, semester FROM subjects ORDER BY name");
                                                        $stmt->execute();
                                                        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    } catch (PDOException $e) {
                                                        echo "Error: " . $e->getMessage();
                                                    }
                                                    ?>

                                                    <select class="form-select" name="subjectName">
                                                        <?php if (!empty($subjects)): ?>
                                                            <option value="" selected>Select a subject</option>
                                                            <?php foreach ($subjects as $row): ?>
                                                                <option value="<?php echo htmlspecialchars($row['name']); ?>">
                                                                    <?php echo htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['semester']) . ')'; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="" selected>No subjects added yet</option>
                                                        <?php endif; ?>
                                                    </select>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="teacher" class="form-label bold">Select Teacher:
                                                    </label>
                                                    <select class="form-select" name="teacher" required>
                                                        <?php
                                                        require 'processes/server/conn.php';
                                                        $sql = "SELECT id, fullName FROM staff_accounts";
                                                        $stmt = $pdo->query($sql);
                                                        if ($stmt->rowCount() > 0) {
                                                            echo '<option selected>Select teacher below</option>';
                                                            while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                echo '<option value="' . htmlspecialchars($teacher["fullName"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($teacher["fullName"], ENT_QUOTES, 'UTF-8') . '</option>';
                                                            }
                                                        } else {
                                                            echo '<option>There is no staff added yet!</option>';
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="semester" class="form-label bold">Select
                                                        Semester:</label>
                                                    <select class="form-select" name="semester" required>
                                                        <?php
                                                        $sql = "SELECT name FROM semester ORDER BY name ";
                                                        $stmt = $pdo->query($sql);
                                                        $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        ?>

                                                        <?php if (!empty($semesters)): ?>
                                                            <?php foreach ($semesters as $semester): ?>
                                                                <option
                                                                    value="<?php echo htmlspecialchars($semester['name']); ?>">
                                                                    <?php echo htmlspecialchars($semester['name']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="">No semesters available</option>
                                                        <?php endif; ?>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="classDesc" class="form-label bold">Class
                                                        Description:</label>
                                                    <textarea class="form-control" id="classDesc" name="classDesc"
                                                        required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Assignment Management Modal -->
                    <div class="modal fade" id="assignmentModal" tabindex="-1" aria-labelledby="assignmentModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignmentModalLabel">Manage Assignments</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="processes/assignments/manage.php" method="POST">
                                        <div class="mb-3">
                                            <label for="classSelect" class="form-label">Select Class:</label>
                                            <select class="form-select" name="class" required>
                                                <option value="BSIT-1A">BSIT-1A - Introduction to IT</option>
                                                <!-- More options dynamically loaded -->
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="assignmentTitle" class="form-label">Assignment Title:</label>
                                            <input type="text" class="form-control" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description:</label>
                                            <textarea class="form-control" name="description" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dueDate" class="form-label">Due Date:</label>
                                            <input type="date" class="form-control" name="due_date" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Assignment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#classesTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>

</html>

<?php
include('processes/server/alerts.php');
?>