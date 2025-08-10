<?php 
require_once('../../config.php');

// Debug script to see zone values
echo "Zone values in users table:<br>";
$zone_qry = $conn->query("SELECT DISTINCT zone FROM users WHERE zone IS NOT NULL ORDER BY zone");
while($row = $zone_qry->fetch_assoc()) {
    echo "Zone: " . $row['zone'] . " (type: " . gettype($row['zone']) . ")<br>";
}

echo "<br>Sample users with zones:<br>";
$users_qry = $conn->query("SELECT id, firstname, lastname, zone FROM users WHERE status = 1 AND type != 1 LIMIT 5");
while($row = $users_qry->fetch_assoc()) {
    echo "User: " . $row['firstname'] . " " . $row['lastname'] . " - Zone: " . $row['zone'] . "<br>";
}
?>
