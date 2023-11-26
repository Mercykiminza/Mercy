<?php
session_start();
require_once '../database.php';
require_once '../utilities.php';

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator') {
  header('Location: ../permissionDenied.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $gender = sanitizeInput($_POST['gender']);
    $email = sanitizeInput($_POST['email']);
    $phoneNumber = sanitizeInput($_POST['phoneNumber']);
    $password = sanitizeInput($_POST['password']);
    $pharmacyId = $_POST['pharmacyId'];

    $errors = array();

    // Validate form fields
    if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($phoneNumber) || empty($password) || empty($pharmacyId)) {
        $errors[] = 'All fields are required.';
    }

    // Check if email or phone number already exists
    $db = new Database();
    $query = "SELECT * FROM pharmacist WHERE emailAddress = ? OR phoneNumber = ?";
    $values = array($email, $phoneNumber);
    $result = $db->queryData($query, $values);

    if (!empty($result)) {
        $errors[] = 'Email or phone number already exists.';
    }

    // If no errors, insert the new pharmacist
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO pharmacist (firstName, lastName, gender, emailAddress, phoneNumber, passwordHash, pharmacyId) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertValues = array($firstName, $lastName, $gender, $email, $phoneNumber, $hashedPassword, $pharmacyId);
        $db->insertData($insertQuery, $insertValues);

        header('Location: ../authentication/login.php');
        exit();
    }
}

// Fetch the pharmacies from the database
$db = new Database();
$query = "SELECT * FROM pharmacy";
$pharmacies = $db->queryData($query, array());
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register Pharmacist</h2>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="firstName" placeholder="First Name" required><br>
            <input type="text" name="lastName" placeholder="Last Name" required><br>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phoneNumber" placeholder="Phone Number" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <select name="pharmacyId" required>
                <option value="">Select Pharmacy</option>
                <?php foreach ($pharmacies as $pharmacy): ?>
                    <option value="<?php echo $pharmacy['pharmacyId']; ?>"><?php echo $pharmacy['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="submit" value = "Register">
        </form>
    </div>
</body>
</html>
