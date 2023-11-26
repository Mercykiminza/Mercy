<?php
session_start();
require_once '../database.php';
require_once '../utilities.php';

require_once '../vendor/autoload.php';
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$emailAddress = sanitizeInput($_POST['emailAddress']);
	$password = sanitizeInput($_POST['password']);
	$user = $_POST['user'];

	$errors = array();

	// Validate form fields
	if (empty($emailAddress) || empty($password) || empty($user)) {
		$errors[] = 'All fields are required.';
	}

	// Check user login based on selected user role
	$db = new Database();
	$query = "SELECT * FROM ";

	switch ($user) {
	case 'Administrator':
		$query .= "administrator WHERE emailAddress = ?";
		break;
	case 'Patient':
		$query .= "patient WHERE emailAddress = ?";
		break;
	case 'Doctor':
		$query .= "doctor WHERE emailAddress = ?";
		break;
	case 'Pharmacist':
		$query .= "pharmacist WHERE emailAddress = ?";
		break;
	case 'Supervisor':
		$query .= "supervisor WHERE emailAddress = ?";
		break;
	default:
		$errors[] = 'Invalid user role selected.';
		break;
	}

	if (empty($errors)) {
		$result = $db->queryData($query, array($emailAddress));

		if (!empty($result)) {
			$hashedPassword = $result[0]['passwordHash'];

			if (password_verify($password, $hashedPassword)) {
				// Login successful
				$_SESSION['user'] = $user;
				$_SESSION['emailAddress'] = $emailAddress;

				switch ($user) {
				case 'Administrator':
					$_SESSION['administratorId'] = $result[0]['administratorId'];
					header('Location: ../administrator/administratorDashboard.php');
					exit();
				case 'Patient':
					$_SESSION['patientId'] = $result[0]['patientId'];
					header('Location: ../profiles/patientProfile.php?patientId=' . $_SESSION['patientId']);
					exit();
				case 'Doctor':
					$_SESSION['doctorId'] = $result[0]['doctorId'];
					header('Location: ../profiles/doctorProfile.php?doctorId=' . $_SESSION['doctorId']);
					exit();
				case 'Pharmacist':
					$_SESSION['pharmacistId'] = $result[0]['pharmacistId'];
					$_SESSION['pharmacyId'] = $result[0]['pharmacyId'];
					header('Location: ../profiles/pharmacistProfile.php?pharmacistId=' . $_SESSION['pharmacistId']);
					exit();
				case 'Supervisor':
					$_SESSION['supervisorId'] = $result[0]['supervisorId'];
					$_SESSION['pharmaceuticalId'] = $result[0]['pharmaceuticalId'];
					header('Location: ../profiles/supervisorProfile.php?supervisorId=' . $_SESSION['supervisorId']);
					exit();
				}
			} else {
				$errors[] = 'Invalid password.';
			}
		} else {
			$errors[] = 'Invalid email address.';
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../registration/styles.css">
</head>
<body>
    <div class="container">
	<h2>Login</h2>
	<?php if (!empty($errors)): ?>
	    <div class="errors">
		<?php foreach ($errors as $error): ?>
		    <p><?php echo $error; ?></p>
		<?php endforeach; ?>
	    </div>
	<?php endif; ?>
	<form method="POST" action="">
	    <input type="email" name="emailAddress" placeholder="Email Address" required><br>
	    <input type="password" name="password" placeholder="Password" required><br>
	    <select name="user" required>
		<option value="">Select User</option>
		<option value="Administrator">Administrator</option>
		<option value="Patient">Patient</option>
		<option value="Doctor">Doctor</option>
		<option value="Pharmacist">Pharmacist</option>
		<option value="Supervisor">Supervisor</option>
	    </select><br>
	    <input type="submit" value="Login">
	</form>
    </div>
</body>
</html>
