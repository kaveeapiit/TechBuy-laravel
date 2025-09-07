# TechBuy Laravel Ecommerce Project

## Overview

TechBuy is a comprehensive Laravel ecommerce application that demonstrates all the concepts covered in your university course. It's a modern electronics store selling iPhones, MacBooks, Android phones, laptops, and more.

## Features Implemented

### Week 1 - Laravel Foundation ✅

-   Complete Laravel 12 setup with Jetstream
-   MVC architecture implementation
-   Eloquent models for ecommerce entities
-   Database migrations and seeders

### Week 2 - Eloquent Models ✅

**Models Created:**

-   `Category` - Product categories (iPhones, MacBooks, etc.)
-   `Product` - Products with specifications, pricing, inventory
-   `Cart` - Shopping cart for users
-   `CartItem` - Individual cart items
-   `Order` - Customer orders
-   `OrderItem` - Order line items
-   `User` - Extended with cart and order relationships

**Model Features:**

-   Relationships (hasMany, belongsTo, hasOne)
-   Accessors and mutators (getCurrentPrice(), isOnSale())
-   Automatic slug generation
-   JSON casting for specifications and images
-   Custom route key names

### Week 3 - Artisan Tinker for Eloquent ORM ✅

-   Demonstrated Eloquent queries using PHP script
-   Model relationships testing
-   Database interaction examples
-   Data manipulation through Eloquent

### Week 4 - Laravel Controllers ✅

**Web Controllers:**

-   `HomeController` - Homepage with featured products
-   `ProductController` - Product listings and details
-   `CartController` - Shopping cart management
-   `CheckoutController` - Order processing

**API Controllers:**

-   `Api\ProductController` - RESTful product API
-   `Api\CategoryController` - Category management API
-   `Api\CartController` - Cart API with authentication

### Week 5 - Laravel API ✅

**API Endpoints:**

-   `GET /api/categories` - List all categories
-   `GET /api/categories/{id}` - Get category details
-   `GET /api/products` - List products with filtering
-   `GET /api/products/{id}` - Get product details
-   `POST /api/cart` - Add item to cart (authenticated)
-   `PUT /api/cart/{id}` - Update cart item (authenticated)
-   `DELETE /api/cart/{id}` - Remove cart item (authenticated)

### Week 6 - Laravel API Authentication with Sanctum ✅

-   Sanctum package installed and configured
-   API routes protected with `auth:sanctum` middleware
-   Cart API requires authentication
-   User model configured with HasApiTokens trait

### Week 8 - Laravel Authentication using Jetstream ✅

-   Jetstream with Livewire stack installed
-   Complete authentication system (login, register, profile)
-   Team management features
-   Two-factor authentication support
-   Profile photo management

### Week 9 - Introduction to Livewire ✅

**Livewire Components:**

-   `ProductList` - Dynamic product filtering and searching
-   `ProductDetail` - Interactive product view with cart functionality
-   `ShoppingCart` - Real-time cart management

**Livewire Features:**

-   Real-time search and filtering
-   Dynamic cart updates
-   Reactive UI components
-   Form handling with validation

### Week 10 - UI/UX and Best Practices ✅

**Frontend Design:**

-   Tailwind CSS for modern, responsive design
-   Clean and intuitive user interface
-   Mobile-first responsive design
-   Professional ecommerce layout

**UX Features:**

-   Intuitive navigation
-   Clear product categorization
-   Easy-to-use search and filters
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

-   6 categories: iPhones, MacBooks, Android Phones, Laptops, Tablets, Accessories
-   8 sample products with realistic specifications and pricing
-   Featured products with sale prices
-   Complete product information including specifications

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

## Key Technologies Used

-   Laravel 12
-   Jetstream (Authentication)
-   Livewire (Frontend interactivity)
-   Sanctum (API authentication)
-   Tailwind CSS (Styling)
-   SQLite (Database)
-   Eloquent ORM

## Getting Started

1. Clone the repository
2. Run `composer install`
3. Run `npm install && npm run dev`
4. Set up your `.env` file
5. Run `php artisan migrate --seed`
6. Start the server with `php artisan serve`

## Testing the Application

1. Visit http://127.0.0.1:8000 to see the homepage
2. Browse products by category
3. View individual product details
4. Register/login to add items to cart
5. Test the API endpoints for integration

This project demonstrates a complete understanding of Laravel fundamentals, from basic MVC patterns to advanced features like API development, authentication, and real-time UI components with Livewire.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
