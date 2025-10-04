<?php

/**
 *  A simple PHP web server script that handles specific routes/endpoints
 */

// Get the request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove query string from URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

// GET request for /foo
if ($method === 'GET' && $uri === '/foo') {
    echo "bar\n";
    exit;
}

// GET request for /kill
if ($method === 'GET' && $uri === '/kill') {
    echo "Shutting down the server...\n";

    // Get the process ID of the current script
    $pid = getmypid();
    
    // Send a SIGTERM to the process to terminate it
    posix_kill($pid, SIGTERM);

    // Fallback
    exit;
}


// POST request for /hello
if ($method === 'POST' && $uri === '/hello') {

    // Get raw POST data
    $json_data = file_get_contents('php://input');
    
    // Decode JSON data
    $data = json_decode($json_data, true);

    // Check if 'name' key exists in the JSON 
    if (isset($data['name'])) {
        $name = htmlspecialchars($data['name']);
        echo "Hello " . $name . "!\n";
    } else {
        // If 'name' is missing, return a bad request error
        http_response_code(400);
        echo "Error: 'name' key not found in JSON body.\n";
    }
    exit;
}

// GET request for /configValue
if ($method === 'GET' && $uri === '/configValue') {
    // Read the value injected from the ConfigMap via environment variable
    $value = getenv('configValue') ?: 'ConfigMap value not found';
    echo $value . "\n";
    exit;
}

// GET request for /secretValue
if ($method === 'GET' && $uri === '/secretValue') {
    // Read the value injected from the Secret via environment variable
    $value = getenv('secretValue') ?: 'Secret value not found';
    echo $value . "\n";
    exit;
}

// GET request for /envValue
if ($method === 'GET' && $uri === '/envValue') {
    // Read the value injected directly from the Deployment's env section
    $value = getenv('envValue') ?: 'Environment value not found';
    echo $value . "\n";
    exit;
}

// Fallback for unknown routes/endpoints
http_response_code(404);
echo "404 Not Found\n";
?>