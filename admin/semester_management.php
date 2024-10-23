<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
	$_SESSION['STATUS'] = "ADMIN_NOT_LOGGED_IN";
	header("Location: admin_login_page.php");
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
	<link rel="stylesheet"
		href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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
</style>

<body>
	<div class="wrapper">
		<?php
		include('sidebar.php')
		?>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>
				<img src="external/img/ccs_logo-removebg-preview.png" class="logo-small">
				<span class="text-white">WMSU - Comprehensive Student Management System </span>
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
								<div class="dropdown-menu-header">
									<div class="position-relative">
										4 New Messages
									</div>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Vanessa Tucker</div>
												<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
												<div class="text-muted small mt-1">15m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">William Harris</div>
												<div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Christina Mason</div>
												<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
												<div class="text-muted small mt-1">4h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Sharon Lessman</div>
												<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all messages</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<span class="text-light">Admin</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">



					<div class="row">

						<div class="col-12">
							<div class="card">

								<div class="card-header">
									<div class="d-flex align-items-center">
										<h5 class="h5 mb-3"><a
												href="index.php"
												class="nav-ham-link">Home</a> / <span>Semester Management</span></h5>

										<div class="ms-auto" aria-hidden="true">
											<img
												src="external/svgs/undraw_favorite_gb6n.svg"
												class=" small-picture img-fluid">
										</div>
									</div>

									<br>

									<h5 class="card-title mb-0">
										<div class="d-flex align-items-center">
											<h3>Semester List</h3>
											<div class="ms-auto" aria-hidden="true">
												<button type="button" class="btn btn-csms" data-bs-toggle="modal" data-bs-target="#createSemesterModal">
													<i class="bi bi-pencil-square"></i> Create a Semester
												</button>
											</div>

										</div>
									</h5>
								</div>
								<div class="card-body">
									<?php
									require 'processes/server/conn.php';

									try {
										// Query to fetch all semesters
										$stmt = $pdo->query("SELECT * FROM semester ORDER BY start_date");

										if ($stmt->rowCount() > 0) {
									?>
											<table id="semesters" class="table responsive" style="width: 100%;">
												<thead class="text-center">
													<tr>
														<th>Semester Name</th>
														<th>Start Date</th>
														<th>End Date</th>
														<th>Status</th>
														<th>Description</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tfoot class="text-center">
													<tr>
														<th>Semester Name</th>
														<th>Start Date</th>
														<th>End Date</th>
														<th>Status</th>
														<th>Description</th>
														<th>Actions</th>
													</tr>
												</tfoot>
												<tbody>
													<?php
													while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													?>
														<tr>
															<td><?php echo htmlspecialchars($row['name']); ?></td>
															<td><?php echo htmlspecialchars($row['start_date']); ?></td>
															<td><?php echo htmlspecialchars($row['end_date']); ?></td>
															<td>
																<?php
																if ($row['status'] == 'active') {
																	echo '<span class="btn btn-success btn-sm">Active</span>';
																} elseif ($row['status'] == 'inactive') {
																	echo '<span class="btn btn-warning btn-sm">Inactive</span>';
																} elseif ($row['status'] == 'archived') {
																	echo '<span class="btn btn-secondary btn-sm">Archived</span>';
																} else {
																	echo '<span class="btn btn-dark btn-sm">Unknown</span>'; // Fallback for any other unexpected status values
																}
																?>
															</td>


															<td><?php echo htmlspecialchars($row['description']); ?></td>
															<td>
																<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#viewModal<?php echo $row['id']; ?>'>
																	<i class='bi bi-eye'></i> View
																</button>
																<button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal<?php echo $row['id']; ?>'>
																	<i class='bi bi-pencil'></i> Edit
																</button>
																<?php 
																				if ($row['status'] != 'active') {
																					?>
																<button type="button" class="btn btn-success" onclick="confirmArchive(<?php echo $row['id']; ?>)">
																	<i class="bi bi-archive"></i> Archive
																</button>
														
																<button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">
																	<i class="bi bi-trash"></i> Delete
																</button>
																<?php } ?>
															</td>
														</tr>

														<!-- View Semester Modal -->
														<div class="modal fade" id="viewModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="viewModalLabel">View Semester</h5>
																		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																	</div>
																	<div class="modal-body">
																		<p><strong>Semester Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
																		<p><strong>Start Date:</strong> <?php echo htmlspecialchars($row['start_date']); ?></p>
																		<p><strong>End Date:</strong> <?php echo htmlspecialchars($row['end_date']); ?></p>
																		<p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
																	</div>
																</div>
															</div>
														</div>

														<!-- Edit Semester Modal -->
														<div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="editModalLabel">Edit Semester</h5>
																		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																	</div>
																	<div class="modal-body">
																		<form action="processes/admin/semester/edit.php?id=<?php echo $row['id'] ?>" method="POST">
																			<div class="mb-3">
																				<label for="semesterNameEdit" class="form-label">Semester Name</label>
																				<input type="text" class="form-control" id="semesterNameEdit" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
																			</div>
																			<div class="mb-3">
																				<label for="startDateEdit" class="form-label">Start Date</label>
																				<input type="date" class="form-control" id="startDateEdit" name="start_date" value="<?php echo htmlspecialchars($row['start_date']); ?>" required>
																			</div>
																			<div class="mb-3">
																				<label for="endDateEdit" class="form-label">End Date</label>
																				<input type="date" class="form-control" id="endDateEdit" name="end_date" value="<?php echo htmlspecialchars($row['end_date']); ?>" required>
																			</div>
																			<div class="mb-3">
																				<label for="descriptionEdit" class="form-label">Description</label>
																				<textarea class="form-control" id="descriptionEdit" name="description" rows="3" required><?php echo htmlspecialchars($row['description']); ?></textarea>
																			</div>
																			<?php
																			if ($row['status'] == 'inactive') {
																			?>
																				<a href="processes/admin/semester/make_active.php?id=<?php echo $row['id'] ?>" class="btn btn-success">Make as Active Semester</a>
																			<?php } ?>
																			<?php
																			if ($row['status'] == 'active') {
																			?>
																				<a href="processes/admin/semester/make_inactive.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">Make as Inactive Semester</a>
																			<?php } ?>
																			<button type="submit" class="btn btn-primary">Update Semester</button>
																		</form>
																	</div>
																</div>
															</div>
														</div>

													<?php } ?>
												</tbody>
											</table>
									<?php
										} else {
											echo "<h1 class='text-center'>No semesters available</h1>";
										}
									} catch (PDOException $e) {
										echo "<p class='text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
									}
									?>
								</div>

							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	</div>

	</div>
	</main>


	</div>
	</div>

	<!-- Create Semester Modal -->
	<div class="modal fade" id="createSemesterModal" tabindex="-1" aria-labelledby="createSemesterModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="createSemesterModalLabel">Create New Semester</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="createSemesterForm" action="processes/admin/semester/add.php" method="POST" onsubmit="return validateDates()">
						<div class="mb-3">
							<label for="semesterName" class="form-label">Semester Name</label>
							<input type="text" class="form-control" id="semesterName" name="name" required>
						</div>
						<div class="mb-3">
							<label for="startDate" class="form-label">Start Date</label>
							<input type="date" class="form-control" id="startDate" name="start_date" required>
						</div>
						<div class="mb-3">
							<label for="endDate" class="form-label">End Date</label>
							<input type="date" class="form-control" id="endDate" name="end_date" required>
						</div>
						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea class="form-control" id="description" name="description" rows="3" required></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Create Semester</button>
					</form>
				</div>
			</div>
		</div>
	</div>





	<script src="js/app.js"></script>
	<?php
	include('processes/server/modals.php');
	?>


<script>
    function validateDates() {
        const startDate = new Date(document.getElementById('startDate').value);
        const endDate = new Date(document.getElementById('endDate').value);

        if (endDate <= startDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date',
                text: 'End date must be after the start date.',
            });
            return false; 
        }
        return true;
    }
</script>



	<script>
		function getTime() {
			const now = new Date();
			const newTime = now.toLocaleString();
			console.log(newTime);
			document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
		}
		setInterval(getTime, 100);
		$(document).ready(function() {
			$.fn.dataTable.ext.type.order['status-pre'] = function(data) {
				if (data === 'pending') {
					return 1;
				} else if (data === 'accepted') {
					return 2;
				} else if (data === 'rejected') {
					return 3;
				}
				return 4;
			};
			var table = $('#semesters').DataTable({
				responsive: true,
				columnDefs: [{
					type: 'status',
					targets: 4
				}],
				order: [
					[4, 'desc']
				]

			});



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
			table.columns.adjust().responsive.recalc();
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
				title: 'Are you sure to delete this semester?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					var form = document.createElement('form');
					form.method = 'POST';
					form.action = 'processes/admin/semester/delete.php';
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

		function confirmArchive(id) {
			Swal.fire({
				title: 'Are you sure to archive this semester?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, archive it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					var form = document.createElement('form');
					form.method = 'POST';
					form.action = 'processes/admin/classes/archive.php';
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