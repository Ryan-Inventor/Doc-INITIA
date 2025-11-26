<?php

/**
 * Get the base URL of the application
 * 
 * @param string $path
 * @return string
 */
function url($path = '') {
    // Get the script name (e.g., /public/index.php or /index.php)
    $script_name = $_SERVER['SCRIPT_NAME'];
    
    // Get the directory of the script (e.g., /public or /)
    $base_dir = dirname($script_name);
    
    // Ensure base_dir doesn't end with a slash unless it's just "/"
    $base_dir = rtrim($base_dir, '/');
    
    // Ensure path starts with a slash if it's not empty
    if (!empty($path) && $path[0] !== '/') {
        $path = '/' . $path;
    }
    
    return $base_dir . $path;
}

/**
 * Redirect to a specific path
 * 
 * @param string $path
 */
function redirect($path) {
    header("Location: " . url($path));
    exit;
}

/**
 * Get the current route (for active menu highlighting)
 * 
 * @return string
 */
function current_route() {
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $script_name = $_SERVER['SCRIPT_NAME'];
    $script_dir = dirname($script_name);
    
    if (strpos($request_uri, $script_dir) === 0) {
        $uri = substr($request_uri, strlen($script_dir));
    } else {
        $uri = $request_uri;
    }
    
    return trim($uri, '/');
}
