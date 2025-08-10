<?php 
require_once('../../config.php');

// Simple debug script to test the absent attendees query
header('Content-Type: application/json');

if(!isset($_POST['event_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid event ID.', 'debug' => 'No event_id in POST']);
    exit;
}

$event_id = intval($_POST['event_id']);
$zone_filter = isset($_POST['zone_filter']) ? trim($_POST['zone_filter']) : '';

echo json_encode([
    'debug_info' => [
        'event_id' => $event_id,
        'zone_filter' => $zone_filter,
        'zone_filter_empty' => empty($zone_filter),
        'post_data' => $_POST
    ]
]);

// Test basic connection
$test_qry = $conn->query("SELECT 1 as test");
if(!$test_qry) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->error]);
    exit;
}

// Test if event exists
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if(!$event_qry) {
    echo json_encode(['success' => false, 'message' => 'Event query failed: ' . $conn->error]);
    exit;
}

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

// Test the main query step by step
$sql = "
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
";

echo json_encode([
    'success' => true,
    'debug' => [
        'sql_query' => $sql,
        'zone_condition' => $zone_condition,
        'event_id' => $event_id,
        'zone_filter' => $zone_filter
    ]
]);
?>
