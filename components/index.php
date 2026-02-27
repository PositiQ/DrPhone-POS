<?php
// Handle navigation redirects
// If someone tries to access /components/[section]/index.php
// redirect them to /components/pages/[section]/index.php

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Parse the path
$path = parse_url($requestUri, PHP_URL_PATH);

// Check if the request matches the pattern /components/[section]/
if (preg_match('#/components/([^/]+)/(.*)$#', $path, $matches)) {
    $section = $matches[1];
    $file = $matches[2];
    
    // Skip if already accessing 'pages' or 'UI' directories
    if ($section !== 'pages' && $section !== 'UI') {
        // Redirect to the correct pages directory
        header('Location: /components/pages/' . $section . '/' . $file);
        exit;
    }
}

// If no match, redirect to dashboard
header('Location: /components/pages/index.php');
exit;
?>
