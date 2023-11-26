<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
	header('Location: ../authentication/login.php');
	exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Patient') {
	header('Location: ../permissionDenied.php');
	exit();
}

// Check if patientId is provided in $_GET or $_SESSION
if (isset($_GET['patientId'])) {
	$patientId = $_GET['patientId'];
	$_SESSION['patientId'] = $patientId;
} elseif (isset($_SESSION['patientId'])) {
	$patientId = $_SESSION['patientId'];
} else {
	echo "Error: Patient ID not provided.";
	exit;
}

// Fetch patient details from the database based on patientId
$db = new Database();
$query = "SELECT * FROM patient WHERE patientId = ?";
$values = array($patientId);
$patientData = $db->queryData($query, $values);

// Check if patient exists
if (empty($patientData)) {
	echo "Error: Patient not found.";
	exit;
}

// Extract patient details
$patient = $patientData[0];
$firstName = $patient['firstName'];
$lastName = $patient['lastName'];
$gender = $patient['gender'];
$emailAddress = $patient['emailAddress'];
$phoneNumber = $patient['phoneNumber'];
$location = $patient['location'];
$dateOfBirth = $patient['dateOfBirth'];

// Update date of birth format for moment.js
$dateOfBirth = date('Y-m-d', strtotime($dateOfBirth));

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Profile</title>
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
		<h3 class="role">Patient</h3>
		<p class=""><i class="fas fa-user-secret"></i> <?php echo $gender; ?></p>
		<p class=""><i class="fas fa-envelope"></i> <?php echo $emailAddress; ?></p>
		<p class=""><i class="fas fa-phone"></i> <?php echo $phoneNumber; ?></p>
		<p class=""><i class="fas fa-map-marker-alt"></i> <?php echo $location; ?></p>
		<p class=""><i class="fas fa-birthday-cake"></i> <span id="dateOfBirthFormatted"></span> (<span id="age"></span>)</p>
	    </div>
	</div>
	<div id="explore-profile" class="profile">
	<a class="button-pill" href = "patientDetails.php?patientId=<?php echo $patientId; ?>">
		Explore Profile
	    </a>
	</div>
	<div class="profile">
	    <div class="actions">
		<a class="action" href="../authentication/logout.php" id="logout-btn">
		    <i class="fas fa-sign-out-alt"></i>
		    <span>Logout</span>
		</a>
		<a class="action" href="../registration/editPatientDetails.php" id="edit-profile-btn">
		    <i class="fas fa-edit"></i>
		    <span>Edit Profile</span>
		</a>
	    </div>
	    <div class="actions">
		<a class="action" href="../registration/updatePassword.php" id="change-password-btn">
		    <i class="fas fa-lock"></i>
		    <span>Change Password</span>
		</a>
		<a class="action" href="../registration/updateEmailAddress.php" id="change-password-btn">
		    <i class="fas fa-envelope"></i>
		    <span>Change Email Address</span>
		</a>
	    </div>
	</div>
    </div>

    <!-- Include moment.js for date formatting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
<script>
// Format date of birth and calculate age using moment.js
var dateOfBirth = moment("<?php echo $dateOfBirth; ?>");
var dateOfBirthFormatted = dateOfBirth.format('ddd MMMM D, YYYY');
var age = moment().diff(dateOfBirth, 'years');
document.getElementById("dateOfBirthFormatted").innerHTML = dateOfBirthFormatted;
document.getElementById("age").innerHTML = age + " years old";
</script>
</body>
</html>
