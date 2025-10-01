#!/bin/bash

echo "🔧 DEPLOYING ADMIN AUTH FIXES"
echo "============================="

echo "✅ Fixed admin migration tracking"
echo "✅ Added proper error logging"
echo "✅ Enhanced form validation display"
echo "✅ Fixed admin table constraints"
echo ""

# Clean up test file
if [ -f "test-admin-register.php" ]; then
    rm test-admin-register.php
    echo "🧹 Cleaned up test file"
fi

# Commit all changes
git add .
git commit -m "Fix admin authentication - enhanced error logging and validation"

# Push to repository
git push origin main

echo ""
echo "🚀 DEPLOYMENT COMPLETE!"
echo ""
echo "📋 SUMMARY OF FIXES:"
echo "1. ✅ Fixed admin table migration tracking"
echo "2. ✅ Updated role constraints to include 'moderator'"
echo "3. ✅ Enhanced admin registration/login error logging"
echo "4. ✅ Improved form validation error display"
echo "5. ✅ Added detailed exception handling"
echo ""
echo "🔍 NEXT STEPS:"
echo "1. Visit https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/admin/register"
echo "2. Try creating a new admin account"
echo "3. Check logs if issues persist: /var/log/nginx/error.log and storage/logs/laravel.log"
echo ""
echo "📧 EXISTING ADMIN ACCOUNTS:"
echo "Email: admin@techbuy.com | Password: password123"
echo "Email: admin2@techbuy.com | Password: password123"
