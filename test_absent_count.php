<?php
require_once('config.php');

// Test the absent count calculation
echo "<h2>Attendance Count Test</h2>";

// Get list of events
$events_qry = $db->conn->query("SELECT id, title FROM event_list ORDER BY date_created DESC LIMIT 5");

if($events_qry && $events_qry->num_rows > 0) {
    while($event = $events_qry->fetch_assoc()) {
        echo "<h3>Event: {$event['title']} (ID: {$event['id']})</h3>";
        
        // Count present attendees
        $present_qry = $db->conn->query("SELECT COUNT(*) as count FROM event_attendance WHERE event_id = {$event['id']} AND status = 'present'");
        $present_count = $present_qry->fetch_assoc()['count'];
        
        // Count total active users (excluding admin/type 1)
        $total_users_qry = $db->conn->query("SELECT COUNT(*) as count FROM users WHERE status = 1 AND type != 1");
        $total_active_users = $total_users_qry->fetch_assoc()['count'];
        
        // Calculate absent
        $absent_count = $total_active_users - $present_count;
        
        echo "<table border='1' style='margin-bottom: 20px;'>";
        echo "<tr><th>Metric</th><th>Count</th></tr>";
        echo "<tr><td>Total Active Users (excluding admin)</td><td>{$total_active_users}</td></tr>";
        echo "<tr><td>Present (QR Scanned)</td><td>{$present_count}</td></tr>";
        echo "<tr><td>Absent (Did not scan QR)</td><td>{$absent_count}</td></tr>";
        echo "</table>";
    }
} else {
    echo "<p>No events found</p>";
}

// Show list of active users for verification
echo "<h3>Active Users (for verification):</h3>";
$users_qry = $db->conn->query("SELECT id, firstname, lastname, type, status FROM users WHERE status = 1 ORDER BY type, firstname");
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Include in Count?</th></tr>";
while($user = $users_qry->fetch_assoc()) {
    $include = ($user['type'] != 1) ? 'YES' : 'NO (Admin)';
    echo "<tr>";
    echo "<td>{$user['id']}</td>";
    echo "<td>{$user['firstname']} {$user['lastname']}</td>";
    echo "<td>{$user['type']}</td>";
    echo "<td>{$user['status']}</td>";
    echo "<td>{$include}</td>";
    echo "</tr>";
}
echo "</table>";
?>
