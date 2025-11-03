<?php
/**
 * Configuration Checker for PMS
 * This file helps diagnose common configuration issues
 * Access: http://localhost/pms/check_config.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html>
<head>
    <title>PMS Configuration Checker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .header {
            background: linear-gradient(135deg, #001f3f, #003d7a);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .check-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #ddd;
        }
        .check-item.success {
            border-left-color: #28a745;
        }
        .check-item.error {
            border-left-color: #dc3545;
        }
        .check-item.warning {
            border-left-color: #ffc107;
        }
        .status {
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }
        .status.ok {
            background: #28a745;
            color: white;
        }
        .status.fail {
            background: #dc3545;
            color: white;
        }
        .status.warn {
            background: #ffc107;
            color: black;
        }
        .info {
            background: #e7f3ff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .fix {
            background: #fff3cd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
        }
        h2 {
            color: #001f3f;
            border-bottom: 2px solid #001f3f;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔧 PMS Configuration Checker</h1>
        <p>Diagnose and fix configuration issues</p>
    </div>

<?php

$errors = [];
$warnings = [];
$success = [];

// Check 1: Initialize.php exists and is readable
echo "<h2>1. File Structure Checks</h2>";

if (file_exists('initialize.php')) {
    echo "<div class='check-item success'>";
    echo "<span class='status ok'>✓ OK</span> initialize.php exists<br>";
    require_once('initialize.php');
    echo "<div class='info'>";
    echo "<strong>Current Configuration:</strong><br>";
    echo "Base URL: <code>" . base_url . "</code><br>";
    echo "Base App: <code>" . base_app . "</code><br>";
    echo "</div>";
    
    // Check if base_url is correct
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    $expected_base = $current_url . dirname($_SERVER['PHP_SELF']) . '/';
    
    if (rtrim(base_url, '/') !== rtrim($expected_base, '/')) {
        echo "<div class='check-item warning'>";
        echo "<span class='status warn'>⚠ WARNING</span> Base URL might be incorrect<br>";
        echo "<div class='info'>";
        echo "Current base_url: <code>" . base_url . "</code><br>";
        echo "Expected base_url: <code>" . $expected_base . "</code><br>";
        echo "</div>";
        echo "<div class='fix'>";
        echo "Fix: Open initialize.php and change:<br>";
        echo "define('base_url','<strong>" . $expected_base . "</strong>');";
        echo "</div>";
        echo "</div>";
        $warnings[] = "Base URL mismatch";
    } else {
        echo "<span class='status ok'>✓ OK</span> Base URL is correctly configured";
    }
    echo "</div>";
} else {
    echo "<div class='check-item error'>";
    echo "<span class='status fail'>✗ ERROR</span> initialize.php not found!";
    echo "</div>";
    $errors[] = "initialize.php missing";
}

// Check 2: Database connection
echo "<h2>2. Database Connection</h2>";

try {
    require_once('classes/DBConnection.php');
    $db = new DBConnection();
    $conn = $db->conn;
    
    if ($conn) {
        echo "<div class='check-item success'>";
        echo "<span class='status ok'>✓ OK</span> Database connection successful<br>";
        echo "<div class='info'>";
        echo "Server: <code>" . DB_SERVER . "</code><br>";
        echo "Database: <code>" . DB_NAME . "</code><br>";
        echo "User: <code>" . DB_USERNAME . "</code><br>";
        echo "</div>";
        
        // Check if required tables exist
        $tables = ['users', 'event_list', 'announcement_list', 'forum_messages'];
        $missing_tables = [];
        
        foreach ($tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result->num_rows == 0) {
                $missing_tables[] = $table;
            }
        }
        
        if (count($missing_tables) > 0) {
            echo "<div class='check-item warning'>";
            echo "<span class='status warn'>⚠ WARNING</span> Missing tables: " . implode(', ', $missing_tables) . "<br>";
            echo "<div class='fix'>";
            echo "Fix: Import database/pms_db.sql in phpMyAdmin";
            echo "</div>";
            echo "</div>";
            $warnings[] = "Missing database tables";
        } else {
            echo "<span class='status ok'>✓ OK</span> All required tables exist";
        }
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<div class='check-item error'>";
    echo "<span class='status fail'>✗ ERROR</span> Database connection failed<br>";
    echo "<div class='info'>";
    echo "Error: " . $e->getMessage() . "<br>";
    echo "</div>";
    echo "<div class='fix'>";
    echo "Fix:<br>";
    echo "1. Make sure MySQL is running in XAMPP<br>";
    echo "2. Check database credentials in initialize.php<br>";
    echo "3. Verify database 'pms_db' exists in phpMyAdmin";
    echo "</div>";
    echo "</div>";
    $errors[] = "Database connection failed";
}

// Check 3: PHP Extensions
echo "<h2>3. PHP Extensions</h2>";

$required_extensions = [
    'mysqli' => 'Database operations',
    'gd' => 'Image processing',
    'mbstring' => 'String operations',
    'json' => 'JSON encoding/decoding',
    'session' => 'Session management'
];

$missing_extensions = [];

foreach ($required_extensions as $ext => $purpose) {
    if (extension_loaded($ext)) {
        echo "<div class='check-item success'>";
        echo "<span class='status ok'>✓ OK</span> $ext extension loaded ($purpose)";
        echo "</div>";
    } else {
        echo "<div class='check-item error'>";
        echo "<span class='status fail'>✗ ERROR</span> $ext extension NOT loaded ($purpose)";
        echo "</div>";
        $missing_extensions[] = $ext;
        $errors[] = "$ext extension missing";
    }
}

if (count($missing_extensions) > 0) {
    echo "<div class='fix'>";
    echo "Fix: Enable extensions in php.ini:<br>";
    echo "1. XAMPP Control Panel → Config → PHP (php.ini)<br>";
    echo "2. Find and uncomment (remove ;) these lines:<br>";
    foreach ($missing_extensions as $ext) {
        echo "   extension=$ext<br>";
    }
    echo "3. Save and restart Apache";
    echo "</div>";
}

// Check 4: File Permissions
echo "<h2>4. File Permissions</h2>";

$writable_dirs = ['uploads', 'uploads/sk_officials'];

foreach ($writable_dirs as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "<div class='check-item success'>";
            echo "<span class='status ok'>✓ OK</span> $dir/ is writable";
            echo "</div>";
        } else {
            echo "<div class='check-item warning'>";
            echo "<span class='status warn'>⚠ WARNING</span> $dir/ is NOT writable";
            echo "<div class='fix'>";
            echo "Fix: Right-click folder → Properties → Security → Edit → Give Full Control";
            echo "</div>";
            echo "</div>";
            $warnings[] = "$dir not writable";
        }
    } else {
        echo "<div class='check-item warning'>";
        echo "<span class='status warn'>⚠ WARNING</span> $dir/ does not exist";
        echo "<div class='fix'>";
        echo "Fix: Create the directory: $dir/";
        echo "</div>";
        echo "</div>";
        $warnings[] = "$dir missing";
    }
}

// Check 5: AJAX Endpoints
echo "<h2>5. AJAX Endpoints Test</h2>";

$ajax_endpoints = [
    'classes/Master.php' => 'Main AJAX handler',
    'classes/Login.php' => 'Login handler',
    'user/get_qr_code.php' => 'QR code generator'
];

foreach ($ajax_endpoints as $file => $desc) {
    if (file_exists($file)) {
        echo "<div class='check-item success'>";
        echo "<span class='status ok'>✓ OK</span> $file exists ($desc)";
        echo "</div>";
    } else {
        echo "<div class='check-item error'>";
        echo "<span class='status fail'>✗ ERROR</span> $file NOT found ($desc)";
        echo "</div>";
        $errors[] = "$file missing";
    }
}

// Check 6: PHP Configuration
echo "<h2>6. PHP Configuration</h2>";

$php_checks = [
    'upload_max_filesize' => ['value' => ini_get('upload_max_filesize'), 'recommended' => '10M'],
    'post_max_size' => ['value' => ini_get('post_max_size'), 'recommended' => '10M'],
    'max_execution_time' => ['value' => ini_get('max_execution_time'), 'recommended' => '300'],
    'memory_limit' => ['value' => ini_get('memory_limit'), 'recommended' => '256M']
];

foreach ($php_checks as $setting => $info) {
    echo "<div class='check-item success'>";
    echo "<span class='status ok'>ℹ INFO</span> $setting: <code>{$info['value']}</code> (recommended: {$info['recommended']})";
    echo "</div>";
}

// Final Summary
echo "<h2>📊 Summary</h2>";

$total_checks = count($errors) + count($warnings) + count($success);

echo "<div class='check-item'>";
if (count($errors) == 0 && count($warnings) == 0) {
    echo "<span class='status ok'>🎉 EXCELLENT</span> All checks passed! Your configuration is correct.<br>";
    echo "<div class='info'>";
    echo "✓ No critical errors found<br>";
    echo "✓ No warnings<br>";
    echo "✓ System ready to use<br>";
    echo "<br>";
    echo "<strong>Next steps:</strong><br>";
    echo "1. Visit: <a href='" . base_url . "'>" . base_url . "</a><br>";
    echo "2. Login to admin panel<br>";
    echo "3. Test forum functionality";
    echo "</div>";
} else {
    if (count($errors) > 0) {
        echo "<span class='status fail'>❌ CRITICAL ERRORS</span> Found " . count($errors) . " error(s):<br>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    
    if (count($warnings) > 0) {
        echo "<span class='status warn'>⚠ WARNINGS</span> Found " . count($warnings) . " warning(s):<br>";
        echo "<ul>";
        foreach ($warnings as $warning) {
            echo "<li>$warning</li>";
        }
        echo "</ul>";
    }
    
    echo "<div class='fix'>";
    echo "<strong>Recommended actions:</strong><br>";
    echo "1. Fix all critical errors first<br>";
    echo "2. Address warnings if functionality is affected<br>";
    echo "3. Re-run this checker after making changes<br>";
    echo "4. Check CONFIG_SETUP_GUIDE.md for detailed instructions";
    echo "</div>";
}
echo "</div>";

// Test AJAX Button
echo "<h2>7. Live AJAX Test</h2>";
echo "<div class='check-item'>";
echo "<button onclick='testAjax()' style='padding: 10px 20px; background: #001f3f; color: white; border: none; border-radius: 5px; cursor: pointer;'>Test AJAX Connection</button>";
echo "<div id='ajax-result' style='margin-top: 10px;'></div>";
echo "</div>";

?>

<script>
function testAjax() {
    const resultDiv = document.getElementById('ajax-result');
    resultDiv.innerHTML = '<p>Testing AJAX connection...</p>';
    
    fetch('<?= base_url ?>classes/Master.php?f=get_all_announcements')
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                resultDiv.innerHTML = '<div style="background: #d4edda; padding: 10px; border-radius: 5px; color: #155724;">' +
                    '<strong>✓ AJAX Test Successful!</strong><br>' +
                    'Successfully retrieved ' + (data.data ? data.data.length : 0) + ' announcements from database.<br>' +
                    'Your AJAX endpoints are working correctly!' +
                    '</div>';
            } else {
                resultDiv.innerHTML = '<div style="background: #fff3cd; padding: 10px; border-radius: 5px;">' +
                    '<strong>⚠ AJAX Response Received but with issues</strong><br>' +
                    'Status: ' + data.status + '<br>' +
                    'Message: ' + (data.msg || 'Unknown') +
                    '</div>';
            }
        })
        .catch(error => {
            resultDiv.innerHTML = '<div style="background: #f8d7da; padding: 10px; border-radius: 5px; color: #721c24;">' +
                '<strong>✗ AJAX Test Failed!</strong><br>' +
                'Error: ' + error.message + '<br><br>' +
                '<strong>Common causes:</strong><br>' +
                '1. Base URL is incorrect in initialize.php<br>' +
                '2. Apache server not running<br>' +
                '3. Database connection failed<br>' +
                '4. File permissions issue<br><br>' +
                'Check the configuration above for issues.' +
                '</div>';
        });
}
</script>

<div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 5px;">
    <h3>💡 Quick Tips</h3>
    <ul>
        <li>If you see AJAX errors, most likely the <strong>base_url in initialize.php is wrong</strong></li>
        <li>Always restart Apache after changing configuration files</li>
        <li>Clear browser cache after making changes</li>
        <li>Check browser console (F12) for detailed error messages</li>
        <li>Read CONFIG_SETUP_GUIDE.md for comprehensive troubleshooting</li>
    </ul>
</div>

<div style="text-align: center; margin: 20px; padding: 10px; background: white; border-radius: 5px;">
    <button onclick="location.reload()" style="padding: 10px 20px; background: #001f3f; color: white; border: none; border-radius: 5px; cursor: pointer;">
        🔄 Re-run Checks
    </button>
</div>

</body>
</html>
