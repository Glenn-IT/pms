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
        
        /* Header Navigation */
        .main-header {
            background: linear-gradient(to right, #001f3f, #003d7a);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100% !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
            left: 0 !important;
            right: 0 !important;
        }
        
        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
            width: 100% !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            flex-wrap: wrap;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            margin: 0 !important;
        }
        
        .site-title {
            color: white;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            flex: 1;
            min-width: 200px;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            max-width: 100%;
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
            white-space: nowrap;
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
            flex-wrap: wrap;
        }
        
        .user-name {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
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
            white-space: nowrap;
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
            justify-content: center;
            overflow-x: hidden !important;
            box-sizing: border-box;
        }
        
        /* Main Panel */
        .main-panel {
            width: 100%;
            max-width: 100%;
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
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Welcome Section */
        .welcome-section {
            text-align: center;
            margin-bottom: 2rem;
            max-width: 100%;
        }
        
        .welcome-section h3 {
            color: #001f3f;
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            margin-bottom: 0.5rem;
            word-wrap: break-word;
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
            max-width: 100%;
            overflow-x: hidden;
        }
        
        .user-info-card h4 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            word-wrap: break-word;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }
        
        .info-item {
            background: rgba(255,255,255,0.2);
            padding: 1rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            word-wrap: break-word;
            overflow-wrap: break-word;
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
            word-wrap: break-word;
            display: block;
        }
        
        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            max-width: 100%;
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
        
        /* Latest Updates Grid */
        .events-grid-latest {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
            width: 100%;
            max-width: 100%;
        }
        
        .latest-card {
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
        
        .latest-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .latest-card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }
        
        .latest-card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .latest-card-badge {
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
        
        .latest-card-title {
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
        
        .latest-card-description {
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
        
        .latest-card-date {
            color: #999;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: auto;
        }
        
        /* Feature Card */
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
            max-width: 100%;
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
            width: 100% !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            left: 0 !important;
            right: 0 !important;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }
        
        .footer-content p {
            color: #666;
            margin: 0.5rem auto;
            font-size: 0.95rem;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            word-break: break-word !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            padding: 0 1rem;
            width: calc(100% - 2rem) !important;
            display: block;
        }
        
        .footer-content strong {
            color: #001f3f;
            word-wrap: break-word !important;
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
            overflow: hidden;
            max-width: 100vw;
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
            max-width: 100%;
        }
        
        .modal-body {
            overflow-x: hidden;
            max-width: 100%;
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
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            max-width: 100%;
            width: 100%;
        }
        
        .event-card-modal {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
            max-width: 100%;
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
            word-wrap: break-word;
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
            max-width: 100%;
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
            max-width: 100%;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        .event-details-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.75rem;
            margin: 1rem 0;
            max-width: 100%;
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
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            max-width: 100%;
            width: 100%;
        }
        
        .announcement-card-modal {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
            max-width: 100%;
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
            word-wrap: break-word;
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
            max-width: 100%;
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
            max-width: 100%;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        .announcement-details-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.75rem;
            margin: 1rem 0;
            max-width: 100%;
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
        
        /* Statistics Modal Styles */
        .stats-card-modal {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .stats-progress {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            height: 30px;
            overflow: hidden;
            margin-top: 0.5rem;
        }
        
        .stats-progress-bar {
            background: white;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #001f3f;
            transition: width 0.5s ease;
        }
        
        .recent-attendance-list {
            list-style: none;
            padding: 0;
        }
        
        .recent-attendance-item {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-radius: 8px;
        }
        
        .recent-attendance-item h6 {
            color: #001f3f;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        
        .recent-attendance-item small {
            color: #666;
        }
        
        .zone-rank-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0.5rem 0;
        }
        
        .rank-1 { background: #ffd700; color: #333; }
        .rank-2 { background: #c0c0c0; color: #333; }
        .rank-3 { background: #cd7f32; color: white; }
        .rank-other { background: #007bff; color: white; }
        
        /* Sort Controls */
        .sort-controls {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            flex-wrap: wrap;
            max-width: 100%;
        }
        
        .sort-label {
            font-weight: 600;
            color: #001f3f;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .sort-select {
            padding: 0.5rem 1rem;
            border: 2px solid #001f3f;
            border-radius: 8px;
            background: white;
            color: #001f3f;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            min-width: 200px;
            max-width: 100%;
        }
        
        .sort-select:hover {
            background: #001f3f;
            color: white;
        }
        
        .sort-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.2);
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
        
        /* Laptop Specific Responsive - 1024px to 1366px */
        @media (min-width: 993px) and (max-width: 1366px) {
            .header-container {
                max-width: 100%;
                padding: 0 1.5rem;
            }
            
            .site-title {
                font-size: 0.95rem;
                min-width: 180px;
            }
            
            .nav-menu {
                gap: 0.25rem;
            }
            
            .nav-menu li a {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
            }
            
            .main-container {
                max-width: 100%;
                padding: 0 1.5rem;
                margin: 1.5rem auto;
            }
            
            .panel-body {
                padding: 1.5rem;
            }
            
            .user-info-card {
                padding: 1.5rem;
            }
            
            .info-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 0.75rem;
            }
            
            .features-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }
            
            .events-grid,
            .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 1rem;
            }
            
            .sort-controls {
                padding: 0.75rem;
            }
            
            .sort-select {
                min-width: 180px;
            }
        }
        
        /* Standard Laptop - 1024px */
        @media (min-width: 993px) and (max-width: 1199px) {
            .navbar {
                padding: 0.75rem 0;
            }
            
            .user-menu {
                margin-left: 0.5rem;
            }
            
            .user-name {
                font-size: 0.85rem;
            }
            
            .btn-logout-header {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
            
            .panel-header h2 {
                font-size: 1.5rem;
            }
            
            .feature-card i {
                font-size: 2.5rem;
            }
            
            .feature-card h5 {
                font-size: 1rem;
            }
            
            .feature-card p {
                font-size: 0.85rem;
            }
        }
        
        /* Wide Laptop - 1200px to 1366px */
        @media (min-width: 1200px) and (max-width: 1366px) {
            .main-container {
                max-width: 1200px;
            }
            
            .header-container {
                max-width: 1200px;
            }
        }
        
        /* Tablet Range */
        @media (min-width: 769px) and (max-width: 992px) {
            .navbar {
                padding: 0.75rem 0;
            }
            
            .site-title {
                font-size: 0.9rem;
            }
            
            .main-container {
                padding: 0 1.5rem;
            }
            
            .features-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
            
            .events-grid,
            .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .site-title {
                font-size: 0.85rem;
            }
            
            .search-filter-bar {
                padding: 1rem !important;
            }
            
            .search-filter-bar > div {
                flex-direction: column;
            }
            
            .search-filter-bar input,
            .search-filter-bar select,
            .search-filter-bar button {
                width: 100% !important;
                min-width: auto !important;
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
            
            .events-grid-latest {
                grid-template-columns: 1fr;
                gap: 1.5rem;
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
            
            .sort-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .sort-select {
                width: 100%;
                min-width: auto;
            }
            
            .events-grid,
            .announcements-grid {
                grid-template-columns: 1fr;
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
                YISMPC
            </div>
            
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="#" class="active"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="sk_officials.php"><i class="fas fa-user-tie"></i> SK Officials</a></li>
                <li><a href="forum.php"><i class="fas fa-comments"></i> Forum</a></li>
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
                <div style="text-align: center; margin-top: 1.5rem;">
                    <button class="btn btn-light btn-lg" onclick="showQRCode()" style="padding: 0.75rem 2rem; font-weight: 600;">
                        <i class="fas fa-qrcode"></i> Show My QR Code
                    </button>
                </div>
            </div>
            
            <!-- Banner Slideshow Section -->
            <section class="banner-section" id="bannerSection" style="display: none; margin-bottom: 3rem;">
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
            <section style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.75rem; font-weight: 700; color: #001f3f; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-newspaper" style="color: #003d7a;"></i>
                    What's the latest?
                </h3>
                
                <!-- Search and Filter Bar -->
                <div class="search-filter-bar" style="margin-bottom: 2rem; background: #f8f9fa; padding: 1.5rem; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                        <div style="flex: 1; min-width: 250px;">
                            <div style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #666;"></i>
                                <input type="text" id="searchInputUser" placeholder="Search by title or description..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 0.95rem; background: white; transition: all 0.3s;" onfocus="this.style.borderColor='#001f3f'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>
                        <div style="min-width: 200px;">
                            <select id="filterTypeUser" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 0.95rem; font-weight: 600; color: #001f3f; background: white; cursor: pointer; transition: all 0.3s;" onfocus="this.style.borderColor='#001f3f'" onblur="this.style.borderColor='#e0e0e0'">
                                <option value="all">All Updates</option>
                                <option value="event">Events Only</option>
                                <option value="announcement">Announcements Only</option>
                            </select>
                        </div>
                        <button onclick="clearSearchUser()" style="padding: 0.75rem 1.5rem; background: white; border: 2px solid #e0e0e0; border-radius: 10px; font-weight: 600; color: #666; cursor: pointer; transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                            <i class="fas fa-redo"></i> Clear
                        </button>
                    </div>
                    <div id="searchResultsUser" style="margin-top: 1rem; font-size: 0.9rem; color: #666; display: none;">
                        <i class="fas fa-info-circle"></i> <span id="searchResultsTextUser"></span>
                    </div>
                </div>
                
                <div class="events-grid-latest" id="latestGrid">
                    <div style="text-align: center; padding: 3rem 1rem; color: #999; grid-column: 1 / -1;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <h4 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: #666;">Loading Latest Updates...</h4>
                        <p>Please wait while we fetch the latest events and announcements</p>
                    </div>
                </div>
            </section>
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

<!-- Statistics Modal -->
<div class="modal fade" id="statisticsModal" tabindex="-1" role="dialog" aria-labelledby="statisticsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="statisticsModalLabel">
                    <i class="fas fa-chart-bar"></i> My Attendance Statistics
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4" id="statisticsModalBody">
                <div class="text-center py-3">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2">Loading Statistics...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Item Detail Modal (For both Events and Announcements) -->
<div class="modal fade" id="latestDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(to right, #001f3f, #003d7a); color: white; border: none;">
                <h5 class="modal-title" id="latestDetailModalTitle">
                    <i class="fas fa-info-circle"></i> Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="latestDetailModalBody">
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
    // Define base_url
    var _base_url_ = '<?php echo base_url ?>';
    
    // Store current sort preferences
    var eventSortBy = 'newest';
    var announcementSortBy = 'newest';
    
    // Store all events and announcements for sorting
    var allEvents = [];
    var allAnnouncements = [];
    
    // Banner slideshow variables
    var bannerData = [];
    var currentBannerIndex = 0;
    var bannerInterval = null;
    
    // Latest updates combined
    var latestEvents = [];
    var latestAnnouncements = [];
    
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
        
        stopBannerAutoplay();
        
        currentBannerIndex += direction;
        
        if (currentBannerIndex < 0) {
            currentBannerIndex = bannerData.length - 1;
        } else if (currentBannerIndex >= bannerData.length) {
            currentBannerIndex = 0;
        }
        
        updateBannerDisplay();
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
        $('.banner-slide').removeClass('active');
        $(`.banner-slide[data-index="${currentBannerIndex}"]`).addClass('active');
        
        $('.banner-thumbnail').removeClass('active');
        $('.banner-thumbnail').eq(currentBannerIndex).addClass('active');
        
        const thumbnail = $('.banner-thumbnail').eq(currentBannerIndex)[0];
        if (thumbnail) {
            thumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }
    
    // Start Banner Autoplay
    function startBannerAutoplay() {
        stopBannerAutoplay();
        
        if (bannerData.length <= 1) return;
        
        bannerInterval = setInterval(function() {
            currentBannerIndex++;
            if (currentBannerIndex >= bannerData.length) {
                currentBannerIndex = 0;
            }
            updateBannerDisplay();
        }, 5000);
    }
    
    // Stop Banner Autoplay
    function stopBannerAutoplay() {
        if (bannerInterval) {
            clearInterval(bannerInterval);
            bannerInterval = null;
        }
    }
    
    // Load Latest Updates
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
                latestEvents = eventsData;
                latestAnnouncements = announcementsData;
                const combinedItems = [...eventsData, ...announcementsData];
                
                if (combinedItems.length > 0) {
                    combinedItems.sort((a, b) => {
                        const dateA = new Date(a.date_created || a.date);
                        const dateB = new Date(b.date_created || b.date);
                        return dateB - dateA;
                    });
                    
                    // Store for search/filter
                    allLatestItems = combinedItems;
                    
                    displayLatestUpdates(combinedItems);
                } else {
                    $('#latestGrid').html(`
                        <div style="text-align: center; padding: 3rem 1rem; color: #999; grid-column: 1 / -1;">
                            <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <h4 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: #666;">No Updates Available</h4>
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
                <div class="latest-card" onclick="${isEvent ? 'showEventDetails(' + item.id + ')' : 'showAnnouncementDetails(' + item.id + ')'}">
                    <img src="${_base_url_}${primaryImage}" class="latest-card-image" alt="${item.title}">
                    <div class="latest-card-body">
                        <span class="latest-card-badge ${badgeClass}">
                            <i class="fas ${badgeIcon}"></i>
                            ${badgeText}
                        </span>
                        <h3 class="latest-card-title">${item.title}</h3>
                        <p class="latest-card-description">${item.description}</p>
                        <div class="latest-card-date">
                            <i class="far fa-calendar"></i>
                            ${formattedDate}
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#latestGrid').html(html);
    }

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
                    allEvents = resp.data;
                    displayEvents(allEvents);
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
    
    function sortEvents(sortBy) {
        eventSortBy = sortBy;
        displayEvents(allEvents);
    }
    
    function displayEvents(events){
        // Create a copy to avoid modifying original array
        let sortedEvents = [...events];
        
        // Sort events based on selected option
        switch(eventSortBy) {
            case 'newest':
                sortedEvents.sort((a, b) => new Date(b.date_created || b.date) - new Date(a.date_created || a.date));
                break;
            case 'oldest':
                sortedEvents.sort((a, b) => new Date(a.date_created || a.date) - new Date(b.date_created || b.date));
                break;
            case 'title-asc':
                sortedEvents.sort((a, b) => a.title.localeCompare(b.title));
                break;
            case 'title-desc':
                sortedEvents.sort((a, b) => b.title.localeCompare(a.title));
                break;
        }
        
        // Add sort controls
        let html = `
            <div class="sort-controls">
                <span class="sort-label">
                    <i class="fas fa-sort"></i> Sort By:
                </span>
                <select class="sort-select" onchange="sortEvents(this.value)" id="eventSortSelect">
                    <option value="newest" ${eventSortBy === 'newest' ? 'selected' : ''}>Newest First</option>
                    <option value="oldest" ${eventSortBy === 'oldest' ? 'selected' : ''}>Oldest First</option>
                    <option value="title-asc" ${eventSortBy === 'title-asc' ? 'selected' : ''}>Title (A-Z)</option>
                    <option value="title-desc" ${eventSortBy === 'title-desc' ? 'selected' : ''}>Title (Z-A)</option>
                </select>
            </div>
        `;
        
        html += '<div class="events-grid">';
        
        sortedEvents.forEach(event => {
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
        // Use the latest detail modal
        $('#latestDetailModal').modal('show');
        $('#latestDetailModalBody').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>');
        
        // Find event in latestEvents
        const event = latestEvents.find(e => e.id == eventId);
        
        if (event) {
            displayItemDetails(event, 'event');
        } else {
            // Fallback to AJAX if not in cache
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=get_all_events',
                method: 'GET',
                dataType: 'json',
                success: function(resp){
                    if(resp.status === 'success'){
                        const foundEvent = resp.data.find(e => e.id == eventId);
                        if(foundEvent){
                            displayItemDetails(foundEvent, 'event');
                        } else {
                            $('#latestDetailModalBody').html('<div class="alert alert-danger">Event not found</div>');
                        }
                    }
                },
                error: function(){
                    $('#latestDetailModalBody').html('<div class="alert alert-danger">Failed to load event details</div>');
                }
            });
        }
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
                    allAnnouncements = resp.data;
                    displayAnnouncements(allAnnouncements);
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
    
    function sortAnnouncements(sortBy) {
        announcementSortBy = sortBy;
        displayAnnouncements(allAnnouncements);
    }
    
    function displayAnnouncements(announcements){
        // Create a copy to avoid modifying original array
        let sortedAnnouncements = [...announcements];
        
        // Sort announcements based on selected option
        switch(announcementSortBy) {
            case 'newest':
                sortedAnnouncements.sort((a, b) => new Date(b.date_created || b.date) - new Date(a.date_created || a.date));
                break;
            case 'oldest':
                sortedAnnouncements.sort((a, b) => new Date(a.date_created || a.date) - new Date(b.date_created || b.date));
                break;
            case 'title-asc':
                sortedAnnouncements.sort((a, b) => a.title.localeCompare(b.title));
                break;
            case 'title-desc':
                sortedAnnouncements.sort((a, b) => b.title.localeCompare(a.title));
                break;
        }
        
        // Add sort controls
        let html = `
            <div class="sort-controls">
                <span class="sort-label">
                    <i class="fas fa-sort"></i> Sort By:
                </span>
                <select class="sort-select" onchange="sortAnnouncements(this.value)" id="announcementSortSelect">
                    <option value="newest" ${announcementSortBy === 'newest' ? 'selected' : ''}>Newest First</option>
                    <option value="oldest" ${announcementSortBy === 'oldest' ? 'selected' : ''}>Oldest First</option>
                    <option value="title-asc" ${announcementSortBy === 'title-asc' ? 'selected' : ''}>Title (A-Z)</option>
                    <option value="title-desc" ${announcementSortBy === 'title-desc' ? 'selected' : ''}>Title (Z-A)</option>
                </select>
            </div>
        `;
        
        html += '<div class="announcements-grid">';
        
        sortedAnnouncements.forEach(announcement => {
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
        // Use the latest detail modal
        $('#latestDetailModal').modal('show');
        $('#latestDetailModalBody').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i></div>');
        
        // Find announcement in latestAnnouncements
        const announcement = latestAnnouncements.find(a => a.id == announcementId);
        
        if (announcement) {
            displayItemDetails(announcement, 'announcement');
        } else {
            // Fallback to AJAX if not in cache
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=get_all_announcements',
                method: 'GET',
                dataType: 'json',
                success: function(resp){
                    if(resp.status === 'success'){
                        const foundAnnouncement = resp.data.find(a => a.id == announcementId);
                        if(foundAnnouncement){
                            displayItemDetails(foundAnnouncement, 'announcement');
                        } else {
                            $('#latestDetailModalBody').html('<div class="alert alert-danger">Announcement not found</div>');
                        }
                    }
                },
                error: function(){
                    $('#latestDetailModalBody').html('<div class="alert alert-danger">Failed to load announcement details</div>');
                }
            });
        }
    }
    
    // Display item details (unified function for events and announcements)
    function displayItemDetails(item, type) {
        const images = item.images || [];
        const primaryImage = images[0] || item.image_path;
        
        const itemDate = new Date(item.date_created || item.date);
        const formattedDate = itemDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const isEvent = type === 'event';
        const icon = isEvent ? 'fa-calendar-alt' : 'fa-bullhorn';
        const color = isEvent ? 'primary' : 'success';
        
        let html = '<div style="max-width: 100%; overflow-x: hidden;">';
        
        // Main image
        if (primaryImage) {
            html += `<img src="${_base_url_}${primaryImage}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 1.5rem;" alt="${item.title}">`;
        }
        
        // Badge and Title
        html += `
            <div style="margin-bottom: 1rem;">
                <span class="latest-card-badge ${isEvent ? 'badge-event' : 'badge-announcement'}">
                    <i class="fas ${icon}"></i>
                    ${isEvent ? 'Event' : 'Announcement'}
                </span>
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #001f3f; margin-bottom: 1rem;">${item.title}</h2>
            <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px; flex-wrap: wrap;">
                <span><i class="far fa-calendar text-${color}"></i> <strong>Published:</strong> ${formattedDate}</span>
                ${images.length > 1 ? `<span><i class="fas fa-images text-info"></i> <strong>${images.length}</strong> photos</span>` : ''}
            </div>
        `;
        
        // Description
        html += `
            <div style="margin-bottom: 1.5rem;">
                <h5 style="color: #001f3f; margin-bottom: 1rem;"><i class="fas fa-align-left"></i> Description</h5>
                <p style="white-space: pre-wrap; line-height: 1.8; color: #333;">${item.description}</p>
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
        
        $('#latestDetailModalTitle').html(`<i class="fas ${icon}"></i> ${isEvent ? 'Event' : 'Announcement'} Details`);
        $('#latestDetailModalBody').html(html);
    }
    
    function showStatistics(){
        $('#statisticsModal').modal('show');
        
        // Load statistics via AJAX
        $.ajax({
            url: '<?= base_url ?>classes/Master.php?f=get_user_statistics',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    displayStatistics(resp.data);
                } else {
                    $('#statisticsModalBody').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle"></i> Failed to load statistics
                        </div>
                    `);
                }
            },
            error: function(){
                $('#statisticsModalBody').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Error loading statistics
                    </div>
                `);
            }
        });
    }
    
    function displayStatistics(stats){
        let html = '<div class="container-fluid">';
        
        // Overview Stats Cards
        html += '<div class="row mb-4">';
        
        // Total Events Attended
        html += `
            <div class="col-md-4">
                <div class="stats-card-modal" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                    <div class="stats-number">${stats.total_attended}</div>
                    <div class="stats-label">Events Attended</div>
                </div>
            </div>
        `;
        
        // Total Events Available
        html += `
            <div class="col-md-4">
                <div class="stats-card-modal" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                    <div class="stats-number">${stats.total_events}</div>
                    <div class="stats-label">Total Events</div>
                </div>
            </div>
        `;
        
        // Attendance Rate
        html += `
            <div class="col-md-4">
                <div class="stats-card-modal" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                    <div class="stats-number">${stats.attendance_rate}%</div>
                    <div class="stats-label">Attendance Rate</div>
                    <div class="stats-progress">
                        <div class="stats-progress-bar" style="width: ${stats.attendance_rate}%;">
                            ${stats.attendance_rate}%
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        html += '</div>';
        
        // Zone Ranking (if available)
        if(stats.zone_rank && stats.zone_rank > 0){
            html += '<div class="row mb-4">';
            html += '<div class="col-12">';
            html += `
                <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <h5 style="color: #001f3f; margin-bottom: 1rem;">
                        <i class="fas fa-trophy"></i> Your Zone Performance
                    </h5>
                    <p style="color: #666; margin-bottom: 1rem;">
                        Zone <?= $_settings->userdata('zone') ?> ranks 
                        <span class="zone-rank-badge ${stats.zone_rank === 1 ? 'rank-1' : stats.zone_rank === 2 ? 'rank-2' : stats.zone_rank === 3 ? 'rank-3' : 'rank-other'}">
                            #${stats.zone_rank}
                        </span>
                        out of ${stats.total_zones} zones
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <p style="margin: 0.5rem 0; color: #333;">
                                <i class="fas fa-users text-primary"></i> 
                                <strong>${stats.zone_members || 0}</strong> active members
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p style="margin: 0.5rem 0; color: #333;">
                                <i class="fas fa-calendar-check text-success"></i> 
                                <strong>${stats.zone_attendance || 0}</strong> total attendances
                            </p>
                        </div>
                    </div>
                </div>
            `;
            html += '</div>';
            html += '</div>';
        }
        
        // Two Column Layout for Lists
        html += '<div class="row">';
        
        // Recent Attendance Column
        html += '<div class="col-md-6">';
        html += `
            <h5 style="color: #001f3f; margin-bottom: 1rem;">
                <i class="fas fa-history"></i> Recent Attendance
            </h5>
        `;
        
        if(stats.recent_attendance && stats.recent_attendance.length > 0){
            html += '<ul class="recent-attendance-list">';
            stats.recent_attendance.forEach(function(item){
                html += `
                    <li class="recent-attendance-item">
                        <h6>${item.title}</h6>
                        <small>
                            <i class="fas fa-calendar text-primary"></i> Event Date: ${item.event_date}<br>
                            <i class="fas fa-clock text-success"></i> Scanned: ${item.scan_time}
                        </small>
                    </li>
                `;
            });
            html += '</ul>';
        } else {
            html += `
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No attendance records yet. Start attending events to build your history!
                </div>
            `;
        }
        
        html += '</div>';
        
        // Upcoming/Not Attended Events Column
        html += '<div class="col-md-6">';
        html += `
            <h5 style="color: #001f3f; margin-bottom: 1rem;">
                <i class="fas fa-calendar-plus"></i> Events Not Attended
            </h5>
        `;
        
        if(stats.upcoming_events && stats.upcoming_events.length > 0){
            html += '<ul class="recent-attendance-list">';
            stats.upcoming_events.forEach(function(item){
                html += `
                    <li class="recent-attendance-item" style="border-left-color: #dc3545;">
                        <h6>${item.title}</h6>
                        <small>
                            <i class="fas fa-calendar text-danger"></i> Event Date: ${item.date}
                        </small>
                    </li>
                `;
            });
            html += '</ul>';
        } else {
            html += `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Congratulations! You've attended all available events!
                </div>
            `;
        }
        
        html += '</div>';
        html += '</div>';
        
        html += '</div>';
        
        $('#statisticsModalBody').html(html);
    }
    
    // Overflow Detection for Debugging
    function checkForOverflow() {
        const body = document.body;
        const html = document.documentElement;
        
        const hasBodyOverflow = body.scrollWidth > window.innerWidth;
        const hasHtmlOverflow = html.scrollWidth > window.innerWidth;
        
        if (hasBodyOverflow || hasHtmlOverflow) {
            console.error('⚠️ HORIZONTAL OVERFLOW DETECTED!');
            console.log('Body scrollWidth:', body.scrollWidth, 'Window width:', window.innerWidth);
            console.log('HTML scrollWidth:', html.scrollWidth);
            console.log('Difference:', (body.scrollWidth - window.innerWidth) + 'px');
            
            // Find elements causing overflow
            const allElements = document.querySelectorAll('*');
            const overflowingElements = [];
            
            allElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (el.scrollWidth > window.innerWidth || rect.right > window.innerWidth || rect.left < 0) {
                    const computed = window.getComputedStyle(el);
                    overflowingElements.push({
                        element: el,
                        tag: el.tagName,
                        class: el.className,
                        id: el.id,
                        scrollWidth: el.scrollWidth,
                        offsetWidth: el.offsetWidth,
                        rectRight: Math.round(rect.right),
                        rectLeft: Math.round(rect.left),
                        windowWidth: window.innerWidth,
                        overflow: computed.overflow,
                        overflowX: computed.overflowX,
                        position: computed.position,
                        width: computed.width,
                        maxWidth: computed.maxWidth
                    });
                }
            });
            
            if (overflowingElements.length > 0) {
                console.warn('🔴 Elements causing overflow (' + overflowingElements.length + '):');
                overflowingElements.forEach(el => {
                    console.log('└─ ' + el.tag + (el.class ? '.' + el.class.split(' ')[0] : '') + 
                               (el.id ? '#' + el.id : ''), el);
                });
                
                // Highlight the problematic elements
                overflowingElements.forEach(item => {
                    if (item.element && item.element.style) {
                        item.element.style.outline = '3px solid red';
                    }
                });
            }
            
            return true;
        } else {
            console.log('✅ No horizontal overflow detected - Width: ' + window.innerWidth + 'px');
            return false;
        }
    }
    
    // Check on load
    $(window).on('load', function() {
        setTimeout(checkForOverflow, 500);
    });
    
    // Check on resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(checkForOverflow, 250);
    });
    
    // Make available globally for manual testing
    window.checkOverflow = checkForOverflow;
    
    // Search and Filter Functionality for Latest Updates
    let allLatestItems = [];
    
    // Search and Filter
    function searchAndFilterUser() {
        const searchTerm = $('#searchInputUser').val().toLowerCase();
        const filterType = $('#filterTypeUser').val();
        
        let filteredItems = allLatestItems;
        
        // Filter by type
        if (filterType !== 'all') {
            filteredItems = filteredItems.filter(item => item.type === filterType);
        }
        
        // Filter by search term
        if (searchTerm) {
            filteredItems = filteredItems.filter(item => {
                return item.title.toLowerCase().includes(searchTerm) || 
                       item.description.toLowerCase().includes(searchTerm);
            });
        }
        
        // Display results
        if (filteredItems.length > 0) {
            displayLatestUpdates(filteredItems);
            $('#searchResultsUser').show();
            $('#searchResultsTextUser').text(`Showing ${filteredItems.length} result${filteredItems.length !== 1 ? 's' : ''}`);
        } else {
            $('#latestGrid').html(`
                <div style="text-align: center; padding: 3rem 1rem; color: #999; grid-column: 1 / -1;">
                    <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <h4 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: #666;">No Results Found</h4>
                    <p>Try adjusting your search or filter criteria</p>
                </div>
            `);
            $('#searchResultsUser').show();
            $('#searchResultsTextUser').text('No results found');
        }
    }
    
    // Clear Search
    window.clearSearchUser = function() {
        $('#searchInputUser').val('');
        $('#filterTypeUser').val('all');
        $('#searchResultsUser').hide();
        if (allLatestItems.length > 0) {
            displayLatestUpdates(allLatestItems);
        }
    }
    
    // Attach event listeners
    $('#searchInputUser').on('input', searchAndFilterUser);
    $('#filterTypeUser').on('change', searchAndFilterUser);
</script>

</body>
</html>
