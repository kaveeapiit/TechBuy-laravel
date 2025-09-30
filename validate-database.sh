#!/bin/bash

echo "==================== DATABASE SCHEMA VALIDATION ===================="
echo "Checking for potential database issues..."

# Check if all migration files are clean
echo "✅ Checking migration files..."
MIGRATION_COUNT=$(find database/migrations -name "*.php" | wc -l)
echo "   Found $MIGRATION_COUNT migration files"

# Check for duplicate migration files
echo "✅ Checking for duplicate migrations..."
DUPLICATE_CHECK=$(find database/migrations -name "*create_products*" | wc -l)
if [ $DUPLICATE_CHECK -gt 1 ]; then
    echo "   ⚠️  Multiple product migrations found - this could cause issues"
    find database/migrations -name "*create_products*"
else
    echo "   ✅ No duplicate product migrations"
fi

DUPLICATE_CAT_CHECK=$(find database/migrations -name "*create_categories*" | wc -l)
if [ $DUPLICATE_CAT_CHECK -gt 1 ]; then
    echo "   ⚠️  Multiple category migrations found - this could cause issues"
    find database/migrations -name "*create_categories*"
else
    echo "   ✅ No duplicate category migrations"
fi

# Check ProductionSeeder for all required fields
echo "✅ Checking ProductionSeeder structure..."
if grep -q "sku" database/seeders/ProductionSeeder.php; then
    echo "   ✅ SKU field present in ProductionSeeder"
else
    echo "   ❌ SKU field missing in ProductionSeeder"
fi

if grep -q "brand" database/seeders/ProductionSeeder.php; then
    echo "   ✅ Brand field present in ProductionSeeder"
else
    echo "   ⚠️  Brand field missing in ProductionSeeder"
fi

if grep -q "manage_stock" database/seeders/ProductionSeeder.php; then
    echo "   ✅ manage_stock field present in ProductionSeeder"
else
    echo "   ⚠️  manage_stock field missing in ProductionSeeder"
fi

# Check for factory usage (should not be used in production)
echo "✅ Checking for factory usage in ProductionSeeder..."
if grep -q "factory\|fake()" database/seeders/ProductionSeeder.php; then
    echo "   ❌ Factory usage found - this will fail in production"
else
    echo "   ✅ No factory usage - production safe"
fi

# Check Model fillable fields
echo "✅ Checking Product model fillable fields..."
if grep -q "sku" app/Models/Product.php; then
    echo "   ✅ SKU in Product fillable array"
else
    echo "   ❌ SKU missing from Product fillable array"
fi

echo ""
echo "==================== VALIDATION COMPLETE ===================="
echo "If all checks show ✅, the seeder should work in Azure production."
echo "If any ❌ or ⚠️  appear, those need to be fixed first."