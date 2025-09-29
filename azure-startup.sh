#!/bin/bash

# Azure App Service startup script for Laravel (Root Deployment)
echo "Starting Laravel Azure root deployment setup..."

# Change to application directory
cd /home/site/wwwroot

# Run the root setup script
bash azure-root-setup.sh

echo "Laravel root deployment startup completed!"

# Start Apache or your web server
# This will be handled by Azure App Service automatically
