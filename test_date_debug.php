<?php
require_once('config.php');

// Get events to check date format
$qry = $db->query("SELECT id, title, date_created FROM event_list ORDER BY date_created DESC LIMIT 5");

echo "<h2>Event Date Debug</h2>";
echo "<p>Current Date: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Today: " . date('Y-m-d') . "</p>";

if($qry && $qry->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Title</th><th>Date Created</th><th>Date Only</th><th>Is Today?</th></tr>";
    
    while($row = $qry->fetch_assoc()) {
        $eventDate = date('Y-m-d', strtotime($row['date_created']));
        $isToday = (date('Y-m-d') === $eventDate) ? 'YES' : 'NO';
        
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['title']}</td>";
        echo "<td>{$row['date_created']}</td>";
        echo "<td>{$eventDate}</td>";
        echo "<td><strong>{$isToday}</strong></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No events found</p>";
}

// Show JavaScript comparison
echo "<script>";
echo "console.log('Current JavaScript Date:', new Date().toDateString());";
echo "console.log('Current JavaScript Date ISO:', new Date().toISOString());";
echo "</script>";
?>
