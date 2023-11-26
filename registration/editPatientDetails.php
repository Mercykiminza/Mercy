<?php
session_start();
require_once('../database.php');

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
    $_SESSION['patientId'] = $patientId;
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
$gender = $patient['gender'];
$emailAddress = $patient['emailAddress'];
$phoneNumber = $patient['phoneNumber'];
$location = $patient['location'];
$dateOfBirth = $patient['dateOfBirth'];

// Update patient details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $location = $_POST['location'];
    $dateOfBirth = $_POST['dateOfBirth'];

    // Perform update query
    $query = "UPDATE patient SET firstName = ?, lastName = ?, gender = ?, emailAddress = ?, phoneNumber = ?, location = ?, dateOfBirth = ? WHERE patientId = ?";
    $values = array($firstName, $lastName, $gender, $emailAddress, $phoneNumber, $location, $dateOfBirth, $patientId);
    $db->insertData($query, $values);

    // Redirect to the profile page
    header("Location: ../profiles/patientProfile.php?$patientId");
    exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Patient Details</h1>
        <form action="" method="POST">
            <input type="hidden" name="patientId" value="<?php echo $patientId; ?>">
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
                    <option value="Male" <?php if ($gender === 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender === 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="emailAddress">Email Address:</label>
                <input type="email" id="emailAddress" name="emailAddress" value="<?php echo $emailAddress; ?>">
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo $location; ?>">
            </div>
            <div class="form-group">
                <label for="dateOfBirth">Date of Birth:</label>
                <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>">
            </div>
            <div class="form-group">
                <input type="submit">
            </div>
        </form>
    </div>
</body>
</html>
