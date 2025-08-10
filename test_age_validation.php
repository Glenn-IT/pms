<?php
// Test file to check age validation functionality
require_once('config.php');
require_once('classes/Users.php');

$users = new Users();

echo "<h3>Testing Age Validation Functionality</h3>";

// Test getting users over 31
echo "<h4>Users over 31:</h4>";
$users_over_31 = $users->get_users_over_31();
if(empty($users_over_31)) {
    echo "<p>No users over 31 found.</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Birthdate</th></tr>";
    foreach($users_over_31 as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['firstname'] . " " . $user['lastname'] . "</td>";
        echo "<td>" . $user['age'] . "</td>";
        echo "<td>" . $user['birthdate'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test the age calculation with sample date
echo "<h4>Testing Age Calculation:</h4>";
$birth_date = new DateTime('1992-01-01'); // This would make someone 33 years old
$current_date = new DateTime();
$age = $current_date->diff($birth_date)->y;
echo "<p>Sample birthdate: 1992-01-01, Calculated age: $age years</p>";

echo "<h4>Database Connection Test:</h4>";
if($conn) {
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if users table has birthdate column
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'birthdate'");
    if($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Birthdate column exists in users table</p>";
    } else {
        echo "<p style='color: red;'>✗ Birthdate column missing in users table</p>";
    }
    
    // Check active users count
    $active_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 1");
    if($active_users) {
        $count = $active_users->fetch_assoc()['count'];
        echo "<p>Active users count: $count</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ Database connection failed</p>";
}
?>
