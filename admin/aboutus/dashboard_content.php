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
    echo '<div class="alert alert-warning">Please log in to view About Us.</div>';
    exit;
}
?>

<style>
.about-dashboard {
    padding: 20px;
}
.mission-card, .vision-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    text-align: center;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.feature-mini {
    text-align: center;
    padding: 15px 10px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
    border-left: 4px solid #007bff;
}
.feature-mini i {
    color: #007bff;
    margin-bottom: 8px;
}
.stats-mini {
    text-align: center;
    padding: 15px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 10px;
}
.stats-mini h4 {
    color: #007bff;
    margin-bottom: 5px;
}
</style>

<div class="about-dashboard">
    <!-- Mission & Vision -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="mission-card">
                <h5><i class="fas fa-bullseye mr-2"></i>Our Mission</h5>
                <p class="mb-0 small">To empower the youth of our community through innovative programs, leadership development, and technology-driven solutions that foster growth, engagement, and positive change.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="vision-card">
                <h5><i class="fas fa-eye mr-2"></i>Our Vision</h5>
                <p class="mb-0 small">A vibrant, connected community where every young person has the opportunity to thrive, lead, and contribute to a better future for all.</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-3">
        <div class="col-md-3 col-6">
            <div class="stats-mini">
                <h4>500+</h4>
                <small class="text-muted">Youth Served</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stats-mini">
                <h4>50+</h4>
                <small class="text-muted">Programs</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stats-mini">
                <h4>10+</h4>
                <small class="text-muted">Years Experience</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stats-mini">
                <h4>24/7</h4>
                <small class="text-muted">Support</small>
            </div>
        </div>
    </div>

    <!-- Key Features -->
    <div class="row">
        <div class="col-md-6">
            <div class="feature-mini">
                <i class="fas fa-users fa-2x"></i>
                <h6 class="font-weight-bold mt-2 mb-1">Community Engagement</h6>
                <small class="text-muted">Building stronger connections within our community</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="feature-mini">
                <i class="fas fa-laptop-code fa-2x"></i>
                <h6 class="font-weight-bold mt-2 mb-1">Digital Innovation</h6>
                <small class="text-muted">Leveraging technology for better service delivery</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="feature-mini">
                <i class="fas fa-graduation-cap fa-2x"></i>
                <h6 class="font-weight-bold mt-2 mb-1">Education & Training</h6>
                <small class="text-muted">Providing skills development and learning opportunities</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="feature-mini">
                <i class="fas fa-heart fa-2x"></i>
                <h6 class="font-weight-bold mt-2 mb-1">Youth Empowerment</h6>
                <small class="text-muted">Supporting young leaders in making positive change</small>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="text-center p-3 bg-light rounded">
                <h6 class="font-weight-bold mb-2">Get In Touch</h6>
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        <small class="ml-1">Piat, Cagayan</small>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-phone text-success"></i>
                        <small class="ml-1">Contact SK Office</small>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-envelope text-primary"></i>
                        <small class="ml-1">info@skpiat.gov</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
