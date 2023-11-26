<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Doctor') {
  header('Location: ../permissionDenied.php');
  exit();
}

// Check if healthCenterId is provided in $_GET or $_SESSION
if (isset($_GET['healthCenterId'])) {
    $healthCenterId = $_GET['healthCenterId'];
    $_SESSION['healthCenterId'] = $healthCenterId;
} elseif (isset($_SESSION['healthCenterId'])) {
    $healthCenterId = $_SESSION['healthCenterId'];
} else {
    echo "Error: Health Center ID not provided.";
    exit;
}

// Fetch healthCenter details from the database based on healthCenterId
$db = new Database();
$query = "SELECT * FROM health_center WHERE healthCenterId = ?";
$values = array($healthCenterId);
$healthCenterData = $db->queryData($query, $values);

// Check if healthCenter exists
if (empty($healthCenterData)) {
    echo "Error: Health Center not found.";
    exit;
}

// Extract healthCenter details
$healthCenter = $healthCenterData[0];
$name = $healthCenter['name'];
$location = $healthCenter['location'];
$emailAddress = $healthCenter['emailAddress'];
$phoneNumber = $healthCenter['phoneNumber'];

// Fetch the number of doctors associated with the healthCenter
$query = "SELECT COUNT(*) AS doctorCount FROM doctor WHERE healthCenterId = ?";
$values = array($healthCenterId);
$doctorData = $db->queryData($query, $values);
$doctorCount = $doctorData[0]['doctorCount'];

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Health Center Profile</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <div class="profile-details lead">
                <h1 id="name"><?php echo $name; ?></h1>
                <h3 class="role">Health Center</h3>
                <p class=""><i class="fas fa-map-marker-alt"></i> <a href="https://maps.google.com/?q=<?php echo urlencode($location); ?>" target="_blank"><?php echo $location; ?></a></p>
                <p class=""><i class="fas fa-envelope"></i> <a href="mailto:<?php echo $emailAddress; ?>"><?php echo $emailAddress; ?></a></p>
                <p class=""><i class="fas fa-phone"></i> <a href="tel:<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></a></p>
                <p class=""><i class="fas fa-user-friends"></i> <?php echo $doctorCount; ?> Doctors</p>
            </div>
        </div>
        <div class="profile">
            <div class="actions">
	    <a class="action" href = "../registration/editHealthCenterDetails.php?hospitalId=<?php echo $healthCenterId;?>" id="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
