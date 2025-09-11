<div class="youth-dashboard">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <h2 class="font-weight-bold">Welcome, <?php echo $_settings->userdata('firstname'); ?> 👋</h2>
        <p class="text-muted">Stay updated with the latest announcements, events, and activities for the youth community.</p>
    </div>

    <!-- Announcement Highlight -->
    

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
</script>

<style>
.youth-dashboard h2 { color: #2c3e50; }
.stat-card { transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-5px); }
.quick-links .btn { min-width: 180px; }
.card-body { overflow: hidden; }
canvas { max-width: 100%; height: auto; }
</style>
