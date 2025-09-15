<?php
// Test if GD extension is loaded
if (extension_loaded('gd')) {
    echo "✅ GD extension is loaded!<br>";
    echo "📋 Available GD functions:<br>";
    $gd_info = gd_info();
    foreach($gd_info as $key => $value) {
        echo "$key: " . ($value ? 'Yes' : 'No') . "<br>";
    }
} else {
    echo "❌ GD extension is NOT loaded!<br>";
    echo "Please enable GD extension in php.ini";
}
?>
