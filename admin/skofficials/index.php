<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .org-chart {
        text-align: center;
        padding: 20px;
    }
    
    .org-level {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    
    .org-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 20px;
        margin: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        color: white;
        min-width: 200px;
        max-width: 250px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .org-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.2);
    }
    
    .org-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }
    
    .chairman-card {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        min-width: 280px;
    }
    
    .secretary-card {
        background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
    }
    
    .treasurer-card {
        background: linear-gradient(135deg, #45b7d1 0%, #96c93d 100%);
    }
    
    .kagawad-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        min-width: 180px;
    }
    
    .org-icon {
        font-size: 3em;
        margin-bottom: 15px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .org-title {
        font-size: 1.4em;
        font-weight: bold;
        margin-bottom: 8px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    .org-name {
        font-size: 1.1em;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .org-contact {
        font-size: 0.9em;
        opacity: 0.9;
    }
    
    .connection-line {
        height: 2px;
        background: #ddd;
        margin: 20px auto;
        width: 80%;
        position: relative;
    }
    
    .connection-line::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        background: #667eea;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .kagawad-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 2.5em;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .page-header p {
        margin: 10px 0 0 0;
        font-size: 1.2em;
        opacity: 0.9;
    }
    
    .action-buttons {
        text-align: center;
        margin: 30px 0;
    }
    
    .btn-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 500;
        transition: transform 0.3s ease;
        margin: 0 10px;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    
    .btn-tool:hover {
        background-color: rgba(255,255,255,0.2);
        border-radius: 4px;
        color: #fff;
    }
    
    .close-button-hint {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    @media (max-width: 768px) {
        .org-level {
            flex-direction: column;
            align-items: center;
        }
        
        .kagawad-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header h1 {
            font-size: 2em;
        }
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> SK Officials Management</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="goBackToDashboard()" title="Back to Dashboard" data-toggle="tooltip" data-placement="left">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-sitemap"></i> Sangguniang Kabataan</h1>
            <p>Organizational Chart & Officials Directory</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-custom" onclick="manage_official('chairman')">
                <i class="fas fa-user-plus mr-2"></i>Manage Chairman
            </button>
            <button class="btn btn-custom" onclick="manage_official('secretary')">
                <i class="fas fa-user-edit mr-2"></i>Manage Secretary
            </button>
            <button class="btn btn-custom" onclick="manage_official('treasurer')">
                <i class="fas fa-coins mr-2"></i>Manage Treasurer
            </button>
            <button class="btn btn-custom" onclick="manage_kagawad()">
                <i class="fas fa-users-cog mr-2"></i>Manage Kagawads
            </button>
        </div>

        <!-- Organizational Chart -->
        <div class="org-chart">
            <!-- Chairman Level -->
            <div class="org-level">
                <div class="org-card chairman-card">
                    <div class="org-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="org-title">SK CHAIRMAN</div>
                    <div class="org-name" id="chairman-name">Juan Dela Cruz</div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="chairman-contact">0917-123-4567</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="chairman-email">chairman@sk.gov.ph</span>
                    </div>
                </div>
            </div>

            <div class="connection-line"></div>

            <!-- Secretary & Treasurer Level -->
            <div class="org-level">
                <div class="org-card secretary-card">
                    <div class="org-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="org-title">SK SECRETARY</div>
                    <div class="org-name" id="secretary-name">Maria Santos</div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="secretary-contact">0918-234-5678</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="secretary-email">secretary@sk.gov.ph</span>
                    </div>
                </div>

                <div class="org-card treasurer-card">
                    <div class="org-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="org-title">SK TREASURER</div>
                    <div class="org-name" id="treasurer-name">Pedro Garcia</div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="treasurer-contact">0919-345-6789</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="treasurer-email">treasurer@sk.gov.ph</span>
                    </div>
                </div>
            </div>

            <div class="connection-line"></div>

            <!-- Kagawads Level -->
            <div class="org-level">
                <h4 style="width: 100%; margin-bottom: 20px; color: #667eea;">
                    <i class="fas fa-users mr-2"></i>SK KAGAWADS
                </h4>
                <div class="kagawad-grid">
                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad1-name">Anna Reyes</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad1-contact">0920-456-7890</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad2-name">Carlos Lopez</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad2-contact">0921-567-8901</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad3-name">Sofia Martinez</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad3-contact">0922-678-9012</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad4-name">Miguel Torres</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad4-contact">0923-789-0123</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Office Address:</strong><br>
                            Barangay Hall, [Your Barangay Name]<br>
                            [City/Municipality, Province]</p>
                            
                            <p><strong>Office Hours:</strong><br>
                            Monday - Friday: 8:00 AM - 5:00 PM<br>
                            Saturday: 8:00 AM - 12:00 PM</p>
                            
                            <p><strong>General Hotline:</strong><br>
                            <i class="fas fa-phone mr-2"></i>(02) 8XXX-XXXX</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-bullseye mr-2"></i>Our Mission</h5>
                        </div>
                        <div class="card-body">
                            <p>To serve and represent the youth of our barangay by promoting their welfare, interests, and active participation in community development initiatives.</p>
                            
                            <p><strong>Core Values:</strong></p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success mr-2"></i>Leadership</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Integrity</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Service</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Excellence</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function manage_official(position) {
    alert('Manage ' + position.charAt(0).toUpperCase() + position.slice(1) + ' functionality to be implemented');
    // You can implement modal forms or redirect to management pages here
}

function manage_kagawad() {
    alert('Manage Kagawads functionality to be implemented');
    // You can implement modal forms or redirect to management pages here
}

function goBackToDashboard() {
    // Go back to the main dashboard/home page
    window.location.href = '?page=home';
}

// Add some interactive effects
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    $('.org-card').hover(
        function() {
            $(this).css('cursor', 'pointer');
        },
        function() {
            $(this).css('cursor', 'default');
        }
    );
    
    $('.org-card').click(function() {
        var title = $(this).find('.org-title').text();
        var name = $(this).find('.org-name').text();
        alert('Contact: ' + name + ' (' + title + ')');
        // You can implement detailed view modals here
    });
    
    // Show a brief hint about the close button
    setTimeout(function() {
        if ($('.btn-tool[title="Back to Dashboard"]').length) {
            $('.btn-tool[title="Back to Dashboard"]').tooltip('show');
            setTimeout(function() {
                $('.btn-tool[title="Back to Dashboard"]').tooltip('hide');
            }, 3000);
        }
    }, 1000);
});
</script>
