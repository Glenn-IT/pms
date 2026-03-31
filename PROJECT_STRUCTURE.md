# YISMPC — Project Structure

> Complete directory and file reference for the Youth Information System of Manga Poblacion Community.

---

```
YISMPC/
├── index.php                        # Entry point — redirects to /admin
├── config.php                       # Core app config, DB connection, helper functions
├── config_public.php                # Config for the public/user portal
├── initialize.php                   # Defines base_url, DB credentials (admin side)
├── initialize_public.php            # Defines base_url, DB credentials (public side)
├── .htaccess                        # Apache rewrite rules
├── README.md                        # Project overview and setup guide
├── PROJECT_STRUCTURE.md             # This file
│
├── database/
│   ├── pms_db.sql                   # Full database schema + seed data
│   └── banner_table.sql             # Banner/slideshow table schema
│
├── classes/                         # Core PHP classes (OOP backend)
│   ├── DBConnection.php             # MySQL database connection (admin)
│   ├── DBConnection_public.php      # MySQL database connection (public portal)
│   ├── Login.php                    # Authentication logic
│   ├── Master.php                   # Base CRUD operations
│   ├── QRCodeGenerator.php          # QR code generation wrapper
│   ├── SystemSettings.php           # System settings and user session helpers
│   ├── Users.php                    # Admin user management
│   ├── UsersPublic.php              # Public/youth user management
│   └── Users_public.php             # (Legacy) public user class
│
├── inc/                             # Shared includes (public-facing)
│   ├── header.php                   # HTML head, meta, CSS links
│   ├── footer.php                   # Footer markup and scripts
│   ├── navigation.php               # Public navigation bar
│   ├── defaultNav.php               # Default nav fallback
│   ├── topBarNav.php                # Top bar navigation
│   ├── packages.php                 # JS/CSS package loader
│   └── sess_auth.php                # Session authentication guard
│
├── assets/
│   ├── css/                         # Custom stylesheets
│   ├── js/                          # Custom JavaScript files
│   └── images/                      # Static image assets
│
├── libs/
│   ├── phpqrcode/                   # PHPQRCode library (QR generation)
│   ├── navbarclock.js               # Navbar clock widget
│   └── style.css                    # Shared lib styles
│
├── plugins/                         # Third-party frontend plugins
│   ├── bootstrap/                   # Bootstrap 4
│   ├── chart.js/                    # Chart.js (dashboard charts)
│   ├── datatables/                  # jQuery DataTables
│   ├── datatables-bs4/              # DataTables Bootstrap 4 integration
│   ├── datatables-responsive/       # Responsive DataTables
│   ├── datatables-buttons/          # DataTables export buttons
│   ├── daterangepicker/             # Date range picker
│   ├── dropzone/                    # Drag-and-drop file uploads
│   ├── ekko-lightbox/               # Image lightbox
│   ├── filterizr/                   # Grid filtering animations
│   └── ...                          # Other AdminLTE plugins
│
├── build/                           # Build configuration (SCSS, JS, NPM)
│   ├── config/
│   ├── js/
│   ├── npm/
│   └── scss/
│
├── uploads/                         # User-uploaded files (images, QR codes, etc.)
│
│
├── admin/                           # ── ADMIN PANEL ──────────────────────────────
│   ├── index.php                    # Admin entry — loads layout shell
│   ├── login.php                    # Admin login page
│   ├── logout.php                   # Session destroy + redirect
│   ├── home.php                     # Dashboard content (announcements, events, QR)
│   ├── qr_scanner.php               # QR code scanner interface
│   ├── page_underconstruct.php      # Placeholder for under-construction pages
│   ├── 404.html                     # Admin 404 error page
│   │
│   ├── inc/                         # Admin-specific includes
│   │   ├── header.php               # Admin HTML head
│   │   ├── footer.php               # Admin footer
│   │   ├── defaultNav.php           # Sidebar navigation
│   │   ├── navigation-a.php         # Alternate navigation
│   │   ├── topBarNav.php            # Top bar (user info, notifications)
│   │   └── sess_auth.php            # Admin session guard
│   │
│   ├── announcement/
│   │   └── index.php                # Announcement CRUD management
│   │
│   ├── event/
│   │   └── index.php                # Event CRUD management
│   │
│   ├── attendance/
│   │   ├── index.php                # Attendance overview
│   │   ├── view_attendance.php      # Detailed attendance per event
│   │   ├── present.php              # Present attendees list
│   │   ├── absent.php               # Absent attendees list
│   │   ├── load_present_attendees.php  # AJAX loader — present list
│   │   ├── load_absent_attendees.php   # AJAX loader — absent list
│   │   ├── export_present_list.php  # Export present list (Excel/PDF)
│   │   ├── export_absent_list.php   # Export absent list
│   │   ├── send_bulk_notifications.php    # Send bulk SMS/email notifications
│   │   ├── send_individual_notification.php  # Send individual notification
│   │   ├── attendance_report.php    # Attendance report view
│   │   ├── debug_absent.php         # Debug tool — absent logic
│   │   └── debug_zones.php          # Debug tool — zone assignments
│   │
│   ├── QRCode/
│   │   ├── index.php                # QR code management list
│   │   ├── modal_content.php        # QR code modal (view/print)
│   │   └── test_modal.php           # QR modal test page
│   │
│   ├── banner/
│   │   └── index.php                # Banner/slideshow CRUD
│   │
│   ├── skofficials/
│   │   ├── index.php                # SK Officials list and management
│   │   ├── manage_officials.php     # Add/edit SK official
│   │   ├── assign_official.php      # Assign official to position
│   │   ├── database_setup.php       # DB setup for SK officials
│   │   ├── setup_database.php       # Alternate DB setup script
│   │   ├── update_database.php      # DB migration script
│   │   ├── add_image_column.sql     # SQL to add image column
│   │   ├── debug_images.php         # Debug image path issues
│   │   ├── test_connection.php      # Test DB connection
│   │   ├── test_direct_access.php   # Test direct file access
│   │   ├── test_paths.html          # Test image paths
│   │   └── test_upload.php          # Test file upload
│   │
│   ├── activepurok/
│   │   └── index.php                # Active Purok management
│   │
│   ├── population/
│   │   └── index.php                # Youth population records
│   │
│   ├── reports/
│   │   ├── visitor_report.php       # Visitor logs report
│   │   └── record_history.php       # Event/attendance record history
│   │
│   ├── user/
│   │   ├── index.php                # User management overview
│   │   ├── list.php                 # User list (DataTable)
│   │   └── manage_user.php          # Add/edit/delete users
│   │
│   ├── system_info/
│   │   ├── index.php                # System information/settings
│   │   └── age_management.php       # Youth age classification management
│   │
│   ├── actions/
│   │   ├── index.php                # Action dispatcher
│   │   ├── manage_action.php        # Generic manage actions (CRUD AJAX)
│   │   └── view_action.php          # Generic view actions (AJAX)
│   │
│   ├── aboutus/                     # About Us page management
│   ├── devs/                        # Developer credits page
│   └── forgot_password/             # Admin password recovery
│
│
└── user/                            # ── PUBLIC / USER PORTAL ─────────────────────
    ├── index.php                    # Public home page
    ├── login.php                    # Youth user login
    ├── logout.php                   # User session destroy
    ├── register.php                 # New user registration (current)
    ├── register_new.php             # Registration (new version draft)
    ├── register_old.php             # Registration (legacy backup)
    ├── index_new.php                # Home page (new version draft)
    ├── index_old_backup.php         # Home page (legacy backup)
    ├── sk_officials.php             # Public view — SK Officials
    ├── about_us.php                 # Community about page
    ├── developers.php               # Developer credits page
    ├── forum.php                    # Community forum
    ├── guest.php                    # Guest/unauthenticated view
    ├── get_qr_code.php              # Fetch QR code for logged-in user
    └── forgot_password/             # User password recovery flow
```

---

## Key File Relationships

```
Browser Request
    │
    ▼
index.php  ──► config.php ──► initialize.php   (DB constants, base_url)
                          ──► DBConnection.php  (PDO/MySQLi connection)
                          ──► SystemSettings.php (session, user data)
    │
    ▼
admin/index.php  ──► inc/sess_auth.php  (session guard)
                 ──► inc/header.php     (layout top)
                 ──► inc/defaultNav.php (sidebar)
                 ──► home.php           (dashboard content)
                 ──► inc/footer.php     (layout bottom)
    │
    ▼
admin/actions/manage_action.php  (all CRUD AJAX calls route here via Master.php)
```

---

## Notes

- **Uploads** are stored in `/uploads/` — ensure this directory is writable (`chmod 755` or equivalent).
- **QR codes** are generated server-side using `libs/phpqrcode/` and stored in `/uploads/`.
- **Debug/test files** in `admin/skofficials/` (`debug_*.php`, `test_*.php`) should be removed before production deployment.
- **Legacy backup files** in `user/` (`*_old*.php`, `*_backup*.php`, `*_new.php`) should be cleaned up before production.
- The `_index.html` in the root is a legacy/placeholder file and is not used by the application.
