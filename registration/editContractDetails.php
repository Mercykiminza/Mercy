<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
	header('Location: ../authentication/login.php');
	exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Pharmacist' &&
	$_SESSION['user'] !== 'Supervisor') {
	header('Location: ../permissionDenied.php');
	exit();
}


// Check if contractId is provided in $_GET or $_SESSION
if (isset($_GET['contractId'])) {
	$contractId = $_GET['contractId'];
	$_SESSION['contractId'] = $contractId;
} elseif (isset($_SESSION['contractId'])) {
	$contractId = $_SESSION['contractId'];
} else {
	echo "Error: Contract ID not provided.";
	exit;
}

// Fetch contract details from the database based on contractId
$db = new Database();
$query = "SELECT * FROM contract WHERE contractId = ?";
$values = array($contractId);
$contractData = $db->queryData($query, $values);

// Check if contract exists
if (empty($contractData)) {
	echo "Error: Contract not found.";
	exit;
}

// Extract contract details
$contract = $contractData[0];
$startDate = $contract['startDate'];
$endDate = $contract['endDate'];
$description = $contract['description'];

// Update contract details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$description = $_POST['description'];

	// Perform update query
	$query = "UPDATE contract SET startDate = ?, endDate = ?, description = ? WHERE contractId = ?";
	$values = array($startDate, $endDate, $description, $contractId);
	$db->insertData($query, $values);

	// Redirect to the profile page
	header("Location: contractProfile.php");
	exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contract Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
	<h1>Edit Contract Details</h1>
	<form action="" method="POST">
	    <input type="hidden" name="contractId" value="<?php echo $contractId; ?>">
	    <div class="form-group">
		<label for="startDate">Start Date:</label>
		<input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>">
	    </div>
	    <div class="form-group">
		<label for="endDate">End Date:</label>
		<input type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>">
	    </div>
	    <div class="form-group">
		<label for="description">Description:</label>
		<textarea id="description" name="description"><?php echo $description; ?></textarea>
	    </div>
	    <div class="form-group">
		<button type="submit">Update Details</button>
	    </div>
	</form>
    </div>
</body>
</html>
