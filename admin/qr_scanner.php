<?php 
require_once('../config.php');
require_once('../classes/QRCodeGenerator.php');

// Handle QR code lookup
$qrResult = null;
$qrError = null;

if (isset($_POST['qr_code']) && !empty($_POST['qr_code'])) {
    $qrCode = trim($_POST['qr_code']);
    
    // Validate QR code format
    $validation = QRCodeGenerator::validateQRCode($qrCode);
    
    if ($validation) {
        // Look up user in database
        $userId = $validation['user_id'];
        $userQuery = $conn->query("SELECT * FROM users WHERE id = '{$userId}' AND qr_code = '{$qrCode}'");
        
        if ($userQuery && $userQuery->num_rows > 0) {
            $qrResult = $userQuery->fetch_assoc();
        } else {
            $qrError = "No user found matching this QR code.";
        }
    } else {
        $qrError = "Invalid QR code format.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner - PMS</title>
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-qrcode"></i> QR Code Scanner</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="qr_code">Enter QR Code:</label>
                                <div class="input-group">
                                    <input type="text" name="qr_code" id="qr_code" class="form-control" 
                                           placeholder="PMS-USER-XXXXX-XXXXXXXX-XXXXXXXX" 
                                           value="<?php echo isset($_POST['qr_code']) ? htmlspecialchars($_POST['qr_code']) : '' ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Scan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php if ($qrError): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($qrError) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($qrResult): ?>
                            <div class="alert alert-success">
                                <h5><i class="fas fa-check-circle"></i> User Found!</h5>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <?php if (!empty($qrResult['avatar'])): ?>
                                                <img src="../<?php echo htmlspecialchars($qrResult['avatar']) ?>" 
                                                     alt="Avatar" class="img-thumbnail mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center mb-3" 
                                                     style="width: 120px; height: 120px; margin: 0 auto;">
                                                    <i class="fas fa-user fa-3x"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th>ID:</th>
                                                    <td><?php echo htmlspecialchars($qrResult['id']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Name:</th>
                                                    <td><?php echo htmlspecialchars($qrResult['firstname'] . ' ' . $qrResult['middlename'] . ' ' . $qrResult['lastname']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Username:</th>
                                                    <td><?php echo htmlspecialchars($qrResult['username']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Zone:</th>
                                                    <td>Zone <?php echo htmlspecialchars($qrResult['zone']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Age:</th>
                                                    <td><?php echo htmlspecialchars($qrResult['age']) ?> years old</td>
                                                </tr>
                                                <tr>
                                                    <th>Sex:</th>
                                                    <td><?php echo htmlspecialchars($qrResult['sex']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td>
                                                        <span class="badge badge-<?php echo $qrResult['status'] == 1 ? 'success' : 'danger' ?>">
                                                            <?php echo $qrResult['status'] == 1 ? 'Active' : 'Inactive' ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>QR Code:</th>
                                                    <td><code><?php echo htmlspecialchars($qrResult['qr_code']) ?></code></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4">
                            <h6>How to use:</h6>
                            <ul class="small text-muted">
                                <li>Enter or scan a QR code in the format: PMS-USER-XXXXX-XXXXXXXX-XXXXXXXX</li>
                                <li>The system will look up the user information associated with that QR code</li>
                                <li>Each QR code is unique and contains encrypted user identification data</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="../admin/" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
