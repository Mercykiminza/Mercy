<?php
session_start();
require_once '../database.php';
require_once '../utilities.php';

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check user role and corresponding ID in the session
switch ($_SESSION['user']) {
    case 'Patient':
        $userId = $_SESSION['patientId'];
        $userTable = 'patient';
        $idField = 'patientId';
        break;
    case 'Doctor':
        $userId = $_SESSION['doctorId'];
        $userTable = 'doctor';
        $idField = 'doctorId';
        break;
    case 'Supervisor':
        $userId = $_SESSION['supervisorId'];
        $userTable = 'supervisor';
        $idField = 'supervisorId';
        break;
    case 'Pharmacist':
        $userId = $_SESSION['pharmacistId'];
        $userTable = 'pharmacist';
        $idField = 'pharmacistId';
        break;
    default:
        // Redirect to appropriate login page if user role is invalid or not set
        header('Location: ../permissionDenied.php');
        exit();
}

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newEmail = sanitizeInput($_POST['newEmail']);

    // Check if the new email is already in use by another user
    $emailQuery = "SELECT $idField FROM $userTable WHERE emailAddress = ? AND $idField <> ?";
    $existingUserId = $db->queryData($emailQuery, [$newEmail, $userId])[0][$idField];

    if ($existingUserId) {
        // Flash message: Email already exists
        $_SESSION['flashMessage'] = 'Email is already in use by another user.';
    } else {
        // Update the email address in the database
        $updateQuery = "UPDATE $userTable SET emailAddress = ? WHERE $idField = ?";
        $db->insertData($updateQuery, [$newEmail, $userId]);

        // Flash message: Email address updated successfully
        $_SESSION['flashMessage'] = 'Email address updated successfully.';

        // Redirect to user's profile page
        header("Location: ../profiles/{$userTable}Profile.php?{$idField}={$userId}");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Email Address</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Update Email Address</h2>
        <?php if (isset($_SESSION['flashMessage'])): ?>
            <div class="message">
                <?php echo $_SESSION['flashMessage']; ?>
                <?php unset($_SESSION['flashMessage']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="email" name="newEmail" placeholder="New Email Address" required><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
