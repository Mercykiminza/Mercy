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

// Check if pharmacistId is provided in $_GET or $_SESSION
if (isset($_GET['pharmacistId'])) {
    $pharmacistId = $_GET['pharmacistId'];
    $_SESSION['pharmacistId'] = $pharmacistId;
} elseif (isset($_SESSION['pharmacistId'])) {
    $pharmacistId = $_SESSION['pharmacistId'];
} else {
    echo "Error: Pharmacist ID not provided.";
    exit;
}

// Fetch pharmacist details from the database based on pharmacistId
$db = new Database();
$query = "SELECT * FROM pharmacist WHERE pharmacistId = ?";
$values = array($pharmacistId);
$pharmacistData = $db->queryData($query, $values);

// Check if pharmacist exists
if (empty($pharmacistData)) {
    echo "Error: Pharmacist not found.";
    exit;
}

// Extract pharmacist details
$pharmacist = $pharmacistData[0];
$firstName = $pharmacist['firstName'];
$lastName = $pharmacist['lastName'];
$gender = $pharmacist['gender'];
$emailAddress = $pharmacist['emailAddress'];
$phoneNumber = $pharmacist['phoneNumber'];
$pharmacyId = $pharmacist['pharmacyId'];

// Fetch pharmacy details
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
$pharmacyName = $pharmacy['name'];
$pharmacyLocation = $pharmacy['location'];

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Profile</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <div class="profile-picture">
                <img src="profile.png">
            </div>
            <div class="profile-details lead">
                <h1 id="name"><?php echo $firstName . ' ' . $lastName; ?></h1>
                <h3 class="role">Pharmacist</h3>
                <p class=""><i class="fas fa-user-secret"></i> <?php echo $gender; ?></p>
                <p class=""><i class="fas fa-envelope"></i> <?php echo $emailAddress; ?></p>
                <p class=""><i class="fas fa-phone"></i> <?php echo $phoneNumber; ?></p>
                <p class=""><i class="fas fa-clinic-medical"></i> <?php echo $pharmacyName . ', ' . $pharmacyLocation; ?></p>
            </div>
        </div>
        <div id="explore-profile" class="profile">
            <a href="pharmacyProfile.php?pharmacyId=<?php echo $pharmacyId; ?>" class="button-pill">
                View Pharmacy Profile
            </a>
        </div>
        <div class="profile">
            <div class="actions">
	    <a class="action" href = "../registration/editPharmacistDetails.php?pharmacistId=<?php echo $pharmacistId;?>" id="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
