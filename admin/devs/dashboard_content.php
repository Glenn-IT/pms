<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize database constants first
require_once('../../initialize.php');

// Initialize system classes
require_once('../../classes/DBConnection.php');
require_once('../../classes/SystemSettings.php');

$db = new DBConnection;
$conn = $db->conn;

$_settings = new SystemSettings($conn);

// Check if user is logged in
if(!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])){
    echo '<div class="alert alert-warning">Please log in to view Developers Information.</div>';
    exit;
}
?>

<style>
.dev-dashboard {
    padding: 20px;
}
.dev-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    text-align: center;
    transition: all 0.3s ease;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.dev-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.dev-card.kim {
    border-left: 4px solid #17a2b8;
}
.dev-card.cristel {
    border-left: 4px solid #ffc107;
}
.dev-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    color: white;
}
.dev-name {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}
.dev-details {
    font-size: 11px;
    color: #666;
    line-height: 1.3;
}
.team-stats {
    background: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    text-align: center;
}
.team-stats h6 {
    color: #007bff;
    margin-bottom: 10px;
}
</style>

<div class="dev-dashboard">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="team-stats">
                <h6><i class="fas fa-code mr-2"></i>Development Team</h6>
                <div class="row">
                    <div class="col-4">
                        <h5 class="text-primary mb-1">2</h5>
                        <small class="text-muted">Developers</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-success mb-1">BSIT</h5>
                        <small class="text-muted">Program</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-warning mb-1">CSU</h5>
                        <small class="text-muted">University</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Developer Cards -->
    <div class="row">
        <!-- Kimberly Agustin -->
        <div class="col-md-6">
            <div class="dev-card kim">
                <div class="dev-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="dev-name">Kimberly Agustin</div>
                <div class="dev-details">
                    <div class="mb-1"><i class="fas fa-graduation-cap text-primary"></i> BS Information Technology</div>
                    <div class="mb-1"><i class="fas fa-university text-success"></i> CSU - Piat Campus</div>
                    <div class="mb-1"><i class="fas fa-phone text-info"></i> 09359505884</div>
                    <div><i class="fas fa-envelope text-danger"></i> agustinkimberly27@gmail.com</div>
                </div>
            </div>
        </div>

        <!-- Cristel Pulig -->
        <div class="col-md-6">
            <div class="dev-card cristel">
                <div class="dev-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="dev-name">Cristel Pulig</div>
                <div class="dev-details">
                    <div class="mb-1"><i class="fas fa-graduation-cap text-primary"></i> BS Information Technology</div>
                    <div class="mb-1"><i class="fas fa-university text-success"></i> CSU - Piat Campus</div>
                    <div class="mb-1"><i class="fas fa-phone text-info"></i> 09674513768</div>
                    <div><i class="fas fa-envelope text-danger"></i> cristelpulig770@gmail.com</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technologies Used -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="team-stats">
                <h6><i class="fas fa-tools mr-2"></i>Technologies Used</h6>
                <div class="row text-center">
                    <div class="col-3">
                        <i class="fab fa-php fa-2x text-primary mb-1"></i>
                        <br><small>PHP</small>
                    </div>
                    <div class="col-3">
                        <i class="fab fa-js-square fa-2x text-warning mb-1"></i>
                        <br><small>JavaScript</small>
                    </div>
                    <div class="col-3">
                        <i class="fab fa-bootstrap fa-2x text-purple mb-1"></i>
                        <br><small>Bootstrap</small>
                    </div>
                    <div class="col-3">
                        <i class="fas fa-database fa-2x text-success mb-1"></i>
                        <br><small>MySQL</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Info -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="text-center p-3 bg-light rounded">
                <small class="text-muted">
                    <i class="fas fa-quote-left mr-1"></i>
                    Dedicated to creating innovative solutions for community management and youth engagement.
                    <i class="fas fa-quote-right ml-1"></i>
                </small>
            </div>
        </div>
    </div>
</div>
