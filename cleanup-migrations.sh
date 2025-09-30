#!/bin/bash

echo "🔧 Comprehensive Migration Cleanup"
echo "=================================="

echo "Identified issues:"
echo "1. ❌ profile_photo_path column already exists in users table (line 18)"
echo "2. ❌ Two duplicate admin table migrations"
echo "3. ❌ Other potential conflicts"
echo ""

echo "🗑️ Removing problematic migrations..."

# Remove the redundant profile photo migration since it's already in users table
if [ -f "database/migrations/2025_09_23_152500_add_profile_photo_path_to_users_table.php" ]; then
    echo "   - Removing redundant profile_photo_path migration"
    rm "database/migrations/2025_09_23_152500_add_profile_photo_path_to_users_table.php"
fi

# Remove duplicate admin table migration (keep the later one)
if [ -f "database/migrations/2025_09_23_154601_create_admins_table.php" ]; then
    echo "   - Removing duplicate admin table migration (older one)"
    rm "database/migrations/2025_09_23_154601_create_admins_table.php"
fi

echo ""
echo "📋 Remaining migrations:"
ls -la database/migrations/ | wc -l
echo "   $(ls database/migrations/ | wc -l) migration files remain"

echo ""
echo "✅ Migration cleanup complete!"
echo ""
echo "Next: Deploy and run clean migration in Azure"
