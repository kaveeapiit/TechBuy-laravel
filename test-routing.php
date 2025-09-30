<?php
echo "🧪 Laravel Routing Test\n";
echo "=====================\n\n";

// Test if pretty URLs are working
$tests = [
    '✅ Index page' => '/',
    '🔐 Login page' => '/login',
    '📝 Register page' => '/register',
    '📊 Dashboard' => '/dashboard',
    '🛍️ Products' => '/products',
];

echo "Testing Laravel routes:\n\n";

foreach ($tests as $name => $route) {
    $url = "https://" . $_SERVER['HTTP_HOST'] . $route;
    echo "$name: $url\n";

    // Test if route exists (simple check)
    $context = stream_context_create([
        'http' => [
            'method' => 'HEAD',
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);

    $headers = @get_headers($url, 1, $context);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "   Status: ✅ OK\n";
    } elseif ($headers && strpos($headers[0], '302') !== false) {
        echo "   Status: 🔄 Redirect (probably OK)\n";
    } else {
        echo "   Status: ❌ Error or not accessible\n";
    }
    echo "\n";
}

echo "🌐 Current request info:\n";
echo "   Protocol: " . (isset($_SERVER['HTTPS']) ? 'HTTPS' : 'HTTP') . "\n";
echo "   Host: " . $_SERVER['HTTP_HOST'] . "\n";
echo "   URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "   User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') . "\n";

echo "\n🔍 Server variables:\n";
$important_vars = ['HTTP_X_FORWARDED_PROTO', 'HTTP_X_FORWARDED_FOR', 'HTTPS', 'SERVER_PORT'];
foreach ($important_vars as $var) {
    echo "   $var: " . ($_SERVER[$var] ?? 'Not set') . "\n";
}
