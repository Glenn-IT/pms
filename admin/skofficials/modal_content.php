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

<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">SK Officials Management</h3>
            <?php if($_SESSION['userdata']['type'] == 1): ?>
            <button class="btn btn-primary btn-sm" type="button" onclick="new_official()">
                <i class="fa fa-plus"></i> Add New Official
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <!-- Chairman Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="text-center mb-3">SK CHAIRPERSON</h5>
                <div class="d-flex justify-content-center">
                    <?php if($chairman): ?>
                    <div class="official-card chairman-card">
                        <?php 
                        // Use user avatar if available, otherwise use SK official image, otherwise placeholder
                        if(!empty($chairman['avatar'])) {
                            $image_path = '../../uploads/avatars/' . $chairman['avatar'];
                        } elseif(!empty($chairman['image_path'])) {
                            $image_path = '../../uploads/sk_officials/' . $chairman['image_path'];
                        } else {
                            $image_path = 'https://via.placeholder.com/80x80.png?text=Photo';
                        }
                        
                        $full_name = trim($chairman['display_firstname'] . ' ' . $chairman['display_middlename'] . ' ' . $chairman['display_lastname']);
                        ?>
                        <img class="official-photo" src="<?php echo $image_path ?>" alt="Chairman Photo">
                        <div class="position-title">SK Chairperson</div>
                        <div class="official-name"><?php echo $full_name ?></div>
                        <div class="official-details"><?php echo $chairman['display_zone'] ?></div>
                        <div class="official-details">Contact: <?php echo $chairman['contact'] ?></div>
                        <?php if($_SESSION['userdata']['type'] == 1): ?>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-xs" onclick="edit_official(<?php echo $chairman['id'] ?>)">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="delete_official(<?php echo $chairman['id'] ?>)">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="official-card chairman-card">
                        <img class="official-photo" src="https://via.placeholder.com/80x80.png?text=No+Photo" alt="No Chairman">
                        <div class="position-title">SK Chairperson</div>
                        <div class="official-name">No Chairman Assigned</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Councilors Section -->
        <div class="row">
            <div class="col-12">
                <h5 class="text-center mb-3">SK COUNCILORS</h5>
                <div class="row">
                    <?php 
                    for($i = 0; $i < 7; $i++): 
                        $councilor = isset($councilors[$i]) ? $councilors[$i] : null;
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="official-card">
                            <?php if($councilor): ?>
                                <?php 
                                // Use user avatar if available, otherwise use SK official image, otherwise placeholder
                                if(!empty($councilor['avatar'])) {
                                    $image_path = '../../uploads/avatars/' . $councilor['avatar'];
                                } elseif(!empty($councilor['image_path'])) {
                                    $image_path = '../../uploads/sk_officials/' . $councilor['image_path'];
                                } else {
                                    $image_path = 'https://via.placeholder.com/80x80.png?text=Photo';
                                }
                                
                                $full_name = trim($councilor['display_firstname'] . ' ' . $councilor['display_middlename'] . ' ' . $councilor['display_lastname']);
                                ?>
                                <img class="official-photo" src="<?php echo $image_path ?>" alt="Councilor Photo">
                                <div class="position-title">Councilor</div>
                                <div class="official-name"><?php echo $full_name ?></div>
                                <div class="official-details"><?php echo $councilor['display_zone'] ?></div>
                                <div class="official-details">Contact: <?php echo $councilor['contact'] ?></div>
                                <?php if($_SESSION['userdata']['type'] == 1): ?>
                                <div class="mt-2">
                                    <button class="btn btn-primary btn-xs" onclick="edit_official(<?php echo $councilor['id'] ?>)">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-xs" onclick="delete_official(<?php echo $councilor['id'] ?>)">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <img class="official-photo" src="https://via.placeholder.com/80x80.png?text=No+Photo" alt="No Councilor">
                                <div class="position-title">Councilor</div>
                                <div class="official-name">No Councilor Assigned</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function new_official(position = '') {
    uni_modal("Add New SK Official", "../skofficials/manage_official.php" + (position ? "?position=" + position : ""), "large");
}

function edit_official(id) {
    uni_modal("Edit SK Official", "../skofficials/manage_official.php?id=" + id, "large");
}

function delete_official(id) {
    _conf("Are you sure to delete this SK Official?", "delete_official_confirmed", [id]);
}

function delete_official_confirmed(id) {
    start_loader();
    $.ajax({
        url: "../../classes/Master.php?f=delete_official",
        method: "POST",
        data: {id: id},
        dataType: "json",
        error: err => {
            console.log(err);
            alert_toast("An error occurred.", 'error');
            end_loader();
        },
        success: function(resp) {
            if(typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occurred.", 'error');
                end_loader();
            }
        }
    });
}
</script>

<style>
.official-card {
    background: #f4f6f9;
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 15px;
    margin: 10px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
.official-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.official-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #007bff;
    margin-bottom: 10px;
    background: #e9ecef;
}
.chairman-card {
    border-color: #dc3545;
    background: #fff5f5;
}
.chairman-card .official-photo {
    border-color: #dc3545;
}
.position-title {
    font-weight: bold;
    color: #007bff;
    font-size: 14px;
    text-transform: uppercase;
}
.chairman-card .position-title {
    color: #dc3545;
}
.official-name {
    font-weight: bold;
    margin: 5px 0;
    color: #333;
}
.official-details {
    font-size: 12px;
    color: #666;
    margin: 2px 0;
}
</style>
