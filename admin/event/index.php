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
    }

    @media (max-width: 900px) {
        .event-grid {
            grid-template-columns: 1fr;
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

<!-- Modal -->
<div class="modal fade" id="event_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
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
                        <label for="img">Event Image</label>
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
let eventData = [];

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
        html += `
            <div class="event-card">
                <img src="../${event.image_path}" class="event-img" alt="Event">
                <div class="event-body">
                    <div class="event-title">${event.title}</div>
                    <div class="event-date">
                        <i class="fa fa-calendar"></i> ${event.date}
                    </div>
                    <div class="event-desc">${event.description}</div>
                    <span class="read-more">Read More</span>
                    ${adminType == 1 ? `
                    <div class="event-actions">
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
                    </div>
                    ` : ''}
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

$(function() {
    loadAllEvents();

    $('#sort_event').on('change', function() {
        renderEvents($(this).val());
    });

    // Read More Toggle
    $(document).on('click', '.read-more', function() {
        const desc = $(this).siblings('.event-desc');
        const card = $(this).closest('.event-card');

        if (desc.hasClass('expanded')) {
            desc.removeClass('expanded');
            $(this).text('Read More');
            card.css('height', ''); // Reset to auto height
        } else {
            desc.addClass('expanded');
            $(this).text('Show Less');
            card.css('height', 'auto'); // Allow auto expansion
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
        $('[name="img"]').prop('required', true);
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
        $('[name="img"]').prop('required', false);
        $('#event_modal').modal('show');
    });
});
</script>
