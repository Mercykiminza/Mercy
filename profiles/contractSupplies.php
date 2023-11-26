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
	$_SESSION['user'] !== 'Pharmaceutical') {
	header('Location: ../permissionDenied.php');
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contract Supplies</title>
    <link rel = "stylesheet" href = "styles.css" type = "text/css">
    <style>
	.status-paid {
	    color: green;
	}

	.status-pending {
	    color: red;
	}
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body>
    <div class = "container">
    <h2>Contract Supplies</h2>
<?php
// Check if contractId is provided
if (isset($_GET['contractId'])) {
	// Retrieve the contractId
	$contractId = $_GET['contractId'];

	// Connect to the database
	require_once '../database.php';
	$db = new Database();

	// Query the contract supplies
	$query = "SELECT supply.*, SUM(supply_payment.amountCashed) AS totalAmountPaid,
		contract.pharmacyId, contract.pharmaceuticalId, pharmaceutical.name AS pharmaceuticalName
		FROM supply
		LEFT JOIN supply_payment ON supply.supplyId = supply_payment.supplyId
		INNER JOIN contract ON supply.contractId = contract.contractId
		LEFT JOIN pharmaceutical ON contract.pharmaceuticalId = pharmaceutical.pharmaceuticalId
		WHERE supply.contractId = ?
		GROUP BY supply.supplyId";
	$values = [$contractId];
	$supplies = $db->queryData($query, $values);
	echo "<link rel = 'stylesheet' type = 'text/css' href = 'styles.css'>";
	echo "<link rel='stylesheet' type='text/css' href='../administrator/styles.css'>";
	echo "<div class = 'container'>";
	echo "<a class = 'button-pill' id = 'view-prescriptions' href='createSupply.php?contractId=$contractId'>Create New Supply</a>";
	echo '<table>';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Supply ID</th>';
	echo '<th>Date Created</th>';
	echo '<th>Status</th>';
	echo '<th>Total Amount Paid</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	foreach ($supplies as $supply) {
		$supplyId = $supply['supplyId'];
		$dateCreated = $supply['dateCreated'];
		$status = $supply['status'];
		$totalAmountPaid = $supply['totalAmountPaid'] ?? 0;

		// Format the date using Moment.js
		$formattedDate = "<script>document.write(moment('" . $dateCreated . "').format('ddd MMMM D, YYYY'));</script>";

		// Determine the CSS class for the status
		$statusClass = ($status === 'paid') ? 'status-paid' : 'status-pending';

		echo '<tr>';
		echo '<td><a href="../profiles/supplyProfile.php?supplyId=' . $supplyId . '">' . $supplyId . '</a></td>';
		echo '<td>' . $formattedDate . '</td>';
		echo '<td class="' . $statusClass . '">' . $status . '</td>';
		echo '<td>' . $totalAmountPaid . '</td>';
		echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';
	echo '</div>';

	// Disconnect from the database
	$db->disconnect();
} else {
	echo '<p>No contract ID provided.</p>';
}
?>
</div>
</body>
</html>
