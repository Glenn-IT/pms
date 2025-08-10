<?php 
require_once('../../config.php');

if(!isset($_POST['event_id'])) {
    echo '<script>alert("Invalid event ID."); history.back();</script>';
    exit;
}

$event_id = intval($_POST['event_id']);
$zone_filter = isset($_POST['zone_filter']) ? trim($_POST['zone_filter']) : '';
$event_title = isset($_POST['event_title']) ? $_POST['event_title'] : 'Event';

// Validate event exists
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if($event_qry->num_rows == 0) {
    echo '<script>alert("Event not found."); history.back();</script>';
    exit;
}
$event = $event_qry->fetch_assoc();

// Build the query with optional zone filter
$zone_condition = '';
$zone_text = 'All Zones';
if(!empty($zone_filter)) {
    $zone_filter = $conn->real_escape_string($zone_filter);
    $zone_condition = "AND u.zone = '{$zone_filter}'";
    $zone_text = $zone_filter;
}

// Get absent users (those who didn't scan QR for this event)
$absentees_qry = $conn->query("
    SELECT 
        u.id as user_id,
        CONCAT(u.firstname, ' ', COALESCE(CONCAT(u.middlename, ' '), ''), u.lastname) as user_name,
        u.zone as user_zone,
        u.contact_no,
        u.email
    FROM `users` u 
    WHERE u.status = 1 
    AND u.type != 1
    AND u.id NOT IN (
        SELECT ea.user_id 
        FROM `event_attendance` ea 
        WHERE ea.event_id = '{$event_id}' 
        AND ea.status = 'present'
    )
    {$zone_condition}
    ORDER BY u.lastname ASC, u.firstname ASC
");

// Get statistics for summary
$present_qry = $conn->query("
    SELECT COUNT(*) as present_count 
    FROM `event_attendance` ea 
    WHERE ea.event_id = '{$event_id}' 
    AND ea.status = 'present'
");
$present_count = $present_qry->fetch_assoc()['present_count'];

$total_users_qry = $conn->query("
    SELECT COUNT(*) as total_count 
    FROM `users` 
    WHERE status = 1 AND type != 1
    " . (!empty($zone_condition) ? $zone_condition : "")
);
$total_users = $total_users_qry->fetch_assoc()['total_count'];
$absent_count = $absentees_qry->num_rows;
$attendance_rate = $total_users > 0 ? round(($present_count / $total_users) * 100, 1) : 0;

// Set headers for CSV download
$filename = "Absent_Attendees_" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $event['title']) . "_" . date('Y-m-d') . ".csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Create output stream
$output = fopen('php://output', 'w');

// Add UTF-8 BOM for Excel compatibility
fwrite($output, "\xEF\xBB\xBF");

// Add CSV headers with event info
fputcsv($output, [
    'Event: ' . $event['title'],
    'Date: ' . date("M d, Y h:i A", strtotime($event['date_created'])),
    'Zone Filter: ' . $zone_text,
    'Export Date: ' . date('M d, Y h:i A')
]);

// Add summary statistics
fputcsv($output, []);
fputcsv($output, ['ATTENDANCE SUMMARY']);
fputcsv($output, ['Total Registered Users:', $total_users]);
fputcsv($output, ['Present:', $present_count]);
fputcsv($output, ['Absent:', $absent_count]);
fputcsv($output, ['Attendance Rate:', $attendance_rate . '%']);

// Add empty row
fputcsv($output, []);

// Add column headers
fputcsv($output, [
    'No.',
    'Name',
    'Zone/Purok',
    'Contact Number',
    'Email',
    'Status'
]);

// Add absentee data
$counter = 1;
while($row = $absentees_qry->fetch_assoc()) {
    fputcsv($output, [
        $counter++,
        $row['user_name'],
        $row['user_zone'] ?: 'N/A',
        $row['contact_no'] ?: 'N/A',
        $row['email'] ?: 'N/A',
        'Absent'
    ]);
}

// Add footer note
fputcsv($output, []);
fputcsv($output, ['Note: These users did not scan the QR code for this event.']);
fputcsv($output, ['Generated on: ' . date('M d, Y h:i:s A')]);

fclose($output);
exit;
?>
