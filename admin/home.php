<div class="youth-dashboard">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <h2 class="font-weight-bold">Welcome, <?php echo $_settings->userdata('firstname'); ?> 👋</h2>
        <p class="text-muted">Stay updated with the latest announcements, events, and activities for the youth community.</p>
    </div>

    <!-- Announcement Highlight -->
    <div class="announcement-highlight mb-4">
        <div class="card shadow-sm rounded-lg border-0">
            <div class="card-body d-flex align-items-center">
                <div class="icon mr-3 text-primary">
                    <i class="fa fa-bullhorn fa-3x"></i>
                </div>
                <div>
                    
                    
                    <h5><a href="index.php?page=announcements" class="btn btn-link p-0 mt-2">View All Announcements →</a></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0 rounded-lg text-center p-3">
                <div class="icon text-primary mb-2"><i class="fa fa-users fa-2x"></i></div>
                <h5 class="mb-1">Registered Youth</h5>
                <h3 class="font-weight-bold" id="youth_count">0</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0 rounded-lg text-center p-3">
                <div class="icon text-success mb-2"><i class="fa fa-calendar-alt fa-2x"></i></div>
                <h5 class="mb-1">Events</h5>
                <h3 class="font-weight-bold" id="event_count">0</h3>
            </div>
        </div>
        
        
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-venus-mars mr-2"></i>Gender Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fa fa-map-marker-alt mr-2"></i>Population Per Zone</h5>
                </div>
                <div class="card-body">
                    <canvas id="zoneChart" width="400" height="200"></canvas>
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
                    position: 'bottom'
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
                        stepSize: 1
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
</script>

<style>
.youth-dashboard h2 { color: #2c3e50; }
.stat-card { transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-5px); }
.quick-links .btn { min-width: 180px; }
</style>
