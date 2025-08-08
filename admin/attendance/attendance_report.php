<?php 
if(!isset($_GET['event_id'])) {
    echo '<script>location.href = "./?page=attendance";</script>';
    exit;
}

$event_id = intval($_GET['event_id']);

// Get event details
$event_qry = $conn->query("SELECT * FROM `event_list` WHERE id = '{$event_id}'");
if($event_qry->num_rows == 0) {
    echo '<script>alert("Event not found!"); location.href = "./?page=attendance";</script>';
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

// Count present attendees (those who scanned QR)
$present_count = 0;
$attendance_qry->data_seek(0); // Reset pointer
while($row = $attendance_qry->fetch_assoc()) {
    if($row['status'] == 'present') {
        $present_count++;
    }
}
$attendance_qry->data_seek(0); // Reset pointer again

// Get total active users (excluding admin/type 1) to calculate absent count
$total_active_users_qry = $conn->query("SELECT COUNT(*) as count FROM `users` WHERE `status` = 1 AND `type` != 1");
$total_active_users = $total_active_users_qry->fetch_assoc()['count'];

// Calculate absent count: total active users minus those who attended
$absent_count = $total_active_users - $present_count;
$total_attendees = $attendance_qry->num_rows; // Keep for compatibility with existing code
?>

<style>
    .report-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 4px solid;
    }
    
    .stat-card.total { border-left-color: #17a2b8; }
    .stat-card.present { border-left-color: #28a745; }
    .stat-card.absent { border-left-color: #dc3545; }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    @media print {
        .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .report-header { background: #333 !important; -webkit-print-color-adjust: exact; }
    }
</style>

<div class="container-fluid">
    <div class="row no-print mb-3">
        <div class="col-12">
            <a href="./?page=attendance" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Attendance Management
            </a>
            <button onclick="window.print()" class="btn btn-primary float-right">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
    </div>
    
    <div class="report-header text-center">
        <h1 class="mb-3">Attendance Report</h1>
        <h3><?= htmlspecialchars($event['title']) ?></h3>
        <p class="mb-0">Generated on: <?= date("M d, Y h:i A") ?></p>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card total">
                <div class="stat-number text-info"><?= $total_active_users ?></div>
                <div class="stat-label">Total Active Users</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card present">
                <div class="stat-number text-success"><?= $present_count ?></div>
                <div class="stat-label">Present</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card absent">
                <div class="stat-number text-danger"><?= $absent_count ?></div>
                <div class="stat-label">Absent</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card total">
                <div class="stat-number text-warning"><?= $total_attendees ?></div>
                <div class="stat-label">QR Scans</div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">
                <i class="fas fa-list"></i> Detailed Attendance List (QR Scanned Only)
            </h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Event:</strong> <?= htmlspecialchars($event['title']) ?>
                </div>
                <div class="col-md-6">
                    <strong>Date of Event:</strong> <?= date("M d, Y h:i A", strtotime($event['date_created'])) ?>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Note:</strong> "Absent" count represents active users who did not scan their QR code for this event. The detailed list below only shows users who actually scanned their QR codes.
            </div>
            
            <?php if($total_attendees > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="reportTable">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Attendee Name</th>
                            <th width="20%">Zone/Purok</th>
                            <th width="25%">Scan Time</th>
                            <th width="10%">Status</th>
                            <th width="10%">Scanned By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        while($row = $attendance_qry->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
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
                <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                <strong>No attendance records found for this event.</strong>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#reportTable').dataTable({
        "pageLength": 50,
        "order": [[ 3, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ]
    });
    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
});
</script>
