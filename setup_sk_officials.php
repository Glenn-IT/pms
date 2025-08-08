<?php
require_once('config.php');

// Read the SQL file
$sql_content = file_get_contents('database/sk_officials.sql');

// Split by semicolons to get individual queries
$queries = explode(';', $sql_content);

echo "Setting up SK Officials table...\n";

foreach($queries as $query) {
    $query = trim($query);
    if(!empty($query)) {
        if($conn->query($query)) {
            echo "✓ Query executed successfully: " . substr($query, 0, 50) . "...\n";
        } else {
            echo "✗ Error executing query: " . $conn->error . "\n";
            echo "Query: " . substr($query, 0, 100) . "...\n";
        }
    }
}

echo "\nSK Officials setup completed!\n";
echo "You can now access the SK Officials management at: admin/skofficials/\n";
?>
