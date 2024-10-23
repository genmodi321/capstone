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

<?php
include 'processes/server/conn.php';
$query = "SELECT id, name, type, code, semester FROM subjects";
$result = $pdo->query($query);
$subjectData = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $subjectData[] = [
        'id' => htmlspecialchars(($row['id'])),
        'name' => htmlspecialchars($row['name']),
        'type' => htmlspecialchars($row['type']),
        'code' => htmlspecialchars($row['code']),
        'semester' => htmlspecialchars($row['semester']),
        'actions' => '' 
    ];
}
$subjectDataJSON = json_encode($subjectData);
?>

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
					<?php
					include('top-bar.php');
					?>
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
												class="nav-ham-link">Home</a> / <span>Subject Management</span></h5>

										<div class="ms-auto" aria-hidden="true">
											<img
												src="external/svgs/undraw_favorite_gb6n.svg"
												class=" small-picture img-fluid">
										</div>
									</div>

									<br>

									<h5 class="card-title mb-0">
										<div class="d-flex align-items-center">
											<h3>Subject List</h3>
											<div class="ms-auto" aria-hidden="true">
												<button type="button" class="btn btn-csms"
													data-bs-toggle="modal"
													data-bs-target="#createSubjectModal"><i
														class="bi bi-pencil-square"></i>
													Create Subject</button>
											</div>

										</div>
									</h5>
								</div>
								<div class="card-body">
									<h1 id="noDataMessage" style="display:none; text-align:center">No subjects added, yet!</h1>
									<table id="classes" class="responsive" style="width:100%">
										<tfoot id="table-footer">
											<tr>
												<th>Subject Name</th>
												<th>Subject Type</th>
												<th>Subject Code</th>
												<th>Semester</th>
												<th>Actions</th>
											</tr>
										</tfoot>
									</table>
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




	<script src="js/app.js"></script>
	<?php
	include('processes/server/modals.php');
	?>
<div class="modal fade" id="createSubjectModal" tabindex="-1"
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
                <form method="POST" action="processes/admin/subjects/add.php">
                    <div class="mb-3">
                        <label for="class" class="form-label">Subject Name </label>
                        <input type="text" class="form-control"
                            id="subjectName" name="subjectName" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Subject Code </label>
                        <input type="text" class="form-control"
                            id="subjectCode" name="subjectCode" required>
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Select
                            Class: </label>
                        <select class="form-select" name="class" required>
                            <option selected>Select a class</option>
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
                        <label for="type" class="form-label">Class Type </label>
                        <select class="form-control" name="type" id=type>
                        <option default selected disabled> Select class type below</option>
                        <option value="Lecture">Lecture</option>
                        <option value="Laboratory">Laboratory</option>
                        </select>
                     
                    </div>

                    <div class="mb-3">
                        <label for="teacher" class="form-label">Select
                            Teacher: </label>
                        <select class="form-select" name="teacher" required>
                            <option default selected disabled> Select a teacher below</option>
                            <?php
                            require 'processes/server/conn.php';
                            $sql = "SELECT id, fullName FROM staff_accounts";
                            $stmt = $pdo->query($sql);
                            if ($stmt->rowCount() > 0) {

                                while ($teacher = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    echo '<option value="' . htmlspecialchars($teacher["fullName"]) . '">' . htmlspecialchars($teacher["fullName"]) . '</option>';
                                }
                            } else {
                                echo '<option disabled>There is no staff added yet!</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Select
                            Semester: </label>
                            <?php
$semesters = [];
try {
    $stmt = $pdo->query("SELECT name FROM semester");
    $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching semesters: " . $e->getMessage();
}
?>

<select class="form-select" name="semester" required>
    <option selected>Select a Semester</option>
    <?php if (!empty($semesters)): ?>
        <?php foreach ($semesters as $semester): ?>
            <option value="<?= htmlspecialchars($semester['name']) ?>"><?= htmlspecialchars($semester['name']) ?></option>
        <?php endforeach; ?>
    <?php else: ?>
        <option disabled>No semesters available</option>
    <?php endif; ?>
</select>

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
require 'processes/server/conn.php';

$staffQuery = "SELECT id, fullName FROM staff_accounts";
$staffStmt = $pdo->query($staffQuery);
$staffMembers = $staffStmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM subjects";
$stmt = $pdo->query($sql);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($subjects as $subject) {
    $modalId = $subject['id'];
?>
    <div class="modal fade" id="viewModal<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Viewing Subject: <?php echo htmlspecialchars($subject['name']); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label bold">Subject Name</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['name']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label bold ">Subject Code</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['code']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label bold">Semester</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($subject['semester']); ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editModal<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Subject: <?php echo htmlspecialchars($subject['name']); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSubjectForm<?php echo $subject['id']; ?>" method="POST" action="processes/admin/subjects/edit.php?id=<?php echo $subject['id'] ?>">
                        <input type="hidden" id="editSubjectId<?php echo $subject['id']; ?>" name="id" value="<?php echo $subject['id']; ?>">
                        <div class="mb-3">
                            <label for="editSubjectName<?php echo $subject['id']; ?>" class="form-label">Subject Name</label>
                            <input type="text" class="form-control" id="editSubjectName<?php echo $subject['id']; ?>" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSubjectCode<?php echo $subject['id']; ?>" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="editSubjectCode<?php echo $subject['id']; ?>" name="code" value="<?php echo htmlspecialchars($subject['code']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editClass<?php echo $subject['id']; ?>" class="form-label">Select Class</label>
                            <select class="form-select" id="editClass<?php echo $subject['id']; ?>" name="class">
                  
                                <?php
                                $classes = [
                                    'Department of Information Technology' => [
                                        'BSIT-1A',
                                        'BSIT-1B',
                                        'BSIT-2A',
                                        'BSIT-2B',
                                        'BSIT-3A',
                                        'BSIT-3B',
                                        'BSIT-4A',
                                        'BSIT-4B'
                                    ],
                                    'Department of Computer Science' => [
                                        'BSCS-1A',
                                        'BSCS-1B',
                                        'BSCS-2A',
                                        'BSCS-2B',
                                        'BSCS-3A',
                                        'BSCS-3B',
                                        'BSCS-4A',
                                        'BSCS-4B'
                                    ]
                                ];

                              
                                foreach ($classes as $category => $classGroup) {
                                   
                                    echo "<optgroup label=\"$category\">";

                               
                                    foreach ($classGroup as $class) {
                                        $selected = ($subject['class'] === $class) ? 'selected' : '';
                                        echo "<option value=\"$class\" $selected>$class</option>";
                                    }

                                    echo "</optgroup>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="mb-3">
                        <label for="type" class="form-label">Class Type </label>
                        <select class="form-control" name="type" id=type>
                        <option default selected disabled> Select class type below</option>
                        <option value="Lecture">Lecture</option>
                        <option value="Laboratory">Laboratory</option>
                        </select>
                     
                    </div>

                        <div class="mb-3">
                            <label for="editTeacher<?php echo $subject['id']; ?>" class="form-label">Select Teacher</label>
                            <select class="form-select" id="editTeacher<?php echo $subject['id']; ?>" name="teacher">
                                <?php
                                require 'processes/server/conn.php';
                                foreach ($staffMembers as $staff) {
                                    $selected = ($subject['teacher'] == $staff['fullName']) ? 'selected' : '';
                                    echo "<option value=\"{$staff['fullName']}\" $selected>{$staff['fullName']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editSemester<?php echo $subject['id']; ?>" class="form-label">Select Semester</label>
                            <select class="form-select" id="editSemester<?php echo $subject['id']; ?>" name="semester">
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
?>

<script>
    var subjectData = <?php echo $subjectDataJSON; ?>;

    if (subjectData.length > 0) {
        $('#classes').show();

        var table = $('#classes').DataTable({
            responsive: true,
            data: subjectData.map(row => {
                row.actions = `
                    <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#viewModal${row.id}">
                        <i class="bi bi-eye"></i> View
                    </button>
                    <button type="button" class="btn btn-warning edit-btn" data-bs-toggle="modal" data-bs-target="#editModal${row.id}">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger delete-btn" data-id="${row.id}">
                        <i class="bi bi-trash"></i> Delete
                    </button>`;
                return [
                    `${row.name}`,
					row.type,
                    row.code,
                    row.semester,
                    row.actions
                ];
            }),
            columns: [
                { title: 'Subject Name' },
				{ title: 'Subject Type' },
                { title: 'Subject Code' },
              
                { title: 'Semester' },
                { title: 'Actions', orderable: false }
            ]
        });

        // Ensure the table layout is adjusted properly
        table.columns.adjust().responsive.recalc();

        $(document).on('click', '.delete-btn', function() {
            var subjectId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'processes/admin/subjects/delete.php?id=' + subjectId;
                }
            });
        });
    } else {
        $('#noDataMessage').show();
        $('#table-footer').hide();
    }
</script>




<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        document.getElementById('sidebarContainer').classList.toggle('collapsed');
    });
</script>
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

	$(document).ready(function() {
    var table = $('#classes').DataTable();

    // Create input fields in the footer for search functionality
    $('#classes tfoot th').each(function() {
        var title = $(this).text();
        if (title === 'Subject Type') { // Assuming 'Subject Type' is the header name
            $(this).html(`
                <select class="selector">
                    <option value="">All</option>
                    <option value="lecture">Lecture</option>
                    <option value="laboratory">Laboratory</option>
                </select>
            `);
        } else {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }
    });

    // Apply search functionality for the input fields
    table.columns().every(function() {
        var that = this;

        // Handle text input for all columns except 'Subject Type'
        $('input', this.footer()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });

        // Handle the dropdown for the 'Subject Type'
        $('select', this.footer()).on('change', function() {
            var selectedValue = $(this).val();
            if (that.search() !== selectedValue) {
                that
                    .search(selectedValue ? '^' + selectedValue + '$' : '', true, false)
                    .draw();
            }
        });
    });
});



    $(document).ready(function() {
        var subjects = {

            'BSIT-4A': [{
                    value: 'Software Engineering',
                    text: 'Software Engineering'
                },
                {
                    value: 'Capstone Project and Research I',
                    text: 'Capstone Project and Research I'
                },
                {
                    value: 'Networks',
                    text: 'Networks'
                }
            ],
            'BSIT-4B': [{
                    value: 'Capstone Project and Research I',
                    text: 'Capstone Project and Research I'
                },
                {
                    value: 'Software Engineering',
                    text: 'Software Engineering'
                },
                {
                    value: 'Networks',
                    text: 'Networks'
                }
            ]
        };

        var assignedSubjects = {
            'BSIT-4A': [
                'Software Engineering',
            ],
            'BSIT-4B': [
                'Capstone Project and Research I',

            ]
        };


        $('#class-select').change(function() {
            var classSelected = $(this).val();
            var subjectSelect = $('#subject-select');
            var assignedSubjectsContainer = $('#assigned-subjects-container');

            subjectSelect.empty();
            assignedSubjectsContainer.empty();

            if (classSelected !== 'Select a class') {

                $.each(subjects[classSelected], function(index, subject) {
                    subjectSelect.append($('<option>', {
                        value: subject.value,
                        text: subject.text
                    }));
                });


                $.each(assignedSubjects[classSelected], function(index, subject) {
                    assignedSubjectsContainer.append(
                        '<div class="col"><small>' + subject + '</small></div>' +
                        '<div class="col"><a href="#" class="remove-subject">Remove</a></div>'
                    );
                });
            } else {
                subjectSelect.append($('<option>', {
                    text: 'Select a class first'
                }));

                assignedSubjectsContainer.append('<div class="col"><small>No subjects assigned</small></div>');
            }
        });


        $('#subject-select').change(function() {
            var subjectSelected = $(this).val();
            var assignedSubjectsContainer = $('#assigned-subjects-container');

            var exists = assignedSubjectsContainer.find('.col:contains("' + subjectSelected + '")').length;
            if (!exists && subjectSelected !== 'Select a class first') {
                assignedSubjectsContainer.append(
                    '<div class="col"><small>' + subjectSelected + '</small></div>' +
                    '<div class="col"><a href="#" class="remove-subject">Remove</a></div>'
                );
            }
        });


        $(document).on('click', '.remove-subject', function(e) {
            e.preventDefault();
            $(this).closest('.col').prev('.col').remove();
            $(this).closest('.col').remove();
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

</html>

<?php
include('processes/server/alerts.php');
?>