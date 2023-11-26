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


// Check if hospitalId is provided in $_GET or $_SESSION
if (isset($_GET['hospitalId'])) {
    $hospitalId = $_GET['hospitalId'];
    $_SESSION['hospitalId'] = $hospitalId;
} elseif (isset($_SESSION['hospitalId'])) {
    $hospitalId = $_SESSION['hospitalId'];
} else {
    echo "Error: Hospital ID not provided.";
    exit;
}

// Fetch hospital details from the database based on hospitalId
$db = new Database();
$query = "SELECT * FROM health_center WHERE healthCenterId = ?";
$values = array($hospitalId);
$hospitalData = $db->queryData($query, $values);

// Check if hospital exists
if (empty($hospitalData)) {
    echo "Error: Hospital not found.";
    exit;
}

// Extract hospital details
$hospital = $hospitalData[0];
$name = $hospital['name'];
$location = $hospital['location'];
$emailAddress = $hospital['emailAddress'];
$phoneNumber = $hospital['phoneNumber'];

// Update hospital details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];

    // Perform update query
    $query = "UPDATE health_center SET name = ?, location = ?, emailAddress = ?, " .
	    "phoneNumber = ? WHERE healthCenterId = ?";
    $values = array($name, $location, $emailAddress, $phoneNumber, $hospitalId);
    $db->insertData($query, $values);

    // Redirect to the profile page
    header("Location: ../profiles/healthCenterProfile.php?healthCenterId=$hospitalId");
    exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Hospital Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Hospital Details</h1>
        <form action="" method="POST">
            <input type="hidden" name="hospitalId" value="<?php echo $hospitalId; ?>">
            <div class="form-group">
                <label for="name">Hospital Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo $location; ?>">
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
                <input type="submit">
            </div>
        </form>
    </div>
</body>
</html>
