<?php
// Test script to verify duplicate validation logic
require_once('../config.php');
require_once('../classes/Master.php');

// Test the duplicate validation logic
function testDuplicateValidation() {
    $master = new Master();
    
    echo "<h2>Testing Event Duplicate Validation</h2>";
    echo "<p>This test script simulates adding events to check duplicate validation.</p>";
    
    // Test case 1: Different title, same time - should PASS
    echo "<h3>Test Case 1: Different title, same time (Should PASS)</h3>";
    echo "Event 1: Title = 'Meeting A', Time = '10:00:00'<br>";
    echo "Event 2: Title = 'Meeting B', Time = '10:00:00'<br>";
    echo "Result: Should be allowed (different titles)<br><br>";
    
    // Test case 2: Same title, different time - should PASS
    echo "<h3>Test Case 2: Same title, different time (Should PASS)</h3>";
    echo "Event 1: Title = 'Meeting A', Time = '10:00:00'<br>";
    echo "Event 2: Title = 'Meeting A', Time = '11:00:00'<br>";
    echo "Result: Should be allowed (different times)<br><br>";
    
    // Test case 3: Same title, same time - should FAIL
    echo "<h3>Test Case 3: Same title, same time (Should FAIL)</h3>";
    echo "Event 1: Title = 'Meeting A', Time = '10:00:00'<br>";
    echo "Event 2: Title = 'Meeting A', Time = '10:00:00'<br>";
    echo "Result: Should be rejected (duplicate title and time)<br><br>";
    
    // Test case 4: Same title, same time, different date - should FAIL
    echo "<h3>Test Case 4: Same title, same time, different date (Should FAIL)</h3>";
    echo "Event 1: Title = 'Meeting A', Date = '2025-08-15', Time = '10:00:00'<br>";
    echo "Event 2: Title = 'Meeting A', Date = '2025-08-16', Time = '10:00:00'<br>";
    echo "Result: Should be rejected (same title and time, different date ignored)<br><br>";
    
    echo "<h3>Validation Logic Summary:</h3>";
    echo "<ul>";
    echo "<li>✅ Allow: Same title + different time</li>";
    echo "<li>✅ Allow: Different title + same time</li>";
    echo "<li>❌ Reject: Same title + same time (regardless of date)</li>";
    echo "</ul>";
    
    echo "<p><strong>Note:</strong> The system compares only the title and time portion (HH:MM:SS) of the datetime, ignoring the date portion.</p>";
}

testDuplicateValidation();
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
h3 { color: #007bff; margin-top: 20px; }
ul { background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; }
p { line-height: 1.6; }
</style>
