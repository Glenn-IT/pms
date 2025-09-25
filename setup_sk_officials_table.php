<?php
require_once('config.php');

echo "Setting up SK Officials table...\n";

// Create the sk_officials table
$create_table_sql = "
CREATE TABLE IF NOT EXISTS `sk_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `position` enum('chairman','secretary','treasurer','kagawad','councilor') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `zone` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order_position` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if($conn->query($create_table_sql)){
    echo "✓ sk_officials table created successfully!\n";
} else {
    echo "✗ Error creating table: " . $conn->error . "\n";
}

// Check if table exists now
$check_table = $conn->query("SHOW TABLES LIKE 'sk_officials'");
if($check_table->num_rows > 0){
    echo "✓ sk_officials table exists and is ready to use!\n";
    
    // Check current data
    $count = $conn->query("SELECT COUNT(*) as count FROM sk_officials")->fetch_assoc()['count'];
    echo "Current records in sk_officials table: $count\n";
    
} else {
    echo "✗ sk_officials table still doesn't exist!\n";
}

echo "\nSetup complete. You can now use the SK Officials management system.\n";
?>
