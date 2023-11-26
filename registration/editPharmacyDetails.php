<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
	header('Location: ../authentication/login.php');
	exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Pharmacy') {
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

// Update pharmacy details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'];
	$location = $_POST['location'];
	$emailAddress = $_POST['emailAddress'];
	$phoneNumber = $_POST['phoneNumber'];

	// Perform update query
	$query = "UPDATE pharmacy SET name = ?, location = ?, emailAddress = ?, phoneNumber = ? WHERE pharmacyId = ?";
	$values = array($name, $location, $emailAddress, $phoneNumber, $pharmacyId);
	$db->insertData($query, $values);

	// Redirect to the profile page
	header("Location: ../profiles/pharmacyProfile.php?pharmacyId=$pharmacyId");
	exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pharmacy Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
	<h1>Edit Pharmacy Details</h1>
	<form action="" method="POST">
	    <input type="hidden" name="pharmacyId" value="<?php echo $pharmacyId; ?>">
	    <div class="form-group">
		<label for="name">Pharmacy Name:</label>
		<input type="text" id="name" name="name" value="<?php echo $name; ?>">
	    </div>
	    <div class="form-group">
		<label for="location">Location:</label>
		<input type="text" id="location" name="location" value="<?php echo $location; ?>">
	    </div>
	    <div class="form-group">
		<label for="emailAddress">Email Address:</label>
		<input type="email" id="emailAddress" name="emailAddress" value="<?php echo $emailAddress; ?>">
	    </div>
	    <div class="form-group">
		<label for="phoneNumber">Phone Number:</label>
		<input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
	    </div>
	    <div class="form-group">
		<input type="submit">
	    </div>
	</form>
    </div>
</body>
</html>
