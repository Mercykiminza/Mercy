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
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Doctor') {
	header('Location: ../permissionDenied.php');
	exit();
}

if (isset($_SESSION['doctorId']))
{
	$doctorId = $_SESSION['doctorId'];
}
else if (isset($_GET['doctorId']))
{
	$doctorId = $_GET['doctorId'];
}
// Create a new instance of the Database class
$db = new Database();

// Query the patient, patient_doctor, and doctor tables to retrieve assigned patients for the specified doctor
$query = "SELECT p.patientId, p.firstName, p.lastName, p.gender, p.emailAddress, p.phoneNumber, p.location, p.dateOfBirth
	FROM patient p
	INNER JOIN patient_doctor pd ON p.patientId = pd.patientId
	WHERE pd.doctorId = ?";
$values = array($doctorId);
$assignedPatients = $db->queryData($query, $values);

// Fetch consultations for the doctor
$query = "SELECT consultation.*, patient_doctor.patientId, patient.firstName AS patientFirstName, patient.lastName AS patientLastName
	FROM consultation
	INNER JOIN patient_doctor ON consultation.patientDoctorId = patient_doctor.patientDoctorId
	INNER JOIN patient ON patient_doctor.patientId = patient.patientId
	WHERE patient_doctor.patientId = ?
	ORDER BY consultation.dateScheduled DESC LIMIT 12";
$consultations = $db->queryData($query, $values);

// Fetch latest 12 prescriptions for the patient
// Fetch patients not assigned to the doctor
$query = "SELECT * FROM patient WHERE patientId NOT IN (SELECT patientId FROM patient_doctor WHERE doctorId = ?)";
$availablePatients = $db->queryData($query, [$doctorId]);

// Assign a patient to the Doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignPatient'])) {
	$patientId = $_POST['patientId'];
	$isPrimary = $_POST['isPrimary'];

	// Insert into patient_doctor table
	$query = "INSERT INTO patient_doctor (patientId, doctorId, dateAssigned, isPrimary)
		VALUES (?, ?, CURRENT_TIMESTAMP, ?)";
	$values = array($patientId, $doctorId, $isPrimary);
	$db->insertData($query, $values);

	// Redirect to the same page after assigning the doctor
	header("Location: doctorDetails.php?doctorId=$doctorId");
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Details</title>
    <link rel="stylesheet" type="text/css" href="../administrator/styles.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h2>Doctor Details | #ID <?php echo $doctorId; ?></h2>

    <div class = "container">
    <h3>Assign Patients</h3>
    <form action="doctorDetails.php" method="POST">
	<div class="form-group">
	    <label for="patientId">Select a Patient:</label>
	    <select id="patientId" name="patientId">
		<?php foreach ($availablePatients as $patient): ?>
		    <option value="<?php echo $patient['patientId']; ?>"><?php echo $patient['firstName'] . ' ' . $patient['lastName']; ?></option>
		<?php endforeach; ?>
	    </select>
				<div class="form-group">
					<select id="isPrimary" name="isPrimary">
						<option value="0">Secondary</option>
						<option value="1">Primary</option>
					</select>
				</div>
	</div>
	<div class="form-group">
	    <input type="submit" name="assignPatient">
	</div>
    </form>
    </div>
    <div class = "container">
    <h3>Assigned Patients</h3>
    <table>
	<thead>
	    <tr>
		<th>Patient ID</th>
		<th>Name</th>
		<th>Gender</th>
		<th>Email Address</th>
		<th>Phone Number</th>
		<th>Residential Address</th>
	    </tr>
	</thead>
	<tbody>
	    <?php foreach ($assignedPatients as $assignedPatient): ?>
		<tr>
		    <td><?php echo $assignedPatient['patientId']; ?></td>
		    <td><?php echo $assignedPatient['firstName'] . ' ' . $assignedPatient['lastName']; ?></td>
		    <td><?php echo $assignedPatient['gender']; ?></td>
		    <td><a href = "mailto: <?php echo $assignedPatient['emailAddress'];?>"><?php echo $assignedPatient['emailAddress']; ?></a></td>
		    <td><a href = "tel: <?php echo $assignedPatient['phoneNumber'];?>"><?php echo $assignedPatient['phoneNumber']; ?></a></td>
		    <td><?php echo $assignedPatient['location']; ?></td>
		</tr>
	    <?php endforeach; ?>
	</tbody>
    </table>
</div>
		<div class = "container">
			<h3>Latest Consultations</h3>
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
						<td><?php echo $consultation['patientFirstName'] . ' ' . $consultation['patientLastName']; ?></td>
						<td class="<?php echo getStatusColor($consultation['status']); ?>"><?php echo $consultation['status']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
    <div class = "container">
    <a href="../administrator/assignedPatients.php?doctorId=<?php echo $doctorId; ?>">View Assigned Patients</a>
    <a href="consultations.php?doctorId=<?php echo $doctorId; ?>">View All Consultations</a>
    <a href="assignedPrescriptions.php?doctorId=<?php echo $doctorId; ?>">View Assigned Prescriptions</a>
</div>
</body>
</html>


