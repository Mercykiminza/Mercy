<?php
session_start();
require_once '../database.php';
require_once '../utilities.php';

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator') {
  header('Location: ../permissionDenied.php');
  exit();
}

// create database object
$db = new Database();

// Query all hospitals
$hospitalQuery = "SELECT * FROM health_center";
$hospitals = $db->queryData($hospitalQuery, array());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$firstName = sanitizeInput($_POST['firstName']);
	$lastName = sanitizeInput($_POST['lastName']);
	$gender = sanitizeInput($_POST['gender']);
	$email = sanitizeInput($_POST['email']);
	$phoneNumber = sanitizeInput($_POST['phoneNumber']);
	$specialization = sanitizeInput($_POST['specialization']);
	$healthCenterId = sanitizeInput($_POST['healthCenterId']);
	$SSN = sanitizeInput($_POST['SSN']);
	$startYear = sanitizeInput($_POST['startYear']);
	$password = sanitizeInput($_POST['password']);
	$confirmPassword = sanitizeInput($_POST['confirmPassword']);

	$errors = array();

	// Validate form fields
	if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($phoneNumber) ||
		empty($specialization) || empty($healthCenterId) || empty($SSN) || empty($startYear) ||
		empty($password) || empty($confirmPassword)) {
		$errors[] = 'All fields are required.';
	}

	if ($password !== $confirmPassword) {
		$errors[] = 'Passwords do not match.';
	}

	// Check if email or phone number already exists
	$query = "SELECT * FROM doctor WHERE emailAddress = ? OR phoneNumber = ?";
	$values = array($email, $phoneNumber);
	$result = $db->queryData($query, $values);

	if (!empty($result)) {
		$errors[] = 'Email or phone number already exists.';
	}

	// If no errors, insert the new doctor
	if (empty($errors)) {
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);

		$insertQuery = "INSERT INTO doctor (firstName, lastName, gender, emailAddress, phoneNumber, " .
			"specialization, healthCenterId, SSN, startYear, passwordHash) VALUES " .
			"(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$insertValues = array($firstName, $lastName, $gender, $email, $phoneNumber, $specialization,
			$healthCenterId, $SSN, $startYear, $passwordHash);
		$db->insertData($insertQuery, $insertValues);

		header('Location: registerDoctor.php');
		exit();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
	<h2>Doctor Registration</h2>
	<?php if (!empty($errors)): ?>
	    <div class="errors">
		<?php foreach ($errors as $error): ?>
		    <p><?php echo $error; ?></p>
		<?php endforeach; ?>
	    </div>
	<?php endif; ?>
	<form method="POST" action="">
	    <input type="text" name="firstName" placeholder="First Name" required><br>
	    <input type="text" name="lastName" placeholder="Last Name" required><br>
	    <select name="gender" required>
		<option value="">Select Gender</option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
		<option value="Other">Other</option>
	    </select><br>
	    <input type="email" name="email" placeholder="Email" required><br>
	    <input type="tel" name="phoneNumber" placeholder="Phone Number" required><br>
	    <input type="text" name="specialization" placeholder="Specialization" required><br>
	    <select name="healthCenterId" required>
		<option value="">Select Hospital</option>
		<?php foreach ($hospitals as $hospital): ?>
		    <option value="<?php echo $hospital['healthCenterId']; ?>"><?php echo $hospital['name']; ?></option>
		<?php endforeach; ?>
	    </select><br>
	    <input type="text" name="SSN" placeholder="Social Security Number" required><br>
	    <input type="number" name="startYear" placeholder="Start Year" required><br>
	    <input type="password" name="password" placeholder="Password" required><br>
	    <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br>
	    <input type="submit" value="Register">
	</form>
    </div>
</body>
</html>
