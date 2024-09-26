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
        href="external/css/admin_semesterManagement.css"
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
                    <a class="navbar-brand" href="#" id="toggleButton">
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
                                            href="index.html"
                                            class="nav-ham-link">Home</a> /
                                        Semester Management</p>
                                </h3>

                                <div class="ms-auto" aria-hidden="true">
                                    <img
                                        src="external/svgs/undraw_favorite_gb6n.svg"
                                        class=" small-picture img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <h5>Semester List</h5>
                            <div class="ms-auto" aria-hidden="true">
                                <button type="button" class="btn btn-csms"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createSemesterModal"><i
                                        class="bi bi-pencil-square"></i>
                                    Create a Semester</button>
                                <button type="button" class="btn btn-csms"
                                    data-bs-toggle="modal"
                                    data-bs-target="#assignClassModal"><i
                                        class="bi bi-pencil-fill"></i>
                                    Assign a Class to a Semester</button>

                            </div>

                        </div>
                    </div>

                    <br>

                    <?php
                    $sql = "SELECT * FROM semester";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    if (empty($semesters)) {
                        echo "<h1 style='text-align:center'>No semesters available.</h5>";
                    } else {
                        echo " <table id='classes'>
                        <thead>
                            <tr>
                                <th>Semester Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";
                        foreach ($semesters as $semester) {

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($semester['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($semester['start_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($semester['end_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($semester['description']) . "</td>";
                            echo "<td>
                <button type='button' data-bs-toggle='modal' data-bs-target='#editModal{$semester['id']}' class='btn btn-warning'>
                    <i class='bi bi-pencil'></i> Edit
                </button>
                <button type='button' data-bs-toggle='modal' onclick='deleteClass({$semester['id']})' class='btn btn-danger'>
                    <i class='bi bi-trash'></i> Delete
                </button>
              </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
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

<div class="modal fade" id="createSemesterModal" tabindex="-1"
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
                <form action="processes/admin/semester/add.php" method="POST">
                    <div class="mb-3">
                        <label for="classDesc" class="form-label">Semester
                            Name</label>
                        <input type="text" class="form-control"
                            id="classDesc" name="semName">
                    </div>
                    <div class="mb-3">
                        <label for="semStartDate" class="form-label">Start
                            Date: </label>
                        <input type="date" class="form-control"
                            id="semStartDate" name="semStartDate">
                    </div>

                    <div class="mb-3">
                        <label for="semEndDate" class="form-label">End
                            Date: </label>
                        <input type="date" class="form-control"
                            id="semEndDate" name="semEndDate">
                    </div>

                    <div class="mb-3">
                        <label for="classDesc" class="form-label">Semester
                            Description</label>
                        <textarea type="text" class="form-control"
                            id="semDesc" name="semDesc"></textarea>
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

<div class="modal fade" id="assignClassModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"
                    id="exampleModalLabel">Assigning a Class to a
                    Semester</h1>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Select a Semester: </label>
                        <select class="form-select" name="semester" id="semester">
                            <option selected>Select a Semester</option>
                            <option value="First Semester">First Semester</option>
                            <option value="Second Semester">Second Semester</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="availableClasses" class="form-label">Available Classes</label>
                        <select class="form-select" name="availableClasses" id="availableClasses">
                            <option selected>Select a Class</option>
                        </select>
                    </div>

                    <div class="mb-3" id="assignedClassesContainer">
                        <label>Assigned Classes</label>
                        <table id="assignedClasses" class="display">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Subjects</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="assignedClassesBody">
                                <!-- Prepopulated classes and subjects go here -->
                                <!-- Example for First Semester -->
                                <tr data-semester="First Semester" data-class="BSIT-1A">
                                    <td>BSIT-1A</td>
                                    <td>Math 101, Programming 101, English 101</td>
                                    <td><button class="remove-btn btn btn-danger">Remove</button></td>
                                </tr>
                                <tr data-semester="First Semester" data-class="BSIT-1B">
                                    <td>BSIT-1B</td>
                                    <td>Math 101, Programming 101, English 102</td>
                                    <td><button class="remove-btn btn btn-danger">Remove</button></td>
                                </tr>
                                <tr data-semester="First Semester" data-class="BSIT-2A">
                                    <td>BSIT-2A</td>
                                    <td>Math 201, Data Structures, Operating Systems</td>
                                    <td><button class="remove-btn btn btn-danger">Remove</button></td>
                                </tr>
                                <!-- Example for Second Semester -->
                                <tr data-semester="Second Semester" data-class="BSIT-3A">
                                    <td>BSIT-3A</td>
                                    <td>Algorithms, Database Systems, Software Engineering</td>
                                    <td><button class="remove-btn btn btn-danger">Remove</button></td>
                                </tr>
                                <tr data-semester="Second Semester" data-class="BSIT-3B">
                                    <td>BSIT-3B</td>
                                    <td>Algorithms, Database Systems, Web Development</td>
                                    <td><button class="remove-btn btn btn-danger">Remove</button></td>
                                </tr>
                                <tr data-semester="Second Semester" data-class="BSIT-4A">
                                    <td>BSIT-4A</td>
                                    <td>Advanced Programming, Project Management, Ethics in IT</td>
                                    <td><button class="remove-btn btn btn-danger">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
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
$sql = "SELECT * FROM semester";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($semesters as $semester) { ?>
    <div class="modal fade" id="editModal<?php echo $semester['id'] ?>" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"
                        id="exampleModalLabel">Editing Semester: <?php echo $semester['name'] ?></h1>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="processes/admin/semester/edit.php?id=<?php echo $semester['id'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="classDesc" class="form-label">Semester
                                Name</label>
                            <input type="text" class="form-control"
                                id="classDesc" name="semName" required value="<?php echo $semester['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="semStartDate" class="form-label">Start
                                Date: </label>
                            <input type="date" class="form-control"
                                id="semStartDate" name="semStartDate" value="<?php echo $semester['start_date'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="semEndDate" class="form-label">End
                                Date: </label>
                            <input type="date" class="form-control" value="<?php echo $semester['end_date'] ?>"
                                id="semEndDate" name="semEndDate">
                        </div>

                        <div class="mb-3">
                            <label for="classDesc" class="form-label">Semester
                                Description</label>
                            <textarea type="text" class="form-control" id="semDesc" name="semDesc"><?php echo $semester['description'] ?></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>

            </form>
        </div>

    </div>
    </div>
    </div>
<?php
}
?>
<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        document.getElementById('sidebarContainer').classList.toggle('collapsed');
    });


    function deleteClass(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = 'processes/admin/semester/delete.php?id=' + id;
            }
        });
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    function getTime() {
        const now = new Date();
        const newTime = now.toLocaleString();
        console.log(newTime);
        document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
    }

    setInterval(getTime, 1000);

    $(document).ready(function() {
        $('#classes').DataTable();
        $('#assignedClasses').DataTable();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const semesterSelect = document.getElementById('semester');
        const availableClassesSelect = document.getElementById('availableClasses');
        const assignedClassesContainer = document.getElementById('assignedClassesContainer');
        const assignedClassesBody = document.getElementById('assignedClassesBody');

        const classes = {
            "First Semester": ["BSIT-1A", "BSIT-1B", "BSIT-2A"],
            "Second Semester": ["BSIT-3A", "BSIT-3B", "BSIT-4A"]
        };

        semesterSelect.addEventListener('change', function() {
            const selectedSemester = semesterSelect.value;
            availableClassesSelect.innerHTML = '<option selected disabled>Select a Class</option>';

            if (classes[selectedSemester]) {
                classes[selectedSemester].forEach(function(className) {
                    const option = document.createElement('option');
                    option.value = className;
                    option.textContent = className;
                    availableClassesSelect.appendChild(option);
                });
            }

            checkSelections();
        });

        function checkSelections() {
            if (semesterSelect.value !== 'Select a Semester' && availableClassesSelect.value !== 'Select a Class') {
                const selectedSemester = semesterSelect.value;
                const selectedClass = availableClassesSelect.value;
                let hasRelevantClasses = false;

                [...assignedClassesBody.getElementsByTagName('tr')].forEach(row => {
                    if (row.dataset.semester === selectedSemester && row.dataset.class === selectedClass) {
                        row.style.display = '';
                        hasRelevantClasses = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (hasRelevantClasses) {
                    assignedClassesContainer.style.display = 'block';
                } else {
                    assignedClassesContainer.style.display = 'none';
                }
            } else {
                assignedClassesContainer.style.display = 'none';
            }
        }

        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                row.parentNode.removeChild(row);
                checkSelections();
            });
        });

        availableClassesSelect.addEventListener('change', checkSelections);
    });
</script>

<script>
    document.getElementById('messageForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var messageText = document.getElementById('messageInput').value.trim(); // Trim spaces

        if (messageText !== '') {
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