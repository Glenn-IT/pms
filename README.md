# YISMPC — Youth Information System of Manga Poblacion Community

> A web-based Punong Barangay Management System (PMS) tailored for youth community management, event tracking, QR code attendance, and barangay administration.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Default Credentials](#default-credentials)
- [Project Structure](#project-structure)
- [Database](#database)
- [Modules](#modules)
- [User Roles](#user-roles)

---

## Overview

YISMPC is a PHP/MySQL web application running on a XAMPP stack. It provides tools for barangay administrators and SK (Sangguniang Kabataan) officers to manage youth residents, announcements, events, attendance via QR codes, banners, reports, and population data.

---

## Features

| Feature | Description |
|---|---|
| 🔐 Authentication | Secure login/logout with session management for Admin and Youth roles |
| 📢 Announcements | Create, manage, and publish community announcements |
| 📅 Events | Create events with QR-based attendance tracking |
| 📷 QR Code Attendance | Generate and scan QR codes for event check-in |
| 🏞 Banner Slideshow | Admin-managed banner/slideshow for the public portal |
| 👥 SK Officials | Manage Sangguniang Kabataan officials with photo uploads |
| 🏘 Active Purok | Manage and display active puroks in the community |
| 👨‍👩‍👧 Population Management | Track and manage youth residents and their profiles |
| 📊 Reports | Visitor logs and event record history |
| 🔞 Age Management | Automated age-category tracking for youth classification |
| 🌐 Public Portal | User-facing portal for registration, login, and community info |
| 📋 Forum | Community forum for youth engagement |

---

## Tech Stack

- **Backend:** PHP 7.x / 8.x
- **Database:** MySQL (via XAMPP/phpMyAdmin)
- **Frontend:** HTML5, CSS3, JavaScript (jQuery)
- **UI Framework:** AdminLTE 3 + Bootstrap 4
- **QR Library:** PHPQRCode (libs/phpqrcode)
- **Charts:** Chart.js
- **DataTables:** jQuery DataTables
- **Icons:** Font Awesome 5

---

## Requirements

- [XAMPP](https://www.apachefriends.org/) v7.4+ (Apache + MySQL + PHP)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- A modern web browser

---

## Installation

1. **Clone or copy** the project folder into your XAMPP web root:
   ```
   C:\xampp\htdocs\YISMPC\
   ```

2. **Start XAMPP** — ensure Apache and MySQL services are running.

3. **Create the database:**
   - Open [phpMyAdmin](http://localhost/phpmyadmin)
   - Create a new database named `pms_db`
   - Import the SQL file:
     ```
     database/pms_db.sql
     ```
   - *(Optional)* Import banner table:
     ```
     database/banner_table.sql
     ```

4. **Access the application:**
   ```
   http://localhost/YISMPC/
   ```

---

## Configuration

Edit `initialize.php` to match your environment:

```php
define('base_url', 'http://localhost/YISMPC/');
define('DB_SERVER',   'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME',     'pms_db');
```

For the **public portal**, edit `initialize_public.php` with equivalent settings.

---

## Default Credentials

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `admin123` |

> ⚠️ Change default credentials immediately after first login.

---

## Database

| File | Description |
|---|---|
| `database/pms_db.sql` | Full database schema and seed data |
| `database/banner_table.sql` | Banner/slideshow table schema |

---

## Modules

### Admin Panel (`/admin`)

| Module | Path | Description |
|---|---|---|
| Dashboard | `admin/home.php` | Overview of announcements, events, QR tools |
| Announcements | `admin/announcement/` | CRUD for community announcements |
| Events | `admin/event/` | Event creation and management |
| Attendance | `admin/attendance/` | View present/absent lists, export reports |
| QR Scanner | `admin/qr_scanner.php` | Scan QR codes for attendance |
| QR Code Manager | `admin/QRCode/` | Generate and view QR codes |
| Banner | `admin/banner/` | Manage homepage banner slideshow |
| SK Officials | `admin/skofficials/` | Manage officials with photo uploads |
| Active Purok | `admin/activepurok/` | Manage active puroks |
| Population | `admin/population/` | Youth population records |
| Reports | `admin/reports/` | Visitor and record history reports |
| User Management | `admin/user/` | Add/edit/delete system users |
| System Info | `admin/system_info/` | System settings and age management |
| About Us | `admin/aboutus/` | Manage about page content |
| Developers | `admin/devs/` | Developer credits page |

### Public / User Portal (`/user`)

| Page | File | Description |
|---|---|---|
| Home | `user/index.php` | Public landing page |
| Login | `user/login.php` | Youth user login |
| Register | `user/register.php` | New user registration |
| SK Officials | `user/sk_officials.php` | Public view of SK officials |
| About Us | `user/about_us.php` | Community info page |
| Developers | `user/developers.php` | Dev credits page |
| Forum | `user/forum.php` | Community forum |
| Guest | `user/guest.php` | Guest view |

---

## User Roles

| Role | Access |
|---|---|
| `1` — Administrator | Full access to all admin modules |
| `2` — Youth / SK Officer | Limited dashboard, events, announcements, QR tools |
| Public / Guest | Registration, public portal, SK officials view |
