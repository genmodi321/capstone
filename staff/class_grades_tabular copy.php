<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    $_SESSION['STATUS'] = "TEACHER_NOT_LOGGED_IN";
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
        border: 1px solid black
    }

    .btn-csms {
        background-color: #709775;
        color: white;
    }

    .btn-csms:hover {
        border: 1px solid #709775;
    }

    .grey-bg {
        background-color: grey;
        color: white;
    }

    .small-logo {
        height: 125px;
        width: 125px;
    }
</style>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <a href="class_grades.php" class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-right: 5px;"></i>
                    <p class="m-0">Back</p>
                </a>
                <div id="printTable">
                    <div id="page-content-wrapper">
                        <div class="card bg-light border-0 shadow-sm"
                            style="background-color: white !important; padding: 5px;">

                            <div class="card-body">
                                <div
                                    class="container text-center d-flex align-items-center justify-content-center my-3">
                                    <div class="row w-100 d-flex align-items-center justify-content-center">
                                        <div class="col-2 d-flex justify-content-center">
                                            <img src="../external/img/wmsu_Logo-removebg-preview.png"
                                                class="img-fluid small-logo">
                                        </div>
                                        <div class="col-8 text-center">
                                            <h5 class="bold mb-1">Western Mindanao State University</h5>
                                            <h5 class="mb-1">College of Computing Studies</h5>
                                            <h5>Zamboanga City</h5>
                                        </div>
                                        <div class="col-2 d-flex justify-content-center">
                                            <img src="../external/img/ccs_logo-removebg-preview.png"
                                                class="img-fluid small-logo">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <?php
                                // Get the class_id from the URL parameter
                                $class_id = $_GET['id'];


                                // Prepare the SQL statement
                                $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = :class_id");

                                // Bind the class_id parameter
                                $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);

                                // Execute the query
                                $stmt->execute();

                                // Fetch the result
                                $class = $stmt->fetch();

                                if ($class) {
                                    // Extract the class details from the fetched data
                                    $adviser = $class['teacher'];
                                    $subject = $class['subject'];
                                    $year_section = $class['code']; // Assuming 'code' is for year/section
                                    $semester = $class['semester'];
                                    $school_year = date('Y', strtotime($class['datetime_added']));
                                } else {
                                    // If no class is found, display a message
                                    echo "Class not found.";
                                    exit;
                                }

                                ?>

                                <!-- HTML Structure -->
                                <div class="row">
                                    <div class="col">
                                        <h3><b><i class="bi bi-person-circle" style="margin-right: 5px;"></i>
                                                Adviser:</b> <span><?php echo htmlspecialchars($adviser); ?></span></h3>
                                        <h3><b><i class="bi bi-book" style="margin-right: 5px;"></i> Subject:</b>
                                            <span><?php echo htmlspecialchars($subject); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-building" style="margin-right: 5px;"></i> Year and
                                                Section:</b> <span><?php echo htmlspecialchars($year_section); ?></span>
                                        </h3>
                                    </div>
                                    <div class="col">
                                        <h3><b><i class="bi bi-calendar3" style="margin-right: 5px;"></i> Semester:</b>
                                            <span><?php echo htmlspecialchars($semester); ?></span>
                                        </h3>
                                        <h3><b><i class="bi bi-calendar-range" style="margin-right: 5px;"></i> School
                                                Year:</b> <span><?php echo htmlspecialchars($school_year); ?></span>
                                        </h3>
                                    </div>
                                </div>


                                <hr>

                                <table class="print-text" id="class" style="width: 100%; border: 1px solid black;">
                                    <thead style="border: 1px solid black;">
                                        <tr>

                                            <td class="text-center bold" colspan="21">Worksheets</td>
                                        </tr>
                                    </thead style="border: 1px solid black;">

                                    <tr style="border: 1px solid black;">
                                        <td class="text-center bold" colspan="2">Criteria</td>
                                        <td class="text-center bold" colspan="4">Quizzes (20%)</td>
                                        <td class="text-center bold" colspan="2">Total</td>

                                        <td class="text-center bold" colspan="4">Activites (20%)</td>
                                        <td class="text-center bold">Total</td>
                                        <td class="text-center bold" colspan="4">Projects (40%)</td>
                                        <td class="text-center bold">Total</td>
                                        <td class="text-center bold" colspan=2>Exams (20%)</td>
                                        <td class="text-center bold">Total</td>

                                        <td class="text-center bold">GPA</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center bold">No. of Students</td>
                                        <td class="text-center bold">Names of Students</td>
                                        <td class="text-center bold">Q1 (LC) <br> (30)</td>
                                        <td class="text-center bold">Q1 (LB)<br> (30)</td>
                                        <td class="text-center bold">Q3 <br> (30)</td>
                                        <td class="text-center bold">Q4 <br> (30)</td>
                                        <td class="text-center bold">120 (LB)</td>
                                        <td class="text-center bold">120 (LC)</td>
                                        <td class="text-center bold">ACT. 1 <br> (50)</td>
                                        <td class="text-center bold">ACT. 2 <br> (50)</td>
                                        <td class="text-center bold">ACT. 3 <br> (50)</td>
                                        <td class="text-center bold">ACT. 4 <br> (50)</td>
                                        <td class="text-center bold"> 200</td>
                                        <td class="text-center bold"> P. 1 <br> (25)</td>
                                        <td class="text-center bold"> P. 2 <br> (25)</td>
                                        <td class="text-center bold"> P. 3 <br> (25)</td>
                                        <td class="text-center bold"> P. 4 <br> (25)</td>
                                        <td class="text-center bold">100</td>
                                        <td class="text-center bold">Midterms <br>(50)</td>
                                        <td class="text-center bold">Finals <br>(100)</td>
                                        <td class="text-center bold"> 150</td>
                                        <td class="text-center"></td>

                                    </tr>

                                    <tr>
                                        <td class="text-center grey-bg" colspan="2">Male</td>
                                    </tr>

                                    <tr>
                                        <td style="width:1% !important;">1.)</td>
                                        <td>Aquino, Leonard </td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">60/120</td>
                                        <td class="text-center">20/50</td>
                                        <td class="text-center">45/50</td>
                                        <td class="text-center">50/50</td>
                                        <td class="text-center">50/50</td>
                                        <td class="text-center">165/200</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">50</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">150</td>
                                        <td class="text-center">
                                            1.00
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="text-center grey-bg" colspan="2">Female</td>
                                    </tr>

                                    <tr>
                                        <td style="width:1% !important;">1.)</td>
                                        <td>Abdulla, Nurfitra </td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">15/30</td>
                                        <td class="text-center">60/120</td>
                                        <td class="text-center">20/50</td>
                                        <td class="text-center">45/50</td>
                                        <td class="text-center">50/50</td>
                                        <td class="text-center">50/50</td>
                                        <td class="text-center">165/200</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">25/25</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">50</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">150</td>
                                        <td class="text-center">
                                            1.00
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button onclick="printDiv('printTable')" class="btn btn-primary mb-3">
                    <i class="bi bi-printer"></i> Print
                </button>
            </main>


        </div>


        <script src="js/app.js"></script>

        <script>
            function printDiv(divId) {
                var content = document.getElementById(divId).innerHTML;
                var printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`
        <html>
            <head>
                <title>Print Content</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .text-center { text-align: center; }
                    .bold { font-weight: bold; }
                    .grey-bg { background-color: #f8f9fa; }
                    table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
                    .grade { background: none; border: none; cursor: pointer; color: inherit; }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                ${content}
            </body>
        </html>
    `);
                printWindow.document.close();
            }
        </script>
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