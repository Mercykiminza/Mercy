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

// Fetch doctors assigned to the patient
$query = "SELECT doctor.*, patient_doctor.patientDoctorId, patient_doctor.isPrimary,
	hc.healthCenterId, hc.name FROM doctor INNER JOIN health_center AS hc ON
	hc.healthCenterId = doctor.healthCenterId INNER JOIN patient_doctor ON
	doctor.doctorId = patient_doctor.doctorId WHERE patient_doctor.patientId = ?";
$assignedDoctors = $db->queryData($query, $values);

// Fetch consultations for the patient
$query = "SELECT consultation.*, patient_doctor.doctorId, doctor.firstName AS doctorFirstName, doctor.lastName AS doctorLastName
	FROM consultation
	INNER JOIN patient_doctor ON consultation.patientDoctorId = patient_doctor.patientDoctorId
	INNER JOIN doctor ON patient_doctor.doctorId = doctor.doctorId
	WHERE patient_doctor.patientId = ?
	ORDER BY consultation.dateScheduled DESC LIMIT 12";
$consultations = $db->queryData($query, $values);

// Fetch latest 12 prescriptions for the patient
$query = "SELECT prescription.*, dr.tradeName, doctor.firstName AS doctorFirstName, doctor.lastName AS doctorLastName 
	FROM prescription
	INNER JOIN consultation ON prescription.consultationId = consultation.consultationID
	INNER JOIN patient_doctor ON consultation.patientDoctorId = patient_doctor.patientDoctorId
	INNER JOIN doctor ON patient_doctor.doctorId = doctor.doctorId
	INNER JOIN drug dr ON prescription.drugId = dr.drugId 
	WHERE patient_doctor.patientId = ?
	ORDER BY prescription.dateCreated DESC
	LIMIT 12";
$prescriptions = $db->queryData($query, $values);

// Fetch doctors not assigned to the patient
$query = "SELECT * FROM doctor WHERE doctorId NOT IN (SELECT doctorId FROM patient_doctor WHERE patientId = ?)";
$availableDoctors = $db->queryData($query, $values);

// Assign a doctor to the patient
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignDoctor'])) {
	$doctorId = $_POST['doctorId'];
	$isPrimary = $_POST['isPrimary'];

	// Insert into patient_doctor table
	$query = "INSERT INTO patient_doctor (patientId, doctorId, dateAssigned, isPrimary)
		VALUES (?, ?, CURRENT_TIMESTAMP, ?)";
	$values = array($patientId, $doctorId, $isPrimary);
	$db->insertData($query, $values);

	// Redirect to the same page after assigning the doctor
	header("Location: patientDetails.php?patientId=$patientId");
	exit;
}

// Schedule a consultation with a doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scheduleConsultation'])) {
	$patientDoctorId = $_POST['patientDoctorId'];
	$dateScheduled = $_POST['dateScheduled'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];

	// Insert into consultation table
	$query = "INSERT INTO consultation (dateScheduled, startTime, endTime, patientDoctorId, 
		status) VALUES ('$dateScheduled', '$startTime', '$endTime', $patientDoctorId, 
		'pending')";
	$db->insertData($query, []);
	// Redirect to the same page after scheduling the consultation
	header("Location: patientDetails.php?patientId=$patientId");
	exit;
}

// Function to get the color class based on consultation status
function getStatusColor($status) {
	switch ($status) {
	case 'requested':
		return 'brown';
	case 'completed':
		return 'green';
	case 'declined':
		return 'red';
	case 'defaulted':
		return 'orange';
	default:
		return 'default';
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Patient Details</title>
		<link rel="stylesheet" type="text/css" href="../administrator/styles.css">
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<h2>Patient Details - <?php echo $firstName . ' ' . $lastName; ?></h2>

		<div class = "container">
			<h3>Assign Doctors</h3>
			<form action="patientDetails.php" method="POST">
				<div class="form-group">
					<select id="doctorId" name="doctorId">
						<option value = "">Select a doctor</option>
						<?php foreach ($availableDoctors as $doctor): ?>
						<option value="<?php echo $doctor['doctorId']; ?>"><?php echo $doctor['firstName'] . ' ' . $doctor['lastName']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<select id="isPrimary" name="isPrimary">
						<option value="0">Secondary</option>
						<option value="1">Primary</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" name="assignDoctor">
				</div>
			</form>
		</div>

		<div class = "container">
			<h3>Assigned Doctors</h3>
			<table>
				<thead>
					<tr>
						<th>Doctor</th>
						<th>Email Address</th>
						<th>Phone Number</th>
						<th>Health Center</th>
						<th>Priority</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($assignedDoctors as $assignedDoctor): ?>
					<tr>
						<td><?php echo $assignedDoctor['firstName'] . ' ' . $assignedDoctor['lastName']; ?></td>
						<td><?php echo $assignedDoctor['emailAddress'] ?></td>
						<td><?php echo $assignedDoctor['phoneNumber'] ?></td>
						<td><?php echo $assignedDoctor['name'] ?></td>
						<td><?php echo ($assignedDoctor['isPrimary'] == 1) ? 'Primary' : 'Secondary'; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class = "container">
			<h3>Schedule Consultation</h3>
			<form action="patientDetails.php" method="POST">
				<div class="form-group">
					<label for="patientDoctorId">Select a Doctor</label>
					<select id="patientDoctorId" name="patientDoctorId">
						<?php foreach ($assignedDoctors as $assignedDoctor): ?>
						<option value="<?php echo $assignedDoctor['patientDoctorId']; ?>"><?php echo $assignedDoctor['firstName'] . ' ' . $assignedDoctor['lastName']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="dateScheduled">Date Scheduled</label>
					<input type="date" id="dateScheduled" name="dateScheduled">
				</div>
				<div class="form-group">
					<label for="startTime">Start Time</label>
					<input type="datetime-local" id="startTime" name="startTime">
				</div>
				<div class="form-group">
					<label for="endTime">End Time</label>
					<input type="datetime-local" id="endTime" name="endTime">
				</div>
				<div class="form-group">
					<input type="submit" name="scheduleConsultation">
				</div>
			</form>
		</div>

		<div class = "container">
			<h3>Consultations</h3>
			<table>
				<thead>
					<tr>
						<th>Consultation ID</th>
						<th>Date Scheduled</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Doctor</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($consultations as $consultation): ?>
					<tr>
						<td>
							<a href = "consultationProfile.php?consultationId=<?php echo $consultation['consultationID']?>">
								<?php echo $consultation['consultationID']; ?>
							</a>
						</td>
						<td><?php echo $consultation['dateScheduled']; ?></td>
						<td><?php echo $consultation['startTime']; ?></td>
						<td><?php echo $consultation['endTime']; ?></td>
						<td><?php echo $consultation['doctorFirstName'] . ' ' . $consultation['doctorLastName']; ?></td>
						<td class="<?php echo getStatusColor($consultation['status']); ?>"><?php echo $consultation['status']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class = "container">
			<h3>Prescriptions</h3>
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Doctor</th>
						<th>Date Created</th>
						<th>Medication</th>
						<th>Dosage</th>
						<th>Quantity</th>
						<th>Start Date</th>
						<th>End Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($prescriptions as $prescription): ?>
					<tr>
						<td><?php echo $prescription['prescriptionId']; ?></td>
						<td><?php echo $prescription['doctorFirstName'] . ' ' . $prescription['doctorLastName']; ?></td>
						<td><?php echo $prescription['dateCreated']; ?></td>
						<td><?php echo $prescription['tradeName']; ?></td>
						<td><?php echo $prescription['dosage']; ?></td>
						<td><?php echo $prescription['quantity']; ?></td>
						<td><?php echo $prescription['startDate']; ?></td>
						<td><?php echo $prescription['endDate']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<a class = "button-pill" id = "view-prescriptions" href="assignedPatientPrescriptions.php?patientId=<?php echo $patientId; ?>">View All Assigned Prescriptions</a>
		</div>
	</body>
</html>
