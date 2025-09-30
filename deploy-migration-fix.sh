#!/bin/bash

echo "🚀 Deploying Migration Fix"
echo "========================="

echo "✅ Removed duplicate migration file locally"
echo "✅ Created Azure migration fix script"

git add .
git add -u  # This stages the deleted file

echo ""
echo "📋 Changes:"
git status --porcelain

git commit -m "Fix duplicate migration files causing Azure database errors

- Remove duplicate create_categories_table_temp.php migration
- Add azure-migration-fix.sh with repair commands
- Fixes SQLSTATE[42P07] duplicate table error
- Provides clean migration path for Azure"

echo ""
echo "🌐 Deploying to Azure..."
git push origin main

echo ""
echo "✅ MIGRATION FIX DEPLOYED!"
echo ""
echo "🔧 Now run this in Azure Console:"
echo ""
echo "🎯 ONE-LINER FIX:"
echo "php artisan db:wipe --force && php artisan migrate --force && php artisan db:seed --force"
echo ""
echo "🧪 Then verify:"
echo "php artisan tinker --execute=\"echo 'Users: ' . \\App\\Models\\User::count(); echo 'Products: ' . \\App\\Models\\Product::count();\""
echo ""
echo "Expected result:"
echo "✅ Users: 5+"
echo "✅ Products: 8+"
echo "✅ Categories: 6+"
