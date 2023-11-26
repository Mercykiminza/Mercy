<?php
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assigned Patients</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
	<h2>Assigned Patients</h2>
<?php
require_once '../database.php';

// Check if the doctorId parameter is provided
if (isset($_GET['doctorId'])) {
	$doctorId = $_GET['doctorId'];

	// Create a new instance of the Database class
	$db = new Database();

	// Query the patient, patient_doctor, and doctor tables to retrieve assigned patients for the specified doctor
	$query = "SELECT p.patientId, p.firstName, p.lastName, p.gender, p.emailAddress, p.phoneNumber, p.location, p.dateOfBirth
		FROM patient p
		INNER JOIN patient_doctor pd ON p.patientId = pd.patientId
		WHERE pd.doctorId = ?";
	$values = [$doctorId];
	$assignedPatients = $db->queryData($query, $values);
?>
		<table>
		    <thead>
			<tr>
			    <th>Patient ID</th>
			    <th>First Name</th>
			    <th>Last Name</th>
			    <th>Gender</th>
			    <th>Email Address</th>
			    <th>Phone Number</th>
			    <th>Location</th>
			    <th>Age</th>
			</tr>
		    </thead>
		    <tbody>
<?php
	// Iterate over the assigned patients and populate the table rows dynamically
	foreach ($assignedPatients as $patient) {
		$patientId = $patient['patientId'];
		$firstName = $patient['firstName'];
		$lastName = $patient['lastName'];
		$gender = $patient['gender'];
		$emailAddress = $patient['emailAddress'];
		$phoneNumber = $patient['phoneNumber'];
		$location = $patient['location'];
		$dateOfBirth = $patient['dateOfBirth'];
		// Calculate age using Moment.js
		$age = "<script>document.write(moment('" . $dateOfBirth . "').fromNow(true));</script>";
?>
			    <tr>
				<td><a href="../profiles/patientProfile.php?patientId=<?php echo $patientId; ?>"><?php echo $patientId; ?></a></td>
				<td><?php echo $firstName; ?></td>
				<td><?php echo $lastName; ?></td>
				<td><?php echo $gender; ?></td>
				<td><?php echo $emailAddress; ?></td>
				<td><?php echo $phoneNumber; ?></td>
				<td><?php echo $location; ?></td>
				<td><?php echo $age; ?></td>
			    </tr>
<?php
	}
?>
		    </tbody>
		</table>
<?php
} else {
	echo '<p>No assigned patients for this doctor.</p>';
}
?>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js">
</script>

</body>
</html>
