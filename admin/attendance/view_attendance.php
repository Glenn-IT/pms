<?php 
require_once('../../config.php');

if(!isset($_POST['event_id'])) {
    echo '<div class="alert alert-danger">Invalid event ID.</div>';
    exit;
}

$event_id = intval($_POST['event_id']);

// Get event details
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if($event_qry->num_rows == 0) {
    echo '<div class="alert alert-danger">Event not found.</div>';
    exit;
}
$event = $event_qry->fetch_assoc();

// Get attendance data
$attendance_qry = $conn->query("
    SELECT 
        ea.*,
        CONCAT(u.firstname, ' ', COALESCE(CONCAT(u.middlename, ' '), ''), u.lastname) as attendee_name,
        u.avatar as attendee_avatar,
        u.zone as attendee_zone,
        CONCAT(scanner.firstname, ' ', COALESCE(CONCAT(scanner.middlename, ' '), ''), scanner.lastname) as scanner_name
    FROM `event_attendance` ea 
    LEFT JOIN `users` u ON ea.user_id = u.id 
    LEFT JOIN `users` scanner ON ea.scanner_user_id = scanner.id 
    WHERE ea.event_id = '{$event_id}' 
    ORDER BY ea.scan_time DESC
");
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt"></i> Event Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <!--<?php if(!empty($event['image_path']) && file_exists(base_app.$event['image_path'])): ?>
                            <img src="<?= validate_image($event['image_path']) ?>" alt="Event Image" class="img-fluid rounded">
                        <?php else: ?>
                            <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                <i class="fas fa-calendar-alt fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>-->
                    </div>
                    <div class="col-md-9">
                        <h4><?= htmlspecialchars($event['title']) ?></h4>
                        <p class="text-muted"><?= htmlspecialchars($event['description']) ?></p>
                        <p><strong>Date of Event:</strong> <?= date("M d, Y h:i A", strtotime($event['date_created'])) ?></p>
                        <p><strong>Total Attendees:</strong> <span class="badge badge-success"><?= $attendance_qry->num_rows ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($attendance_qry->num_rows > 0): ?>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered" id="attendanceTable">
        <thead>
            <tr>
                <th>Attendee Name</th>
                <th>Zone/Purok</th>
                <th>Scan Time</th>
                <th>Status</th>
                <th>Scanned By</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $attendance_qry->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['attendee_name']) ?></td>
                <td><?= !empty($row['attendee_zone']) ? htmlspecialchars($row['attendee_zone']) : '<span class="text-muted">N/A</span>' ?></td>
                <td><?= date("M d, Y h:i:s A", strtotime($row['scan_time'])) ?></td>
                <td class="text-center">
                    <?php if($row['status'] == 'present'): ?>
                        <span class="badge badge-success">Present</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Absent</span>
                    <?php endif; ?>
                </td>
                <td><?= !empty($row['scanner_name']) ? htmlspecialchars($row['scanner_name']) : '<em class="text-muted">Auto-scan</em>' ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="alert alert-info text-center">
    <i class="fas fa-info-circle"></i> No attendance records found for this event.
</div>
<?php endif; ?>

<style>
.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

#attendanceTable {
    font-size: 0.9rem;
}

.badge {
    font-size: 0.8rem;
}

code {
    background-color: #f8f9fa;
    padding: 2px 4px;
    border-radius: 3px;
    font-size: 0.8rem;
}
</style>
