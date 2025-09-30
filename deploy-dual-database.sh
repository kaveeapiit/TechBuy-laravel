#!/bin/bash

echo "==================== DUAL DATABASE AZURE DEPLOYMENT ===================="
echo "🚀 Deploying TechBuy with PostgreSQL + MongoDB Architecture"
echo ""

# Commit the comprehensive dual database setup
git add .
git commit -m "feat: Comprehensive dual database setup with MongoDB support

🎯 Complete Database Architecture:
- PostgreSQL: Core data (users, orders, auth, basic products/categories)
- MongoDB: Enhanced product data (analytics, reviews, rich content)

✅ What's included:
- Fixed ProductionSeeder with all required PostgreSQL fields
- New MongoDBSeeder for enhanced product features
- Smart MongoDB detection (gracefully handles missing extension)
- Comprehensive product analytics and review system
- SEO-optimized content structure

🔧 Technical improvements:
- All database constraints satisfied (no more NULL violations)
- Production-safe seeding (no factory dependencies)
- Dual database support with fallback handling
- Enhanced product catalog with MongoDB features"

# Push to Azure
echo "📤 Pushing to Azure..."
git push origin main

echo ""
echo "==================== AZURE DATABASE SETUP ===================="
echo "Run these commands in your Azure console:"
echo ""
echo "1. Navigate to directory:"
echo "   cd /home/site/wwwroot"
echo ""
echo "2. Clear and reseed both databases:"
echo "   php artisan db:wipe --force && php artisan migrate --force && php artisan db:seed --class=ProductionSeeder --force"
echo ""
echo "3. Verify PostgreSQL data:"
echo "   php artisan tinker"
echo "   >>> \\App\\Models\\User::count()           // Should be: 2"
echo "   >>> \\App\\Models\\Category::count()       // Should be: 6"
echo "   >>> \\App\\Models\\Product::count()        // Should be: 4"
echo "   >>> \\App\\Models\\Product::first()->sku   // Should be: IPH-15-PRO-001"
echo "   >>> exit"
echo ""
echo "4. Check MongoDB status (optional):"
echo "   php artisan tinker"
echo "   >>> extension_loaded('mongodb')           // Shows if MongoDB extension is available"
echo "   >>> \\App\\Models\\Mongo\\MongoProduct::count() // MongoDB product count (if extension available)"
echo "   >>> exit"
echo ""
echo "==================== DATABASE ARCHITECTURE EXPLAINED ===================="
echo ""
echo "🎯 DUAL DATABASE DESIGN:"
echo ""
echo "📊 PostgreSQL (Primary Database):"
echo "   ✅ Users & Authentication (Laravel Jetstream)"
echo "   ✅ Orders & Shopping Cart"
echo "   ✅ Basic Categories & Products"
echo "   ✅ Core e-commerce functionality"
echo "   ✅ ACID transactions for critical data"
echo ""
echo "🍃 MongoDB (Enhanced Features):"
echo "   📈 Product Analytics & Views"
echo "   ⭐ Product Reviews & Ratings"
echo "   🖼️  Rich Product Media & Specifications"
echo "   🔍 Search Optimization Data"
echo "   📱 Device & Geographic Analytics"
echo "   🏷️  Enhanced Tagging & Categorization"
echo ""
echo "🔧 SMART FALLBACK SYSTEM:"
echo "   - If MongoDB extension is NOT installed:"
echo "     ✅ Site works perfectly with PostgreSQL only"
echo "     ✅ Basic product catalog fully functional"
echo "     ⚠️  Advanced analytics features disabled"
echo ""
echo "   - If MongoDB extension IS installed:"
echo "     ✅ Full dual database functionality"
echo "     ✅ Advanced product features enabled"
echo "     ✅ Rich analytics and reviews"
echo ""
echo "==================== EXPECTED RESULTS ===================="
echo ""
echo "After running the seeding commands:"
echo ""
echo "✅ PostgreSQL will contain:"
echo "   - 2 users (admin@techbuy.com, test@example.com)"
echo "   - 6 product categories"
echo "   - 4 sample products with all required fields"
echo "   - All data needed for basic e-commerce functionality"
echo ""
echo "✅ MongoDB will contain (if extension available):"
echo "   - 6 enhanced categories with SEO data"
echo "   - 4 products with rich specifications and features"
echo "   - Analytics data for each product"
echo "   - Sample review and rating data"
echo ""
echo "🌐 Your TechBuy website will be fully functional!"
echo ""
echo "==================== MONGODB INSTALLATION (OPTIONAL) ===================="
echo "To enable advanced MongoDB features in Azure:"
echo ""
echo "1. Add to your Azure App Service Configuration:"
echo "   MONGODB_HOST=your-mongodb-connection-string"
echo "   MONGODB_DATABASE=techbuy_products"
echo "   MONGODB_USERNAME=your-username"
echo "   MONGODB_PASSWORD=your-password"
echo ""
echo "2. Install MongoDB PHP extension (contact Azure support or use custom container)"
echo ""
echo "3. Re-run seeding to populate MongoDB:"
echo "   php artisan db:seed --class=MongoDBSeeder --force"
echo ""
echo "📝 Note: The site works perfectly without MongoDB - it's just an enhancement!"
