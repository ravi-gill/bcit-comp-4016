# Use official PHP 8 image as base
FROM php:8-cli

# Install pcntl and posix extensions
RUN docker-php-ext-install pcntl posix

# Install cURL to run readiness probe
RUN apt-get update && apt-get install -y \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Set working directory in container
WORKDIR /usr/local/src

# Copy index.php and entrypoint.sh into container working directory
COPY entrypoint.sh ./
COPY index.php ./

# Expose port 8080
EXPOSE 8080

# Run entry point shell script
ENTRYPOINT ["./entrypoint.sh"]
