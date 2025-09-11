<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize database constants first
require_once('../../initialize.php');

// Initialize system classes
require_once('../../classes/DBConnection.php');
require_once('../../classes/SystemSettings.php');

$db = new DBConnection;
$conn = $db->conn;

$_settings = new SystemSettings($conn);

// Check if user is logged in
if(!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])){
    echo '<div class="alert alert-warning">Please log in to view your QR code.</div>';
    exit;
}

// Get current logged-in user data
$user_id = $_SESSION['userdata']['id'];
$user = $conn->query("SELECT * FROM users WHERE id = '{$user_id}'");
$user_data = $user->fetch_assoc();
require_once('../../classes/QRCodeGenerator.php');
?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"><i class="fas fa-qrcode"></i> My Personal QR Code</h3>
	</div>
	<div class="card-body">
		<?php if($user_data): ?>
			<div class="row">
				<div class="col-md-8 mx-auto">
					<div class="qr-container">
						<h4><i class="fas fa-id-card-alt"></i> Your Unique Identification Code</h4>
						<p class="mb-0">This QR code uniquely identifies you in the system</p>
					</div>
					<div class="qr-display">
						<?php if(!empty($user_data['qr_code'])): ?>
							<div class="text-center mb-4">
								<i class="fas fa-qrcode fa-5x text-primary mb-3"></i>
								<h5 class="text-primary">Your Personal QR Code</h5>
							</div>
							<div class="qr-code-text" id="qrCodeText">
								<?php echo htmlspecialchars($user_data['qr_code']) ?>
							</div>
							<div class="text-center mt-4">
								<button class="btn btn-primary copy-button" onclick="copyQRCode()">
									<i class="fas fa-copy"></i> Copy QR Code
								</button>
								<button class="btn btn-info ml-2" onclick="generateQRImage()">
									<i class="fas fa-download"></i> Generate QR Image
								</button>
							</div>
							<div class="mt-4 p-3 bg-light rounded">
								<h6><i class="fas fa-info-circle text-info"></i> QR Code Information</h6>
								<?php 
								$validation = QRCodeGenerator::validateQRCode($user_data['qr_code']);
								if($validation): 
								?>
									<div class="row">
										<div class="col-sm-4">
											<strong>User ID:</strong><br>
											<span class="text-primary"><?php echo $validation['user_id'] ?></span>
										</div>
										<div class="col-sm-4">
											<strong>Username:</strong><br>
											<span class="text-primary"><?php echo $validation['username_prefix'] ?></span>
										</div>
										<div class="col-sm-4">
											<strong>Hash:</strong><br>
											<span class="text-primary"><?php echo $validation['hash_prefix'] ?></span>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php else: ?>
							<div class="text-center py-5">
								<i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
								<h5 class="text-warning">No QR Code Generated</h5>
								<p class="text-muted">Your QR code hasn't been generated yet. This usually happens automatically when your profile is created or updated.</p>
								<form method="post" action="">
									<input type="hidden" name="generate_qr" value="1">
									<button type="submit" class="btn btn-primary">
										<i class="fas fa-magic"></i> Generate My QR Code
									</button>
								</form>
							</div>
						<?php endif; ?>
					</div>
					<div class="mt-4 p-3 border rounded">
						<h6><i class="fas fa-question-circle text-info"></i> How to Use Your QR Code</h6>
						<ul class="mb-0 small">
							<li>This QR code uniquely identifies you in the system</li>
							<li>Share it with authorized personnel for quick identification</li>
							<li>You can copy the text or generate a scannable QR image</li>
							<li>Keep your QR code secure and don't share it publicly</li>
						</ul>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="alert alert-danger">
				<i class="fas fa-exclamation-triangle"></i> Unable to load user data. Please contact your administrator.
			</div>
		<?php endif; ?>
	</div>
</div>

<script>
function copyQRCode() {
	const qrText = document.getElementById('qrCodeText').textContent;
	const textarea = document.createElement('textarea');
	textarea.value = qrText;
	document.body.appendChild(textarea);
	textarea.select();
	try {
		document.execCommand('copy');
		alert_toast('QR Code copied to clipboard!', 'success');
	} catch (err) {
		alert_toast('Failed to copy QR Code', 'error');
	}
	document.body.removeChild(textarea);
}
function generateQRImage() {
	const qrText = document.getElementById('qrCodeText').textContent;
	const encodedData = encodeURIComponent(qrText);
	const qrImageUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodedData}`;
	const imageHtml = `<img src="${qrImageUrl}" alt="QR Code" class="img-fluid" style="max-width: 250px;">`;
	
	// Create modal if it doesn't exist
	if (!document.getElementById('qrImageContainer')) {
		const modalHtml = `
			<div id="qrImageContainer" class="modal fade" tabindex="-1">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">QR Code Image</h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body text-center">
							<div id="qrImageDisplay"></div>
							<p class="mt-3 small text-muted">Right-click to save the QR code image</p>
						</div>
					</div>
				</div>
			</div>
		`;
		document.body.insertAdjacentHTML('beforeend', modalHtml);
	}
	
	document.getElementById('qrImageDisplay').innerHTML = imageHtml;
	$('#qrImageContainer').modal('show');
}
</script>
<style>
.qr-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    text-align: center;
    margin-bottom: 20px;
}
.qr-display {
    background: white;
    padding: 30px;
    border-radius: 15px;
    margin: 20px 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.qr-code-text {
    font-family: 'Courier New', monospace;
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
    letter-spacing: 2px;
    word-break: break-all;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 2px dashed #007bff;
}
.copy-button {
    transition: all 0.3s ease;
}
.copy-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}
</style>
