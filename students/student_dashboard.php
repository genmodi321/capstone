<?php
session_start();
if (!isset($_SESSION['student_id'])) {
	$_SESSION['STATUS'] = "STUDENT_NOT_LOGGED_IN";
	header("Location: ../login/index.php");
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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

	.container-bordered {
		border: 1px solid black;
		margin: 10px;
		padding: 10px;
	}

	.missed {
		color: red;
	}
</style>

<body>
	<div class="wrapper">
		<?php
		include('sidebar.php')
			?>

		<div class="main">
			<?php
			include('topbar.php')
				?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="card shadow-sm">
						<div class="card-body">


							<h1 class="h3 mb-3"><strong>Student</strong> Dashboard</h1>

							<div class="row text-center">
								<div class="col container-bordered" data-bs-toggle="modal"
									data-bs-target="#subjectsModal">
									<h5>Subjects Enrolled </h5>
									<ul>
										<?php
										try {
											// Assuming the student's ID is stored in the session
											$student_id = $_SESSION['student_id'];

											// Fetch all class_ids for the student from the students_enrollments table
											$stmt = $pdo->prepare("SELECT class_id FROM students_enrollments WHERE student_id = :student_id");
											$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
											$stmt->execute();
											$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

											// Check if any classes were found
											if ($classes) {
												// Loop through the class_ids
												foreach ($classes as $class) {
													$class_id = $class['class_id'];

													// Fetch the subjects associated with the class_id
													$subjectStmt = $pdo->prepare("SELECT subject FROM classes WHERE id = :class_id");
													$subjectStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
													$subjectStmt->execute();
													$subjects = $subjectStmt->fetchAll(PDO::FETCH_ASSOC);

													// Check if subjects were found
													if ($subjects) {
														// Display subjects for each class
										
														foreach ($subjects as $subject) {
															echo '<li>' . htmlspecialchars($subject['subject']) . '</li>';
														}

													} else {
														echo "<li>Class ID: $class_id - No subjects found.</li>";
													}
												}
											} else {
												echo '<li>No classes enrolled for this student.</li>';
											}
										} catch (PDOException $e) {
											echo "Error: " . $e->getMessage();
										}
										?>
									</ul>

								</div>


								<div class="col container-bordered" data-bs-toggle="modal"
									data-bs-target="#pendingActivitiesModal">
									<h5>Pending Activities</h5>
									<ul>

										<?php
										try {
											// Assuming the student's ID is stored in the session
											$student_id = $_SESSION['student_id'];

											// Fetch all class_ids the student is enrolled in
											$stmt = $pdo->prepare("SELECT class_id FROM students_enrollments WHERE student_id = :student_id");
											$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
											$stmt->execute();
											$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

											// Check if the student is enrolled in any classes
											if ($enrollments) {
												// Get the current date
												$current_date = date('Y-m-d');

												// Iterate over each class
												foreach ($enrollments as $enrollment) {
													$class_id = $enrollment['class_id'];

													// Fetch the subject associated with this class_id
													$subjectStmt = $pdo->prepare("SELECT subject FROM classes WHERE id = :class_id");
													$subjectStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
													$subjectStmt->execute();
													$class = $subjectStmt->fetch(PDO::FETCH_ASSOC);

													// Set a fallback in case the class isn't found
													$classSubject = $class ? $class['subject'] : 'Unknown Class';

													// Fetch the pending activities for this class_id
													$activityStmt = $pdo->prepare("
                    SELECT title, due_date 
                    FROM activities 
                    WHERE class_id = :class_id 
                    AND due_date >= :current_date
                    ORDER BY due_date ASC
                ");
													$activityStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
													$activityStmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
													$activityStmt->execute();

													$activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

													// Display the subject as a heading for this class
													echo "<li><strong>$classSubject</strong><ul>";

													// Check if there are any pending activities for the class
													if ($activities) {
														foreach ($activities as $activity) {
															// Format the due date for better readability
															$dueDate = new DateTime($activity['due_date']);
															$formattedDueDate = $dueDate->format('F j, Y'); // E.g., 'August 19, 2024'
															echo '<li>' . htmlspecialchars($activity['title']) . ' (Due on ' . $formattedDueDate . ')</li>';
														}
													} else {
														echo '<li>No pending activities for this class.</li>';
													}
													echo "</ul></li> <br>";
												}
											} else {
												echo '<li>The student is not enrolled in any classes.</li>';
											}
										} catch (PDOException $e) {
											echo "Error: " . $e->getMessage();
										}
										?>
									</ul>




									</ul>
								</div>

								<!-- Modal -->
								<div class="modal fade" id="pendingActivitiesModal" tabindex="-1"
									aria-labelledby="pendingActivitiesModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="pendingActivitiesModalLabel">Pending
													Activities</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal"
													aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<div class="accordion" id="activitiesAccordion">
													<?php
													try {
														$stmt = $pdo->prepare("SELECT class_id FROM students_enrollments WHERE student_id = :student_id");
														$stmt->bindParam(':student_id', $_SESSION['student_id'], PDO::PARAM_INT);
														$stmt->execute();
														$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

														if ($enrollments) {
															$current_date = date('Y-m-d');
															$classIndex = 0;

															foreach ($enrollments as $enrollment) {
																$class_id = $enrollment['class_id'];

																// Fetch subject name
																$subjectStmt = $pdo->prepare("SELECT subject FROM classes WHERE id = :class_id");
																$subjectStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
																$subjectStmt->execute();
																$class = $subjectStmt->fetch(PDO::FETCH_ASSOC);
																$classSubject = $class ? htmlspecialchars($class['subject']) : 'Unknown Class';

																// Fetch activities
																$activityStmt = $pdo->prepare("
                                    SELECT title, due_date 
                                    FROM activities 
                                    WHERE class_id = :class_id AND due_date >= :current_date
                                    ORDER BY due_date ASC
                                ");
																$activityStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
																$activityStmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
																$activityStmt->execute();
																$activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

																// Display class and activities in accordion format
																echo '
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading' . $classIndex . '">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse' . $classIndex . '" aria-expanded="true" 
                                            aria-controls="collapse' . $classIndex . '">
                                            ' . $classSubject . '
                                        </button>
                                    </h2>
                                    <div id="collapse' . $classIndex . '" class="accordion-collapse collapse ' . ($classIndex === 0 ? 'show' : '') . '" aria-labelledby="heading' . $classIndex . '" data-bs-parent="#activitiesAccordion">
                                        <div class="accordion-body">
                                            ';

																if ($activities) {
																	echo '<table class="table table-striped">';
																	echo '<thead><tr><th>Activity Title</th><th>Due Date</th></tr></thead><tbody>';
																	foreach ($activities as $activity) {
																		$dueDate = new DateTime($activity['due_date']);
																		$formattedDueDate = $dueDate->format('F j, Y');
																		echo '<tr>
                                                <td>' . htmlspecialchars($activity['title']) . '</td>
                                                <td>' . $formattedDueDate . '</td>
                                            </tr>';
																	}
																	echo '</tbody></table>';
																} else {
																	echo '<p>No pending activities for this class.</p>';
																}

																echo '</div></div></div>';
																$classIndex++;
															}
														} else {
															echo '<p>The student is not enrolled in any classes.</p>';
														}
													} catch (PDOException $e) {
														echo '<p>Error: ' . $e->getMessage() . '</p>';
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="col container-bordered" data-bs-toggle="modal"
									data-bs-target="#modalActivities">
									<h5>Missed Activities</h5>
									<ul>
										<?php
										try {
											// Assuming the student's ID is stored in the session
											$student_id = $_SESSION['student_id'];

											// Fetch all class_ids the student is enrolled in
											$stmt = $pdo->prepare("SELECT class_id FROM students_enrollments WHERE student_id = :student_id");
											$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
											$stmt->execute();
											$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

											// Variable to hold all missed activities grouped by subject
											$activitiesBySubject = [];

											if ($enrollments) {
												// Get the current date
												$current_date = date('Y-m-d');

												// Iterate through each enrolled class
												foreach ($enrollments as $enrollment) {
													$class_id = $enrollment['class_id'];

													// Fetch the subject name for this class_id
													$subjectStmt = $pdo->prepare("SELECT subject FROM classes WHERE id = :class_id");
													$subjectStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
													$subjectStmt->execute();
													$class = $subjectStmt->fetch(PDO::FETCH_ASSOC);
													$classSubject = $class ? htmlspecialchars($class['subject']) : 'Unknown Class';

													// Fetch missed activities for this class
													$activityStmt = $pdo->prepare("
                        SELECT a.title, a.due_date 
                        FROM activities a
                        LEFT JOIN activity_submissions s 
                        ON a.id = s.activity_id AND s.student_id = :student_id
                        WHERE a.class_id = :class_id 
                        AND a.due_date < :current_date
                        ORDER BY a.due_date ASC
                    ");
													$activityStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
													$activityStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
													$activityStmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
													$activityStmt->execute();
													$missedActivities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

													// Store missed activities for the subject
													foreach ($missedActivities as $activity) {
														$activitiesBySubject[$classSubject][] = [
															'title' => htmlspecialchars($activity['title']),
															'due_date' => $activity['due_date']
														];
													}
												}

												// Display up to 3 missed activities for each subject
												$totalActivities = 0;
												foreach ($activitiesBySubject as $subject => $activities) {
													$totalActivities += count($activities);

													// Display the subject first
													echo "<li><strong>$subject</strong>";

													if (!empty($activities)) {
														echo "<ul>"; // Nested list for activities
										
														// Display activities (up to 3)
														$activityCount = 0;
														foreach ($activities as $activity) {
															if ($activityCount < 3) {
																$dueDate = new DateTime($activity['due_date']);
																$formattedDueDate = $dueDate->format('F j, Y');
																echo "<li class='missed'>{$activity['title']} (Was due on $formattedDueDate)</li>";
																$activityCount++;
															}
														}

														echo "</ul>";

														// If there are more than 3 activities, display "and others"
														if (count($activities) > 3) {
															echo ' and other more';
														}
													}

													echo "</li>"; // End of subject
												}

												if ($totalActivities === 0) {
													echo '<li>No missed activities.</li>';
												}
											} else {
												echo '<li>The student is not enrolled in any classes.</li>';
											}
										} catch (PDOException $e) {
											echo '<li>Error: ' . htmlspecialchars($e->getMessage()) . '</li>';
										}
										?>
									</ul>

									<!-- Modal to Show All Missed Activities -->
									<!-- Modal structure -->
									<div class="modal fade" id="modalActivities" tabindex="-1"
										aria-labelledby="modalActivitiesLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="modalActivitiesLabel">All Missed
														Activities</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal"
														aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<div class="container">
														<div class="accordion" id="activitiesAccordion">
															<?php
															// Display all missed activities in an accordion by subject
															foreach ($activitiesBySubject as $subject => $activities) {
																// Create a unique ID for each subject in the accordion
																$accordionId = 'accordion-' . md5($subject);
																?>
																<div class="accordion-item">
																	<h2 class="accordion-header"
																		id="heading-<?php echo $accordionId; ?>">
																		<button class="accordion-button" type="button"
																			data-bs-toggle="collapse"
																			data-bs-target="#collapse-<?php echo $accordionId; ?>"
																			aria-expanded="true"
																			aria-controls="collapse-<?php echo $accordionId; ?>"
																			onclick="event.stopPropagation();">
																			<?php echo htmlspecialchars($subject); ?>
																		</button>
																	</h2>
																	<div id="collapse-<?php echo $accordionId; ?>"
																		class="accordion-collapse collapse"
																		aria-labelledby="heading-<?php echo $accordionId; ?>"
																		data-bs-parent="#activitiesAccordion">
																		<div class="accordion-body">
																			<?php
																			// Display each missed activity for the current subject
																			foreach ($activities as $activity) {
																				$dueDate = new DateTime($activity['due_date']);
																				$formattedDueDate = $dueDate->format('F j, Y');
																				?>
																				<div class="activity-item">
																					<p><strong>Title:</strong>
																						<?php echo htmlspecialchars($activity['title']); ?>
																					</p>
																					<p><strong>Due Date:</strong>
																						<?php echo $formattedDueDate; ?></p>
																				</div>
																				<hr>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
																<?php
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal JavaScript to prevent closing modal on interaction -->
									<script>
										// Handle modal behavior
										var modal = document.getElementById('modalActivities');

										// Disable modal close on any click inside
										modal.addEventListener('click', function (e) {
											e.stopPropagation();  // Prevent the modal from closing when clicking inside it
										});

										// Disable closing modal if clicking on the accordion header
										var accordionButtons = modal.querySelectorAll('.accordion-button');
										accordionButtons.forEach(function (button) {
											button.addEventListener('click', function (e) {
												e.stopPropagation(); // Prevent modal from closing
											});
										});

										// This stops modal close if the user clicks outside the modal content area
										modal.querySelector('.modal-dialog').addEventListener('click', function (e) {
											e.stopPropagation(); // Prevent propagation to the backdrop, which would close the modal
										});
									</script>


								</div>





							
							</div>
							<br>
							<div class="row text-center d-flex justify-content-center">
								<h5>Shortcut Links</h5>
								<div class="col-sm-2 container-bordered cb-hover  " data-bs-toggle="collapse"
									data-bs-target="#info">
									Info
								</div>
								<div class="col-sm-2 container-bordered  cb-hover" data-bs-toggle="collapse"
									data-bs-target="#subjects">
									Subjects
								</div>
								<div class="col-sm-2 container-bordered  cb-hover" data-bs-toggle="collapse"
									data-bs-target="#activities">
									Activities
								</div>

								<div class="col-sm-2 container-bordered  cb-hover" data-bs-toggle="collapse"
									data-bs-target="#attendance">
									Attendance
								</div>

								<div class="col-sm-2 container-bordered  cb-hover" data-bs-toggle="collapse"
									data-bs-target="#grades">
									Grades
								</div>
							</div>

							<?php 
                        if (isset($_SESSION['student_id'])) {
                        
                            $studentId = $_SESSION['student_id'];
                            
                            // Fetch student data from the database
                            $sql = "SELECT * FROM student_info WHERE student_id = :studentId";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':studentId', $studentId);
                            $stmt->execute();
                            
                            // Assuming there is one row of data
                            $studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            // If no data is found, redirect or handle the error
                            if (!$studentInfo) {
                              
                            }
                        }
                        ?>


							<div class="accordion" id="shortcutLinks">
								<div class="container-fluid accordion-collapse collapse bordered" id="info"
									data-bs-parent="#shortcutLinks">
									<div class="accordion-body">
										<p class="text-center bold">Personal Information</p>
										<br>
										<p><strong>Full Name:</strong>
											<?php echo htmlspecialchars($studentInfo['full_name'] ?? 'No information added yet.'); ?>
										</p>
										<p><strong>Email:</strong>
											<?php echo htmlspecialchars($studentInfo['email'] ?? 'No information added yet.'); ?>
										</p>
										<p><strong>Course & Year:</strong>
											<?php echo htmlspecialchars($studentInfo['course_year'] ?? 'No information added yet.'); ?>
										</p>
										<p><strong>Address:</strong>
											<?php echo htmlspecialchars($studentInfo['address'] ?? 'No information added yet.'); ?>
										</p>
										<p><strong>Phone Number:</strong>
											<?php echo htmlspecialchars($studentInfo['phone_number'] ?? 'No information added yet.'); ?>
										</p>
										<p><strong>Emergency Contact:</strong>
											<?php echo htmlspecialchars($studentInfo['emergency_contact'] ?? 'No information added yet.'); ?>
										</p>
										<p><strong>Gender:</strong>
											<?php echo htmlspecialchars($studentInfo['gender'] ?? 'No information added yet.'); ?>
										</p>
									</div>

								</div>

								<div class="container-fluid accordion-collapse collapse bordered" id="subjects"
									data-bs-parent="#shortcutLinks">
									<div class="accordion-body">
										<?php

										$studentId = $_SESSION['student_id'];

										$stmt = $pdo->prepare("SELECT class_id FROM students_enrollments WHERE student_id = ?");
										$stmt->execute([$studentId]);
										$enrolledClasses = $stmt->fetchAll(PDO::FETCH_COLUMN);

										$classes = [];

										if (!empty($enrolledClasses)) {
											// Fetch class details from the 'classes' table using class_id
											$inQuery = implode(',', array_fill(0, count($enrolledClasses), '?')); // For use in WHERE IN clause
											$stmt = $pdo->prepare("SELECT * FROM classes WHERE id IN ($inQuery)");
											$stmt->execute($enrolledClasses);
											$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
										}
										?>
										<div class="container-fluid text-center">
											<div class="d-flex align-items-center">
												<h5>Subjects</h5>&nbsp; <button type="button" class="btn btn-primary"
													data-bs-toggle="modal" data-bs-target="#enterClassModal">
													Enter Class
												</button>
												<div class=" ms-auto" aria-hidden="true">
													<form>
														<input type="text" class="form-control" id="searchClasses"
															placeholder="Search classes by name, subject, or teacher"
															oninput="filterClasses()">
													</form>
												</div>
											</div>
											<div class="row align-items-center mb-4">



											</div>

											<div class="row" id="classesContainer">
												<!-- Display the enrolled classes -->
												<?php if (!empty($classes)): ?>
													<?php foreach ($classes as $class): ?>
														<div class="col mb-4 class-item">
															<div class="card">
																<div class="card-body">
																	<h5 class="card-title class-name">
																		<?php echo htmlspecialchars($class['name']); ?>
																	</h5>
																	<p class="card-text class-subject">
																		<?php echo htmlspecialchars($class['subject']); ?>
																	</p>
																	<p class="card-text class-teacher">Teacher:
																		<?php echo htmlspecialchars($class['teacher']); ?>
																	</p>
																	<p class="card-text class-code">Class Code:
																		<?php echo htmlspecialchars($class['classCode']); ?>
																	</p>
																	<a href="student_classes.php?class_id=<?php echo $class['id']; ?>"
																		class="btn btn-primary">
																		<i class="bi bi-door-open-fill"></i> Go to Class
																	</a>
																</div>
															</div>
														</div>
													<?php endforeach; ?>
												<?php else: ?>
													<p>No classes enrolled.</p>
												<?php endif; ?>
											</div>
										</div>

										<script>
											// JavaScript function to filter classes
											function filterClasses() {
												const searchValue = document.getElementById('searchClasses').value.toLowerCase();
												const classItems = document.querySelectorAll('#classesContainer .class-item');

												classItems.forEach(item => {
													const className = item.querySelector('.class-name').textContent.toLowerCase();
													const classSubject = item.querySelector('.class-subject').textContent.toLowerCase();
													const classTeacher = item.querySelector('.class-teacher').textContent.toLowerCase();
													const classCode = item.querySelector('.class-code').textContent.toLowerCase();

													// Check if the search value matches any relevant text in the card
													if (
														className.includes(searchValue) ||
														classSubject.includes(searchValue) ||
														classTeacher.includes(searchValue) ||
														classCode.includes(searchValue)
													) {
														item.style.display = ''; // Show the class
													} else {
														item.style.display = 'none'; // Hide the class
													}
												});
											}
										</script>

									</div>
								</div>

								<div class="modal fade" id="enterClassModal" tabindex="-1"
									aria-labelledby="enterClassModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="enterClassModalLabel">Enter
													Class Code</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal"
													aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<form method="POST" action="processes/students/class/enter.php">
													<div class="mb-3">
														<label for="classCode" class="form-label">Class
															Code</label>
														<input type="text" class="form-control" id="classCode"
															name="classCode" placeholder="Enter Class Code">
													</div>

											</div>
											<div class="modal-footer">

												<input type="submit" class="btn btn-csms" value="Join">
												</form>
											</div>
										</div>
									</div>
								</div>

								<div class="container-fluid accordion-collapse collapse bordered" id="activities"
									data-bs-parent="#shortcutLinks">
									<div class="accordion-body">
										<h5 class="bold text-center mb-4">Activities List:</h5>
										<div>
											<?php
											try {
												// Fetch the student's ID from the session
												$student_id = $_SESSION['student_id'];

												// Fetch all class IDs the student is enrolled in
												$stmt = $pdo->prepare("SELECT e.class_id, c.subject 
                FROM students_enrollments e
                INNER JOIN classes c ON e.class_id = c.id
                WHERE e.student_id = :student_id");
												$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
												$stmt->execute();
												$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

												if ($classes) {
													foreach ($classes as $class) {
														$class_id = $class['class_id'];
														$subject = htmlspecialchars($class['subject']);
														?>
														<!-- Subject Title -->
														<div class="subject-section mb-4 text-center">
															<h3 class="subject-title text-primary">Subject: <?php echo $subject; ?>
															</h3>

															<!-- Activity Table -->
															<table class="table table-striped table-hover">
																<thead>
																	<tr>
																		<th scope="col">Title</th>
																		<th scope="col">Description</th>
																		<th scope="col">Due Date</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	// Fetch all activities for this class
																	$activityStmt = $pdo->prepare("SELECT title, message, due_date 
                                    FROM activities 
                                    WHERE class_id = :class_id 
                                    ORDER BY due_date ASC");
																	$activityStmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
																	$activityStmt->execute();
																	$activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

																	if ($activities) {
																		foreach ($activities as $activity) {
																			$dueDate = new DateTime($activity['due_date']);
																			$formattedDueDate = $dueDate->format('F j, Y');
																			?>
																			<tr>
																				<td><strong><?php echo htmlspecialchars($activity['title']); ?></strong>
																				</td>
																				<td><?php echo htmlspecialchars($activity['message']); ?>
																				</td>
																				<td><small
																						class="text-muted"><?php echo $formattedDueDate; ?></small>
																				</td>
																			</tr>
																			<?php
																		}
																	} else {
																		echo '<tr><td colspan="3" class="text-center text-muted">No activities found for this subject.</td></tr>';
																	}
																	?>
																</tbody>
															</table>

															<!-- View Details Button -->
															<div class="text-center mt-3">
																<a href="student_classes.php?class_id=<?php echo $class_id; ?>"
																	class="btn btn-primary btn-sm">View Details</a>
															</div>
														</div>
														<?php
													}
												} else {
													echo "<p class='text-muted text-center'>This student is not enrolled in any classes.</p>";
												}
											} catch (PDOException $e) {
												echo "<p class='text-danger text-center'>Error: " . $e->getMessage() . "</p>";
											}
											?>
										</div>
									</div>


								</div>
								<div class="container-fluid accordion-collapse collapse bordered" id="attendance"
									data-bs-parent="#shortcutLinks">
									<div class="accordion-body">
										<?php
										// Include the database connection
										require_once 'processes/server/conn.php';

										// Get the logged-in student's ID
										$studentId = $_SESSION['student_id'] ?? null;

										if ($studentId) {
											// Query to get meetings for classes the student is enrolled in
											$stmtMeetings = $pdo->prepare("
            SELECT cm.id AS meeting_id, cm.date, cm.class_id, cm.status, cm.start_time, cm.end_time, cm.type,
                   c.name AS class_name, c.subject AS subject_name, c.teacher AS teacher_name,
                   s.id AS semesterId
            FROM students_enrollments se
            JOIN classes_meetings cm ON se.class_id = cm.class_id
            JOIN classes c ON cm.class_id = c.id
            JOIN semester s ON c.semester = s.name
            WHERE se.student_id = :student_id
              AND cm.date = CURDATE()
              AND cm.status = 'Ongoing'
              AND s.status = 'active'
        ");
											$stmtMeetings->execute([':student_id' => $studentId]);

											// Check if there are results
											if ($stmtMeetings->rowCount() > 0) {
												echo '<div class="list-group">';
												while ($row = $stmtMeetings->fetch(PDO::FETCH_ASSOC)) {
													// Create the URL for the attendance page
													$attendanceUrl = 'class_attendance_qr.php?class_id=' . urlencode($row['class_id']) .
														'&classAttendanceId=' . urlencode($row['meeting_id']) .
														'&semesterId=' . urlencode($row['semesterId']);

													echo '<div class="list-group-item border-0 mb-3 shadow-sm rounded">';
													echo '<div class="d-flex justify-content-between align-items-center">';
													echo '<div class="pe-3">';
													echo '<h5 class="mb-1 text-primary"><strong>' . htmlspecialchars($row['class_name']) . '</strong></h5>';
													echo '<p class="mb-1"><strong>Subject:</strong> ' . htmlspecialchars($row['subject_name']) . '</p>';
													echo '<p class="mb-1"><strong>Teacher:</strong> ' . htmlspecialchars($row['teacher_name']) . '</p>';
													echo '<p class="mb-1"><strong>Date:</strong> ' . htmlspecialchars($row['date']) . '</p>';
													echo '<p class="mb-1"><strong>Status:</strong> <span class="badge bg-success">' . htmlspecialchars($row['status']) . '</span></p>';
													echo '<p class="mb-1"><strong>Start Time:</strong> ' . htmlspecialchars($row['start_time']) . '</p>';
													echo '<p><strong>End Time:</strong> ' . htmlspecialchars($row['end_time']) . '</p>';
													echo '</div>';
													echo '<div>';
													echo '<a href="' . htmlspecialchars($attendanceUrl) . '" class="btn btn-outline-primary btn-lg d-flex align-items-center">';
													echo '<i class="bi bi-arrow-right-circle me-2"></i> Enter';
													echo '</a>';
													echo '</div>';
													echo '</div>';
													echo '</div>';
												}
												echo '</div>';
											} else {
												echo '<p>No ongoing meetings found for today.</p>';
											}
										} else {
											echo '<p>Student not logged in.</p>';
										}
										?>
									</div>
								</div>

								<div class="container-fluid accordion-collapse collapse bordered" id="grades"
									data-bs-parent="#shortcutLinks">
									<div class="accordion-body">
										<?php
										// Include the database connection
										require_once 'processes/server/conn.php';

										// Get the logged-in student's ID
										$studentId = $_SESSION['student_id'] ?? null;

										if ($studentId) {
											// Query to get enrolled classes for the student
											$stmtClasses = $pdo->prepare("
            SELECT c.id AS class_id, c.name AS class_name, c.subject AS subject_name
            FROM students_enrollments se
            JOIN classes c ON se.class_id = c.id
            WHERE se.student_id = :student_id
        ");
											$stmtClasses->execute([':student_id' => $studentId]);

											if ($stmtClasses->rowCount() > 0) {
												echo '<div class="table-responsive">';
												echo '<table class="table table-bordered">';
												echo '<thead>';
												echo '<tr>';
												echo '<th>Subject</th>';
												echo '<th>Class</th>';
												echo '<th>Midterm Grade</th>';
												echo '<th>Final Grade</th>';

												echo '</tr>';
												echo '</thead>';
												echo '<tbody>';

												while ($row = $stmtClasses->fetch(PDO::FETCH_ASSOC)) {
													$classId = $row['class_id'];
													$subjectName = htmlspecialchars($row['subject_name']);
													$className = htmlspecialchars($row['class_name']);

													// Fetch the grades for this class
													$stmtGrades = $pdo->prepare("
                    SELECT midterm_grade, final_grade 
                    FROM student_grades 
                    WHERE class_id = :class_id AND student_id = :student_id
                ");
													$stmtGrades->execute([':class_id' => $classId, ':student_id' => $studentId]);
													$grades = $stmtGrades->fetch(PDO::FETCH_ASSOC);

													$midtermGrade = $grades ? htmlspecialchars($grades['midterm_grade']) : 'N/A';
													$finalGrade = $grades ? htmlspecialchars($grades['final_grade']) : 'N/A';

													echo '<tr>';
													echo '<td>' . $subjectName . '</td>';
													echo '<td>' . $className . '</td>';
													echo '<td>' . $midtermGrade . '</td>';
													echo '<td>' . $finalGrade . '</td>';

													echo '</tr>';
												}

												echo '</tbody>';
												echo '</table>';
												echo '</div>';
											} else {
												echo '<p>No classes found for this student.</p>';
											}
										} else {
											echo '<p>Student not logged in.</p>';
										}
										?>
									</div>




								</div>






							</div>

						</div>
			</main>


		</div>
	</div>




	<script src="js/app.js"></script>
	<?php
	include('processes/server/modals.php');
	?>




	<script>
		function getTime() {
			const now = new Date();
			const newTime = now.toLocaleString();
			console.log(newTime);
			document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
		}
		setInterval(getTime, 100);

	</script>

</html>

<?php
include('processes/server/alerts.php');
?>