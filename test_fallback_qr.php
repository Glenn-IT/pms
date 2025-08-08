<?php
require_once('config.php');

// Test simple image creation for QR fallback
$userId = 999;
$filename = 'uploads/qrcodes/test_fallback_' . time() . '.png';

echo "Testing fallback QR creation...\n";

try {
    // Create a simple image with user info
    $width = 200;
    $height = 200;
    $image = imagecreate($width, $height);
    
    // Define colors
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $gray = imagecolorallocate($image, 128, 128, 128);
    
    // Fill background
    imagefill($image, 0, 0, $white);
    
    // Draw border
    imagerectangle($image, 0, 0, $width-1, $height-1, $black);
    
    // Add user ID
    $font = 5;
    $text = "USER ID: " . $userId;
    $textWidth = imagefontwidth($font) * strlen($text);
    $x = ($width - $textWidth) / 2;
    imagestring($image, $font, $x, 20, $text, $black);
    
    // Add QR-like pattern (simple grid)
    $cellSize = 8;
    $startX = 20;
    $startY = 50;
    $gridSize = 20;
    
    // Create a pattern based on user ID
    $seed = $userId;
    for ($row = 0; $row < $gridSize; $row++) {
        for ($col = 0; $col < $gridSize; $col++) {
            $seed = ($seed * 1664525 + 1013904223) % 4294967296; // Linear congruential generator
            if ($seed % 2 == 0) {
                imagefilledrectangle($image, 
                    $startX + $col * $cellSize, 
                    $startY + $row * $cellSize,
                    $startX + ($col + 1) * $cellSize - 1,
                    $startY + ($row + 1) * $cellSize - 1,
                    $black
                );
            }
        }
    }
    
    // Add timestamp
    $timeText = date('Y-m-d H:i');
    $timeWidth = imagefontwidth(3) * strlen($timeText);
    $timeX = ($width - $timeWidth) / 2;
    imagestring($image, 3, $timeX, $height - 20, $timeText, $gray);
    
    // Save image
    if (imagepng($image, $filename)) {
        echo "✅ Fallback QR image created: " . $filename . "\n";
        echo "📁 File exists: " . (file_exists($filename) ? 'Yes' : 'No') . "\n";
        if (file_exists($filename)) {
            echo "📏 File size: " . filesize($filename) . " bytes\n";
        }
    } else {
        echo "❌ Failed to save image\n";
    }
    
    imagedestroy($image);
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
