<?php
require_once('../config.php');
// No authentication required for guest page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $_settings->info('name') ?> - Welcome</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Prevent all elements from causing horizontal overflow */
        *:not(html):not(body) {
            max-width: 100%;
        }
        
        html {
            overflow-x: hidden;
            max-width: 100%;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden !important;
            max-width: 100vw !important;
            position: relative;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        
        /* Ensure all direct children of body respect width */
        body > * {
            max-width: 100vw !important;
            box-sizing: border-box !important;
        }
        
        /* Force all containers to respect viewport width */
        .container, .container-fluid, .row {
            max-width: 100% !important;
            overflow-x: hidden !important;
        }
        
        /* Prevent negative margins from Bootstrap rows */
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        .row > * {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        /* Bootstrap modal fixes */
        .modal {
            overflow-x: hidden !important;
        }
        
        .modal-dialog {
            max-width: calc(100vw - 2rem) !important;
            margin: 1rem auto !important;
        }
        
        .modal-xl {
            max-width: calc(100vw - 2rem) !important;
        }
        
        .modal-lg {
            max-width: calc(100vw - 2rem) !important;
        }
        
        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #001f3f 0%, #003d7a 100%);
            color: white;
            padding: 4rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            width: 100% !important;
            max-width: 100vw !important;
        }
        
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            opacity: 0.5;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .hero-banner h1 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            margin-bottom: 1rem;
            font-weight: 700;
            max-width: 100%;
            word-wrap: break-word;
        }
        
        .hero-banner p {
            font-size: clamp(1rem, 2vw, 1.25rem);
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 100%;
            word-wrap: break-word;
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn-login, .btn-register {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
        }
        
        .btn-login {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        
        .btn-login:hover {
            background: white;
            color: #001f3f;
            transform: translateY(-2px);
            text-decoration: none;
        }
        
        .btn-register {
            background: #28a745;
            color: white;
            border: 2px solid #28a745;
        }
        
        .btn-register:hover {
            background: #218838;
            border-color: #218838;
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }
        
        /* Main Container */
        .main-container {
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 2rem auto;
            padding: 0 1rem;
            overflow-x: hidden !important;
        }
        
        /* Banner Slideshow Styles */
        .banner-section {
            margin-bottom: 3rem;
            width: 100%;
        }
        
        .banner-slideshow {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .main-banner-container {
            position: relative;
            width: 100%;
            height: 450px;
            overflow: hidden;
            background: #000;
        }
        
        .main-banner {
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        .banner-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            flex-direction: column;
        }
        
        .banner-slide.active {
            opacity: 1;
            z-index: 1;
        }
        
        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .banner-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
            color: white;
            padding: 2rem 2rem 1.5rem;
            transform: translateY(0);
            transition: transform 0.3s;
        }
        
        .banner-info h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .banner-info p {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .banner-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #001f3f;
            transition: all 0.3s;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .banner-nav:hover {
            background: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .banner-nav.prev {
            left: 1rem;
        }
        
        .banner-nav.next {
            right: 1rem;
        }
        
        .thumbnail-container {
            display: flex;
            gap: 1rem;
            padding: 1.5rem;
            overflow-x: auto;
            background: #f8f9fa;
            scrollbar-width: thin;
            scrollbar-color: #001f3f #e9ecef;
        }
        
        .thumbnail-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .thumbnail-container::-webkit-scrollbar-track {
            background: #e9ecef;
            border-radius: 4px;
        }
        
        .thumbnail-container::-webkit-scrollbar-thumb {
            background: #001f3f;
            border-radius: 4px;
        }
        
        .thumbnail-container::-webkit-scrollbar-thumb:hover {
            background: #003d7a;
        }
        
        .banner-thumbnail {
            flex: 0 0 150px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
            border: 3px solid transparent;
        }
        
        .banner-thumbnail:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .banner-thumbnail.active {
            border-color: #001f3f;
            box-shadow: 0 0 0 2px white, 0 0 0 5px #001f3f;
        }
        
        .banner-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .banner-thumbnail-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,31,63,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .banner-thumbnail:hover .banner-thumbnail-overlay {
            opacity: 1;
        }
        
        .banner-thumbnail.active .banner-thumbnail-overlay {
            opacity: 0;
        }
        
        .banner-thumbnail-text {
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
            padding: 0.5rem;
        }
        
        /* Section Titles */
        .section-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            color: #001f3f;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .section-title i {
            color: #003d7a;
        }
        
        /* Grid Layouts */
        .events-grid, .announcements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
            width: 100%;
            max-width: 100%;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            max-width: 100%;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }
        
        .card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .card-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            width: fit-content;
        }
        
        .badge-event {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .badge-announcement {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #001f3f;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-wrap: break-word;
            max-width: 100%;
        }
        
        .card-description {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
            word-wrap: break-word;
            max-width: 100%;
        }
        
        .card-date {
            color: #999;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: auto;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #999;
            grid-column: 1 / -1;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #666;
        }
        
        /* Footer */
        .footer-section {
            background: transparent;
            padding: 2rem 1rem;
            text-align: center;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }
        
        .footer-content {
            max-width: 1400px;
            width: 100% !important;
            margin: 0 auto;
            overflow-x: hidden !important;
        }
        
        .footer-content p {
            color: #666;
            margin: 0.5rem 0;
            font-size: 0.95rem;
            max-width: calc(100% - 2rem) !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            display: block;
            margin-left: auto;
            margin-right: auto;
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
        
        /* Tablet Responsive (769px - 992px) */
        @media (min-width: 769px) and (max-width: 992px) {
            .events-grid, .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 1.5rem;
            }
        }
        
        /* Laptop Small (993px - 1199px) */
        @media (min-width: 993px) and (max-width: 1199px) {
            .events-grid, .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 1.5rem;
            }
            
            .main-container {
                max-width: 95%;
            }
        }
        
        /* Laptop Wide (1200px - 1366px) */
        @media (min-width: 1200px) and (max-width: 1366px) {
            .events-grid, .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
            
            .main-container {
                max-width: 98%;
            }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-banner {
                padding: 2rem 1rem;
            }
            
            .main-banner-container {
                height: 300px;
            }
            
            .banner-info {
                padding: 1rem;
            }
            
            .banner-info h3 {
                font-size: 1.1rem;
            }
            
            .banner-info p {
                font-size: 0.85rem;
            }
            
            .banner-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .banner-nav.prev {
                left: 0.5rem;
            }
            
            .banner-nav.next {
                right: 0.5rem;
            }
            
            .thumbnail-container {
                padding: 1rem;
                gap: 0.5rem;
            }
            
            .banner-thumbnail {
                flex: 0 0 100px;
                height: 70px;
            }
            
            .events-grid, .announcements-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .auth-buttons {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .main-container {
                margin: 1rem auto;
            }
            
            .main-banner-container {
                height: 250px;
            }
            
            .banner-thumbnail {
                flex: 0 0 80px;
                height: 60px;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Hero Banner -->
<section class="hero-banner">
    <div class="hero-content">
        <h1><i class="fas fa-handshake"></i> Welcome to YOUTH INFORMATION SYSTEM OF BARANGAY MAGUILLING, PIAT, CAGAYAN</h1>
        <p>Stay connected with the latest events and announcements from the Sangguniang Kabataan of Maguilling, Piat, Cagayan</p>
        
        <div class="auth-buttons">
            <a href="login.php" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="register.php" class="btn-register">
                <i class="fas fa-user-plus"></i> Register
            </a>
        </div>
    </div>
</section>

<!-- Main Container -->
<div class="main-container">
    <!-- Banner Slideshow Section -->
    <section class="banner-section" id="bannerSection" style="display: none;">
        <div class="banner-slideshow">
            <div class="main-banner-container">
                <div class="main-banner" id="mainBanner">
                    <!-- Main banner image will load here -->
                </div>
                <button class="banner-nav prev" onclick="changeBanner(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="banner-nav next" onclick="changeBanner(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="thumbnail-container" id="thumbnailContainer">
                <!-- Thumbnails will load here -->
            </div>
        </div>
    </section>

    <!-- What's the Latest Section -->
    <section>
        <h2 class="section-title">
            <i class="fas fa-newspaper"></i>
            What's the latest?
        </h2>
        <div class="events-grid" id="latestGrid">
            <div class="empty-state">
                <i class="fas fa-spinner fa-spin"></i>
                <h3>Loading Latest Updates...</h3>
                <p>Please wait while we fetch the latest events and announcements</p>
            </div>
        </div>
    </section>
    
    <!-- Footer Section (Integrated in Main Container) -->
    <section class="footer-section">
        <div class="footer-content">
            <p><strong>Youth Information System</strong> - Maguilling, Piat, Cagayan</p>
            <p>&copy; <?php echo date('Y') ?> Sangguniang Kabataan. All Rights Reserved.</p>
            <p style="font-size: 0.85rem; color: #999;">Developed for SK Community Management</p>
        </div>
    </section>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="detailModalTitle">
                    <i class="fas fa-info-circle"></i> Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="detailModalBody">
                <!-- Content loads here -->
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    var _base_url_ = '<?php echo base_url ?>';
    
    let allEvents = [];
    let allAnnouncements = [];
    let bannerData = [];
    let currentBannerIndex = 0;
    let bannerInterval = null;
    
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
        loadBanners();
        loadLatestUpdates();
    });
    
    // Load Active Banners
    function loadBanners() {
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=get_active_banners',
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success' && resp.data.length > 0) {
                    bannerData = resp.data;
                    displayBanners();
                    startBannerAutoplay();
                }
            },
            error: function(err) {
                console.log('Error loading banners:', err);
            }
        });
    }
    
    // Display Banners
    function displayBanners() {
        if (bannerData.length === 0) return;
        
        $('#bannerSection').show();
        
        let mainHtml = '';
        let thumbHtml = '';
        
        bannerData.forEach((banner, index) => {
            const imagePath = banner.image_path ? _base_url_ + banner.image_path : _base_url_ + 'assets/images/placeholder.jpg';
            const isActive = index === 0 ? 'active' : '';
            
            // Main banner slide
            mainHtml += `
                <div class="banner-slide ${isActive}" data-index="${index}">
                    <img src="${imagePath}" alt="${banner.title}">
                    <div class="banner-info">
                        <h3>${banner.title}</h3>
                        ${banner.description ? `<p>${banner.description}</p>` : ''}
                    </div>
                </div>
            `;
            
            // Thumbnail
            thumbHtml += `
                <div class="banner-thumbnail ${isActive}" onclick="selectBanner(${index})">
                    <img src="${imagePath}" alt="${banner.title}">
                    <div class="banner-thumbnail-overlay">
                        <div class="banner-thumbnail-text">${banner.title}</div>
                    </div>
                </div>
            `;
        });
        
        $('#mainBanner').html(mainHtml);
        $('#thumbnailContainer').html(thumbHtml);
    }
    
    // Change Banner
    window.changeBanner = function(direction) {
        if (bannerData.length === 0) return;
        
        // Stop autoplay when user manually navigates
        stopBannerAutoplay();
        
        currentBannerIndex += direction;
        
        if (currentBannerIndex < 0) {
            currentBannerIndex = bannerData.length - 1;
        } else if (currentBannerIndex >= bannerData.length) {
            currentBannerIndex = 0;
        }
        
        updateBannerDisplay();
        
        // Restart autoplay after 5 seconds
        setTimeout(startBannerAutoplay, 5000);
    }
    
    // Select Banner by Index
    window.selectBanner = function(index) {
        if (bannerData.length === 0) return;
        
        stopBannerAutoplay();
        currentBannerIndex = index;
        updateBannerDisplay();
        setTimeout(startBannerAutoplay, 5000);
    }
    
    // Update Banner Display
    function updateBannerDisplay() {
        // Update main slides
        $('.banner-slide').removeClass('active');
        $(`.banner-slide[data-index="${currentBannerIndex}"]`).addClass('active');
        
        // Update thumbnails
        $('.banner-thumbnail').removeClass('active');
        $('.banner-thumbnail').eq(currentBannerIndex).addClass('active');
        
        // Scroll thumbnail into view
        const thumbnail = $('.banner-thumbnail').eq(currentBannerIndex)[0];
        if (thumbnail) {
            thumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }
    
    // Start Banner Autoplay
    function startBannerAutoplay() {
        stopBannerAutoplay(); // Clear any existing interval
        
        if (bannerData.length <= 1) return;
        
        bannerInterval = setInterval(function() {
            currentBannerIndex++;
            if (currentBannerIndex >= bannerData.length) {
                currentBannerIndex = 0;
            }
            updateBannerDisplay();
        }, 5000); // Change banner every 5 seconds
    }
    
    // Stop Banner Autoplay
    function stopBannerAutoplay() {
        if (bannerInterval) {
            clearInterval(bannerInterval);
            bannerInterval = null;
        }
    }
    
    // Load Latest Updates (Events and Announcements combined)
    function loadLatestUpdates() {
        let eventsLoaded = false;
        let announcementsLoaded = false;
        let eventsData = [];
        let announcementsData = [];
        
        // Load Events
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=get_all_events',
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success' && resp.data.length > 0) {
                    eventsData = resp.data.map(item => ({...item, type: 'event'}));
                }
                eventsLoaded = true;
                checkAndDisplay();
            },
            error: function() {
                eventsLoaded = true;
                checkAndDisplay();
            }
        });
        
        // Load Announcements
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=get_all_announcements',
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success' && resp.data.length > 0) {
                    announcementsData = resp.data.map(item => ({...item, type: 'announcement'}));
                }
                announcementsLoaded = true;
                checkAndDisplay();
            },
            error: function() {
                announcementsLoaded = true;
                checkAndDisplay();
            }
        });
        
        function checkAndDisplay() {
            if (eventsLoaded && announcementsLoaded) {
                // Combine both arrays
                allEvents = eventsData;
                allAnnouncements = announcementsData;
                const combinedItems = [...eventsData, ...announcementsData];
                
                if (combinedItems.length > 0) {
                    // Sort by date_created in descending order (newest first)
                    combinedItems.sort((a, b) => {
                        const dateA = new Date(a.date_created || a.date);
                        const dateB = new Date(b.date_created || b.date);
                        return dateB - dateA; // Descending order
                    });
                    
                    displayLatestUpdates(combinedItems);
                } else {
                    $('#latestGrid').html(`
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No Updates Available</h3>
                            <p>Check back later for new events and announcements</p>
                        </div>
                    `);
                }
            }
        }
    }
    
    // Display Latest Updates
    function displayLatestUpdates(items) {
        let html = '';
        
        items.forEach(item => {
            const images = item.images || [];
            const primaryImage = images[0] || item.image_path || _base_url_ + 'assets/images/placeholder.jpg';
            
            const itemDate = new Date(item.date_created || item.date);
            const formattedDate = itemDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
            
            const isEvent = item.type === 'event';
            const badgeClass = isEvent ? 'badge-event' : 'badge-announcement';
            const badgeIcon = isEvent ? 'fa-calendar-alt' : 'fa-bullhorn';
            const badgeText = isEvent ? 'Event' : 'Announcement';
            
            html += `
                <div class="card" onclick="showDetail(${item.id}, '${item.type}')">
                    <img src="${_base_url_}${primaryImage}" class="card-image" alt="${item.title}">
                    <div class="card-body">
                        <span class="card-badge ${badgeClass}">
                            <i class="fas ${badgeIcon}"></i>
                            ${badgeText}
                        </span>
                        <h3 class="card-title">${item.title}</h3>
                        <p class="card-description">${item.description}</p>
                        <div class="card-date">
                            <i class="far fa-calendar"></i>
                            ${formattedDate}
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#latestGrid').html(html);
    }
    
    // Show Detail Modal
    function showDetail(id, type) {
        const data = type === 'event' 
            ? allEvents.find(e => e.id == id) 
            : allAnnouncements.find(a => a.id == id);
        
        if (!data) return;
        
        const images = data.images || [];
        const primaryImage = images[0] || data.image_path;
        
        const itemDate = new Date(data.date_created || data.date);
        const formattedDate = itemDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        let html = '<div style="max-width: 100%; overflow-x: hidden;">';
        
        // Main image
        if (primaryImage) {
            html += `<img src="${_base_url_}${primaryImage}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 1.5rem;" alt="${data.title}">`;
        }
        
        // Badge and Title
        html += `
            <div style="margin-bottom: 1rem;">
                <span class="card-badge ${type === 'event' ? 'badge-event' : 'badge-announcement'}">
                    <i class="fas ${type === 'event' ? 'fa-calendar-alt' : 'fa-bullhorn'}"></i>
                    ${type === 'event' ? 'Event' : 'Announcement'}
                </span>
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #001f3f; margin-bottom: 1rem;">${data.title}</h2>
            <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px; flex-wrap: wrap;">
                <span><i class="far fa-calendar text-primary"></i> <strong>Published:</strong> ${formattedDate}</span>
                ${images.length > 1 ? `<span><i class="fas fa-images text-info"></i> <strong>${images.length}</strong> photos</span>` : ''}
            </div>
        `;
        
        // Description
        html += `
            <div style="margin-bottom: 1.5rem;">
                <h5 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-align-left"></i> Description</h5>
                <p style="white-space: pre-wrap; line-height: 1.8; color: #333;">${data.description}</p>
            </div>
        `;
        
        // Gallery
        if (images.length > 1) {
            html += `
                <h5 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-images"></i> Photo Gallery (${images.length} photos)</h5>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
            `;
            
            images.forEach(img => {
                html += `<img src="${_base_url_}${img}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; cursor: pointer; transition: transform 0.3s;" onclick="window.open('${_base_url_}${img}', '_blank')" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="Gallery image">`;
            });
            
            html += '</div>';
        }
        
        html += '</div>';
        
        $('#detailModalTitle').html(`<i class="fas ${type === 'event' ? 'fa-calendar-alt' : 'fa-bullhorn'}"></i> ${type === 'event' ? 'Event' : 'Announcement'} Details`);
        $('#detailModalBody').html(html);
        $('#detailModal').modal('show');
    }
</script>

</body>
</html>
