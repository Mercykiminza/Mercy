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

// Check if doctorId is provided in $_GET or $_SESSION
if (isset($_GET['doctorId'])) {
    $doctorId = $_GET['doctorId'];
    $_SESSION['doctorId'] = $doctorId;
} elseif (isset($_SESSION['doctorId'])) {
    $doctorId = $_SESSION['doctorId'];
} else {
    echo "Error: Doctor ID not provided.";
    exit;
}

// Fetch doctor details from the database based on doctorId
$db = new Database();
$query = "SELECT * FROM doctor WHERE doctorId = ?";
$values = array($doctorId);
$doctorData = $db->queryData($query, $values);

// Check if doctor exists
if (empty($doctorData)) {
    echo "Error: Doctor not found.";
    exit;
}

// Extract doctor details
$doctor = $doctorData[0];
$firstName = $doctor['firstName'];
$lastName = $doctor['lastName'];
$gender = $doctor['gender'];
$emailAddress = $doctor['emailAddress'];
$phoneNumber = $doctor['phoneNumber'];
$specialization = $doctor['specialization'];
$healthCenterId = $doctor['healthCenterId'];

// Fetch health center details
$query = "SELECT * FROM health_center WHERE healthCenterId = ?";
$values = array($healthCenterId);
$healthCenterData = $db->queryData($query, $values);

// Check if health center exists
if (empty($healthCenterData)) {
    echo "Error: Health center not found.";
    exit;
}

// Extract health center details
$healthCenter = $healthCenterData[0];
$healthCenterName = $healthCenter['name'];
$healthCenterLocation = $healthCenter['location'];

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Profile</title>
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
                <h3 class="role">Doctor</h3>
                <p class=""><i class="fas fa-user-secret"></i> <?php echo $gender; ?></p>
                <p class=""><i class="fas fa-envelope"></i> <?php echo $emailAddress; ?></p>
                <p class=""><i class="fas fa-phone"></i> <?php echo $phoneNumber; ?></p>
                <p class=""><i class="fas fa-stethoscope"></i> <?php echo $specialization; ?></p>
                <p class=""><i class="fas fa-clinic-medical"></i> <?php echo $healthCenterName . ', ' . $healthCenterLocation; ?></p>
            </div>
        </div>
        <div id="explore-profile" class="profile">
	<a class="button-pill" href = "doctorDetails.php?doctorId=<?php echo $doctorId;?>">
                Explore Profile
            </a>
        </div>
        <div class="profile">
            <div class="actions">
                <a class="action" href = "../authentication/logout.php" id="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <a class="action" href = "../registration/editDoctorDetails.php" id="edit-profile-btn">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
            <div class="actions">
                <a class="action" href = "../registration/updatePassword.php" id="change-password-btn">
                    <i class="fas fa-lock"></i>
                    <span>Change Password</span>
                </a>
                <a class="action" id="change-email-btn" href = "../registration/updateEmailAddress.php">
                    <i class="fas fa-envelope"></i>
                    <span>Change Email Address</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
