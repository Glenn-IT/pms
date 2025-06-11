<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<script>
    const adminType = <?php echo json_encode($_settings->userdata('type')); ?>;
</script>

<style>
    .announcement-img {
        width: 100%;
        max-width: 600px; /* Adjust this as needed for size */
        height: auto;
        display: block;
        margin: 0 auto 1rem auto;
        border: 1px solid #ccc;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>


<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Announcement</h3>
		
		<?php if($_settings->userdata('type') == 1): ?>
<div class="card-tools">
	
    <button class="btn btn-primary btn-sm" type="button" id="add_announcement">
        <i class="fa fa-plus"></i> Add Announcement
    </button>
</div>

<?php endif; ?>

	</div>
	<div class="card-body">
		<div class="container-fluid">
		<div id="announcement_list" class="row">
				<!-- Image Viewer -->
				<img src="uploads/announcements/sample.jpg" alt="Announcement Image" class="announcement-img" id="announcement_img">

				<!-- Date and Time -->
				<p><strong>Date & Time:</strong> <span id="announcement_date">June 11, 2025 - 2:30 PM</span></p>

				<!-- Description -->
				<p><strong>Description:</strong></p>
				<p id="announcement_desc">
					This is a sample announcement regarding upcoming changes to prison policy. Please review all updates and reach out if you have questions.
				</p>
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
function loadAllAnnouncements(){
	$.ajax({
		url: '../classes/Master.php?f=get_all_announcements',
		method: 'GET',
		dataType: 'json',
		success: function(resp){
			if(resp.status === 'success'){
				let html = '';
				resp.data.forEach(ann => {
					html += `
						<div class="col-md-6 mb-4">
							<div class="card">
								<img src="../${ann.image_path}" class="card-img-top announcement-img" alt="Announcement">
								<div class="card-body">
									<h5 class="card-title">${ann.date}</h5>
									<p class="card-text">${ann.description}</p>
									${adminType == 1 ? `
										<button class="btn btn-sm btn-primary edit_announcement" data-id="${ann.id}" data-date="${ann.date_created}" data-description="${ann.description}">Edit</button>
										<button class="btn btn-sm btn-danger delete_announcement" data-id="${ann.id}">Delete</button>
									` : ''}
								</div>
							</div>
						</div>
					`;
				});
				$('#announcement_list').html(html);
			} else {
				$('#announcement_list').html('<p>No announcements found.</p>');
			}
		},
		error: function(xhr){
			console.error(xhr.responseText);
			$('#announcement_list').html('<p>Error loading announcements.</p>');
		}
	});
}



$(function(){
	loadAllAnnouncements();



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
						loadAllAnnouncements(); // reload content dynamically
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
	$('[name="date"]').val(new Date(date).toISOString().slice(0,16)); // format for datetime-local
	$('[name="img"]').prop('required', false); // image not required for edit
	$('#announcement_modal').modal('show');
});

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
