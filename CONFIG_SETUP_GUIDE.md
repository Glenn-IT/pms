# PMS Configuration Setup Guide for Different Laptops

## Common AJAX Error Issues and Solutions

When moving this project to a different laptop, you may encounter "AJAX Error" messages. Here's how to fix them:

---

## 🔧 Issue 1: Wrong Base URL (MOST COMMON!)

### Symptoms:

- AJAX errors in forum
- Functions not working
- 404 errors in browser console
- "Failed to load" messages

### Solution:

**Step 1:** Open `initialize.php` in the project root

**Step 2:** Update the base_url to match your laptop's configuration:

```php
// Original (may not work on your laptop):
if(!defined('base_url')) define('base_url','http://localhost/pms/');

// Change to one of these based on your setup:

// Option 1: If using localhost
if(!defined('base_url')) define('base_url','http://localhost/pms/');

// Option 2: If using IP address
if(!defined('base_url')) define('base_url','http://192.168.1.100/pms/');

// Option 3: If using different port
if(!defined('base_url')) define('base_url','http://localhost:8080/pms/');

// Option 4: If different folder name
if(!defined('base_url')) define('base_url','http://localhost/my_pms_project/');
```

**Step 3:** Save the file and refresh your browser

---

## 🔧 Issue 2: Database Connection Issues

### Symptoms:

- AJAX returns errors about database
- Cannot login
- Data not loading

### Solution:

**Step 1:** Open `initialize.php`

**Step 2:** Update database credentials:

```php
if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"");  // Your MySQL password
if(!defined('DB_NAME')) define('DB_NAME',"pms_db");
```

**Step 3:** Make sure the database exists:

1. Open phpMyAdmin
2. Import `database/pms_db.sql`
3. Verify the database name matches `DB_NAME` above

---

## 🔧 Issue 3: XAMPP/Apache Configuration

### Symptoms:

- 403 Forbidden errors
- Cannot access the project
- Files not found

### Solution:

**Step 1:** Verify XAMPP installation:

- Make sure Apache and MySQL are running in XAMPP Control Panel
- Check if ports 80 and 3306 are not blocked

**Step 2:** Verify file location:

- Project must be in `C:\xampp\htdocs\pms\`
- Or update base_url if in different location

**Step 3:** Check Apache configuration:

- Open XAMPP Control Panel
- Click "Config" next to Apache
- Select "httpd.conf"
- Find the line `DocumentRoot` and verify it points to `htdocs`

---

## 🔧 Issue 4: PHP Extensions Not Enabled

### Symptoms:

- Image uploads not working
- QR codes not generating
- Specific features failing

### Solution:

**Step 1:** Open `php.ini`:

- XAMPP Control Panel → Config → PHP (php.ini)

**Step 2:** Enable these extensions (remove the `;` at the start):

```ini
extension=gd
extension=mysqli
extension=mbstring
extension=openssl
extension=fileinfo
```

**Step 3:** Save and restart Apache

---

## 🔧 Issue 5: Browser Cache Issues

### Symptoms:

- Old code still running
- Changes not reflecting
- Inconsistent behavior

### Solution:

**Clear browser cache:**

- Chrome/Edge: `Ctrl + Shift + Delete`
- Firefox: `Ctrl + Shift + Delete`
- Or use Incognito/Private mode for testing

---

## 🔧 Issue 6: File Permissions (Rare on Windows)

### Symptoms:

- Cannot upload files
- Cannot write to database
- Permission denied errors

### Solution:

**Step 1:** Right-click on the `pms` folder

**Step 2:** Properties → Security → Edit

**Step 3:** Give "Full Control" to your user account

---

## 📝 Quick Checklist for New Laptop Setup

Use this checklist when setting up on a new laptop:

- [ ] XAMPP installed and running (Apache + MySQL)
- [ ] Project folder copied to `C:\xampp\htdocs\pms\`
- [ ] Database imported from `database/pms_db.sql`
- [ ] `initialize.php` - base_url updated
- [ ] `initialize.php` - database credentials updated
- [ ] PHP extensions enabled (gd, mysqli, mbstring)
- [ ] Apache restarted after configuration changes
- [ ] Browser cache cleared
- [ ] Test by visiting: `http://localhost/pms/`

---

## 🐛 Debugging AJAX Errors

If you still have AJAX errors, follow these debugging steps:

### Step 1: Check Browser Console

1. Press `F12` in your browser
2. Click "Console" tab
3. Look for red error messages
4. Note the URL that's failing

### Step 2: Check Network Tab

1. Press `F12` in your browser
2. Click "Network" tab
3. Click on the red/failed request
4. Look at the "Response" tab
5. This will show you the actual error

### Step 3: Check PHP Error Logs

1. Open `C:\xampp\apache\logs\error.log`
2. Look for recent errors
3. Check for PHP warnings or fatal errors

### Step 4: Test Direct Access

- Try accessing the AJAX endpoint directly in browser
- Example: `http://localhost/pms/classes/Master.php?f=get_forum_messages`
- If you see an error or blank page, there's a PHP issue

---

## 💡 Common AJAX Error Messages and Fixes

### Error: "AJAX Error" in Forum

**Cause:** Base URL mismatch or PHP errors
**Fix:** Check `initialize.php` base_url and check browser console

### Error: "Failed to load"

**Cause:** File path incorrect or server not responding
**Fix:** Verify Apache is running and base_url is correct

### Error: "404 Not Found"

**Cause:** URL path is wrong
**Fix:** Update base_url in `initialize.php`

### Error: "500 Internal Server Error"

**Cause:** PHP syntax error or database connection issue
**Fix:** Check Apache error logs, verify database credentials

### Error: "Database connection failed"

**Cause:** MySQL not running or wrong credentials
**Fix:** Start MySQL in XAMPP, check DB_USERNAME and DB_PASSWORD

---

## 🎯 Forum-Specific Issues

The forum uses these AJAX endpoints:

- `classes/Master.php?f=get_forum_messages`
- `classes/Master.php?f=send_forum_message`
- `classes/Master.php?f=delete_forum_message`

If forum isn't working:

1. Verify you're logged in
2. Check that `forum_messages` table exists in database
3. Check browser console for errors
4. Test the endpoint directly in browser

---

## 🔗 Testing Your Configuration

After making changes, test these URLs in your browser:

1. **Main Page:**
   `http://localhost/pms/`

2. **Admin Login:**
   `http://localhost/pms/admin/`

3. **Test AJAX (should show JSON):**
   `http://localhost/pms/classes/Master.php?f=get_all_announcements`

4. **Forum (must be logged in):**
   `http://localhost/pms/user/forum.php`

If any of these don't work, there's a configuration issue.

---

## 📞 Need More Help?

If issues persist after following this guide:

1. **Check error logs:**

   - `C:\xampp\apache\logs\error.log`
   - `C:\xampp\mysql\data\mysql_error.log`

2. **Enable PHP error display:**
   Add to top of `config.php`:

   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

3. **Test with simple PHP file:**
   Create `test.php` in pms folder:
   ```php
   <?php
   echo "PHP is working!";
   phpinfo();
   ?>
   ```
   Access: `http://localhost/pms/test.php`

---

## 📌 Remember

**MOST AJAX ERRORS are caused by incorrect base_url in initialize.php!**

Always check this file first when moving to a new laptop.
