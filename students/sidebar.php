<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <div class="text-center">
            <p class="text-light time" id="currentTime"></p>
        </div>
        <div class="sidebar-brand text-center" href="index.html">
            <?php
            // Assuming the session contains user info or student_id for lookup
// Get the student info from the database
            $stmt = $pdo->prepare("SELECT picture FROM student_info WHERE student_id = :student_id");
            $stmt->execute([':student_id' => $_SESSION['user_id']]); // Use the logged-in student's ID
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the student has a profile picture
            $profilePicture = !empty($student['picture']) ? $student['picture'] : 'ccs_logo-removebg-preview.png';
            
            ?>
            

            <!-- Display the profile picture or default image -->
            <img src="<?= '../uploads/profile_pictures/' . $profilePicture ?>" class="img-fluid logo" alt="Profile Picture">


            <?php
            if (isset($_SESSION['student_id'])) {
                $student_id = $_SESSION['student_id'];

                try {
                    $stmt = $pdo->prepare("SELECT fullName FROM students WHERE student_id = :student_id");
                    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $student = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($student) {
                        echo '<h3 class="align-middle text-light bold">Welcome, ' . htmlspecialchars($student['fullName']) . '!</h3>';
                    } else {
                        echo '<h1 class="align-middle text-light bold">Welcome, Student!</h1>';
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo '<h1 class="align-middle text-light bold">Welcome, Student!</h1>';
            }
            ?>

            <!-- Four Buttons -->
            <div class="mt-3">
                <button type="button" class="btn btn-csms w-100 mb-2" data-bs-toggle="modal"
                    data-bs-target="#updateProfileModal">
                    <i class="bi bi-pencil-square"></i> Update Profile
                </button>
                <button type="button" class="btn btn-csms w-100 mb-2" data-bs-toggle="modal"
                    data-bs-target="#changePasswordModal">
                    <i class="bi bi-lock"></i> Change Password
                </button>

                <button type="button" class="btn btn-csms w-100 mb-2" data-bs-toggle="modal"
                    data-bs-target="#updateProfilePictureModal">
                    <i class="bi bi-person-circle"></i> Update Profile Picture
                </button>
            </div>
        </div>

    </div>
</nav>

<?php
// Check if student_id is in session
if (isset($_SESSION['student_id'])) {
    $studentId = $_SESSION['student_id'];

    // Fetch student data from the database
    $sql = "SELECT * FROM student_info WHERE student_id = :studentId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':studentId', $studentId);
    $stmt->execute();

    // Assuming there is one row of data
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no data is found, redirect or handle the error
    if (!$studentData) {

    }
}
?>

<!-- Modals -->
<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST">
                    <!-- Student ID Field (Read-only) -->
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId" required
                            value="<?php echo $_SESSION['student_id'] ?? 'N/A'; ?>" readonly>
                    </div>

                    <!-- Student Name Field -->
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" required
                            value="<?php echo htmlspecialchars($studentData['full_name'] ?? ''); ?>">
                    </div>

                    <!-- Student Email Field -->
                    <div class="mb-3">
                        <label for="studentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="studentEmail" name="studentEmail" required
                            value="<?php echo htmlspecialchars($studentData['email'] ?? ''); ?>">
                    </div>

                    <!-- Student Phone Number Field -->
                    <div class="mb-3">
                        <label for="studentPhone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="studentPhone" name="studentPhone" required
                            value="<?php echo htmlspecialchars($studentData['phone_number'] ?? ''); ?>">
                    </div>

                    <!-- Course Year Field -->
                    <div class="mb-3">
                        <label for="courseYear" class="form-label">Course & Year</label>
                        <input type="text" class="form-control" id="courseYear" name="courseYear" required
                            value="<?php echo htmlspecialchars($studentData['course_year'] ?? ''); ?>">
                    </div>

                    <!-- Address Field -->
                    <div class="mb-3">
                        <label for="studentAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="studentAddress" name="studentAddress" required
                            value="<?php echo htmlspecialchars($studentData['address'] ?? ''); ?>">
                    </div>

                    <!-- Emergency Contact Field -->
                    <div class="mb-3">
                        <label for="emergencyContact" class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control" id="emergencyContact" name="emergencyContact" required
                            value="<?php echo htmlspecialchars($studentData['emergency_contact'] ?? ''); ?>">
                    </div>

                    <!-- Gender Field -->
                    <div class="mb-3">
                        <label for="studentGender" class="form-label">Gender</label>
                        <select class="form-select" id="studentGender" name="studentGender" required>
                            <option value="" disabled <?php echo empty($studentData['gender']) ? 'selected' : ''; ?>>Select Gender</option>
                            <option value="Male" <?php echo ($studentData['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($studentData['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($studentData['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="change_password.php" method="POST">
                    <!-- New Password Field -->
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                            required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Event listener for form submission
    document.getElementById('changePasswordForm').addEventListener('submit', function (event) {
        var newPassword = document.getElementById('newPassword').value;
        var confirmPassword = document.getElementById('confirmPassword').value;

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            alert("Passwords do not match.");
            event.preventDefault(); // Prevent form submission
        }
    });
</script>


<!-- Update Course & Year Modal -->
<div class="modal fade" id="updateCourseYearModal" tabindex="-1" aria-labelledby="updateCourseYearModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCourseYearModalLabel">Update Course & Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="update_course_year.php" method="POST">
                    <div class="mb-3">
                        <label for="course" class="form-label">Course</label>
                        <input type="text" class="form-control" id="course" name="course" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year" min="1" max="5" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Profile Picture Modal -->
<div class="modal fade" id="updateProfilePictureModal" tabindex="-1" aria-labelledby="updateProfilePictureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfilePictureModalLabel">Update Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="new_profile_picture.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profilePicture" class="form-label">Upload Profile Picture</label>
                        <input type="file" class="form-control" id="profilePicture" name="profilePicture" required
                            accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

            </div>
        </div>
    </div>
</div>