<?php
require_once('../../config.php');

// Create database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if image column already exists
$check_column = $conn->query("SHOW COLUMNS FROM sk_officials LIKE 'image'");

if($check_column->num_rows == 0) {
    // Add image column
    $alter_query = "ALTER TABLE `sk_officials` ADD COLUMN `image` varchar(255) DEFAULT NULL AFTER `address`";
    
    if($conn->query($alter_query)) {
        echo "✅ Successfully added 'image' column to sk_officials table.<br>";
    } else {
        echo "❌ Error adding 'image' column: " . $conn->error . "<br>";
    }
} else {
    echo "ℹ️ 'image' column already exists in sk_officials table.<br>";
}

// Verify the table structure
$describe_query = $conn->query("DESCRIBE sk_officials");
echo "<br><strong>Current sk_officials table structure:</strong><br>";
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";

while($row = $describe_query->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['Field'] . "</td>";
    echo "<td>" . $row['Type'] . "</td>";
    echo "<td>" . $row['Null'] . "</td>";
    echo "<td>" . $row['Key'] . "</td>";
    echo "<td>" . $row['Default'] . "</td>";
    echo "<td>" . $row['Extra'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
