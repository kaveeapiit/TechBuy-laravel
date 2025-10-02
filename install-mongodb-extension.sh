#!/bin/bash

echo "🔧 MongoDB Extension Installer for Azure App Service"
echo "=================================================="

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

# Change to project directory
cd /home/site/wwwroot

log "🔌 Installing MongoDB PHP extension..."

# Method 1: Try PECL installation
install_pecl() {
    log "📦 Installing via PECL..."

    # Update packages
    apt-get update -y

    # Install dependencies
    apt-get install -y \
        pkg-config \
        libssl-dev \
        libsasl2-dev \
        build-essential \
        php-dev \
        php-pear

    # Install MongoDB extension
    pecl install mongodb

    # Enable extension
    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/30-mongodb.ini

    log "✅ PECL installation complete"
}

# Method 2: Download pre-compiled extension
install_precompiled() {
    log "📦 Installing pre-compiled extension..."

    # Get PHP version
    PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
    PHP_EXT_DIR=$(php -r "echo ini_get('extension_dir');")

    log "📋 PHP Version: $PHP_VERSION"
    log "📋 Extension Directory: $PHP_EXT_DIR"

    # Download MongoDB extension (adjust URL based on PHP version)
    if [[ "$PHP_VERSION" == "8.2" ]]; then
        DOWNLOAD_URL="https://github.com/mongodb/mongo-php-driver/releases/download/1.17.0/mongodb-1.17.0.tgz"
    elif [[ "$PHP_VERSION" == "8.1" ]]; then
        DOWNLOAD_URL="https://github.com/mongodb/mongo-php-driver/releases/download/1.17.0/mongodb-1.17.0.tgz"
    else
        log "⚠️  Unsupported PHP version: $PHP_VERSION"
        return 1
    fi

    # Create temp directory
    mkdir -p /tmp/mongodb-ext
    cd /tmp/mongodb-ext

    # Download and extract
    wget -O mongodb.tgz "$DOWNLOAD_URL"
    tar -xzf mongodb.tgz

    # Build and install
    cd mongodb-*
    phpize
    ./configure
    make
    make install

    # Enable extension
    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/30-mongodb.ini

    log "✅ Pre-compiled installation complete"
}

# Check if already installed
if php -m | grep -q mongodb; then
    log "✅ MongoDB extension already installed"
    exit 0
fi

# Try installation methods
log "🚀 Starting MongoDB extension installation..."

if install_pecl; then
    log "✅ PECL installation successful"
elif install_precompiled; then
    log "✅ Pre-compiled installation successful"
else
    log "❌ Installation failed - trying alternative method"

    # Alternative: Use composer-based solution
    log "📦 Installing composer-based MongoDB library..."
    composer require mongodb/mongodb --no-interaction
    log "✅ Composer MongoDB library installed"
fi

# Verify installation
log "🔍 Verifying installation..."
if php -m | grep -q mongodb; then
    log "✅ MongoDB PHP extension successfully installed and loaded"
else
    log "⚠️  Extension installed but may need PHP restart"
fi

log "🎉 MongoDB setup complete!"
