<?php
require_once('./../../config.php');

$position = isset($_GET['position']) ? $_GET['position'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$is_edit = !empty($id);

// Fetch existing data if editing
$official_data = null;
if($is_edit) {
    $official_query = $conn->query("SELECT * FROM `sk_officials` WHERE `id` = '{$id}' AND `status` = 1");
    if($official_query && $official_query->num_rows > 0) {
        $official_data = $official_query->fetch_assoc();
        // Use the position from database if not provided in URL
        if(empty($position)) {
            $position = $official_data['position'];
        }
    }
}

$position_display = '';
switch($position) {
    case 'chairman': $position_display = 'SK Chairman'; break;
    case 'secretary': $position_display = 'SK Secretary'; break;
    case 'treasurer': $position_display = 'SK Treasurer'; break;
    case 'kagawad': $position_display = 'SK Kagawad'; break;
    default: $position_display = 'SK Official'; break;
}
?>

<div class="container-fluid">
    <form action="" id="assign-official-form" enctype="multipart/form-data">
        <input type="hidden" name="position" value="<?php echo $position ?>">
        <?php if($is_edit): ?>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="image" class="control-label">Photo (Optional)</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
            <small class="text-muted"><?php echo $is_edit ? 'Upload a new photo to replace current photo' : 'Upload a photo for the official' ?></small>
            
            <?php if($is_edit && !empty($official_data['image_path'])): ?>
            <div id="current_image" class="mt-2">
                <label class="text-muted">Current Photo:</label><br>
                <img src="<?php echo base_url ?>uploads/sk_officials/<?php echo $official_data['image_path'] ?>" alt="Current Photo" style="max-width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
            </div>
            <?php endif; ?>
            
            <div id="image_preview" class="mt-2" style="display: none;">
                <label class="text-muted">New Photo Preview:</label><br>
                <img id="preview_img" src="" alt="Preview" style="max-width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="firstname" class="control-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required value="<?php echo $is_edit ? htmlspecialchars($official_data['firstname']) : '' ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="middlename" class="control-label">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" id="middlename" value="<?php echo $is_edit ? htmlspecialchars($official_data['middlename']) : '' ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="lastname" class="control-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required value="<?php echo $is_edit ? htmlspecialchars($official_data['lastname']) : '' ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contact" class="control-label">Contact Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="contact" id="contact" required placeholder="e.g. 09123456789" value="<?php echo $is_edit ? htmlspecialchars($official_data['contact']) : '' ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="control-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="e.g. john.doe@email.com" value="<?php echo $is_edit ? htmlspecialchars($official_data['email']) : '' ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="zone" class="control-label">Zone <span class="text-danger">*</span></label>
            <select class="form-control" name="zone" id="zone" required>
                <option value="" disabled <?php echo !$is_edit ? 'selected' : '' ?>>Select Zone</option>
                <?php for($i = 1; $i <= 7; $i++): ?>
                <option value="Zone <?php echo $i ?>" <?php echo ($is_edit && $official_data['zone'] == "Zone $i") ? 'selected' : '' ?>>Zone <?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_of_birth" class="control-label">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required value="<?php echo $is_edit ? $official_data['date_of_birth'] : '' ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sex" class="control-label">Sex <span class="text-danger">*</span></label>
                    <select class="form-control" name="sex" id="sex" required>
                        <option value="" disabled <?php echo !$is_edit ? 'selected' : '' ?>>Select Gender</option>
                        <option value="Male" <?php echo ($is_edit && $official_data['sex'] == 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?php echo ($is_edit && $official_data['sex'] == 'Female') ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    // Handle image preview
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_img').attr('src', e.target.result);
                $('#image_preview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#image_preview').hide();
        }
    });

    // Handle form submission
    $('#assign-official-form').submit(function(e){
        e.preventDefault();
        var _this = $(this)
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=assign_sk_official",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: function(xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText);
                console.log("Status:", status);
                console.log("Error:", error);
                alert_toast("Network error occurred: " + error, 'error');
                end_loader();
            },
            success: function(resp){
                console.log("Response:", resp);
                if(typeof resp =='object' && resp.status == 'success'){
                    alert_toast(resp.msg, 'success')
                    setTimeout(() => {
                        $('#uni_modal').modal('hide');
                        location.reload()
                    }, 1500)
                } else if(resp.status == 'failed' && !!resp.msg){
                    var el = $('<div>')
                    el.addClass("alert alert-danger err-msg").text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                    $("html, body, .modal").scrollTop(0);
                    end_loader()
                } else {
                    alert_toast("Unexpected response format", 'error');
                    end_loader();
                    console.log("Full response:", resp)
                }
            }
        })
    })
})
</script>
