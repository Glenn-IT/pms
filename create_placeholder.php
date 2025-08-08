<?php
// Create a simple placeholder QR code image
$width = 150;
$height = 150;

// Create image
$image = imagecreate($width, $height);

// Define colors
$white = imagecolorallocate($image, 255, 255, 255);
$gray = imagecolorallocate($image, 200, 200, 200);
$black = imagecolorallocate($image, 0, 0, 0);

// Fill background
imagefill($image, 0, 0, $white);

// Draw border
imagerectangle($image, 0, 0, $width-1, $height-1, $gray);

// Add text
$font = 3;
$text = "QR CODE";
$text_width = imagefontwidth($font) * strlen($text);
$text_height = imagefontheight($font);
$x = ($width - $text_width) / 2;
$y = ($height - $text_height) / 2;

imagestring($image, $font, $x, $y, $text, $black);

// Save image
imagepng($image, 'c:\xampp\htdocs\pms\uploads\qrcodes\placeholder.png');

// Clean up
imagedestroy($image);

echo "Placeholder QR image created successfully!";
?>
