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

// Check if supervisorId is provided in $_GET or $_SESSION
if (isset($_GET['supervisorId'])) {
    $supervisorId = $_GET['supervisorId'];
    $_SESSION['supervisorId'] = $supervisorId;
} elseif (isset($_SESSION['supervisorId'])) {
    $supervisorId = $_SESSION['supervisorId'];
} else {
    echo "Error: Supervisor ID not provided.";
    exit;
}

// Fetch supervisor details from the database based on supervisorId
$db = new Database();
$query = "SELECT * FROM supervisor WHERE supervisorId = ?";
$values = array($supervisorId);
$supervisorData = $db->queryData($query, $values);

// Check if supervisor exists
if (empty($supervisorData)) {
    echo "Error: Supervisor not found.";
    exit;
}

// Extract supervisor details
$supervisor = $supervisorData[0];
$firstName = $supervisor['firstName'];
$lastName = $supervisor['lastName'];
$emailAddress = $supervisor['emailAddress'];
$phoneNumber = $supervisor['phoneNumber'];
$pharmaceuticalId = $supervisor['pharmaceuticalId'];

// Fetch pharmaceutical details
$query = "SELECT * FROM pharmaceutical WHERE pharmaceuticalId = ?";
$values = array($pharmaceuticalId);
$pharmaceuticalData = $db->queryData($query, $values);

// Check if pharmaceutical exists
if (empty($pharmaceuticalData)) {
    echo "Error: Pharmaceutical not found.";
    exit;
}

// Extract pharmaceutical details
$pharmaceutical = $pharmaceuticalData[0];
$pharmaceuticalName = $pharmaceutical['name'];
$pharmaceuticalLocation = $pharmaceutical['location'];

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supervisor Profile</title>
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
                <h3 class="role">Supervisor</h3>
                <p class=""><i class="fas fa-envelope"></i> <?php echo $emailAddress; ?></p>
                <p class=""><i class="fas fa-phone"></i> <?php echo $phoneNumber; ?></p>
                <p class=""><i class="fas fa-industry"></i> <?php echo $pharmaceuticalName . ', ' . $pharmaceuticalLocation; ?></p>
            </div>
        </div>
        <div id="explore-profile" class="profile">
            <a href="pharmaceuticalProfile.php?pharmaceuticalId=<?php echo $pharmaceuticalId; ?>" class="button-pill">
                View Pharmaceutical Profile
            </a>
        </div>
        <div class="profile">
            <div class="actions">
                <a class="action" href = "../registration/editSupervisorDetails.php?supervisorId={$supervisorId}" id="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </
