<?php
require_once('../../config.php');

// Test database connection
echo "<h2>SK Officials Database Test</h2>";

try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($conn->connect_error) {
        echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Database connection successful!</p>";
        
        // Check if sk_officials table exists
        $check_table = $conn->query("SHOW TABLES LIKE 'sk_officials'");
        if($check_table && $check_table->num_rows > 0) {
            echo "<p style='color: green;'>✅ SK Officials table exists!</p>";
            
            // Count records
            $count_query = $conn->query("SELECT COUNT(*) as count FROM sk_officials");
            if($count_query) {
                $count = $count_query->fetch_assoc();
                echo "<p style='color: blue;'>📊 Records in table: " . $count['count'] . "</p>";
                
                // Show sample data
                $sample_query = $conn->query("SELECT position, name, contact FROM sk_officials LIMIT 3");
                if($sample_query && $sample_query->num_rows > 0) {
                    echo "<h3>Sample Data:</h3>";
                    echo "<table border='1' style='border-collapse: collapse; padding: 8px;'>";
                    echo "<tr><th style='padding: 8px;'>Position</th><th style='padding: 8px;'>Name</th><th style='padding: 8px;'>Contact</th></tr>";
                    while($row = $sample_query->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($row['contact']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
        } else {
            echo "<p style='color: orange;'>⚠️ SK Officials table does not exist. Please run the database setup.</p>";
            echo "<p><a href='database_setup.php' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Run Database Setup</a></p>";
        }
    }
    
    $conn->close();
    
} catch(Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='../'>← Back to SK Officials</a></p>";
echo "<p><a href='database_setup.php'>Database Setup</a></p>";
?>
