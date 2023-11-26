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
    $name = sanitizeInput($_POST['name']);
    $location = sanitizeInput($_POST['location']);
    $email = sanitizeInput($_POST['email']);
    $phoneNumber = sanitizeInput($_POST['phoneNumber']);

    $errors = array();

    // Validate form fields
    if (empty($name) || empty($location) || empty($email) || empty($phoneNumber)) {
        $errors[] = 'All fields are required.';
    }

    // Check if email or phone number already exists
    $db = new Database();
    $query = "SELECT * FROM health_center WHERE emailAddress = ? OR phoneNumber = ?";
    $values = array($email, $phoneNumber);
    $result = $db->queryData($query, $values);

    if (!empty($result)) {
        $errors[] = 'Email or phone number already exists.';
    }

    // If no errors, insert the new hospital
    if (empty($errors)) {
        $insertQuery = "INSERT INTO health_center (name, location, emailAddress, phoneNumber) 
                        VALUES (?, ?, ?, ?)";
        $insertValues = array($name, $location, $email, $phoneNumber);
        $db->insertData($insertQuery, $insertValues);

        header('Location: registerHospital.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Health Center Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register Hospital</h2>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="text" name="location" placeholder="Location" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phoneNumber" placeholder="Phone Number" required><br>
            <input type="submit" value = "Register">
        </form>
    </div>
</body>
</html>
