<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<script>
    const adminType = <?php echo json_encode($_settings->userdata('type')); ?>;
</script>

<style>
    .banner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .banner-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .banner-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.16);
    }

    .banner-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f5f5f5;
        flex-shrink: 0;
        cursor: pointer;
    }

    .banner-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .banner-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .banner-date {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 0.75rem;
    }

    .banner-status {
        margin-bottom: 0.75rem;
    }

    .banner-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
        flex-wrap: wrap;
    }

    .banner-actions .btn {
        flex: 1;
        min-width: 80px;
        font-size: 0.85rem;
    }

    .image-preview-container {
        margin-top: 10px;
        text-align: center;
    }

    .image-preview-container img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #ddd;
    }

    @media (max-width: 900px) {
        .banner-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Banner Management</h3>
        <div class="d-flex align-items-center ml-auto">
            <label for="sort_banner" class="mr-2 mb-0" style="font-weight:normal;">Sort by:</label>
            <select id="sort_banner" class="form-control form-control-sm mr-3" style="width:auto;">
                <option value="desc">Newest First</option>
                <option value="asc">Oldest First</option>
            </select>
            <?php if($_settings->userdata('type') == 1): ?>
            <button class="btn btn-primary btn-sm" type="button" id="add_banner">
                <i class="fa fa-plus"></i> Add Banner
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="banner_list" class="banner-grid">
                <!-- Banners will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Banner -->
<div class="modal fade" id="banner_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="banner_form">
            <input type="hidden" name="id" id="banner_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Banner</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Banner Title</label>
                        <input type="text" class="form-control" name="title" required>
                        <small class="text-muted">Enter a descriptive title for this banner</small>
                    </div>
                    <div class="form-group">
                        <label for="img">Banner Image</label>
                        <input type="file" class="form-control" name="image" id="banner_image" accept="image/*" required>
                        <small class="text-muted">Recommended size: 1920x600px (Wide banner format)</small>
                        <div id="image_preview_container" class="image-preview-container"></div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description (Optional)</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Add a brief description about this banner..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <small class="text-muted">Only active banners will be displayed on the website</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save Banner</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal for View Banner -->
<div class="modal fade" id="view_banner_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Banner Preview</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="view_banner_content" class="text-center">
                    <!-- Banner image will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
let bannerData = [];

function renderBanners(sortOrder = 'desc') {
    if (!bannerData.length) {
        $('#banner_list').html('<p class="text-center">No banners found.</p>');
        return;
    }
    
    let sorted = [...bannerData];
    sorted.sort((a, b) => {
        const dateA = new Date(a.date_created);
        const dateB = new Date(b.date_created);
        return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
    });
    
    let html = '';
    sorted.forEach(banner => {
        const statusBadge = banner.status == 1 
            ? '<span class="badge badge-success">Active</span>' 
            : '<span class="badge badge-secondary">Inactive</span>';
        
        const imagePath = banner.image_path ? `../${banner.image_path}` : '../assets/images/placeholder.jpg';
        
        html += `
            <div class="banner-card">
                <img src="${imagePath}" class="banner-img" alt="Banner" onclick="viewBanner(${banner.id})">
                <div class="banner-body">
                    <div class="banner-title">${banner.title}</div>
                    <div class="banner-date">
                        <i class="fa fa-calendar"></i> ${banner.date}
                    </div>
                    <div class="banner-status">
                        ${statusBadge}
                    </div>
                    ${banner.description ? `<div class="mb-2" style="font-size: 0.9rem; color: #666;">${banner.description}</div>` : ''}
                    <div class="banner-actions">
                        <button class="btn btn-sm btn-info view_banner" data-id="${banner.id}">
                            <i class="fa fa-eye"></i> View
                        </button>
                        ${adminType == 1 ? `
                        <button class="btn btn-sm btn-primary edit_banner" 
                            data-id="${banner.id}" 
                            data-title="${banner.title}" 
                            data-description="${banner.description || ''}"
                            data-status="${banner.status}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm ${banner.status == 1 ? 'btn-warning' : 'btn-success'} toggle_status" 
                            data-id="${banner.id}" 
                            data-status="${banner.status}">
                            <i class="fa fa-${banner.status == 1 ? 'eye-slash' : 'eye'}"></i> 
                            ${banner.status == 1 ? 'Deactivate' : 'Activate'}
                        </button>
                        <button class="btn btn-sm btn-danger delete_banner" data-id="${banner.id}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    });
    
    $('#banner_list').html(html);
}

function loadAllBanners() {
    $.ajax({
        url: '../classes/Master.php?f=get_all_banners',
        method: 'GET',
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                bannerData = resp.data;
                renderBanners($('#sort_banner').val());
            } else {
                bannerData = [];
                renderBanners();
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            bannerData = [];
            renderBanners();
        }
    });
}

function viewBanner(bannerId) {
    const banner = bannerData.find(b => b.id == bannerId);
    if (banner) {
        const imagePath = banner.image_path ? `../${banner.image_path}` : '../assets/images/placeholder.jpg';
        let content = `
            <div>
                <h4>${banner.title}</h4>
                ${banner.description ? `<p>${banner.description}</p>` : ''}
                <img src="${imagePath}" class="img-fluid" alt="Banner" style="max-width: 100%; cursor: zoom-in;" onclick="window.open('${imagePath}', '_blank')">
            </div>
        `;
        $('#view_banner_content').html(content);
        $('#view_banner_modal').modal('show');
    }
}

$(function() {
    loadAllBanners();

    $('#sort_banner').on('change', function() {
        renderBanners($(this).val());
    });

    // Image preview functionality
    $('#banner_image').on('change', function() {
        const file = this.files[0];
        const container = $('#image_preview_container');
        container.empty();
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = $(`<img src="${e.target.result}" alt="Preview">`);
                container.append(preview);
            };
            reader.readAsDataURL(file);
        }
    });

    // View banner
    $(document).on('click', '.view_banner', function() {
        const bannerId = $(this).data('id');
        viewBanner(bannerId);
    });

    $('#banner_form').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        $.ajax({
            url: '../classes/Master.php?f=save_banner',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    alert_toast("Banner saved successfully", 'success');
                    setTimeout(() => {
                        loadAllBanners();
                        $('#banner_modal').modal('hide');
                    }, 1000);
                } else {
                    alert_toast(resp.msg || "Failed to save banner", 'error');
                }
            },
            error: function(xhr) {
                alert_toast("AJAX Error", 'error');
                console.error(xhr.responseText);
            }
        });
    });

    $('#add_banner').click(function() {
        $('#banner_form')[0].reset();
        $('#banner_id').val('');
        $('#image_preview_container').empty();
        $('#banner_image').prop('required', true);
        $('#banner_modal .modal-title').text('Add New Banner');
        $('#banner_modal').modal('show');
    });

    $(document).on('click', '.delete_banner', function() {
        if (confirm("Are you sure you want to delete this banner?")) {
            let id = $(this).data('id');
            $.ajax({
                url: '../classes/Master.php?f=delete_banner',
                method: 'POST',
                data: { id },
                dataType: 'json',
                success: function(resp) {
                    if (resp.status === 'success') {
                        alert_toast("Banner deleted successfully", 'success');
                        loadAllBanners();
                    } else {
                        alert_toast("Failed to delete banner", 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert_toast("AJAX Error", 'error');
                }
            });
        }
    });

    $(document).on('click', '.edit_banner', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const description = $(this).data('description');
        const status = $(this).data('status');

        $('#banner_modal .modal-title').text('Edit Banner');
        $('#banner_id').val(id);
        $('[name="title"]').val(title);
        $('[name="description"]').val(description);
        $('[name="status"]').val(status);
        $('#banner_image').prop('required', false);
        $('#image_preview_container').empty();
        $('#banner_modal').modal('show');
    });

    $(document).on('click', '.toggle_status', function() {
        const id = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus == 1 ? 0 : 1;
        const action = newStatus == 1 ? 'activate' : 'deactivate';
        
        if (confirm(`Are you sure you want to ${action} this banner?`)) {
            $.ajax({
                url: '../classes/Master.php?f=toggle_banner_status',
                method: 'POST',
                data: { id: id, status: newStatus },
                dataType: 'json',
                success: function(resp) {
                    if (resp.status === 'success') {
                        alert_toast(`Banner ${action}d successfully`, 'success');
                        loadAllBanners();
                    } else {
                        alert_toast(`Failed to ${action} banner`, 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert_toast("AJAX Error", 'error');
                }
            });
        }
    });
});
</script>
