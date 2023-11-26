<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Pharmacist') {
  header('Location: ../permissionDenied.php');
  exit();
}

// Check if pharmacyId is provided in $_GET or $_SESSION
if (isset($_GET['pharmacyId'])) {
    $pharmacyId = $_GET['pharmacyId'];
    $_SESSION['pharmacyId'] = $pharmacyId;
} elseif (isset($_SESSION['pharmacyId'])) {
    $pharmacyId = $_SESSION['pharmacyId'];
} else {
    echo "Error: Pharmacy ID not provided.";
    exit;
}

// Fetch pharmacy details from the database based on pharmacyId
$db = new Database();
$query = "SELECT * FROM pharmacy WHERE pharmacyId = ?";
$values = array($pharmacyId);
$pharmacyData = $db->queryData($query, $values);

// Check if pharmacy exists
if (empty($pharmacyData)) {
    echo "Error: Pharmacy not found.";
    exit;
}

// Extract pharmacy details
$pharmacy = $pharmacyData[0];
$name = $pharmacy['name'];
$location = $pharmacy['location'];
$emailAddress = $pharmacy['emailAddress'];
$phoneNumber = $pharmacy['phoneNumber'];

// Fetch the number of pharmacists associated with the pharmacy
$query = "SELECT COUNT(*) AS pharmacistCount FROM pharmacist WHERE pharmacyId = ?";
$values = array($pharmacyId);
$pharmacistData = $db->queryData($query, $values);
$pharmacistCount = $pharmacistData[0]['pharmacistCount'];

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Profile</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <div class="profile-details lead">
                <h1 id="name"><?php echo $name; ?></h1>
                <h3 class="role">Pharmacy</h3>
                <p class=""><i class="fas fa-map-marker-alt"></i> <a href="https://maps.google.com/?q=<?php echo urlencode($location); ?>" target="_blank"><?php echo $location; ?></a></p>
                <p class=""><i class="fas fa-envelope"></i> <a href="mailto:<?php echo $emailAddress; ?>"><?php echo $emailAddress; ?></a></p>
                <p class=""><i class="fas fa-phone"></i> <a href="tel:<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></a></p>
                <p class=""><i class="fas fa-user-friends"></i> <?php echo $pharmacistCount; ?> Pharmacists</p>
            </div>
        </div>
        <div class="profile">
            <div class="actions">
	    <a class="action" href = "../registration/editPharmacyDetails.php?pharmacyId=<?php echo $pharmacyId;?>" id="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
