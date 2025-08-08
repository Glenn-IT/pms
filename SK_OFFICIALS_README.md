# SK Officials Management System

## Overview

This is a simple SK Officials management system that allows admin users to manage Sangguniang Kabataan (SK) officials information.

## Features

- **Display SK Officials**: Shows all active SK officials in a card-based layout
- **Position Management**: Supports 1 SK Chairman and up to 7 SK Councilors
- **Role-Based Access Control**:
  - **Admins**: Can add, edit, delete, and view officials
  - **Non-Admin Users**: Can only view officials (read-only access)
- **Image Support**: Officials can have profile pictures
- **Simple Interface**: Clean and easy-to-use interface

## Official Information Fields

- **Name**: Full name of the SK official
- **Position**: Either "SK Chairman" or "SK Councilor"
- **Zone**: The zone they represent
- **Age**: Age of the official (18-99 years)
- **Contact**: Contact number
- **Image**: Profile picture (optional)

## Access

- Navigate to: `admin/?page=skofficials`
- Or use the "SK Officials" menu item in the admin navigation

## Database

- Table: `sk_officials`
- Default data includes 1 Chairman and 7 Councilors
- Images stored in: `uploads/sk_officials/`

## Functions

- **Add Official**: Click "Add Official" button
- **Edit Official**: Click "Edit" button on any official card
- **Delete Official**: Click "Delete" button (soft delete - sets status to 0)

## Limitations

- Maximum 1 SK Chairman allowed
- Maximum 7 SK Councilors allowed
- Only admins can manage officials
- Simple validation on age (18-99 years)

## Files Structure

```
admin/skofficials/
├── index.php              # Main display page
└── manage_official.php    # Add/Edit form

database/
└── sk_officials.sql       # Database structure

classes/
└── Master.php            # Added save_official() and delete_official() functions

uploads/sk_officials/     # Image storage directory
```

## Notes

- The system uses the existing PMS framework
- Integrates with the existing user authentication
- Uses Bootstrap styling for responsive design
- AJAX for form submissions
- Image upload with preview functionality
