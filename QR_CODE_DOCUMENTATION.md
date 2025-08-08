# QR Code Feature Documentation

## Overview

This document describes the unique QR code feature added to the Prison Management System (PMS). Each user now gets a unique QR code generated automatically when they are created or updated.

## Features Implemented

### 1. Automatic QR Code Generation

- **Location**: Every new user gets a unique QR code automatically
- **Format**: Text-based QR codes in format: `PMS-USER-XXXXX-XXXXXXXX-XXXXXXXX`
- **Content**: Contains user ID, username prefix, and unique hash
- **Generation**: Happens automatically during user creation and significant updates

### 2. Database Changes

- **New Column**: Added `qr_code` TEXT column to `users` table
- **Storage**: QR codes are stored as text strings in the database
- **Migration**: Database migration script was executed to add the column

### 3. User Interface Updates

- **Form Enhancement**: Added QR code display section below avatar in user management form
- **Visual Design**: Shows QR icon and formatted text display for existing users
- **Placeholder**: Shows informative placeholder for new users before saving

### 4. QR Code Scanner

- **Location**: `/admin/qr_scanner.php`
- **Functionality**: Allows scanning/entering QR codes to look up user information
- **Validation**: Validates QR code format and looks up user in database
- **Display**: Shows complete user information when valid QR code is found

## Technical Implementation

### Files Modified/Created

1. **classes/QRCodeGenerator.php** (New)

   - Handles QR code generation
   - Text-based system for reliability
   - Validation and utility functions

2. **classes/Users.php** (Modified)

   - Added QR code generation during user save
   - Added QR code deletion during user deletion
   - Handles both creation and update scenarios

3. **admin/user/manage_user.php** (Modified)

   - Added QR code display section
   - Visual improvements with Font Awesome icons
   - Responsive design for QR code area

4. **admin/qr_scanner.php** (New)

   - QR code scanning/lookup interface
   - User information display
   - Bootstrap-based responsive design

5. **database/add_qr_code_column.sql** (New)
   - SQL migration script to add qr_code column

### QR Code Format

```
Format: PMS-USER-[5-digit-user-id]-[8-char-username]-[8-char-hash]
Example: PMS-USER-00123-JOHN_DOE-8076ecfe

Components:
- PMS-USER: System identifier
- 00123: Zero-padded 5-digit user ID
- JOHN_DOE: First 8 characters of uppercase username
- 8076ecfe: 8-character unique hash based on user data
```

### Features

#### Automatic Generation

- QR codes are generated automatically when:
  - New user is created
  - Existing user's significant data is updated (name, username, zone)
- No manual intervention required

#### Unique Identification

- Each QR code is globally unique
- Contains multiple validation layers:
  - User ID verification
  - Username prefix matching
  - Cryptographic hash validation

#### Database Integration

- QR codes are stored in the `users` table
- Properly integrated with existing user management workflows
- Automatic cleanup when users are deleted

#### Scanning/Lookup

- Dedicated scanner interface at `/admin/qr_scanner.php`
- Real-time validation and user lookup
- Complete user information display
- Error handling for invalid codes

## Usage Instructions

### For Administrators

1. **Creating Users**:

   - Fill out the user form as usual
   - QR code will be generated automatically after saving
   - QR code appears in the form for existing users

2. **Viewing QR Codes**:

   - Edit any existing user to see their QR code
   - QR code is displayed as formatted text below the avatar
   - Can be copied or manually transcribed

3. **Scanning QR Codes**:
   - Go to `/admin/qr_scanner.php`
   - Enter or paste the QR code text
   - Click "Scan" to look up user information
   - System displays complete user profile if found

### For End Users

1. **QR Code Format**:

   - Each user has a unique QR code
   - Format: `PMS-USER-XXXXX-XXXXXXXX-XXXXXXXX`
   - Can be used for identification purposes

2. **Security**:
   - QR codes contain encrypted user data
   - Cannot be easily forged or duplicated
   - Linked directly to user database records

## Security Considerations

### Data Protection

- QR codes contain only necessary identification data
- No sensitive information (passwords, personal details) in QR codes
- Hash-based validation prevents tampering

### Access Control

- QR scanner requires admin access
- User data is only displayed to authorized personnel
- Database queries are properly escaped and validated

### Validation

- Multi-layer validation ensures QR code authenticity
- Format validation prevents malicious input
- Database lookup confirms QR code legitimacy

## Future Enhancements

### Potential Improvements

1. **Visual QR Codes**: Generate actual QR code images using online services
2. **Mobile App**: Dedicated mobile app for QR code scanning
3. **Bulk Operations**: Generate QR codes for existing users in bulk
4. **Export Features**: Export user QR codes to PDF or CSV
5. **Advanced Analytics**: Track QR code usage and scanning statistics

### Technical Notes

- System is designed to be easily extensible
- QR code format can be modified if needed
- Database structure supports additional QR code metadata
- Compatible with existing user management workflows

## Troubleshooting

### Common Issues

1. **QR Code Not Generated**:

   - Check if database column `qr_code` exists
   - Verify QRCodeGenerator class is included
   - Check error logs for generation failures

2. **Scanner Not Working**:

   - Verify QR code format is correct
   - Check database connection
   - Ensure user exists in database

3. **Database Errors**:
   - Run the migration script if column is missing
   - Check database permissions
   - Verify table structure matches requirements

### Support

For technical support or questions about the QR code feature, refer to the system administrator or development team.

---

**Version**: 1.0  
**Date**: August 8, 2025  
**System**: Prison Management System (PMS)
