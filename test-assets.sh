#!/bin/bash

echo "Azure Asset Deployment Diagnostic"
echo "================================="
echo ""

BASE_URL="https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net"

echo "Testing asset accessibility..."
echo ""

# Test the homepage
echo "1. Testing homepage..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/")
if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ Homepage responds: $HTTP_CODE"
else
    echo "❌ Homepage failed: $HTTP_CODE"
fi

# Test CSS asset (using the new filename)
echo ""
echo "2. Testing CSS assets..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/build/assets/app-D-IKpomT.css")
if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ CSS asset accessible: $HTTP_CODE"
else
    echo "❌ CSS asset failed: $HTTP_CODE"
fi

# Test JS asset
echo ""
echo "3. Testing JS assets..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/build/assets/app-Bj43h_rG.js")
if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ JS asset accessible: $HTTP_CODE"
else
    echo "❌ JS asset failed: $HTTP_CODE"
fi

# Test Livewire
echo ""
echo "4. Testing Livewire..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/livewire/livewire.min.js")
if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ Livewire accessible: $HTTP_CODE"
else
    echo "❌ Livewire failed: $HTTP_CODE"
fi

# Test Laravel diagnostic
echo ""
echo "5. Testing Laravel diagnostic..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/azure-test.php")
if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ Laravel test accessible: $HTTP_CODE"
else
    echo "❌ Laravel test failed: $HTTP_CODE"
fi

echo ""
echo "6. Test manifest file..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/build/manifest.json")
if [ "$HTTP_CODE" = "200" ]; then
    echo "✅ Build manifest accessible: $HTTP_CODE"
else
    echo "❌ Build manifest failed: $HTTP_CODE"
fi

echo ""
echo "================================="
echo "Diagnostic complete!"
echo ""
echo "If all tests show ✅, your deployment is successful!"
echo "If any show ❌, the deployment may still be in progress or needs troubleshooting."
echo ""
echo "Manual test: Visit $BASE_URL and check browser console for 404 errors"
