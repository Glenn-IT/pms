<?php
require_once('../config.php');
// No authentication required for guest page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $_settings->info('name') ?> - News & Updates</title>
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
        
        .auth-buttons {
            display: flex;
            gap: 0.75rem;
            margin-left: 1rem;
        }
        
        .btn-login, .btn-register {
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
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
        
        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #001f3f 0%, #003d7a 100%);
            color: white;
            padding: 3rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero-banner h1 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .hero-banner p {
            font-size: clamp(1rem, 2vw, 1.25rem);
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        /* Main Container */
        .main-container {
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        /* Tab Navigation */
        .tab-navigation {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .tab-btn {
            background: white;
            border: 2px solid #001f3f;
            color: #001f3f;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }
        
        .tab-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,31,63,0.3);
        }
        
        .tab-btn.active {
            background: linear-gradient(135deg, #001f3f 0%, #003d7a 100%);
            color: white;
        }
        
        .tab-btn i {
            margin-right: 0.5rem;
        }
        
        /* News Grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Article Card */
        .article-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }
        
        .article-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .article-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #e9ecef;
        }
        
        .article-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .article-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .article-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-event {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .badge-announcement {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .badge-new {
            background: #fff3e0;
            color: #f57c00;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .article-date {
            color: #666;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .article-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #001f3f;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .article-excerpt {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }
        
        .article-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
        
        .read-more {
            color: #007bff;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        
        .read-more:hover {
            color: #0056b3;
            gap: 0.75rem;
        }
        
        .article-stats {
            display: flex;
            gap: 1rem;
            color: #999;
            font-size: 0.85rem;
        }
        
        .article-stats span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Article Detail Modal */
        .modal-article-detail {
            padding: 2rem;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-article-detail::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-article-detail::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .modal-article-detail::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .modal-article-detail::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .detail-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .detail-header {
            margin-bottom: 1.5rem;
        }
        
        .detail-title {
            font-size: 2rem;
            font-weight: 700;
            color: #001f3f;
            margin-bottom: 1rem;
        }
        
        .detail-meta {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .detail-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .detail-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .detail-gallery img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .detail-gallery img:hover {
            transform: scale(1.05);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #999;
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
        
        .empty-state p {
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
            
            .auth-buttons {
                width: 100%;
                justify-content: center;
                margin: 1rem 0 0 0;
            }
        }
        
        @media (max-width: 768px) {
            .site-title {
                font-size: 0.85rem;
            }
            
            .hero-banner {
                padding: 2rem 1rem;
            }
            
            .news-grid {
                grid-template-columns: 1fr;
            }
            
            .detail-title {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .main-container {
                margin: 1rem auto;
            }
            
            .tab-btn {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
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
                <li><a href="guest.php" class="active"><i class="fas fa-newspaper"></i> News & Updates</a></li>
                <li><a href="about_us.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="developers.php"><i class="fas fa-code"></i> Developers</a></li>
            </ul>
            
            <div class="auth-buttons">
                <a href="login.php" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="register.php" class="btn-register">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        </nav>
    </div>
</header>

<!-- Hero Banner -->
<section class="hero-banner">
    <div class="hero-content">
        <h1><i class="fas fa-newspaper"></i> Latest News & Updates</h1>
        <p>Stay informed with the latest events, announcements, and activities from the SK of Maguilling</p>
    </div>
</section>

<!-- Main Container -->
<div class="main-container">
    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <button class="tab-btn active" data-tab="all" onclick="switchTab('all')">
            <i class="fas fa-th-large"></i> All Updates
        </button>
        <button class="tab-btn" data-tab="events" onclick="switchTab('events')">
            <i class="fas fa-calendar-alt"></i> Events
        </button>
        <button class="tab-btn" data-tab="announcements" onclick="switchTab('announcements')">
            <i class="fas fa-bullhorn"></i> Announcements
        </button>
    </div>
    
    <!-- News Grid -->
    <div class="news-grid" id="newsGrid">
        <div class="empty-state">
            <i class="fas fa-spinner fa-spin"></i>
            <h3>Loading...</h3>
            <p>Please wait while we fetch the latest updates</p>
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

<!-- Article Detail Modal -->
<div class="modal fade" id="articleModal" tabindex="-1" role="dialog" aria-labelledby="articleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="articleModalLabel">
                    <i class="fas fa-newspaper"></i> Article Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" id="articleModalBody">
                <!-- Article details will load here -->
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
    
    // Store all data
    let allEvents = [];
    let allAnnouncements = [];
    let currentTab = 'all';
    
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
        loadAllContent();
    });
    
    function toggleMobileMenu(){
        $('#navMenu').toggleClass('active');
    }
    
    function loadAllContent() {
        // Load both events and announcements
        Promise.all([
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=get_all_events',
                method: 'GET',
                dataType: 'json'
            }),
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=get_all_announcements',
                method: 'GET',
                dataType: 'json'
            })
        ]).then(([eventsResp, announcementsResp]) => {
            allEvents = eventsResp.status === 'success' ? eventsResp.data : [];
            allAnnouncements = announcementsResp.status === 'success' ? announcementsResp.data : [];
            displayContent();
        }).catch(error => {
            console.error('Error loading content:', error);
            $('#newsGrid').html(`
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Error Loading Content</h3>
                    <p>Failed to load news and updates. Please try again later.</p>
                </div>
            `);
        });
    }
    
    function switchTab(tab) {
        currentTab = tab;
        
        // Update active tab button
        $('.tab-btn').removeClass('active');
        $(`.tab-btn[data-tab="${tab}"]`).addClass('active');
        
        displayContent();
    }
    
    function displayContent() {
        let combinedData = [];
        
        // Filter based on current tab
        if (currentTab === 'all') {
            // Add events
            allEvents.forEach(event => {
                combinedData.push({...event, type: 'event'});
            });
            // Add announcements
            allAnnouncements.forEach(announcement => {
                combinedData.push({...announcement, type: 'announcement'});
            });
        } else if (currentTab === 'events') {
            allEvents.forEach(event => {
                combinedData.push({...event, type: 'event'});
            });
        } else if (currentTab === 'announcements') {
            allAnnouncements.forEach(announcement => {
                combinedData.push({...announcement, type: 'announcement'});
            });
        }
        
        // Sort by date (newest first)
        combinedData.sort((a, b) => {
            const dateA = new Date(a.date_created || a.date);
            const dateB = new Date(b.date_created || b.date);
            return dateB - dateA;
        });
        
        if (combinedData.length === 0) {
            $('#newsGrid').html(`
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Content Available</h3>
                    <p>There are no ${currentTab === 'all' ? 'updates' : currentTab} to display at the moment.</p>
                </div>
            `);
            return;
        }
        
        let html = '';
        
        combinedData.forEach(item => {
            const images = item.images || [];
            const primaryImage = images[0] || item.image_path || _base_url_ + 'assets/images/placeholder.jpg';
            
            // Format date
            const itemDate = new Date(item.date_created || item.date);
            const formattedDate = itemDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
            
            // Check if new (within last 7 days)
            const today = new Date();
            const daysDiff = Math.floor((today - itemDate) / (1000 * 60 * 60 * 24));
            const isNew = daysDiff <= 7;
            
            // Get image count
            const imageCount = images.length || (item.image_path ? 1 : 0);
            
            html += `
                <article class="article-card" onclick="showArticle(${item.id}, '${item.type}')">
                    <img src="${_base_url_}${primaryImage}" class="article-image" alt="${item.title}">
                    <div class="article-body">
                        <div class="article-meta">
                            <span class="article-badge ${item.type === 'event' ? 'badge-event' : 'badge-announcement'}">
                                <i class="fas ${item.type === 'event' ? 'fa-calendar-alt' : 'fa-bullhorn'}"></i>
                                ${item.type === 'event' ? 'Event' : 'Announcement'}
                            </span>
                            ${isNew ? '<span class="article-badge badge-new"><i class="fas fa-star"></i> New</span>' : ''}
                        </div>
                        <h3 class="article-title">${item.title}</h3>
                        <p class="article-excerpt">${item.description}</p>
                        <div class="article-footer">
                            <span class="article-date">
                                <i class="far fa-calendar"></i>
                                ${formattedDate}
                            </span>
                            ${imageCount > 1 ? `<div class="article-stats"><span><i class="fas fa-images"></i> ${imageCount}</span></div>` : ''}
                        </div>
                    </div>
                </article>
            `;
        });
        
        $('#newsGrid').html(html);
    }
    
    function showArticle(id, type) {
        const data = type === 'event' 
            ? allEvents.find(e => e.id == id) 
            : allAnnouncements.find(a => a.id == id);
        
        if (!data) return;
        
        const images = data.images || [];
        const primaryImage = images[0] || data.image_path;
        
        // Format date
        const itemDate = new Date(data.date_created || data.date);
        const formattedDate = itemDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        let html = '<div class="modal-article-detail">';
        
        // Main image
        if (primaryImage) {
            html += `<img src="${_base_url_}${primaryImage}" class="detail-image" alt="${data.title}">`;
        }
        
        // Header
        html += `
            <div class="detail-header">
                <div class="mb-3">
                    <span class="article-badge ${type === 'event' ? 'badge-event' : 'badge-announcement'}">
                        <i class="fas ${type === 'event' ? 'fa-calendar-alt' : 'fa-bullhorn'}"></i>
                        ${type === 'event' ? 'Event' : 'Announcement'}
                    </span>
                </div>
                <h2 class="detail-title">${data.title}</h2>
                <div class="detail-meta">
                    <span><i class="far fa-calendar text-primary"></i> <strong>Published:</strong> ${formattedDate}</span>
                    ${images.length > 1 ? `<span><i class="fas fa-images text-info"></i> <strong>${images.length}</strong> photos</span>` : ''}
                </div>
            </div>
        `;
        
        // Content
        html += `
            <div class="detail-content">
                <h5 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-align-left"></i> Description</h5>
                <p style="white-space: pre-wrap;">${data.description}</p>
            </div>
        `;
        
        // Gallery
        if (images.length > 1) {
            html += `
                <h5 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-images"></i> Photo Gallery (${images.length} photos)</h5>
                <div class="detail-gallery">
            `;
            
            images.forEach(img => {
                html += `<img src="${_base_url_}${img}" alt="Gallery image" onclick="window.open('${_base_url_}${img}', '_blank')">`;
            });
            
            html += '</div>';
        }
        
        html += '</div>';
        
        $('#articleModalBody').html(html);
        $('#articleModal').modal('show');
    }
</script>

</body>
</html>
