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

        <!-- Organizational Chart -->
        <div class="org-chart">
            <!-- Chairman Level -->
            <div class="org-level">
                <div class="org-card chairman-card">
                    <div class="org-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="org-title">SK CHAIRMAN</div>
                    <div class="org-name" id="chairman-name">Juan Dela Cruz</div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="chairman-contact">0917-123-4567</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="chairman-email">chairman@sk.gov.ph</span>
                    </div>
                </div>
            </div>

            <div class="connection-line"></div>

            <!-- Secretary & Treasurer Level -->
            <div class="org-level">
                <div class="org-card secretary-card">
                    <div class="org-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="org-title">SK SECRETARY</div>
                    <div class="org-name" id="secretary-name">Maria Santos</div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="secretary-contact">0918-234-5678</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="secretary-email">secretary@sk.gov.ph</span>
                    </div>
                </div>

                <div class="org-card treasurer-card">
                    <div class="org-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="org-title">SK TREASURER</div>
                    <div class="org-name" id="treasurer-name">Pedro Garcia</div>
                    <div class="org-contact">
                        <i class="fas fa-phone mr-1"></i><span id="treasurer-contact">0919-345-6789</span><br>
                        <i class="fas fa-envelope mr-1"></i><span id="treasurer-email">treasurer@sk.gov.ph</span>
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
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad1-name">Anna Reyes</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad1-contact">0920-456-7890</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad2-name">Carlos Lopez</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad2-contact">0921-567-8901</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad3-name">Sofia Martinez</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad3-contact">0922-678-9012</span>
                        </div>
                    </div>

                    <div class="org-card kagawad-card">
                        <div class="org-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="org-title">KAGAWAD</div>
                        <div class="org-name" id="kagawad4-name">Miguel Torres</div>
                        <div class="org-contact">
                            <i class="fas fa-phone mr-1"></i><span id="kagawad4-contact">0923-789-0123</span>
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
                <form id="officialForm">
                    <input type="hidden" id="officialPosition" name="position">
                    
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="officialEmail"><i class="fas fa-envelope mr-1"></i>Email Address</label>
                                <input type="email" class="form-control" id="officialEmail" name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="officialAge"><i class="fas fa-calendar mr-1"></i>Age</label>
                                <input type="number" class="form-control" id="officialAge" name="age" min="15" max="30">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="officialAddress"><i class="fas fa-map-marker-alt mr-1"></i>Address</label>
                                <textarea class="form-control" id="officialAddress" name="address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="officialStartDate"><i class="fas fa-calendar-check mr-1"></i>Start Date</label>
                                <input type="date" class="form-control" id="officialStartDate" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="officialStatus"><i class="fas fa-check-circle mr-1"></i>Status</label>
                                <select class="form-control" id="officialStatus" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
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
                                <form id="kagawadForm1">
                                    <input type="hidden" name="kagawad_number" value="1">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="kagawad1Name" name="name" value="Anna Reyes">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" id="kagawad1Contact" name="contact" value="0920-456-7890">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" id="kagawad1Email" name="email" value="anna@sk.gov.ph">
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
                                <form id="kagawadForm2">
                                    <input type="hidden" name="kagawad_number" value="2">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="kagawad2Name" name="name" value="Carlos Lopez">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" id="kagawad2Contact" name="contact" value="0921-567-8901">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" id="kagawad2Email" name="email" value="carlos@sk.gov.ph">
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
                                <form id="kagawadForm3">
                                    <input type="hidden" name="kagawad_number" value="3">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="kagawad3Name" name="name" value="Sofia Martinez">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" id="kagawad3Contact" name="contact" value="0922-678-9012">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" id="kagawad3Email" name="email" value="sofia@sk.gov.ph">
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
                                <form id="kagawadForm4">
                                    <input type="hidden" name="kagawad_number" value="4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="kagawad4Name" name="name" value="Miguel Torres">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" id="kagawad4Contact" name="contact" value="0923-789-0123">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" id="kagawad4Email" name="email" value="miguel@sk.gov.ph">
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
    
    // Load current data based on position
    let currentName = '';
    let currentContact = '';
    let currentEmail = '';
    
    switch(position) {
        case 'chairman':
            currentName = $('#chairman-name').text();
            currentContact = $('#chairman-contact').text();
            currentEmail = $('#chairman-email').text();
            break;
        case 'secretary':
            currentName = $('#secretary-name').text();
            currentContact = $('#secretary-contact').text();
            currentEmail = $('#secretary-email').text();
            break;
        case 'treasurer':
            currentName = $('#treasurer-name').text();
            currentContact = $('#treasurer-contact').text();
            currentEmail = $('#treasurer-email').text();
            break;
    }
    
    // Populate form with current data
    $('#officialName').val(currentName);
    $('#officialContact').val(currentContact);
    $('#officialEmail').val(currentEmail);
    $('#officialStatus').val('active');
    
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
    const position = $('#officialPosition').val();
    const name = $('#officialName').val();
    const contact = $('#officialContact').val();
    const email = $('#officialEmail').val();
    
    // Validate required fields
    if (!name || !contact) {
        showErrorToast('Please fill in all required fields (Name and Contact).');
        return;
    }
    
    let targetCard;
    
    // Update the display based on position
    switch(position) {
        case 'chairman':
            $('#chairman-name').text(name);
            $('#chairman-contact').text(contact);
            $('#chairman-email').text(email);
            targetCard = $('.chairman-card');
            break;
        case 'secretary':
            $('#secretary-name').text(name);
            $('#secretary-contact').text(contact);
            $('#secretary-email').text(email);
            targetCard = $('.secretary-card');
            break;
        case 'treasurer':
            $('#treasurer-name').text(name);
            $('#treasurer-contact').text(contact);
            $('#treasurer-email').text(email);
            targetCard = $('.treasurer-card');
            break;
    }
    
    // Close modal
    $('#officialModal').modal('hide');
    
    // Add animation to updated card
    if (targetCard) {
        targetCard.addClass('card-updated');
        setTimeout(() => {
            targetCard.removeClass('card-updated');
        }, 600);
    }
    
    // Show success toast
    showSuccessToast(`SK ${position.charAt(0).toUpperCase() + position.slice(1)} information updated successfully!`);
    
    // Reset form
    form[0].reset();
}

function saveKagawad(kagawadNumber) {
    const name = $('#kagawad' + kagawadNumber + 'Name').val();
    const contact = $('#kagawad' + kagawadNumber + 'Contact').val();
    const email = $('#kagawad' + kagawadNumber + 'Email').val();
    
    // Validate required fields
    if (!name || !contact) {
        showErrorToast(`Please fill in Name and Contact for Kagawad ${kagawadNumber}`);
        return;
    }
    
    // Update the display in the organizational chart
    $('#kagawad' + kagawadNumber + '-name').text(name);
    $('#kagawad' + kagawadNumber + '-contact').text(contact);
    
    // Find and animate the specific kagawad card
    const targetCard = $(`.kagawad-grid .org-card:nth-child(${kagawadNumber})`);
    if (targetCard.length) {
        targetCard.addClass('card-updated');
        setTimeout(() => {
            targetCard.removeClass('card-updated');
        }, 600);
    }
    
    // Show success toast
    showSuccessToast(`Kagawad ${kagawadNumber} information updated successfully!`);
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

function showContactInfo(title, name, contact, email) {
    const contactModal = $(`
        <div class="modal fade" id="contactInfoModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-address-card mr-2"></i>Contact Information
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle" style="font-size: 3em; color: #17a2b8;"></i>
                        </div>
                        <h5 class="text-primary">${title}</h5>
                        <h4 class="mb-3">${name}</h4>
                        <p class="mb-2">
                            <i class="fas fa-phone text-success mr-2"></i>
                            <a href="tel:${contact}" class="text-decoration-none">${contact}</a>
                        </p>
                        ${email ? `
                        <p class="mb-0">
                            <i class="fas fa-envelope text-info mr-2"></i>
                            <a href="mailto:${email}" class="text-decoration-none">${email}</a>
                        </p>
                        ` : ''}
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    // Remove any existing contact modal
    $('#contactInfoModal').remove();
    
    $('body').append(contactModal);
    $('#contactInfoModal').modal('show');
    
    // Remove modal from DOM when hidden
    $('#contactInfoModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Add some interactive effects
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    $('.org-card').hover(
        function() {
            $(this).css('cursor', 'pointer');
        },
        function() {
            $(this).css('cursor', 'default');
        }
    );
    
    $('.org-card').click(function() {
        const title = $(this).find('.org-title').text();
        const name = $(this).find('.org-name').text();
        const contactElement = $(this).find('.org-contact span').first();
        const emailElement = $(this).find('.org-contact span').eq(1);
        
        const contact = contactElement.length ? contactElement.text() : '';
        const email = emailElement.length ? emailElement.text() : '';
        
        showContactInfo(title, name, contact, email);
    });
    
    // Show a brief hint about the close button
    setTimeout(function() {
        if ($('.btn-tool[title="Back to Dashboard"]').length) {
            $('.btn-tool[title="Back to Dashboard"]').tooltip('show');
            setTimeout(function() {
                $('.btn-tool[title="Back to Dashboard"]').tooltip('hide');
            }, 3000);
        }
    }, 1000);
});
</script>
