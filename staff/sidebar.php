<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <div class="text-center">
            <p class="text-light time" id="currentTime"> </p>
        </div>
        <div class="sidebar-brand text-center" href="index.html">
            <img src="external/img/ccs_logo-removebg-preview.png" class="img-fluid logo">
            <?php
            // Start the session to access the teacher's session ID
            
            // Check if the teacher's ID is set in the session
            if (isset($_SESSION['teacher_id'])) {
                $teacher_id = $_SESSION['teacher_id'];

                // Assuming $pdo is the PDO connection to the database
                try {
                    // Query to select the teacher's full name from staff_accounts based on the session teacher ID
                    $stmt = $pdo->prepare("SELECT fullName FROM staff_accounts WHERE id = :teacher_id");
                    $stmt->bindParam(':teacher_id', $teacher_id);
                    $stmt->execute();

                    // Fetch the teacher's details
                    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Check if the teacher's data was found
                    if ($teacher) {
                        // Display the teacher's name in the greeting
                        echo '<h3 class="align-middle text-light bold">Welcome, ' . htmlspecialchars($teacher['fullName']) . '!</h3>';
                    } else {
                        // Handle the case where no teacher was found (optional)
                        echo '<h1 class="align-middle text-light bold">Welcome, Teacher!</h1>';
                    }
                } catch (PDOException $e) {
                    // Error handling (optional)
                    echo "Error: " . $e->getMessage();
                }
            } else {
                // If the session does not contain a teacher ID, show a default message
                echo '<h1 class="align-middle text-light bold">Welcome, Teacher!</h1>';
            }
            ?>

            <!-- Edit Profile Button -->
            <button type="button" class="btn btn-csms mt-2" data-bs-toggle="modal" data-bs-target="#editStaffModal">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </button>
        </div>




        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="index.php">
                    <i class="bi bi-sliders align-middle"></i> <span class="align-middle">Index</span>
                </a>
            </li>
            <hr style="border-bottom: 1px solid white;">

            <li class="sidebar-item <?php echo ($current_page == 'class_management.php') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="class_management.php">
                    <i class="bi bi-people align-middle"></i> <span class="align-middle">Class Management</span>
                </a>
            </li>

            <li class="sidebar-item <?php echo ($current_page == 'subject_management.php') ? 'active' : ''; ?>">
                <a class="sidebar-link">
                    <i class="bi bi-journal align-middle"></i> <span class="align-middle">Subject Management</span>
                </a>
            </li>





            <hr style="border-bottom: 1px solid white;">

            <li class="sidebar-item <?php echo ($current_page == 'teacher_management.php') ? 'active' : ''; ?>">
                <a class="sidebar-link" href="">
                    <i class="bi bi-person-badge align-middle"></i> <span class="align-middle">Teacher User</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<?php
$teacher_id = $_SESSION['teacher_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM staff_accounts WHERE id = :teacher_id");
    $stmt->execute(['teacher_id' => $teacher_id]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$teacher) {
        echo "Teacher not found.";
        exit;
    }

    // Store teacher details to be used in the modal
    $fullName = $teacher['fullName'];
    $email = $teacher['email'];
    $department = $teacher['department'];
    $class = $teacher['class'];
    $phone_number = $teacher['phone_number'];
    $gender = $teacher['gender'];


} catch (PDOException $e) {
    echo "An error occurred while fetching the teacher's data: " . $e->getMessage();
}
?>

<!-- Modal for Editing Staff Information -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">Edit Staff Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName"
                            value="<?php echo htmlspecialchars($fullName); ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Department -->
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="Department of Information Technology" <?php echo ($department == 'Department of Information Technology') ? 'selected' : ''; ?>>Department of Information Technology
                            </option>
                            <option value="Department of Computer Science" <?php echo ($department == 'Department of Computer Science') ? 'selected' : ''; ?>>Department of Computer Science</option>
                        </select>
                    </div>

                    <!-- Class -->
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-select" id="class" name="class" required>
                            <option value="BSIT-1A" <?php echo ($class == 'BSIT-1A') ? 'selected' : ''; ?>>BSIT-1A
                            </option>
                            <option value="BSIT-1B" <?php echo ($class == 'BSIT-1B') ? 'selected' : ''; ?>>BSIT-1B
                            </option>
                            <option value="BSIT-2A" <?php echo ($class == 'BSIT-2A') ? 'selected' : ''; ?>>BSIT-2A
                            </option>
                            <option value="BSIT-2B" <?php echo ($class == 'BSIT-2B') ? 'selected' : ''; ?>>BSIT-2B
                            </option>
                            <option value="BSIT-3A" <?php echo ($class == 'BSIT-3A') ? 'selected' : ''; ?>>BSIT-3A
                            </option>
                            <option value="BSIT-3B" <?php echo ($class == 'BSIT-3B') ? 'selected' : ''; ?>>BSIT-3B
                            </option>
                            <option value="BSIT-4A" <?php echo ($class == 'BSIT-4A') ? 'selected' : ''; ?>>BSIT-4A
                            </option>
                            <option value="BSIT-4B" <?php echo ($class == 'BSIT-4B') ? 'selected' : ''; ?>>BSIT-4B
                            </option>
                            <option value="BSCS-1A" <?php echo ($class == 'BSCS-1A') ? 'selected' : ''; ?>>BSCS-1A
                            </option>
                            <option value="BSCS-1B" <?php echo ($class == 'BSCS-1B') ? 'selected' : ''; ?>>BSCS-1B
                            </option>
                            <option value="BSCS-2A" <?php echo ($class == 'BSCS-2A') ? 'selected' : ''; ?>>BSCS-2A
                            </option>
                            <option value="BSCS-2B" <?php echo ($class == 'BSCS-2B') ? 'selected' : ''; ?>>BSCS-2B
                            </option>
                            <option value="BSCS-3A" <?php echo ($class == 'BSCS-3A') ? 'selected' : ''; ?>>BSCS-3A
                            </option>
                            <option value="BSCS-3B" <?php echo ($class == 'BSCS-3B') ? 'selected' : ''; ?>>BSCS-3B
                            </option>
                            <option value="BSCS-4A" <?php echo ($class == 'BSCS-4A') ? 'selected' : ''; ?>>BSCS-4A
                            </option>
                            <option value="BSCS-4B" <?php echo ($class == 'BSCS-4B') ? 'selected' : ''; ?>>BSCS-4B
                            </option>
                        </select>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="<?php echo htmlspecialchars($phone_number); ?>" required>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Ensure teacher is logged in

if (!isset($_SESSION['teacher_id'])) {
    echo "Teacher is not logged in.";
    exit;
}

try {
    // Get the teacher's ID
    $teacher_id = $_SESSION['teacher_id'];

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the data from the form
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $department = $_POST['department'];
        $class = $_POST['class'];
        $phone_number = $_POST['phone_number'];
        $gender = $_POST['gender'];

        // Update the staff account in the database
        $stmt = $pdo->prepare("UPDATE staff_accounts SET fullName = :fullName, email = :email, password = :password, department = :department, class = :class, phone_number = :phone_number, gender = :gender WHERE id = :teacher_id");

        $stmt->execute([
            'fullName' => $fullName,
            'email' => $email,
            'password' => $password,
            'department' => $department,
            'class' => $class,
            'phone_number' => $phone_number,
            'gender' => $gender,
            'teacher_id' => $teacher_id
        ]);

        $_SESSION['STATUS'] = "NEW_INFO_SUCCESFUL";
    }
} catch (PDOException $e) {
    error_log("Error updating staff: " . $e->getMessage());
    $_SESSION['STATUS'] = "NEW_INFO_ERROR";
}
?>