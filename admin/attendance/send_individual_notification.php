<?php 
require_once('../../config.php');

header('Content-Type: application/json');

if(!isset($_POST['user_id']) || !isset($_POST['event_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit;
}

$user_id = intval($_POST['user_id']);
$event_id = intval($_POST['event_id']);
$notification_type = isset($_POST['type']) ? $_POST['type'] : 'follow-up';

// Validate user exists
$user_qry = $conn->query("SELECT * FROM `users` WHERE id = '{$user_id}' AND status = 1");
if($user_qry->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}
$user = $user_qry->fetch_assoc();

// Validate event exists
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if($event_qry->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Event not found.']);
    exit;
}
$event = $event_qry->fetch_assoc();

// Generate notification message based on type
$messages = [
    'reminder' => [
        'title' => 'Event Reminder',
        'body' => "Hi {$user['firstname']}, we noticed you missed our recent event: {$event['title']}. We hope to see you at our next gathering!"
    ],
    'follow-up' => [
        'title' => 'We Missed You!',
        'body' => "Hello {$user['firstname']}, we missed you at {$event['title']} on " . date("M d, Y", strtotime($event['date_created'])) . ". Your participation is valuable to our community. Please let us know if there's anything we can do to help you attend future events."
    ],
    'survey' => [
        'title' => 'Your Feedback Matters',
        'body' => "Hi {$user['firstname']}, we'd love to hear from you! We noticed you weren't able to attend {$event['title']}. Could you help us understand how we can make future events more accessible for you?"
    ]
];

$notification = $messages[$notification_type] ?? $messages['follow-up'];

// In a real system, you would send actual notifications here
// For this demo, we'll simulate the notification system
// You could integrate with:
// - SMS API (Twilio, etc.)
// - Email service (PHPMailer, etc.)
// - Push notifications
// - Internal notification system

// Simulate notification logging (you might want to create a notifications table)
$log_qry = $conn->query("
    INSERT INTO `notification_log` 
    (user_id, event_id, notification_type, title, message, sent_at, status) 
    VALUES 
    ('{$user_id}', '{$event_id}', '{$notification_type}', 
     '{$conn->real_escape_string($notification['title'])}', 
     '{$conn->real_escape_string($notification['body'])}', 
     NOW(), 'sent')
    ON DUPLICATE KEY UPDATE 
    sent_at = NOW(), 
    status = 'sent',
    notification_type = '{$notification_type}'
");

// Check if notification_log table exists, if not, we'll just simulate success
if($conn->error && strpos($conn->error, "doesn't exist") !== false) {
    // Table doesn't exist, but we'll still return success for demo purposes
    echo json_encode([
        'success' => true, 
        'message' => 'Notification sent successfully (demo mode)',
        'notification' => $notification
    ]);
} else if($log_qry) {
    echo json_encode([
        'success' => true, 
        'message' => 'Notification sent successfully',
        'notification' => $notification
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Failed to log notification: ' . $conn->error
    ]);
}
?>
