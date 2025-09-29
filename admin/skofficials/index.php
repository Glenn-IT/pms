<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .org-chart {
        text-align: center;
        padding: 20px;
    }
    
    .org-level {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    
    .org-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 20px;
        margin: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        color: white;
        min-width: 200px;
        max-width: 250px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .org-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.2);
    }
    
    .org-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }
    
    .chairman-card {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        min-width: 280px;
    }
    
    .secretary-card {
        background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
    }
    
    .treasurer-card {
        background: linear-gradient(135deg, #45b7d1 0%, #96c93d 100%);
    }
    
    .kagawad-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        min-width: 180px;
    }
    
    .org-icon {
        font-size: 3em;
        margin-bottom: 15px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .org-title {
        font-size: 1.4em;
        font-weight: bold;
        margin-bottom: 8px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    .org-name {
        font-size: 1.1em;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .org-contact {
        font-size: 0.9em;
        opacity: 0.9;
    }
    
    .connection-line {
        height: 2px;
        background: #ddd;
        margin: 20px auto;
        width: 80%;
        position: relative;
    }
    
    .connection-line::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        background: #667eea;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .kagawad-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 2.5em;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .page-header p {
        margin: 10px 0 0 0;
        font-size: 1.2em;
        opacity: 0.9;
    }
    
    .action-buttons {
        text-align: center;
        margin: 30px 0;
    }
    
    .btn-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 500;
        transition: transform 0.3s ease;
        margin: 0 10px;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    
    .btn-tool:hover {
        background-color: rgba(255,255,255,0.2);
        border-radius: 4px;
        color: #fff;
    }
    
    .close-button-hint {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    /* Success Toast Notification Styles */
    .success-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(40, 167, 69, 0.3);
        z-index: 9999;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        min-width: 300px;
        display: flex;
        align-items: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .success-toast.show {
        opacity: 1;
        transform: translateX(0);
    }
    
    .success-toast .toast-icon {
        font-size: 1.5em;
        margin-right: 15px;
        animation: bounceIn 0.6s ease-out;
    }
    
    .success-toast .toast-message {
        flex: 1;
        font-weight: 500;
    }
    
    .success-toast .toast-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.2em;
        cursor: pointer;
        margin-left: 10px;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .success-toast .toast-close:hover {
        opacity: 1;
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.3); opacity: 0; }
        50% { transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes cardUpdate {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); box-shadow: 0 16px 48px rgba(0,0,0,0.3); }
        100% { transform: scale(1); }
    }
    
    .card-updated {
        animation: cardUpdate 0.6s ease-out;
    }
    
    /* Progress bar for toast */
    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 0 0 10px 10px;
        animation: progressBar 3s linear forwards;
    }
    
    @keyframes progressBar {
        from { width: 100%; }
        to { width: 0%; }
    }
    
    /* Image Upload Styles */
    .image-upload-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .image-preview {
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .image-preview:hover {
        transform: scale(1.05);
    }
    
    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        border: 2px dashed #ddd;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .upload-placeholder:hover {
        border-color: #007bff;
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .org-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100px;
    }
    
    .org-image img {
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .org-image img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    
    /* Kagawad Modal Image Styles */
    .kagawad-image-preview {
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }
    
    .kagawad-image-preview:hover {
        transform: scale(1.05);
    }
    
    .kagawad-upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border: 1px dashed #ccc;
        border-radius: 8px;
        transition: all 0.3s ease;
        min-height: 100px;
    }
    
    .kagawad-upload-placeholder:hover {
        border-color: #007bff;
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    @media (max-width: 768px) {
        .org-level {
            flex-direction: column;
            align-items: center;
        }
        
        .kagawad-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header h1 {
            font-size: 2em;
        }
        
        .success-toast {
            right: 10px;
            left: 10px;
            min-width: auto;
        }
        
        .org-image img {
            width: 60px !important;
            height: 60px !important;
        }
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> SK Officials Management</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" onclick="goBackToDashboard()" title="Back to Dashboard" data-toggle="tooltip" data-placement="left">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-sitemap"></i> Sangguniang Kabataan</h1>
            <p>Organizational Chart & Officials Directory</p>
        </div>

        <!-- Action Buttons -->
        <?php if($_settings->userdata('type') == 1): ?>
        <div class="action-buttons">
            <button class="btn btn-custom" onclick="manage_official('chairman')">
                <i class="fas fa-user-plus mr-2"></i>Manage Chairman
            </button>
            <button class="btn btn-custom" onclick="manage_official('secretary')">
                <i class="fas fa-user-edit mr-2"></i>Manage Secretary
            </button>
            <button class="btn btn-custom" onclick="manage_official('treasurer')">
                <i class="fas fa-coins mr-2"></i>Manage Treasurer
            </button>
            <button class="btn btn-custom" onclick="manage_kagawad()">
                <i class="fas fa-users-cog mr-2"></i>Manage Kagawads
            </button>
        </div>
        <?php endif; ?>

        <!-- Organizational Chart -->
        <div class="org-chart">
            <!-- Chairman Level -->
            <div class="org-level">
                <div class="org-card chairman-card">
                    <div class="org-image">
                        <img id="chairman-image" src="" alt="Chairman" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                        <div id="chairman-icon" class="org-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                    <div class="org-title">SK CHAIRMAN</div>
                    <div class="org-name" id="chairman-name">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Loading...
                    </div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="chairman-contact">...</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="chairman-email">...</span>
                    </div>
                </div>
            </div>

            <div class="connection-line"></div>

            <!-- Secretary & Treasurer Level -->
            <div class="org-level">
                <div class="org-card secretary-card">
                    <div class="org-image">
                        <img id="secretary-image" src="" alt="Secretary" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                        <div id="secretary-icon" class="org-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="org-title">SK SECRETARY</div>
                    <div class="org-name" id="secretary-name">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Loading...
                    </div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="secretary-contact">...</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="secretary-email">...</span>
                    </div>
                </div>

                <div class="org-card treasurer-card">
                    <div class="org-image">
                        <img id="treasurer-image" src="" alt="Treasurer" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                        <div id="treasurer-icon" class="org-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <div class="org-title">SK TREASURER</div>
                    <div class="org-name" id="treasurer-name">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Loading...
                    </div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="treasurer-contact">...</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="treasurer-email">...</span>
                    </div>
                </div>
            </div>

            <div class="connection-line"></div>

            <!-- Kagawads Level -->
            <div class="org-level">
                <h4 style="width: 100%; margin-bottom: 20px; color: #667eea;">
                    <i class="fas fa-users mr-2"></i>SK KAGAWADS
                </h4>
                <div class="kagawad-grid">
                    <div class="org-card kagawad-card">
                        <div class="org-image">
                            <img id="kagawad1-image" src="" alt="Kagawad 1" style="display: none; width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                            <div id="kagawad1-icon" class="org-icon" style="font-size: 2.5em;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad1-name">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Loading...
                        </div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad1-contact">...</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-image">
                            <img id="kagawad2-image" src="" alt="Kagawad 2" style="display: none; width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                            <div id="kagawad2-icon" class="org-icon" style="font-size: 2.5em;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad2-name">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Loading...
                        </div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad2-contact">...</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-image">
                            <img id="kagawad3-image" src="" alt="Kagawad 3" style="display: none; width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                            <div id="kagawad3-icon" class="org-icon" style="font-size: 2.5em;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad3-name">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Loading...
                        </div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad3-contact">...</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-image">
                            <img id="kagawad4-image" src="" alt="Kagawad 4" style="display: none; width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid white; margin-bottom: 10px;">
                            <div id="kagawad4-icon" class="org-icon" style="font-size: 2.5em;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad4-name">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Loading...
                        </div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad4-contact">...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Managing Officials -->
<div class="modal fade" id="officialModal" tabindex="-1" role="dialog" aria-labelledby="officialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="officialModalLabel">
                    <i class="fas fa-user-edit mr-2"></i>Manage Official
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="officialForm" enctype="multipart/form-data">
                    <input type="hidden" id="officialPosition" name="position">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group text-center">
                                <label><i class="fas fa-camera mr-1"></i>Profile Picture</label>
                                <div class="image-upload-container">
                                    <div class="image-preview" id="imagePreview">
                                        <img id="previewImg" src="" alt="Preview" style="display: none; width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #ddd;">
                                        <div class="upload-placeholder" id="uploadPlaceholder">
                                            <i class="fas fa-user-circle" style="font-size: 8em; color: #ddd;"></i>
                                            <p class="mt-2 text-muted">Click to upload image</p>
                                        </div>
                                    </div>
                                    <input type="file" class="form-control-file mt-2" id="officialImage" name="image" accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="$('#officialImage').click()">
                                        <i class="fas fa-upload mr-1"></i>Choose Image
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm mt-2" id="removeImageBtn" onclick="removeImage()" style="display: none;">
                                        <i class="fas fa-trash mr-1"></i>Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="officialName"><i class="fas fa-user mr-1"></i>Full Name</label>
                                        <input type="text" class="form-control" id="officialName" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="officialContact"><i class="fas fa-phone mr-1"></i>Contact Number</label>
                                        <input type="text" class="form-control" id="officialContact" name="contact" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="officialEmail"><i class="fas fa-envelope mr-1"></i>Email Address</label>
                                        <input type="email" class="form-control" id="officialEmail" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveOfficial()">
                    <i class="fas fa-save mr-1"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Managing Kagawads -->
<div class="modal fade" id="kagawadModal" tabindex="-1" role="dialog" aria-labelledby="kagawadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="kagawadModalLabel">
                    <i class="fas fa-users-cog mr-2"></i>Manage SK Kagawads
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kagawad 1 -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-user-tie mr-1"></i>Kagawad 1</h6>
                            </div>
                            <div class="card-body">
                                <form id="kagawadForm1" enctype="multipart/form-data">
                                    <input type="hidden" name="kagawad_number" value="1">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="form-group">
                                                <label>Profile Picture</label>
                                                <div class="kagawad-image-preview" id="kagawadImagePreview1">
                                                    <img id="kagawadPreviewImg1" src="" alt="Preview" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                                                    <div class="kagawad-upload-placeholder" id="kagawadUploadPlaceholder1">
                                                        <i class="fas fa-user-circle" style="font-size: 4em; color: #ddd;"></i>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control-file mt-1" id="kagawadImage1" name="image" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-outline-primary btn-sm mt-1" onclick="$('#kagawadImage1').click()">
                                                    <i class="fas fa-upload mr-1"></i>Choose
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" id="kagawad1Name" name="name" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" id="kagawad1Contact" name="contact" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" id="kagawad1Email" name="email" placeholder="Loading...">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="saveKagawad(1)">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kagawad 2 -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-user-tie mr-1"></i>Kagawad 2</h6>
                            </div>
                            <div class="card-body">
                                <form id="kagawadForm2" enctype="multipart/form-data">
                                    <input type="hidden" name="kagawad_number" value="2">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="form-group">
                                                <label>Profile Picture</label>
                                                <div class="kagawad-image-preview" id="kagawadImagePreview2">
                                                    <img id="kagawadPreviewImg2" src="" alt="Preview" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                                                    <div class="kagawad-upload-placeholder" id="kagawadUploadPlaceholder2">
                                                        <i class="fas fa-user-circle" style="font-size: 4em; color: #ddd;"></i>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control-file mt-1" id="kagawadImage2" name="image" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-outline-primary btn-sm mt-1" onclick="$('#kagawadImage2').click()">
                                                    <i class="fas fa-upload mr-1"></i>Choose
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" id="kagawad2Name" name="name" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" id="kagawad2Contact" name="contact" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" id="kagawad2Email" name="email" placeholder="Loading...">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="saveKagawad(2)">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kagawad 3 -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-user-tie mr-1"></i>Kagawad 3</h6>
                            </div>
                            <div class="card-body">
                                <form id="kagawadForm3" enctype="multipart/form-data">
                                    <input type="hidden" name="kagawad_number" value="3">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="form-group">
                                                <label>Profile Picture</label>
                                                <div class="kagawad-image-preview" id="kagawadImagePreview3">
                                                    <img id="kagawadPreviewImg3" src="" alt="Preview" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                                                    <div class="kagawad-upload-placeholder" id="kagawadUploadPlaceholder3">
                                                        <i class="fas fa-user-circle" style="font-size: 4em; color: #ddd;"></i>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control-file mt-1" id="kagawadImage3" name="image" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-outline-primary btn-sm mt-1" onclick="$('#kagawadImage3').click()">
                                                    <i class="fas fa-upload mr-1"></i>Choose
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" id="kagawad3Name" name="name" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" id="kagawad3Contact" name="contact" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" id="kagawad3Email" name="email" placeholder="Loading...">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="saveKagawad(3)">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kagawad 4 -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-user-tie mr-1"></i>Kagawad 4</h6>
                            </div>
                            <div class="card-body">
                                <form id="kagawadForm4" enctype="multipart/form-data">
                                    <input type="hidden" name="kagawad_number" value="4">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="form-group">
                                                <label>Profile Picture</label>
                                                <div class="kagawad-image-preview" id="kagawadImagePreview4">
                                                    <img id="kagawadPreviewImg4" src="" alt="Preview" style="display: none; width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                                                    <div class="kagawad-upload-placeholder" id="kagawadUploadPlaceholder4">
                                                        <i class="fas fa-user-circle" style="font-size: 4em; color: #ddd;"></i>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control-file mt-1" id="kagawadImage4" name="image" accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-outline-primary btn-sm mt-1" onclick="$('#kagawadImage4').click()">
                                                    <i class="fas fa-upload mr-1"></i>Choose
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" id="kagawad4Name" name="name" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" id="kagawad4Contact" name="contact" placeholder="Loading...">
                                            </div>
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" id="kagawad4Email" name="email" placeholder="Loading...">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="saveKagawad(4)">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function manage_official(position) {
    // Set modal title and position
    $('#officialModalLabel').html('<i class="fas fa-user-edit mr-2"></i>Manage SK ' + position.charAt(0).toUpperCase() + position.slice(1));
    $('#officialPosition').val(position);
    
    // Clear form first
    $('#officialForm')[0].reset();
    $('#officialPosition').val(position);
    
    // Reset image preview
    resetImagePreview();
    
    // Load current data from database
    $.ajax({
        url: 'skofficials/manage_officials.php?f=get_official&position=' + position,
        method: 'GET',
        dataType: 'json',
        success: function(resp) {
            if(resp.status === 'success') {
                const data = resp.data;
                $('#officialName').val(data.name);
                $('#officialContact').val(data.contact);
                $('#officialEmail').val(data.email);
                
                // Load existing image if available
                if(data.image) {
                    let fullPath = data.image.startsWith('uploads/') ? '/pms/' + data.image : '/pms/uploads/sk_officials/' + data.image;
                    // console.log('Loading modal image: ' + fullPath); // Debug log
                    $('#previewImg').attr('src', fullPath).show();
                    $('#uploadPlaceholder').hide();
                    $('#removeImageBtn').show();
                }
            }
        },
        error: function(err) {
            console.log(err);
            // Still show modal even if loading fails (for new entries)
        }
    });
    
    // Show modal
    $('#officialModal').modal('show');
}

function manage_kagawad() {
    $('#kagawadModal').modal('show');
}

function goBackToDashboard() {
    // Go back to the main dashboard/home page
    window.location.href = '?page=home';
}

function saveOfficial() {
    const form = $('#officialForm');
    const formData = new FormData(form[0]);
    
    // Validate required fields
    if (!formData.get('name') || !formData.get('contact')) {
        showErrorToast('Please fill in all required fields (Name and Contact).');
        return;
    }
    
    // Show loading state
    const saveBtn = $('.modal-footer .btn-primary');
    const originalText = saveBtn.html();
    saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...').prop('disabled', true);
    
    // Send AJAX request
    $.ajax({
        url: 'skofficials/manage_officials.php?f=save_official',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(resp) {
            if(resp.status === 'success') {
                // Close modal
                $('#officialModal').modal('hide');
                
                // Reload officials data
                loadAllOfficials();
                
                // Show success toast
                showSuccessToast(resp.msg);
                
                // Reset form and image preview
                form[0].reset();
                resetImagePreview();
            } else {
                showErrorToast(resp.msg);
            }
        },
        error: function(err) {
            console.log(err);
            showErrorToast('An error occurred while saving the information.');
        },
        complete: function() {
            // Restore button state
            saveBtn.html(originalText).prop('disabled', false);
        }
    });
}

function saveKagawad(kagawadNumber) {
    const form = $('#kagawadForm' + kagawadNumber);
    const formData = new FormData(form[0]);
    formData.append('position', 'kagawad' + kagawadNumber);
    formData.append('status', 'active');
    
    // Validate required fields
    if (!formData.get('name') || !formData.get('contact')) {
        showErrorToast(`Please fill in Name and Contact for Kagawad ${kagawadNumber}`);
        return;
    }
    
    // Show loading state
    const saveBtn = $(`#kagawadForm${kagawadNumber} .btn-primary`);
    const originalText = saveBtn.html();
    saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Updating...').prop('disabled', true);
    
    // Send AJAX request
    $.ajax({
        url: 'skofficials/manage_officials.php?f=save_official',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(resp) {
            if(resp.status === 'success') {
                // Reload officials data
                loadAllOfficials();
                
                // Show success toast
                showSuccessToast(`Kagawad ${kagawadNumber} information updated successfully!`);
            } else {
                showErrorToast(resp.msg);
            }
        },
        error: function(err) {
            console.log(err);
            showErrorToast('An error occurred while updating the information.');
        },
        complete: function() {
            // Restore button state
            saveBtn.html(originalText).prop('disabled', false);
        }
    });
}

// Toast Notification Functions
function showSuccessToast(message) {
    const toastId = 'toast-' + Date.now();
    const toast = $(`
        <div class="success-toast" id="${toastId}">
            <div class="toast-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" onclick="hideToast('${toastId}')">
                <i class="fas fa-times"></i>
            </button>
            <div class="toast-progress"></div>
        </div>
    `);
    
    $('body').append(toast);
    
    // Show toast with animation
    setTimeout(() => {
        toast.addClass('show');
    }, 100);
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        hideToast(toastId);
    }, 3000);
}

function showErrorToast(message) {
    const toastId = 'toast-' + Date.now();
    const toast = $(`
        <div class="success-toast" id="${toastId}" style="background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); box-shadow: 0 8px 32px rgba(220, 53, 69, 0.3);">
            <div class="toast-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" onclick="hideToast('${toastId}')">
                <i class="fas fa-times"></i>
            </button>
            <div class="toast-progress"></div>
        </div>
    `);
    
    $('body').append(toast);
    
    // Show toast with animation
    setTimeout(() => {
        toast.addClass('show');
    }, 100);
    
    // Auto hide after 4 seconds (longer for error messages)
    setTimeout(() => {
        hideToast(toastId);
    }, 4000);
}

function hideToast(toastId) {
    const toast = $('#' + toastId);
    toast.removeClass('show');
    setTimeout(() => {
        toast.remove();
    }, 400);
}

// Contact info modal function removed - click functionality disabled

// Load all officials from database
function loadAllOfficials() {
    $.ajax({
        url: 'skofficials/manage_officials.php?f=get_all_officials',
        method: 'GET',
        dataType: 'json',
        success: function(resp) {
            if(resp.status === 'success') {
                const officials = resp.data;
                
                // Update Chairman
                if(officials.chairman) {
                    $('#chairman-name').text(officials.chairman.name);
                    $('#chairman-contact').text(officials.chairman.contact);
                    $('#chairman-email').text(officials.chairman.email || '');
                    updateOfficialImage('chairman', officials.chairman.image);
                }
                
                // Update Secretary
                if(officials.secretary) {
                    $('#secretary-name').text(officials.secretary.name);
                    $('#secretary-contact').text(officials.secretary.contact);
                    $('#secretary-email').text(officials.secretary.email || '');
                    updateOfficialImage('secretary', officials.secretary.image);
                }
                
                // Update Treasurer
                if(officials.treasurer) {
                    $('#treasurer-name').text(officials.treasurer.name);
                    $('#treasurer-contact').text(officials.treasurer.contact);
                    $('#treasurer-email').text(officials.treasurer.email || '');
                    updateOfficialImage('treasurer', officials.treasurer.image);
                }
                
                // Update Kagawads
                for(let i = 1; i <= 4; i++) {
                    const kagawadKey = 'kagawad' + i;
                    if(officials[kagawadKey]) {
                        $('#kagawad' + i + '-name').text(officials[kagawadKey].name);
                        $('#kagawad' + i + '-contact').text(officials[kagawadKey].contact);
                        updateOfficialImage('kagawad' + i, officials[kagawadKey].image);
                        
                        // Also update the form values in kagawad modal
                        $('#kagawad' + i + 'Name').val(officials[kagawadKey].name);
                        $('#kagawad' + i + 'Contact').val(officials[kagawadKey].contact);
                        $('#kagawad' + i + 'Email').val(officials[kagawadKey].email || '');
                        
                        // Update kagawad image in modal
                        if(officials[kagawadKey].image) {
                            let fullPath = officials[kagawadKey].image.startsWith('uploads/') ? '/pms/' + officials[kagawadKey].image : '/pms/uploads/sk_officials/' + officials[kagawadKey].image;
                            // console.log('Loading kagawad ' + i + ' modal image: ' + fullPath); // Debug log
                            $('#kagawadPreviewImg' + i).attr('src', fullPath).show();
                            $('#kagawadUploadPlaceholder' + i).hide();
                        } else {
                            $('#kagawadPreviewImg' + i).hide();
                            $('#kagawadUploadPlaceholder' + i).show();
                        }
                        
                        // Add animation to updated card
                        const targetCard = $(`.kagawad-grid .org-card:nth-child(${i})`);
                        if (targetCard.length) {
                            targetCard.addClass('card-updated');
                            setTimeout(() => {
                                targetCard.removeClass('card-updated');
                            }, 600);
                        }
                    }
                }
            }
        },
        error: function(err) {
            console.log('Error loading officials:', err);
        }
    });
}

// Add some interactive effects
$(document).ready(function() {
    // Load officials data when page loads
    loadAllOfficials();
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Removed click functionality for org cards to prevent modal popup
    $('.org-card').hover(
        function() {
            $(this).css('cursor', 'default');
        },
        function() {
            $(this).css('cursor', 'default');
        }
    );
    
    // Show a brief hint about the close button
    setTimeout(function() {
        if ($('.btn-tool[title="Back to Dashboard"]').length) {
            $('.btn-tool[title="Back to Dashboard"]').tooltip('show');
            setTimeout(function() {
                $('.btn-tool[title="Back to Dashboard"]').tooltip('hide');
            }, 3000);
        }
    }, 1000);
    
    // Image upload preview functionality
    $('#officialImage').change(function() {
        const file = this.files[0];
        if (file) {
            // Validate file type
            if (!file.type.match('image.*')) {
                showErrorToast('Please select a valid image file.');
                return;
            }
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                showErrorToast('Image size must be less than 5MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result).show();
                $('#uploadPlaceholder').hide();
                $('#removeImageBtn').show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Make image preview clickable
    $('#imagePreview').click(function() {
        $('#officialImage').click();
    });
    
    // Kagawad image upload handlers
    for(let i = 1; i <= 4; i++) {
        $(`#kagawadImage${i}`).change(function() {
            const file = this.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    showErrorToast('Please select a valid image file.');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showErrorToast('Image size must be less than 5MB.');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(`#kagawadPreviewImg${i}`).attr('src', e.target.result).show();
                    $(`#kagawadUploadPlaceholder${i}`).hide();
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Make kagawad image preview clickable
        $(`#kagawadImagePreview${i}`).click(function() {
            $(`#kagawadImage${i}`).click();
        });
    }
});

// Helper function to update official images in the organizational chart
function updateOfficialImage(position, imagePath) {
    const imageElement = $('#' + position + '-image');
    const iconElement = $('#' + position + '-icon');
    
    if (imagePath) {
        // Use absolute path from website root
        let fullPath;
        if (imagePath.startsWith('uploads/')) {
            fullPath = '/pms/' + imagePath;
        } else if (imagePath.startsWith('/')) {
            fullPath = imagePath;
        } else {
            fullPath = '/pms/uploads/sk_officials/' + imagePath;
        }
        
        // console.log('Loading image for ' + position + ': ' + fullPath); // Debug log
        
        imageElement.attr('src', fullPath)
            .show()
            .on('error', function() {
                console.error('Failed to load image: ' + fullPath);
                // Try alternative path
                let altPath = '../../' + (imagePath.startsWith('uploads/') ? imagePath : 'uploads/sk_officials/' + imagePath);
                // console.log('Trying alternative path: ' + altPath);
                $(this).attr('src', altPath).one('error', function() {
                    console.error('Alternative path also failed: ' + altPath);
                    // Fallback to icon if both paths fail
                    $(this).hide();
                    iconElement.show();
                });
            })
            .on('load', function() {
                // console.log('Successfully loaded image: ' + fullPath);
                iconElement.hide();
            });
    } else {
        imageElement.hide();
        iconElement.show();
    }
}

// Helper function to reset image preview in modal
function resetImagePreview() {
    $('#previewImg').hide();
    $('#uploadPlaceholder').show();
    $('#removeImageBtn').hide();
    $('#officialImage').val('');
}

// Function to remove selected image
function removeImage() {
    resetImagePreview();
}
</script>
