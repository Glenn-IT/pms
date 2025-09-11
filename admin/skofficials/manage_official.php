<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `sk_officials` WHERE id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="official-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        
        <?php if(!isset($id) || empty($id)): ?>
        <!-- User Selection Section (for new officials) -->
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Select User to Assign as SK Official <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control select2" required>
                        <option value="">-- Select a User --</option>
                        <?php
                        // Get users who are not already SK officials and are active residents (type 2)
                        $users_qry = $conn->query("SELECT u.* FROM `users` u 
                                                  LEFT JOIN `sk_officials` sk ON u.id = sk.user_id AND sk.status = 1
                                                  WHERE u.type = 2 AND u.status = 1 AND sk.id IS NULL 
                                                  ORDER BY u.firstname ASC");
                        while($user = $users_qry->fetch_assoc()):
                            $user_name = trim($user['firstname'] . ' ' . (!empty($user['middlename']) ? $user['middlename'] . ' ' : '') . $user['lastname']);
                        ?>
                        <option value="<?php echo $user['id'] ?>" 
                                data-firstname="<?php echo $user['firstname'] ?>"
                                data-middlename="<?php echo $user['middlename'] ?>"
                                data-lastname="<?php echo $user['lastname'] ?>"
                                data-birthdate="<?php echo $user['birthdate'] ?>"
                                data-age="<?php echo $user['age'] ?>"
                                data-sex="<?php echo $user['sex'] ?>"
                                data-zone="<?php echo $user['zone'] ?>"
                                data-avatar="<?php echo $user['avatar'] ?>">
                            <?php echo $user_name ?> (Age: <?php echo $user['age'] ?>, Zone: <?php echo $user['zone'] ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- User Preview Section -->
        <div id="user-preview" style="display: none;">
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0">Selected User Preview</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img id="preview-avatar" src="" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" alt="User Photo">
                        </div>
                        <div class="col-md-9">
                            <table class="table table-sm">
                                <tr><td><strong>Name:</strong></td><td id="preview-name"></td></tr>
                                <tr><td><strong>Age:</strong></td><td id="preview-age"></td></tr>
                                <tr><td><strong>Sex:</strong></td><td id="preview-sex"></td></tr>
                                <tr><td><strong>Zone:</strong></td><td id="preview-zone"></td></tr>
                                <tr><td><strong>Birth Date:</strong></td><td id="preview-birthdate"></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Editing existing official -->
        <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : '' ?>">
        
        <!-- Display current user info -->
        <?php
        if(isset($user_id) && $user_id > 0) {
            $user_qry = $conn->query("SELECT * FROM `users` WHERE id = '{$user_id}'");
            if($user_qry->num_rows > 0) {
                $user_data = $user_qry->fetch_assoc();
            }
        }
        ?>
        
        <?php if(isset($user_data)): ?>
        <div class="alert alert-info">
            <strong>Editing SK Official:</strong> 
            <?php echo trim($user_data['firstname'] . ' ' . $user_data['middlename'] . ' ' . $user_data['lastname']); ?>
            (Age: <?php echo $user_data['age'] ?>, Zone: <?php echo $user_data['zone'] ?>)
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Position and Other Details -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="position" class="control-label">Position <span class="text-danger">*</span></label>
                    <select name="position" id="position" class="form-control" required>
                        <option value="" <?php echo !isset($position) ? "selected" : '' ?>>-- Select Position --</option>
                        <option value="chairman" <?php echo isset($position) && $position == "chairman" ? 'selected' : '' ?>>SK Chairman</option>
                        <option value="councilor" <?php echo isset($position) && $position == "councilor" ? 'selected' : '' ?>>SK Councilor</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contact" class="control-label">Contact Number</label>
                    <input name="contact" id="contact" type="text" class="form-control" 
                           value="<?php echo isset($contact) ? $contact : ''; ?>" 
                           placeholder="e.g. 09123456789">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="control-label">Email Address</label>
                    <input name="email" id="email" type="email" class="form-control" 
                           value="<?php echo isset($email) ? $email : ''; ?>" 
                           placeholder="e.g. john.doe@email.com">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="img" class="control-label">Additional Photo (Optional)</label>
                    <input name="img" id="img" type="file" class="form-control" accept="image/png,image/jpeg">
                    <small class="text-muted">Leave blank to use user's avatar</small>
                </div>
            </div>
            <div class="col-md-6">
                <?php if(isset($image_path) && !empty($image_path)): ?>
                <div class="form-group">
                    <label class="control-label">Current Photo</label><br>
                    <img src="<?php echo base_url.'uploads/sk_officials/'.$image_path ?>" alt="Official Photo" 
                         width="100" height="100" style="object-fit: cover; border-radius: 10px;">
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Auto-calculated fields -->
        <input type="hidden" name="status" value="1">
    </form>
</div>

<script>
$(document).ready(function(){
    // Initialize select2 for better user selection
    if($('#user_id').length) {
        $('#user_id').select2({
            dropdownParent: $('#uni_modal'),
            placeholder: "Search and select a user...",
            allowClear: true
        });
    }

    // Pre-select position if passed as parameter
    <?php if(isset($_GET['position'])): ?>
    $('#position').val('<?php echo $_GET['position']; ?>');
    <?php endif; ?>

    // Handle user selection
    $('#user_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        if(selectedOption.val()) {
            // Show user preview
            $('#user-preview').show();
            
            // Update preview data
            var avatar = selectedOption.data('avatar');
            var avatarSrc = avatar ? '<?php echo base_url ?>uploads/avatars/' + avatar : 'https://via.placeholder.com/100x100.png?text=No+Photo';
            
            $('#preview-avatar').attr('src', avatarSrc);
            $('#preview-name').text(selectedOption.data('firstname') + ' ' + 
                                  (selectedOption.data('middlename') || '') + ' ' + 
                                  selectedOption.data('lastname'));
            $('#preview-age').text(selectedOption.data('age'));
            $('#preview-sex').text(selectedOption.data('sex'));
            $('#preview-zone').text('Zone ' + selectedOption.data('zone'));
            $('#preview-birthdate').text(selectedOption.data('birthdate'));
        } else {
            $('#user-preview').hide();
        }
    });

    $('#official-form').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();
        
        // Validate user selection for new officials
        if(!$('#user_id').val() && !$('input[name="user_id"]').val()) {
            alert_toast("Please select a user to assign as SK Official", 'error');
            return false;
        }

        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_official",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if(typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else if(resp.status == 'failed' && !!resp.msg) {
                    var el = $('<div>');
                    el.addClass("alert alert-danger err-msg").text(resp.msg);
                    _this.prepend(el);
                    el.show('slow');
                    $("html, body, .modal").scrollTop(0);
                    end_loader();
                } else {
                    alert_toast("An error occurred", 'error');
                    end_loader();
                    console.log(resp);
                }
            }
        });
    });
});
</script>
