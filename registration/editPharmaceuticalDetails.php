<?php
require_once('../database.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Supervisor') {
  header('Location: ../permissionDenied.php');
  exit();
}

// Check if pharmaceuticalId is provided in $_GET or $_SESSION
if (isset($_GET['pharmaceuticalId'])) {
    $pharmaceuticalId = $_GET['pharmaceuticalId'];
    $_SESSION['pharmaceuticalId'] = $pharmaceuticalId;
} elseif (isset($_SESSION['pharmaceuticalId'])) {
    $pharmaceuticalId = $_SESSION['pharmaceuticalId'];
} else {
    echo "Error: Pharmaceutical ID not provided.";
    exit;
}

// Fetch pharmaceutical details from the database based on pharmaceuticalId
$db = new Database();
$query = "SELECT * FROM pharmaceutical WHERE pharmaceuticalId = ?";
$values = array($pharmaceuticalId);
$pharmaceuticalData = $db->queryData($query, $values);

// Check if pharmaceutical exists
if (empty($pharmaceuticalData)) {
    echo "Error: Pharmaceutical not found.";
    exit;
}

// Extract pharmaceutical details
$pharmaceutical = $pharmaceuticalData[0];
$name = $pharmaceutical['name'];
$location = $pharmaceutical['location'];
$emailAddress = $pharmaceutical['emailAddress'];
$phoneNumber = $pharmaceutical['phoneNumber'];

// Update pharmaceutical details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];

    // Perform update query
    $query = "UPDATE pharmaceutical SET name = ?, location = ?, emailAddress = ?, phoneNumber = ? WHERE pharmaceuticalId = ?";
    $values = array($name, $location, $emailAddress, $phoneNumber, $pharmaceuticalId);
    $db->insertData($query, $values);

    // Redirect to the profile page
    header("Location: ../profiles/pharmaceuticalProfile.php?pharmaceuticalId=$pharmaceuticalId");
    exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pharmaceutical Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Pharmaceutical Details</h1>
        <form action="" method="POST">
            <input type="hidden" name="pharmaceuticalId" value="<?php echo $pharmaceuticalId; ?>">
            <div class="form-group">
                <label for="name">Pharmaceutical Name:</label>
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
