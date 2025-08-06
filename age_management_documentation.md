# Age Management System

## Overview

The system has been enhanced with automatic age validation and management features to ensure users are within the acceptable age range (15-30 years old).

## Features

### 1. Registration Age Validation

- **Automatic Rejection**: Users above 30 years old cannot be registered in the system
- **Real-time Validation**: Age is calculated automatically from the birthdate
- **Frontend Validation**: Form shows warnings and prevents submission for invalid ages
- **Backend Validation**: Server-side validation ensures data integrity

### 2. Automatic Deactivation

- **Age Monitoring**: System can automatically deactivate users who turn 31
- **Manual Trigger**: Administrators can manually run age checks
- **Logging**: All age check activities are logged for audit purposes

## How to Use

### Manual Age Check

1. Go to Admin Panel → System Info → Age Management
2. Click "Run Age Check Now" button
3. System will deactivate all users who are 31 years old or older

### Automatic Scheduling

You can schedule the age check to run automatically using Windows Task Scheduler:

1. **Open Windows Task Scheduler**
2. **Create New Task**:
   - Name: "PMS Daily Age Check"
   - Description: "Check and deactivate users over 31 years old"
3. **Set Trigger**:
   - Daily at a specific time (recommended: early morning)
4. **Set Action**:
   - Program: `C:\xampp\htdocs\pms\run_age_check.bat`
5. **Save the task**

### Manual Command Line Execution

You can also run the age check manually:

**Option 1 - Using Batch File:**

```bash
C:\xampp\htdocs\pms\run_age_check.bat
```

**Option 2 - Using PHP CLI:**

```bash
C:\xampp\php\php.exe C:\xampp\htdocs\pms\check_user_age.php
```

## Technical Details

### Error Codes

- **Code 6**: Age above 30 not allowed (new error code added)
- **Code 3**: Username already exists
- **Code 5**: User with same details already exists

### Database Changes

- Uses existing `status` field in users table (1 = active, 0 = inactive)
- No additional database modifications required

### Files Modified/Added

1. **Modified Files**:

   - `admin/user/manage_user.php` - Enhanced age validation
   - `classes/Users.php` - Added age validation and deactivation functions

2. **New Files**:
   - `check_user_age.php` - Main age check script
   - `run_age_check.bat` - Windows batch file for scheduling
   - `admin/system_info/age_management.php` - Admin interface for age management

### Logging

- Age check activities are logged to `logs/age_check.log`
- Log includes timestamp and number of users deactivated

## Best Practices

1. **Daily Checks**: Schedule age checks to run daily for timely deactivation
2. **Monitor Logs**: Regularly check the log files for any issues
3. **Backup**: Always backup your database before major changes
4. **Testing**: Test the age check function in a development environment first

## Troubleshooting

### Common Issues

1. **Permission Errors**: Ensure the web server has write permissions to the logs directory
2. **PHP CLI Not Found**: Verify PHP path in the batch file matches your XAMPP installation
3. **Database Connection**: Ensure database credentials are correct in config.php

### Support

For technical support or questions about the age management system, refer to the system administrator or development team.
