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

// Get list of absent users (active users who didn't scan QR for this event)
$absent_users_qry = $conn->query("
    SELECT 
        u.id,
        CONCAT(u.firstname, ' ', COALESCE(CONCAT(u.middlename, ' '), ''), u.lastname) as full_name,
        u.zone,
        u.username
    FROM `users` u 
    WHERE u.status = 1 
    AND u.type != 1 
    AND u.id NOT IN (
        SELECT ea.user_id 
        FROM `event_attendance` ea 
        WHERE ea.event_id = '{$event_id}' 
        AND ea.status = 'present'
    )
    ORDER BY u.firstname, u.lastname
");
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
        .print-only { display: block !important; }
        .card { border: none !important; box-shadow: none !important; page-break-inside: avoid; }
        .card-header { display: none !important; }
        .report-header { background: none !important; color: #000 !important; padding: 0 !important; margin-bottom: 1.5rem !important; border-radius: 0 !important; }
        .report-header h1 { font-size: 1.3rem; margin-bottom: 0.5rem; font-weight: bold; }
        .report-header h3 { font-size: 1.4rem; margin-bottom: 0.5rem; font-weight: bold; }
        .report-header p { display: none !important; }
        .stat-card, .row.mb-4, .alert { display: none !important; }
        .print-section { display: none !important; }
        .print-section.print-active { display: block !important; }
        .hide-on-print { display: none !important; }
        .simple-print-list thead th:not(:nth-child(1)):not(:nth-child(2)) { display: none !important; }
        .simple-print-list tbody td:not(:nth-child(1)):not(:nth-child(2)) { display: none !important; }
        .table { font-size: 0.95rem; border-collapse: collapse !important; }
        .table thead { background: none !important; }
        .table thead th { background: none !important; border: none !important; border-bottom: 2px solid #000 !important; font-weight: bold; padding: 0.5rem 0.3rem !important; text-align: left; }
        .table tbody tr { border: none !important; }
        .table tbody td { border: none !important; border-bottom: 1px solid #ddd !important; padding: 0.4rem 0.3rem !important; }
        .table tbody td:first-child { width: 40px; text-align: center; }
        .table tbody td:nth-child(2) { text-align: left; }
        .badge { display: none !important; }
        .container-fluid { padding: 0 !important; }
        .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate { display: none !important; }
    }
</style>

<div class="container-fluid">
    <div class="row no-print mb-3">
        <div class="col-12">
            <a href="./?page=attendance" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Attendance Management
            </a>
            <div class="float-right">
                <button onclick="printAll()" class="btn btn-primary mr-2">
                    <i class="fas fa-print"></i> Print Complete Report
                </button>
                <button onclick="printPresent()" class="btn btn-success mr-2">
                    <i class="fas fa-print"></i> Print Present Only
                </button>
                <button onclick="printAbsent()" class="btn btn-danger">
                    <i class="fas fa-print"></i> Print Absent Only
                </button>
            </div>
        </div>
    </div>
    
    <div class="report-header text-center">
        <h1 class="mb-3">YOUTH INFORMATION SYSTEM OF MAGUILLING, PIAT, CAGAYAN</h1>
        <h3><?= htmlspecialchars($event['title']) ?></h3>
        <p class="mb-0">Generated on: <?= date("M d, Y h:i A") ?></p>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card total">
                <div class="stat-number text-info"><?= $total_active_users ?></div>
                <div class="stat-label">Total Active SK</div>
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
        <div class="card-body print-section" id="presentSection">
            <div class="row mb-3 no-print">
                <div class="col-md-6">
                    <strong>Event:</strong> <?= htmlspecialchars($event['title']) ?>
                </div>
                <div class="col-md-6">
                    <strong>Date of Event:</strong> <?= date("M d, Y h:i A", strtotime($event['date_created'])) ?>
                </div>
            </div>
            <h4 class="print-only" style="display: none; margin-bottom: 1rem; font-size: 1.1rem; font-weight: bold;">Present List</h4>
            
            <div class="alert alert-info no-print">
                <i class="fas fa-info-circle"></i>
                <strong>Report Overview:</strong> 
                <ul class="mb-0 mt-2">
                    <li><strong>Present:</strong> SK who scanned their QR code for this event</li>
                    <li><strong>Absent:</strong> Active SK who did not scan their QR code for this event</li>
                    <li>The table below shows only SK who scanned their QR codes</li>
                    <li>Scroll down to see the complete list of absent SK's</li>
                </ul>
            </div>
            
            <?php if($total_attendees > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered simple-print-list" id="reportTable">
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
                            <td class="hide-on-print"><?= !empty($row['attendee_zone']) ? htmlspecialchars($row['attendee_zone']) : '<span class="text-muted">N/A</span>' ?></td>
                            <td class="hide-on-print"><?= date("M d, Y h:i:s A", strtotime($row['scan_time'])) ?></td>
                            <td class="text-center hide-on-print">
                                <?php if($row['status'] == 'present'): ?>
                                    <span class="badge badge-success">Present</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Absent</span>
                                <?php endif; ?>
                            </td>
                            <td class="hide-on-print"><?= !empty($row['scanner_name']) ? htmlspecialchars($row['scanner_name']) : '<em class="text-muted">Auto-scan</em>' ?></td>
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

<!-- Absent Users Section -->
<div class="card mt-4">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <i class="fas fa-user-times text-danger"></i> Absent SK List (Did Not Scan QR)
        </h4>
    </div>
    <div class="card-body print-section" id="absentSection">
        <h4 class="print-only" style="display: none; margin-bottom: 1rem; margin-top: 2rem; font-size: 1.1rem; font-weight: bold;">Absent List</h4>
        <div class="alert alert-warning no-print">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Note:</strong> These are active SK who did not scan their QR code for this event.
        </div>
        
        <?php if($absent_count > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered simple-print-list" id="absentTable">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="40%">Name</th>
                        <th width="25%">Zone/Purok</th>
                        <th width="30%">Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $j = 1;
                    while($absent_row = $absent_users_qry->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?= $j++ ?></td>
                        <td><?= htmlspecialchars($absent_row['full_name']) ?></td>
                        <td class="hide-on-print"><?= !empty($absent_row['zone']) ? htmlspecialchars($absent_row['zone']) : '<span class="text-muted">N/A</span>' ?></td>
                        <td class="hide-on-print"><?= htmlspecialchars($absent_row['username']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle fa-2x mb-3"></i><br>
            <strong>Perfect Attendance!</strong> All active SK scanned their QR codes for this event.
        </div>
        <?php endif; ?>
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
    
    $('#absentTable').dataTable({
        "pageLength": 50,
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ]
    });
    
    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
});

// Print functions
function printAll() {
    // Show all sections for printing
    $('.print-section').addClass('print-active');
    window.print();
    
    // Remove the class after printing
    setTimeout(function() {
        $('.print-section').removeClass('print-active');
    }, 1000);
}

function printPresent() {
    // Show only present section for printing
    $('.print-section').removeClass('print-active');
    $('#presentSection').addClass('print-active');
    
    // Create a temporary title for the print
    var originalTitle = document.title;
    document.title = 'Present Attendees - <?= htmlspecialchars($event['title']) ?>';
    
    window.print();
    
    // Restore original title
    document.title = originalTitle;
    
    // Remove the class after printing
    setTimeout(function() {
        $('#presentSection').removeClass('print-active');
    }, 1000);
}

function printAbsent() {
    // Show only absent section for printing
    $('.print-section').removeClass('print-active');
    $('#absentSection').addClass('print-active');
    
    // Create a temporary title for the print
    var originalTitle = document.title;
    document.title = 'Absent Users - <?= htmlspecialchars($event['title']) ?>';
    
    window.print();
    
    // Restore original title
    document.title = originalTitle;
    
    // Remove the class after printing
    setTimeout(function() {
        $('#absentSection').removeClass('print-active');
    }, 1000);
}
</script>
