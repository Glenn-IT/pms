<?php
require_once('config.php');

echo "Checking SK Officials in database...\n";

$result = $conn->query("SELECT id, firstname, lastname, position, status FROM sk_officials ORDER BY id");

if($result->num_rows > 0) {
    echo "Found " . $result->num_rows . " SK Officials:\n";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | " . $row['firstname'] . " " . $row['lastname'] . " | " . $row['position'] . " | Status: " . ($row['status'] == 1 ? 'Active' : 'Inactive') . "\n";
    }
    
    echo "\nActivating all SK Officials for testing...\n";
    $activate = $conn->query("UPDATE sk_officials SET status = 1");
    if($activate) {
        echo "✓ All SK Officials activated successfully!\n";
    } else {
        echo "❌ Error activating SK Officials: " . $conn->error . "\n";
    }
} else {
    echo "No SK Officials found in database.\n";
}

$conn->close();
?>
