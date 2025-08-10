<?php 
require_once('../../config.php');

header('Content-Type: application/json');

if(!isset($_POST['event_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid event ID.']);
    exit;
}

$event_id = intval($_POST['event_id']);
$zone_filter = isset($_POST['zone_filter']) ? trim($_POST['zone_filter']) : '';

// Validate event exists
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if($event_qry->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Event not found.']);
    exit;
}

// Build the query with optional zone filter
$zone_condition = '';
if(!empty($zone_filter)) {
    $zone_filter = $conn->real_escape_string($zone_filter);
    $zone_condition = "AND u.zone = '{$zone_filter}'";
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
    ORDER BY ea.scan_time ASC
");

$attendees = [];
$zones = [];
$scan_times = [];

while($row = $attendees_qry->fetch_assoc()) {
    $attendees[] = [
        'name' => $row['attendee_name'],
        'zone' => $row['attendee_zone'],
        'scan_time' => date("M d, Y h:i A", strtotime($row['scan_time'])),
        'scanner_name' => $row['scanner_name']
    ];
    
    // Collect zones for stats
    if(!empty($row['attendee_zone']) && !in_array($row['attendee_zone'], $zones)) {
        $zones[] = $row['attendee_zone'];
    }
    
    // Collect scan times for average calculation
    $scan_times[] = strtotime($row['scan_time']);
}

// Calculate statistics
$stats = [
    'total_present' => count($attendees),
    'unique_zones' => count($zones),
    'avg_scan_time' => '--'
];

// Calculate average scan time
if(!empty($scan_times)) {
    $event_start = $event_qry->fetch_assoc()['date_created'];
    $event_start_timestamp = strtotime($event_start);
    
    $time_differences = [];
    foreach($scan_times as $scan_time) {
        $diff = $scan_time - $event_start_timestamp;
        if($diff >= 0) { // Only consider scans after event start
            $time_differences[] = $diff;
        }
    }
    
    if(!empty($time_differences)) {
        $avg_diff = array_sum($time_differences) / count($time_differences);
        $hours = floor($avg_diff / 3600);
        $minutes = floor(($avg_diff % 3600) / 60);
        
        if($hours > 0) {
            $stats['avg_scan_time'] = "{$hours}h {$minutes}m";
        } else {
            $stats['avg_scan_time'] = "{$minutes}m";
        }
    }
}

echo json_encode([
    'success' => true,
    'attendees' => $attendees,
    'stats' => $stats
]);
?>
