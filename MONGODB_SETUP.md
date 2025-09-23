# MongoDB Dual Database Setup Guide

## Overview

This document outlines the MongoDB implementation for the TechBuy Laravel application's dual database architecture.

## Architecture

-   **PostgreSQL**: Users, authentication, orders, admin system (Primary)
-   **MongoDB**: Products, categories, reviews, analytics (Secondary/Enhanced)

## Current Status

✅ **Completed:**

-   MongoDB models created (MongoProduct, MongoCategory, ProductReview, ProductAnalytic)
-   DualDatabaseService for database synchronization
-   TrackProductAnalytics middleware for real-time analytics
-   MongoProductController for enhanced product operations
-   Migration command (products:migrate-to-mongodb)

❌ **Pending:**

-   MongoDB PHP extension installation (`ext-mongodb`)
-   MongoDB server setup and configuration
-   Data migration from PostgreSQL to MongoDB

## MongoDB Extension Installation

### macOS (using Homebrew)

```bash
# Install MongoDB PHP extension
brew install mongodb/brew/mongodb-community-shim
pecl install mongodb

# Add to php.ini
echo "extension=mongodb.so" >> /opt/homebrew/etc/php/8.x/php.ini
```

### Ubuntu/Debian

```bash
# Install MongoDB PHP extension
sudo apt-get install php-mongodb
```

### Alternative: Docker MongoDB

```bash
# Run MongoDB in Docker
docker run -d --name mongodb -p 27017:27017 -e MONGO_INITDB_ROOT_USERNAME=admin -e MONGO_INITDB_ROOT_PASSWORD=password mongo:7
```

## Configuration

### Environment Variables (.env)

```env
# MongoDB Configuration
MONGODB_HOST=127.0.0.1
MONGODB_PORT=27017
MONGODB_DATABASE=techbuy_mongo
MONGODB_USERNAME=admin
MONGODB_PASSWORD=password
```

### Database Configuration (config/database.php)

Already configured with MongoDB connection settings.

## Migration Process

### Step 1: Install MongoDB Extension

Follow the installation steps above for your operating system.

### Step 2: Start MongoDB Server

```bash
# Start MongoDB service
brew services start mongodb/brew/mongodb-community
# or
sudo systemctl start mongod
```

### Step 3: Run Migration

```bash
# Migrate products from PostgreSQL to MongoDB
php artisan products:migrate-to-mongodb

# Force migration (overwrites existing)
php artisan products:migrate-to-mongodb --force
```

### Step 4: Verify Migration

```bash
# Check migration status
php artisan tinker
# In tinker:
App\Models\Mongo\MongoProduct::count()
App\Models\Mongo\MongoCategory::count()
```

## Features Implemented

### 1. MongoDB Models

-   **MongoProduct**: Enhanced product model with analytics integration
-   **MongoCategory**: Hierarchical category structure
-   **ProductReview**: Customer reviews with approval workflow
-   **ProductAnalytic**: Comprehensive analytics tracking

### 2. Analytics Tracking

-   Real-time view tracking
-   Cart addition monitoring
-   Purchase conversion tracking
-   Device and referrer analytics
-   Geographic data collection

### 3. Dual Database Service

-   Automatic synchronization between PostgreSQL and MongoDB
-   Fallback mechanisms for reliability
-   Migration utilities

### 4. Enhanced Controllers

-   MongoProductController with advanced features
-   Analytics endpoints
-   Trending products detection
-   Advanced search capabilities

## API Endpoints

### Product Analytics

```
GET /api/products/{id}/analytics - Get product analytics
GET /api/products/trending - Get trending products
POST /api/products/{id}/cart-addition - Record cart addition
POST /api/products/{id}/purchase - Record purchase
```

### Product Search

```
GET /api/products/search?q=term - Advanced MongoDB search
```

## Fallback Strategy

If MongoDB is not available, the application will:

1. Gracefully fallback to PostgreSQL operations
2. Log warnings about MongoDB unavailability
3. Continue normal functionality without analytics

## Benefits of MongoDB Implementation

### Performance

-   Faster complex queries for product catalogs
-   Efficient handling of nested data (variants, attributes)
-   Better performance for analytics aggregations

### Scalability

-   Horizontal scaling capabilities
-   Better handling of high-volume analytics data
-   Flexible schema for product variations

### Analytics

-   Real-time analytics tracking
-   Complex aggregation queries
-   Better insights into customer behavior

## Monitoring and Maintenance

### Daily Tasks

-   Monitor analytics data collection
-   Check synchronization between databases
-   Review performance metrics

### Weekly Tasks

-   Reset weekly analytics counters
-   Backup MongoDB data
-   Review trending products

### Monthly Tasks

-   Reset monthly analytics counters
-   Archive old analytics data
-   Performance optimization review

## Troubleshooting

### Common Issues

1. **MongoDB connection failed**: Check if MongoDB service is running
2. **Extension not found**: Ensure `ext-mongodb` is installed and enabled
3. **Sync issues**: Check DualDatabaseService logs
4. **Performance issues**: Review indexes and query optimization

### Debug Commands

```bash
# Test MongoDB connection
php artisan tinker --execute="App\Models\Mongo\MongoProduct::raw(function(\$c) { return \$c->ping(); })"

# Check synchronization status
php artisan tinker --execute="app(\App\Services\DualDatabaseService::class)->getProductStatistics()"

# Validate data integrity
php artisan products:validate-sync
```

## Future Enhancements

-   Machine learning recommendations using MongoDB aggregation
-   Real-time inventory tracking
-   Advanced customer segmentation
-   Product performance predictions
-   A/B testing framework integration

---

**Note**: This implementation provides a robust foundation for scaling the TechBuy application while maintaining compatibility with existing PostgreSQL operations.
