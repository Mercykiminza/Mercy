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

// Check if supervisorId is provided in $_GET or $_SESSION
if (isset($_GET['supervisorId'])) {
    $supervisorId = $_GET['supervisorId'];
    $_SESSION['supervisorId'] = $supervisorId;
} elseif (isset($_SESSION['supervisorId'])) {
    $supervisorId = $_SESSION['supervisorId'];
} else {
    echo "Error: Supervisor ID not provided.";
    exit;
}

// Fetch supervisor details from the database based on supervisorId
$db = new Database();
$query = "SELECT * FROM supervisor WHERE supervisorId = ?";
$values = array($supervisorId);
$supervisorData = $db->queryData($query, $values);

// Check if supervisor exists
if (empty($supervisorData)) {
    echo "Error: Supervisor not found.";
    exit;
}

// Extract supervisor details
$supervisor = $supervisorData[0];
$firstName = $supervisor['firstName'];
$lastName = $supervisor['lastName'];
$gender = $supervisor['gender'];
$emailAddress = $supervisor['emailAddress'];
$phoneNumber = $supervisor['phoneNumber'];

// Update supervisor details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];

    // Perform update query
    $query = "UPDATE supervisor SET firstName = ?, lastName = ?, gender = ?, emailAddress = ?, phoneNumber = ? WHERE supervisorId = ?";
    $values = array($firstName, $lastName, $gender, $emailAddress, $phoneNumber, $supervisorId);
    $db->insertData($query, $values);

    // Redirect to the profile page
    header("Location: ../profiles/supervisorProfile.php?supervisorId=$supervisorId");
    exit;
}

$db->disconnect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supervisor Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Supervisor Details</h1>
        <form action="" method="POST">
            <input type="hidden" name="supervisorId" value="<?php echo $supervisorId; ?>">
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
