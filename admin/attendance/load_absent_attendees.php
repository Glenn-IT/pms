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
    $zone_filter_escaped = $conn->real_escape_string($zone_filter);
    $zone_condition = "AND u.zone = '{$zone_filter_escaped}'";
}

// Get all active users who did NOT attend this event
$absentees_qry = $conn->query("
    SELECT 
        u.id as user_id,
        CONCAT(u.firstname, ' ', COALESCE(CONCAT(u.middlename, ' '), ''), u.lastname) as user_name,
        u.zone as user_zone
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

// Check if the main query was successful
if(!$absentees_qry) {
    echo json_encode(['success' => false, 'message' => 'Database error in main query: ' . $conn->error]);
    exit;
}

// Check if query was successful
if(!$absentees_qry) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

// Get present count for statistics (filtered by zone if applicable)
$present_qry = $conn->query("
    SELECT COUNT(*) as present_count 
    FROM `event_attendance` ea 
    LEFT JOIN `users` u ON ea.user_id = u.id
    WHERE ea.event_id = '{$event_id}' 
    AND ea.status = 'present'
    " . (!empty($zone_condition) ? $zone_condition : "")
);

if(!$present_qry) {
    echo json_encode(['success' => false, 'message' => 'Database error in present count: ' . $conn->error]);
    exit;
}

$present_count = $present_qry->fetch_assoc()['present_count'];

// Get total active users for statistics (with same zone filter)
$total_users_qry = $conn->query("
    SELECT COUNT(*) as total_count 
    FROM `users` u
    WHERE u.status = 1 AND u.type != 1
    " . (!empty($zone_condition) ? $zone_condition : "")
);

if(!$total_users_qry) {
    echo json_encode(['success' => false, 'message' => 'Database error in total count: ' . $conn->error]);
    exit;
}
$total_users = $total_users_qry->fetch_assoc()['total_count'];

$absentees = [];
$zones = [];

// Check if absentees query returned results
if($absentees_qry && $absentees_qry->num_rows >= 0) {
    while($row = $absentees_qry->fetch_assoc()) {
        $absentees[] = [
            'user_id' => $row['user_id'],
            'name' => $row['user_name'],
            'zone' => $row['user_zone']
        ];
        
        // Collect zones for stats
        if(!empty($row['user_zone']) && !in_array($row['user_zone'], $zones)) {
            $zones[] = $row['user_zone'];
        }
    }
}

// Calculate statistics
$absent_count = count($absentees);
$attendance_rate = $total_users > 0 ? round(($present_count / $total_users) * 100, 1) : 0;

$stats = [
    'total_absent' => $absent_count,
    'absent_zones' => count($zones),
    'attendance_rate' => $attendance_rate,
    'total_present' => $present_count,
    'total_users' => $total_users
];

// Debug information (remove this in production)
$debug_info = [
    'zone_filter' => $zone_filter,
    'zone_condition' => $zone_condition,
    'event_id' => $event_id,
    'query_successful' => $absentees_qry !== false,
    'num_rows' => $absentees_qry ? $absentees_qry->num_rows : 'N/A'
];

if($absent_count == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Perfect attendance! All registered users attended this event.',
        'stats' => $stats,
        'debug' => $debug_info
    ]);
} else {
    echo json_encode([
        'success' => true,
        'absentees' => $absentees,
        'stats' => $stats,
        'debug' => $debug_info
    ]);
}
?>
