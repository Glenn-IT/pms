<?php
require_once('config.php');

// Test: Create an event for today
$today = date('Y-m-d H:i:s');
$title = "Test Event for Today - " . date('Y-m-d');
$description = "This is a test event created for today to test QR functionality";

$sql = "INSERT INTO event_list (title, description, date_created) VALUES (?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("sss", $title, $description, $today);

if($stmt->execute()) {
    echo "✅ Test event created successfully!<br>";
    echo "Event ID: " . $db->insert_id . "<br>";
    echo "Title: " . $title . "<br>";
    echo "Date: " . $today . "<br>";
    echo "<br><a href='admin/event/'>View Events</a>";
} else {
    echo "❌ Error creating test event: " . $db->error;
}

$stmt->close();
?>
