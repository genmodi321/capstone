<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['STATUS'] = "ADMIN_NOT_LOGGED_IN";
    header("Location: admin_login_page.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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

<?php
include 'processes/server/conn.php';

// Fetch all subjects
$query = "SELECT id, name, type, code, semester, course, year_level FROM subjects";
$result = $pdo->query($query);
$subjectData = [];

// Prepare subjects data
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $subjectData[] = [
        'id' => htmlspecialchars($row['id']),
        'name' => htmlspecialchars($row['name']),
        'type' => htmlspecialchars($row['type']),
        'code' => htmlspecialchars($row['code']),
        'semester' => htmlspecialchars($row['semester']),
        'course' => htmlspecialchars($row['course']),
        'year_level' => htmlspecialchars($row['year_level']),
        'schedule' => '', // Placeholder for schedule
        'actions' => ''
    ];
}

// Fetch class schedules
$scheduleQuery = "SELECT subject_id, meeting_days, start_time, end_time FROM subjects_schedules";
$scheduleResult = $pdo->query($scheduleQuery);
$scheduleData = [];

// Prepare schedules
while ($row = $scheduleResult->fetch(PDO::FETCH_ASSOC)) {
    // Create a formatted string for the schedule
    $formattedSchedule = '<strong>' . $row['meeting_days'] . '</strong> ' . date("g:i A", strtotime($row['start_time'])) . ' - ' . date("g:i A", strtotime($row['end_time']));
    $scheduleData[$row['subject_id']][] = $formattedSchedule; // Group by subject_id
}

// Merge schedules into subject data
foreach ($subjectData as &$subject) {
    if (isset($scheduleData[$subject['id']])) {
        $subject['schedule'] = implode('<br> ', $scheduleData[$subject['id']]); // Join schedules with a semicolon
    } else {
        $subject['schedule'] = 'No schedule'; // Default message if no schedule found
    }
}

// Convert the final subject data to JSON for JavaScript use
$subjectDataJSON = json_encode($subjectData);
?>

<script>
    var subjectData = <?php echo $subjectDataJSON; ?>;

    // You can use subjectData here to populate your DataTable or display it as needed
    console.log(subjectData);
</script>


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
                    <?php
                    include('top-bar.php');
                    ?>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">



                    <div class="row">

                        <div class="col-12">
                            <div class="card">

                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="h5 mb-3"><a
                                                href="index.php"
                                                class="nav-ham-link">Home</a> / <span>Subject Management</span></h5>

                                        <div class="ms-auto" aria-hidden="true">
                                            <img
                                                src="external/svgs/undraw_favorite_gb6n.svg"
                                                class=" small-picture img-fluid">
                                        </div>
                                    </div>

                                    <br>

                                    <h5 class="card-title mb-0">
                                        <div class="d-flex align-items-center">
                                            <h3>Subject List</h3>
                                            <div class="ms-auto" aria-hidden="true">
                                                <button type="button" class="btn btn-csms"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#createSubjectModal"><i
                                                        class="bi bi-pencil-square"></i>
                                                    Create Subject</button>
                                            </div>

                                        </div>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h1 id="noDataMessage" style="display:none; text-align:center">No subjects added, yet!</h1>
                                    <table id="classes" class="responsive" style="width:100%">
                                    <tfoot id="table-footer">
        <tr>
            <th>Subject Name</th>
            <th>Subject Type</th>
            <th>Subject Code</th>
            <th>Subject Schedule</th>
                  <th>Semester</th>
            <th>Course</th>
            <th>Year Level</th>
      
            <th>Actions</th>
        </tr>
    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>

    </div>
    </main>


    </div>
    </div>




    <script src="js/app.js"></script>
 
   <div class="modal fade" id="createSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create a Subject</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="processes/admin/subjects/add.php">
                    <!-- Subject Name -->
                    <div class="mb-3">
                        <label for="subjectName" class="form-label bold">Subject Name</label>
                        <input type="text" class="form-control" id="subjectName" name="subjectName" required>
                    </div>

                    <!-- Subject Code -->
                    <div class="mb-3">
                        <label for="subjectCode" class="form-label bold">Subject Code</label>
                        <input type="text" class="form-control" id="subjectCode" name="subjectCode" required>
                    </div>

                    <!-- Subject Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label bold">Subject Type</label>
                        <select class="form-control" name="type" id="type">
                            <option default selected disabled>Select class type below</option>
                            <option value="Lecture">Lecture</option>
                            <option value="Laboratory">Laboratory</option>
                        </select>
                    </div>

                    <!-- Meeting Days -->
                    <div class="mb-3">
                        <label for="meetingDays" class="form-label bold">Meeting Days:</label>
                        <div id="meetingDays">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="meeting_days[]" value="Monday">
                                <label class="form-check-label">Monday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="meeting_days[]" value="Tuesday">
                                <label class="form-check-label">Tuesday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="meeting_days[]" value="Wednesday">
                                <label class="form-check-label">Wednesday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="meeting_days[]" value="Thursday">
                                <label class="form-check-label">Thursday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="meeting_days[]" value="Friday">
                                <label class="form-check-label">Friday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="meeting_days[]" value="Saturday">
                                <label class="form-check-label">Saturday</label>
                            </div>
                        </div>
                    </div>

                    <!-- Start Time -->
                    <div class="mb-3">
                        <label for="startTime" class="form-label bold">Start Time:</label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>

                    <!-- End Time -->
                    <div class="mb-3">
                        <label for="endTime" class="form-label bold">End Time:</label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>

                    <!-- Semester -->
                    <div class="mb-3">
                        <label for="semester" class="form-label bold">Select Semester:</label>
                        <?php
                        $semesters = [];
                        try {
                            $stmt = $pdo->query("SELECT name FROM semester WHERE status = 'active'");
                            $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Error fetching semesters: " . $e->getMessage();
                        }
                        ?>
                        <select class="form-select" name="semester" required>
                            <option selected>Select a Semester</option>
                            <?php if (!empty($semesters)): ?>
                                <?php foreach ($semesters as $semester): ?>
                                    <option value="<?= htmlspecialchars($semester['name']) ?>"><?= htmlspecialchars($semester['name']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>No semesters available</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Course (e.g., BSIT, BSCS) -->
                    <div class="mb-3">
                        <label for="course" class="form-label bold">Course</label>
                        <select class="form-control" name="course" required>
                            <option value="" disabled selected>Select Course</option>
                            <option value="BSIT">Bachelor of Science in Information Technology</option>
                            <option value="BSCS">Bachelor of Science in Computer Science</option>
                            <option value="MIT">Masters in Information Technology</option>
                            <option value="MCS">Masters in Computer Sciebce</option>
                 
                        </select>
                    </div>

                    <!-- Year Level -->
                    <div class="mb-3">
                        <label for="yearLevel" class="form-label bold">Year Level</label>
                        <select class="form-control" name="year_level" required>
                            <option value="" disabled selected>Select Year Level</option>
                            <option value="1A">1A</option>
                            <option value="1B">1B</option>
                            <option value="2A">2A</option>
                            <option value="2B">2B</option>
                            <option value="3A">3A</option>
                            <option value="3B">3B</option>
                            <option value="4A">4A</option>
                            <option value="4B">4B</option>
                            <!-- Add other year levels as needed -->
                        </select>
                    </div>

           
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <input type="submit" class="btn btn-csms" value="Save Changes">
                <button type="button" class="btn btn-csms" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


    <?php
    require 'processes/server/conn.php';

    $staffQuery = "SELECT id, fullName FROM staff_accounts";
    $staffStmt = $pdo->query($staffQuery);
    $staffMembers = $staffStmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM subjects";
    $stmt = $pdo->query($sql);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subjects as $subject) {
        $modalId = $subject['id'];
    ?>
     <?php
// Fetching meeting days with start and end times for the selected subject
$meetingDetails = [];
try {
    $stmt = $pdo->prepare("SELECT meeting_days, start_time, end_time FROM subjects_schedules WHERE subject_id = :subject_id");
    $stmt->bindParam(':subject_id', $subject['id'], PDO::PARAM_INT); // Assuming $subject['id'] contains the subject ID
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Store each meeting day with start and end times in the array
    foreach ($schedules as $schedule) {
        $meetingDetails[] = htmlspecialchars($schedule['meeting_days']) . ": " . date("h:i A", strtotime($schedule['start_time'])) . " - " . date("h:i A", strtotime($schedule['end_time']));
    }
} catch (PDOException $e) {
    echo "Error fetching meeting details: " . $e->getMessage();
}
?>

<div class="modal fade" id="viewModal<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 bold" id="exampleModalLabel">Viewing Subject: <?php echo htmlspecialchars($subject['name']); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label bold">Subject Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($subject['name']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label bold">Subject Code</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($subject['code']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label bold">Semester</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($subject['semester']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label bold">Meeting Days and Times</label>
                    <textarea class="form-control" rows="3" readonly><?php echo implode("\n", $meetingDetails); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


        <!-- Edit Subject Modal -->
        <div class="modal fade" id="editModal<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Subject: <?php echo htmlspecialchars($subject['name']); ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editSubjectForm<?php echo $subject['id']; ?>" method="POST" action="processes/admin/subjects/edit.php?id=<?php echo $subject['id'] ?>">
                            <input type="hidden" id="editSubjectId<?php echo $subject['id']; ?>" name="id" value="<?php echo $subject['id']; ?>">

                            <div class="mb-3">
                                <label for="editSubjectName<?php echo $subject['id']; ?>" class="form-label fw-bold">Subject Name</label>
                                <input type="text" class="form-control" id="editSubjectName<?php echo $subject['id']; ?>" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="editSubjectCode<?php echo $subject['id']; ?>" class="form-label fw-bold">Subject Code</label>
                                <input type="text" class="form-control" id="editSubjectCode<?php echo $subject['id']; ?>" name="code" value="<?php echo htmlspecialchars($subject['code']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="editClass<?php echo $subject['id']; ?>" class="form-label fw-bold">Select Class</label>
                                <select class="form-select" id="editClass<?php echo $subject['id']; ?>" name="class">
                                    <?php
                                    $classes = [
                                        'Department of Information Technology' => [
                                            'BSIT-1A',
                                            'BSIT-1B',
                                            'BSIT-2A',
                                            'BSIT-2B',
                                            'BSIT-3A',
                                            'BSIT-3B',
                                            'BSIT-4A',
                                            'BSIT-4B'
                                        ],
                                        'Department of Computer Science' => [
                                            'BSCS-1A',
                                            'BSCS-1B',
                                            'BSCS-2A',
                                            'BSCS-2B',
                                            'BSCS-3A',
                                            'BSCS-3B',
                                            'BSCS-4A',
                                            'BSCS-4B'
                                        ]
                                    ];

                                    foreach ($classes as $category => $classGroup) {
                                        echo "<optgroup label=\"" . htmlspecialchars($category) . "\">";
                                        foreach ($classGroup as $class) {
                                            $selected = ($subject['class'] === $class) ? 'selected' : '';
                                            echo "<option value=\"" . htmlspecialchars($class) . "\" $selected>" . htmlspecialchars($class) . "</option>";
                                        }
                                        echo "</optgroup>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label fw-bold">Subject Type</label>
                                <select class="form-select" name="type" id="type" required>
                                    <option value="" disabled>Select class type below</option>
                                    <option value="Lecture" <?php echo ($subject['type'] === 'Lecture') ? 'selected' : ''; ?>>Lecture</option>
                                    <option value="Laboratory" <?php echo ($subject['type'] === 'Laboratory') ? 'selected' : ''; ?>>Laboratory</option>
                                </select>
                            </div>

                            <div class="mb-3">

                                <?php
                                // Fetch all selected meeting days for the subject

                                $query = "SELECT meeting_days FROM subjects_schedules WHERE subject_id = :subjectId";
                                $stmt = $pdo->prepare($query);
                                $stmt->bindParam(':subjectId', $modalId, PDO::PARAM_INT);
                                $stmt->execute();
                                $selectedDays = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch meeting days as a flat array

                                // Define all possible days to render the checkboxes
                                $allDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                                ?>

                                <div class="mb-3">
                                    <label for="meetingDays" class="form-label bold">Meeting Days:</label>
                                    <div id="meetingDays">
                                        <?php foreach ($allDays as $day): ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    name="meeting_days[]"
                                                    value="<?php echo $day; ?>"
                                                    <?php echo in_array($day, $selectedDays) ? 'checked' : ''; ?>>
                                                <label class="form-check-label"><?php echo $day; ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>


                            <?php
                            $selectedStartTime = '';
                            $selectedEndTime = '';

                            // Fetch selected start and end times from the database for the current subject
                            try {
                                $stmt = $pdo->prepare("SELECT start_time, end_time FROM subjects_schedules WHERE subject_id = :subject_id LIMIT 1");
                                $stmt->bindParam(':subject_id', $modalId, PDO::PARAM_INT); // assuming $subjectId is set to the current subject's ID
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($result) {
                                    $selectedStartTime = htmlspecialchars($result['start_time']);
                                    $selectedEndTime = htmlspecialchars($result['end_time']);
                                }
                            } catch (PDOException $e) {
                                echo "Error fetching times: " . $e->getMessage();
                            }
                            ?>

                            <!-- Start Time Input -->
                            <div class="mb-3">
                                <label for="startTime" class="form-label bold">Start Time:</label>
                                <input type="time" class="form-control" name="start_time" value="<?php echo $selectedStartTime; ?>" required>
                            </div>

                            <!-- End Time Input -->
                            <div class="mb-3">
                                <label for="endTime" class="form-label bold">End Time:</label>
                                <input type="time" class="form-control" name="end_time" value="<?php echo $selectedEndTime; ?>" required>
                            </div>



                            <div class="mb-3">
                                <label for="editTeacher<?php echo $subject['id']; ?>" class="form-label fw-bold">Select Teacher</label>
                                <select class="form-select" id="editTeacher<?php echo $subject['id']; ?>" name="teacher">
                                    <?php
                                    require 'processes/server/conn.php';
                                    foreach ($staffMembers as $staff) {
                                        $selected = ($subject['teacher'] == $staff['fullName']) ? 'selected' : '';
                                        echo "<option value=\"" . htmlspecialchars($staff['fullName']) . "\" $selected>" . htmlspecialchars($staff['fullName']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editSemester<?php echo $subject['id']; ?>" class="form-label fw-bold">Select Semester</label>
                                <select class="form-select" id="editSemester<?php echo $subject['id']; ?>" name="semester">
                                    <?php if (!empty($semesters)): ?>
                                        <?php foreach ($semesters as $semester): ?>
                                            <option value="<?php echo htmlspecialchars($semester['name']); ?>" <?php echo ($subject['semester'] === $semester['name']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($semester['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="" disabled>No semesters available</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


    <?php
    }
    ?>

    <script>
        var subjectData = <?php echo $subjectDataJSON; ?>;

        if (subjectData.length > 0) {
            $('#classes').show();

            var table = $('#classes').DataTable({
                responsive: true,
                data: subjectData.map(row => {
                    row.actions = `
                <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#viewModal${row.id}">
                    <i class="bi bi-eye"></i> View
                </button>
                <button type="button" class="btn btn-warning edit-btn" data-bs-toggle="modal" data-bs-target="#editModal${row.id}">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button type="button" class="btn btn-danger delete-btn" data-id="${row.id}">
                    <i class="bi bi-trash"></i> Delete
                </button>`;
                    return [
                        `${row.name}`,
                        row.type,
                        row.code,
                        row.schedule, // Now including the schedule
                        row.semester,
                        row.course,
                        row.year_level,
                        row.actions
                    ];
                }),
                columns: [{
                        title: 'Subject Name'
                    },
                    {
                        title: 'Subject Type'
                    },
                    {
                        title: 'Subject Code'
                    },
                    {
                        title: 'Subject Schedule'
                    },
                    {
                        title: 'Semester'
                    },
                    {
                        title: 'Course'
                    },
                    {
                        title: 'Year Level'
                    },
                    {
                        title: 'Actions',
                        orderable: false
                    }
                ]
            });

            // Ensure the table layout is adjusted properly
            table.columns.adjust().responsive.recalc();

            $(document).on('click', '.delete-btn', function() {
                var subjectId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'processes/admin/subjects/delete.php?id=' + subjectId;
                    }
                });
            });
        } else {
            $('#noDataMessage').show();
            $('#table-footer').hide();
        }
    </script>




    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            document.getElementById('sidebarContainer').classList.toggle('collapsed');
        });
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        function getTime() {
            const now = new Date();
            const newTime = now.toLocaleString();
            console.log(newTime);
            document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
        }

        setInterval(getTime, 100);

        $(document).ready(function() {
            var table = $('#classes').DataTable();

            // Create input fields in the footer for search functionality
            $('#classes tfoot th').each(function() {
                var title = $(this).text();
                if (title === 'Subject Type') { // Assuming 'Subject Type' is the header name
                    $(this).html(`
                <select class="selector">
                    <option value="">All</option>
                    <option value="lecture">Lecture</option>
                    <option value="laboratory">Laboratory</option>
                </select>
            `);
                } else {
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                }
            });

            // Apply search functionality for the input fields
            table.columns().every(function() {
                var that = this;

                // Handle text input for all columns except 'Subject Type'
                $('input', this.footer()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });

                // Handle the dropdown for the 'Subject Type'
                $('select', this.footer()).on('change', function() {
                    var selectedValue = $(this).val();
                    if (that.search() !== selectedValue) {
                        that
                            .search(selectedValue ? '^' + selectedValue + '$' : '', true, false)
                            .draw();
                    }
                });
            });
        });



        $(document).ready(function() {
            var subjects = {

                'BSIT-4A': [{
                        value: 'Software Engineering',
                        text: 'Software Engineering'
                    },
                    {
                        value: 'Capstone Project and Research I',
                        text: 'Capstone Project and Research I'
                    },
                    {
                        value: 'Networks',
                        text: 'Networks'
                    }
                ],
                'BSIT-4B': [{
                        value: 'Capstone Project and Research I',
                        text: 'Capstone Project and Research I'
                    },
                    {
                        value: 'Software Engineering',
                        text: 'Software Engineering'
                    },
                    {
                        value: 'Networks',
                        text: 'Networks'
                    }
                ]
            };

            var assignedSubjects = {
                'BSIT-4A': [
                    'Software Engineering',
                ],
                'BSIT-4B': [
                    'Capstone Project and Research I',

                ]
            };


            $('#class-select').change(function() {
                var classSelected = $(this).val();
                var subjectSelect = $('#subject-select');
                var assignedSubjectsContainer = $('#assigned-subjects-container');

                subjectSelect.empty();
                assignedSubjectsContainer.empty();

                if (classSelected !== 'Select a class') {

                    $.each(subjects[classSelected], function(index, subject) {
                        subjectSelect.append($('<option>', {
                            value: subject.value,
                            text: subject.text
                        }));
                    });


                    $.each(assignedSubjects[classSelected], function(index, subject) {
                        assignedSubjectsContainer.append(
                            '<div class="col"><small>' + subject + '</small></div>' +
                            '<div class="col"><a href="#" class="remove-subject">Remove</a></div>'
                        );
                    });
                } else {
                    subjectSelect.append($('<option>', {
                        text: 'Select a class first'
                    }));

                    assignedSubjectsContainer.append('<div class="col"><small>No subjects assigned</small></div>');
                }
            });


            $('#subject-select').change(function() {
                var subjectSelected = $(this).val();
                var assignedSubjectsContainer = $('#assigned-subjects-container');

                var exists = assignedSubjectsContainer.find('.col:contains("' + subjectSelected + '")').length;
                if (!exists && subjectSelected !== 'Select a class first') {
                    assignedSubjectsContainer.append(
                        '<div class="col"><small>' + subjectSelected + '</small></div>' +
                        '<div class="col"><a href="#" class="remove-subject">Remove</a></div>'
                    );
                }
            });


            $(document).on('click', '.remove-subject', function(e) {
                e.preventDefault();
                $(this).closest('.col').prev('.col').remove();
                $(this).closest('.col').remove();
            });
        });


        document.getElementById('messageForm').addEventListener('submit', function(event) {
            event.preventDefault();


            var messageText = document.getElementById('messageInput').value;


            if (messageText.trim() !== '') {
                var chatBody = document.getElementById('chatBody');


                var newMessage = document.createElement('div');
                newMessage.className = 'row receiver';
                newMessage.innerHTML = `
      
            <div class="col">
              <div class="message">
                 <span>${messageText}</span>
              </div>
              <i class="bi bi-person"></i>
            </div>
      
      
      `;


                chatBody.appendChild(newMessage);


                document.getElementById('messageInput').value = '';


                chatBody.scrollTop = chatBody.scrollHeight;

            }
        });
    </script>

</html>

<?php
include('processes/server/alerts.php');
?>