<?php
session_start();
include('processes/server/header.php');
include('processes/server/conn.php');
if (!isset($_SESSION['teacher_id'])) {
  $_SESSION['STATUS'] = "TEACHER_NOT_LOGGED_IN";
  header("Location: teacher_login_page.php");
}
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
    href="external/css/teacher_attendance.css"
    rel="stylesheet">

  <link rel="icon" type="image/png" sizes="32x32"
    href="external/img/favicon-32x32.png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <script src="https://unpkg.com/html5-qrcode"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="container-fluid whole-container">
    <div class="row">

      <div class="sidebar-container c-white text-center" id="sidebarContainer">
        <div class="sidebar-content text-center justify-content-center">

          <small id="currentTime"> </small>

          <img src="external/img/ccs_logo-removebg-preview.png"
            class="img-fluid logo space-sm ">
          <h4 class="bold c-white">Welcome, Teacher!</h4>

          <div class="navigation-links" style="text-align: left;">

            <a href="teacher_dashboard.php">
              <p><i class="bi bi-kanban"></i> Home</p>
            </a>
            <hr>

            <a href="teacher_class_dashboard.php">
              <p><i
                  class="bi bi-book"></i> Classes
              </p>
            </a>
            <a href="teacher_subject_dashboard.php">
              <p><i
                  class="bi bi-journals"></i> Subjects
              </p>
            </a>
            <hr>
            <p><i class="bi bi-calendar-event"></i>
              Class
              Management</p>

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
                <a href="processes/teachers/account/logout.php" a class="nav-link-span">
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
                </h3>

                <div class="ms-auto" aria-hidden="true">
                  <img
                    src="external/svgs/undraw_teacher.svg"
                    class=" small-picture img-fluid">
                </div>
              </div>
            </div>
            <br>
            <div class="d-flex align-items-center">
              <h5><span><i class="bi bi-arrow-left-circle-fill"
                    onclick="redirect()"></i> </span> Go Back</h5>
              <div class="ms-auto text-center" aria-hidden="true">
                <?php
                if (isset($_GET['id'])) {
                  $classId = $_GET['id'];
                  $stmt =
                    $pdo->prepare("SELECT semester FROM classes WHERE id = ?");
                  $stmt->execute([$classId]);
                  $class = $stmt->fetch(PDO::FETCH_ASSOC);
                  if ($class) {
                    $semesterName = $class['semester'];
                    $stmt =
                      $pdo->prepare("SELECT start_date, end_date FROM semester WHERE name = ?");
                    $stmt->execute([$semesterName]);
                    $semester = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($semester) {
                      $startDate = new DateTime($semester['start_date']);
                      $endDate = new DateTime($semester['end_date']);
                      $dates = [];
                      while ($startDate <= $endDate) {
                        $dates[] = $startDate->format('Y-m-d');
                        $startDate->modify('+1 day');
                      }
                    } else {
                      die("Semester not found.");
                    }
                  } else {
                    die("Subject not found.");
                  }
                }
                ?>
                <div class="ms-3">
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle"
                      type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      Select Meeting Date
                    </button>
                    <ul class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton">
                      <?php if (!empty($dates)): ?>
                        <?php foreach ($dates as $date): ?>
                          <li>
                            <a style="color:black !important"
                              class="dropdown-item"
                              href="processes/teachers/meetings/create.php?class_id=<?php echo $_GET['id']; ?>&date=<?php echo $date; ?>">
                              <?php echo date('F j, Y', strtotime($date)); ?>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <li><span class="dropdown-item disabled">No dates
                            available</span></li>
                      <?php endif; ?>
                    </ul>
                  </div>

                  <div class data-bs-toggle="modal"
                    data-bs-target="#cameraModal">
                    <h5><i class="bi bi-camera-fill"></i></h5>
                    <p>Scan QR</p>
                  </div>
                </div>
              </div>
            </div>
            <?php

            // Get the subject ID and date from the URL parameters
            $subjectId = $_GET['id'];
            $meetingDate = $_GET['date'] ?? ''; // Use null coalescing
            $meetingStmt = $pdo->prepare("
              SELECT student_id, attendance
              FROM classes_meetings
              WHERE class_id = :class_id AND date = :meeting_date
              ");
            $meetingStmt->bindParam(':class_id', $subjectId);
            $meetingStmt->bindParam(':meeting_date', $meetingDate);
            $meetingStmt->execute();

            // Fetch the subject name
            $subjectStmt = $pdo->prepare("
              SELECT subject
              FROM classes
              WHERE id = :class_id
              ");
            $subjectStmt->bindParam(':class_id', $subjectId);
            $subjectStmt->execute();
            $subject = $subjectStmt->fetchColumn();

            // Display the header
            echo '<div id="attendance"
                class="container-fluid attendance-container text-center">';
            echo '<br>';
            echo '<p class="info">Western Mindano State University <br>';
            echo 'College of Computing Studies <br>';
            echo '<span class="bold">Department of Information
                    Technology</span><br>';
            echo 'Zamboanga City</p>';
            echo '<br>';
            echo '<div class="row">';
            echo '<div class="col"><p
                      class="bold">' . htmlspecialchars($subject) . '</p></div>';
            echo '<div class="col"><p class="bold">ATTENDANCE</p></div>';
            echo '<div class="col"><p
                      class="bold">' . htmlspecialchars($meetingDate) . '</p>
                    <br>
                    <p class="bold">Present - <i
                        class="bi bi-check-square-fill"> </i> | Absent - <i
                        class="bi bi-square"> </i></p>
                  </div>'; // Use the meeting date from URL
            echo '</div>';
            echo '<br>';

            // Display the student names and attendance records
            if ($meetingStmt->rowCount() > 0) {
              while ($meeting = $meetingStmt->fetch(PDO::FETCH_ASSOC)) {
                // Get the student ID for the current meeting
                $studentId = $meeting['student_id'];

                $studentStmt = $pdo->prepare("
                SELECT s.fullName
                FROM students s
                JOIN students_enrollments se ON s.student_id = se.student_id
                WHERE se.student_id = :student_id AND se.class_id = :class_id
                ");
                $studentStmt->bindParam(':student_id', $studentId);
                $studentStmt->bindParam(':class_id', $subjectId); // using
                $studentStmt->execute();
                $studentName = $studentStmt->fetchColumn();

                // Display the attendance record
                echo '<div class="row">';
                echo '<div class="col"><p class="bold">' .
                  htmlspecialchars($studentName ?: 'Unknown Student') .
                  '</p></div>';
                echo '<div class="col"><hr class="liner"></div>';
                echo '<div class="col"><p class="bold">';
                echo ($meeting['attendance'] === 'present') ? '<i
                        class="bi bi-check-square-fill"></i>' : '<i
                        class="bi bi-square"></i>';
                echo '</p></div>';
                echo '</div>';
              }
            } else {
              echo '<p>No attendance records found for this date.</p>';
            }

            echo '</div>';
            ?>

          </div>

          <div class="container print-container text-center">
            <button class="btn btn-csms"
              onclick="print('attendance')">Print</button>
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
        <h1 class="modal-title fs-5"
          id="exampleModalLabel">Notifications</h1>
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
            <p><em>Lorenzo: Good afternoon sir, ask ko lang if available
                po
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
              <span>Hi, this is Jason Catadman. I'd like to switch from
                Web
                Technologies to Software Engineering, thanks!</span>
            </div>
          </div>
        </div>
        <br>
        <div class="row receiver">
          <div class="col">
            <div class="message">
              <span>Sure sir Catadman. I will work on that right
                now.</span>
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
            <div class="ms-auto" aria-hidden="true"
              style="margin-left: 10px">
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Notes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <strong role="status">View Notes</strong>
          <div class="ms-auto" aria-hidden="true">
            <a href class="nav-ham-link" data-bs-toggle="modal"
              data-bs-target="#addNotesModal">Add New Note</a>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">
                  Note #1 (8/5/2024)
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">

                  <div class="d-flex align-items-center">
                    <p role="status">Note #1</p>
                    <div class=" ms-auto" aria-hidden="true">
                      <p>Date: (8/5/2024)</p>
                    </div>
                  </div>

                  <p><em>Test note #1, test here.</em></p>

                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                  aria-expanded="false" aria-controls="collapseTwo">
                  Note #2 (8/6/2024)
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">

                  <div class="d-flex align-items-center">
                    <p role="status">Note #2</p>
                    <div class=" ms-auto" aria-hidden="true">
                      <p>Date: (8/6/2024)</p>
                    </div>
                  </div>

                  <p><em>Look towards creating a grandiose life.</em></p>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addNotesModal" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New
          Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <label for="title">Title:</label>
          <input type="text" class="form-control" name="title">
          <label for="description">Description:</label>
          <textarea class="form-control" name="description"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-target="#notesModal"
          data-bs-toggle="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="remindersModal" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reminders</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <strong role="status">View Reminders</strong>
          <div class="ms-auto" aria-hidden="true">
            <a href class="nav-ham-link" data-bs-toggle="modal"
              data-bs-target="#addReminderModal">Add New Reminder</a>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="accordion" id="reminderOne">
            <div class="accordion-item">
              <h2 class="accordion-header">

                <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">

                  <p>Pass documentary requirements <br>
                    Due at: 11:59PM 8/11/2024</p> &nbsp; &nbsp;
                  <span class="badge text-bg-danger">High</span>
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse"
                data-bs-parent="#reminderOne">
                <div class="accordion-body">
                  <p>Pass the documentary requirements to the
                    registrar.</p>
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#reiminderTwo"
                  aria-expanded="false" aria-controls="collapseTwo">
                  <p>Pass documentary requirements <br> Due at: 11:59PM
                    8/13/2024</p> &nbsp; &nbsp; <span
                    class="badge text-bg-primary">Medium</span>
                </button>
              </h2>
              <div id="reiminderTwo" class="accordion-collapse collapse"
                data-bs-parent="#reiminderTwo">
                <div class="accordion-body">
                  <p>Test requirement, haha.</p>
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#reiminderThree"
                  aria-expanded="false" aria-controls="collapseTwo">
                  <p>Consult a technical HR meeting <br> Due at: 4:00PM
                    8/14/2024</p> &nbsp; &nbsp; <span
                    class="badge text-bg-secondary">Low</span>
                </button>
              </h2>
              <div id="reiminderThree" class="accordion-collapse collapse"
                data-bs-parent="#reiminderThree">
                <div class="accordion-body">
                  <p>Test meeting lods, haha.</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-dismiss="modal">Close</button>

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
        <form>
          <label for="title">Title:</label>
          <input type="text" class="form-control" name="title">
          <label for="due">Due Date:</label>
          <input type="date" class="form-control" name="due_date">
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
          data-bs-target="#notesModal"
          data-bs-toggle="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cameraModal" tabindex="-1"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Scan QR Code for
          Attendance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">

        <div class="container" id="qr-reader"></div>
        <div id="qr-reader-results"></div>

        <div id="qr-reader" style="width: 300px;"></div>
        <div id="qr-reader-results"></div>

        <script>
          var resultContainer = document.getElementById('qr-reader-results');
          var lastResult, countResults = 0;

          // Function to handle successful QR scan
          function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
              ++countResults;
              lastResult = decodedText
              console.log(`Scan result ${decodedText}`, decodedResult);

              // Redirect to mark attendance based on scanned student ID
              markStudentPresent(decodedText);
            }
          }

          // Function to redirect and mark student as present
          function markStudentPresent(studentId) {
            // Get the current date in the format YYYY-MM-DD (optional, adjust as needed)
            const urlParams = new URLSearchParams(window.location.search);

            // Extract the 'date' parameter from the URL
            const meetingDate = urlParams.get('date');

            // If the 'date' parameter is not present, use the current date as a fallback
            const fallbackDate = new Date().toISOString().split('T')[0];
            const finalMeetingDate = meetingDate || fallbackDate;

            // Construct the URL with query parameters (student_id and date)
            const url = `processes/teachers/meetings/mark_attendance.php?student_id=${encodeURIComponent(studentId)}&date=${finalMeetingDate}&id=${<?php echo $_GET['id'] ?>}`;

            // Redirect to PHP script to mark attendance
            window.location.href = url;
          }

          // Initialize the QR code scanner
          var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
              fps: 60,
              qrbox: 150
            });
          html5QrcodeScanner.render(onScanSuccess);
        </script>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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

  // Function to send the message
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

<script>
  $(document).ready(function() {
    $('#class').DataTable();
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

<script>
  function redirect() {
    window.location.href = "teacher_class_management.php";
  }


  function print(divId) {
    var divToPrint = document.getElementById(divId).innerHTML;
    var iframe = document.createElement('iframe');
    document.body.appendChild(iframe);

    var doc = iframe.contentDocument || iframe.contentWindow.document;

    // Apply Bootstrap CSS
    var link = doc.createElement('link');
    link.href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css";
    link.rel = "stylesheet";
    link.integrity = "sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH";
    link.crossOrigin = "anonymous";
    doc.head.appendChild(link);

    var link = doc.createElement('link');
    link.href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css";
    link.rel = "stylesheet";

    doc.head.appendChild(link);

    // Custom styles for the print
    var style = doc.createElement('style');
    style.textContent = `
    info{display: block}
    body{text-align:center;}
        .bold { font-weight: bold; }
        hr.liner { border-top: 2px solid #000; }
        .attendance-container{ margin: 20px; border: 1px solid black}

      
    `;
    doc.head.appendChild(style);

    doc.body.innerHTML = divToPrint;

    // Printing the content of the iframe
    iframe.contentWindow.focus();
    iframe.contentWindow.print();

    // Removing the iframe after printing
    document.body.removeChild(iframe);
  }
</script>

<?php
include('processes/server/alerts.php');
?>

</html>