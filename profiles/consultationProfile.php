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

// Check if consultationId is provided in $_GET or $_SESSION
if (isset($_GET['consultationId'])) {
	$consultationId = $_GET['consultationId'];
	$_SESSION['consultationId'] = $consultationId;
} elseif (isset($_SESSION['consultationId'])) {
	$consultationId = $_SESSION['consultationId'];
} else {
	echo "Error: Consultation ID not provided.";
	exit;
}

// Fetch consultation details from the database based on consultationId
$db = new Database();
$query = "SELECT consultation.*, patient.patientId, patient.firstName AS patientFirstName,
	patient.lastName AS patientLastName FROM consultation
	INNER JOIN patient_doctor ON consultation.patientDoctorId = patient_doctor.patientDoctorId
	INNER JOIN patient ON patient_doctor.patientId = patient.patientId
	WHERE consultation.consultationId = ?";
$values = array($consultationId);
$consultationData = $db->queryData($query, $values);

// Check if consultation exists
if (empty($consultationData)) {
	echo "Error: Consultation not found.";
	exit;
}

// Extract consultation details
$consultation = $consultationData[0];
$patientId = $consultation['patientId'];
$patientFirstName = $consultation['patientFirstName'];
$patientLastName = $consultation['patientLastName'];
$dateScheduled = $consultation['dateScheduled'];
$startTime = $consultation['startTime'];
$endTime = $consultation['endTime'];

// Fetch prescriptions assigned to the consultation
$query = "SELECT p.prescriptionId, dr.tradeName AS drugTradeName, p.dosage, p.quantity, " .
	"p.startDate, p.endDate, p.dateCreated FROM prescription p " .
	"INNER JOIN consultation c ON p.consultationId = c.consultationID " .
	"INNER JOIN drug dr ON p.drugId = dr.drugId WHERE p.consultationId = ?";
$values = array($consultationId);
$prescriptions = $db->queryData($query, $values);

// Fetch diagnoses registered for the consultation
$query = "SELECT * FROM diagnosis WHERE consultationId = ?";
$diagnoses = $db->queryData($query, $values);

// Fetch drugs registered
$query = "SELECT drugId, tradeName FROM drug";
$registeredDrugs = $db->queryData($query, []);

// Add prescription record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignPrescription'])) {
	$drugId = $_POST['drugId'];
	$dosage = $_POST['dosage'];
	$quantity = $_POST['quantity'];
	$startDate= $_POST['startDate'];
	$endDate = $_POST['endDate'];

	$query = "INSERT INTO prescription (consultationID, drugId, dosage, quantity, startDate, endDate) " .
		"VALUES (?, ?, ?, ?, ?, ?)";
	$values = array($consultationId, $drugId, $dosage, $quantity, $startDate, $endDate);
	$db->insertData($query, $values);

	// Redirect to the same page after assigning the prescription
	header("Location: consultationProfile.php?consultationId=$consultationId");
	exit;
}

// Add prescription record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addDiagnosis'])) {
	$symptom = $_POST['symptom'];
	$description = $_POST['description'];

	$query = "INSERT INTO diagnosis (consultationId, symptom, description) VALUES (?, ?, ?)";
	$values = array($consultationId, $symptom, $description);
	$db->insertData($query, $values);

	// Redirect to the same page after assigning the prescription
	header("Location: consultationProfile.php?consultationId=$consultationId");
	exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Consultation Profile</title>
		<link rel="stylesheet" type="text/css" href="../administrator/styles.css">
		<link rel="stylesheet" type="text/css" href="profile.css">
		<link rel="stylesheet" type="text/css" href="consultationProfile.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	</head>
	<body>
		<div class="container">
			<div class="container section">
				<div class="profile" style = "margin-bottom: 0; padding-bottom: 0;">
					<div class="profile-details lead">
						<h1 class="profile-title" id = "name">
							<span style = "color: #000;">Consultation Profile | </span>#ID: <?php echo $consultationId; ?>
						</h1>
						<p class=""><i class="fas fa-user"></i> Patient: <a href="patientProfile.php?patientId=<?php echo $patientId; ?>"><?php echo $patientFirstName . ' ' . $patientLastName; ?></a></p>
						<p class=""><i class="fas fa-calendar-alt"></i> Date Scheduled: <?php echo $dateScheduled; ?></p>
						<p class=""><i class="fas fa-clock"></i> Time: <?php echo $startTime . ' - ' . $endTime; ?></p>
					</div>
				</div>
			</div>
			<div class = "container section">
				<h2>Assign Prescription</h2>
				<form action="" method="POST">
					<div class="form-group">
						<label for="drugId">Select a drug</label>
						<select id="drugId" name="drugId">
							<?php foreach ($registeredDrugs as $registeredDrug): ?>
							<option value="<?php echo $registeredDrug['drugId']; ?>"><?php echo $registeredDrug['tradeName']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="dosage">Dosage</label>
						<input type="text" id="dosage" name="dosage">
					</div>
					<div class="form-group">
						<label for="quantity">Quantity</label>
						<input type="number" id="quantity" name="quantity">
					</div>
					<div class="form-group">
						<label for="startDate">Start Date</label>
						<input type="datetime-local" id="startDate" name="startDate">
					</div>
					<div class="form-group">
						<label for="endDate">End Date</label>
						<input type="datetime-local" id="endDate" name="endDate">
					</div>
					<div class="form-group">
						<input type="submit" name="assignPrescription">
					</div>
				</form>
			</div>
			<div class = "container section">
				<div class="profile">
					<div class="prescriptions table-div">
						<h2 class="profile-subtitle">Prescriptions</h2>
						<?php if (empty($prescriptions)) : ?>
						<p style = 'color: red;'>No prescriptions assigned for this consultation.</p>
						<?php else : ?>
						<table>
							<thead>
								<tr>
									<th>ID</th>
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
									<td><?php echo $prescription['dateCreated']; ?></td>
									<td><?php echo $prescription['drugTradeName']; ?></td>
									<td><?php echo $prescription['dosage']; ?></td>
									<td><?php echo $prescription['quantity']; ?></td>
									<td><?php echo $prescription['startDate']; ?></td>
									<td><?php echo $prescription['endDate']; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class = "container section">
				<h2>Add Diagnosis Record</h2>
				<form action="" method="POST">
					<div class="form-group">
						<label for="symptom">Symptom</label>
						<input type="text" id="symptom" name="symptom">
					</div>
					<div class="form-group">
						<label for="description">Description</label><br>
						<textarea type="text" id="description" name="description" rows='6'></textarea>
					</div>
					<div class="form-group">
						<input type="submit" name="addDiagnosis">
					</div>
				</form>
			</div>
			<div class = "container section">
				<div class="profile">
					<div class="diagnoses table-div">
						<h2 class="profile-subtitle">Diagnoses</h2>
						<?php if (empty($diagnoses)) : ?>
						<p style = 'color: red;'>No diagnoses registered for this consultation.</p>
						<?php else : ?>
						<table>
							<thead>
								<tr>
									<th>Symptom</th>
									<th>Description</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($diagnoses as $diagnosis): ?>
								<tr>
									<td><?php echo $diagnosis['symptom'] ?></td>
									<td><?php echo $diagnosis['description'] ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php endif; ?>
					</div>
				</div>
			</div>
	</body>
</html>

