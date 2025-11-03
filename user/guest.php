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
        <h1><i class="fas fa-handshake"></i> Welcome to YISMPC</h1>
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
    <!-- Events Section -->
    <section>
        <h2 class="section-title">
            <i class="fas fa-calendar-alt"></i>
            Upcoming Events
        </h2>
        <div class="events-grid" id="eventsGrid">
            <div class="empty-state">
                <i class="fas fa-spinner fa-spin"></i>
                <h3>Loading Events...</h3>
                <p>Please wait while we fetch the latest events</p>
            </div>
        </div>
    </section>
    
    <!-- Announcements Section -->
    <section>
        <h2 class="section-title">
            <i class="fas fa-bullhorn"></i>
            Latest Announcements
        </h2>
        <div class="announcements-grid" id="announcementsGrid">
            <div class="empty-state">
                <i class="fas fa-spinner fa-spin"></i>
                <h3>Loading Announcements...</h3>
                <p>Please wait while we fetch the latest announcements</p>
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
        loadEvents();
        loadAnnouncements();
    });
    
    // Load Events
    function loadEvents() {
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=get_all_events',
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success' && resp.data.length > 0) {
                    allEvents = resp.data;
                    displayEvents();
                } else {
                    $('#eventsGrid').html(`
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>No Events Available</h3>
                            <p>Check back later for upcoming events</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#eventsGrid').html(`
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Error Loading Events</h3>
                        <p>Please try again later</p>
                    </div>
                `);
            }
        });
    }
    
    // Load Announcements
    function loadAnnouncements() {
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=get_all_announcements',
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success' && resp.data.length > 0) {
                    allAnnouncements = resp.data;
                    displayAnnouncements();
                } else {
                    $('#announcementsGrid').html(`
                        <div class="empty-state">
                            <i class="fas fa-bullhorn"></i>
                            <h3>No Announcements Available</h3>
                            <p>Check back later for new announcements</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#announcementsGrid').html(`
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Error Loading Announcements</h3>
                        <p>Please try again later</p>
                    </div>
                `);
            }
        });
    }
    
    // Display Events
    function displayEvents() {
        let html = '';
        
        allEvents.forEach(event => {
            const images = event.images || [];
            const primaryImage = images[0] || event.image_path || _base_url_ + 'assets/images/placeholder.jpg';
            
            const eventDate = new Date(event.date_created || event.date);
            const formattedDate = eventDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
            
            html += `
                <div class="card" onclick="showDetail(${event.id}, 'event')">
                    <img src="${_base_url_}${primaryImage}" class="card-image" alt="${event.title}">
                    <div class="card-body">
                        <span class="card-badge badge-event">
                            <i class="fas fa-calendar-alt"></i>
                            Event
                        </span>
                        <h3 class="card-title">${event.title}</h3>
                        <p class="card-description">${event.description}</p>
                        <div class="card-date">
                            <i class="far fa-calendar"></i>
                            ${formattedDate}
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#eventsGrid').html(html);
    }
    
    // Display Announcements
    function displayAnnouncements() {
        let html = '';
        
        allAnnouncements.forEach(announcement => {
            const images = announcement.images || [];
            const primaryImage = images[0] || announcement.image_path || _base_url_ + 'assets/images/placeholder.jpg';
            
            const announcementDate = new Date(announcement.date_created || announcement.date);
            const formattedDate = announcementDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
            
            html += `
                <div class="card" onclick="showDetail(${announcement.id}, 'announcement')">
                    <img src="${_base_url_}${primaryImage}" class="card-image" alt="${announcement.title}">
                    <div class="card-body">
                        <span class="card-badge badge-announcement">
                            <i class="fas fa-bullhorn"></i>
                            Announcement
                        </span>
                        <h3 class="card-title">${announcement.title}</h3>
                        <p class="card-description">${announcement.description}</p>
                        <div class="card-date">
                            <i class="far fa-calendar"></i>
                            ${formattedDate}
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#announcementsGrid').html(html);
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
