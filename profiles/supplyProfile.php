<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
	header('Location: ../authentication/login.php');
	exit();
}

// Check if the user is not an Administrator, Supervisor, or Pharmacist
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Supervisor' && $_SESSION['user'] !== 'Pharmacist') {
	header('Location: ../permissionDenied.php');
	exit();
}

// Check if supplyId is provided in $_GET
if (isset($_GET['supplyId'])) {
	$supplyId = $_GET['supplyId'];
} else {
	echo "Error: Supply ID not provided.";
	exit;
}

// Fetch supply details from the database based on supplyId
$db = new Database();
$query = "SELECT * FROM supply WHERE supplyId = ?";
$values = array($supplyId);
$supplyData = $db->queryData($query, $values);

// Check if supply exists
if (empty($supplyData)) {
	echo "Error: Supply not found.";
	exit;
}

// Extract supply details
$supply = $supplyData[0];

// Fetch supplied drugs for the supply
$query = "SELECT * FROM drug WHERE supplyId = ?";
$values = array($supplyId);
$suppliedDrugs = $db->queryData($query, $values);

// fetch payments made for the supply
$query = "SELECT * FROM supply_payment WHERE supplyId = ?";
$payments = $db->queryData($query, $values);

// Add a new drug to the supply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addDrug'])) {
	$tradeName = $_POST['tradeName'];
	$scientificName = $_POST['scientificName'];
	$formula = $_POST['formula'];
	$form = $_POST['form'];
	$dateManufactured = $_POST['dateManufactured'];
	$expiryDate = $_POST['expiryDate'];

	// Insert into supplied_drugs table
	$query = "INSERT INTO drug (tradeName, scientificName, formula, form, " .
		"dateManufactured, expiryDate, supplyId) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$values = array($tradeName, $scientificName, $formula, $form, $dateManufactured,
		$expiryDate, $supplyId);
	$db->insertData($query, $values);
	
	// Redirect to the same page after adding the drug
	header("Location: supplyProfile.php?supplyId=$supplyId");
	exit;
}

// Add payment for the supply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addPayment'])) {
	$amountCashed = $_POST['amountCashed'];
	$method = $_POST['method'];

	// Insert into supply_payment table
	$query = "INSERT INTO supply_payment (supplyId, amountCashed, method) VALUES (?, ?, ?)";
	$values = array($supplyId, $amountCashed, $method);
	$db->insertData($query, $values);

	// Redirect to the same page after adding the payment
	header("Location: supplyProfile.php?supplyId=$supplyId");
	exit;
}

// Mark the supply as completed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markCompleted'])) {
	// Update supply status to 'Completed'
	$query = "UPDATE supply SET status = 'Completed' WHERE supplyId = ?";
	$values = array($supplyId);
	$db->insertData($query, $values);

	// Redirect to the same page after marking the supply as completed
	header("Location: supplyProfile.php?supplyId=$supplyId");
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Supply Profile</title>
		<link rel="stylesheet" type="text/css" href="../administrator/styles.css">
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<h2>Supply Profile</h2>

		<div class = "container">
			<h3>Supply Details</h3>
			<p>Supply ID: <?php echo $supply['supplyId']; ?></p>
			<p>Contract ID: <?php echo $supply['contractId']; ?></p>
			<p>Status: <?php echo $supply['status']; ?></p>
			
			<?php if ($supply['status'] !== 'Completed'): ?>
				<form method="POST" action="">
					<input type="submit" name="markCompleted" value="Mark Completed">
				</form>
			<?php endif; ?>
		</div>
		
		<div class = "container">
			<h3>Supplied Drugs</h3>
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Trade Name</th>
						<th>Scientific Name</th>
						<th>Formula</th>
						<th>Form</th>
						<th>Manufacturing Date</th>
						<th>Expiry Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($suppliedDrugs as $suppliedDrug): ?>
						<tr>
							<td><?php echo $suppliedDrug['drugId']; ?></td>
							<td><?php echo $suppliedDrug['tradeName']; ?></td>
							<td><?php echo $suppliedDrug['scientificName']; ?></td>
							<td><?php echo $suppliedDrug['formula']; ?></td>
							<td><?php echo $suppliedDrug['form']; ?></td>
							<td><?php echo $suppliedDrug['dateManufactured']; ?></td>
							<td><?php echo $suppliedDrug['expiryDate']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		
		<?php if ($supply['status'] !== 'Completed'): ?>
			<div class = "container">
				<h3>Add Drug to Supply</h3>
				<form method="POST" action="">
					<div class="form-group">
						<label for="tradeName">Trade Name</label>
						<br>
						<input type="text" name="tradeName" id="tradeName" required>
						<br>
					</div>
					<div class="form-group">
						<label for="scientificName">Scientific Name</label>
						<br>
						<input type="text" name="scientificName" id="scientificName" required>
						<br>
					</div>
					<div class="form-group">
						<label for="formula">Formula</label>
						<br>
						<input type="text" name="formula" id="formula" required>
						<br>
					</div>
					<div class="form-group">
						<label for="form">Form</label>
						<br>
						<input type="text" name="form" id="form" required>
						<br>
					</div>
					<div class="form-group">
						<label for="dateManufactured">Date Manufactured</label>
						<br>
						<input type="date" name="dateManufactured" id="dateManufactured" required>
						<br>
					</div>
					<div class="form-group">
						<label for="expiryDate">Expiry Date</label>
						<br>
						<input type="date" name="expiryDate" id="expiryDate" required>
						<br>
					</div>
					<div class="form-group">
						<input type="submit" name="addDrug" value="Add Drug">
					</div>
				</form>
			</div>
		<?php endif; ?>
		
		<div class = "container">
			<h3>Payments</h3>
			<table>
				<tr>
					<th>Payment ID</th>
					<th>Date</th>
					<th>Amount</th>
					<th>Payment Method</th>
				</tr>
				<?php foreach ($payments as $payment): ?>
					<tr>
						<td><?php echo $payment['supplyPaymentId']; ?></td>
						<td><?php echo $payment['dateCreated']; ?></td>
						<td><?php echo $payment['amountCashed']; ?></td>
						<td><?php echo $payment['method']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php if ($supply['status'] !== 'Completed'): ?>
		<div class = "container">
			<h3>Add Payment for Supply</h3>
			<form method="POST" action="">
				<div class="form-group">
					<label for="amountCashed">Amount Cashed</label>
					<br>
					<input type="number" name="amountCashed" id="amountCashed" required>
					<br>
				</div>
				<div class="form-group">
					<label for="method">Method</label>
					<br>
					<input type="text" name="method" id="method" required>
					<br>
				</div>
				<div class="form-group">
					<input type="submit" name="addPayment" value="Add Payment">
				</div>
			</form>
		</div>
<?php endif; ?>
	</body>
</html>
