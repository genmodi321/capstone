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
        href="external/css/admin_classManagement.css"
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
            <!-- Sidebar container with transition -->
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
                    <div class="container-fluid wd-100">
                        <div class="welcome-container">

                            <div class="d-flex align-items-center">
                                <h3>Welcome to your Dashboard!

                                    <p class="fs-small mt-10">Welcome back!
                                        Here's
                                        to another day of making a
                                        difference in our students'
                                        lives.</p>

                                    <p class="fs-small mt-10"> <a
                                            href="dashboard.html"
                                            class="nav-ham-link">Home</a> /
                                        Class Management</p>
                                </h3>

                                <div class="ms-auto" aria-hidden="true">
                                    <img
                                        src="external/svgs/undraw_favorite_gb6n.svg"
                                        class=" small-picture img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <h5>Class List</h5>
                            <div class="ms-auto" aria-hidden="true">
                                <button type="button" class="btn btn-csms" data-bs-toggle="modal" data-bs-target="#createClassModal">
                                    <i class="bi bi-pencil-square"></i> Create a Class
                                </button>

                                <!-- Assign Subject Class button with dropdown -->
                                <button type="button" class="btn btn-csms dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-folder2-open"></i> Assign a Subject Class
                                </button>

                                <div class="dropdown-menu" style="padding: 10px;">
                                    <small>Assigned Classes</small>
                                    <!-- Class selection dropdown -->
                                    <select class="form-select" id="class-select">
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

                                    <small>Available Subject List</small>
                                    <!-- Subject selection dropdown -->
                                    <select class="form-select" id="subject-select">
                                        <option selected disabled>Select a subject</option>
                                        <!-- Subject options will be populated dynamically from the database -->
                                        <?php
                                        $sql = "SELECT semester FROM current_semester LIMIT 1";
                                        $stmt = $pdo->query($sql);
                                        $currentSemester = $stmt->fetchColumn();
                                        echo $currentSemester;
                                        if (isset($selectedClass) && isset($currentSemester)) {
                                            // Database query to get subjects based on class and semester
                                            $sql = "SELECT * FROM subjects WHERE class = :class";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute([
                                                ':class' => $selectedClass,
                                            ]);

                                            $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            // Check if there are any subjects for the selected class and semester
                                            if (empty($subjects)) {
                                                echo "<option value='' disabled>No subjects available for this class and semester</option>";
                                            } else {
                                                // Loop through the subjects and populate the dropdown
                                                foreach ($subjects as $subject) {
                                                    echo "<option value='" . htmlspecialchars($subject['id']) . "'>" . htmlspecialchars($subject['name']) . " (" . htmlspecialchars($subject['code']) . ")</option>";
                                                }
                                            }
                                        } else {
                                            echo "<option value='' disabled>Please select a class first</option>";
                                        }
                                        ?>
                                    </select>

                                    <!-- Assigned Subject List -->
                                    <div id="assigned-subject-list">
                                        <small>Assigned Subject List</small>
                                        <div class="row text-center" id="assigned-subjects-container">
                                            <!-- Assigned subjects will be appended here dynamically -->
                                            <div class="col">
                                                <small id="assigned-subject">No subjects assigned</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Class button, initially hidden -->
                                    <button type="button" class="btn btn-primary mt-3" id="update-class-btn" style="display: none;" onclick="updateAssignedClass()">
                                        Update Class
                                    </button>
                                </div>
                            </div>

                            <script>
                                // Handle subject selection and adding to the assigned list
                                document.getElementById('subject-select').addEventListener('change', function() {
                                    const selectedSubjectId = this.value;
                                    const selectedSubjectText = this.options[this.selectedIndex].text;

                                    const assignedSubjectsContainer = document.getElementById('assigned-subjects-container');

                                    // Check if the subject is already in the assigned list
                                    if (document.getElementById(`assigned-subject-${selectedSubjectId}`)) {
                                        alert("Subject already assigned!");
                                        return;
                                    }

                                    // Create a new row for the assigned subject
                                    const newSubjectRow = document.createElement('div');
                                    newSubjectRow.classList.add('row');
                                    newSubjectRow.setAttribute('id', `assigned-subject-${selectedSubjectId}`);

                                    newSubjectRow.innerHTML = `
        <div class="col">
            <small>${selectedSubjectText}</small>
            <button class="btn btn-danger btn-sm" onclick="removeAssignedSubject(${selectedSubjectId})">Remove</button>
        </div>
    `;

                                    // Append the new subject row to the container
                                    assignedSubjectsContainer.appendChild(newSubjectRow);

                                    // Show the "Update Class" button if there are subjects in the assigned list
                                    document.getElementById('update-class-btn').style.display = 'block';
                                });

                                // Function to remove a subject from the assigned list
                                function removeAssignedSubject(subjectId) {
                                    const subjectRow = document.getElementById(`assigned-subject-${subjectId}`);
                                    subjectRow.remove();

                                    // If no subjects remain, hide the "Update Class" button
                                    const assignedSubjectsContainer = document.getElementById('assigned-subjects-container');
                                    if (assignedSubjectsContainer.children.length === 0) {
                                        document.getElementById('update-class-btn').style.display = 'none';
                                    }
                                }

                                // Function to handle updating the assigned class
                                function updateAssignedClass() {
                                    const assignedSubjectsContainer = document.getElementById('assigned-subjects-container');
                                    const assignedSubjects = [];

                                    // Loop through the assigned subjects and gather their IDs
                                    assignedSubjectsContainer.querySelectorAll('.row').forEach(row => {
                                        const subjectId = row.getAttribute('id').replace('assigned-subject-', '');
                                        assignedSubjects.push(subjectId);
                                    });

                                    // Make an AJAX request to update the class and assigned subjects on the server
                                    fetch('update_assigned_subjects.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                class: document.getElementById('class-select').value,
                                                subjects: assignedSubjects
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                alert('Class updated successfully!');
                                            } else {
                                                alert('Failed to update class. Please try again.');
                                            }
                                        })
                                        .catch(error => console.error('Error updating class:', error));
                                }

                                document.getElementById('class-select').addEventListener('change', function() {
                                    const selectedClass = this.value;
                                    const selectedSemester = document.getElementById('semester-select').value; // Assuming you have a semester dropdown

                                    if (selectedClass && selectedSemester) {
                                        // Send AJAX request to fetch subjects based on class and semester
                                        fetch('get_subjects.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded',
                                                },
                                                body: `class=${selectedClass}&semester=${selectedSemester}`
                                            })
                                            .then(response => response.text())
                                            .then(data => {
                                                document.getElementById('subject-select').innerHTML = data;
                                            })
                                            .catch(error => console.error('Error loading subjects:', error));
                                    } else {
                                        alert('Please select both class and semester');
                                    }
                                });
                            </script>
                        </div>
                    </div>

                    <br>
                    <?php
                    require 'processes/server/conn.php'; // Include the database connection

                    // Fetch classes from the database
                    try {
                        $stmt = $pdo->query("SELECT id, name, subject, teacher, semester, studentTotal FROM classes ORDER BY name ASC");

                        if ($stmt->rowCount() > 0) {
                            // Only display the table if there are classes
                    ?>
                            <table id="classes">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Subject Name</th>
                                        <th>Teacher</th>
                                        <th>Semester</th>
                                        <th>No. of Students</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Subject Name</th>
                                        <th>Teacher</th>
                                        <th>Semester</th>
                                        <th>No. of Students</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // If classes exist, fetch and display them
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // Fetch the teacher's name based on the teacher's ID
                                        $teacherStmt = $pdo->prepare("SELECT fullName FROM staff_accounts WHERE id = :id");
                                        $teacherStmt->bindParam(':id', $row['teacher'], PDO::PARAM_INT);
                                        $teacherStmt->execute();
                                        $teacher = $teacherStmt->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                            <td><?php echo htmlspecialchars($row['teacher']); ?></td>
                                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                                            <td><?php echo htmlspecialchars($row['studentTotal']); ?></td>
                                            <td>
                                                <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#viewModal<?php echo $row['id']; ?>'>
                                                    <i class='bi bi-eye'></i> View
                                                </button>
                                                <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal<?php echo $row['id']; ?>'>
                                                    <i class='bi bi-pencil'></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                    <?php
                        } else {
                            // If no classes exist, display a message
                            echo "<h1 class='text-center'>No classes available</h1>";
                        }
                    } catch (PDOException $e) {
                        echo "<p class='text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                    ?>

                </div>

            </div>

        </div>
    </div>

</body>
<?php
require 'processes/server/conn.php'; // Include the database connection

// Fetch classes from the database
try {
    $stmt = $pdo->query("SELECT * FROM classes ORDER BY name ASC");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Generate the modal for each class
?>
        <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Viewing Class Content for <?php echo htmlspecialchars($row['name']); ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Class:</label>
                            <p><?php echo htmlspecialchars($row['name']); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject Name:</label>
                            <p><?php echo htmlspecialchars($row['subject']); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teacher:</label>

                            <p>
                                <?php
                                require('processes/server/conn.php');
                                $id = $row['teacher'];
                                $sql = "SELECT * FROM staff_accounts where id =:id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':id', $id);
                                $stmt->execute();
                                $staff = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $staff['fullName'];

                                ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Semester:</label>
                            <p><?php echo htmlspecialchars($row['semester']); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Class Description:</label>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Class Content for <?php echo htmlspecialchars($row['name']); ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="processes/admin/classes/update.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                                <label for="class" class="form-label">Select Class: </label>
                                <select class="form-select" name="class">
                                    <option value="<?php echo htmlspecialchars($row['name']); ?>" selected><?php echo htmlspecialchars($row['name']); ?></option>

                                    <?php
                                    $sections = [
                                        "BSIT-1A",
                                        "BSIT-1B",
                                        "BSIT-2A",
                                        "BSIT-2B",
                                        "BSIT-3A",
                                        "BSIT-3B",
                                        "BSIT-4A",
                                        "BSIT-4B",
                                        "BSCS-1A",
                                        "BSCS-1B",
                                        "BSCS-2A",
                                        "BSCS-2B",
                                        "BSCS-3A",
                                        "BSCS-3B",
                                        "BSCS-4A",
                                        "BSCS-4B"
                                    ];

                                    foreach ($sections as $section) {
                                        if ($section !== $row['name']) {
                                            echo '<option value="' . htmlspecialchars($section) . '">' . htmlspecialchars($section) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subjectName" class="form-label">Select Subject Name: </label>
                                <select class="form-select" name="subjectName">
                                    <option value="<?php echo htmlspecialchars($row['semester']); ?>" selected><?php echo htmlspecialchars($row['subject']); ?></option>
                                    <!-- Add other options here -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="teacher" class="form-label">Select Teachers: </label>
                                <select class="form-select" name="teacher">

                                    <?php
                                    require 'processes/server/conn.php';
                                    $sql = "SELECT id, fullName FROM staff_accounts";
                                    $stmt = $pdo->query($sql);
                                    if ($stmt->rowCount() > 0) {

                                        while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                            echo '<option value=' . $teacher["fullName"] . '>' . $teacher["fullName"] . '</option>';
                                        }
                                    } else {
                                        echo '<option>There is no staff added yet!</option>';
                                    }
                                    ?>


                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Select Semester: </label>
                                <select class="form-select" name="semester">
                                    <option value="<?php echo htmlspecialchars($row['semester']); ?>" selected><?php echo htmlspecialchars($row['semester']); ?></option>
                                    <!-- Add other options here -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="classDesc" class="form-label">Class Description</label>
                                <textarea class="form-control" id="classDesc" name="classDesc"><?php echo htmlspecialchars($row['description']); ?></textarea>
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
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>



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

<div class="modal fade" id="createClassModal" tabindex="-1"
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
                <form id="addClassForm" action="processes/admin/classes/add.php" method="POST">
                    <div class="mb-3">
                        <label for="class" class="form-label">Select Class:</label>
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
                        <label for="subjectName" class="form-label">Select Subject Name: </label>
                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT id, name, semester FROM subjects ORDER BY name ASC");
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
                        <label for="teacher" class="form-label">Select Teacher: </label>
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
                        <label for="semester" class="form-label">Select Semester:</label>
                        <select class="form-select" name="semester" required>
                            <?php
                            $sql = "SELECT name FROM semester ORDER BY name ASC";
                            $stmt = $pdo->query($sql);
                            $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <?php if (!empty($semesters)): ?>
                                <?php foreach ($semesters as $semester): ?>
                                    <option value="<?php echo htmlspecialchars($semester['name']); ?>">
                                        <?php echo htmlspecialchars($semester['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No semesters available</option>
                            <?php endif; ?>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="classDesc" class="form-label">Class Description:</label>
                        <textarea class="form-control" id="classDesc" name="classDesc" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-csms">Save Changes</button>
                        <button type="button" class="btn btn-csms" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>








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

        $(document).ready(function() {
            $('#classes tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            var table = $('#classes').DataTable();

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

<script>
    function confirmDelete(id) {
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
                // Create a form dynamically and submit it
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'processes/admin/classes/delete.php';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>


</html>

<?php 

include('processes/server/alerts.php');

?>