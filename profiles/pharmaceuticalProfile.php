<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Supervisor') {
  header('Location: ../permissionDenied.php');
  exit();
}

// Check if pharmaceuticalId is provided in $_GET or $_SESSION
if (isset($_GET['pharmaceuticalId'])) {
    $pharmaceuticalId = $_GET['pharmaceuticalId'];
    $_SESSION['pharmaceuticalId'] = $pharmaceuticalId;
} elseif (isset($_SESSION['pharmaceuticalId'])) {
    $pharmaceuticalId = $_SESSION['pharmaceuticalId'];
} else {
    echo "Error: Pharmaceutical ID not provided.";
    exit;
}

// Fetch pharmaceutical details from the database based on pharmaceuticalId
$db = new Database();
$query = "SELECT * FROM pharmaceutical WHERE pharmaceuticalId = ?";
$values = array($pharmaceuticalId);
$pharmaceuticalData = $db->queryData($query, $values);

// Check if pharmaceutical company exists
if (empty($pharmaceuticalData)) {
    echo "Error: Pharmaceutical company not found.";
    exit;
}

// Extract pharmaceutical details
$pharmaceutical = $pharmaceuticalData[0];
$name = $pharmaceutical['name'];
$location = $pharmaceutical['location'];
$emailAddress = $pharmaceutical['emailAddress'];
$phoneNumber = $pharmaceutical['phoneNumber'];

// Fetch the number of supervisors associated with the pharmaceutical company
$query = "SELECT COUNT(*) AS supervisorCount FROM supervisor WHERE pharmaceuticalId = ?";
$values = array($pharmaceuticalId);
$supervisorData = $db->queryData($query, $values);
$supervisorCount = $supervisorData[0]['supervisorCount'];

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmaceutical Company Profile</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <div class="profile-details lead">
                <h1 id="name"><?php echo $name; ?></h1>
                <h3 class="role">Pharmaceutical Company</h3>
                <p class=""><i class="fas fa-map-marker-alt"></i> <a href="https://maps.google.com/?q=<?php echo urlencode($location); ?>" target="_blank"><?php echo $location; ?></a></p>
                <p class=""><i class="fas fa-envelope"></i> <a href="mailto:<?php echo $emailAddress; ?>"><?php echo $emailAddress; ?></a></p>
                <p class=""><i class="fas fa-phone"></i> <a href="tel:<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></a></p>
                <p class=""><i class="fas fa-user-friends"></i> <?php echo $supervisorCount; ?> Supervisors</p>
            </div>
        </div>
        <div class="profile">
            <div class="actions">
	    <a class="action" href = "../registration/editPharmaceuticalDetails.php?pharmaceuticalId=<?php echo $pharmaceuticalId; ?>"id="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
