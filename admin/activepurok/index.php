<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<?php
// Get purok attendance statistics
$purok_stats_qry = $conn->query("
    SELECT 
        u.zone as purok,
        COUNT(DISTINCT ea.user_id) as unique_attendees,
        COUNT(ea.id) as total_attendance,
        COUNT(DISTINCT ea.event_id) as events_attended,
        ROUND((COUNT(ea.id) / COUNT(DISTINCT ea.event_id)), 2) as avg_attendance_per_event
    FROM event_attendance ea
    JOIN users u ON ea.user_id = u.id
    WHERE u.zone IS NOT NULL AND u.zone != '' AND u.status = 1 AND u.type != 1
    GROUP BY u.zone
    ORDER BY total_attendance DESC
");

$purok_stats = [];
while($row = $purok_stats_qry->fetch_assoc()) {
    $purok_stats[] = $row;
}

// Get total events count for participation percentage
$total_events_qry = $conn->query("SELECT COUNT(*) as total FROM event_list");
$total_events = $total_events_qry->fetch_assoc()['total'];

// Get recent activity - last 5 events participation by purok
$recent_activity_qry = $conn->query("
    SELECT 
        el.title as event_title,
        el.date_created as event_date,
        u.zone as purok,
        COUNT(ea.id) as attendance_count
    FROM event_list el
    LEFT JOIN event_attendance ea ON el.id = ea.event_id
    LEFT JOIN users u ON ea.user_id = u.id AND u.zone IS NOT NULL
    WHERE u.status = 1 AND u.type != 1
    GROUP BY el.id, u.zone
    ORDER BY el.date_created DESC
    LIMIT 50
");

$recent_activity = [];
while($row = $recent_activity_qry->fetch_assoc()) {
    if($row['purok']) {
        $recent_activity[] = $row;
    }
}

// Get overall statistics
$overall_stats_qry = $conn->query("
    SELECT 
        COUNT(DISTINCT u.zone) as total_active_puroks,
        COUNT(DISTINCT ea.user_id) as total_active_members,
        COUNT(DISTINCT ea.event_id) as events_with_attendance,
        COUNT(ea.id) as total_attendance_records
    FROM event_attendance ea
    JOIN users u ON ea.user_id = u.id
    WHERE u.zone IS NOT NULL AND u.status = 1 AND u.type != 1
");
$overall_stats = $overall_stats_qry->fetch_assoc();
?>

<style>
    .user-avatar{
        width:3rem;
        height:3rem;
        object-fit:scale-down;
        object-position:center center;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .purok-card {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 4px solid;
    }
    
    .purok-card.rank-1 { border-left-color: #ffd700; }
    .purok-card.rank-2 { border-left-color: #c0c0c0; }
    .purok-card.rank-3 { border-left-color: #cd7f32; }
    .purok-card.rank-other { border-left-color: #007bff; }
    
    .rank-badge {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
        color: white;
        margin-right: 1rem;
    }
    
    .rank-1 .rank-badge { background: #ffd700; color: #333; }
    .rank-2 .rank-badge { background: #c0c0c0; color: #333; }
    .rank-3 .rank-badge { background: #cd7f32; }
    .rank-other .rank-badge { background: #007bff; }
    
    .table-responsive {
        margin-top: 1rem;
    }
    
    .activity-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-left: 3px solid #007bff;
    }
</style>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Active Purok - Event Attendance Analysis</h3>
	</div>
	<div class="card-body">
        <!-- Overview Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stats-number"><?php echo $overall_stats['total_active_puroks'] ?: 0 ?></div>
                    <div class="stats-label">Active Puroks</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stats-number"><?php echo $overall_stats['total_active_members'] ?: 0 ?></div>
                    <div class="stats-label">Active Members</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stats-number"><?php echo $overall_stats['events_with_attendance'] ?: 0 ?></div>
                    <div class="stats-label">Events with Attendance</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="stats-number"><?php echo $overall_stats['total_attendance_records'] ?: 0 ?></div>
                    <div class="stats-label">Total Attendance Records</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Purok Attendance Chart -->
            <div class="col-lg-8 col-md-12">
                <div class="chart-card">
                    <div class="chart-title">Purok Attendance Comparison</div>
                    <div class="chart-container">
                        <canvas id="purokAttendanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Performing Puroks -->
            <div class="col-lg-4 col-md-12">
                <div class="chart-card">
                    <div class="chart-title">Top Performing Puroks</div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <?php if(!empty($purok_stats)): ?>
                            <?php foreach($purok_stats as $index => $stats): ?>
                                <?php 
                                $rank_class = '';
                                if($index == 0) $rank_class = 'rank-1';
                                elseif($index == 1) $rank_class = 'rank-2';
                                elseif($index == 2) $rank_class = 'rank-3';
                                else $rank_class = 'rank-other';
                                
                                $participation_rate = $total_events > 0 ? round(($stats['events_attended'] / $total_events) * 100, 1) : 0;
                                ?>
                                <div class="purok-card <?php echo $rank_class ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="rank-badge"><?php echo $index + 1 ?></span>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Purok <?php echo htmlspecialchars($stats['purok']) ?></h6>
                                            <small class="text-muted">
                                                <?php echo $stats['total_attendance'] ?> attendances • 
                                                <?php echo $stats['unique_attendees'] ?> members • 
                                                <?php echo $participation_rate ?>% participation
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p>No attendance data available yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-title">Detailed Purok Statistics</div>
                    <?php if(!empty($purok_stats)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Rank</th>
                                        <th>Purok</th>
                                        <th>Total Attendance</th>
                                        <th>Unique Members</th>
                                        <th>Events Attended</th>
                                        <th>Avg. Attendance per Event</th>
                                        <th>Participation Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($purok_stats as $index => $stats): ?>
                                        <?php $participation_rate = $total_events > 0 ? round(($stats['events_attended'] / $total_events) * 100, 1) : 0; ?>
                                        <tr>
                                            <td>
                                                <?php if($index == 0): ?>
                                                    <span class="badge badge-warning">🥇 #<?php echo $index + 1 ?></span>
                                                <?php elseif($index == 1): ?>
                                                    <span class="badge badge-secondary">🥈 #<?php echo $index + 1 ?></span>
                                                <?php elseif($index == 2): ?>
                                                    <span class="badge badge-warning" style="background-color: #cd7f32;">🥉 #<?php echo $index + 1 ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-primary">#<?php echo $index + 1 ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong>Purok <?php echo htmlspecialchars($stats['purok']) ?></strong></td>
                                            <td><span class="badge badge-success"><?php echo $stats['total_attendance'] ?></span></td>
                                            <td><span class="badge badge-info"><?php echo $stats['unique_attendees'] ?></span></td>
                                            <td><span class="badge badge-primary"><?php echo $stats['events_attended'] ?></span></td>
                                            <td><?php echo $stats['avg_attendance_per_event'] ?></td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $participation_rate ?>%;" 
                                                         aria-valuenow="<?php echo $participation_rate ?>" aria-valuemin="0" aria-valuemax="100">
                                                        <?php echo $participation_rate ?>%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                            <strong>No Data Available</strong><br>
                            No purok attendance data found. Attendance will appear here once members start attending events.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Prepare data for chart
    const purokData = <?php echo json_encode($purok_stats) ?>;
    
    if(purokData.length > 0) {
        const purokLabels = purokData.map(item => `Purok ${item.purok}`);
        const attendanceCounts = purokData.map(item => parseInt(item.total_attendance));
        const uniqueMembers = purokData.map(item => parseInt(item.unique_attendees));
        
        // Create attendance comparison chart
        const ctx = document.getElementById('purokAttendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: purokLabels,
                datasets: [{
                    label: 'Total Attendance',
                    data: attendanceCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }, {
                    label: 'Unique Members',
                    data: uniqueMembers,
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Purok Performance Comparison'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
    
    // Initialize DataTable for detailed statistics
    <?php if(!empty($purok_stats)): ?>
    $('.table').DataTable({
        "pageLength": 10,
        "order": [[ 2, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ]
    });
    <?php endif; ?>
});
</script>
