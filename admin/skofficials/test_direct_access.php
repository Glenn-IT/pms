<?php
// Test direct image access
$imageName = 'chairman_1759135217.jpg';
$imagePath = '../../uploads/sk_officials/' . $imageName;
$webPath = '/pms/uploads/sk_officials/' . $imageName;

echo "<h2>Direct Image Access Test</h2>";
echo "<p><strong>Image Name:</strong> " . htmlspecialchars($imageName) . "</p>";
echo "<p><strong>File System Path:</strong> " . htmlspecialchars($imagePath) . "</p>";
echo "<p><strong>Web Path:</strong> " . htmlspecialchars($webPath) . "</p>";

if(file_exists($imagePath)) {
    echo "<p style='color:green;'>✅ File exists in filesystem</p>";
    echo "<p><strong>File Size:</strong> " . number_format(filesize($imagePath) / 1024, 2) . " KB</p>";
    echo "<p><strong>File Type:</strong> " . mime_content_type($imagePath) . "</p>";
} else {
    echo "<p style='color:red;'>❌ File does not exist in filesystem</p>";
}

echo "<h3>Image Display Test:</h3>";
echo "<p>Using web path: <code>" . htmlspecialchars($webPath) . "</code></p>";
echo "<img src='" . htmlspecialchars($webPath) . "' style='max-width: 200px; max-height: 200px; border: 2px solid #ddd;' onerror='this.nextSibling.style.display=\"block\"'>";
echo "<div style='display:none; color:red; margin:10px 0;'>❌ Failed to load image via web path</div>";

echo "<h3>Alternative Paths:</h3>";
$altPaths = [
    '../../uploads/sk_officials/' . $imageName,
    '../uploads/sk_officials/' . $imageName,
    '/pms/uploads/sk_officials/' . $imageName
];

foreach($altPaths as $path) {
    echo "<p>Testing: <code>" . htmlspecialchars($path) . "</code></p>";
    echo "<img src='" . htmlspecialchars($path) . "' style='width: 100px; height: 100px; object-fit: cover; margin: 5px; border: 1px solid #ccc;' onerror='this.nextSibling.innerHTML=\"❌ Failed\"'>";
    echo "<span style='color:green;'>✅ Success</span><br>";
}
?>

<script>
// Test with JavaScript
setTimeout(() => {
    const imgs = document.querySelectorAll('img');
    imgs.forEach(img => {
        if (img.complete && img.naturalWidth > 0) {
            console.log('✅ Successfully loaded:', img.src);
        } else {
            console.error('❌ Failed to load:', img.src);
        }
    });
}, 1000);
</script>
