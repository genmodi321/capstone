<?php
session_start();
include('processes/server/header.php');
include('processes/server/conn.php');
if (!isset($_SESSION['teacher_id'])) {
  $_SESSION['STATUS'] = "TEACHER_NOT_LOGGED_IN";
  header("Location: teacher_login_page.php");
}
?>

<body>
  <div class="container-fluid whole-container">
    <div class="row">

      <?php include('processes/server/sidebar.php');
      ?>

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
            <div class="row text-center">
              <div class="col-sm-3 info-container">
                <h5 class="bold ">No. of Students</h5>
                <h5><i class="bi bi-person-fill"></i>
                  <?php
                  $teacherName = $_SESSION['teacher_name'];
                  $stmt = $pdo->prepare("
                        SELECT COUNT(DISTINCT se.student_id) AS studentTotal
                        FROM students_enrollments se
                        JOIN classes c ON se.class_id = c.id
                        WHERE c.teacher = ?
                    ");
                  $stmt->execute([$teacherName]);
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  $studentTotal = $result['studentTotal'] ?? 0;
                  echo $studentTotal;
                  ?></h5>
              </div>
              <div class="col-sm-3 info-container">
                <h5 class="bold ">No. of Subjects</h5>
                <h5><i class="bi bi-person-fill-gear"></i>
                  <?php
                  $stmt = $pdo->prepare("
                  SELECT COUNT(*) AS subjectTotal
                  FROM subjects
                  WHERE teacher = ?
              ");
                  $stmt->execute([$teacherName]);
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  $subjectTotal = $result['subjectTotal'] ?? 0;
                  echo $subjectTotal;
                  ?></h5>
              </div>
              <div class="col-sm-3 info-container">
                <h5 class="bold ">No. of Activites</h5>
                <h5><i class="bi bi-file-post-fill"></i>
                  20</h5>

              </div>

            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col">
              <div class="d-flex align-items-center">
                <h5>Subjects</h5>
                <div class="ms-auto" aria-hidden="true">
                  <a href="teacher_subject_dashboard.php" class="btn btn-danger"><i
                      class="bi bi-eye-fill"></i> View All</a>
                </div>
              </div>

              <br> <br>
              <?php
              $stmt = $pdo->prepare("
              SELECT name
              FROM subjects
              WHERE teacher = ?
              ");
              $stmt->execute([$teacherName]);
              $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC); 
              ?>

              <div class="container subjects">
                <?php if ($subjects):
                ?>
                  <?php foreach ($subjects as $subject): ?>
                    <div class="container subject">
                      <h5><?php echo htmlspecialchars($subject['name']); ?></h5>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="container subject">
                    <h5>No subjects assigned.</h5>
                  </div>
                <?php endif; ?>
              </div>

            </div>
            <div class="col">

              <div class="row info-container"
                data-bs-toggle="modal" data-bs-target="#remindersModal">
                <h5 class="bold ">Reminders</h5>
                <ul>
                  <li>Pass documentary requirements</li>
                  <li>Pass documentary requirements</li>
                  <li>Consult a technical HR meeting </li>
                </ul>
              </div>

              <div class="row info-container">
                <h5 class="bold ">Activities</h5>
                <ul>
                  <li><a href="teacher_subject_management_activity.html" style="color:black !important">Activity #1: Make a Portfolio</a></li>
                  <li><a href="teacher_subject_management_activity.html" style="color:black !important">Activity #2: Make a Website</a></li>
                </ul>
              </div>

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
          data-bs-target="#notesModal" data-bs-toggle="modal">Close</button>
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
                  <p>Pass the documentary requirements to the registrar.</p>
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
                  data-bs-toggle="collapse" data-bs-target="#reiminderThree"
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
          data-bs-target="#notesModal" data-bs-toggle="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
include('processes/server/footer.php');
include('processes/server/alerts.php');
?>

</html>