<div class="container-fluid actual-content">
          <div class="container-fluid">
            <div class="welcome-container">

              <div class="d-flex align-items-center">
                <h3>Welcome to your Dashboard!

                  <p class="fs-small mt-10">Welcome back!
                    Here's
                    to another day of making a
                    difference in our students'
                    lives.</p>

                  <p class="fs-small mt-10"> <a
                      href="teacher_dashboard.html"
                      class="nav-ham-link">Home</a> /
                    <a
                      href="teacher_subject_dashboard.html"
                      class="nav-ham-link">Subjects</a> / <span
                      class="nav-ham-link">
                      <?php
                      $subject_id = $_GET['id'];
                      try {
                        $sql = "SELECT name FROM subjects WHERE id = :subject_id LIMIT 1";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
                        $stmt->execute();
                        $subject = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($subject) {
                          echo htmlspecialchars($subject['name']);
                        } else {
                          echo "<p>No subject found with this ID.</p>";
                        }
                      } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                      }
                      ?>
                    </span> /
                    <span
                      class="nav-ham-link">Students</span>
                  </p>
                </h3>

                <div class="ms-auto" aria-hidden="true">
                  <img
                    src="external/svgs/undraw_teacher.svg"
                    class=" small-picture img-fluid">
                </div>
              </div>
            </div>

            <hr>
            <div class="container">
              <h5 class="bold" onclick="goBack()"><i
                  class="bi bi-arrow-left"></i> Back</h5>
            </div>

            <div class="container">
              <div class="row">
                <h5>Manage:</h5>
                <div class="col">
                  <button class="btn wide-btn btn-csms-1"
                    onclick="gotoPeople()">Students</button>
                </div>
                <div class="col">
                  <button class="btn wide-btn btn-csms-1"
                    onclick="gotoActivity()">Activity</button>
                </div>
                <div class="col">
                  <div class="dropdown">
                    <button class="btn wide-btn btn-csms-1" href="#"
                      role="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Grades
                    </button>

                    <ul class="dropdown-menu text-center container">
                      <li><a class="dropdown-item"
                          href="teacher_subject_management_activity_grading.html" style="color:black !important;">Activities</a></li>
                      <li><a href="teacher_subject_grades.html" class="dropdown-item" style="color:black !important;" href="#">Grades</a></li>

                    </ul>
                  </div>

                </div>
                <div class="col">
                  <button class="btn wide-btn btn-csms-1"
                    onclick="goToLectures()">Lectures</button>
                </div>
              </div>
              <hr>

              <div class="container-fluid teacher-container">

                <h5>Teacher</h5>

                <div
                  class="container-fluid bordered-none align-middle teacher-container-individual">
                  <h5><i class="bi bi-person-fill"></i> <?php
                                                        $subject_id = $_GET['id'];
                                                        try {
                                                          $sql = "SELECT teacher FROM subjects WHERE id = :subject_id LIMIT 1";
                                                          $stmt = $pdo->prepare($sql);
                                                          $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
                                                          $stmt->execute();
                                                          $subject = $stmt->fetch(PDO::FETCH_ASSOC);
                                                          if ($subject) {
                                                            echo htmlspecialchars($subject['teacher']);
                                                          } else {
                                                            echo "<p>No teacher found with this ID.</p>";
                                                          }
                                                        } catch (PDOException $e) {
                                                          echo "Error: " . $e->getMessage();
                                                        }
                                                        ?></h5>
                </div>
              </div>

              <?php
              $subject_id = $_GET['id']; // Replace with the actual subject_id from the request

              try {
                // Prepare the SQL query to fetch students enrolled in a specific subject
                $sql = "
        SELECT s.id, s.fullName 
        FROM students_enrolled_subjects ses
        JOIN students s ON ses.student_id = s.id
        WHERE ses.subject_id = :subject_id
    ";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the result
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($students)) {
                  // Loop through students and display them in HTML
                  echo '<div class="container-fluid student-container">';
                  echo '<h5>Students</h5>';

                  foreach ($students as $student) {
                    echo "
                <div class='container-fluid bordered-none align-middle student-container-individual'>
                    <h5><i class='bi bi-mortarboard-fill'></i> " . htmlspecialchars($student['fullName']) . "</h5>
                </div>
            ";
                  }

             
                } else {
                  echo '<p>No students have enrolled yet for this subject..</p>';
                }
              } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
              }
              echo '</div>';
              ?>

            </div>
          </div>

        </div>