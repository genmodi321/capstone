<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  $_SESSION['STATUS'] = "ADMIN_NOT_LOGGED_IN";
  header("Location: admin_login_page.php");
}
include('processes/server/conn.php');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WMSU - CCS | Comprehensive Student Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link
        href="external/css/admin_subjectManagement.css"
        rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32"
        href="external/img/favicon-32x32.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script
        src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script src="vendor/datatables/dataTables.rowsGroup.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<style>
    table.dataTable {
        font-size: 12px;
    }

    td {
        text-align: center;
        vertical-align: middle;
    }

    .btn-csms {
        background-color: #709775;
        color: white;
    }
</style>

<?php
include 'processes/server/conn.php';
$query = "SELECT id, name, code, class, teacher, semester FROM subjects";
$result = $pdo->query($query);
$subjectData = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $subjectData[] = [
        'id' => htmlspecialchars(($row['id'])),
        'name' => htmlspecialchars($row['name']),
        'code' => htmlspecialchars($row['code']),
        'class' => htmlspecialchars($row['class']),
        'teacher' => htmlspecialchars($row['teacher']),
        'semester' => htmlspecialchars($row['semester']),
        'actions' => '' 
    ];
}
$subjectDataJSON = json_encode($subjectData);
?>


<body>
    <div class="container-fluid whole-container">
        <div class="row">
            <div class="sidebar-container" id="sidebarContainer">
                <div class="sidebar-content text-center">
                    <small class="c-white" id="currentTime"> </small>

                    <img src="external/img/ccs_logo-removebg-preview.png" class="img-fluid logo space-sm">
                    <h4 class="bold c-white ">Welcome, Admin!</h4>
                    
                    <div class="navigation-links" style="text-align: left;">
                        <span><i class="bi bi-house"></i> Home</span>
                        <a href="dashboard.php">
                            <p><i class="bi bi-kanban"></i> Index</p>
                        </a>
                        <hr>
                        <span><i class="bi bi-menu-button-wide"></i> Management</span>
                        <a href="class_management.php">
                            <p><i class="bi bi-book"></i> Class Management</p>
                        </a>
                        <a href="staff_management.php">
                            <p><i class="bi bi-person-square"></i> Teacher Management</p>
                        </a>
                        <a href="subject_management.php">
                            <p><i class="bi bi-journals"></i> Subject Management</p>
                        </a>
                        <a href="semester_management.php">
                            <p><i class="bi bi-calendar-event"></i> Semester Management</p>
                        </a>
                        <hr>
                        <a href="admin_management.php">
                            <p><i class="bi bi-file-person-fill"></i> Admin User</p>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col">

                <div
                    class="container-fluid d-flex navbar navbar-expand-lg">
                    <a class="navbar-brand" href="#" type="button" id="toggleButton">
                        <img
                            src="external/img/ccs_logo-removebg-preview.png"
                            class="img-fluid small-logo">
                    </a>
                    <div class="mx-auto c-white">
                        Comprehensive Student Management System
                    </div>
                    <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse"
                        id="navbarSupportedContent">
                        <div class="ms-auto">
                            <span class="ms-auto">
                                <a href
                                    class="nav-link-spand position-relative "
                                    data-bs-toggle="modal"
                                    data-bs-target="#messageModal">

                                    <i
                                        class="bi bi-chat-dots iconics"></i>
                                    <span
                                        class="position-absolute 
                                            top-0 start-50 translate-middle p-2 
                                            bg-danger border border-light rounded-circle">

                                    </span>
                                </a>
                                <a
                                    class="nav-link-span position-relative"><i
                                        class="bi bi-bell iconics"
                                        data-bs-toggle="modal"
                                        data-bs-target="#notificationModal"></i>

                                    <span
                                        class="position-absolute 
                                            top-0 start-50 translate-middle p-2 
                                            bg-danger border border-light rounded-circle">

                                    </span>

                                </a>
                                <a href="processes/admin/account/logout.php " class="nav-link-span" style="color: white !important; border: 1px solid white;
                border-radius: 20px; padding: 5px;"> Logout</a>

                            </span>

                        </div>
                    </div>
                </div>

                <div class="container-fluid actual-content">
                    <div class="container wd-75">
                        <div class="welcome-container">

                            <div class="d-flex align-items-center">
                                <h3>Welcome to your Dashboard!

                                    <p class="fs-small mt-10">Welcome back!
                                        Here's
                                        to another day of making a
                                        difference in our students'
                                        lives.</p>

                                    <p class="fs-small mt-10"> <a
                                            href="dashboard.php"
                                            class="nav-ham-link">Home</a> /
                                        Subject Management</p>
                                </h3>

                                <div class="ms-auto" aria-hidden="true">
                                    <img
                                        src="external/svgs/undraw_favorite_gb6n.svg"
                                        class=" small-picture img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <h5>Subject List</h5>
                            <div class="ms-auto" aria-hidden="true">
                                <button type="button" class="btn btn-csms"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createSubjectModal"><i
                                        class="bi bi-pencil-square"></i>
                                    Create Subject</button>

                                <div class="dropdown-menu"
                                    style="padding: 10px;">
                                    <small>Assigned Classes</small>
                                    <select class="form-select" id="class-select">
                                        <option selected>Select a class</option>
                                        <option value="BSIT-4A">BSIT - 4A</option>
                                        <option value="BSIT-4B">BSIT - 4B</option>
                                    </select>
                                    <small>Available Subject List</small>
                                    <select class="form-select"
                                        id="subject-select">
                                        <option selected>Select a subject
                                        </option>

                                    </select>
                                    <div>
                                        <div id="assigned-subject-list">
                                            <small>Assigned Subject List</small>
                                            <div class="row text-center" id="assigned-subjects-container">
                                                <div class="col">
                                                    <small id="assigned-subject">No subjects assigned</small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <br>
                    <h1 id="noDataMessage" style="display:none; text-align:center">No subjects added, yet!</h1>
                    <table id="classes" class="display" style="width:100%">
                        <tfoot id="table-footer">
                            <tr>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Semester</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        </div>
    </div>

</body>

<div class="modal fade" id="notificationModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"
                    id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notificationModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Notifications</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex align-items-center">
                    <span>Notifications</span>
                    <div class=" ms-auto" aria-hidden="true"><a href
                            class="nav-ham-link"> View All</a> | <a href
                            class="nav-ham-link"> Read All</a></div>
                </div>

                <br>

                <div class="row ">
                    <div class="col-sm-2 text-center">
                        <h1><i class="bi bi-bell-fill"></i></h1>
                    </div>
                    <div class="col">
                        <h5>You have received a new notification!</h5>
                        <p>Test notification!</p>
                    </div>
                </div>

                <br>

                <div class="row ">
                    <div class="col-sm-2 text-center">
                        <h1><i class="bi bi-bell-fill"></i></h1>
                    </div>
                    <div class="col">
                        <h5>You have received a new notification!</h5>
                        <p>Test notification!</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="messageModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chats</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row msg align-items-center" data-bs-target="#actualMessageModal" data-bs-toggle="modal">
                    <div class="col-sm-3 text-center" style="border-right: 1px solid black;">
                        <h1><i class="bi bi-person-fill"></i></h1>
                        <span>Jason Catadman</span>
                    </div>
                    <div class="col">
                        <p><em>You: Sure sir Catadman. I will work on that right now.</em></p>
                    </div>
                </div>

                <br>

                <div class="row unread msg align-items-center">
                    <div class="col-sm-3 text-center" style="border-right: 1px solid black;">
                        <h1><i class="bi bi-person-fill"></i></h1>
                        <span>Ceed Lorenzo</span>
                    </div>
                    <div class="col">
                        <p><em>Lorenzo: Good afternoon sir, ask ko lang if available po si...</em></p>
                    </div>
                </div>



            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="actualMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chats</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="chatBody">
                <div class="time text-center grey">
                    2:09 PM - 8/11/2024
                </div>
                <br>
                <div class="row sender">
                    <div class="col">
                        <i class="bi bi-person-fill"></i>
                        <div class="message">
                            <span>Hi, this is Jason Catadman. I'd like to switch from Web Technologies to Software Engineering, thanks!</span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row receiver">
                    <div class="col">
                        <div class="message">
                            <span>Sure sir Catadman. I will work on that right now.</span>
                        </div>
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <br>
            </div>

            <div class="modal-footer">
                <form id="messageForm">
                    <div class="d-flex align-items-center">
                        <textarea id="messageInput" cols="45"></textarea>
                        <div class="ms-auto" aria-hidden="true" style="margin-left: 10px">
                            <input type="submit" value="Send">
                        </div>
                    </div>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="notesModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"
                    id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="remindersModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"
                    id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createSubjectModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"
                    id="exampleModalLabel">Create a Class</h1>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="processes/admin/subjects/add.php">
                    <div class="mb-3">
                        <label for="class" class="form-label">Subject Name </label>
                        <input type="text" class="form-control"
                            id="subjectName" name="subjectName" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Subject Code </label>
                        <input type="text" class="form-control"
                            id="subjectCode" name="subjectCode" required>
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Select
                            Class: </label>
                        <select class="form-select" name="class" required>
                            <option selected>Select a class</option>
                            <optgroup label="Information Technology Department"></optgroup>
                            <option value="BSIT-1A">BSIT-1A</option>
                            <option value="BSIT-1B">BSIT-1B</option>
                            <option value="BSIT-2A">BSIT-2A</option>
                            <option value="BSIT-2B">BSIT-2B</option>
                            <option value="BSIT-3A">BSIT-3A</option>
                            <option value="BSIT-3B">BSIT-3B</option>
                            <option value="BSIT-4A">BSIT-4A</option>
                            <option value="BSIT-4B">BSIT-4B</option>
                            <optgroup label="Computer Science Department"></optgroup>
                            <option value="BSCS-1A">BSCS-1A</option>
                            <option value="BSCS-1B">BSCS-1B</option>
                            <option value="BSCS-2A">BSCS-2A</option>
                            <option value="BSCS-2B">BSCS-2B</option>
                            <option value="BSCS-3A">BSCS-3A</option>
                            <option value="BSCS-3B">BSCS-3B</option>
                            <option value="BSCS-4A">BSCS-4A</option>
                            <option value="BSCS-4B">BSCS-4B</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="teacher" class="form-label">Select
                            Teacher: </label>
                        <select class="form-select" name="teacher" required>
                            <option> Select a teacher below</option>
                            <?php
                            require 'processes/server/conn.php';
                            $sql = "SELECT id, fullName FROM staff_accounts";
                            $stmt = $pdo->query($sql);
                            if ($stmt->rowCount() > 0) {

                                while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    echo '<option value="' . htmlspecialchars($teacher["fullName"]) . '">' . htmlspecialchars($teacher["fullName"]) . '</option>';
                                }
                            } else {
                                echo '<option>There is no staff added yet!</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Select
                            Semester: </label>
                            <?php
$semesters = [];
try {
    $stmt = $pdo->query("SELECT name FROM semester");
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

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-csms"
                    value="Save Changes">
                <button type="button" class="btn btn-csms"
                    data-bs-dismiss="modal">Close</button>
                </form>
            </div>
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
    <div class="modal fade" id="viewModal<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Viewing Subject: <?php echo htmlspecialchars($subject['name']); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label bold">Subject Name</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['name']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label bold ">Subject Code</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['code']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label bold">Class</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['class']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label bold">Teacher</label>
                        <p class="form-control-plaintext">
                            <?php
                            echo $subject['teacher'];
                            ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label bold">Semester</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['semester']); ?></p>
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
                            <label for="editSubjectName<?php echo $subject['id']; ?>" class="form-label">Subject Name</label>
                            <input type="text" class="form-control" id="editSubjectName<?php echo $subject['id']; ?>" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSubjectCode<?php echo $subject['id']; ?>" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="editSubjectCode<?php echo $subject['id']; ?>" name="code" value="<?php echo htmlspecialchars($subject['code']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="editClass<?php echo $subject['id']; ?>" class="form-label">Select Class</label>
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
                                   
                                    echo "<optgroup label=\"$category\">";

                               
                                    foreach ($classGroup as $class) {
                                        $selected = ($subject['class'] === $class) ? 'selected' : '';
                                        echo "<option value=\"$class\" $selected>$class</option>";
                                    }

                                    echo "</optgroup>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="editTeacher<?php echo $subject['id']; ?>" class="form-label">Select Teacher</label>
                            <select class="form-select" id="editTeacher<?php echo $subject['id']; ?>" name="teacher">
                                <?php
                                require 'processes/server/conn.php';
                                foreach ($staffMembers as $staff) {
                                    $selected = ($subject['teacher'] == $staff['fullName']) ? 'selected' : '';
                                    echo "<option value=\"{$staff['fullName']}\" $selected>{$staff['fullName']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editSemester<?php echo $subject['id']; ?>" class="form-label">Select Semester</label>
                            <select class="form-select" id="editSemester<?php echo $subject['id']; ?>" name="semester">
                                <option value="First Semester" <?php echo $subject['semester'] === 'First Semester' ? 'selected' : ''; ?>>First Semester</option>
                                <option value="Second Semester" <?php echo $subject['semester'] === 'Second Semester' ? 'selected' : ''; ?>>Second Semester</option>
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
            data: subjectData.map(row => {
          
                row.actions = `<button type="button" class="btn btn-success view-btn" data-bs-toggle="modal" data-bs-target="#viewModal${row.id}">
                              <i class="bi bi-eye"></i> View
                          </button>
            <button type="button" class="btn btn-warning edit-btn" data-bs-toggle="modal" data-bs-target="#editModal${row.id}">
                              <i class="bi bi-pencil"></i> Edit
                          </button>
                          <button type="button" class="btn btn-danger delete-btn" data-id="${row.id}">
                              <i class="bi bi-trash"></i> Delete
                          </button>`;
                return [row.name, row.code, row.class, row.teacher, row.semester, row.actions];
            }),
            columns: [{
                    title: 'Subject Name'
                }, 
                {
                    title: 'Subject Code'
                }, 
                {
                    title: 'Class'
                }, 
                {
                    name: 'teacher',
                    title: 'Teacher'
                }, 
                {
                    title: 'Semester'
                }, 
                {
                    title: 'Actions',
                    orderable: false
                } 
            ],
            rowsGroup: [
                'teacher:name' 
            ]
        });

  
        table.rowsgroup.update();

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

        $('#classes tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        table.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
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