<?php
require_once('config.php');

echo "Checking sk_officials table structure...\n\n";

// Check if table exists
$check_table = $conn->query("SHOW TABLES LIKE 'sk_officials'");
if($check_table->num_rows > 0) {
    echo "✓ sk_officials table exists\n\n";
    
    // Show current structure
    echo "Current table structure:\n";
    $structure = $conn->query("DESCRIBE sk_officials");
    while($row = $structure->fetch_assoc()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    
    // Check if name column exists
    $check_name = $conn->query("SHOW COLUMNS FROM sk_officials LIKE 'name'");
    if($check_name->num_rows == 0) {
        echo "\n❌ 'name' column is missing! Adding it...\n";
        if($conn->query("ALTER TABLE sk_officials ADD COLUMN name varchar(255) NOT NULL AFTER id")) {
            echo "✓ 'name' column added successfully\n";
        } else {
            echo "❌ Error adding 'name' column: " . $conn->error . "\n";
        }
    } else {
        echo "\n✓ 'name' column exists\n";
    }
    
} else {
    echo "❌ sk_officials table does not exist! Creating it...\n";
    
    // Read and execute the SQL file
    $sql_content = file_get_contents('database/sk_officials.sql');
    $queries = explode(';', $sql_content);
    
    foreach($queries as $query) {
        $query = trim($query);
        if(!empty($query) && !str_starts_with($query, '--')) {
            if($conn->query($query)) {
                echo "✓ Query executed: " . substr($query, 0, 50) . "...\n";
            } else {
                echo "❌ Error executing query: " . $conn->error . "\n";
            }
        }
    }
}

echo "\n=== Final table structure ===\n";
$final_structure = $conn->query("DESCRIBE sk_officials");
while($row = $final_structure->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

echo "\n=== Current data ===\n";
$data = $conn->query("SELECT id, name, position, zone FROM sk_officials WHERE status = 1");
if($data->num_rows > 0) {
    while($row = $data->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Position: " . $row['position'] . " | Zone: " . $row['zone'] . "\n";
    }
} else {
    echo "No data found\n";
}

echo "\nDone!\n";
?>
