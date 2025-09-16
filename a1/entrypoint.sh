#!/bin/bash

# Trap SIGINT and SIGTERM signals and do graceful exit if docker stop is called
trap 'exit 0' SIGINT SIGTERM

# Run PHP built-in Web server as a background (child) process
php -S 0.0.0.0:8080 index.php &

# Wait for the background process (PHP built-in Web server) to finish
wait $!
