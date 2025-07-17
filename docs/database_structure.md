# DENR TOIS Database Structure Documentation

## Table of Contents
- [Overview](#overview)
- [Tables](#tables)
  - [Employees](#employees)
  - [Positions](#positions)
  - [Employment Statuses](#employment-statuses)
  - [Div Sec Units](#div-sec-units)
  - [Users](#users)
- [Relationships](#relationships)
- [Migration Order](#migration-order)

## Overview
This document provides a comprehensive overview of the database structure for the DENR TOIS (Technical Operations and Information System) application. The database is designed to manage employee information, positions, employment statuses, and organizational units.

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

1. **One-to-One Relationships**
   - Employee has one User (via employee_id)

2. **One-to-Many Relationships**
   - Position has many Employees
   - Employment Status has many Employees
   - Div Sec Unit has many Employees

3. **Cascade Behavior**
   - Deleting a Position/Div Sec Unit/Employment Status will cascade delete related Employees
   - Deleting an Employee will set null in related User's employee_id

## Migration Order
The migrations must be run in this specific order to avoid foreign key constraint issues:

1. `0001_01_01_000000_create_users_table.php` (Basic users table)
2. `2025_07_17_011556_create_positions_table.php`
3. `2025_07_17_011557_create_employment_statuses_table.php`
4. `2025_07_17_011558_create_div_sec_units_table.php`
5. `2025_07_17_011559_create_employees_table.php`
6. `2025_07_17_011600_add_employee_relationship_to_users.php` (Add employee relationship to users)

## Notes
- All tables use Laravel's default timestamp columns (created_at, updated_at)
- Foreign key constraints are enforced with proper cascade behavior
- The database uses MySQL as the backend
- All string fields are properly indexed where necessary for performance
- The schema is designed to be extensible for future enhancements
