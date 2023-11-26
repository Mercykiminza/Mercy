<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Pharmacist') {
  header('Location: ../permissionDenied.php');
  exit();
}

// Check if pharmacistId is provided in $_GET or $_SESSION
if (isset($_GET['pharmacistId'])) {
    $pharmacistId = $_GET['pharmacistId'];
    $_SESSION['pharmacistId'] = $pharmacistId;
} elseif (isset($_SESSION['pharmacistId'])) {
    $pharmacistId = $_SESSION['pharmacistId'];
} else {
    echo "Error: Pharmacist ID not provided.";
    exit;
}

// Fetch pharmacist details from the database based on pharmacistId
$db = new Database();
$query = "SELECT * FROM pharmacist WHERE pharmacistId = ?";
$values = array($pharmacistId);
$pharmacistData = $db->queryData($query, $values);

// Check if pharmacist exists
if (empty($pharmacistData)) {
    echo "Error: Pharmacist not found.";
    exit;
}

// Extract pharmacist details
$pharmacist = $pharmacistData[0];
$firstName = $pharmacist['firstName'];
$lastName = $pharmacist['lastName'];
$gender = $pharmacist['gender'];
$emailAddress = $pharmacist['emailAddress'];
$phoneNumber = $pharmacist['phoneNumber'];

// Update pharmacist details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];

    // Perform update query
    $query = "UPDATE pharmacist SET firstName = ?, lastName = ?, gender = ?, emailAddress = ?, phoneNumber = ? WHERE pharmacistId = ?";
    $values = array($firstName, $lastName, $gender, $emailAddress, $phoneNumber, $pharmacistId);
    $db->insertData($query, $values);

    // Redirect to the profile page
    header("Location: ../profiles/pharmacistProfile.php?pharmacistId=$pharmacistId");
    exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pharmacist Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Pharmacist Details</h1>
        <form action="" method="POST">
            <input type="hidden" name="pharmacistId" value="<?php echo $pharmacistId; ?>">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="emailAddress">Email Address:</label>
                <input type="email" id="emailAddress" name="emailAddress" value="<?php echo $emailAddress; ?>">
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
            </div>
            <div class="form-group">
                <input type="submit">
            </div>
        </form>
    </div>
</body>
</html>
