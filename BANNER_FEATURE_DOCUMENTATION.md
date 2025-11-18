# Banner Management Feature

## Overview

The Banner Management feature allows administrators to upload and manage banner images that can be displayed on the website. This feature provides full CRUD (Create, Read, Update, Delete) functionality.

## Features

### For Administrators

1. **Add Banners**: Upload banner images with title and description
2. **Edit Banners**: Update banner details and replace images
3. **Delete Banners**: Remove unwanted banners
4. **Toggle Status**: Activate or deactivate banners
5. **Sort Banners**: Sort by newest or oldest first
6. **View Banners**: Preview banner images in full size

### Banner Properties

- **Title**: Required, descriptive name for the banner
- **Image**: Required on creation, optional on update
- **Description**: Optional text description
- **Status**: Active (visible) or Inactive (hidden)
- **Date Created**: Automatically recorded

## Technical Implementation

### Database Table

```sql
CREATE TABLE `banner_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `date_created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_date_created` (`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### File Structure

```
admin/
  banner/
    index.php          # Main banner management page
uploads/
  banners/             # Banner image storage directory
classes/
  Master.php           # Backend functions
database/
  banner_table.sql     # Database schema
```

### API Endpoints (Master.php)

- `save_banner` - Create or update a banner
- `get_all_banners` - Retrieve all banners
- `get_active_banners` - Get only active banners
- `delete_banner` - Delete a banner and its image
- `toggle_banner_status` - Activate/deactivate a banner

## Usage

### Access the Feature

1. Login as an administrator
2. Navigate to the "Banner" menu item in the sidebar
3. The banner management page will display all existing banners

### Add a New Banner

1. Click the "Add Banner" button
2. Fill in the required fields:
   - Title (required)
   - Image (required - recommended size: 1920x600px)
   - Description (optional)
   - Status (Active/Inactive)
3. Click "Save Banner"

### Edit a Banner

1. Click the "Edit" button on any banner card
2. Modify the fields as needed
3. Image upload is optional when editing
4. Click "Save Banner"

### Delete a Banner

1. Click the "Delete" button on the banner card
2. Confirm the deletion
3. The banner and its image file will be permanently removed

### Activate/Deactivate a Banner

1. Click the "Activate" or "Deactivate" button
2. Confirm the action
3. Only active banners will be visible on the public-facing site

## Image Recommendations

- **Format**: JPG, PNG, or GIF
- **Size**: 1920x600px (wide banner format)
- **File Size**: Keep under 2MB for faster loading
- **Quality**: Use high-resolution images for best display

## Security Features

- Only administrators (type = 1) can manage banners
- All user inputs are sanitized to prevent SQL injection
- File uploads are validated for allowed image types
- Old images are automatically deleted when replaced

## Future Enhancements

- Image resizing/cropping functionality
- Multiple banner support with carousel
- Banner scheduling (show/hide on specific dates)
- Click tracking and analytics
- Link URLs for banner clickthrough

## Notes

- The banner feature is currently admin-only
- User-facing display functionality can be implemented as needed
- All banner images are stored in `uploads/banners/`
- Image files are named with banner ID and timestamp for uniqueness
