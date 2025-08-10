<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .absentee-card {
        transition: transform 0.2s ease-in-out;
        border-left: 4px solid #dc3545;
    }
    .absentee-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .event-filter-card {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    .stats-card {
        border-left: 4px solid #dc3545;
    }
    .absentee-avatar {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 2px solid #dc3545;
    }
    .filter-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .absence-reason {
        font-size: 0.8em;
        color: #6c757d;
        font-style: italic;
    }
</style>

<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-times"></i> List of Absent Attendees
        </h3>
    </div>
    <div class="card-body">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <label for="event-filter">Filter by Event:</label>
                    <select class="form-control" id="event-filter">
                        <option value="">Select an event to view absentees</option>
                        <?php 
                        $event_qry = $conn->query("
                            SELECT 
                                el.id, 
                                el.title, 
                                el.date_created,
                                COUNT(ea.id) as present_count,
                                (SELECT COUNT(*) FROM users WHERE status = 1 AND type != 1) as total_users
                            FROM `event_list` el 
                            LEFT JOIN `event_attendance` ea ON el.id = ea.event_id AND ea.status = 'present'
                            GROUP BY el.id 
                            ORDER BY el.date_created DESC
                        ");
                        while($event = $event_qry->fetch_assoc()):
                            $absent_count = $event['total_users'] - $event['present_count'];
                        ?>
                        <option value="<?= $event['id'] ?>" data-absent="<?= $absent_count ?>" data-present="<?= $event['present_count'] ?>">
                            <?= htmlspecialchars($event['title']) ?> - <?= date("M d, Y", strtotime($event['date_created'])) ?> (<?= $absent_count ?> absent)
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="zone-filter">Filter by Zone:</label>
                    <select class="form-control" id="zone-filter">
                        <option value="">All Zones</option>
                        <?php 
                        $zone_qry = $conn->query("SELECT DISTINCT zone FROM `users` WHERE zone IS NOT NULL AND zone != '' ORDER BY zone");
                        while($zone = $zone_qry->fetch_assoc()):
                        ?>
                        <option value="<?= htmlspecialchars($zone['zone']) ?>"><?= htmlspecialchars($zone['zone']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <div>
                        <button type="button" class="btn btn-danger btn-block" id="search-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Statistics Section -->
        <div id="stats-section" style="display: none;">
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <h4 class="text-danger" id="total-absent">0</h4>
                            <small>Total Absent</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <h4 class="text-warning" id="absent-zones">0</h4>
                            <small>Zones with Absences</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <h4 class="text-info" id="attendance-rate">0%</h4>
                            <small>Attendance Rate</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <button class="btn btn-danger btn-sm" id="export-btn" disabled>
                                <i class="fas fa-download"></i> Export List
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Absentees List -->
        <div id="absentees-container">
            <div class="text-center text-muted py-5">
                <i class="fas fa-user-times fa-3x mb-3"></i>
                <h5>Select an event to view absent attendees</h5>
                <p>Choose an event from the dropdown above to see who was absent.</p>
            </div>
        </div>

        <!-- Loading indicator -->
        <div id="loading-indicator" style="display: none;" class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-danger"></i>
            <p class="mt-2">Loading absentees...</p>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){
    let currentEventId = null;
    
    // Search button click
    $('#search-btn').click(function(){
        loadAbsentees();
    });
    
    // Event filter change
    $('#event-filter').change(function(){
        if($(this).val()) {
            loadAbsentees();
        } else {
            resetView();
        }
    });
    
    // Export functionality
    $('#export-btn').click(function(){
        if(currentEventId) {
            exportAbsenteesList();
        }
    });
    
    function loadAbsentees() {
        const eventId = $('#event-filter').val();
        const zoneFilter = $('#zone-filter').val();
        
        if(!eventId) {
            alert('Please select an event first.');
            return;
        }
        
        currentEventId = eventId;
        
        // Show loading
        $('#loading-indicator').show();
        $('#absentees-container').hide();
        $('#stats-section').hide();
        
        // AJAX call to load absentees
        $.ajax({
            url: _base_url_ + "admin/attendance/load_absent_attendees.php",
            method: "POST",
            data: {
                event_id: eventId,
                zone_filter: zoneFilter
            },
            dataType: 'json',
            success: function(response) {
                $('#loading-indicator').hide();
                
                // Log response for debugging
                console.log('Response:', response);
                
                if(response.success) {
                    displayAbsentees(response.absentees);
                    updateStats(response.stats);
                    $('#stats-section').show();
                    $('#export-btn').prop('disabled', false);
                } else {
                    $('#absentees-container').html(
                        '<div class="alert alert-success text-center">' +
                        '<i class="fas fa-check-circle"></i> ' + response.message +
                        '</div>'
                    ).show();
                }
            },
            error: function(xhr, status, error) {
                $('#loading-indicator').hide();
                console.log('Error details:', xhr.responseText, status, error);
                $('#absentees-container').html(
                    '<div class="alert alert-danger text-center">' +
                    '<i class="fas fa-exclamation-circle"></i> Error loading absentees. Please try again.<br>' +
                    '<small>Debug: ' + error + '</small>' +
                    '</div>'
                ).show();
            }
        });
    }
    
    function displayAbsentees(absentees) {
        let html = '';
        
        if(absentees.length === 0) {
            html = '<div class="alert alert-success text-center">' +
                   '<i class="fas fa-check-circle fa-2x mb-2"></i><br>' +
                   '<strong>Perfect Attendance!</strong><br>' +
                   'All registered users attended this event.' +
                   '</div>';
        } else {
            html = '<div class="row">';
            absentees.forEach(function(absentee) {
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card absentee-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user-times text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-1">${absentee.name}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> ${absentee.zone || 'N/A'}
                                        </small>
                                        <div class="absence-reason mt-1">
                                            <i class="fas fa-info-circle"></i> Did not scan QR code
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
        }
        
        $('#absentees-container').html(html).show();
    }
    
    function updateStats(stats) {
        $('#total-absent').text(stats.total_absent);
        $('#absent-zones').text(stats.absent_zones);
        $('#attendance-rate').text(stats.attendance_rate + '%');
    }
    
    function resetView() {
        currentEventId = null;
        $('#absentees-container').html(
            '<div class="text-center text-muted py-5">' +
            '<i class="fas fa-user-times fa-3x mb-3"></i>' +
            '<h5>Select an event to view absent attendees</h5>' +
            '<p>Choose an event from the dropdown above to see who was absent.</p>' +
            '</div>'
        );
        $('#stats-section').hide();
        $('#export-btn').prop('disabled', true);
    }
    
    function exportAbsenteesList() {
        const eventTitle = $('#event-filter option:selected').text();
        const zoneFilter = $('#zone-filter').val();
        
        // Create a form and submit for export
        const form = $('<form>', {
            method: 'POST',
            action: _base_url_ + 'admin/attendance/export_absent_list.php'
        });
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'event_id',
            value: currentEventId
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'zone_filter', 
            value: zoneFilter
        }));
        
        form.append($('<input>', {
            type: 'hidden',
            name: 'event_title',
            value: eventTitle
        }));
        
        $('body').append(form);
        form.submit();
        form.remove();
    }
});
</script>
