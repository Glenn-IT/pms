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
    <title><?php echo $_settings->info('name') ?> - SK Officials</title>
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
        
        /* SK Officials Organizational Chart */
        .org-chart {
            text-align: center;
            padding: 1rem;
        }
        
        .org-level {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            gap: 1.5rem;
        }
        
        .org-card {
            background: linear-gradient(135deg, #001f3f 0%, #003d7a 100%);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0,31,63,0.2);
            color: white;
            min-width: 200px;
            max-width: 250px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .org-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,31,63,0.3);
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-width: 280px;
            max-width: 300px;
        }
        
        .secretary-card {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }
        
        .treasurer-card {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        }
        
        .kagawad-card {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            min-width: 180px;
            max-width: 220px;
        }
        
        .org-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            border: 3px solid rgba(255,255,255,0.3);
            overflow: hidden;
            background: rgba(255,255,255,0.1);
        }
        
        .org-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .org-icon i {
            font-size: 2.5rem;
            line-height: 74px;
            color: white;
        }
        
        .org-title {
            font-size: 1.3em;
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .org-name {
            font-size: 1.1em;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .org-contact {
            font-size: 0.85em;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }
        
        .org-email {
            font-size: 0.8em;
            opacity: 0.8;
            word-break: break-all;
        }
        
        .connection-line {
            height: 3px;
            background: linear-gradient(to right, transparent, #001f3f, transparent);
            margin: 1.5rem auto;
            width: 80%;
            position: relative;
        }
        
        .section-title {
            text-align: center;
            color: #001f3f;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #001f3f, #003d7a);
            border-radius: 2px;
        }
        
        .loading-spinner {
            text-align: center;
            padding: 3rem;
            color: #001f3f;
        }
        
        .loading-spinner i {
            font-size: 3rem;
            margin-bottom: 1rem;
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
            
            .org-level {
                flex-direction: column;
                align-items: center;
            }
            
            .org-card {
                max-width: 100%;
                width: 100%;
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
                <li><a href="sk_officials.php" class="active"><i class="fas fa-user-tie"></i> SK Officials</a></li>
                <li><a href="#"><i class="fas fa-comments"></i> Forum</a></li>
                <li><a href="about_us.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="developers.php"><i class="fas fa-code"></i> Developers</a></li>
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
            <h2><i class="fas fa-user-tie"></i> SK Officials</h2>
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="panel-body">
            <div class="org-chart" id="skOfficialsChart">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading SK Officials...</p>
                </div>
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
        loadSKOfficials();
    });

    function logout(){
        if(confirm('Are you sure you want to logout?')){
            start_loader();
            $.ajax({
                url: '<?= base_url ?>classes/Login.php?f=user_logout',
                method: 'POST',
                success: function(resp){
                    location.href = '<?= base_url ?>user/guest.php';
                }
            });
        }
    }
    
    function toggleMobileMenu(){
        $('#navMenu').toggleClass('active');
    }
    
    function loadSKOfficials() {
        $.ajax({
            url: '<?= base_url ?>admin/skofficials/manage_officials.php?f=get_all_officials',
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if(resp.status === 'success') {
                    displaySKOfficials(resp.data);
                } else {
                    $('#skOfficialsChart').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            No SK Officials data available at the moment.
                        </div>
                    `);
                }
            },
            error: function() {
                $('#skOfficialsChart').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> 
                        Failed to load SK Officials data.
                    </div>
                `);
            }
        });
    }
    
    function displaySKOfficials(officials) {
        let html = '';
        
        // Chairman Section
        if(officials.chairman) {
            html += `
                <div class="section-title">
                    <i class="fas fa-crown"></i> SK Chairman
                </div>
                <div class="org-level">
                    ${renderOfficialCard(officials.chairman, 'chairman', 'SK Chairman')}
                </div>
                <div class="connection-line"></div>
            `;
        }
        
        // Secretary and Treasurer
        html += `
            <div class="section-title">
                <i class="fas fa-users"></i> Executive Officers
            </div>
            <div class="org-level">
        `;
        
        if(officials.secretary) {
            html += renderOfficialCard(officials.secretary, 'secretary', 'Secretary');
        }
        
        if(officials.treasurer) {
            html += renderOfficialCard(officials.treasurer, 'treasurer', 'Treasurer');
        }
        
        html += '</div><div class="connection-line"></div>';
        
        // Kagawads
        const kagawadCount = [1, 2, 3, 4].filter(i => officials['kagawad' + i]).length;
        
        if(kagawadCount > 0) {
            html += `
                <div class="section-title">
                    <i class="fas fa-user-friends"></i> SK Kagawads
                </div>
                <div class="org-level">
            `;
            
            for(let i = 1; i <= 4; i++) {
                if(officials['kagawad' + i]) {
                    html += renderOfficialCard(officials['kagawad' + i], 'kagawad', 'Kagawad ' + i);
                }
            }
            
            html += '</div>';
        }
        
        $('#skOfficialsChart').html(html);
    }
    
    function renderOfficialCard(official, type, title) {
        const imageUrl = official.image 
            ? `<?= base_url ?>${official.image.startsWith('uploads/') ? official.image : 'uploads/sk_officials/' + official.image}`
            : null;
        
        let iconClass = 'fa-user';
        if(type === 'chairman') iconClass = 'fa-crown';
        else if(type === 'secretary') iconClass = 'fa-file-alt';
        else if(type === 'treasurer') iconClass = 'fa-coins';
        else if(type === 'kagawad') iconClass = 'fa-user-friends';
        
        return `
            <div class="org-card ${type}-card">
                <div class="org-icon">
                    ${imageUrl 
                        ? `<img src="${imageUrl}" alt="${official.name}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                           <i class="fas ${iconClass}" style="display:none;"></i>`
                        : `<i class="fas ${iconClass}"></i>`
                    }
                </div>
                <div class="org-title">${title}</div>
                <div class="org-name">${official.name}</div>
                <div class="org-contact">
                    <i class="fas fa-phone"></i> ${official.contact}
                </div>
                ${official.email ? `
                    <div class="org-email">
                        <i class="fas fa-envelope"></i> ${official.email}
                    </div>
                ` : ''}
            </div>
        `;
    }
</script>

</body>
</html>
