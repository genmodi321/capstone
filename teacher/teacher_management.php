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
            href="external/css/admin_teacherManagement.css"
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

        td{
            text-align: center;
            vertical-align: middle;
        }

        .btn-csms{
            background-color: #709775;
            color: white;
        }

    </style>

    <body>
        <div class="container-fluid whole-container">
            <div class="row">

                <div class="col-md-2 sidebar text-center">
                    <small id="currentTime"> </small>

                    <img src="external/img/ccs_logo-removebg-preview.png"
                        class="img-fluid logo space-sm">
                    <h4 class="bold">Welcome, Admin!</h4>

                    <div class="navigation-links" style="text-align: left;">
                        <span><i class="bi bi-house"></i> Home</span>
                        <a href="teacher_dashboard.html"><p><i class="bi bi-kanban"></i> Index</p></a>
                        <hr>
                        <span><i class="bi bi-menu-button-wide"></i>
                          Management</span>
                        <a href="teacher_class_dashboard.html"><p><i
                              class="bi bi-book"></i> Classes
                            </p></a>
                        <a href="teacher_subject_dashboard.html"><p><i
                              class="bi bi-journals"></i> Subjects
                            </p></a>
                        <hr>
                        <p><i class="bi bi-calendar-event"></i>
                            Class
                            Management</p>
                
                     
                      </div>
                </div>

                <div class="col">

                    <div
                        class="container-fluid d-flex navbar navbar-expand-lg">
                        <a class="navbar-brand" href="#">
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
                                    <a href="index.html"a class="nav-link-span">
                                        <button class="btn btn-csms-outline">Logout</button></a>

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
                                <h5>Teacher List</h5>
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

                        <table id="classes">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Class</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Jason Catadman</td>
                                    <td>jason_catadman@wmsu.css.edu.ph</td>
                                    <td>Department of Information Technology</td>
                                  <td>BSIT-4A</td>



                                    <td>
                                        <button type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            class="btn btn-warning"><i
                                                class="bi bi-pencil"></i>
                                            Edit</button>
                                        <button type="button"
                                          onclick="deleteModal()"
                                            class="btn btn-danger"><i
                                                class="bi bi-trash"></i>
                                            Delete</button>

                                    </td>

                                </tr>

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

    <div class="modal fade" id="messageModal" tabindex="-1"
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

    <div class="modal fade" id="addTeacherModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"
                        id="exampleModalLabel">Add a new Teacher</h1>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullName"
                                class="form-label">Full Name</label>
                            <input type="text" class="form-control"
                                id="fullName" name="fullName">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email
                            </label>
                            <input type="email" class="form-control"
                                id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>

                            <select class="form-control" name="department">
                                <option>Select a department</option>   
                                <option value="Department of Information Technology">Department of Information Technology</option>
                                <option value="Department of Computer Science">Department of Computer Science</option>
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Class Assignment</label>

                          <div class="row">

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-1A
                            </div>

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-2A
                            </div>

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-3A
                            </div>

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-4A
                            </div>
                          </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-csms"
                            value="Update">
                        <button type="button" class="btn btn-csms"
                            data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"
                        id="exampleModalLabel">Editing Existing Information for: Jason Catadman</h1>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullName"
                                class="form-label">Full Name</label>
                            <input type="text" class="form-control"
                                id="fullName" name="fullName" value="Jason Catadman">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email
                            </label>
                            <input type="email" class="form-control"
                                id="email" name="email" value="jason_catadman@wmsu.css.edu.ph">
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>

                            <select class="form-control" name="department">
                                <option>Select a department</option>   
                                <option value="Department of Information Technology" selected>Department of Information Technology</option>
                                <option value="Department of Computer Science">Department of Computer Science</option>
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Class Assignment</label>

                          <div class="row">

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-1A
                            </div>

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-2A
                            </div>

                            <div class="col">
                                <input type="checkbox" name="classes[]"> BSIT-3A
                            </div>

                            <div class="col">
                                <input type="checkbox" name="classes[]" checked> BSIT-4A
                            </div>
                          </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-csms"
                            value="Update">
                        <button type="button" class="btn btn-csms"
                            data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        function getTime()
        {
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


 document.addEventListener('DOMContentLoaded', function () {
            const semesterSelect = document.getElementById('semester');
            const availableClassesSelect = document.getElementById('availableClasses');
            const assignedClassesContainer = document.getElementById('assignedClassesContainer');
            const assignedClassesBody = document.getElementById('assignedClassesBody');

            const classes = {
                "First Semester": ["BSIT-1A", "BSIT-1B", "BSIT-2A"],
                "Second Semester": ["BSIT-3A", "BSIT-3B", "BSIT-4A"]
            };

            // Update available classes based on selected semester
            semesterSelect.addEventListener('change', function () {
                const selectedSemester = semesterSelect.value;

                // Clear previous options
                availableClassesSelect.innerHTML = '<option selected disabled>Select a Class</option>';

                // Add new options based on selected semester
                if (classes[selectedSemester]) {
                    classes[selectedSemester].forEach(function (className) {
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
                button.addEventListener('click', function () {
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

        const togglerConfirmPassword = document
            .querySelector('#togglerConfirmPassword');
        const confirmPassword = document.querySelector('#confirm_password');
        togglerConfirmPassword.addEventListener('click', () => {
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
                confirmPassword.setAttribute('type', type);
            togglerConfirmPassword.classList.toggle('bi-eye');
        });

        function deleteModal(){
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
    Swal.fire({
      title: "Deleted!",
      text: "Your record has been deleted.",
      icon: "success"
    });
  }
});
        }

    </script>
</html>