<?php
/**
 *  A simple PHP web server script that handles specific routes/endpoints
 */

// Directory/file path for persistence
const DATA_DIR = '/data';
const DATA_FILE = DATA_DIR . '/persist.txt';

// Ensure the data directory exists
if (!is_dir(DATA_DIR)) {
    // Attempt to create the directory
    if (!mkdir(DATA_DIR, 0777, true)) {
        // Log or handle error if directory creation fails
        error_log("Failed to create data directory: " . DATA_DIR);
    }
}

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove query string from URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

// GET request for /foo
if ($method === 'GET' && (strcasecmp($uri, '/foo') === 0)) {
    echo "bar\n";
    exit;
}

// POST request for /hello
if ($method === 'POST' && (strcasecmp($uri, '/hello') === 0)) {
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
        echo "Error: 'name' key not found in JSON body\n";
    }
    exit;
}

// GET request for /kill
if ($method === 'GET' && (strcasecmp($uri, '/kill') === 0)) {
    echo "Shutting down the server ...\n";
    // Get the process ID of the current script
    $pid = getmypid();
    // Send a SIGTERM to the process to terminate it
    posix_kill($pid, SIGTERM);
    exit;
}

// GET request for /configvalue
if ($method === 'GET' && (strcasecmp($uri, '/configvalue') === 0)) {
    // Read the value injected from the ConfigMap via environment variable
    $value = getenv('configValue') ?: 'ConfigMap value not found';
    echo $value . "\n";
    exit;
}

// GET request for /secretvalue
if ($method === 'GET' && (strcasecmp($uri, '/secretvalue') === 0)) {
    // Read the value injected from the Secret via environment variable
    $value = getenv('secretValue') ?: 'Secret value not found';
    echo $value . "\n";
    exit;
}

// GET request for /envvalue
if ($method === 'GET' && (strcasecmp($uri, '/envvalue') === 0)) {
    // Read the value injected directly from the Deployment's env section
    $value = getenv('envValue') ?: 'Environment value not found';
    echo $value . "\n";
    exit;
}

// POST request for /savestring
if ($method === 'POST' && (strcasecmp($uri, '/savestring') === 0)) {
    // Get raw POST data
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    // Check for 'data' key and save the string
    if (isset($data['data']) && is_string($data['data'])) {
        // Save the string to the file
        if (file_put_contents(DATA_FILE, $data['data']) !== false) {
            http_response_code(200);
            echo "String saved\n"; // Response won't be checked
        } else {
            http_response_code(500);
            echo "Error saving string\n";
        }
    } else {
        http_response_code(400);
        echo "Error: 'data' key not found or not a string\n";
    }
    exit;
}

// 2. GET request for /getstring
if ($method === 'GET' && (strcasecmp($uri, '/getstring') === 0)) {
    if (file_exists(DATA_FILE)) {
        $saved_string = file_get_contents(DATA_FILE);
        http_response_code(200);
        echo $saved_string . "\n";
    } else {
        http_response_code(404);
        echo "404 Not Found: No string saved yet\n"; 
    }
    exit;
}

// 3. GET request to make the CPU busy for 3 minutes
if ($method === 'GET' && (strcasecmp($uri, '/busywait') === 0)) {
    // Try to get 100% CPU usage for 3 minutes (180 seconds) 
    $endTime = time() + 180;
    // This loop consumes CPU cycles
    while (time() < $endTime) {
        $a = 0;
        for ($i = 0; $i < 100000; $i++) {
            $a = $a + sin(sqrt($i)); // Busy-wait operation
        }
    }
    http_response_code(200);
    echo "CPU busy-wait finished\n";
    exit;
}

// 1. GET request for /isalive (Used by StatefulSet readiness probe)
if ($method === 'GET' && (strcasecmp($uri, '/isalive') === 0)) {
    http_response_code(200);
    echo "true\n";
    exit;
}

// Fallback
http_response_code(404);
echo "404 Not Found\n";
?>