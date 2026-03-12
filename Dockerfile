# =============================================================================
# STAGE 1: The Base (The Shared Foundation)
# =============================================================================
# We name this stage "base" using "AS base" so we can refer to it later in Stage 2, 3, and 4.
# We start with the official PHP 8.3 image with PHP-FPM (FastCGI Process Manager).
# This provides the operating system, PHP, and the engine to handle PHP requests.
FROM php:8.3-fpm AS base

# Set the working directory inside the container's virtual file system.
# Think of this like "cd /var/www/html". All future commands happen inside this folder.
WORKDIR /var/www/html

# Install system-level software needed for Laravel and typical web apps.
# - apt-get update: Downloads the latest list of available software packages.
# - apt-get install -y: Installs specific tools like git, curl, and image libraries.
# - The "\" at the end of lines tells Docker that the command continues on the next line.
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libicu-dev gnupg \
    # docker-php-ext-install: A special helper to install PHP-specific "plugins" (extensions).
    # These allow PHP to talk to MySQL, handle images, process text, etc.
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd calendar intl opcache

# Setup Node.js (Version 24) for compiling frontend assets like CSS and JavaScript.
# 1. Create a folder to store security keys.
RUN mkdir -p /etc/apt/keyrings \
    # 2. Download the security key for the NodeSource repository.
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    # 3. Tells the system where to find the Node.js software on the internet.
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_24.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    # 4. Update the package list again and install Node.js and npm (Node Package Manager).
    && apt-get update && apt-get install -y nodejs

# Clean up temporary installation files to keep the final image size small.
# This is like emptying the recycle bin after installing software on your PC.
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy the latest Composer (PHP's package manager) from its official image into our own.
# This is "multi-stage building": grabbing a specific tool from another image.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =============================================================================
# STAGE 2: Local Development
# =============================================================================
# This stage is for when you are coding on your own computer.
# It inherits everything from "base".
FROM base AS development
# Tells Git that this directory is "safe" to prevent permission errors when using Git inside Docker.
RUN git config --global --add safe.directory /var/www/html
# Start PHP-FPM to wait for web requests.
CMD ["php-fpm"]

# =============================================================================
# STAGE 3: Production Build (The Compilation Phase)
# =============================================================================
# This stage is like a "temporary workshop". It builds the code but isn't the final ship.
FROM base AS build
# Copy your local source code into the container.
COPY ./src /var/www/html

# Install PHP dependencies for production.
# --no-interaction: Don't ask questions during install.
# --optimize-autoloader: Makes the app run faster by creating a pre-mapped list of files.
# --no-dev: Skip tools only needed for testing or debugging.
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install Node packages and compile "assets" (CSS/JS) into fast, static files.
RUN npm install
RUN npm run build

# =============================================================================
# STAGE 4: Production Runtime (The Final, Polished Image)
# =============================================================================
# This is the actual image that gets shipped to your server.
FROM base AS production

# Copy ONLY the final, built code from the "build" stage.
# --chown=www-data:www-data: Sets the "owner" of the files to the web server user for security.
COPY --from=build --chown=www-data:www-data /var/www/html /var/www/html

# Permissions: Ensure Laravel can write to specific folders for logs and fast caching.
# chmod -R 775: Gives read/write access to the group (the web server).
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Define the final command: Start the PHP engine.
CMD ["php-fpm"]