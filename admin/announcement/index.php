<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<script>
    const adminType = <?php echo json_encode($_settings->userdata('type')); ?>;
</script>
<!-- Modal for Event Attendance Details -->
<div class="modal fade" id="event_attendance_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Attendance Details</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="event_attendance_content">
                    <!-- Detailed attendance data will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Announcement Images -->
<div class="modal fade" id="view_announcement_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Announcement Images</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="view_announcement_content">
                    <!-- Announcement images will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .announcement-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
    }
    .announcement-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: box-shadow 0.2s, height 0.3s ease;
        display: flex;
        flex-direction: column;
        min-height: 450px;
    }    .announcement-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.16);
    }
    .announcement-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f5f5f5;
        flex-shrink: 0;
    }
    .announcement-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .announcement-title {
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
    .announcement-date {
        font-size: 0.95rem;
        color: #888;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    .announcement-desc {
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
    .announcement-desc.expanded {
        -webkit-line-clamp: unset;
        max-height: none;
    }
    .read-more {
        color: #007bff;
        font-size: 0.9rem;
        cursor: pointer;
        margin-bottom: 1rem;
        align-self: flex-start;
        display: none; /* Hidden by default */
    }
    .announcement-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
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
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .gallery-image:hover {
        transform: scale(1.05);
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

    #duplicate_warning {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 900px) {
        .announcement-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center" style="display:flex;justify-content:space-between;align-items:center;">
        <h3 class="card-title mb-0">Announcements</h3>
        <div class="d-flex align-items-center ml-auto">
            <label for="sort_announcement" class="mr-2 mb-0" style="font-weight:normal;">Sort by:</label>
            <select id="sort_announcement" class="form-control form-control-sm mr-3" style="width:auto;display:inline-block;">
                <option value="desc">Newest First</option>
                <option value="asc">Oldest First</option>
            </select>
            <?php if($_settings->userdata('type') == 1): ?>
            <button class="btn btn-primary btn-sm" type="button" id="add_announcement">
                <i class="fa fa-plus"></i> Add Announcement
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="announcement_list" class="announcement-grid">
                <!-- Announcements will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Event Attendance Section -->
<div class="card card-outline card-success mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Event Attendance Overview</h3>
        <div class="d-flex align-items-center ml-auto">
            <button class="btn btn-success btn-sm" type="button" id="refresh_attendance">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="attendance_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Event Title</th>
                            <th>Event Date</th>
                            <th>Total Attendees</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Event attendance data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="announcement_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="announcement_form">
            <input type="hidden" name="id" id="announcement_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Announcement</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="img">Announcement Images</label>
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

<!-- Modal for Viewing Event Attendance Details -->
<div class="modal fade" id="event_attendance_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Attendance Details</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="event_attendance_content">
                    <!-- Detailed attendance data will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
let announcementsData = [];

function renderAnnouncements(sortOrder = 'desc') {
    if (!announcementsData.length) {
        $('#announcement_list').html('<p>No announcements found.</p>');
        return;
    }
    let sorted = [...announcementsData];
    sorted.sort((a, b) => {
        const dateA = new Date(a.date_created || a.date);
        const dateB = new Date(b.date_created || b.date);
        return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
    });
    let html = '';
    sorted.forEach(ann => {
        // Handle multiple images or single image
        let imageSrc = '';
        let imageIndicator = '';
        
        if (ann.images && ann.images.length > 0) {
            imageSrc = `../${ann.images[0]}`;
            if (ann.images.length > 1) {
                imageIndicator = `<div class="image-indicator">+${ann.images.length - 1} more</div>`;
            }
        } else if (ann.image_path) {
            imageSrc = `../${ann.image_path}`;
        } else {
            imageSrc = '../assets/images/placeholder.jpg';
        }
        
        html += `
            <div class="announcement-card">
                <div style="position: relative;">
                    <img src="${imageSrc}" class="announcement-img" alt="Announcement">
                    ${imageIndicator}
                </div>
                <div class="announcement-body">
                    <div class="announcement-title">${ann.title}</div>
                    <div class="announcement-date">
                        <i class="fa fa-calendar"></i> ${ann.date}
                    </div>
                    <div class="announcement-desc">${ann.description}</div>
                    <span class="read-more">Read More</span>
                    <div class="announcement-actions">
                        ${(ann.images && ann.images.length > 0) || ann.image_path ? `
                        <button class="btn btn-sm btn-info view_announcement_images" 
                            data-id="${ann.id}" 
                            data-title="${ann.title}"
                            data-images='${JSON.stringify(ann.images || [ann.image_path])}'>
                            <i class="fa fa-eye"></i> View Images
                        </button>
                        ` : ''}
                        ${adminType == 1 ? `
                        <button class="btn btn-sm btn-primary edit_announcement" 
                            data-id="${ann.id}" 
                            data-title="${ann.title}" 
                            data-date="${ann.date_created}" 
                            data-description="${ann.description}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete_announcement" data-id="${ann.id}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    });
    $('#announcement_list').html(html);

    // Show "Read More" if description is long
    $('.announcement-desc').each(function(){
        if ($(this)[0].scrollHeight > $(this).outerHeight()) {
            $(this).siblings('.read-more').show();
        }
    });
}

function loadAllAnnouncements(){
    $.ajax({
        url: '../classes/Master.php?f=get_all_announcements',
        method: 'GET',
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                announcementsData = resp.data;
                renderAnnouncements($('#sort_announcement').val());
            } else {
                announcementsData = [];
                renderAnnouncements();
            }
        },
        error: function(xhr){
            console.error(xhr.responseText);
            announcementsData = [];
            renderAnnouncements();
        }
    });
}

function loadEventAttendanceOverview() {
    $.ajax({
        url: '../classes/Master.php?f=get_all_events_with_attendance',
        method: 'GET',
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                renderEventAttendanceTable(resp.data);
            } else {
                $('#attendance_table tbody').html('<tr><td colspan="5" class="text-center">Failed to load event data</td></tr>');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            $('#attendance_table tbody').html('<tr><td colspan="5" class="text-center">Error loading event data</td></tr>');
        }
    });
}

function renderEventAttendanceTable(events) {
    let html = '';
    
    if (events.length === 0) {
        html = '<tr><td colspan="5" class="text-center">No events found</td></tr>';
    } else {
        events.forEach((event, index) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${event.title}</td>
                    <td>${event.date}</td>
                    <td>
                        <span class="badge badge-primary">${event.attendance_count || 0}</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-info view_event_attendance" 
                                data-id="${event.id}" 
                                data-title="${event.title}">
                            <i class="fa fa-eye"></i> View Details
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    $('#attendance_table tbody').html(html);
}

$(function(){
    loadAllAnnouncements();
    loadEventAttendanceOverview();

    $('#sort_announcement').on('change', function() {
        renderAnnouncements($(this).val());
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

    // View announcement images functionality
    $(document).on('click', '.view_announcement_images', function() {
        const announcementTitle = $(this).data('title');
        const images = $(this).data('images');
        
        let content = '';
        
        if (images && images.length > 0) {
            content += `<div class="image-gallery">`;
            
            images.forEach(image => {
                const imagePath = image.startsWith('../') ? image : `../${image}`;
                content += `<img src="${imagePath}" class="gallery-image" alt="Announcement Image" style="height: 300px; cursor: zoom-in;" onclick="window.open('${imagePath}', '_blank')">`;
            });
            
            content += `</div>`;
        } else {
            content = '<p>No images available for this announcement.</p>';
        }
        
        $('#view_announcement_modal .modal-title').text(`${announcementTitle} - Images`);
        $('#view_announcement_content').html(content);
        $('#view_announcement_modal').modal('show');
    });

    $('#refresh_attendance').on('click', function() {
        loadEventAttendanceOverview();
    });

    // Read More Toggle
    // Read More Toggle
$(document).on('click', '.read-more', function(){
    const desc = $(this).siblings('.announcement-desc');
    const card = $(this).closest('.announcement-card');

    if(desc.hasClass('expanded')){
        desc.removeClass('expanded');
        $(this).text('Read More');
        card.css('height', ''); // Reset to auto height
    } else {
        desc.addClass('expanded');
        $(this).text('Show Less');
        card.css('height', 'auto'); // Allow auto expansion
    }
});


    $('#announcement_form').submit(function(e){
        e.preventDefault();
        
        // Check for duplicate before submitting
        const title = $('[name="title"]').val().trim();
        const date = $('[name="date"]').val();
        const id = $('#announcement_id').val();
        
        if(title && date) {
            // Check for duplicates
            const dateOnly = new Date(date).toISOString().split('T')[0];
            let isDuplicate = false;
            
            announcementsData.forEach(ann => {
                const annDateOnly = new Date(ann.date_created).toISOString().split('T')[0];
                if(ann.title.toLowerCase() === title.toLowerCase() && 
                   annDateOnly === dateOnly && 
                   ann.id != id) {
                    isDuplicate = true;
                }
            });
            
            if(isDuplicate) {
                alert_toast("An announcement with the same title and date already exists.", 'error');
                return;
            }
        }
        
        var formData = new FormData(this);
        $.ajax({
            url: '../classes/Master.php?f=save_announcement',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    alert_toast("Announcement saved successfully", 'success');
                    setTimeout(() => {
                        loadAllAnnouncements();
                        $('#announcement_modal').modal('hide');
                    }, 1000);
                } else {
                    alert_toast(resp.msg || "Failed to save announcement", 'error');
                }
            },
            error: function(xhr){
                alert_toast("AJAX Error", 'error');
                console.error(xhr.responseText);
            }
        });
    });

    $('#add_announcement').click(function(){
        $('#announcement_form')[0].reset();
        $('#announcement_id').val('');
        $('#image_preview_container').empty();
        $('input[name="images[]"]').prop('required', true);
        $('#announcement_modal .modal-title').text('Add New Announcement');
        $('#duplicate_warning').remove(); // Remove any existing warning
        $('#announcement_modal').modal('show');
    });

    // Real-time duplicate validation
    $(document).on('input change', '[name="title"], [name="date"]', function() {
        const title = $('[name="title"]').val().trim();
        const date = $('[name="date"]').val();
        const id = $('#announcement_id').val();
        
        // Remove existing warning
        $('#duplicate_warning').remove();
        
        if(title && date) {
            const dateOnly = new Date(date).toISOString().split('T')[0];
            let isDuplicate = false;
            
            announcementsData.forEach(ann => {
                const annDateOnly = new Date(ann.date_created).toISOString().split('T')[0];
                if(ann.title.toLowerCase() === title.toLowerCase() && 
                   annDateOnly === dateOnly && 
                   ann.id != id) {
                    isDuplicate = true;
                }
            });
            
            if(isDuplicate) {
                const warning = `<div id="duplicate_warning" class="alert alert-warning mt-2">
                    <i class="fa fa-exclamation-triangle"></i> 
                    Warning: An announcement with this title and date already exists.
                </div>`;
                $('[name="date"]').closest('.form-group').after(warning);
            }
        }
    });

    $(document).on('click', '.delete_announcement', function(){
        if(confirm("Are you sure you want to delete this announcement?")){
            let id = $(this).data('id');
            $.ajax({
                url: '../classes/Master.php?f=delete_announcement',
                method: 'POST',
                data: { id },
                dataType: 'json',
                success: function(resp){
                    if(resp.status === 'success'){
                        alert_toast("Announcement deleted", 'success');
                        loadAllAnnouncements();
                    } else {
                        alert_toast("Failed to delete", 'error');
                    }
                },
                error: function(xhr){
                    console.error(xhr.responseText);
                    alert_toast("AJAX Error", 'error');
                }
            });
        }
    });

    $(document).on('click', '.edit_announcement', function(){
        const id = $(this).data('id');
        const title = $(this).data('title');
        const date = $(this).data('date');
        const description = $(this).data('description');

        $('#announcement_modal .modal-title').text('Edit Announcement');
        $('#announcement_id').val(id);
        $('[name="title"]').val(title);
        $('[name="description"]').val(description);
        $('[name="date"]').val(new Date(date).toISOString().slice(0,16));
        $('input[name="images[]"]').prop('required', false);
        $('#image_preview_container').empty();
        $('#duplicate_warning').remove(); // Remove any existing warning
        $('#announcement_modal').modal('show');
    });

    // View Event Attendance Details
    $(document).on('click', '.view_event_attendance', function() {
        const eventId = $(this).data('id');
        const eventTitle = $(this).data('title');
        
        $('#event_attendance_modal .modal-title').text(`Attendance Details - ${eventTitle}`);
        $('#event_attendance_content').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        $('#event_attendance_modal').modal('show');
        
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
                                        <th>Username</th>
                                        <th>User Type</th>
                                        <th>Scan Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    if (resp.data.length > 0) {
                        resp.data.forEach((record, index) => {
                            const userType = record.type == 1 ? 'Admin' : 'User';
                            content += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${record.firstname} ${record.lastname}</td>
                                    <td>${record.username}</td>
                                    <td><span class="badge badge-${record.type == 1 ? 'danger' : 'primary'}">${userType}</span></td>
                                    <td>${new Date(record.scan_time).toLocaleString()}</td>
                                    <td><span class="badge badge-success">Present</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        content += `
                            <tr>
                                <td colspan="6" class="text-center">No attendance records found</td>
                            </tr>
                        `;
                    }
                    
                    content += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    $('#event_attendance_content').html(content);
                } else {
                    $('#event_attendance_content').html(`
                        <div class="alert alert-danger">
                            <i class="fa fa-times"></i> Failed to load attendance data: ${resp.msg}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#event_attendance_content').html(`
                    <div class="alert alert-danger">
                        <i class="fa fa-times"></i> Error loading attendance data
                    </div>
                `);
            }
        });
    });
});
</script>
