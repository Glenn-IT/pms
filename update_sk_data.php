<?php
require_once('config.php');

echo "Updating existing SK Officials with sample data...\n\n";

$sample_officials = [
    ['id' => 1, 'firstname' => 'John', 'middlename' => 'A.', 'lastname' => 'Dela Cruz', 'email' => 'john.delacruz@email.com', 'date_of_birth' => '1998-05-15', 'sex' => 'Male'],
    ['id' => 2, 'firstname' => 'Maria', 'middlename' => 'B.', 'lastname' => 'Santos', 'email' => 'maria.santos@email.com', 'date_of_birth' => '2000-03-20', 'sex' => 'Female'],
    ['id' => 3, 'firstname' => 'Jose', 'middlename' => 'C.', 'lastname' => 'Garcia', 'email' => 'jose.garcia@email.com', 'date_of_birth' => '1999-07-10', 'sex' => 'Male'],
    ['id' => 4, 'firstname' => 'Ana', 'middlename' => 'D.', 'lastname' => 'Rodriguez', 'email' => 'ana.rodriguez@email.com', 'date_of_birth' => '2001-01-25', 'sex' => 'Female'],
    ['id' => 5, 'firstname' => 'Miguel', 'middlename' => 'E.', 'lastname' => 'Lopez', 'email' => 'miguel.lopez@email.com', 'date_of_birth' => '1997-11-30', 'sex' => 'Male'],
    ['id' => 6, 'firstname' => 'Carmen', 'middlename' => 'F.', 'lastname' => 'Martinez', 'email' => 'carmen.martinez@email.com', 'date_of_birth' => '2000-09-12', 'sex' => 'Female'],
    ['id' => 7, 'firstname' => 'Pedro', 'middlename' => 'G.', 'lastname' => 'Gonzalez', 'email' => 'pedro.gonzalez@email.com', 'date_of_birth' => '1998-12-05', 'sex' => 'Male'],
    ['id' => 8, 'firstname' => 'Rosa', 'middlename' => 'H.', 'lastname' => 'Hernandez', 'email' => 'rosa.hernandez@email.com', 'date_of_birth' => '1999-04-18', 'sex' => 'Female']
];

foreach($sample_officials as $official) {
    $sql = "UPDATE sk_officials SET 
            firstname = '{$official['firstname']}', 
            middlename = '{$official['middlename']}', 
            lastname = '{$official['lastname']}',
            email = '{$official['email']}',
            date_of_birth = '{$official['date_of_birth']}',
            sex = '{$official['sex']}'
            WHERE id = {$official['id']}";
    
    if($conn->query($sql)) {
        echo "✓ Updated official ID {$official['id']}: {$official['firstname']} {$official['lastname']}\n";
    } else {
        echo "❌ Error updating official ID {$official['id']}: " . $conn->error . "\n";
    }
}

echo "\n=== Final SK Officials List ===\n";
$result = $conn->query("SELECT id, firstname, middlename, lastname, position, zone, contact FROM sk_officials WHERE status = 1 ORDER BY CASE WHEN position = 'chairman' THEN 1 ELSE 2 END, firstname");
while($row = $result->fetch_assoc()) {
    $full_name = trim($row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']);
    echo "ID: {$row['id']} | {$full_name} | " . ucfirst($row['position']) . " | Zone: {$row['zone']} | Contact: {$row['contact']}\n";
}

echo "\nSample data updated successfully!\n";
?>
