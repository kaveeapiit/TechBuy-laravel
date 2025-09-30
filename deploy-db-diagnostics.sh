#!/bin/bash

echo "🚀 Deploying Database Diagnostic Tools"
echo "======================================"

git add azure-db-commands.txt azure-db-check.php

git commit -m "Add database diagnostic tools for Azure

- azure-db-commands.txt: Step-by-step commands to fix empty database
- azure-db-check.php: Diagnostic script to check table status
- Helps diagnose why Users: 0, Products: 0 in Azure"

git push origin main

echo ""
echo "✅ DIAGNOSTIC TOOLS DEPLOYED!"
echo ""
echo "🔧 Your database is connected but EMPTY. Here's how to fix:"
echo ""
echo "📍 In Azure Console (https://techbuy-webapp-agbgf2gbgud8apaw.scm.centralindia-01.azurewebsites.net/):"
echo ""
echo "1. 🔍 Check what's missing:"
echo "   php azure-db-check.php"
echo ""
echo "2. 🚀 Quick fix (recommended):"
echo "   php artisan migrate:fresh --seed --force"
echo ""
echo "3. 🧪 Verify fix worked:"
echo "   php artisan tinker --execute=\"echo 'Users: ' . \\App\\Models\\User::count(); echo 'Products: ' . \\App\\Models\\Product::count();\""
echo ""
echo "Expected result after fix:"
echo "✅ Users: 5+ (seeded admin and test users)"
echo "✅ Products: 8+ (sample tech products)"
echo "✅ Categories: 6+ (iPhones, MacBooks, etc.)"
echo ""
echo "💡 The issue: Database connected but no tables/data created yet!"
echo "   Migration and seeding need to run once in Azure environment."
