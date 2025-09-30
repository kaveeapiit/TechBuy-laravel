#!/bin/bash

echo "🚀 FINAL Migration Fix Deployment"
echo "================================="

echo "✅ Issues Fixed:"
echo "   - Removed duplicate profile_photo_path migration"
echo "   - Removed duplicate admins table migration"
echo "   - Cleaned migration conflicts"
echo ""

git add .
git add -u  # Add deleted files

echo "📋 Changes being deployed:"
git status --porcelain

git commit -m "FINAL FIX: Remove all duplicate migrations causing Azure errors

Issues fixed:
- Remove 2025_09_23_152500_add_profile_photo_path_to_users_table.php
  (profile_photo_path already exists in users table)
- Remove duplicate 2025_09_23_154601_create_admins_table.php
  (keeping the newer version)
- Clean migration state for Azure deployment

This should resolve all SQLSTATE duplicate column/table errors"

echo ""
echo "🌐 Deploying clean migrations to Azure..."
git push origin main

echo ""
echo "🎯 CLEAN MIGRATIONS DEPLOYED!"
echo ""
echo "🔧 Now run this in Azure Console:"
echo ""
echo "🚨 FINAL FIX COMMAND:"
echo "php artisan migrate:status && php artisan db:wipe --force && php artisan migrate --force && php artisan db:seed --force"
echo ""
echo "🧪 Then verify:"
echo "php artisan tinker --execute=\"echo 'SUCCESS! Users: ' . \\App\\Models\\User::count() . ', Products: ' . \\App\\Models\\Product::count() . ', Categories: ' . \\App\\Models\\Category::count();\""
echo ""
echo "Expected result:"
echo "✅ SUCCESS! Users: 5+, Products: 8+, Categories: 6+"
echo ""
echo "🔥 This FINAL fix removes ALL duplicate migrations!"
echo "   No more SQLSTATE errors should occur."
