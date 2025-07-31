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
                <h5 class="mb-1">Upcoming Events</h5>
                <h3 class="font-weight-bold" id="event_count">0</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm border-0 rounded-lg text-center p-3">
                <div class="icon text-warning mb-2"><i class="fa fa-handshake fa-2x"></i></div>
                <h5 class="mb-1">Active Programs</h5>
                <h3 class="font-weight-bold" id="program_count">0</h3>
            </div>
        </div>
    </div>

    
</div>

<script>
$(document).ready(function(){
    // Fetch latest announcement
    $.ajax({
        url: 'classes/Master.php?f=get_latest_announcement',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                $('#latest_announcement').text(resp.data.description);
            } else {
                $('#latest_announcement').text("No announcements available.");
            }
        }
    });

    // Fetch stats (example)
    $.ajax({
        url: 'classes/Master.php?f=get_dashboard_stats',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                $('#youth_count').text(resp.data.youth || 0);
                $('#event_count').text(resp.data.events || 0);
                $('#program_count').text(resp.data.programs || 0);
            }
        }
    });
});
</script>

<style>
.youth-dashboard h2 { color: #2c3e50; }
.stat-card { transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-5px); }
.quick-links .btn { min-width: 180px; }
</style>
