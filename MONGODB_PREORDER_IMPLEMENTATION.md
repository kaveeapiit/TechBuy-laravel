# MongoDB CRUD Implementation: Contact Us & Pre-Orders System

## 🎯 **Implementation Overview**

This implementation demonstrates **complete CRUD operations on MongoDB** through a Contact Us page with Pre-order functionality, perfectly meeting your assignment requirements for dual database operations.

## ✅ **Features Implemented**

### **1. Contact Us Page** (`/contact`)

-   **Modern Design**: Matches site theme with glass effects and gradients
-   **Dual Functionality**: Contact form + Pre-order form
-   **Responsive Layout**: Works on all devices
-   **Authentication Integration**: Pre-orders require login

### **2. MongoDB Pre-Order Model** (`App\Models\Mongo\PreOrder`)

-   **Full MongoDB Integration**: Uses `mongodb/laravel-mongodb` package
-   **Rich Data Structure**: Includes status tracking, contact info, timestamps
-   **Relationships**: Links to PostgreSQL User model (dual database)
-   **Status Management**: pending → confirmed → processing → completed/cancelled

### **3. Complete CRUD Operations**

#### **Create** ✅

-   **Route**: `POST /contact/preorder`
-   **Controller**: `ContactController::storePreOrder()`
-   **Form**: Contact Us page pre-order form
-   **Features**: User auto-fill, validation, error handling

#### **Read** ✅

-   **Route**: `GET /profile/preorders`
-   **Controller**: `PreOrderController::index()`
-   **View**: User dashboard with pre-orders list
-   **Features**: Filtering, pagination, status display

#### **Update** ✅

-   **Route**: `PUT /profile/preorders/{id}`
-   **Controller**: `PreOrderController::update()`
-   **Form**: Edit pre-order form (only for pending orders)
-   **Features**: Validation, status restrictions, error handling

#### **Delete** ✅

-   **Route**: `DELETE /profile/preorders/{id}`
-   **Controller**: `PreOrderController::destroy()`
-   **Features**: Confirmation dialog, status restrictions, soft constraints

#### **Additional Operations** ✅

-   **Show**: `GET /profile/preorders/{id}` - Detailed view
-   **Cancel**: `PATCH /profile/preorders/{id}/cancel` - Status update
-   **Edit Form**: `GET /profile/preorders/{id}/edit` - Edit interface

## 🔗 **Routes & Navigation**

### **New Routes Added**

```php
// Contact Us
GET  /contact                     → Contact page with pre-order form
POST /contact/preorder           → Store new pre-order (MongoDB)
POST /contact/message            → Send contact message

// User Dashboard - Pre-orders CRUD
GET    /profile/preorders        → List all user pre-orders
GET    /profile/preorders/create → Create form (alternative)
POST   /profile/preorders        → Store new pre-order
GET    /profile/preorders/{id}   → Show pre-order details
GET    /profile/preorders/{id}/edit → Edit form
PUT    /profile/preorders/{id}   → Update pre-order
DELETE /profile/preorders/{id}   → Delete pre-order
PATCH  /profile/preorders/{id}/cancel → Cancel pre-order
```

### **Navigation Integration**

-   **Main Menu**: "Contact Us" link added
-   **User Dropdown**: "My Pre-Orders" link added
-   **Mobile Menu**: Both links added for mobile users

## 📊 **Database Architecture**

### **PostgreSQL** (Existing)

```
users (id, name, email, ...)
products (id, name, price, ...)
categories (id, name, ...)
orders (id, user_id, ...)
```

### **MongoDB** (New)

```javascript
// pre_orders collection
{
  _id: ObjectId,
  user_id: Integer,          // Links to PostgreSQL users.id
  name: String,
  email: String,
  mobile_number: String,
  preorder_item: String,
  status: String,            // pending, confirmed, processing, completed, cancelled
  notes: String,             // Admin notes
  estimated_delivery: Date,
  created_at: Date,
  updated_at: Date
}
```

## 🎨 **User Experience**

### **Contact Us Page**

-   **Left Side**: Contact information and general contact form
-   **Right Side**: Pre-order form with status features
-   **Styling**: Consistent with site theme (glass panels, gradients)
-   **Responsiveness**: Mobile-friendly layout

### **User Dashboard Pre-Orders**

-   **List View**: Card-based layout with status badges
-   **Actions**: View, Edit, Cancel, Delete based on status
-   **Status Tracking**: Visual progress indicators
-   **Empty State**: Encourages first pre-order

### **CRUD Forms**

-   **Create**: Via contact page or dashboard
-   **Edit**: Full form for pending orders only
-   **View**: Detailed information with timeline
-   **Delete**: Confirmation with restrictions

## 🔒 **Security & Validation**

### **Input Validation**

```php
'name' => ['required', 'string', 'max:255'],
'email' => ['required', 'email', 'max:255'],
'mobile_number' => ['required', 'string', 'max:20'],
'preorder_item' => ['required', 'string', 'max:500'],
```

### **Authorization**

-   **User Ownership**: Users can only access their own pre-orders
-   **Status Restrictions**: Edit/Delete only for specific statuses
-   **Authentication**: Pre-orders require login

### **Error Handling**

-   **MongoDB Unavailable**: Graceful fallback with user notification
-   **Connection Errors**: Logged and user-friendly error messages
-   **Validation Errors**: Field-specific error display

## 📱 **Responsive Design**

### **Mobile Optimization**

-   **Navigation**: Hamburger menu with all links
-   **Forms**: Touch-friendly inputs and buttons
-   **Cards**: Stack properly on small screens
-   **Actions**: Accessible button placement

### **Desktop Experience**

-   **Grid Layouts**: Two-column contact page
-   **Hover Effects**: Interactive elements with transitions
-   **Dropdowns**: Smooth user menu animations

## 🚀 **MongoDB Features Utilized**

### **Laravel MongoDB Package**

-   **Eloquent Integration**: Standard Laravel model syntax
-   **Relationships**: Mixed SQL/NoSQL relationships
-   **Migrations**: Schema-less flexible structure
-   **Querying**: Fluent query builder support

### **MongoDB-Specific Features**

-   **ObjectId**: Native MongoDB document IDs
-   **Flexible Schema**: Easy to add fields later
-   **Fast Queries**: Optimized for read operations
-   **Scalability**: Ready for large datasets

## 🎯 **Assignment Requirements Met**

### ✅ **Dual Database Usage**

-   **PostgreSQL**: Users, Products, Categories, Orders (existing)
-   **MongoDB**: Pre-orders (new implementation)
-   **Integration**: PreOrder model links to PostgreSQL User model

### ✅ **Complete CRUD Operations**

-   **PostgreSQL**: Full admin CRUD for Products, Users, Categories
-   **MongoDB**: Full user CRUD for Pre-orders (Create, Read, Update, Delete)

### ✅ **Web Interface**

-   **PostgreSQL**: Admin dashboard for product management
-   **MongoDB**: User dashboard for pre-order management
-   **Public Interface**: Contact page with pre-order submission

### ✅ **Modern Design**

-   **Consistent Styling**: Matches existing site theme
-   **User Experience**: Intuitive navigation and interactions
-   **Responsive**: Works on all device sizes

## 🔄 **Data Synchronization**

### **User Data Integration**

-   **Auto-fill**: Pre-order forms use authenticated user data
-   **Consistency**: User changes reflected in pre-orders
-   **Relationships**: MongoDB documents reference PostgreSQL IDs

### **Status Management**

-   **Workflow**: pending → confirmed → processing → completed
-   **Business Logic**: Status-based permission restrictions
-   **Admin Control**: Future admin interface can manage statuses

## 📈 **Extensibility**

### **Future Enhancements**

-   **Admin Interface**: Manage all pre-orders from admin panel
-   **Email Notifications**: Status change notifications
-   **Inventory Integration**: Link pre-orders to actual products
-   **Analytics**: Pre-order trends and insights
-   **Payment Integration**: Secure pre-order payments

### **Additional MongoDB Collections**

-   **Reviews**: Product reviews and ratings
-   **Analytics**: User behavior tracking
-   **Notifications**: Real-time user notifications
-   **Wishlist**: User saved items

## 🛠 **Development Notes**

### **MongoDB Installation**

-   **Extension**: Requires `mongodb` PHP extension
-   **Package**: Uses `mongodb/laravel-mongodb`
-   **Fallback**: Graceful degradation when unavailable

### **Testing**

-   **Seeder**: `PreOrderSeeder` for sample data
-   **Error Handling**: Comprehensive error scenarios covered
-   **Edge Cases**: Status restrictions and validation edge cases

---

## 🎉 **Summary**

This implementation successfully demonstrates:

1. **Complete MongoDB CRUD operations** through a real-world pre-order system
2. **Dual database architecture** with PostgreSQL and MongoDB working together
3. **Professional user interface** matching the site's modern design
4. **Full user experience** from discovery to management
5. **Scalable architecture** ready for future enhancements

**Perfect for your assignment requirements** showing both databases with full CRUD operations and modern web development practices! 🚀
