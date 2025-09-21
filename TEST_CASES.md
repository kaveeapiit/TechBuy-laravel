# TechBuy E-Commerce System - Test Cases Documentation

## Overview
This document contains comprehensive test cases for the TechBuy e-commerce platform, covering critical user workflows including authentication, product purchasing, and dashboard functionality.

---

## Test Case 1: User Registration and Authentication

| **Field** | **Details** |
|-----------|-------------|
| **Test Case ID** | #TB001 |
| **Test Scenario** | To verify successful user registration and login on TechBuy platform |
| **Test Steps** | 1. The user navigates to TechBuy.com<br>2. The user clicks on 'Register' button in the navigation<br>3. The user enters valid name in the 'Name' field<br>4. The user enters a unique email address in the 'Email' field<br>5. The user enters a strong password in the 'Password' field<br>6. The user confirms the password in 'Confirm Password' field<br>7. The user agrees to terms and conditions<br>8. The user clicks 'Create Account' button<br>9. The user navigates to login page<br>10. The user enters registered email and password<br>11. The user clicks 'Sign In' button |
| **Prerequisites** | - TechBuy platform is accessible<br>- User has a valid email address<br>- Database is properly configured |
| **Test Data** | - Name: "John Doe"<br>- Email: "john.doe@example.com"<br>- Password: "SecurePass123!"<br>- Confirm Password: "SecurePass123!" |
| **Expected Results** | 1. Registration form accepts all valid inputs<br>2. Account is created successfully<br>3. User receives confirmation message<br>4. Login with registered credentials succeeds<br>5. User is redirected to dashboard page<br>6. Welcome message displays user's name<br>7. Navigation shows user-specific options |
| **Actual Results** | As Expected |
| **Test Status** | **Pass** |
| **Test Category** | Authentication |
| **Priority** | High |
| **Tester** | QA Team |
| **Date Tested** | September 15, 2025 |

---

## Test Case 2: Product Purchase Workflow

| **Field** | **Details** |
|-----------|-------------|
| **Test Case ID** | #TB002 |
| **Test Scenario** | To verify complete product purchase workflow from product selection to order confirmation |
| **Test Steps** | 1. User logs into TechBuy platform<br>2. User browses to product catalog page<br>3. User selects a product (e.g., iPhone 15 Pro Max)<br>4. User views product details page<br>5. User clicks 'Add to Cart' button<br>6. User verifies cart icon shows updated count<br>7. User clicks on cart icon to view cart<br>8. User reviews cart items and quantities<br>9. User clicks 'Proceed to Checkout' button<br>10. User fills in shipping information<br>11. User selects payment method<br>12. User enters payment details<br>13. User clicks 'Place Order' button<br>14. User views order confirmation page |
| **Prerequisites** | - User account exists and is logged in<br>- Products are available in MongoDB database<br>- Payment gateway is configured<br>- Cart and order systems are functional |
| **Test Data** | - Product: "iPhone 15 Pro Max"<br>- Quantity: 1<br>- Shipping Address: "123 Tech Street, Silicon Valley, CA 94000"<br>- Payment Method: "Credit Card"<br>- Card Details: "Valid test card number" |
| **Expected Results** | 1. Product details load correctly<br>2. Add to cart functionality works<br>3. Cart count updates in real-time<br>4. Cart displays correct items and totals<br>5. Checkout form accepts valid information<br>6. Payment processing completes successfully<br>7. Order is created in PostgreSQL database<br>8. Order confirmation page shows order details<br>9. User receives order number<br>10. Cart is cleared after successful purchase |
| **Actual Results** | As Expected |
| **Test Status** | **Pass** |
| **Test Category** | E-Commerce |
| **Priority** | High |
| **Tester** | QA Team |
| **Date Tested** | September 15, 2025 |

---

## Test Case 3: User Dashboard Data Display

| **Field** | **Details** |
|-----------|-------------|
| **Test Case ID** | #TB003 |
| **Test Scenario** | To verify that user dashboard displays accurate order statistics and recent order information |
| **Test Steps** | 1. User completes at least one order (as per Test Case #TB002)<br>2. User navigates to dashboard page<br>3. User views the "Total Orders" statistic<br>4. User views the "Cart Items" count<br>5. User views the "Completed Orders" count<br>6. User views the "Total Spent" amount<br>7. User examines the "Recent Orders" section<br>8. User verifies order details in recent orders list<br>9. User checks order status indicators<br>10. User validates product names and quantities<br>11. User confirms order dates and amounts |
| **Prerequisites** | - User account exists with order history<br>- Dashboard Livewire component is functional<br>- Database contains order and cart data<br>- User has completed at least one purchase |
| **Test Data** | - Previous order: iPhone 15 Pro Max ($1,199.00)<br>- Order status: "Confirmed"<br>- Order date: Current date<br>- Current cart: May contain items |
| **Expected Results** | 1. Dashboard loads without errors<br>2. Total Orders count reflects actual orders in database<br>3. Cart Items count matches current cart contents<br>4. Completed Orders shows confirmed orders only<br>5. Total Spent displays accurate sum of completed orders<br>6. Recent Orders section shows last 5 orders<br>7. Order details include: order number, date, amount, status<br>8. Product names and quantities are displayed correctly<br>9. Order status badges show appropriate colors<br>10. All amounts are formatted correctly with currency<br>11. Quick action links are functional |
| **Actual Results** | As Expected |
| **Test Status** | **Pass** |
| **Test Category** | Dashboard |
| **Priority** | Medium |
| **Tester** | QA Team |
| **Date Tested** | September 15, 2025 |

---

## Test Summary

| **Metric** | **Count** |
|------------|-----------|
| **Total Test Cases** | 3 |
| **Passed** | 3 |
| **Failed** | 0 |
| **Success Rate** | 100% |

## Test Environment
- **Platform**: TechBuy Laravel E-Commerce System
- **Database**: PostgreSQL (Users/Orders) + MongoDB (Products)
- **Framework**: Laravel 12 with Livewire
- **Frontend**: Tailwind CSS with TechBuy Theme
- **Testing Date**: September 15, 2025

## Notes
- All test cases follow the complete user journey workflow
- Tests verify both frontend functionality and backend data integrity
- Cross-database functionality (PostgreSQL + MongoDB) is validated
- Real-time UI updates (cart count, dashboard stats) are confirmed functional
