<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
/* About Page Styles */
.about-hero {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.stat-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    background: white;
    border-radius: 15px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.mission-vision-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}

.mission-vision-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    transform: rotate(45deg);
}

.feature-box {
    text-align: center;
    padding: 30px 20px;
    border-radius: 15px;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-bottom: 30px;
}

.feature-box:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.feature-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #667eea;
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 40px;
    width: 50%;
}

.timeline-item:nth-child(odd) {
    left: 0;
    padding-right: 40px;
}

.timeline-item:nth-child(even) {
    left: 50%;
    padding-left: 40px;
}

.timeline-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    position: relative;
}

.timeline-item::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background: #667eea;
    border-radius: 50%;
    top: 20px;
}

.timeline-item:nth-child(odd)::after {
    right: -10px;
}

.timeline-item:nth-child(even)::after {
    left: -10px;
}

.progress-bar-custom {
    height: 8px;
    border-radius: 10px;
    background: #e9ecef;
    overflow: hidden;
    margin-bottom: 15px;
}

.progress-fill {
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    animation: progressAnimation 2s ease-in-out;
}

@keyframes progressAnimation {
    from { width: 0%; }
}

.contact-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.location-map {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .timeline::before {
        left: 20px;
    }
    
    .timeline-item {
        width: 100%;
        left: 0;
        padding-left: 50px;
        padding-right: 20px;
    }
    
    .timeline-item::after {
        left: 10px;
    }
    
    .timeline-item:nth-child(even) {
        left: 0;
        padding-left: 50px;
    }
}
</style>

<div class="container-fluid">
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 font-weight-bold mb-4">About SK of Maguiling</h1>
                    <h3 class="mb-4">Sangguniang Kabataan ng Maguiling, Piat, Cagayan</h3>
                    <p class="lead mb-4">Empowering the youth, building stronger communities, and creating a brighter future for Maguiling, Piat, Philippines</p>
                    <div class="mt-4">
                        <span class="badge badge-light badge-pill px-3 py-2 mr-2">
                            <i class="fa fa-map-marker-alt mr-1"></i> Maguiling, Piat, Cagayan
                        </span>
                        <span class="badge badge-light badge-pill px-3 py-2">
                            <i class="fa fa-users mr-1"></i> Serving 500+ Youth
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Mission & Vision -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="mission-vision-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="feature-icon mr-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <i class="fa fa-bullseye"></i>
                        </div>
                        <h3 class="mb-0">Our Mission</h3>
                    </div>
                    <p class="mb-0">To empower the youth of Maguiling through meaningful programs, leadership development, and community engagement that promotes social responsibility, education, and sustainable development for a progressive barangay.</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="mission-vision-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="feature-icon mr-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <i class="fa fa-eye"></i>
                        </div>
                        <h3 class="mb-0">Our Vision</h3>
                    </div>
                    <p class="mb-0">A vibrant community where young people are active participants in governance, equipped with skills and values necessary to become responsible leaders and productive citizens of Maguiling, Piat, and the Philippines.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Services -->
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="display-5 font-weight-bold">Our Programs & Services</h2>
            <p class="lead text-muted">Comprehensive programs designed to develop youth potential</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <h5 class="font-weight-bold">Educational Programs</h5>
                    <p class="text-muted">Scholarship assistance, tutorial programs, and educational workshops to support academic excellence.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fa fa-heartbeat"></i>
                    </div>
                    <h5 class="font-weight-bold">Health & Wellness</h5>
                    <p class="text-muted">Health awareness campaigns, medical missions, and wellness programs for youth development.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <h5 class="font-weight-bold">Skills Development</h5>
                    <p class="text-muted">Vocational training, entrepreneurship programs, and livelihood projects for economic empowerment.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fa fa-leaf"></i>
                    </div>
                    <h5 class="font-weight-bold">Environmental Programs</h5>
                    <p class="text-muted">Tree planting, clean-up drives, and environmental awareness campaigns for sustainable development.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fa fa-futbol"></i>
                    </div>
                    <h5 class="font-weight-bold">Sports & Recreation</h5>
                    <p class="text-muted">Basketball leagues, sports tournaments, and recreational activities promoting healthy lifestyle.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fa fa-users-cog"></i>
                    </div>
                    <h5 class="font-weight-bold">Leadership Training</h5>
                    <p class="text-muted">Leadership seminars, governance training, and youth parliament sessions for future leaders.</p>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Contact Information -->
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="display-5 font-weight-bold">Get In Touch</h2>
            <p class="lead text-muted">Connect with us for partnerships, inquiries, or to join our programs</p>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="contact-card text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <h5 class="font-weight-bold">Visit Us</h5>
                    <p class="text-muted mb-0">
                        SK Office, Barangay Maguiling<br>
                        Piat, Cagayan, Philippines 3528
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="contact-card text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="fa fa-phone"></i>
                    </div>
                    <h5 class="font-weight-bold">Call Us</h5>
                    <p class="text-muted mb-0">
                        Mobile: (+63) 912-345-6789<br>
                        Landline: (078) 123-4567
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="contact-card text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <h5 class="font-weight-bold">Email Us</h5>
                    <p class="text-muted mb-0">
                        sk.maguiling@piat.gov.ph<br>
                        info.skmaguiling@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Map -->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h3 class="font-weight-bold">Find Us Here</h3>
            <p class="text-muted">Barangay Maguiling, Piat, Cagayan, Philippines</p>
        </div>
        <div class="location-map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.7234567890123!2d121.4567890!3d17.1234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sPiat%2C%20Cagayan!5e0!3m2!1sen!2sph!4v1234567890"
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="about-hero mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="font-weight-bold mb-4">Join Our Growing Community</h2>
                    <p class="lead mb-4">Be part of the change you want to see in Maguiling. Together, we can build a stronger, more progressive community.</p>
                    <div class="mt-4">
                        
                        <a href="?page=event" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fa fa-calendar mr-2"></i>View Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Animate progress bars on scroll
    function animateProgressBars() {
        $('.progress-fill').each(function() {
            var $this = $(this);
            var width = $this.data('width') || $this.css('width');
            $this.css('width', '0%').animate({
                width: width
            }, 1500);
        });
    }

    // Check if progress bars are in viewport
    function checkProgressBars() {
        var progressSection = $('.progress-bar-custom').first().offset();
        if (progressSection && $(window).scrollTop() + $(window).height() > progressSection.top) {
            animateProgressBars();
            $(window).off('scroll', checkProgressBars);
        }
    }

    // Bind scroll event
    $(window).scroll(checkProgressBars);
    checkProgressBars(); // Check immediately

    // Add smooth scrolling for internal links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        var target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });

    // Add loading animation for timeline items
    $('.timeline-item').each(function(index) {
        $(this).css('opacity', '0').delay(index * 200).animate({
            opacity: 1
        }, 600);
    });
});
</script>
