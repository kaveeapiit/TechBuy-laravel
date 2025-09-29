#!/bin/bash

echo "Azure Storage Setup Script"
echo "========================="

# Base directories
WWW_ROOT="/home/site/wwwroot"
STORAGE_ROOT="$WWW_ROOT/storage"
PUBLIC_STORAGE="$WWW_ROOT/public/storage"
APP_STORAGE="$WWW_ROOT/storage/app/public"

# Function to create directory safely
create_dir() {
    if [ ! -d "$1" ]; then
        mkdir -p "$1"
        chmod 755 "$1"
        echo "✅ Created directory: $1"
    else
        echo "Directory exists: $1"
    fi
}

# Function to ensure proper permissions
set_permissions() {
    chmod -R 755 "$1"
    echo "✅ Set permissions for: $1"
}

echo "Setting up storage directories..."

# 1. Create all required directories
create_dir "$STORAGE_ROOT"
create_dir "$WWW_ROOT/storage/app"
create_dir "$WWW_ROOT/storage/app/public"
create_dir "$WWW_ROOT/storage/framework"
create_dir "$WWW_ROOT/storage/framework/cache"
create_dir "$WWW_ROOT/storage/framework/sessions"
create_dir "$WWW_ROOT/storage/framework/views"
create_dir "$WWW_ROOT/storage/logs"
create_dir "$WWW_ROOT/bootstrap/cache"

# 2. Copy public storage files to root storage
echo "Copying storage files..."
if [ -d "$APP_STORAGE" ]; then
    cp -rf "$APP_STORAGE"/* "$STORAGE_ROOT/" 2>/dev/null
    echo "✅ Copied public storage files to root storage"
else
    echo "⚠️  No public storage files to copy"
fi

# 3. Set proper permissions
set_permissions "$WWW_ROOT/storage"
set_permissions "$WWW_ROOT/bootstrap/cache"

# 4. Create .gitignore for storage
cat > "$STORAGE_ROOT/.gitignore" << 'EOF'
*
!.gitignore
EOF
echo "✅ Created storage .gitignore"

# 5. Verify setup
echo ""
echo "Verifying storage setup..."
echo "=========================="

# Check directories
dirs_to_check=(
    "$STORAGE_ROOT"
    "$WWW_ROOT/storage/app"
    "$WWW_ROOT/storage/framework/cache"
    "$WWW_ROOT/storage/framework/sessions"
    "$WWW_ROOT/storage/framework/views"
    "$WWW_ROOT/storage/logs"
    "$WWW_ROOT/bootstrap/cache"
)

for dir in "${dirs_to_check[@]}"; do
    if [ -d "$dir" ] && [ -w "$dir" ]; then
        echo "✅ $dir: exists and is writable"
    else
        echo "❌ $dir: missing or not writable"
    fi
done

echo ""
echo "Storage setup complete!"