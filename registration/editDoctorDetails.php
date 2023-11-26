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


// Check if doctorId is provided in $_GET or $_SESSION
if (isset($_GET['doctorId'])) {
    $doctorId = $_GET['doctorId'];
    $_SESSION['doctorId'] = $doctorId;
} elseif (isset($_SESSION['doctorId'])) {
    $doctorId = $_SESSION['doctorId'];
} else {
    echo "Error: Doctor ID not provided.";
    exit;
}

// Fetch doctor details from the database based on doctorId
$db = new Database();
$query = "SELECT * FROM doctor WHERE doctorId = ?";
$values = array($doctorId);
$doctorData = $db->queryData($query, $values);

// Check if doctor exists
if (empty($doctorData)) {
    echo "Error: Doctor not found.";
    exit;
}

// Extract doctor details
$doctor = $doctorData[0];
$firstName = $doctor['firstName'];
$lastName = $doctor['lastName'];
$gender = $doctor['gender'];
$emailAddress = $doctor['emailAddress'];
$phoneNumber = $doctor['phoneNumber'];
$specialization = $doctor['specialization'];
$healthCenterId = $doctor['healthCenterId'];

// Update doctor details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $specialization = $_POST['specialization'];
    $healthCenterId = $_POST['healthCenterId'];

    // Perform update query
    $query = "UPDATE doctor SET firstName = ?, lastName = ?, gender = ?, emailAddress = ?, phoneNumber = ?, specialization = ?, healthCenterId = ? WHERE doctorId = ?";
    $values = array($firstName, $lastName, $gender, $emailAddress, $phoneNumber, $specialization, $healthCenterId, $doctorId);
    $db->insertData($query, $values);

    // Redirect to the profile page
    header("Location: ../profiles/doctorProfile.php");
    exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Doctor Details</h1>
        <form action="" method="POST">
            <input type="hidden" name="doctorId" value="<?php echo $doctorId; ?>">
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
                <label for="specialization">Specialization:</label>
                <input type="text" id="specialization" name="specialization" value="<?php echo $specialization; ?>">
            </div>
            <div class="form-group">
                <label for="healthCenterId">Health Center ID:</label>
                <input type="text" id="healthCenterId" name="healthCenterId" value="<?php echo $healthCenterId; ?>">
            </div>
            <div class="form-group">
                <input type="submit">
            </div>
        </form>
    </div>
</body>
</html>
