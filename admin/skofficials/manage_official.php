<?php
require_once('../../config.php');

// Check if user is admin
if($_settings->userdata('type') != 1){
    echo "<div class='alert alert-danger'>Access Denied. Only administrators can manage SK Officials.</div>";
    exit;
}

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `sk_officials` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
                $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="official-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="firstname" class="control-label">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control form-control-sm" value="<?php echo isset($firstname) ? htmlspecialchars($firstname) : '' ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="middlename" class="control-label">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control form-control-sm" value="<?php echo isset($middlename) ? htmlspecialchars($middlename) : '' ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="lastname" class="control-label">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control form-control-sm" value="<?php echo isset($lastname) ? htmlspecialchars($lastname) : '' ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="position" class="control-label">Position</label>
                    <select name="position" id="position" class="form-control form-control-sm" required>
                        <option value="">Select Position</option>
                        <option value="chairman" <?php echo isset($position) && $position == 'chairman' ? 'selected' : '' ?>>SK Chairman</option>
                        <option value="councilor" <?php echo isset($position) && $position == 'councilor' ? 'selected' : '' ?>>SK Councilor</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="zone" class="control-label">Zone</label>
                    <input type="text" name="zone" id="zone" class="form-control form-control-sm" value="<?php echo isset($zone) ? htmlspecialchars($zone) : '' ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date_of_birth" class="control-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control form-control-sm" value="<?php echo isset($date_of_birth) ? $date_of_birth : '' ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sex" class="control-label">Gender</label>
                    <select name="sex" id="sex" class="form-control form-control-sm" required>
                        <option value="">Select Gender</option>
                        <option value="Male" <?php echo isset($sex) && $sex == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?php echo isset($sex) && $sex == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contact" class="control-label">Contact Number</label>
                    <input type="text" name="contact" id="contact" class="form-control form-control-sm" value="<?php echo isset($contact) ? htmlspecialchars($contact) : '' ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control form-control-sm" value="<?php echo isset($email) ? htmlspecialchars($email) : '' ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="customFile" class="control-label">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group d-flex justify-content-center">
                    <img src="<?php echo validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    #cimg{
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100% 100%;
    }
</style>

<script>
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            _this.siblings('.custom-file-label').html(input.files[0].name)
        }
    }
    
    $(document).ready(function(){
        $('#official-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_official",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp== 'object' && resp.status == 'success'){
                        location.reload();
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
                        alert_toast("An error occurred",'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })
    })
</script>
