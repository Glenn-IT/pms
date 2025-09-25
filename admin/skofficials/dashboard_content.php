<?php
require_once('../../config.php');

// You can add database queries here to fetch actual SK Officials data
// For now, I'll create a compact version with sample data
?>

<style>
.dashboard-org-chart {
    padding: 15px;
}

.dashboard-org-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 15px;
    margin: 8px;
    color: white;
    text-align: center;
    transition: transform 0.2s ease;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.dashboard-org-card:hover {
    transform: translateY(-3px);
    cursor: pointer;
}

.dashboard-chairman-card {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
}

.dashboard-secretary-card {
    background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
}

.dashboard-treasurer-card {
    background: linear-gradient(135deg, #45b7d1 0%, #96c93d 100%);
}

.dashboard-kagawad-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.dashboard-org-icon {
    font-size: 1.8em;
    margin-bottom: 8px;
}

.dashboard-org-title {
    font-size: 0.9em;
    font-weight: bold;
    margin-bottom: 4px;
}

.dashboard-org-name {
    font-size: 0.85em;
    opacity: 0.9;
}

.view-full-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 20px;
    font-weight: 500;
    transition: transform 0.2s ease;
    margin-top: 15px;
}

.view-full-btn:hover {
    transform: translateY(-2px);
    color: white;
}
</style>

<div class="dashboard-org-chart">
    <!-- Header -->
    <div class="text-center mb-3">
        <h5 class="mb-2"><i class="fas fa-sitemap text-primary mr-2"></i>Sangguniang Kabataan Officials</h5>
    </div>
    
    <!-- Compact Organizational Chart -->
    <div class="row">
        <!-- Chairman -->
        <div class="col-12 mb-2">
            <div class="dashboard-org-card dashboard-chairman-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="dashboard-org-title">SK CHAIRMAN</div>
                <div class="dashboard-org-name" id="dash-chairman-name">Juan Dela Cruz</div>
            </div>
        </div>
        
        <!-- Secretary & Treasurer -->
        <div class="col-md-6 mb-2">
            <div class="dashboard-org-card dashboard-secretary-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="dashboard-org-title">SK SECRETARY</div>
                <div class="dashboard-org-name" id="dash-secretary-name">Maria Santos</div>
            </div>
        </div>
        
        <div class="col-md-6 mb-2">
            <div class="dashboard-org-card dashboard-treasurer-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="dashboard-org-title">SK TREASURER</div>
                <div class="dashboard-org-name" id="dash-treasurer-name">Pedro Garcia</div>
            </div>
        </div>
        
        <!-- Kagawads -->
        <div class="col-md-3 col-6 mb-2">
            <div class="dashboard-org-card dashboard-kagawad-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="dashboard-org-title">KAGAWAD</div>
                <div class="dashboard-org-name" id="dash-kagawad1-name">Anna Reyes</div>
            </div>
        </div>
        
        <div class="col-md-3 col-6 mb-2">
            <div class="dashboard-org-card dashboard-kagawad-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="dashboard-org-title">KAGAWAD</div>
                <div class="dashboard-org-name" id="dash-kagawad2-name">Carlos Lopez</div>
            </div>
        </div>
        
        <div class="col-md-3 col-6 mb-2">
            <div class="dashboard-org-card dashboard-kagawad-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="dashboard-org-title">KAGAWAD</div>
                <div class="dashboard-org-name" id="dash-kagawad3-name">Sofia Martinez</div>
            </div>
        </div>
        
        <div class="col-md-3 col-6 mb-2">
            <div class="dashboard-org-card dashboard-kagawad-card">
                <div class="dashboard-org-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="dashboard-org-title">KAGAWAD</div>
                <div class="dashboard-org-name" id="dash-kagawad4-name">Miguel Torres</div>
            </div>
        </div>
    </div>
    
    <!-- View Full Chart Button -->
    <div class="text-center">
        <button class="btn view-full-btn" onclick="viewFullChart()">
            <i class="fas fa-expand-alt mr-2"></i>View Full Organizational Chart
        </button>
    </div>
</div>

<script>
function viewFullChart() {
    // Navigate to the full SK Officials page
    window.location.href = '?page=skofficials';
}

// Add click handlers to cards for quick info
$(document).ready(function() {
    $('.dashboard-org-card').click(function() {
        var title = $(this).find('.dashboard-org-title').text();
        var name = $(this).find('.dashboard-org-name').text();
        
        // You can show a modal or tooltip with more info
        alert('Quick Contact: ' + name + ' (' + title + ')');
    });
});
</script>
