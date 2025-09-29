#!/bin/bash

echo "Azure Application Settings Configuration Helper"
echo "=============================================="
echo ""
echo "GitHub's push protection prevented us from committing the .env.production file"
echo "because it contains sensitive Azure credentials. This is good security!"
echo ""
echo "Instead, you need to configure these settings in Azure App Service:"
echo ""
echo "1. Go to Azure Portal"
echo "2. Navigate to: App Service → techbuy-webapp → Configuration → Application Settings"
echo "3. Add these Key-Value pairs:"
echo ""

# Read the local .env.production file and format it for Azure
if [ -f ".env.production" ]; then
    echo "=== COPY THESE SETTINGS TO AZURE ==="
    echo ""
    while IFS= read -r line; do
        # Skip empty lines and comments
        if [[ -n "$line" && ! "$line" =~ ^[[:space:]]*# ]]; then
            # Extract key=value pairs
            if [[ "$line" =~ ^[^=]+= ]]; then
                key=$(echo "$line" | cut -d'=' -f1)
                value=$(echo "$line" | cut -d'=' -f2-)
                echo "Key: $key"
                echo "Value: $value"
                echo "---"
            fi
        fi
    done < .env.production
    echo ""
    echo "=== END OF SETTINGS ==="
else
    echo "❌ .env.production file not found locally"
    echo "Please create it first with your Azure credentials"
fi

echo ""
echo "4. After adding all settings, click 'Save'"
echo "5. Restart the App Service"
echo "6. Test your application"
echo ""
echo "Alternative: Use the Azure CLI:"
echo "az webapp config appsettings set --name techbuy-webapp --resource-group techbuy-rg --settings KEY=VALUE"
echo ""
echo "📖 Full documentation: AZURE_ENVIRONMENT_SETUP.md"
