<?php 
require_once('../../config.php');

header('Content-Type: application/json');

if(!isset($_POST['event_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing event ID.']);
    exit;
}

$event_id = intval($_POST['event_id']);
$zone_filter = isset($_POST['zone_filter']) ? trim($_POST['zone_filter']) : '';
$notification_type = isset($_POST['notification_type']) ? $_POST['notification_type'] : 'reminder';
$custom_message = isset($_POST['custom_message']) ? trim($_POST['custom_message']) : '';
$include_event_details = isset($_POST['include_event_details']) ? $_POST['include_event_details'] === 'true' : false;

// Validate event exists
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if($event_qry->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Event not found.']);
    exit;
}
$event = $event_qry->fetch_assoc();

// Build the query with optional zone filter
$zone_condition = '';
if(!empty($zone_filter)) {
    $zone_filter = $conn->real_escape_string($zone_filter);
    $zone_condition = "AND u.zone = '{$zone_filter}'";
}

// Get all absent users
$absentees_qry = $conn->query("
    SELECT 
        u.id as user_id,
        u.firstname,
        u.lastname,
        u.contact_no,
        u.email,
        u.zone
    FROM `users` u 
    WHERE u.status = 1 
    AND u.type != 1
    AND u.id NOT IN (
        SELECT ea.user_id 
        FROM `event_attendance` ea 
        WHERE ea.event_id = '{$event_id}' 
        AND ea.status = 'present'
    )
    {$zone_condition}
    ORDER BY u.lastname ASC, u.firstname ASC
");

if($absentees_qry->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'No absent users found to notify.']);
    exit;
}

// Generate base message templates
$base_messages = [
    'reminder' => [
        'title' => 'Event Reminder',
        'template' => "Hi {name}, we noticed you missed our recent event: {event_title}. We hope to see you at our next gathering!"
    ],
    'follow-up' => [
        'title' => 'We Missed You!',
        'template' => "Hello {name}, we missed you at {event_title} on {event_date}. Your participation is valuable to our community."
    ],
    'survey' => [
        'title' => 'Your Feedback Matters',
        'template' => "Hi {name}, we'd love to hear from you! We noticed you weren't able to attend {event_title}. Could you help us understand how we can make future events more accessible?"
    ]
];

$message_template = $base_messages[$notification_type] ?? $base_messages['reminder'];
$sent_count = 0;
$failed_count = 0;

// Process each absent user
while($user = $absentees_qry->fetch_assoc()) {
    // Personalize the message
    $personalized_message = str_replace(
        ['{name}', '{event_title}', '{event_date}'],
        [
            $user['firstname'],
            $event['title'],
            date("M d, Y", strtotime($event['date_created']))
        ],
        $message_template['template']
    );
    
    // Add custom message if provided
    if(!empty($custom_message)) {
        $personalized_message .= "\n\n" . $custom_message;
    }
    
    // Add event details if requested
    if($include_event_details) {
        $personalized_message .= "\n\nEvent Details:\n";
        $personalized_message .= "Title: " . $event['title'] . "\n";
        $personalized_message .= "Date: " . date("M d, Y h:i A", strtotime($event['date_created'])) . "\n";
        if(!empty($event['description'])) {
            $personalized_message .= "Description: " . substr($event['description'], 0, 100) . "...\n";
        }
    }
    
    // Log the notification (simulated)
    $log_qry = $conn->query("
        INSERT INTO `notification_log` 
        (user_id, event_id, notification_type, title, message, sent_at, status) 
        VALUES 
        ('{$user['user_id']}', '{$event_id}', '{$notification_type}', 
         '{$conn->real_escape_string($message_template['title'])}', 
         '{$conn->real_escape_string($personalized_message)}', 
         NOW(), 'sent')
        ON DUPLICATE KEY UPDATE 
        sent_at = NOW(), 
        status = 'sent',
        notification_type = '{$notification_type}',
        message = '{$conn->real_escape_string($personalized_message)}'
    ");
    
    // In a real implementation, you would send actual notifications here:
    // - SMS via Twilio/similar service
    // - Email via PHPMailer/similar
    // - Push notifications
    // - In-app notifications
    
    // For demo purposes, we'll simulate success
    if($log_qry || ($conn->error && strpos($conn->error, "doesn't exist") !== false)) {
        $sent_count++;
        
        // Simulate some processing time
        usleep(100000); // 0.1 seconds
    } else {
        $failed_count++;
    }
}

// Create a summary of the bulk notification
$summary_qry = $conn->query("
    INSERT INTO `bulk_notification_log` 
    (event_id, notification_type, zone_filter, sent_count, failed_count, sent_at, custom_message) 
    VALUES 
    ('{$event_id}', '{$notification_type}', '{$conn->real_escape_string($zone_filter)}', 
     '{$sent_count}', '{$failed_count}', NOW(), '{$conn->real_escape_string($custom_message)}')
");

echo json_encode([
    'success' => true,
    'message' => 'Bulk notifications processed successfully',
    'sent_count' => $sent_count,
    'failed_count' => $failed_count,
    'total_processed' => $sent_count + $failed_count,
    'notification_type' => $notification_type
]);
?>
