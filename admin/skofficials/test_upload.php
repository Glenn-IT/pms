<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Officials - Image Upload Test</title>
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .test-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .result-section {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h2 class="text-center mb-4">
            <i class="fas fa-cogs mr-2"></i>SK Officials Image Upload Test
        </h2>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            This page tests the image upload functionality for SK Officials. You can upload test images here.
        </div>
        
        <form id="testForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Position</label>
                        <select class="form-control" name="position" required>
                            <option value="">Select Position</option>
                            <option value="chairman">Chairman</option>
                            <option value="secretary">Secretary</option>
                            <option value="treasurer">Treasurer</option>
                            <option value="kagawad1">Kagawad 1</option>
                            <option value="kagawad2">Kagawad 2</option>
                            <option value="kagawad3">Kagawad 3</option>
                            <option value="kagawad4">Kagawad 4</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter full name" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" class="form-control" name="contact" placeholder="Enter contact number" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email address">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Profile Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="imageFile" accept="image/*">
                    <label class="custom-file-label" for="imageFile">Choose image file...</label>
                </div>
                <small class="form-text text-muted">Maximum file size: 5MB. Supported formats: JPG, PNG, GIF</small>
                
                <div id="imagePreview" class="mt-3" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px; border: 2px solid #ddd;">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save mr-2"></i>Test Upload
            </button>
        </form>
        
        <div id="result" class="result-section" style="display: none;"></div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // File input change handler
        $('#imageFile').change(function() {
            const file = this.files[0];
            const label = $('.custom-file-label');
            
            if (file) {
                label.text(file.name);
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                label.text('Choose image file...');
                $('#imagePreview').hide();
            }
        });
        
        // Form submission
        $('#testForm').submit(function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = $('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...').prop('disabled', true);
            
            $.ajax({
                url: 'manage_officials.php?f=save_official',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(resp) {
                    $('#result').show();
                    if(resp.status === 'success') {
                        $('#result').html(`
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Success!</strong> ${resp.msg}
                            </div>
                        `);
                    } else {
                        $('#result').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Error!</strong> ${resp.msg}
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    $('#result').show().html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Error!</strong> An error occurred while uploading: ${error}
                        </div>
                    `);
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>
