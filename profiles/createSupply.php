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

// Check if contractId is provided in $_GET or $_SESSION
if (isset($_GET['contractId'])) {
	$contractId = $_GET['contractId'];
}

$db = new Database();
$query = "INSERT INTO supply (contractId, status) VALUES (?, ?)";
$values = array($contractId, 'Pending');
$db->insertData($query, $values);

header("Location: contractSupplies.php?contractId=$contractId");
exit;
?>
