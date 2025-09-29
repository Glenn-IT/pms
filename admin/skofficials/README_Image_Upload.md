# SK Officials Image Upload Feature

## Overview

This feature allows administrators to upload and manage profile pictures for SK Officials instead of using static icons.

## Features Added

### 1. Database Changes

- Added `image` column to `sk_officials` table
- Column type: `varchar(255)` to store image file paths
- Default value: `NULL`

### 2. Image Upload Functionality

- **File Types Supported**: JPG, JPEG, PNG, GIF
- **Maximum File Size**: 5MB
- **Storage Location**: `uploads/sk_officials/`
- **Naming Convention**: `{position}_{timestamp}.{extension}`

### 3. User Interface Improvements

- **Profile Picture Preview**: Shows uploaded images in organizational chart
- **Upload Interface**: Drag-and-drop style image upload in modals
- **Image Management**: Easy image replacement and removal
- **Responsive Design**: Works on desktop and mobile devices

## Files Modified

### Core Files

1. `admin/skofficials/index.php` - Main SK Officials management page
2. `admin/skofficials/manage_officials.php` - Backend API for official management
3. `admin/skofficials/update_database.php` - Database update script

### New Files

1. `admin/skofficials/test_upload.php` - Test page for image upload functionality
2. `admin/skofficials/add_image_column.sql` - SQL script for database changes
3. `uploads/sk_officials/` - Directory for storing official images

## Usage Instructions

### For Administrators

#### Uploading Profile Pictures

1. Navigate to SK Officials management page
2. Click on "Manage Chairman", "Manage Secretary", "Manage Treasurer", or "Manage Kagawads"
3. In the modal that opens, click on the profile picture area or "Choose Image" button
4. Select an image file (JPG, PNG, GIF, max 5MB)
5. Preview will show immediately
6. Fill in other required information (Name, Contact)
7. Click "Save Changes" to upload and save

#### Managing Kagawad Images

1. Click "Manage Kagawads" button
2. Each kagawad has their own image upload section
3. Click on the image area or "Choose" button for each kagawad
4. Upload and save individually for each kagawad

### Image Display

- **With Image**: Shows circular profile picture with hover effects
- **Without Image**: Shows default FontAwesome icons
- **Fallback**: Automatically falls back to icons if image fails to load

## Technical Details

### Backend Processing

```php
// Image upload handling in manage_officials.php
private function handleImageUpload($file, $position) {
    // Validates file type and size
    // Creates unique filename
    // Deletes old image if exists
    // Moves uploaded file to storage directory
    // Returns file path for database storage
}
```

### Frontend Features

- **Real-time Preview**: JavaScript FileReader API for instant preview
- **Form Validation**: Client-side validation for file type and size
- **Progress Indicators**: Loading animations during upload
- **Error Handling**: User-friendly error messages
- **Success Notifications**: Toast notifications for successful uploads

### Security Measures

- **File Type Validation**: Only allows image file types
- **File Size Limits**: Maximum 5MB per image
- **Unique Filenames**: Prevents file conflicts and overwrites
- **Directory Protection**: Images stored outside web-accessible areas where possible

## Installation Steps

1. **Database Update**:

   ```sql
   ALTER TABLE `sk_officials` ADD COLUMN `image` varchar(255) DEFAULT NULL AFTER `address`;
   ```

2. **Create Upload Directory**:

   ```bash
   mkdir uploads/sk_officials
   chmod 755 uploads/sk_officials
   ```

3. **File Permissions**:
   - Ensure `uploads/sk_officials/` is writable by web server
   - Set appropriate permissions for uploaded files

## Testing

### Test Upload Page

Use `admin/skofficials/test_upload.php` to test image upload functionality:

1. Open the test page in browser
2. Select a position and fill required fields
3. Upload a test image
4. Verify success/error responses

### Manual Testing

1. Upload images for different positions
2. Verify images appear in organizational chart
3. Test image replacement
4. Test with different file types and sizes
5. Verify error handling for invalid files

## Troubleshooting

### Common Issues

1. **Upload Directory Not Writable**

   - Check directory permissions
   - Ensure web server can write to `uploads/sk_officials/`

2. **Images Not Displaying**

   - Verify file paths in database
   - Check if uploaded files exist in filesystem
   - Ensure correct image URLs

3. **File Size Errors**

   - Check PHP settings: `upload_max_filesize`, `post_max_size`
   - Verify client-side file size validation

4. **Database Errors**
   - Ensure `image` column exists in `sk_officials` table
   - Check database connection and credentials

### Debug Mode

Enable error reporting in PHP for detailed error messages during development:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Future Enhancements

### Possible Improvements

1. **Image Optimization**: Automatic image resizing and compression
2. **Bulk Upload**: Upload multiple images at once
3. **Image Editing**: Basic crop/rotate functionality in browser
4. **Cloud Storage**: Integration with cloud storage services
5. **Image Gallery**: Browse and select from previously uploaded images
6. **Backup System**: Automatic backup of uploaded images

### Performance Optimizations

1. **Thumbnail Generation**: Create smaller thumbnails for faster loading
2. **Lazy Loading**: Load images only when needed
3. **CDN Integration**: Serve images from content delivery network
4. **Caching**: Implement proper browser caching headers

## Support

For technical support or questions about this feature:

1. Check the troubleshooting section above
2. Review the code comments in modified files
3. Test with the provided test upload page
4. Verify database structure and file permissions

---

**Last Updated**: September 29, 2025
**Version**: 1.0
**Compatibility**: PHP 7.4+, MySQL 5.7+, Modern Browsers
