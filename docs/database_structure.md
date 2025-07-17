# DENR TOIS Database Structure Documentation

## Table of Contents
- [Overview](#overview)
- [Tables](#tables)
  - [Employees](#employees)
  - [Positions](#positions)
  - [Employment Statuses](#employment-statuses)
  - [Div Sec Units](#div-sec-units)
  - [Users](#users)
  - [Travel Orders](#travel-orders)
  - [Travel Order Statuses](#travel-order-statuses)
  - [Travel Order User Types](#travel-order-user-types)
  - [Travel Order Signatories](#travel-order-signatories)
- [Relationships](#relationships)
- [Migration Order](#migration-order)

## Overview
This document provides a comprehensive overview of the database structure for the DENR TOIS (Technical Operations and Information System) application. The database is designed to manage employee information, positions, employment statuses, organizational units, and travel order processing.

## Tables

### Employees
The main table storing employee information.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| first_name | string | Employee's first name | Required |
| middle_name | string | Employee's middle name | Optional |
| last_name | string | Employee's last name | Required |
| suffix | string | Name suffix (e.g., Jr., Sr.) | Optional |
| age | integer | Employee's age | Required |
| gender | enum | Employee's gender | Required ('male', 'female', 'other') |
| address | text | Employee's address | Required |
| contact_num | string | Contact number | Required |
| birthdate | date | Date of birth | Required |
| date_hired | date | Date of hiring | Required |
| position_id | bigint | Reference to Positions table | Required, Foreign Key |
| div_sec_unit_id | bigint | Reference to Div Sec Units table | Required, Foreign Key |
| employment_status_id | bigint | Reference to Employment Statuses table | Required, Foreign Key |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Positions
Stores job positions and their details.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| name | string | Position name | Required |
| salary | decimal | Salary amount | Required |
| description | text | Position description | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Employment Statuses
Stores different employment statuses.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| name | string | Status name (e.g., regular, terminated) | Required |
| description | text | Status description | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Div Sec Units
Stores division, section, and unit information.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| name | string | Unit name | Required |
| description | text | Unit description | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Users
Stores authentication information for the system.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| username | string | User's login username | Required, Unique |
| password | string | Hashed password | Required |
| employee_id | bigint | Reference to Employees table | Optional, Unique, Foreign Key |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

## Relationships

### Core Employee Relationships
1. **One-to-One Relationships**
   - Employee has one User (via employee_id)

2. **One-to-Many Relationships**
   - Position has many Employees
   - Employment Status has many Employees
   - Div Sec Unit has many Employees

### Travel Order Relationships
1. **Travel Order Relationships**
   - User has many TravelOrders (as creator)
   - User has many TravelOrders (as recommending approver)
   - User has many TravelOrders (as final approver)
   - TravelOrder belongs to a User (creator)
   - TravelOrder belongs to a User (as recommending_approval)
   - TravelOrder belongs to a User (as approved_by)
   - TravelOrder belongs to a TravelOrderStatus
   - TravelOrder belongs to a TravelOrderUserType
   - TravelOrder has many TravelOrderSignatory
   - TravelOrderStatus has many TravelOrders
   - TravelOrderUserType has many TravelOrders
   - TravelOrderSignatory belongs to a TravelOrder
   - TravelOrderSignatory belongs to a User (as employee)
   - TravelOrderSignatory belongs to a TravelOrderUserType

### Cascade Behavior
- Deleting a Position/Div Sec Unit/Employment Status will cascade delete related Employees
- Deleting an Employee will set null in related User's employee_id
- Deleting a TravelOrder will cascade delete related TravelOrderSignatory
- Deleting a User will set null in related TravelOrder creator/approver fields
- Deleting a TravelOrderStatus/TravelOrderUserType will restrict deletion if referenced by TravelOrders

## Migration Order
The migrations must be run in this specific order to avoid foreign key constraint issues:

1. `0001_01_01_000000_create_users_table.php` (Basic users table)
2. `2025_07_17_011556_create_positions_table.php`
3. `2025_07_17_011557_create_employment_statuses_table.php`
4. `2025_07_17_011558_create_div_sec_units_table.php`
5. `2025_07_17_011559_create_employees_table.php`
6. `2025_07_17_011600_add_employee_relationship_to_users.php` (Add employee relationship to users)
7. `2025_07_17_155000_create_travel_order_statuses_table.php`
8. `2025_07_17_155100_create_travel_order_user_types_table.php`
9. `2025_07_17_155200_create_travel_orders_table.php`
10. `2025_07_17_155300_create_travel_order_signatories_table.php`

## Travel Order Tables

### Travel Orders
Stores travel order information.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| region | string | Region of travel | Required |
| province | string | Province of travel | Required |
| municipality | string | Municipality of travel | Required |
| station | string | Station of travel | Required |
| date | date | Date of travel | Required |
| time | time | Time of travel | Required |
| destination | text | Travel destination | Required |
| purpose | text | Purpose of travel | Required |
| status | string | Current status | Required |
| user_id | bigint | Creator of travel order | Required, Foreign Key to Users |
| recommending_approval_id | bigint | User who recommends approval | Nullable, Foreign Key to Users |
| approved_by_id | bigint | User who approved | Nullable, Foreign Key to Users |
| travel_order_status_id | bigint | Reference to status | Required, Foreign Key |
| travel_order_user_type_id | bigint | Reference to user type | Required, Foreign Key |
| recommendation_notes | text | Notes from recommender | Optional |
| approval_notes | text | Notes from approver | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Travel Order Statuses
Stores possible statuses for travel orders.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| name | string | Status name | Required, Unique |
| description | text | Status description | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Travel Order User Types
Defines different types of users in the travel order process.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| name | string | Type name | Required, Unique |
| description | text | Type description | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

### Travel Order Signatories
Tracks signatories for each travel order.

| Column Name | Type | Description | Constraints |
|-------------|------|-------------|-------------|
| id | bigint | Primary key | Auto-increment |
| travel_order_id | bigint | Reference to travel order | Required, Foreign Key |
| employee_id | bigint | Reference to employee | Required, Foreign Key to Users |
| user_type_id | bigint | Reference to user type | Required, Foreign Key |
| is_signed | boolean | Whether signed | Default: false |
| signed_at | timestamp | When signed | Nullable |
| notes | text | Signing notes | Optional |
| created_at | timestamp | Record creation timestamp | Auto |
| updated_at | timestamp | Record update timestamp | Auto |

## Notes
- All tables use Laravel's default timestamp columns (created_at, updated_at)
- Foreign key constraints are enforced with proper cascade behavior
- The database uses MySQL as the backend
- All string fields are properly indexed where necessary for performance
- The schema is designed to be extensible for future enhancements
- Travel order workflow includes status tracking and signatory management
- User roles in travel orders are managed through the TravelOrderUserType table
