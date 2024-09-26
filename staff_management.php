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
        href="external/css/admin_staffManagement.css"
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
                                        Teacher Management</p>
                                </h3>

                                <div class="ms-auto" aria-hidden="true">
                                    <img
                                        src="external/svgs/undraw_favorite_gb6n.svg"
                                        class=" small-picture img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <h5>Teacher Account List</h5>
                            <div class="ms-auto" aria-hidden="true">
                                <button type="button" class="btn btn-csms"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addTeacherModal"><i
                                        class="bi bi-pencil-square"></i>
                                    Add a Teacher</button>

                            </div>

                        </div>
                    </div>

                    <br>

                    <?php
                    $sql = "SELECT * FROM staff_accounts";
                    $stmt = $pdo->query($sql);


                    if ($stmt->rowCount() > 0) {
                        echo '<table id="classes">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';


                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            echo '<tr>
                <td>' . htmlspecialchars($row['fullName']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . htmlspecialchars($row['department']) . '</td>
                <td>' . htmlspecialchars($row['class']) . '</td>
                <td>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#viewModal' . $row['id'] . '" class="btn btn-success">
                        <i class="bi bi-eye"></i> View
                    </button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal' . $row['id'] . '" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button type="button" onclick="deleteModal(' . $row['id'] . ')" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            </tr>';
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<h1 class="text-center">No teachers found.</h1>';
                    }
                    ?>
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
                <form>
                    <input type="text" name="search" placeholder="Input person here" required class="input-search">
                </form>
                <br>
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

<div class="modal fade" id="addTeacherModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add a new Teacher</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="processes/admin/staff/add.php">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-control" name="department" id="department" required>
                            <option selected>Select a department</option>
                            <option value="Department of Information Technology">Department of Information Technology</option>
                            <option value="Department of Computer Science">Department of Computer Science</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" style="width: 100%; display: inline !important;">
                        <span style="position: absolute; display: inline; right: 5%; margin-top: 5px !important; vertical-align: middle">
                            <i class="bi bi-eye-slash-fill" id="togglerPassword"></i>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" style="width: 100%; display: inline !important;">
                        <span style="position: absolute; display: inline; right: 5%; margin-top: 5px !important; vertical-align: middle">
                            <i class="bi bi-eye-slash-fill" id="togglerConfirmPassword"></i>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-select" name="class" required>
                            <option disabled selected>Select a class</option>
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
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number">

                    </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-csms" value="Update">
                <button type="button" class="btn btn-csms" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const departmentSelect = document.getElementById('department');
    const classSelect = document.getElementById('class');

    const classes = {
        'Department of Information Technology': ['BSIT-1A', 'BSIT-1B', 'BSIT-2A', 'BSIT-3A', 'BSIT-4A', 'BSIT-4B'],
        'Department of Computer Science': ['BSCS-1A', 'BSCS-1B', 'BSCS-2A', 'BSCS-3A', 'BSCS-4A', 'BSCS-4B']
    };

    departmentSelect.addEventListener('change', function() {

        classSelect.innerHTML = '<option>Select a class</option>';


        const selectedDepartment = departmentSelect.value;


        if (classes[selectedDepartment]) {
            classes[selectedDepartment].forEach(function(className) {
                const option = document.createElement('option');
                option.value = className;
                option.text = className;
                classSelect.appendChild(option);
            });
        }
    });
</script>
<?php
$sql = "SELECT * FROM staff_accounts";
$stmt = $pdo->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Pre-select the department and class if they exist in the record
    $selectedDepartment = $row['department'];
    $selectedClass = $row['class'];

    echo '
    <div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Teacher: ' . htmlspecialchars($row['fullName']) . '</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="processes/admin/staff/edit.php?id=' . $row['id'] . '">
                        <div class="mb-3">
                            <label for="full_name' . $row['id'] . '" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name' . $row['id'] . '" name="full_name" value="' . htmlspecialchars($row['fullName']) . '">
                        </div>
                        <div class="mb-3">
                            <label for="email' . $row['id'] . '" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email' . $row['id'] . '" name="email" value="' . htmlspecialchars($row['email']) . '">
                        </div>
                        <div class="mb-3">
                            <label for="department' . $row['id'] . '" class="form-label">Department</label>
                            <select class="form-control" name="department" id="department-' . $row['id'] . '" required>
                                <option>Select a department</option>
                                <option value="Department of Information Technology"' . ($selectedDepartment == 'Department of Information Technology' ? ' selected' : '') . '>Department of Information Technology</option>
                                <option value="Department of Computer Science"' . ($selectedDepartment == 'Department of Computer Science' ? ' selected' : '') . '>Department of Computer Science</option>
                            </select>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password' . $row['id'] . '" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password' . $row['id'] . '" name="password">
                            <i class="bi bi-eye-slash-fill toggler-icon" id="togglerPassword' . $row['id'] . '" style="position: absolute; top: 70%; right: 10px; cursor: pointer; transform: translateY(-50%);"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="confirm_password' . $row['id'] . '" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password' . $row['id'] . '" name="confirm_password">
                            <i class="bi bi-eye-slash-fill toggler-icon" id="togglerConfirmPassword' . $row['id'] . '" style="position: absolute; top: 70%; right: 10px; cursor: pointer; transform: translateY(-50%);"></i>
                        </div>
                        <div class="mb-3">
                            <label for="class' . $row['id'] . '" class="form-label">Class</label>
                            <select class="form-control" name="class" id="class-' . $row['id'] . '">
                                <option disabled selected>Select a class</option>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>';

    // JavaScript for handling class selection based on department
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        
            const togglerPassword = document.querySelector('#togglerPassword" . $row['id'] . "');
            const password = document.querySelector('#password" . $row['id'] . "');
            togglerPassword.addEventListener('click', () => {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                togglerPassword.classList.toggle('bi-eye');
                togglerPassword.classList.toggle('bi-eye-slash-fill');
            });

            const togglerConfirmPassword = document.querySelector('#togglerConfirmPassword" . $row['id'] . "');
            const confirmPassword = document.querySelector('#confirm_password" . $row['id'] . "');
            togglerConfirmPassword.addEventListener('click', () => {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                togglerConfirmPassword.classList.toggle('bi-eye');
                togglerConfirmPassword.classList.toggle('bi-eye-slash-fill');
            });

          
            const departmentSelectNew = document.getElementById('department-" . $row['id'] . "');
            const classSelectNew = document.getElementById('class-" . $row['id'] . "');

            const classesNew = {
                'Department of Information Technology': ['BSIT-1A', 'BSIT-1B', 'BSIT-2A', 'BSIT-3A', 'BSIT-4A', 'BSIT-4B'],
                'Department of Computer Science': ['BSCS-1A', 'BSCS-1B', 'BSCS-2A', 'BSCS-3A', 'BSCS-4A', 'BSCS-4B']
            };

      
            const selectedDepartmentNew = '" . $selectedDepartment . "';
            const selectedClassNew = '" . $selectedClass . "';
            
            if (selectedDepartmentNew && classesNew[selectedDepartmentNew]) {
                classesNew[selectedDepartmentNew].forEach(function(className) {
                    const option = document.createElement('option');
                    option.value = className;
                    option.text = className;
                    if (className === selectedClassNew) {
                        option.selected = true;
                    }
                    classSelectNew.appendChild(option);
                });
            }

       
            departmentSelectNew.addEventListener('change', function() {
                classSelectNew.innerHTML = '<option>Select a class</option>';

                const selectedDepartment = departmentSelectNew.value;

                if (classesNew[selectedDepartment]) {
                    classesNew[selectedDepartment].forEach(function(className) {
                        const option = document.createElement('option');
                        option.value = className;
                        option.text = className;
                        classSelectNew.appendChild(option);
                    });
                }
            });
        });
    </script>";
}
?>


<?php
$sql = "SELECT * FROM staff_accounts";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '
    <div class="modal fade" id="viewModal' . $row['id'] . '" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Teacher Information: ' . htmlspecialchars($row['fullName']) . '</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" value="' . htmlspecialchars($row['fullName']) . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="' . htmlspecialchars($row['email']) . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" value="' . htmlspecialchars($row['department']) . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <input type="text" class="form-control" id="class" value="' . htmlspecialchars($row['class']) . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Date Created</label>
                        <input type="text" class="form-control" id="created_at" value="' . htmlspecialchars($row['date_created']) . '" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>';
}
?>

<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        document.getElementById('sidebarContainer').classList.toggle('collapsed');
    });


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
        $('#classes').DataTable();
    });

    $(document).ready(function() {
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

        // Update available classes based on selected semester
        semesterSelect.addEventListener('change', function() {
            const selectedSemester = semesterSelect.value;

            // Clear previous options
            availableClassesSelect.innerHTML = '<option selected disabled>Select a Class</option>';

            // Add new options based on selected semester
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

        // Show/hide assigned classes section based on selections
        function checkSelections() {
            if (semesterSelect.value !== 'Select a Semester' && availableClassesSelect.value !== 'Select a Class') {
                // Filter and show only relevant rows
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

        // Remove class
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                row.parentNode.removeChild(row);
                checkSelections();
            });
        });

        // Also check the selections when the class dropdown changes
        availableClassesSelect.addEventListener('change', checkSelections);
    });

    function hidePasswordsOnLoad() {
        var passwordCells = document.querySelectorAll('span[data-password]');
        passwordCells.forEach(function(passwordCell) {
            var password = passwordCell.getAttribute('data-password');
            passwordCell.textContent = '*'.repeat(password.length);
            passwordCell.setAttribute('data-hidden', 'true');
        });
    }

    function togglePassword(passwordId, button) {
        var passwordCell = document.getElementById(passwordId);
        var isHidden = passwordCell.getAttribute('data-hidden') === 'true';

        if (isHidden) {
            passwordCell.textContent = passwordCell.getAttribute('data-password');
            button.textContent = "Hide";
            passwordCell.setAttribute('data-hidden', 'false');
        } else {
            passwordCell.textContent = '*'.repeat(passwordCell.getAttribute('data-password').length);
            button.textContent = "Show";
            passwordCell.setAttribute('data-hidden', 'true');
        }
    }

    // Hide passwords when the page loads
    window.onload = hidePasswordsOnLoad;

    const togglerPassword = document
        .querySelector('#togglerPassword');
    const password = document.querySelector('#password');
    togglerPassword.addEventListener('click', () => {
        const type = password
            .getAttribute('type') === 'password' ?
            'text' : 'password';
        password.setAttribute('type', type);
        togglerPassword.classList.toggle('bi-eye');
    });

    const togglerConfirmPassword = document.querySelector('#togglerConfirmPassword');
    const confirmPassword = document.querySelector('#confirm_password');
    togglerConfirmPassword.addEventListener('click', () => {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        togglerConfirmPassword.classList.toggle('bi-eye');
        togglerConfirmPassword.classList.toggle('bi-eye-slash');
    });


    function deleteModal(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "processes/admin/staff/delete.php?id=" + id;
            }
        });
    }
</script>

<script>
    document.getElementById('messageForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get the message from the textarea
        var messageText = document.getElementById('messageInput').value;

        // If the message is not empty, append it to the chat
        if (messageText.trim() !== '') {
            var chatBody = document.getElementById('chatBody');

            // Create the new message element
            var newMessage = document.createElement('div');
            newMessage.className = 'row receiver'; // Set it as a sender message
            newMessage.innerHTML = `
      
            <div class="col">
              <div class="message">
                 <span>${messageText}</span>
              </div>
              <i class="bi bi-person"></i>
            </div>
      
      
      `;

            // Append the new message to the chat body
            chatBody.appendChild(newMessage);

            // Clear the textarea
            document.getElementById('messageInput').value = '';

            // Scroll to the bottom of the chat
            chatBody.scrollTop = chatBody.scrollHeight;

        }
    });
</script>

</html>

<?php include('processes/server/alerts.php') ?>