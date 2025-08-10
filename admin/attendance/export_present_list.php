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

// Get present attendees
$attendees_qry = $conn->query("
    SELECT 
        u.id as user_id,
        CONCAT(u.firstname, ' ', COALESCE(CONCAT(u.middlename, ' '), ''), u.lastname) as attendee_name,
        u.zone as attendee_zone,
        ea.scan_time,
        ea.status,
        CONCAT(scanner.firstname, ' ', COALESCE(CONCAT(scanner.middlename, ' '), ''), scanner.lastname) as scanner_name
    FROM `event_attendance` ea 
    LEFT JOIN `users` u ON ea.user_id = u.id 
    LEFT JOIN `users` scanner ON ea.scanner_user_id = scanner.id 
    WHERE ea.event_id = '{$event_id}' 
    AND ea.status = 'present'
    {$zone_condition}
    ORDER BY u.lastname ASC, u.firstname ASC
");

// Set headers for CSV download
$filename = "Present_Attendees_" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $event['title']) . "_" . date('Y-m-d') . ".csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Create output stream
$output = fopen('php://output', 'w');

// Add UTF-8 BOM for Excel compatibility
fwrite($output, "\xEF\xBB\xBF");

// Add CSV headers
fputcsv($output, [
    'Event: ' . $event['title'],
    'Date: ' . date("M d, Y h:i A", strtotime($event['date_created'])),
    'Zone Filter: ' . $zone_text,
    'Export Date: ' . date('M d, Y h:i A')
]);

// Add empty row
fputcsv($output, []);

// Add column headers
fputcsv($output, [
    'No.',
    'Attendee Name',
    'Zone/Purok',
    'Scan Time',
    'Scanned By'
]);

// Add attendee data
$counter = 1;
while($row = $attendees_qry->fetch_assoc()) {
    fputcsv($output, [
        $counter++,
        $row['attendee_name'],
        $row['attendee_zone'] ?: 'N/A',
        date("M d, Y h:i:s A", strtotime($row['scan_time'])),
        $row['scanner_name'] ?: 'Auto-scan'
    ]);
}

// Add summary at the bottom
fputcsv($output, []);
fputcsv($output, ['Total Present Attendees:', $attendees_qry->num_rows]);

fclose($output);
exit;
?>
