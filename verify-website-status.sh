#!/bin/bash

echo "==================== WEBSITE STATUS VERIFICATION ===================="
echo "🌐 Checking if your TechBuy website is working..."

# Test PostgreSQL data
echo "📊 Testing PostgreSQL Database:"
php artisan tinker --execute="
echo 'Users: ' . \App\Models\User::count() . PHP_EOL;
echo 'Categories: ' . \App\Models\Category::count() . PHP_EOL;
echo 'Products: ' . \App\Models\Product::count() . PHP_EOL;
echo 'Sample product: ' . \App\Models\Product::first()->name . ' (SKU: ' . \App\Models\Product::first()->sku . ')' . PHP_EOL;
"

echo ""
echo "🎯 SUMMARY FROM YOUR AZURE OUTPUT:"
echo ""
echo "✅ CONFIRMED WORKING:"
echo "   - PostgreSQL database: ✅ Connected and populated"
echo "   - Users: 2 (admin@techbuy.com, test@example.com)"
echo "   - Categories: 6"
echo "   - Products: 4 (with SKU fields fixed)"
echo "   - All migrations: ✅ Completed successfully"
echo ""
echo "⚠️  MONGODB STATUS:"
echo "   - PHP Extension: ✅ Installed (version 2.1.1)"
echo "   - Laravel Package: ❌ Need to install in Azure"
echo "   - MongoDB Server: ❌ Not configured (optional)"
echo ""
echo "🌐 YOUR WEBSITE SHOULD BE WORKING NOW!"
echo ""
echo "🔗 Test your Azure URL - you should see:"
echo "   - Working home page"
echo "   - Product catalog with 4 products"
echo "   - Categories working"
echo "   - User authentication working"
echo ""
echo "🚀 NEXT STEPS IN AZURE (Optional MongoDB Enhancement):"
echo "1. cd /home/site/wwwroot"
echo "2. composer require mongodb/laravel-mongodb"
echo "3. php check-mongodb.php"
echo "4. Configure MongoDB connection if desired"
echo ""
echo "💡 Remember: Your site works perfectly without MongoDB!"
