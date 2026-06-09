<?php

$filePath = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($filePath);

// Directories
if (!is_dir('public/assets/css')) {
    mkdir('public/assets/css', 0777, true);
}
if (!is_dir('public/assets/js')) {
    mkdir('public/assets/js', 0777, true);
}

// Extract CSS
if (preg_match('/<style>(.*?)<\/style>/s', $content, $cssMatches)) {
    $css = trim($cssMatches[1]);
    file_put_contents('public/assets/css/style.css', $css);
    
    // Replace in blade file
    $linkTag = '<link rel="stylesheet" href="{{ asset(\'assets/css/style.css\') }}">';
    $content = str_replace($cssMatches[0], $linkTag, $content);
}

// Extract JS
if (preg_match('/<script>(.*?)<\/script>/s', $content, $jsMatches)) {
    $js = trim($jsMatches[1]);
    file_put_contents('public/assets/js/script.js', $js);
    
    // Replace in blade file
    $scriptTag = '<script src="{{ asset(\'assets/js/script.js\') }}"></script>';
    $content = str_replace($jsMatches[0], $scriptTag, $content);
}

// Write back to app.blade.php
file_put_contents($filePath, $content);

echo "Assets extracted successfully.\n";
