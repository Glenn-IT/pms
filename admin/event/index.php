<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<script>
    const adminType = <?php echo json_encode($_settings->userdata('type')); ?>;
</script>

<style>
    .event-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .event-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: box-shadow 0.2s, height 0.3s ease;
        display: flex;
        flex-direction: column;
        min-height: 500px;
    }

    .event-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.16);
    }

    .event-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f5f5f5;
        flex-shrink: 0;
        position: relative;
    }

    .image-indicator {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    .event-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .event-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
        height: 48px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .event-date {
        font-size: 0.95rem;
        color: #888;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .event-desc {
        font-size: 1.08rem;
        color: #222;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        transition: all 0.3s ease;
        min-height: 60px;
        max-height: 80px;
    }

    .event-desc.expanded {
        -webkit-line-clamp: unset;
        max-height: none;
    }

    .read-more {
        color: #007bff;
        font-size: 0.9rem;
        cursor: pointer;
        margin-bottom: 1rem;
        align-self: flex-start;
        display: none;
    }

    .event-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
        flex-wrap: wrap;
    }
    
    .event-actions .btn {
        flex: 1;
        min-width: 80px;
        font-size: 0.8rem;
    }

    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #ddd;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .gallery-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .gallery-image:hover {
        transform: scale(1.05);
    }

    #qr_video {
        border-radius: 8px;
        background: #f8f9fa;
    }

    #camera_status {
        font-size: 0.9rem;
        min-height: 20px;
    }

    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        font-weight: 500;
    }

    .scan_qr_attendance:disabled {
        opacity: 0.6;
        cursor: not-allowed !important;
    }

    .scan_qr_attendance:disabled:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }

    @media (max-width: 900px) {
        .event-grid {
            grid-template-columns: 1fr;
        }
        
        #qr_scan_modal .modal-dialog {
            margin: 0.5rem;
        }
        
        #qr_video {
            max-width: 250px;
            height: 150px;
        }
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Events</h3>
        <div class="d-flex align-items-center ml-auto">
            <label for="sort_event" class="mr-2 mb-0" style="font-weight:normal;">Sort by:</label>
            <select id="sort_event" class="form-control form-control-sm mr-3" style="width:auto;">
                <option value="desc">Newest First</option>
                <option value="asc">Oldest First</option>
            </select>
            <?php if($_settings->userdata('type') == 1): ?>
            <button class="btn btn-primary btn-sm" type="button" id="add_event">
                <i class="fa fa-plus"></i> Add Event
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="event_list" class="event-grid">
                <!-- Events will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Event -->
<div class="modal fade" id="event_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="event_form">
            <input type="hidden" name="id" id="event_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Event</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="img">Event Images</label>
                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple required>
                        <small class="text-muted">You can select multiple images</small>
                        <div id="image_preview_container" class="image-preview-container"></div>
                    </div>
                    <div class="form-group">
                        <label for="date">Date & Time</label>
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" rows="4" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal for View Event -->
<div class="modal fade" id="view_event_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="view_event_content">
                    <!-- Event details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Image Gallery -->
<div class="modal fade" id="image_gallery_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Images</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="image_gallery_content">
                    <!-- Gallery images will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for QR Code Scanning -->
<div class="modal fade" id="qr_scan_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR for Attendance</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <h6 id="event_title_display"></h6>
                </div>
                
                <!-- Camera Scanner Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fa fa-camera"></i> Camera Scanner</h6>
                            </div>
                            <div class="card-body text-center">
                                <div id="camera_section">
                                    <video id="qr_video" width="100%" style="max-width: 300px; height: 200px; border: 1px solid #ddd;"></video>
                                    <div class="mt-2">
                                        <button type="button" id="start_camera" class="btn btn-success btn-sm">
                                            <i class="fa fa-camera"></i> Start Camera
                                        </button>
                                        <button type="button" id="stop_camera" class="btn btn-danger btn-sm" style="display: none;">
                                            <i class="fa fa-stop"></i> Stop Camera
                                        </button>
                                    </div>
                                    <div id="camera_status" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fa fa-keyboard"></i> Manual Entry</h6>
                            </div>
                            <div class="card-body">
                                <form id="qr_scan_form">
                                    <input type="hidden" id="scan_event_id" name="event_id">
                                    <div class="form-group">
                                        <label for="qr_code_input">QR Code</label>
                                        <input type="text" class="form-control" id="qr_code_input" name="qr_code" 
                                               placeholder="Scan or enter QR code" required>
                                        <small class="text-muted">Enter QR code manually or use camera</small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fa fa-check"></i> Mark Attendance
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="scan_result" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Attendance -->
<div class="modal fade" id="attendance_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Attendance</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="attendance_content">
                    <!-- Attendance data will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
let eventData = [];
let qrCodeReader = null;
let videoStream = null;

function renderEvents(sortOrder = 'desc') {
    if (!eventData.length) {
        $('#event_list').html('<p>No events found.</p>');
        return;
    }
    let sorted = [...eventData];
    sorted.sort((a, b) => {
        const dateA = new Date(a.date_created || a.date);
        const dateB = new Date(b.date_created || b.date);
        return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
    });
    let html = '';
    sorted.forEach(event => {
        const images = event.images || [];
        const primaryImage = images[0] || event.image_path;
        const imageCount = images.length || (event.image_path ? 1 : 0);
        
        // Check if today is the event date
        const today = new Date();
        const eventDate = new Date(event.date_created);
        
        // Compare year, month, and day separately to avoid timezone issues
        const isEventToday = (
            today.getFullYear() === eventDate.getFullYear() &&
            today.getMonth() === eventDate.getMonth() &&
            today.getDate() === eventDate.getDate()
        );
        
        html += `
            <div class="event-card">
                <div class="event-img" style="position: relative;">
                    <img src="../${primaryImage}" class="event-img" alt="Event" style="position: static;">
                    ${imageCount > 1 ? `<div class="image-indicator">${imageCount} photos</div>` : ''}
                </div>
                <div class="event-body">
                    <div class="event-title">${event.title}</div>
                    <div class="event-date">
                        <i class="fa fa-calendar"></i> ${event.date}
                        <!-- COMMENTED OUT: QR Available badges - GLENN REMINDER: Uncomment to restore QR status display -->
                        <!-- ${isEventToday ? '<span class="badge badge-success ml-2">QR Available Today</span>' : '<span class="badge badge-secondary ml-2">QR Not Available</span>'} -->
                    </div>
                    <div class="event-desc">${event.description}</div>
                    <span class="read-more">Read More</span>
                    <div class="event-actions">
                        <button class="btn btn-sm btn-info view_event" data-id="${event.id}">
                            <i class="fa fa-eye"></i> View
                        </button>
                        ${adminType == 1 ? `
                        <!-- COMMENTED OUT: Scan QR Button - GLENN REMINDER: Uncomment to restore QR scanning functionality -->
                        <!-- <button class="btn btn-sm ${isEventToday ? 'btn-success' : 'btn-secondary'} scan_qr_attendance" 
                                data-id="${event.id}" 
                                data-title="${event.title}"
                                data-event-date="${event.date_created}"
                                ${isEventToday ? '' : 'disabled'} 
                                title="${isEventToday ? 'Scan QR for attendance' : 'QR scanning is only available on the event date'}">
                            <i class="fa fa-qrcode"></i> Scan QR
                        </button> -->
                        <!-- COMMENTED OUT: Attendance Button - GLENN REMINDER: Uncomment to restore attendance viewing -->
                        <!-- <button class="btn btn-sm btn-warning view_attendance" data-id="${event.id}" data-title="${event.title}">
                            <i class="fa fa-users"></i> Attendance
                        </button> -->
                        <button class="btn btn-sm btn-primary edit_event" 
                            data-id="${event.id}" 
                            data-title="${event.title}" 
                            data-date="${event.date_created}" 
                            data-description="${event.description}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete_event" data-id="${event.id}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    });
    $('#event_list').html(html);

    // Show "Read More" if description is long
    $('.event-desc').each(function(){
        if ($(this)[0].scrollHeight > $(this).outerHeight()) {
            $(this).siblings('.read-more').show();
        }
    });
}

function loadAllEvents() {
    $.ajax({
        url: '../classes/Master.php?f=get_all_events',
        method: 'GET',
        dataType: 'json',
        success: function(resp){
            if (resp.status === 'success') {
                eventData = resp.data;
                renderEvents($('#sort_event').val());
            } else {
                eventData = [];
                renderEvents();
            }
        },
        error: function(xhr){
            console.error(xhr.responseText);
            eventData = [];
            renderEvents();
        }
    });
}

function showImageGallery(eventId) {
    const event = eventData.find(e => e.id == eventId);
    if (event && (event.images || event.image_path)) {
        let content = '<div class="image-gallery">';
        
        if (event.images && event.images.length > 0) {
            event.images.forEach(image => {
                content += `<img src="../${image}" class="gallery-image" alt="Event Image" style="height: 200px; cursor: zoom-in;" onclick="window.open('../${image}', '_blank')">`;
            });
        } else if (event.image_path) {
            content += `<img src="../${event.image_path}" class="gallery-image" alt="Event Image" style="height: 200px; cursor: zoom-in;" onclick="window.open('../${event.image_path}', '_blank')">`;
        }
        
        content += '</div>';
        $('#image_gallery_content').html(content);
        $('#image_gallery_modal').modal('show');
    }
}

$(function() {
    loadAllEvents();

    $('#sort_event').on('change', function() {
        renderEvents($(this).val());
    });

    // Image preview functionality
    $('input[name="images[]"]').on('change', function() {
        const files = this.files;
        const container = $('#image_preview_container');
        container.empty();
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = $(`
                    <div class="image-preview" data-index="${i}">
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image" data-index="${i}">×</button>
                    </div>
                `);
                container.append(preview);
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Remove image preview
    $(document).on('click', '.remove-image', function() {
        const index = $(this).data('index');
        $(this).closest('.image-preview').remove();
        
        // Reset file input to remove the file
        const fileInput = $('input[name="images[]"]')[0];
        const dt = new DataTransfer();
        const files = fileInput.files;
        
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
            }
        }
        
        fileInput.files = dt.files;
    });

    // Read More Toggle
    $(document).on('click', '.read-more', function() {
        const desc = $(this).siblings('.event-desc');
        const card = $(this).closest('.event-card');

        if (desc.hasClass('expanded')) {
            desc.removeClass('expanded');
            $(this).text('Read More');
            card.css('height', '');
        } else {
            desc.addClass('expanded');
            $(this).text('Show Less');
            card.css('height', 'auto');
        }
    });

    // View event functionality
    $(document).on('click', '.view_event', function() {
    const eventId = $(this).data('id');
    const event = eventData.find(e => e.id == eventId);
    
    if (event) {
        let content = '';
        
        if (event.images && event.images.length > 0) {
            content += `<div class="image-gallery">`;
            
            event.images.forEach(image => {
                content += `<img src="../${image}" class="gallery-image" alt="Event Image" style="height: 300px; cursor: zoom-in;" onclick="window.open('../${image}', '_blank')">`;
            });
            
            content += `</div>`;
        } else if (event.image_path) {
            content += `<img src="../${event.image_path}" class="gallery-image" alt="Event Image" style="height: 300px; cursor: zoom-in; width: 100%;" onclick="window.open('../${event.image_path}', '_blank')">`;
        } else {
            content = '<p>No images available for this event.</p>';
        }
        
        $('#view_event_content').html(content);
        $('#view_event_modal').modal('show');
    }
});

    $('#event_form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '../classes/Master.php?f=save_event',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    alert_toast("Event saved successfully", 'success');
                    setTimeout(() => {
                        loadAllEvents();
                        $('#event_modal').modal('hide');
                    }, 1000);
                } else {
                    alert_toast(resp.msg || "Failed to save event", 'error');
                }
            },
            error: function(xhr) {
                alert_toast("AJAX Error", 'error');
                console.error(xhr.responseText);
            }
        });
    });

    $('#add_event').click(function() {
        $('#event_form')[0].reset();
        $('#event_id').val('');
        $('#image_preview_container').empty();
        $('input[name="images[]"]').prop('required', true);
        $('#event_modal .modal-title').text('Add New Event');
        $('#event_modal').modal('show');
    });

    $(document).on('click', '.delete_event', function() {
        if (confirm("Are you sure you want to delete this event?")) {
            let id = $(this).data('id');
            $.ajax({
                url: '../classes/Master.php?f=delete_event',
                method: 'POST',
                data: { id },
                dataType: 'json',
                success: function(resp) {
                    if (resp.status === 'success') {
                        alert_toast("Event deleted", 'success');
                        loadAllEvents();
                    } else {
                        alert_toast("Failed to delete", 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert_toast("AJAX Error", 'error');
                }
            });
        }
    });

    $(document).on('click', '.edit_event', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const date = $(this).data('date');
        const description = $(this).data('description');

        $('#event_modal .modal-title').text('Edit Event');
        $('#event_id').val(id);
        $('[name="title"]').val(title);
        $('[name="description"]').val(description);
        $('[name="date"]').val(new Date(date).toISOString().slice(0, 16));
        $('input[name="images[]"]').prop('required', false);
        $('#image_preview_container').empty();
        $('#event_modal').modal('show');
    });

    // QR Scan for Attendance
    $(document).on('click', '.scan_qr_attendance', function() {
        // Check if button is disabled
        if ($(this).is(':disabled')) {
            alert_toast('QR scanning is only available on the event date', 'warning');
            return;
        }
        
        const eventId = $(this).data('id');
        const eventTitle = $(this).data('title');
        const eventDate = $(this).data('event-date');
        
        // Double-check the date validation
        const today = new Date();
        const eventDateObj = new Date(eventDate);
        
        // Compare year, month, and day separately to avoid timezone issues
        const isEventToday = (
            today.getFullYear() === eventDateObj.getFullYear() &&
            today.getMonth() === eventDateObj.getMonth() &&
            today.getDate() === eventDateObj.getDate()
        );
        
        if (!isEventToday) {
            alert_toast('QR scanning is only available on the event date (' + eventDateObj.toDateString() + ')', 'warning');
            return;
        }
        
        $('#scan_event_id').val(eventId);
        $('#event_title_display').text(eventTitle);
        $('#qr_code_input').val('');
        $('#scan_result').html('');
        stopCamera(); // Stop any existing camera
        $('#qr_scan_modal').modal('show');
        
        // Focus on QR input after modal is shown
        $('#qr_scan_modal').on('shown.bs.modal', function() {
            $('#qr_code_input').focus();
        });
        
        // Stop camera when modal is closed
        $('#qr_scan_modal').on('hidden.bs.modal', function() {
            stopCamera();
        });
    });

    // Camera Functions
    function startCamera() {
        // Check if browser supports getUserMedia
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            $('#camera_status').html('<span class="text-danger"><i class="fa fa-times"></i> Camera not supported in this browser</span>');
            return;
        }
        
        $('#camera_status').html('<span class="text-info"><i class="fa fa-spinner fa-spin"></i> Starting camera...</span>');
        
        navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: 'environment', // Use back camera if available
                width: { ideal: 300 },
                height: { ideal: 200 }
            } 
        })
        .then(function(stream) {
            videoStream = stream;
            const video = document.getElementById('qr_video');
            video.srcObject = stream;
            video.play();
            
            $('#start_camera').hide();
            $('#stop_camera').show();
            $('#camera_status').html('<span class="text-success"><i class="fa fa-check"></i> Camera active - Point at QR code</span>');
            
            // Start scanning for QR codes
            scanQRCode();
        })
        .catch(function(err) {
            console.error('Error accessing camera:', err);
            let errorMsg = 'Camera access denied or not available';
            
            if (err.name === 'NotAllowedError') {
                errorMsg = 'Camera permission denied. Please allow camera access and try again.';
            } else if (err.name === 'NotFoundError') {
                errorMsg = 'No camera found on this device.';
            } else if (err.name === 'NotSupportedError') {
                errorMsg = 'Camera not supported in this browser.';
            }
            
            $('#camera_status').html(`<span class="text-danger"><i class="fa fa-times"></i> ${errorMsg}</span>`);
        });
    }

    function stopCamera() {
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            videoStream = null;
        }
        
        const video = document.getElementById('qr_video');
        video.srcObject = null;
        
        $('#start_camera').show();
        $('#stop_camera').hide();
        $('#camera_status').html('');
        
        if (qrCodeReader) {
            clearTimeout(qrCodeReader);
            qrCodeReader = null;
        }
    }

    function scanQRCode() {
        const video = document.getElementById('qr_video');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        
        function scan() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.height = video.videoHeight;
                canvas.width = video.videoWidth;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                
                if (code) {
                    // QR code detected
                    $('#qr_code_input').val(code.data);
                    $('#camera_status').html('<span class="text-success"><i class="fa fa-check"></i> QR Code detected!</span>');
                    
                    // Auto-submit if QR code is valid
                    if (code.data.trim()) {
                        $('#qr_scan_form').submit();
                        stopCamera();
                        return; // Stop scanning
                    }
                }
            }
            
            // Continue scanning if camera is still active
            if (videoStream) {
                qrCodeReader = setTimeout(scan, 250); // Scan every 250ms
            }
        }
        
        scan();
    }

    // Camera button events
    $('#start_camera').click(function() {
        startCamera();
    });

    $('#stop_camera').click(function() {
        stopCamera();
    });

    // Handle QR Scan Form Submission
    $('#qr_scan_form').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            event_id: $('#scan_event_id').val(),
            qr_code: $('#qr_code_input').val().trim()
        };

        if (!formData.qr_code) {
            alert_toast('Please enter or scan a QR code', 'error');
            return;
        }

        $.ajax({
            url: '../classes/Master.php?f=record_event_attendance',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    $('#scan_result').html(`
                        <div class="alert alert-success">
                            <i class="fa fa-check"></i> <strong>Success!</strong><br>
                            <strong>Name:</strong> ${resp.user.firstname} ${resp.user.lastname}<br>
                            <strong>Time:</strong> ${resp.scan_time}<br>
                            Attendance recorded successfully!
                        </div>
                    `);
                    $('#qr_code_input').val('').focus();
                    alert_toast('Attendance recorded successfully', 'success');
                } else {
                    $('#scan_result').html(`
                        <div class="alert alert-danger">
                            <i class="fa fa-times"></i> <strong>Error:</strong> ${resp.msg}
                        </div>
                    `);
                    alert_toast(resp.msg, 'error');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#scan_result').html(`
                    <div class="alert alert-danger">
                        <i class="fa fa-times"></i> <strong>Error:</strong> Failed to process QR code
                    </div>
                `);
                alert_toast('Failed to process QR code', 'error');
            }
        });
    });

    // View Attendance
    $(document).on('click', '.view_attendance', function() {
        const eventId = $(this).data('id');
        const eventTitle = $(this).data('title');
        
        $('#attendance_modal .modal-title').text(`Attendance - ${eventTitle}`);
        $('#attendance_content').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        $('#attendance_modal').modal('show');
        
        $.ajax({
            url: '../classes/Master.php?f=get_event_attendance',
            method: 'GET',
            data: { event_id: eventId },
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    let content = `
                        <div class="mb-3">
                            <h6>Total Attendees: ${resp.data.length}</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Zone</th>
                                        <th>Scan Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    if (resp.data.length > 0) {
                        resp.data.forEach((record, index) => {
                            // Get zone from database, with fallback to 'Unassigned'
                            const zone = record.zone || 'Unassigned';
                            content += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${record.firstname} ${record.lastname}</td>
                                    <td><span class="badge badge-info">${zone}</span></td>
                                    <td>${new Date(record.scan_time).toLocaleString()}</td>
                                    <td><span class="badge badge-success">Present</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        content += `
                            <tr>
                                <td colspan="5" class="text-center">No attendance records found</td>
                            </tr>
                        `;
                    }
                    
                    content += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    $('#attendance_content').html(content);
                } else {
                    $('#attendance_content').html(`
                        <div class="alert alert-danger">
                            <i class="fa fa-times"></i> Failed to load attendance data
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#attendance_content').html(`
                    <div class="alert alert-danger">
                        <i class="fa fa-times"></i> Error loading attendance data
                    </div>
                `);
            }
        });
    });
});
</script>