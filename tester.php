<?php
include('processes/server/conn.php');
?>

<div class="student-grades">
    <h3>Enrolled Students and Grades</h3>
    <?php
    if (isset($_GET['class_id'])) {
        $class_id = $_GET['class_id'];
        echo $class_id;
        try {
            $class_id = (int) $_GET['class_id']; // Ensure class_id is an integer
    
            $stmt = $pdo->prepare(
                "SELECT s.student_id, s.fullName, sg.grade
                                                             FROM students s
                                                             LEFT JOIN student_grades sg ON s.student_id = sg.student_id AND sg.class_id = :class_id1
                                                             JOIN students_enrollments se ON s.student_id = se.student_id
                                                             WHERE se.class_id = :class_id2"
            );

            $stmt->bindParam(':class_id1', $class_id, PDO::PARAM_INT); // Bind the parameter securely
            $stmt->bindParam(':class_id2', $class_id, PDO::PARAM_INT); // Bind the parameter securely
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }

        // Check if there are students enrolled in the class
        if (!empty($students)) {
            echo "<form method='POST' action='update_grades.php'>";
            echo "<table class='grades-table'>";
            echo "<thead>
                    <tr>
                        <th>Name</th>
                        <th>Grade</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            foreach ($students as $student) {
                $studentId = htmlspecialchars($student['student_id']);
                $fullName = htmlspecialchars($student['fullName']);
                $grade = htmlspecialchars($student['grade'] ?? ''); // Handle null grades
                echo "<tr>
                        <td>$fullName</td>
                        <td>
                            <input type='text' name='grades[$studentId]' value='$grade' class='grade-input'>
                        </td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<button type='submit' class='btn btn-primary'>Save Grades</button>";
            echo "</form>";
        } else {
            // No students enrolled
            echo "<p class='no-students'>No students are enrolled in this class yet.</p>";
        }
    } else {
        // No class selected
        echo "<p class='no-class'>No class selected.</p>";
    }
    ?>
</div>