
<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<script>
    const adminType = <?php echo json_encode($_settings->userdata('type')); ?>;
</script>

<style>
    .announcement-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: flex-start;
    }
    .announcement-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: box-shadow 0.2s;
        width: 100%;
        max-width: 370px;
        display: flex;
        flex-direction: column;
        margin-bottom: 1.5rem;
    }
    .announcement-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.16);
    }
    .announcement-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f5f5f5;
    }
    .announcement-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
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
        margin-bottom: 1rem;
        min-height: 60px;
    }
    .announcement-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }
    @media (max-width: 900px) {
        .announcement-grid {
            flex-direction: column;
            gap: 1rem;
        }
        .announcement-card {
            max-width: 100%;
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

<!-- Modal (Optional for future adding/editing) -->
<div class="modal fade" id="announcement_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <form id="announcement_form">
        <input type="hidden" name="id" id="announcement_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Announcement</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="img">Announcement Image</label>
                        <input type="file" class="form-control" name="img" accept="image/*" required>
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
        html += `
            <div class="announcement-card">
                <img src="../${ann.image_path}" class="announcement-img" alt="Announcement">
                <div class="announcement-body">
                    <div class="announcement-date">
                        <i class="fa fa-calendar"></i> ${ann.date}
                    </div>
                    <div class="announcement-desc">${ann.description}</div>
                    ${adminType == 1 ? `
                    <div class="announcement-actions">
                        <button class="btn btn-sm btn-primary edit_announcement" data-id="${ann.id}" data-date="${ann.date_created}" data-description="${ann.description}"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-sm btn-danger delete_announcement" data-id="${ann.id}"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    $('#announcement_list').html(html);
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

$(function(){
    loadAllAnnouncements();

    $('#sort_announcement').on('change', function() {
        renderAnnouncements($(this).val());
    });

    $('#announcement_form').submit(function(e){
        e.preventDefault();
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

    // Reset Modal on Add
    $('#add_announcement').click(function(){
        $('#announcement_form')[0].reset();
        $('#announcement_id').val('');
        $('[name="img"]').prop('required', true);
        $('#announcement_modal .modal-title').text('Add New Announcement');
        $('#announcement_modal').modal('show');
    });

    // Delete Announcement
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

    // Edit Announcement
    $(document).on('click', '.edit_announcement', function(){
        const id = $(this).data('id');
        const date = $(this).data('date');
        const description = $(this).data('description');

        $('#announcement_modal .modal-title').text('Edit Announcement');
        $('#announcement_id').val(id);
        $('[name="description"]').val(description);
        $('[name="date"]').val(new Date(date).toISOString().slice(0,16));
        $('[name="img"]').prop('required', false);
        $('#announcement_modal').modal('show');
    });

    // (Optional) View for non-admins
    if(adminType == 0){
        $(document).on('click', '#announcement_list ul li', function(){
            const img = $(this).data('image');
            const date = $(this).data('date');
            const description = $(this).data('description');

            $('#view_announcement_img').attr('src', img);
            $('#view_announcement_date').text(date);
            $('#view_announcement_desc').text(description);

            $('#announcement_view_modal').modal('show');
        });
    }
});
</script>