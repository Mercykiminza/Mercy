<?php
require_once '../database.php';
require_once '../utilities.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $gender = sanitizeInput($_POST['gender']);
    $email = sanitizeInput($_POST['email']);
    $phoneNumber = sanitizeInput($_POST['phoneNumber']);
    $location = sanitizeInput($_POST['location']);
    $dateOfBirth = sanitizeInput($_POST['dateOfBirth']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);
    $SSN = sanitizeInput($_POST['SSN']);

    $errors = array();

    // Validate form fields
    if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($phoneNumber) ||
        empty($location) || empty($dateOfBirth) || empty($password) || empty($confirmPassword) || empty($SSN)) {
        $errors[] = 'All fields are required.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    // Check if email or phone number already exists
    $db = new Database();
    $query = "SELECT * FROM patient WHERE emailAddress = ? OR phoneNumber = ?";
    $values = array($email, $phoneNumber);
    $result = $db->queryData($query, $values);

    if (!empty($result)) {
        $errors[] = 'Email or phone number already exists.';
    }

    // If no errors, insert the new patient
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO patient (firstName, lastName, gender, emailAddress, phoneNumber, location, dateOfBirth, passwordHash, SSN) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertValues = array($firstName, $lastName, $gender, $email, $phoneNumber, $location, $dateOfBirth, $passwordHash, $SSN);
        $db->insertData($insertQuery, $insertValues);

        header('Location: ../authentication/login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Patient Registration</h2>
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
		<option value="Other">Other</option>
	    </select><br>
	    <input type="email" name="email" placeholder="Email" required><br>
	    <input type="tel" name="phoneNumber" placeholder="Phone Number" required><br>
	    <input type="text" name="location" placeholder="Location" required><br>
	    <input type="date" name="dateOfBirth" placeholder="Date of Birth" required><br>
	    <input type="password" name="password" placeholder="Password" required><br>
	    <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br>
	    <input type="text" name="SSN" placeholder="Social Security Number" required><br>
	    <input type="submit" value="Register">
	</form>
    </div>
</body>
</html>
