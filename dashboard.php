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
    href="external/css/dashboard.css"
    rel="stylesheet">

  <link rel="icon" type="image/png" sizes="32x32"
    href="external/img/favicon-32x32.png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

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
                  data-bs-toggle="modal" data-bs-target="#messageModal">

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
                    class="bi bi-bell iconics" data-bs-toggle="modal"
                    data-bs-target="#notificationModal"></i>

                  <span
                    class="position-absolute 
                                            top-0 start-50 translate-middle p-2 
                                            bg-danger border border-light rounded-circle">

                  </span>

                </a>
                <a href="processes/admin/account/logout.php " class="nav-link-span" style="color: white !important; border: 1px solid white;
                border-radius: 20px; padding: 5px;">
                  Logout
                </a>

              </span>

            </div>
          </div>
        </div>

        <div class="container-fluid actual-content">
          <div class="container-fluid wd-75">
            <div class="welcome-container">

              <div class="d-flex align-items-center">
                <h3>Welcome to your Dashboard!

                  <p class="fs-small mt-10">Welcome back!
                    Here's
                    to another day of making a
                    difference in our students'
                    lives.</p>
                </h3>

                <div class="ms-auto" aria-hidden="true">
                  <img
                    src="external/svgs/undraw_favorite_gb6n.svg"
                    class=" small-picture img-fluid">
                </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-sm-3 info-container">
                <h5 class="bold ">Total Students</h5>
                <h5><i class="bi bi-person-fill"></i>

                  <?php
                  // TO-DO: Implement getting number of total students from database
                  //  $sql = "SELECT COUNT(*) AS total from students";
                  //  $stmt = $pdo->prepare($sql);
                  //  $stmt->execute();
                  //  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  //  $totalStudents = $result['total'];
                  //  echo $totalStudents;
                  ?>
                  0
                </h5>
              </div>
              <div class="col-sm-3 info-container">
                <h5 class="bold ">No. of Teachers</h5>
                <h5><i class="bi bi-person-fill-gear"></i>
                  <?php
                  // TO-DO: Implement getting number of total students from database
                  $sql = "SELECT COUNT(*) AS total from staff_accounts";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  $totalTeachers = $result['total'];
                  echo $totalTeachers;
                  ?></h5>
              </div>
              <div class="col-sm-3 info-container">
                <h5 class="bold ">Total Classes</h5>
                <h5><i class="bi bi-person-video3"></i>
                  <?php
                  // TO-DO: Implement getting number of total classes from database
                  $sql = "SELECT COUNT(*) AS total from classes";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  $totalClasses = $result['total'];
                  echo $totalClasses;
                  ?></h5>
              </div>
              <div class="col-sm-3 info-container">
                <h5 class="bold ">Total Subjects</h5>
                <h5><i class="bi bi-book-half"></i>
                  <?php
                  // TO-DO: Implement getting number of total classes from database
                  $sql = "SELECT COUNT(*) AS total from subjects";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  $totalSubjects = $result['total'];
                  echo $totalSubjects;
                  ?></h5>
              </div>
              <div class="col-sm-3 info-container" data-bs-toggle="modal" data-bs-target="#semesterModal">
                <h5 class="bold ">Current Semester</h5>
                <h5><i class="bi bi-calendar2-range"></i>
                  <?php
           
                  $sql = "SELECT s.name 
        FROM current_semester cs
        JOIN semester s ON cs.semester = s.name 
        LIMIT 1";
                  $stmt = $pdo->query($sql);
                  $currentSemester = $stmt->fetch(PDO::FETCH_ASSOC);

                  if ($currentSemester) {
                  
                    echo $currentSemester['name'];
                  } else {
                  
                    echo "No current semester is set.";
                  }
                  ?>
                </h5>
              </div>

            </div>
          </div>

          <hr>

          <div class="row text-center">
            <div class="col-sm-3 info-container">
              <h5 class="bold ">Quick Access</h5>
              <a href="staff_management.php" class="qa-link">Teachers</a>
              <a href="subject_maangement.php" class="qa-link">Subject</a>
              <div class="spacer-10"></div>
              <a href="class_management.php" class="qa-link">Class</a>
              <a href="semester_management.php" class="qa-link">Semester</a>
            </div>
            <div class="col-sm-3 info-container"
              data-bs-toggle="modal" data-bs-target="#notesModal">
              <h5 class="bold ">Notes</h5>
              <?php
              $notes = [];
              try {
                $stmt = $pdo->query("SELECT * FROM admin_notes ORDER BY datetime_created DESC");
                $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                echo "Error fetching notes: " . $e->getMessage();
              }
              ?>

              <ul>
                <?php if (!empty($notes)): ?>
                  <?php foreach ($notes as $note): ?>
                    <li><?= htmlspecialchars($note['title']) ?> (<?= date('m/d/Y', strtotime($note['datetime_created'])) ?>)</li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>No notes available</li>
                <?php endif; ?>
              </ul>

            </div>
            <?php
            $reminders = [];
            try {
              $stmt = $pdo->query("SELECT * FROM admin_reminders ORDER BY datetime_created DESC");
              $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
              echo "Error fetching reminders: " . $e->getMessage();
            }
            ?>

            <div class="col-sm-3 info-container" data-bs-toggle="modal" data-bs-target="#remindersModal">
              <h5 class="bold">Reminders</h5>
              <ul>
                <?php if (!empty($reminders)): ?>
                  <?php foreach ($reminders as $reminder): ?>
                    <li><?= htmlspecialchars($reminder['title']) ?></li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>No reminders available</li>
                <?php endif; ?>
              </ul>
            </div>


          </div>

        </div>

      </div>

    </div>
  </div>

</body>

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
          <input type="text" name="search" placeholder="Input person here"
            required class="input-search">
        </form>
        <br>
        <div class="row msg align-items-center"
          data-bs-target="#actualMessageModal" data-bs-toggle="modal">
          <div class="col-sm-3 text-center"
            style="border-right: 1px solid black;">
            <h1><i class="bi bi-person-fill"></i></h1>
            <span>Jason Catadman</span>
          </div>
          <div class="col">
            <p><em>You: Sure sir Catadman. I will work on that right
                now.</em></p>
          </div>
        </div>

        <br>

        <div class="row unread msg align-items-center">
          <div class="col-sm-3 text-center"
            style="border-right: 1px solid black;">
            <h1><i class="bi bi-person-fill"></i></h1>
            <span>Ceed Lorenzo</span>
          </div>
          <div class="col">
            <p><em>Lorenzo: Good afternoon sir, ask ko lang if available po
                si...</em></p>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="actualMessageModal" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Chats</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
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
              <span>Hi, this is Jason Catadman. I'd like to switch from Web
                Technologies to Software Engineering, thanks!</span>
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
<?php
include('processes/server/conn.php');
date_default_timezone_set('Asia/Manila');

$notes = [];
try {
  $stmt = $pdo->query("SELECT * FROM admin_notes ORDER BY datetime_created DESC");
  $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error fetching notes: " . $e->getMessage();
}

?>

<!-- HTML Modal for Viewing and Adding Notes -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Notes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <strong role="status">View Notes</strong>
          <div class="ms-auto" aria-hidden="true">
            <a href="#" class="nav-ham-link" data-bs-toggle="modal" data-bs-target="#addNotesModal">Add New Note</a>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="accordion" id="accordionExample">
            <?php if (!empty($notes)): ?>
              <?php foreach ($notes as $index => $note): ?>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNote<?= $index ?>" aria-expanded="false" aria-controls="collapseNote<?= $index ?>">
                      <?= htmlspecialchars($note['title']) ?> (<?= date('m/d/Y', strtotime($note['datetime_created'])) ?>)
                      &nbsp; <a href="processes/admin/notes/delete.php?id=<?php echo $note['id'] ?> ?>" style="color: red !important"><i style="color: red !important" class="bi bi-trash-fill"></i></a>
                    </button>
                  </h2>
                  <div id="collapseNote<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <div class="d-flex align-items-center">
                        <p role="status"><?= htmlspecialchars($note['title']) ?></p>
                        <div class="ms-auto" aria-hidden="true">
                          <p>Date: (<?= date('m/d/Y', strtotime($note['datetime_created'])) ?>)</p>
                        </div>
                      </div>
                      <p><em><?= htmlspecialchars($note['description']) ?></em></p>
                      <!-- Add delete functionality -->

                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No notes available</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding a New Note -->
<div class="modal fade" id="addNotesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="processes/admin/notes/add.php">
          <label for="title">Title:</label>
          <input type="text" class="form-control" name="title" required>
          <label for="description">Description:</label>
          <textarea class="form-control" name="description" required></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-target="#notesModal" data-bs-toggle="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$reminders = [];
try {
  $stmt = $pdo->query("SELECT * FROM admin_reminders ORDER BY due_date DESC");
  $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error fetching reminders: " . $e->getMessage();
}
?>

<div class="modal fade" id="remindersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reminders</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <strong role="status">View Reminders</strong>
          <div class="ms-auto" aria-hidden="true">
            <a href class="nav-ham-link" data-bs-toggle="modal" data-bs-target="#addReminderModal">Add New Reminder</a>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="accordion" id="reminderAccordion">
            <?php if (!empty($reminders)): ?>
              <?php foreach ($reminders as $index => $reminder): ?>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false">
                      <p><?= htmlspecialchars($reminder['title']) ?> <br> Due at: <?= htmlspecialchars($reminder['due_time']) ?> <?= htmlspecialchars($reminder['due_date']) ?></p> &nbsp; &nbsp;
                      <span class="badge <?= ($reminder['level'] == 'High') ? 'text-bg-danger' : (($reminder['level'] == 'Medium') ? 'text-bg-primary' : 'text-bg-secondary') ?>">
                        <?= htmlspecialchars($reminder['level']) ?>
                      </span>
                    </button>
                  </h2>
                  <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#reminderAccordion">
                    <div class="accordion-body">
                      <p><?= htmlspecialchars($reminder['description']) ?> <a href="processes/admin/reminders/delete.php?id=<?php echo $reminder['id']?>"><i class="bi bi-trash-fill" style="color:red"></i></a></p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No reminders available</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addReminderModal" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New
          Remider</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="processes/admin/reminders/add.php">
          <label for="title">Title:</label>
          <input type="text" class="form-control" name="title">
          <label for="due">Due Date:</label>
          <input type="date" class="form-control" name="due_date">
          <label for="due">Due Time:</label>
          <input type="time" class="form-control" name="due_time">
          <label for="status">Status:</label>
          <select class="form-control" name="status">
            <option>Select an option below: </option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
          </select>
          <label for="description">Description:</label>
          <textarea class="form-control" name="description"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-target="#notesModal" data-bs-toggle="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="semesterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Current Semester</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="processes/admin/semester/update_current_semester.php">
          <div class="mb">
            <label>Current Semester</label>
            <select class="form-control" name="semester">
              <?php
              $sql = "SELECT * FROM semester";
              $stmt = $pdo->query($sql);
              if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='{$row['name']}'>{$row['name']}</option>";
                }
              } else {
                echo "<option value='' disabled>No semesters available</option>";
              }
              ?>
            </select>
          </div>

      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Save Changes">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Viewing and Editing Profile</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="processes/admin/account/edit.php">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
          </div>
          <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name">
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <!-- Password Fields -->
          <div class="mb-3" style="position: relative;">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <span style="position: absolute; right: 10px; top: 38px; cursor: pointer;">
              <i class="bi bi-eye-slash-fill" id="togglerPassword"></i>
            </span>
          </div>

          <div class="mb-3" style="position: relative;">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <span style="position: absolute; right: 10px; top: 38px; cursor: pointer;">
              <i class="bi bi-eye-slash-fill" id="togglerConfirmPassword"></i>
            </span>
          </div>
          <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="number" class="form-control" id="phone_number" name="phone_number" required min="1000000000" max="9999999999" placeholder="Enter your phone number" oninput="this.value = this.value.slice(0, 12)">
          </div>

          <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" name="gender" id="gender" required>
              <option value="" disabled selected>Select a gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
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

<script
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
  crossorigin="anonymous"></script>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
  integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
  crossorigin="anonymous"></script>

</html>

<?php
include('processes/server/alerts.php');
?>