<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .attendee-card {
        transition: transform 0.2s ease-in-out;
        border-left: 4px solid #28a745;
    }
    .attendee-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .event-filter-card {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }
    .stats-card {
        border-left: 4px solid #17a2b8;
    }
    .scan-time {
        font-size: 0.9em;
        color: #6c757d;
    }
    .attendee-avatar {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 2px solid #28a745;
    }
    .filter-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>

<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-check"></i> List of Present Attendees
        </h3>
    </div>
    <div class="card-body">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <label for="event-filter">Filter by Event:</label>
                    <select class="form-control" id="event-filter">
                        <option value="">Select an event to view attendees</option>
                        <?php 
                        $event_qry = $conn->query("
                            SELECT 
                                el.id, 
                                el.title, 
                                el.date_created,
                                COUNT(ea.id) as present_count 
                            FROM `event_list` el 
                            LEFT JOIN `event_attendance` ea ON el.id = ea.event_id AND ea.status = 'present'
                            GROUP BY el.id 
                            ORDER BY el.date_created DESC
                        ");
                        while($event = $event_qry->fetch_assoc()):
                        ?>
                        <option value="<?= $event['id'] ?>" data-count="<?= $event['present_count'] ?>">
                            <?= htmlspecialchars($event['title']) ?> - <?= date("M d, Y", strtotime($event['date_created'])) ?> (<?= $event['present_count'] ?> present)
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
                        <button type="button" class="btn btn-primary btn-block" id="search-btn">
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
                            <h4 class="text-success" id="total-present">0</h4>
                            <small>Total Present</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <h4 class="text-info" id="total-zones">0</h4>
                            <small>Zones Represented</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <h4 class="text-primary" id="avg-scan-time">--</h4>
                            <small>Avg. Scan Time</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <button class="btn btn-success btn-sm" id="export-btn" disabled>
                                <i class="fas fa-download"></i> Export List
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendees List -->
        <div id="attendees-container">
            <div class="text-center text-muted py-5">
                <i class="fas fa-users fa-3x mb-3"></i>
                <h5>Select an event to view present attendees</h5>
                <p>Choose an event from the dropdown above to see who attended.</p>
            </div>
        </div>

        <!-- Loading indicator -->
        <div id="loading-indicator" style="display: none;" class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2">Loading attendees...</p>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    let currentEventId = null;
    
    // Search button click
    $('#search-btn').click(function(){
        loadAttendees();
    });
    
    // Event filter change
    $('#event-filter').change(function(){
        if($(this).val()) {
            loadAttendees();
        } else {
            resetView();
        }
    });
    
    // Export functionality
    $('#export-btn').click(function(){
        if(currentEventId) {
            exportAttendeesList();
        }
    });
    
    function loadAttendees() {
        const eventId = $('#event-filter').val();
        const zoneFilter = $('#zone-filter').val();
        
        if(!eventId) {
            alert('Please select an event first.');
            return;
        }
        
        currentEventId = eventId;
        
        // Show loading
        $('#loading-indicator').show();
        $('#attendees-container').hide();
        $('#stats-section').hide();
        
        // AJAX call to load attendees
        $.ajax({
            url: _base_url_ + "admin/attendance/load_present_attendees.php",
            method: "POST",
            data: {
                event_id: eventId,
                zone_filter: zoneFilter
            },
            dataType: 'json',
            success: function(response) {
                $('#loading-indicator').hide();
                
                if(response.success) {
                    displayAttendees(response.attendees);
                    updateStats(response.stats);
                    $('#stats-section').show();
                    $('#export-btn').prop('disabled', false);
                } else {
                    $('#attendees-container').html(
                        '<div class="alert alert-warning text-center">' +
                        '<i class="fas fa-exclamation-triangle"></i> ' + response.message +
                        '</div>'
                    ).show();
                }
            },
            error: function() {
                $('#loading-indicator').hide();
                $('#attendees-container').html(
                    '<div class="alert alert-danger text-center">' +
                    '<i class="fas fa-exclamation-circle"></i> Error loading attendees. Please try again.' +
                    '</div>'
                ).show();
            }
        });
    }
    
    function displayAttendees(attendees) {
        let html = '';
        
        if(attendees.length === 0) {
            html = '<div class="alert alert-info text-center">' +
                   '<i class="fas fa-info-circle"></i> No present attendees found for the selected criteria.' +
                   '</div>';
        } else {
            html = '<div class="row">';
            attendees.forEach(function(attendee) {
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card attendee-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-1">${attendee.name}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> ${attendee.zone || 'N/A'}
                                        </small>
                                        <div class="scan-time mt-1">
                                            <i class="fas fa-clock"></i> ${attendee.scan_time}
                                        </div>
                                        ${attendee.scanner_name ? 
                                            `<div class="text-muted" style="font-size: 0.8em;">
                                                Scanned by: ${attendee.scanner_name}
                                            </div>` : ''
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
        }
        
        $('#attendees-container').html(html).show();
    }
    
    function updateStats(stats) {
        $('#total-present').text(stats.total_present);
        $('#total-zones').text(stats.unique_zones);
        $('#avg-scan-time').text(stats.avg_scan_time);
    }
    
    function resetView() {
        currentEventId = null;
        $('#attendees-container').html(
            '<div class="text-center text-muted py-5">' +
            '<i class="fas fa-users fa-3x mb-3"></i>' +
            '<h5>Select an event to view present attendees</h5>' +
            '<p>Choose an event from the dropdown above to see who attended.</p>' +
            '</div>'
        );
        $('#stats-section').hide();
        $('#export-btn').prop('disabled', true);
    }
    
    function exportAttendeesList() {
        const eventTitle = $('#event-filter option:selected').text();
        const zoneFilter = $('#zone-filter').val();
        
        // Create a form and submit for export
        const form = $('<form>', {
            method: 'POST',
            action: _base_url_ + 'admin/attendance/export_present_list.php'
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
