<?php
session_start();

// Settings for CAPTCHA image
$width = 200;
$height = 70;
$font_size = 20;

// Generate random captcha string (5 chars)
$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$captcha_text = '';
for ($i = 0; $i < 5; $i++) {
    $captcha_text .= $chars[rand(0, strlen($chars) - 1)];
}

// Store captcha text in session for verification
$_SESSION['captcha'] = $captcha_text;

// Create image
$image = imagecreate($width, $height);

// Colors
$bg_color = imagecolorallocate($image, 255, 255, 255); // white background
$text_color = imagecolorallocate($image, 0, 0, 0); // black text
$noise_color = imagecolorallocate($image, 100, 120, 180); // noise color

// Add noise - dots
for ($i = 0; $i < 100; $i++) {
    imagefilledellipse($image, rand(0,$width), rand(0,$height), 2, 3, $noise_color);
}

// Add noise - lines
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $noise_color);
}

// Add the captcha text to image
$font_path = __DIR__ . '/fonts/arial.ttf';  // You can place a .ttf font file in a 'fonts' folder

if (file_exists($font_path)) {
    // Use TrueType font
    $textbox = imagettfbbox($font_size, 0, $font_path, $captcha_text);
    $x = ($width - ($textbox[2] - $textbox[0])) / 2;
    $y = ($height - ($textbox[7] - $textbox[1])) / 2;
    $y -= $textbox[7];
    imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_path, $captcha_text);
} else {
    // Use built-in font as fallback
    imagestring($image, 5, 30, 15, $captcha_text, $text_color);
}

// Output image as PNG
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
