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
    <title><?php echo $_settings->info('name') ?> - Forum</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
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
            max-width: 1200px;
            width: 100%;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        /* Forum Container */
        .forum-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 220px);
            min-height: 500px;
        }
        
        .forum-header {
            background: linear-gradient(to right, #001f3f, #003d7a);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 3px solid rgba(255,255,255,0.3);
        }
        
        .forum-header h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            margin: 0;
            font-weight: 700;
        }
        
        .forum-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        /* Messages Area */
        .messages-area {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: #f8f9fa;
        }
        
        .messages-area::-webkit-scrollbar {
            width: 8px;
        }
        
        .messages-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .messages-area::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .messages-area::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Message Bubble */
        .message-bubble {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .message-content {
            flex: 1;
            background: white;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .message-user {
            font-weight: 700;
            color: #001f3f;
            font-size: 1rem;
        }
        
        .message-zone {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.15rem 0.6rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .message-time {
            color: #999;
            font-size: 0.85rem;
        }
        
        .message-text {
            color: #333;
            line-height: 1.6;
            word-wrap: break-word;
        }
        
        .message-actions {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
        }
        
        .btn-delete-msg {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: all 0.3s;
            opacity: 0;
        }
        
        .message-content:hover .btn-delete-msg {
            opacity: 1;
        }
        
        .btn-delete-msg:hover {
            background: #dc3545;
            color: white;
        }
        
        /* My Message (Current User) */
        .message-bubble.my-message {
            flex-direction: row-reverse;
        }
        
        .message-bubble.my-message .message-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .message-bubble.my-message .message-user {
            color: white;
        }
        
        .message-bubble.my-message .message-text {
            color: white;
        }
        
        .message-bubble.my-message .message-time {
            color: rgba(255,255,255,0.8);
        }
        
        .message-bubble.my-message .message-zone {
            background: rgba(255,255,255,0.3);
            color: white;
        }
        
        .message-bubble.my-message .btn-delete-msg {
            color: white;
        }
        
        .message-bubble.my-message .btn-delete-msg:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Input Area */
        .input-area {
            padding: 1.5rem;
            background: white;
            border-top: 2px solid #e9ecef;
        }
        
        .input-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }
        
        .input-wrapper {
            flex: 1;
            position: relative;
        }
        
        #messageInput {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            resize: none;
            min-height: 50px;
            max-height: 120px;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        #messageInput:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-send {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-send:active {
            transform: translateY(0);
        }
        
        .btn-send:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #999;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state p {
            font-size: 1.1rem;
        }
        
        /* Loading */
        .loading {
            text-align: center;
            padding: 2rem;
            color: #999;
        }
        
        /* Footer */
        .main-footer {
            background: rgba(255,255,255,0.95);
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        
        .footer-content p {
            color: #666;
            margin: 0.25rem 0;
            font-size: 0.9rem;
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
            
            .forum-container {
                height: calc(100vh - 260px);
            }
            
            .message-bubble {
                gap: 0.75rem;
            }
            
            .message-avatar {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
            
            .input-form {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .btn-send {
                width: 100%;
                justify-content: center;
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
                <li><a href="forum.php" class="active"><i class="fas fa-comments"></i> Forum</a></li>
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
    <div class="forum-container">
        <div class="forum-header">
            <h2><i class="fas fa-comments"></i> SK Youth Forum</h2>
            <p>Connect and chat with fellow SK members</p>
        </div>
        
        <div class="messages-area" id="messagesArea">
            <div class="loading">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>Loading messages...</p>
            </div>
        </div>
        
        <div class="input-area">
            <form class="input-form" id="messageForm" onsubmit="sendMessage(event)">
                <div class="input-wrapper">
                    <textarea 
                        id="messageInput" 
                        placeholder="Type your message here..." 
                        rows="1"
                        required
                    ></textarea>
                </div>
                <button type="submit" class="btn-send" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="main-footer">
    <div class="footer-content">
        <p><strong>Youth Information System</strong> - Maguilling, Piat, Cagayan</p>
        <p>&copy; <?php echo date('Y') ?> Sangguniang Kabataan. All Rights Reserved.</p>
    </div>
</footer>

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    var _base_url_ = '<?php echo base_url ?>';
    var currentUserId = <?php echo $_settings->userdata('id') ?>;
    var currentUserName = '<?php echo $_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname') ?>';
    var refreshInterval;

    $(document).ready(function(){
        loadMessages();
        
        // Auto-refresh messages every 5 seconds
        refreshInterval = setInterval(loadMessages, 5000);
        
        // Auto-resize textarea
        $('#messageInput').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Enter to send, Shift+Enter for new line
        $('#messageInput').on('keydown', function(e) {
            if(e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                $('#messageForm').submit();
            }
        });
    });

    function logout(){
        if(confirm('Are you sure you want to logout?')){
            clearInterval(refreshInterval);
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
    
    function loadMessages() {
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=get_forum_messages',
            method: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    displayMessages(resp.data);
                }
            },
            error: function(){
                console.error('Failed to load messages');
            }
        });
    }
    
    function displayMessages(messages) {
        const messagesArea = $('#messagesArea');
        const wasScrolledToBottom = messagesArea[0].scrollHeight - messagesArea.scrollTop() <= messagesArea.outerHeight() + 100;
        
        if(messages.length === 0) {
            messagesArea.html(`
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <p>No messages yet. Be the first to start the conversation!</p>
                </div>
            `);
            return;
        }
        
        let html = '';
        
        // Reverse to show oldest first
        messages.reverse().forEach(msg => {
            const isMyMessage = msg.user_id == currentUserId;
            const initials = (msg.firstname.charAt(0) + msg.lastname.charAt(0)).toUpperCase();
            
            html += `
                <div class="message-bubble ${isMyMessage ? 'my-message' : ''}">
                    <div class="message-avatar">${initials}</div>
                    <div class="message-content">
                        <div class="message-header">
                            <div>
                                <span class="message-user">${msg.firstname} ${msg.lastname}</span>
                                ${msg.zone ? `<span class="message-zone">Zone ${msg.zone}</span>` : ''}
                            </div>
                            <span class="message-time">${msg.time_ago}</span>
                        </div>
                        <div class="message-text">${escapeHtml(msg.message)}</div>
                        ${isMyMessage ? `
                            <div class="message-actions">
                                <button class="btn-delete-msg" onclick="deleteMessage(${msg.id})" title="Delete message">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        });
        
        messagesArea.html(html);
        
        // Scroll to bottom if was already at bottom or it's first load
        if(wasScrolledToBottom || messagesArea.find('.message-bubble').length === messages.length) {
            scrollToBottom();
        }
    }
    
    function sendMessage(event) {
        event.preventDefault();
        
        const messageInput = $('#messageInput');
        const message = messageInput.val().trim();
        
        if(!message) return;
        
        const sendBtn = $('#sendBtn');
        sendBtn.prop('disabled', true);
        
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=send_forum_message',
            method: 'POST',
            data: { message: message },
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    messageInput.val('');
                    messageInput.css('height', 'auto');
                    loadMessages();
                } else {
                    alert(resp.msg || 'Failed to send message');
                }
            },
            error: function(){
                alert('Error sending message');
            },
            complete: function(){
                sendBtn.prop('disabled', false);
                messageInput.focus();
            }
        });
    }
    
    function deleteMessage(messageId) {
        if(!confirm('Are you sure you want to delete this message?')) return;
        
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=delete_forum_message',
            method: 'POST',
            data: { id: messageId },
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    loadMessages();
                } else {
                    alert(resp.msg || 'Failed to delete message');
                }
            },
            error: function(){
                alert('Error deleting message');
            }
        });
    }
    
    function scrollToBottom() {
        const messagesArea = $('#messagesArea');
        messagesArea.scrollTop(messagesArea[0].scrollHeight);
    }
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]).replace(/\n/g, '<br>');
    }
    
    // Clean up interval when page is unloaded
    $(window).on('beforeunload', function() {
        clearInterval(refreshInterval);
    });
</script>

</body>
</html>
