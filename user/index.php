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
    <title><?php echo $_settings->info('name') ?> - User Portal</title>
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
            display: flex;
            gap: 2rem;
        }
        
        /* Sidebar */
        .sidebar {
            width: 80px;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 1.5rem 0.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        
        /* Main Panel */
        .main-panel {
            flex: 1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .panel-header {
            background: linear-gradient(to right, #001f3f, #003d7a);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 3px solid rgba(255,255,255,0.3);
        }
        
        .panel-header h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            margin: 0;
            font-weight: 700;
        }
        
        .panel-body {
            padding: 2rem;
        }
        
        /* Welcome Section */
        .welcome-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .welcome-section h3 {
            color: #001f3f;
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            margin-bottom: 0.5rem;
        }
        
        .welcome-section p {
            color: #666;
            font-size: 1rem;
        }
        
        /* User Info Card */
        .user-info-card {
            background: linear-gradient(to right, #001f3f, #003d7a);
            border-radius: 15px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,31,63,0.3);
        }
        
        .user-info-card h4 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .info-item {
            background: rgba(255,255,255,0.2);
            padding: 1rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        
        .info-item strong {
            display: block;
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }
        
        .info-item span {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .feature-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,123,255,0.2);
            border-color: #007bff;
        }
        
        .feature-card i {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 1rem;
        }
        
        .feature-card h5 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .feature-card p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
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
        
        /* Modal Styles */
        .modal-content {
            border: none;
        }
        
        .modal .close {
            opacity: 1;
            text-shadow: none;
        }
        
        .modal .close:hover {
            opacity: 0.8;
        }
        
        /* Button in User Info Card */
        .user-info-card .btn-light {
            transition: all 0.3s;
        }
        
        .user-info-card .btn-light:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255,255,255,0.3);
        }
        
        /* Events Modal Styles */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .event-card-modal {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .event-card-modal:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .event-img-modal {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f5f5f5;
        }
        
        .event-body-modal {
            padding: 1.25rem;
        }
        
        .event-title-modal {
            font-size: 1.1rem;
            font-weight: 600;
            color: #001f3f;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .event-date-modal {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .event-date-modal i {
            color: #007bff;
        }
        
        .event-desc-modal {
            font-size: 0.95rem;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.75rem;
        }
        
        .event-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .event-details-content {
            padding: 1rem;
            max-height: 70vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .event-details-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .event-details-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .event-details-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .event-details-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .event-details-img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        .event-details-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.75rem;
            margin: 1rem 0;
        }
        
        .event-details-gallery img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .event-details-gallery img:hover {
            transform: scale(1.05);
        }
        
        /* Announcements Modal Styles (same as events) */
        .announcements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .announcement-card-modal {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .announcement-card-modal:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .announcement-img-modal {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f5f5f5;
        }
        
        .announcement-body-modal {
            padding: 1.25rem;
        }
        
        .announcement-title-modal {
            font-size: 1.1rem;
            font-weight: 600;
            color: #001f3f;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .announcement-date-modal {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .announcement-date-modal i {
            color: #28a745;
        }
        
        .announcement-desc-modal {
            font-size: 0.95rem;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.75rem;
        }
        
        .announcement-details-content {
            padding: 1rem;
            max-height: 70vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .announcement-details-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .announcement-details-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .announcement-details-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .announcement-details-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .announcement-details-img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        .announcement-details-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.75rem;
            margin: 1rem 0;
        }
        
        .announcement-details-gallery img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .announcement-details-gallery img:hover {
            transform: scale(1.05);
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
            
            .main-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                position: static;
                display: flex;
                justify-content: space-around;
                padding: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .site-title {
                font-size: 0.85rem;
            }
            
            .panel-header {
                padding: 1rem 1.5rem;
            }
            
            .panel-body {
                padding: 1.5rem 1rem;
            }
            
            .user-info-card {
                padding: 1.5rem 1rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .features-grid {
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
                <li><a href="#" class="active"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="#"><i class="fas fa-user-tie"></i> SK Officials</a></li>
                <li><a href="#"><i class="fas fa-comments"></i> Forum</a></li>
                <li><a href="#"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="#"><i class="fas fa-code"></i> Developers</a></li>
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
    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Sidebar content can be added here -->
    </aside>
    
    <!-- Main Panel -->
    <main class="main-panel">
        <div class="panel-header">
            <h2><i class="fas fa-tachometer-alt"></i> User Dashboard</h2>
        </div>
        
        <div class="panel-body">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h3>Welcome back, <?php echo $_settings->userdata('firstname') ?>!</h3>
                <p>You are successfully logged into the SK Youth Information System</p>
            </div>
            
            <!-- User Info Card -->
            <div class="user-info-card">
                <h4><i class="fas fa-id-card"></i> Your Information</h4>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Full Name</strong>
                        <span><?php echo $_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname') ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Username</strong>
                        <span><?php echo $_settings->userdata('username') ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Zone/Purok</strong>
                        <span>Zone <?php echo $_settings->userdata('zone') ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Account Type</strong>
                        <span>SK Member</span>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-light btn-lg" onclick="showQRCode()" style="border: 2px solid white; font-weight: 600;">
                        <i class="fas fa-qrcode"></i> Show My QR Code
                    </button>
                </div>
            </div>
            
            <!-- Features Grid -->
            <div class="features-grid">
                <div class="feature-card" onclick="showEvents()">
                    <i class="fas fa-calendar-alt"></i>
                    <h5>Events</h5>
                    <p>View upcoming SK events and activities</p>
                </div>
                
                <div class="feature-card" onclick="showAnnouncements()">
                    <i class="fas fa-bullhorn"></i>
                    <h5>Announcements</h5>
                    <p>Stay updated with latest announcements</p>
                </div>
                
                <div class="feature-card">
                    <i class="fas fa-qrcode"></i>
                    <h5>QR Code</h5>
                    <p>Your unique QR code for attendance</p>
                </div>
                
                <div class="feature-card">
                    <i class="fas fa-user-edit"></i>
                    <h5>Profile</h5>
                    <p>Update your personal information</p>
                </div>
                
                <div class="feature-card">
                    <i class="fas fa-chart-bar"></i>
                    <h5>Statistics</h5>
                    <p>View your attendance and participation</p>
                </div>
                
                <div class="feature-card">
                    <i class="fas fa-envelope"></i>
                    <h5>Messages</h5>
                    <p>Check your inbox and notifications</p>
                </div>
            </div>
            
            <!-- Info Alert -->
            <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #007bff;">
                <i class="fas fa-info-circle"></i> <strong>Coming Soon:</strong> More features are being developed to enhance your experience with the SK Youth Information System.
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="main-footer">
    <div class="footer-content">
        <p><strong>Youth Information System</strong> - Maguilling, Piat, Cagayan</p>
        <p>&copy; <?php echo date('Y') ?> Sangguniang Kabataan. All Rights Reserved.</p>
        <p style="font-size: 0.85rem; color: #999;">Developed for SK Community Management</p>
    </div>
</footer>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="qrCodeModalLabel">
                    <i class="fas fa-qrcode"></i> My Personal QR Code
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4" id="qrModalBody">
                <div class="text-center py-3">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2">Loading QR Code...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Events Modal -->
<div class="modal fade" id="eventsModal" tabindex="-1" role="dialog" aria-labelledby="eventsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="eventsModalLabel">
                    <i class="fas fa-calendar-alt"></i> SK Events & Activities
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4" id="eventsModalBody">
                <div class="text-center py-3">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2">Loading Events...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="eventDetailsModalLabel">
                    <i class="fas fa-info-circle"></i> Event Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4" id="eventDetailsBody">
                <!-- Event details will load here -->
            </div>
        </div>
    </div>
</div>

<!-- Announcements Modal -->
<div class="modal fade" id="announcementsModal" tabindex="-1" role="dialog" aria-labelledby="announcementsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="announcementsModalLabel">
                    <i class="fas fa-bullhorn"></i> SK Announcements
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4" id="announcementsModalBody">
                <div class="text-center py-3">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2">Loading Announcements...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcement Details Modal -->
<div class="modal fade" id="announcementDetailsModal" tabindex="-1" role="dialog" aria-labelledby="announcementDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="announcementDetailsModalLabel">
                    <i class="fas fa-info-circle"></i> Announcement Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4" id="announcementDetailsBody">
                <!-- Announcement details will load here -->
            </div>
        </div>
    </div>
</div>

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
    
    function showQRCode(){
        $('#qrCodeModal').modal('show');
        
        // Load QR code data via AJAX
        $.ajax({
            url: '<?= base_url ?>user/get_qr_code.php',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    displayQRCode(resp.data);
                } else {
                    $('#qrModalBody').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${resp.message || 'QR Code not found'}
                        </div>
                        <p class="text-muted">Your QR code will be generated automatically. Please contact the administrator if this issue persists.</p>
                    `);
                }
            },
            error: function(){
                $('#qrModalBody').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Failed to load QR Code
                    </div>
                `);
            }
        });
    }
    
    function displayQRCode(data){
        const qrImageUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(data.qr_code)}`;
        
        const html = `
            <div style="padding: 20px;">
                <div style="background: white; padding: 20px; border-radius: 10px; display: inline-block; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <img src="${qrImageUrl}" alt="QR Code" style="width: 300px; height: 300px; display: block;">
                </div>
                
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="mb-3"><i class="fas fa-barcode text-primary"></i> QR Code Text</h6>
                    <div style="font-family: 'Courier New', monospace; font-size: 14px; font-weight: bold; color: #2c3e50; word-break: break-all; background: #fff; padding: 15px; border-radius: 8px; border: 2px dashed #007bff;">
                        ${data.qr_code}
                    </div>
                    <button class="btn btn-primary btn-sm mt-3" onclick="copyQRText('${data.qr_code}')">
                        <i class="fas fa-copy"></i> Copy QR Code
                    </button>
                </div>
                
                <div class="mt-3 text-left">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> <strong>How to use:</strong> Show this QR code for attendance verification at SK events.
                    </small>
                </div>
            </div>
        `;
        
        $('#qrModalBody').html(html);
    }
    
    function copyQRText(text){
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        
        try {
            document.execCommand('copy');
            alert('QR Code copied to clipboard!');
        } catch (err) {
            alert('Failed to copy QR Code');
        }
        
        document.body.removeChild(textarea);
    }
    
    function showEvents(){
        $('#eventsModal').modal('show');
        
        // Load events via AJAX
        $.ajax({
            url: '<?= base_url ?>classes/Master.php?f=get_all_events',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success' && resp.data.length > 0){
                    displayEvents(resp.data);
                } else {
                    $('#eventsModalBody').html(`
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No events available at the moment</p>
                        </div>
                    `);
                }
            },
            error: function(){
                $('#eventsModalBody').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Failed to load events
                    </div>
                `);
            }
        });
    }
    
    function displayEvents(events){
        // Sort events by date (newest first)
        events.sort((a, b) => new Date(b.date_created || b.date) - new Date(a.date_created || a.date));
        
        let html = '<div class="events-grid">';
        
        events.forEach(event => {
            const images = event.images || [];
            const primaryImage = images[0] || event.image_path || '<?= base_url ?>assets/images/placeholder.jpg';
            const imageCount = images.length || (event.image_path ? 1 : 0);
            
            // Format date
            const eventDate = new Date(event.date_created || event.date);
            const formattedDate = eventDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Check if event is upcoming
            const today = new Date();
            const isUpcoming = eventDate > today;
            const isPast = eventDate < today;
            
            html += `
                <div class="event-card-modal" onclick="showEventDetails(${event.id})">
                    <img src="<?= base_url ?>${primaryImage}" class="event-img-modal" alt="${event.title}">
                    <div class="event-body-modal">
                        <div class="event-title-modal">${event.title}</div>
                        <div class="event-date-modal">
                            <i class="fas fa-calendar-alt"></i> ${formattedDate}
                        </div>
                        <div class="event-desc-modal">${event.description}</div>
                        <div>
                            ${isUpcoming ? '<span class="event-badge bg-primary text-white">Upcoming</span>' : ''}
                            ${isPast ? '<span class="event-badge bg-secondary text-white">Past Event</span>' : ''}
                            ${imageCount > 1 ? `<span class="event-badge bg-info text-white ml-2"><i class="fas fa-images"></i> ${imageCount} photos</span>` : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        $('#eventsModalBody').html(html);
    }
    
    function showEventDetails(eventId){
        // Close events modal and open details modal
        $('#eventsModal').modal('hide');
        $('#eventDetailsModal').modal('show');
        $('#eventDetailsBody').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>');
        
        // Load event details
        $.ajax({
            url: '<?= base_url ?>classes/Master.php?f=get_all_events',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    const event = resp.data.find(e => e.id == eventId);
                    if(event){
                        displayEventDetails(event);
                    } else {
                        $('#eventDetailsBody').html('<div class="alert alert-danger">Event not found</div>');
                    }
                }
            },
            error: function(){
                $('#eventDetailsBody').html('<div class="alert alert-danger">Failed to load event details</div>');
            }
        });
        
        // When details modal is hidden, show events modal again
        $('#eventDetailsModal').off('hidden.bs.modal').on('hidden.bs.modal', function() {
            $('#eventsModal').modal('show');
        });
    }
    
    function displayEventDetails(event){
        const images = event.images || [];
        const primaryImage = images[0] || event.image_path;
        
        // Format date
        const eventDate = new Date(event.date_created || event.date);
        const formattedDate = eventDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        let html = '<div class="event-details-content">';
        
        // Main image
        if(primaryImage){
            html += `<img src="<?= base_url ?>${primaryImage}" class="event-details-img" alt="${event.title}">`;
        }
        
        // Event info
        html += `
            <h4 style="color: #001f3f; margin-bottom: 1rem;">${event.title}</h4>
            <p style="color: #666; margin-bottom: 1rem;">
                <i class="fas fa-calendar-alt text-primary"></i> <strong>Date:</strong> ${formattedDate}
            </p>
            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <h6 style="color: #001f3f; margin-bottom: 0.5rem;"><i class="fas fa-info-circle"></i> Description</h6>
                <p style="color: #333; margin: 0;">${event.description}</p>
            </div>
        `;
        
        // Image gallery
        if(images.length > 1){
            html += `
                <h6 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-images"></i> Event Gallery (${images.length} photos)</h6>
                <div class="event-details-gallery">
            `;
            
            images.forEach(img => {
                html += `<img src="<?= base_url ?>${img}" alt="Event photo" onclick="window.open('<?= base_url ?>${img}', '_blank')">`;
            });
            
            html += '</div>';
        }
        
        html += '</div>';
        
        $('#eventDetailsBody').html(html);
    }
    
    function showAnnouncements(){
        $('#announcementsModal').modal('show');
        
        // Load announcements via AJAX
        $.ajax({
            url: '<?= base_url ?>classes/Master.php?f=get_all_announcements',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success' && resp.data.length > 0){
                    displayAnnouncements(resp.data);
                } else {
                    $('#announcementsModalBody').html(`
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No announcements available at the moment</p>
                        </div>
                    `);
                }
            },
            error: function(){
                $('#announcementsModalBody').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Failed to load announcements
                    </div>
                `);
            }
        });
    }
    
    function displayAnnouncements(announcements){
        // Sort announcements by date (newest first)
        announcements.sort((a, b) => new Date(b.date_created || b.date) - new Date(a.date_created || a.date));
        
        let html = '<div class="announcements-grid">';
        
        announcements.forEach(announcement => {
            const images = announcement.images || [];
            const primaryImage = images[0] || announcement.image_path || '<?= base_url ?>assets/images/placeholder.jpg';
            const imageCount = images.length || (announcement.image_path ? 1 : 0);
            
            // Format date
            const announcementDate = new Date(announcement.date_created || announcement.date);
            const formattedDate = announcementDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Check if announcement is new (within last 7 days)
            const today = new Date();
            const daysDiff = Math.floor((today - announcementDate) / (1000 * 60 * 60 * 24));
            const isNew = daysDiff <= 7;
            
            html += `
                <div class="announcement-card-modal" onclick="showAnnouncementDetails(${announcement.id})">
                    <img src="<?= base_url ?>${primaryImage}" class="announcement-img-modal" alt="${announcement.title}">
                    <div class="announcement-body-modal">
                        <div class="announcement-title-modal">${announcement.title}</div>
                        <div class="announcement-date-modal">
                            <i class="fas fa-calendar-alt"></i> ${formattedDate}
                        </div>
                        <div class="announcement-desc-modal">${announcement.description}</div>
                        <div>
                            ${isNew ? '<span class="event-badge bg-success text-white">New</span>' : ''}
                            ${imageCount > 1 ? `<span class="event-badge bg-info text-white ml-2"><i class="fas fa-images"></i> ${imageCount} photos</span>` : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        $('#announcementsModalBody').html(html);
    }
    
    function showAnnouncementDetails(announcementId){
        // Close announcements modal and open details modal
        $('#announcementsModal').modal('hide');
        $('#announcementDetailsModal').modal('show');
        $('#announcementDetailsBody').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>');
        
        // Load announcement details
        $.ajax({
            url: '<?= base_url ?>classes/Master.php?f=get_all_announcements',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    const announcement = resp.data.find(a => a.id == announcementId);
                    if(announcement){
                        displayAnnouncementDetails(announcement);
                    } else {
                        $('#announcementDetailsBody').html('<div class="alert alert-danger">Announcement not found</div>');
                    }
                }
            },
            error: function(){
                $('#announcementDetailsBody').html('<div class="alert alert-danger">Failed to load announcement details</div>');
            }
        });
        
        // When details modal is hidden, show announcements modal again
        $('#announcementDetailsModal').off('hidden.bs.modal').on('hidden.bs.modal', function() {
            $('#announcementsModal').modal('show');
        });
    }
    
    function displayAnnouncementDetails(announcement){
        const images = announcement.images || [];
        const primaryImage = images[0] || announcement.image_path;
        
        // Format date
        const announcementDate = new Date(announcement.date_created || announcement.date);
        const formattedDate = announcementDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        let html = '<div class="announcement-details-content">';
        
        // Main image
        if(primaryImage){
            html += `<img src="<?= base_url ?>${primaryImage}" class="announcement-details-img" alt="${announcement.title}">`;
        }
        
        // Announcement info
        html += `
            <h4 style="color: #001f3f; margin-bottom: 1rem;">${announcement.title}</h4>
            <p style="color: #666; margin-bottom: 1rem;">
                <i class="fas fa-calendar-alt text-success"></i> <strong>Posted:</strong> ${formattedDate}
            </p>
            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <h6 style="color: #001f3f; margin-bottom: 0.5rem;"><i class="fas fa-info-circle"></i> Description</h6>
                <p style="color: #333; margin: 0; white-space: pre-wrap;">${announcement.description}</p>
            </div>
        `;
        
        // Image gallery
        if(images.length > 1){
            html += `
                <h6 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-images"></i> Gallery (${images.length} photos)</h6>
                <div class="announcement-details-gallery">
            `;
            
            images.forEach(img => {
                html += `<img src="<?= base_url ?>${img}" alt="Announcement photo" onclick="window.open('<?= base_url ?>${img}', '_blank')">`;
            });
            
            html += '</div>';
        }
        
        html += '</div>';
        
        $('#announcementDetailsBody').html(html);
    }
</script>

</body>
</html>
