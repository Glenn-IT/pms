<div class="card shadow-lg border-0 rounded-lg mt-4">
    <div class="card-header bg-dark text-white">
        <h3 class="mb-0"><i class="fa fa-tachometer-alt mr-2"></i>Youth Dashboard</h3>
    </div>
    <div class="card-body">
        <div class="youth-dashboard">
            <!-- Welcome Section -->
            <div class="welcome-section mb-4">
                <h2 class="font-weight-bold">Welcome, <?php echo $_settings->userdata('firstname'); ?> 👋</h2>
                <p class="text-muted">Stay updated with the latest announcements, events, and activities for the youth community.</p>
            </div>

            <?php if($_settings->userdata('type') != 1): ?>
            <!-- Announcement Highlight -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa fa-bullhorn mr-2"></i>Latest Announcements</h4>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div id="dashboard_announcement_list" class="announcement-grid">
                            <!-- Announcements will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events Highlight -->
            <div class="card card-outline card-success mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa fa-calendar-alt mr-2"></i>Upcoming Events</h4>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div id="dashboard_event_list" class="event-grid">
                            <!-- Events will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Tools Panel -->
            <div class="card card-outline card-info mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa fa-qrcode mr-2"></i>QR Code Tools</h4>
                </div>
                <div class="card-body">
                    <div class="container-fluid text-center">
                        <button type="button" class="btn btn-info btn-lg" style="min-width:200px;" data-toggle="modal" data-target="#qrCodeModal" id="openQRCodeModuleBtn">
                            <i class="fa fa-qrcode mr-2"></i>Open QR Code Module
                        </button>
                        <p class="mt-2 text-muted">Access QR code generation, scanning, and management tools.</p>
                    </div>
                </div>
            </div>

            <!-- SK Officials Panel -->
            <div class="card card-outline card-warning mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa fa-users mr-2"></i>SK Officials</h4>
                </div>
                <div class="card-body">
                    <div id="sk_officials_content">
                        <div class="text-center text-muted py-3"><i class="fa fa-spinner fa-spin"></i> Loading SK Officials...</div>
                    </div>
                </div>
            </div>

            <!-- About Us Panel -->
            <div class="card card-outline card-success mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa fa-info-circle mr-2"></i>About Us</h4>
                </div>
                <div class="card-body">
                    <div id="about_us_content">
                        <div class="text-center text-muted py-3"><i class="fa fa-spinner fa-spin"></i> Loading About Us...</div>
                    </div>
                </div>
            </div>

            <!-- Developers Information Panel -->
            <div class="card card-outline card-purple mb-4" style="border-color: #6f42c1;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fa fa-code mr-2"></i>Developers Information</h4>
                </div>
                <div class="card-body">
                    <div id="developers_content">
                        <div class="text-center text-muted py-3"><i class="fa fa-spinner fa-spin"></i> Loading Developers...</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- QR Code Modal -->
            <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrCodeModalLabel"><i class="fa fa-qrcode mr-2"></i>QR Code Module</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="qrCodeModalBody" style="min-height:400px;">
                            <div class="text-center text-muted py-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SK Officials Modal -->
            <div class="modal fade" id="skOfficialsModal" tabindex="-1" role="dialog" aria-labelledby="skOfficialsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="skOfficialsModalLabel"><i class="fa fa-users mr-2"></i>SK Officials Management</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="skOfficialsModalBody" style="min-height:400px;">
                            <div class="text-center text-muted py-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            $(document).ready(function(){
                $('#openQRCodeModuleBtn').on('click', function(){
                    console.log('QR Code button clicked');
                    $('#qrCodeModalBody').html('<div class="text-center text-muted py-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
                    $.ajax({
                        url: 'QRCode/modal_content.php',
                        type: 'GET',
                        success: function(data) {
                            console.log('AJAX success, data length:', data.length);
                            console.log('Data preview:', data.substring(0, 200));
                            $('#qrCodeModalBody').html(data);
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX error:', error);
                            console.log('Status:', status);
                            console.log('Response:', xhr.responseText);
                            $('#qrCodeModalBody').html('<div class="alert alert-danger">Failed to load QR Code Module. Error: ' + error + '</div>');
                        }
                    });
                });

                <?php if($_settings->userdata('type') != 1): ?>
                // Load SK Officials automatically on page load
                loadSKOfficials();
                loadAboutUs();
                loadDevelopers();
                <?php endif; ?>
            });

            function loadSKOfficials() {
                $.ajax({
                    url: 'skofficials/dashboard_content.php',
                    type: 'GET',
                    success: function(data) {
                        $('#sk_officials_content').html(data);
                    },
                    error: function(xhr, status, error) {
                        $('#sk_officials_content').html('<div class="alert alert-danger">Failed to load SK Officials.</div>');
                    }
                });
            }

            function loadAboutUs() {
                $.ajax({
                    url: 'aboutus/dashboard_content.php',
                    type: 'GET',
                    success: function(data) {
                        $('#about_us_content').html(data);
                    },
                    error: function(xhr, status, error) {
                        $('#about_us_content').html('<div class="alert alert-danger">Failed to load About Us.</div>');
                    }
                });
            }

            function loadDevelopers() {
                $.ajax({
                    url: 'devs/dashboard_content.php',
                    type: 'GET',
                    success: function(data) {
                        $('#developers_content').html(data);
                    },
                    error: function(xhr, status, error) {
                        $('#developers_content').html('<div class="alert alert-danger">Failed to load Developers Information.</div>');
                    }
                });
            }
            </script>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card stat-card shadow-sm border-0 rounded-lg text-center p-3">
                        <div class="icon text-primary mb-2"><i class="fa fa-users fa-2x"></i></div>
                        <h5 class="mb-1">Registered Youth</h5>
                        <h3 class="font-weight-bold" id="youth_count">0</h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card stat-card shadow-sm border-0 rounded-lg text-center p-3">
                        <div class="icon text-success mb-2"><i class="fa fa-calendar-alt fa-2x"></i></div>
                        <h5 class="mb-1">Events</h5>
                        <h3 class="font-weight-bold" id="event_count">0</h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card stat-card shadow-sm border-0 rounded-lg text-center p-3">
                        <div class="icon text-success mb-2"><i class="fa fa-calendar-alt fa-2x"></i></div>
                        <h5 class="mb-1">Announcements</h5>
                        <h3 class="font-weight-bold" id="announcement_count">0</h3>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa fa-venus-mars mr-2"></i>Gender Distribution</h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 200px; position: relative;">
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa fa-map-marker-alt mr-2"></i>Population Per Zone</h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 200px; position: relative;">
                                <canvas id="zoneChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fa fa-user-check mr-2"></i>Active/Inactive Users</h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 200px; position: relative;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0"><i class="fa fa-calendar-check mr-2"></i>Attendance Overview</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <select id="eventSelector" class="form-control form-control-sm">
                                    <option value="all">All Events</option>
                                </select>
                            </div>
                            <div style="height: 200px; position: relative;">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<script>
$(document).ready(function(){   // Fetch stats (example)
    $.ajax({
        url: '../classes/Master.php?f=get_dashboard_stats',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                $('#youth_count').text(resp.data.youth || 0);
                $('#event_count').text(resp.data.events || 0);
                $('#announcement_count').text(resp.data.announcements || 0);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
    
    // Load Gender Chart
    $.ajax({
        url: '../classes/Master.php?f=get_gender_stats',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                createGenderChart(resp.data);
            }
        }
    });
    
    // Load Zone Chart
    $.ajax({
        url: '../classes/Master.php?f=get_zone_stats',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                createZoneChart(resp.data);
            }
        }
    });
    
    // Load Status Chart
    $.ajax({
        url: '../classes/Master.php?f=get_status_stats',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                createStatusChart(resp.data);
            }
        }
    });
    
    // Load Attendance Chart
    $.ajax({
        url: '../classes/Master.php?f=get_attendance_stats',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                createAttendanceChart(resp.data);
            }
        }
    });
    
    // Load Events for Dropdown
    $.ajax({
        url: '../classes/Master.php?f=get_events_for_dropdown',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                populateEventDropdown(resp.data);
            }
        }
    });
    
    // Handle event selection change
    $('#eventSelector').on('change', function(){
        var selectedEventId = $(this).val();
        loadAttendanceData(selectedEventId);
    });

    <?php if($_settings->userdata('type') != 1): ?>
    loadDashboardAnnouncements();
    loadDashboardEvents();
    <?php endif; ?>
});

function createGenderChart(data) {
    const ctx = document.getElementById('genderChart').getContext('2d');
    const labels = data.map(item => item.label);
    const counts = data.map(item => item.count);
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: ['#007bff', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
}

function createZoneChart(data) {
    const ctx = document.getElementById('zoneChart').getContext('2d');
    const labels = data.map(item => item.label);
    const counts = data.map(item => item.count);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Population',
                data: counts,
                backgroundColor: '#28a745',
                borderColor: '#1e7e34',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        font: {
                            size: 10
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

function createStatusChart(data) {
    const ctx = document.getElementById('statusChart').getContext('2d');
    const labels = data.map(item => item.label);
    const counts = data.map(item => item.count);
    
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: ['#17a2b8', '#6c757d'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
}

function createAttendanceChart(data) {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const labels = data.map(item => item.label);
    const counts = data.map(item => item.count);
    
    // Destroy existing chart if it exists
    if(window.attendanceChartInstance) {
        window.attendanceChartInstance.destroy();
    }
    
    // Dynamic colors based on labels
    let colors = [];
    labels.forEach(label => {
        if(label.includes('Present') || label.includes('Ever Attended')) {
            colors.push('#28a745'); // Green
        } else {
            colors.push('#dc3545'); // Red
        }
    });
    
    window.attendanceChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
}

function populateEventDropdown(events) {
    var dropdown = $('#eventSelector');
    dropdown.empty();
    dropdown.append('<option value="all">All Events</option>');
    
    events.forEach(function(event) {
        dropdown.append('<option value="' + event.id + '">' + event.title + ' (' + event.date + ')</option>');
    });
}

function loadAttendanceData(eventId) {
    var url = '../classes/Master.php?f=get_attendance_stats';
    if(eventId && eventId !== 'all') {
        url += '&event_id=' + eventId;
    }
    
    $.ajax({
        url: url,
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                createAttendanceChart(resp.data);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error loading attendance data:', error);
        }
    });
}

// Dashboard Announcements AJAX
function renderDashboardAnnouncements(announcements) {
    if (!announcements.length) {
        $('#dashboard_announcement_list').html('<p class="text-muted">No announcements found.</p>');
        return;
    }
    let html = '';
    announcements.forEach(ann => {
        let imageSrc = '';
        let imageIndicator = '';
        if (ann.images && ann.images.length > 0) {
            imageSrc = `../${ann.images[0]}`;
            if (ann.images.length > 1) {
                imageIndicator = `<div class=\"image-indicator\">+${ann.images.length - 1} more</div>`;
            }
        } else if (ann.image_path) {
            imageSrc = `../${ann.image_path}`;
        } else {
            imageSrc = '../assets/images/placeholder.jpg';
        }
        html += `
            <div class=\"announcement-card\">
                <div style=\"position: relative;\">
                    <img src=\"${imageSrc}\" class=\"announcement-img\" alt=\"Announcement\">
                    ${imageIndicator}
                </div>
                <div class=\"announcement-body\">
                    <div class=\"announcement-title\">${ann.title}</div>
                    <div class=\"announcement-date\"><i class=\"fa fa-calendar\"></i> ${ann.date}</div>
                    <div class=\"announcement-desc\">${ann.description}</div>
                </div>
            </div>
        `;
    });
    $('#dashboard_announcement_list').html(html);
}

function loadDashboardAnnouncements() {
    $.ajax({
        url: '../classes/Master.php?f=get_all_announcements',
        method: 'GET',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                // Show only the latest 3 announcements
                let latest = resp.data.sort((a, b) => new Date(b.date_created || b.date) - new Date(a.date_created || a.date)).slice(0, 3);
                renderDashboardAnnouncements(latest);
            } else {
                renderDashboardAnnouncements([]);
            }
        },
        error: function(){
            renderDashboardAnnouncements([]);
        }
    });
}

// Dashboard Events AJAX
function renderDashboardEvents(events) {
    if (!events.length) {
        $('#dashboard_event_list').html('<p class="text-muted">No events found.</p>');
        return;
    }
    let html = '';
    events.forEach(event => {
        let imageSrc = '';
        if (event.images && event.images.length > 0) {
            imageSrc = `../${event.images[0]}`;
        } else if (event.image_path) {
            imageSrc = `../${event.image_path}`;
        } else {
            imageSrc = '../assets/images/placeholder.jpg';
        }
        html += `
            <div class=\"event-card\">
                <div style=\"position: relative;\">
                    <img src=\"${imageSrc}\" class=\"event-img\" alt=\"Event\">
                </div>
                <div class=\"event-body\">
                    <div class=\"event-title\">${event.title}</div>
                    <div class=\"event-date\"><i class=\"fa fa-calendar\"></i> ${event.date}</div>
                    <div class=\"event-desc\">${event.description}</div>
                </div>
            </div>
        `;
    });
    $('#dashboard_event_list').html(html);
}

function loadDashboardEvents() {
    $.ajax({
        url: '../classes/Master.php?f=get_all_events',
        method: 'GET',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                // Show only the latest 3 events (by date)
                let latest = resp.data.sort((a, b) => new Date(b.date_created || b.date) - new Date(a.date_created || a.date)).slice(0, 3);
                renderDashboardEvents(latest);
            } else {
                renderDashboardEvents([]);
            }
        },
        error: function(){
            renderDashboardEvents([]);
        }
    });
}
</script>

<style>
.youth-dashboard h2 { color: #2c3e50; }
.stat-card { transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-5px); }
.quick-links .btn { min-width: 180px; }
.card-body { overflow: hidden; }
canvas { max-width: 100%; height: auto; }

/* Modern Announcement Styles for Dashboard */
.announcement-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
}
.announcement-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: box-shadow 0.2s, height 0.3s ease;
    display: flex;
    flex-direction: column;
    min-height: 350px;
}
.announcement-card:hover {
    box-shadow: 0 8px 32px rgba(0,0,0,0.16);
}
.announcement-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: #f5f5f5;
    flex-shrink: 0;
}
.announcement-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.announcement-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #333;
    height: 40px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.announcement-date {
    font-size: 0.95rem;
    color: #888;
    margin-bottom: 0.5rem;
    font-weight: 500;
}
.announcement-desc {
    font-size: 1.02rem;
    color: #222;
    margin-bottom: 0.5rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    min-height: 48px;
    max-height: 60px;
}
.image-indicator {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

/* Modern Event Styles for Dashboard */
.event-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
}
.event-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: box-shadow 0.2s, height 0.3s ease;
    display: flex;
    flex-direction: column;
    min-height: 350px;
}
.event-card:hover {
    box-shadow: 0 8px 32px rgba(0,0,0,0.16);
}
.event-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: #f5f5f5;
    flex-shrink: 0;
}
.event-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.event-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #333;
    height: 40px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.event-date {
    font-size: 0.95rem;
    color: #888;
    margin-bottom: 0.5rem;
    font-weight: 500;
}
.event-desc {
    font-size: 1.02rem;
    color: #222;
    margin-bottom: 0.5rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    min-height: 48px;
    max-height: 60px;
}
@media (max-width: 900px) {
    .announcement-grid {
        grid-template-columns: 1fr;
    }
    .event-grid {
        grid-template-columns: 1fr;
    }
}
</style>
