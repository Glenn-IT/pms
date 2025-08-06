@echo off
REM Batch file to run the age check script
REM This can be scheduled to run daily using Windows Task Scheduler

echo Running daily age check...

REM Change to the script directory
cd /d "C:\xampp\htdocs\pms"

REM Run the PHP script using XAMPP's PHP
"C:\xampp\php\php.exe" check_user_age.php

echo Age check completed.
pause
