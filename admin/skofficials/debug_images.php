<?php
require_once('../../config.php');

// Create database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>SK Officials Image Debug</h2>";

// Get all officials
$query = "SELECT * FROM sk_officials WHERE status = 'active' ORDER BY position";
$result = $conn->query($query);

if($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Position</th><th>Name</th><th>Image Path</th><th>File Exists?</th><th>Full Path</th><th>Preview</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['image'] ?? 'NULL') . "</td>";
        
        if($row['image']) {
            $fullPath = '../../' . $row['image'];
            $fileExists = file_exists($fullPath);
            echo "<td>" . ($fileExists ? "✅ Yes" : "❌ No") . "</td>";
            echo "<td>" . htmlspecialchars($fullPath) . "</td>";
            
            if($fileExists) {
                $webPath = '../../' . $row['image'];
                echo "<td><img src='" . htmlspecialchars($webPath) . "' style='width: 50px; height: 50px; object-fit: cover; border-radius: 50%;' onerror='this.style.display=\"none\"; this.nextSibling.style.display=\"inline\";'><span style='display:none; color:red;'>Failed to load</span></td>";
            } else {
                echo "<td>File not found</td>";
            }
        } else {
            echo "<td>No image</td>";
            echo "<td>N/A</td>";
            echo "<td>No image uploaded</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No officials found.</p>";
}

echo "<br><h3>Upload Directory Info:</h3>";
$uploadDir = '../../uploads/sk_officials/';
echo "<p><strong>Upload Directory:</strong> " . realpath($uploadDir) . "</p>";
echo "<p><strong>Directory Exists:</strong> " . (is_dir($uploadDir) ? "✅ Yes" : "❌ No") . "</p>";
echo "<p><strong>Directory Writable:</strong> " . (is_writable($uploadDir) ? "✅ Yes" : "❌ No") . "</p>";

if(is_dir($uploadDir)) {
    $files = scandir($uploadDir);
    $imageFiles = array_filter($files, function($file) {
        return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    });
    
    echo "<h4>Files in Upload Directory:</h4>";
    if(count($imageFiles) > 0) {
        echo "<ul>";
        foreach($imageFiles as $file) {
            $filePath = $uploadDir . $file;
            $fileSize = filesize($filePath);
            echo "<li>" . htmlspecialchars($file) . " (" . number_format($fileSize / 1024, 2) . " KB)</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No image files found in upload directory.</p>";
    }
}

$conn->close();
?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { margin: 20px 0; }
    th, td { padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>
