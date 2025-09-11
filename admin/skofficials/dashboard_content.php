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
    echo '<div class="alert alert-warning">Please log in to view SK Officials.</div>';
    exit;
}

// Get SK Officials from database with user information
$sk_officials = $conn->query("SELECT sk.*, u.firstname as user_firstname, u.middlename as user_middlename, 
                             u.lastname as user_lastname, u.avatar, u.age as user_age, u.sex as user_sex, 
                             u.zone as user_zone, u.birthdate
                             FROM `sk_officials` sk 
                             LEFT JOIN `users` u ON sk.user_id = u.id 
                             WHERE sk.status = 1 
                             ORDER BY 
                                CASE WHEN sk.position = 'chairman' THEN 1 ELSE 2 END, 
                                sk.order_position ASC, sk.firstname ASC");

$chairman = null;
$councilors = [];

while($row = $sk_officials->fetch_assoc()) {
    // Use user data if available, fallback to SK officials data
    $row['display_firstname'] = !empty($row['user_firstname']) ? $row['user_firstname'] : $row['firstname'];
    $row['display_middlename'] = !empty($row['user_middlename']) ? $row['user_middlename'] : $row['middlename'];
    $row['display_lastname'] = !empty($row['user_lastname']) ? $row['user_lastname'] : $row['lastname'];
    $row['display_zone'] = !empty($row['user_zone']) ? 'Zone ' . $row['user_zone'] : $row['zone'];

    if($row['position'] == 'chairman') {
        $chairman = $row;
    } else {
        $councilors[] = $row;
    }
}
?>

<style>
.sk-dashboard-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin: 5px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 220px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.sk-dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.sk-dashboard-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #007bff;
    margin: 0 auto 10px;
    background: #e9ecef;
}
.chairman-dashboard-card {
    border-color: #dc3545;
    background: #fff5f5;
}
.chairman-dashboard-card .sk-dashboard-photo {
    border-color: #dc3545;
}
.sk-position-title {
    font-weight: bold;
    color: #007bff;
    font-size: 12px;
    text-transform: uppercase;
    margin-bottom: 5px;
}
.chairman-dashboard-card .sk-position-title {
    color: #dc3545;
}
.sk-name {
    font-weight: bold;
    margin: 5px 0;
    color: #333;
    font-size: 14px;
    line-height: 1.2;
}
.sk-details {
    font-size: 11px;
    color: #666;
    margin: 2px 0;
}
</style>

<!-- Chairman Section -->
<div class="row mb-3">
    <div class="col-12">
        <h6 class="text-center mb-2 font-weight-bold">SK CHAIRPERSON</h6>
        <div class="d-flex justify-content-center">
            <?php if($chairman): ?>
            <div class="sk-dashboard-card chairman-dashboard-card">
                <?php 
                // Use user avatar if available, otherwise use SK official image, otherwise placeholder
                if(!empty($chairman['avatar'])) {
                    $image_path = '../uploads/avatars/' . $chairman['avatar'];
                } elseif(!empty($chairman['image_path'])) {
                    $image_path = '../uploads/sk_officials/' . $chairman['image_path'];
                } else {
                    $image_path = 'https://via.placeholder.com/60x60.png?text=Photo';
                }
                
                $full_name = trim($chairman['display_firstname'] . ' ' . $chairman['display_middlename'] . ' ' . $chairman['display_lastname']);
                ?>
                <img class="sk-dashboard-photo" src="<?php echo $image_path ?>" alt="Chairman Photo">
                <div class="sk-position-title">SK Chairperson</div>
                <div class="sk-name"><?php echo $full_name ?></div>
                <div class="sk-details"><?php echo $chairman['display_zone'] ?></div>
                <div class="sk-details">Contact: <?php echo $chairman['contact'] ?></div>
            </div>
            <?php else: ?>
            <div class="sk-dashboard-card chairman-dashboard-card">
                <img class="sk-dashboard-photo" src="https://via.placeholder.com/60x60.png?text=No+Photo" alt="No Chairman">
                <div class="sk-position-title">SK Chairperson</div>
                <div class="sk-name">No Chairman Assigned</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Councilors Section -->
<div class="row">
    <div class="col-12">
        <h6 class="text-center mb-2 font-weight-bold">SK COUNCILORS</h6>
        <div class="row">
            <?php 
            for($i = 0; $i < 7; $i++): 
                $councilor = isset($councilors[$i]) ? $councilors[$i] : null;
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-2">
                <div class="sk-dashboard-card">
                    <?php if($councilor): ?>
                        <?php 
                        // Use user avatar if available, otherwise use SK official image, otherwise placeholder
                        if(!empty($councilor['avatar'])) {
                            $image_path = '../uploads/avatars/' . $councilor['avatar'];
                        } elseif(!empty($councilor['image_path'])) {
                            $image_path = '../uploads/sk_officials/' . $councilor['image_path'];
                        } else {
                            $image_path = 'https://via.placeholder.com/60x60.png?text=Photo';
                        }
                        
                        $full_name = trim($councilor['display_firstname'] . ' ' . $councilor['display_middlename'] . ' ' . $councilor['display_lastname']);
                        ?>
                        <img class="sk-dashboard-photo" src="<?php echo $image_path ?>" alt="Councilor Photo">
                        <div class="sk-position-title">Councilor</div>
                        <div class="sk-name"><?php echo $full_name ?></div>
                        <div class="sk-details"><?php echo $councilor['display_zone'] ?></div>
                        <div class="sk-details">Contact: <?php echo $councilor['contact'] ?></div>
                    <?php else: ?>
                        <img class="sk-dashboard-photo" src="https://via.placeholder.com/60x60.png?text=No+Photo" alt="No Councilor">
                        <div class="sk-position-title">Councilor</div>
                        <div class="sk-name">No Councilor Assigned</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
