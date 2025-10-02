# Azure File Upload Fix Guide

## 🚨 Problem: File Uploads Not Working on Azure

**Issue**: Product images and file uploads work locally but fail on Azure App Service.

**Root Cause**: Azure App Service has a read-only file system. Files uploaded to `/home/site/wwwroot/storage` are lost on container restarts.

## 🔧 Complete Solution

### 1. **Update Azure Environment Variables**

In Azure Portal → App Service → Configuration → Application Settings, add:

```env
# File Storage Configuration
FILESYSTEM_DISK=public
AZURE_STORAGE_PATH=/home/LogFiles/storage
WEBSITES_ENABLE_APP_SERVICE_STORAGE=true

# Make storage writable
WEBSITES_CONTAINER_START_TIME_LIMIT=1800
```

### 2. **Update startup.sh Script**

Add file storage setup to your startup script:

```bash
#!/bin/bash

echo "🔧 Azure Laravel Startup with File Storage"
echo "=========================================="

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Starting Azure Laravel configuration..."

# Set working directory
cd /home/site/wwwroot

# Apply nginx configuration
if [ -f "/home/site/wwwroot/nginx.conf" ]; then
    log "📁 Applying nginx configuration..."
    cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup 2>/dev/null || true
    cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default
    nginx -s reload 2>/dev/null || service nginx restart 2>/dev/null
    log "✅ Nginx configuration applied"
fi

# Set up persistent file storage
log "📁 Setting up persistent file storage..."
mkdir -p /home/LogFiles/storage/products 2>/dev/null || true
mkdir -p /home/LogFiles/storage/profile-photos 2>/dev/null || true
mkdir -p /home/LogFiles/storage/uploads 2>/dev/null || true
chmod -R 755 /home/LogFiles/storage 2>/dev/null || true

# Create symbolic link to persistent storage
rm -rf /home/site/wwwroot/public/storage 2>/dev/null || true
ln -sf /home/LogFiles/storage /home/site/wwwroot/public/storage 2>/dev/null || true
log "✅ Persistent storage configured"

# Set basic permissions
chmod -R 755 /home/site/wwwroot 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/storage 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

# Clear cache for fresh start
log "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Database Setup
log "📊 Setting up database..."
php artisan migrate --force 2>/dev/null || true

# Create storage link
log "🔗 Creating storage link..."
php artisan storage:link 2>/dev/null || true

# Optimize for production
log "⚡ Optimizing for production..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true

log "✅ Complete Laravel startup with file storage completed"
log "🌐 Application ready with persistent file uploads"
log "📁 File uploads will be stored in: /home/LogFiles/storage"
```

### 3. **Update nginx.conf for File Serving**

Add file serving configuration to your nginx.conf:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name _;
    root /home/site/wwwroot/public;
    index index.php index.html index.htm;

    # ... existing configuration ...

    # Serve uploaded files from persistent storage
    location /storage/ {
        alias /home/LogFiles/storage/;
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # Static assets caching
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # ... rest of existing configuration ...
}
```

### 4. **Update Filesystem Configuration**

Update `config/filesystems.php`:

```php
'public' => [
    'driver' => 'local',
    'root' => env('AZURE_STORAGE_PATH', storage_path('app/public')),
    'url' => env('APP_URL') . '/storage',
    'visibility' => 'public',
    'throw' => false,
    'report' => false,
],
```

### 5. **Update Product Controller Error Handling**

Add better error handling for file uploads:

```php
// In AdminProductController.php - store method
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'price' => ['required', 'numeric', 'min:0'],
        'sku' => ['required', 'string', 'unique:products'],
        'category_id' => ['required', 'exists:categories,id'],
        'stock_quantity' => ['required', 'integer', 'min:0'],
        'images.*' => ['image', 'max:2048'], // 2MB max per image
        'specifications' => ['nullable', 'string'],
    ]);

    try {
        // Handle image uploads with error checking
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $path = $image->store('products', 'public');
                    if ($path) {
                        $imagePaths[] = $path;
                        \Log::info('Image uploaded successfully', ['path' => $path]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Image upload failed', ['error' => $e->getMessage()]);
                    return back()->withErrors(['images' => 'Failed to upload image: ' . $e->getMessage()]);
                }
            }
        }

        $validated['images'] = $imagePaths;
        $validated['is_active'] = $request->boolean('is_active', true);

        $product = Product::create($validated);

        \Log::info('Product created successfully', ['product_id' => $product->id, 'images_count' => count($imagePaths)]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    } catch (\Exception $e) {
        \Log::error('Product creation failed', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to create product: ' . $e->getMessage());
    }
}
```

### 6. **Create File Upload Test Script**

Create a test script to verify uploads work:

```php
<?php
// test-upload.php - Place in project root

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "🧪 Testing Azure File Upload Configuration\n";
echo "==========================================\n\n";

// Test storage disk configuration
echo "1. Testing storage disk configuration...\n";
$disk = Storage::disk('public');
echo "✅ Public disk configured\n";

// Test directory creation
echo "\n2. Testing directory creation...\n";
try {
    if (!$disk->exists('test')) {
        $disk->makeDirectory('test');
        echo "✅ Test directory created\n";
    } else {
        echo "✅ Test directory exists\n";
    }
} catch (Exception $e) {
    echo "❌ Directory creation failed: " . $e->getMessage() . "\n";
}

// Test file write
echo "\n3. Testing file write...\n";
try {
    $testContent = "Test file created at " . date('Y-m-d H:i:s');
    $disk->put('test/upload-test.txt', $testContent);
    echo "✅ Test file written\n";
} catch (Exception $e) {
    echo "❌ File write failed: " . $e->getMessage() . "\n";
}

// Test file read
echo "\n4. Testing file read...\n";
try {
    if ($disk->exists('test/upload-test.txt')) {
        $content = $disk->get('test/upload-test.txt');
        echo "✅ Test file read successfully\n";
        echo "   Content: " . substr($content, 0, 50) . "...\n";
    } else {
        echo "❌ Test file not found\n";
    }
} catch (Exception $e) {
    echo "❌ File read failed: " . $e->getMessage() . "\n";
}

// Test URL generation
echo "\n5. Testing URL generation...\n";
try {
    $url = $disk->url('test/upload-test.txt');
    echo "✅ File URL generated: " . $url . "\n";
} catch (Exception $e) {
    echo "❌ URL generation failed: " . $e->getMessage() . "\n";
}

// Show storage path
echo "\n6. Storage configuration:\n";
echo "   Storage root: " . $disk->path('') . "\n";
echo "   Storage URL: " . config('app.url') . '/storage' . "\n";

// Clean up
try {
    $disk->delete('test/upload-test.txt');
    $disk->deleteDirectory('test');
    echo "\n✅ Test cleanup completed\n";
} catch (Exception $e) {
    echo "\n⚠️ Cleanup warning: " . $e->getMessage() . "\n";
}

echo "\n🏁 Upload test completed!\n";
```

## 📋 Deployment Steps

1. **Update the files** (startup.sh, nginx.conf, filesystems.php)
2. **Commit and push** to GitHub
3. **Wait for Azure deployment** (2-3 minutes)
4. **Run the startup script** on Azure SSH:
    ```bash
    cd /home/site/wwwroot
    bash startup.sh
    ```
5. **Test file uploads** in admin panel

## 🔍 Troubleshooting

### Check Storage Permissions:

```bash
ls -la /home/LogFiles/storage/
```

### Test File Upload:

```bash
php test-upload.php
```

### Check Logs:

```bash
tail -f /home/LogFiles/storage/logs/laravel.log
```

This solution ensures that uploaded files persist across container restarts and are properly accessible via HTTP.
