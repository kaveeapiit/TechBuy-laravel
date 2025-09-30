#!/bin/bash

echo "🔧 Azure Database Migration Fix"
echo "=============================="

echo "Issue: Duplicate migration files causing table conflicts"
echo "Solution: Clean migration state and run properly"
echo ""

echo "Run these commands in Azure Console:"
echo ""

echo "1. 🗑️ Drop all tables (clean slate):"
echo "   php artisan db:wipe --force"
echo ""

echo "2. 🔄 Run migrations only (without fresh):"
echo "   php artisan migrate --force"
echo ""

echo "3. 🌱 Seed the database:"
echo "   php artisan db:seed --force"
echo ""

echo "4. 🧪 Verify success:"
echo "   php artisan tinker --execute=\"echo 'Users: ' . \\App\\Models\\User::count(); echo 'Products: ' . \\App\\Models\\Product::count(); echo 'Categories: ' . \\App\\Models\\Category::count();\""
echo ""

echo "🎯 One-liner fix:"
echo "php artisan db:wipe --force && php artisan migrate --force && php artisan db:seed --force && php artisan tinker --execute=\"echo 'Fixed! Users: ' . \\App\\Models\\User::count() . ', Products: ' . \\App\\Models\\Product::count() . ', Categories: ' . \\App\\Models\\Category::count();\""
echo ""

echo "⚠️ What happened:"
echo "- migrate:fresh tried to drop tables but some remained"
echo "- Duplicate migration files tried to create same table"
echo "- db:wipe completely cleans database"
echo "- migrate then runs all migrations cleanly"
