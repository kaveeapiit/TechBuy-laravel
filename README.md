# TechBuy Laravel Ecommerce

## Overview

TechBuy is a modern Laravel-based ecommerce application for electronics retail. The application features a comprehensive product catalog, user authentication, shopping cart functionality, and order management.

## Features

### Laravel Foundation

-   Laravel 12 with Jetstream authentication
-   MVC architecture
-   Eloquent ORM models
-   Database migrations and seeders

### Eloquent Models

**Core Models:**

-   `Category` - Product categories
-   `Product` - Product catalog with specifications and pricing
-   `Cart` - User shopping carts
-   `CartItem` - Individual cart items
-   `Order` - Customer orders
-   `OrderItem` - Order line items
-   `User` - User accounts with relationships

**Features:**

-   Model relationships (hasMany, belongsTo, hasOne)
-   Accessors and mutators
-   Automatic slug generation
-   JSON casting for specifications and images
-   Custom route key names

### Eloquent ORM

-   Database queries using Eloquent
-   Model relationships testing
-   Data manipulation and retrieval

### Laravel Controllers

**Web Controllers:**

-   `HomeController` - Homepage with featured products
-   `ProductController` - Product listings and details
-   `CartController` - Shopping cart management
-   `CheckoutController` - Order processing

**API Controllers:**

-   `Api\ProductController` - RESTful product API
-   `Api\CategoryController` - Category management API
-   `Api\CartController` - Cart API with authentication

### API Development

**RESTful Endpoints:**

-   `GET /api/categories` - List all categories
-   `GET /api/categories/{id}` - Get category details
-   `GET /api/products` - List products with filtering
-   `GET /api/products/{id}` - Get product details
-   `POST /api/cart` - Add item to cart (authenticated)
-   `PUT /api/cart/{id}` - Update cart item (authenticated)
-   `DELETE /api/cart/{id}` - Remove cart item (authenticated)

### API Authentication

-   Laravel Sanctum for API authentication
-   Protected routes with `auth:sanctum` middleware
-   Token-based authentication for cart operations
-   User model configured with HasApiTokens trait

### User Authentication

-   Laravel Jetstream with Livewire stack
-   Complete authentication system (login, register, profile)
-   Team management features
-   Two-factor authentication support
-   Profile photo management

### Livewire Components

**Interactive Components:**

-   `ProductList` - Dynamic product filtering and searching
-   `ProductDetail` - Interactive product view with cart functionality
-   `ShoppingCart` - Real-time cart management

**Features:**

-   Real-time search and filtering
-   Dynamic cart updates
-   Reactive UI components
-   Form handling with validation

### UI/UX Design

**Frontend:**

-   Tailwind CSS for responsive design
-   Clean and intuitive user interface
-   Mobile-first approach
-   Professional ecommerce layout

**User Experience:**

-   Intuitive navigation
-   Clear product categorization
-   Search and filtering functionality
-   Streamlined checkout process
-   Visual feedback for user actions

## Database Schema

### Categories Table

-   id, name, slug, description, image, is_active, timestamps

### Products Table

-   id, name, slug, description, short_description
-   price, sale_price, sku, stock_quantity
-   manage_stock, in_stock, is_active
-   images (JSON), specifications (JSON)
-   brand, model, category_id, weight, dimensions
-   timestamps

### Carts Table

-   id, user_id, session_id, timestamps

### Cart Items Table

-   id, cart_id, product_id, quantity, price, timestamps

### Orders Table

-   id, order_number, user_id, status
-   total_amount, tax_amount, shipping_amount
-   billing_address (JSON), shipping_address (JSON)
-   payment_method, payment_status, notes
-   shipped_at, delivered_at, timestamps

### Order Items Table

-   id, order_id, product_id, product_name, product_sku
-   quantity, price, total, timestamps

## Sample Data

The application includes sample data for testing:

-   6 product categories: iPhones, MacBooks, Android Phones, Laptops, Tablets, Accessories
-   8 sample products with specifications and pricing
-   Featured products with promotional pricing

## Routes

### Web Routes

-   `/` - Homepage
-   `/products` - Product listing
-   `/category/{slug}` - Category-specific products
-   `/product/{slug}` - Product details
-   `/cart` - Shopping cart (authenticated)
-   `/checkout` - Checkout process (authenticated)

### API Routes

-   `/api/categories` - Category management
-   `/api/products` - Product management
-   `/api/cart/*` - Cart management (authenticated)

## Technology Stack

-   Laravel 12
-   Jetstream (Authentication)
-   Livewire (Frontend interactivity)
-   Sanctum (API authentication)
-   Tailwind CSS (Styling)
-   SQLite (Database)
-   Eloquent ORM

## Installation

1. Clone the repository
2. Install PHP dependencies: `composer install`
3. Install Node.js dependencies: `npm install`
4. Copy environment file: `cp .env.example .env`
5. Generate application key: `php artisan key:generate`
6. Run database migrations: `php artisan migrate --seed`
7. Build frontend assets: `npm run dev`
8. Start the development server: `php artisan serve`

## Usage

1. Visit http://127.0.0.1:8000 to access the application
2. Browse products by category
3. View product details
4. Register or login to add items to cart
5. Complete the checkout process
6. Test API endpoints for integration

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
