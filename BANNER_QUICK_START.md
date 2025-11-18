# Banner Feature - Quick Start Guide

## ✅ Installation Complete!

The Banner Management feature has been successfully installed in your PMS system.

## 📋 What Was Created

### 1. Database Table

- **Table Name**: `banner_list`
- **Status**: ✅ Created successfully
- **Location**: `pms_db` database

### 2. Files Created

```
✅ admin/banner/index.php                    # Banner management interface
✅ uploads/banners/                          # Image storage directory
✅ database/banner_table.sql                 # Database schema
✅ BANNER_FEATURE_DOCUMENTATION.md           # Full documentation
```

### 3. Backend Functions Added to `classes/Master.php`

- ✅ `save_banner()` - Create/update banners
- ✅ `get_all_banners()` - Get all banners
- ✅ `get_active_banners()` - Get active banners only
- ✅ `delete_banner()` - Delete banners
- ✅ `toggle_banner_status()` - Activate/deactivate banners

## 🚀 How to Use

### Step 1: Access the Feature

1. Open your browser and go to: `http://localhost/pms/admin/`
2. Login with your admin credentials
3. Click on **"Banner"** in the left sidebar menu

### Step 2: Add Your First Banner

1. Click the **"Add Banner"** button (top right)
2. Fill in the form:
   - **Title**: Enter a descriptive name (e.g., "Welcome Banner")
   - **Image**: Upload an image (recommended size: 1920x600px)
   - **Description**: Add optional details
   - **Status**: Select "Active" to show it immediately
3. Click **"Save Banner"**

### Step 3: Manage Banners

- **View**: Click the "View" button to see the full-size banner
- **Edit**: Click "Edit" to modify title, description, or replace image
- **Activate/Deactivate**: Toggle banner visibility
- **Delete**: Remove unwanted banners permanently

## 📁 File Locations

### Admin Interface

```
http://localhost/pms/admin/?page=banner/index
```

### Upload Directory

```
c:\xampp\htdocs\pms\uploads\banners\
```

### Backend Code

```
c:\xampp\htdocs\pms\classes\Master.php
```

## 🎨 Image Recommendations

### Best Practices

- **Format**: JPG, PNG, or GIF
- **Dimensions**: 1920x600px (wide banner)
- **File Size**: Under 2MB
- **Resolution**: High quality for best display

## ⚙️ Features Available

### Current Features

- ✅ Upload banner images
- ✅ Add title and description
- ✅ Activate/deactivate banners
- ✅ Edit existing banners
- ✅ Delete banners
- ✅ Sort by date (newest/oldest)
- ✅ View full-size preview
- ✅ Admin-only access control

### Admin Panel Features

- **Card-based layout** - Easy to scan and manage
- **Status badges** - Visual indication of active/inactive
- **Responsive design** - Works on all screen sizes
- **Image preview** - See images before uploading
- **Sort options** - Order by newest or oldest first

## 🔒 Security

- ✅ Admin-only access (type = 1)
- ✅ SQL injection prevention (sanitized inputs)
- ✅ File type validation (images only)
- ✅ Automatic old image cleanup

## 📊 Database Schema

```sql
Table: banner_list
├── id (INT, Auto Increment, Primary Key)
├── title (VARCHAR 255, Required)
├── description (TEXT, Optional)
├── image_path (VARCHAR 255)
├── status (TINYINT, 1=Active, 0=Inactive)
└── date_created (DATETIME, Auto)

Indexes:
├── idx_status (status)
└── idx_date_created (date_created)
```

## 🧪 Testing the Feature

1. **Navigate to banner management**:

   ```
   http://localhost/pms/admin/?page=banner/index
   ```

2. **Test adding a banner**:

   - Click "Add Banner"
   - Fill in required fields
   - Upload a test image
   - Save and verify it appears in the list

3. **Test editing**:

   - Click "Edit" on a banner
   - Modify the title
   - Save and verify changes

4. **Test status toggle**:

   - Click "Deactivate" on an active banner
   - Verify status badge changes to "Inactive"
   - Click "Activate" to restore

5. **Test deletion**:
   - Click "Delete" on a test banner
   - Confirm deletion
   - Verify banner is removed from list

## 🔧 Troubleshooting

### Images not uploading?

- Check that `uploads/banners/` directory exists
- Verify directory has write permissions
- Ensure file size is under PHP upload limit

### Banner page not loading?

- Verify `admin/banner/index.php` exists
- Check browser console for JavaScript errors
- Ensure you're logged in as admin (type = 1)

### Database errors?

- Confirm `banner_list` table exists
- Run `database/banner_table.sql` if needed
- Check database connection in `config.php`

## 📞 Support

For issues or questions, refer to:

- **Full Documentation**: `BANNER_FEATURE_DOCUMENTATION.md`
- **Database Schema**: `database/banner_table.sql`
- **Source Code**: `admin/banner/index.php` and `classes/Master.php`

---

## ✨ Next Steps

1. ✅ Test the banner management interface
2. ✅ Upload your first banner
3. 📱 Implement banner display on user-facing pages (coming soon)
4. 🎯 Add carousel functionality (future enhancement)

**Status**: Ready to use! 🎉
