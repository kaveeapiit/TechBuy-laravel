<?php
// test-upload.php - Place in project root for testing file uploads

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "🧪 Testing Azure File Upload Configuration\n";
echo "==========================================\n\n";

// Test storage disk configuration
echo "1. Testing storage disk configuration...\n";
try {
    $disk = Storage::disk('public');
    echo "✅ Public disk configured\n";
    echo "   Storage root: " . $disk->path('') . "\n";
} catch (Exception $e) {
    echo "❌ Storage disk error: " . $e->getMessage() . "\n";
    exit(1);
}

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
    $testContent = "Test file created at " . date('Y-m-d H:i:s') . "\nStorage path: " . $disk->path('test/upload-test.txt');
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
        echo "   Content preview: " . substr($content, 0, 50) . "...\n";
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

// Test product upload directory
echo "\n6. Testing product upload directory...\n";
try {
    if (!$disk->exists('products')) {
        $disk->makeDirectory('products');
        echo "✅ Products directory created\n";
    } else {
        echo "✅ Products directory exists\n";
    }
    echo "   Products path: " . $disk->path('products') . "\n";
} catch (Exception $e) {
    echo "❌ Products directory test failed: " . $e->getMessage() . "\n";
}

// Show current configuration
echo "\n7. Current storage configuration:\n";
echo "   App URL: " . config('app.url') . "\n";
echo "   Storage URL: " . config('app.url') . '/storage' . "\n";
echo "   Default disk: " . config('filesystems.default') . "\n";
echo "   Public disk root: " . config('filesystems.disks.public.root') . "\n";

// Check if directories are writable
echo "\n8. Directory permissions check:\n";
$pathsToCheck = [
    $disk->path(''),
    $disk->path('products'),
    '/home/LogFiles',
    '/home/LogFiles/storage'
];

foreach ($pathsToCheck as $path) {
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path) ? 'writable' : 'not writable';
        echo "   {$path}: {$perms} ({$writable})\n";
    } else {
        echo "   {$path}: does not exist\n";
    }
}

// Clean up test file
echo "\n9. Cleanup...\n";
try {
    if ($disk->exists('test/upload-test.txt')) {
        $disk->delete('test/upload-test.txt');
        echo "✅ Test file deleted\n";
    }
    if ($disk->exists('test') && count($disk->files('test')) === 0) {
        $disk->deleteDirectory('test');
        echo "✅ Test directory removed\n";
    }
} catch (Exception $e) {
    echo "⚠️ Cleanup warning: " . $e->getMessage() . "\n";
}

echo "\n🏁 Upload test completed!\n";
echo "If all tests passed, file uploads should work in the admin panel.\n";
