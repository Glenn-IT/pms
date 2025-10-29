<?php
require_once('../config.php');
if($_settings->userdata('id') <= 0 || $_settings->userdata('type') != 2){
    redirect('user/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $_settings->info('name') ?> - Developers</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header Navigation */
        .main-header {
            background: linear-gradient(to right, #001f3f, #003d7a);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            flex-wrap: wrap;
        }
        
        .site-title {
            color: white;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            flex: 1;
            min-width: 200px;
        }
        
        .site-title i {
            margin-right: 0.5rem;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .nav-menu li a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.95rem;
            display: block;
        }
        
        .nav-menu li a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        .nav-menu li a.active {
            background: rgba(255,255,255,0.3);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            margin-left: 1rem;
        }
        
        .user-name {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-logout-header {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .btn-logout-header:hover {
            background: white;
            color: #001f3f;
            transform: translateY(-2px);
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: 2px solid white;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
        }
        
        /* Main Container */
        .main-container {
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        /* Main Panel */
        .main-panel {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .panel-header {
            background: linear-gradient(to right, #001f3f, #003d7a);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 3px solid rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .panel-header h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            margin: 0;
            font-weight: 700;
        }
        
        .back-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .back-btn:hover {
            background: white;
            color: #001f3f;
            text-decoration: none;
        }
        
        .panel-body {
            padding: 2rem;
        }
        
        /* Team Stats */
        .team-stats {
            background: linear-gradient(135deg, #001f3f 0%, #003d7a 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0,31,63,0.2);
        }
        
        .team-stats h4 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }
        
        .stat-item h5 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        
        .stat-item small {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Developer Cards */
        .dev-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .dev-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        
        .dev-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
        }
        
        .dev-card.kim {
            border-top: 5px solid #17a2b8;
        }
        
        .dev-card.cristel {
            border-top: 5px solid #ffc107;
        }
        
        .dev-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            text-align: center;
        }
        
        .dev-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .dev-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .dev-avatar i {
            font-size: 3rem;
            line-height: 92px;
            color: #001f3f;
        }
        
        .dev-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #001f3f;
            margin-bottom: 0.5rem;
        }
        
        .dev-body {
            padding: 2rem;
        }
        
        .dev-detail {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .dev-detail i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .dev-detail span {
            flex: 1;
            color: #333;
        }
        
        /* Technologies Section */
        .tech-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .tech-section h4 {
            color: #001f3f;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1.5rem;
        }
        
        .tech-item {
            padding: 1rem;
        }
        
        .tech-item i {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        
        .tech-item small {
            display: block;
            color: #666;
            font-weight: 600;
        }
        
        /* Quote Section */
        .quote-section {
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            border-left: 4px solid #001f3f;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .quote-section p {
            color: #666;
            font-style: italic;
            margin: 0;
            font-size: 1rem;
        }
        
        /* Footer */
        .main-footer {
            background: rgba(255,255,255,0.95);
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            margin-top: auto;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .footer-content p {
            color: #666;
            margin: 0.5rem 0;
            font-size: 0.95rem;
        }
        
        .footer-content strong {
            color: #001f3f;
        }
        
        /* Loader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0,0,0,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .loader-holder {
            display: flex;
            gap: 12px;
        }
        
        .loader-holder div {
            width: 18px;
            height: 18px;
            background: linear-gradient(to right, #001f3f, #003d7a);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        
        .loader-holder div:nth-child(1) { animation-delay: -0.32s; }
        .loader-holder div:nth-child(2) { animation-delay: -0.16s; }
        .loader-holder div:nth-child(3) { animation-delay: 0s; }
        .loader-holder div:nth-child(4) { animation-delay: 0.16s; }
        
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        
        /* Mobile Responsive */
        @media (max-width: 992px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .nav-menu {
                display: none;
                width: 100%;
                flex-direction: column;
                margin-top: 1rem;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .nav-menu li a {
                width: 100%;
                text-align: center;
            }
            
            .user-menu {
                width: 100%;
                justify-content: center;
                margin: 1rem 0 0 0;
            }
        }
        
        @media (max-width: 768px) {
            .site-title {
                font-size: 0.85rem;
            }
            
            .panel-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }
            
            .panel-body {
                padding: 1.5rem 1rem;
            }
            
            .dev-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .main-container {
                margin: 1rem auto;
            }
            
            .user-name {
                font-size: 0.9rem;
            }
            
            .btn-logout-header {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="main-header">
    <div class="header-container">
        <nav class="navbar">
            <div class="site-title">
                <i class="fas fa-users"></i>
                YOUTH INFORMATION SYSTEM OF MAGUILLING, PIAT, CAGAYAN
            </div>
            
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="sk_officials.php"><i class="fas fa-user-tie"></i> SK Officials</a></li>
                <li><a href="#"><i class="fas fa-comments"></i> Forum</a></li>
                <li><a href="about_us.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="developers.php" class="active"><i class="fas fa-code"></i> Developers</a></li>
            </ul>
            
            <div class="user-menu">
                <span class="user-name">
                    <i class="fas fa-user-circle"></i>
                    <?php echo $_settings->userdata('firstname') ?>
                </span>
                <button class="btn-logout-header" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </nav>
    </div>
</header>

<!-- Main Container -->
<div class="main-container">
    <!-- Main Panel -->
    <div class="main-panel">
        <div class="panel-header">
            <h2><i class="fas fa-code"></i> Development Team</h2>
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="panel-body">
            <!-- Team Stats -->
            <div class="team-stats">
                <h4><i class="fas fa-users-cog"></i> Our Development Team</h4>
                <div class="stats-row">
                    <div class="stat-item">
                        <h5>2</h5>
                        <small>Developers</small>
                    </div>
                    <div class="stat-item">
                        <h5>BSIT</h5>
                        <small>Program</small>
                    </div>
                    <div class="stat-item">
                        <h5>CSU</h5>
                        <small>University</small>
                    </div>
                </div>
            </div>
            
            <!-- Developer Cards -->
            <div class="dev-grid">
                <!-- Kimberly Agustin -->
                <div class="dev-card kim">
                    <div class="dev-header">
                        <div class="dev-avatar">
                            <img src="<?= base_url ?>Kim.jpg" alt="Kimberly Agustin" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <i class="fas fa-user" style="display:none;"></i>
                        </div>
                        <div class="dev-name">Kimberly Agustin</div>
                    </div>
                    <div class="dev-body">
                        <div class="dev-detail">
                            <i class="fas fa-graduation-cap text-primary"></i>
                            <span>BS Information Technology</span>
                        </div>
                        <div class="dev-detail">
                            <i class="fas fa-university text-success"></i>
                            <span>CSU - Piat Campus</span>
                        </div>
                        <div class="dev-detail">
                            <i class="fas fa-phone text-info"></i>
                            <span>09359505884</span>
                        </div>
                        <div class="dev-detail">
                            <i class="fas fa-envelope text-danger"></i>
                            <span>agustinkimberly27@gmail.com</span>
                        </div>
                    </div>
                </div>
                
                <!-- Cristel Pulig -->
                <div class="dev-card cristel">
                    <div class="dev-header">
                        <div class="dev-avatar">
                            <img src="<?= base_url ?>Cristel.jpg" alt="Cristel Pulig" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <i class="fas fa-user" style="display:none;"></i>
                        </div>
                        <div class="dev-name">Cristel Pulig</div>
                    </div>
                    <div class="dev-body">
                        <div class="dev-detail">
                            <i class="fas fa-graduation-cap text-primary"></i>
                            <span>BS Information Technology</span>
                        </div>
                        <div class="dev-detail">
                            <i class="fas fa-university text-success"></i>
                            <span>CSU - Piat Campus</span>
                        </div>
                        <div class="dev-detail">
                            <i class="fas fa-phone text-info"></i>
                            <span>09674513768</span>
                        </div>
                        <div class="dev-detail">
                            <i class="fas fa-envelope text-danger"></i>
                            <span>cristelpulig770@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Technologies Used -->
            <div class="tech-section">
                <h4><i class="fas fa-tools"></i> Technologies Used</h4>
                <div class="tech-grid">
                    <div class="tech-item">
                        <i class="fab fa-php text-primary"></i>
                        <small>PHP</small>
                    </div>
                    <div class="tech-item">
                        <i class="fab fa-js-square text-warning"></i>
                        <small>JavaScript</small>
                    </div>
                    <div class="tech-item">
                        <i class="fab fa-bootstrap" style="color: #7952b3;"></i>
                        <small>Bootstrap</small>
                    </div>
                    <div class="tech-item">
                        <i class="fas fa-database text-success"></i>
                        <small>MySQL</small>
                    </div>
                </div>
            </div>
            
            <!-- Quote -->
            <div class="quote-section">
                <p>
                    <i class="fas fa-quote-left"></i>
                    Dedicated to creating innovative solutions for community management and youth engagement.
                    <i class="fas fa-quote-right"></i>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="main-footer">
    <div class="footer-content">
        <p><strong>Youth Information System</strong> - Maguilling, Piat, Cagayan</p>
        <p>&copy; <?php echo date('Y') ?> Sangguniang Kabataan. All Rights Reserved.</p>
        <p style="font-size: 0.85rem; color: #999;">Developed for SK Community Management</p>
    </div>
</footer>

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    // Define base_url
    var _base_url_ = '<?php echo base_url ?>';
    
    // Loader functions
    window.start_loader = function(){
        $('body').append('<div id="preloader"><div class="loader-holder"><div></div><div></div><div></div><div></div></div></div>');
    }
    window.end_loader = function(){
        $('#preloader').fadeOut('fast', function() {
            $(this).remove();
        });
    }

    $(document).ready(function(){
        end_loader();
    });

    function logout(){
        if(confirm('Are you sure you want to logout?')){
            start_loader();
            $.ajax({
                url: '<?= base_url ?>classes/Login.php?f=user_logout',
                method: 'POST',
                success: function(resp){
                    location.href = '<?= base_url ?>user/login.php';
                }
            });
        }
    }
    
    function toggleMobileMenu(){
        $('#navMenu').toggleClass('active');
    }
</script>

</body>
</html>
