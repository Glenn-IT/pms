<?php if($_settings->chk_flashdata('success')): ?>
<script>
  alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="developer-info-board">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body text-center py-4">
                    <i class="fas fa-code fa-3x mb-3"></i>
                    <h2 class="font-weight-bold mb-2">Developer Information Board</h2>
                    <p class="mb-0">Meet the talented developers behind this system</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Developer Cards -->
    <div class="row">
        <!-- Developer 1: Kimberly Agustin -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-info text-white text-center">
                    <div class="developer-avatar mb-2">
                        <i class="fas fa-user-circle fa-4x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-0">Kimberly Agustin</h4>
                </div>
                <div class="card-body">
                    <div class="developer-details">
                        <div class="detail-item mb-3">
                            <i class="fas fa-graduation-cap text-primary mr-2"></i>
                            <strong>Course:</strong> BS Information Technology
                        </div>
                        <div class="detail-item mb-3">
                            <i class="fas fa-university text-success mr-2"></i>
                            <strong>School:</strong> Cagayan State University - Piat Campus
                        </div>
                        <div class="detail-item mb-3">
                            <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                            <strong>Location:</strong> Piat, Cagayan
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <h6 class="font-weight-bold text-dark mb-2">Contact Information:</h6>
                    <div class="contact-links">
                        <div class="contact-item mb-2">
                            <i class="fas fa-phone text-success mr-2"></i>
                            <span>09359505884</span>
                        </div>
                        <div class="contact-item mb-2">
                            <i class="fas fa-envelope text-danger mr-2"></i>
                            <a href="mailto:agustinkimberly27@gmail.com" class="text-decoration-none">
                                agustinkimberly27@gmail.com
                            </a>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook text-primary mr-2"></i>
                            <span class="text-muted">Facebook profile not provided</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Developer 2: Cristel Pulig -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-warning text-dark text-center">
                    <div class="developer-avatar mb-2">
                        <i class="fas fa-user-circle fa-4x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-0">Cristel Pulig</h4>
                </div>
                <div class="card-body">
                    <div class="developer-details">
                        <div class="detail-item mb-3">
                            <i class="fas fa-graduation-cap text-primary mr-2"></i>
                            <strong>Course:</strong> BS Information Technology
                        </div>
                        <div class="detail-item mb-3">
                            <i class="fas fa-university text-success mr-2"></i>
                            <strong>School:</strong> Cagayan State University - Piat Campus
                        </div>
                        <div class="detail-item mb-3">
                            <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                            <strong>Location:</strong> Piat, Cagayan
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <h6 class="font-weight-bold text-dark mb-2">Contact Information:</h6>
                    <div class="contact-links">
                        <div class="contact-item mb-2">
                            <i class="fas fa-phone text-success mr-2"></i>
                            <span>09674513768</span>
                        </div>
                        <div class="contact-item mb-2">
                            <i class="fas fa-envelope text-danger mr-2"></i>
                            <a href="mailto:cristelpulig770@gmail.com" class="text-decoration-none">
                                cristelpulig770@gmail.com
                            </a>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook text-primary mr-2"></i>
                            <a href="https://www.facebook.com/cristel.pulig.52" target="_blank" class="text-decoration-none">
                                Facebook Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Development Team Info -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Development Team</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="team-stat">
                                <i class="fas fa-laptop-code fa-2x text-primary mb-2"></i>
                                <h6 class="font-weight-bold">Active Developers</h6>
                                <h3 class="text-primary">2</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="team-stat">
                                <i class="fas fa-university fa-2x text-success mb-2"></i>
                                <h6 class="font-weight-bold">Institution</h6>
                                <h6 class="text-success">CSU Piat Campus</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="team-stat">
                                <i class="fas fa-graduation-cap fa-2x text-warning mb-2"></i>
                                <h6 class="font-weight-bold">Program</h6>
                                <h6 class="text-warning">BS Information Technology</h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            <i class="fas fa-quote-left mr-1"></i>
                            Dedicated to creating innovative solutions for community management and youth engagement.
                            <i class="fas fa-quote-right ml-1"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom CSS for Developer Information Board */
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.developer-avatar {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.detail-item {
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.contact-item {
    display: flex;
    align-items: center;
    padding: 5px 0;
}

.contact-item a {
    color: #007bff;
}

.contact-item a:hover {
    color: #0056b3;
    text-decoration: underline !important;
}

.team-stat {
    padding: 20px 10px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.card-header {
    border-bottom: 2px solid rgba(0,0,0,0.1);
}

.developer-info-board .card {
    border-radius: 10px;
    overflow: hidden;
}

.developer-info-board .card-header {
    border-radius: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .developer-info-board .col-lg-6 {
        margin-bottom: 1rem;
    }
    
    .team-stat {
        padding: 15px 5px;
    }
}
</style>

<script>
$(document).ready(function(){
    // Add some interactive effects
    $('.hover-card').hover(
        function() {
            $(this).find('.card-header i').addClass('fa-spin');
        },
        function() {
            $(this).find('.card-header i').removeClass('fa-spin');
        }
    );
    
    // Add tooltip to contact links
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
