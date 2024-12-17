<?php
require 'processes/server/conn.php';

// Get semester_id and optional subject_id from the query string
$semester_id = $_GET['semester_id'] ?? 18;
$subject_id = $_GET['subject_id'] ?? 42; // Optional parameter

$semesterQuery = $pdo->prepare("SELECT name, start_date, end_date FROM semester WHERE id = :semester_id");
$semesterQuery->execute(['semester_id' => $semester_id]);
$semester = $semesterQuery->fetch(PDO::FETCH_ASSOC);

if (!$semester) {
    echo json_encode(['error' => "No semester found with ID: $semester_id"]);
    exit;
}

// Prepare the SQL query to fetch schedules for the specific semester
$sql = "
    SELECT sch.meeting_days, sch.start_time, sch.end_time, s.name AS subject_name 
    FROM subjects_schedules sch 
    JOIN subjects s ON s.id = sch.subject_id 
    WHERE s.semester = :semester_name AND s.is_archived = 0
";

$params = ['semester_name' => $semester['name']];

// If subject_id is provided, filter by it
if ($subject_id !== null) {
    $sql .= " AND s.id = :subject_id";
    $params['subject_id'] = $subject_id;
}

$scheduleQuery = $pdo->prepare($sql);
if (!$scheduleQuery->execute($params)) {
    echo json_encode(['error' => "Query execution failed: " . implode(", ", $scheduleQuery->errorInfo())]);
    exit;
}

$schedules = $scheduleQuery->fetchAll(PDO::FETCH_ASSOC);

$events = [];
$meetingDaysSet = []; // To hold meeting days for background coloring
$start = new DateTime($semester['start_date']);
$end = new DateTime($semester['end_date']);
$interval = new DateInterval('P1D');
$period = new DatePeriod($start, $interval, $end);

// Process each schedule to create events
foreach ($schedules as $schedule) {
    $meetingDays = explode(',', $schedule['meeting_days']);
    foreach ($period as $date) {
        if (in_array($date->format('l'), $meetingDays)) {
            $eventStart = $date->format('Y-m-d') . 'T' . $schedule['start_time'];
            $eventEnd = $date->format('Y-m-d') . 'T' . $schedule['end_time'];
            $events[] = [
                'title' => $schedule['subject_name'] . " - Meeting",
                'start' => $eventStart,
                'end' => $eventEnd,
                'color' => '#28a745' // Optional color for meeting days
            ];
            $meetingDaysSet[] = $date->format('Y-m-d'); // Add the meeting day to the set
        }
    }
}

header('Content-Type: application/json');
echo json_encode(['events' => $events, 'meetingDays' => array_unique($meetingDaysSet)]);
