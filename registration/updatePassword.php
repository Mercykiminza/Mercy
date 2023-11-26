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
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    // Verify the old password against the one stored in the database
    $passwordQuery = "SELECT passwordHash FROM $userTable WHERE $idField = ?";
    $passwordHash = $db->queryData($passwordQuery, [$userId])[0]['passwordHash'];

    if (password_verify($oldPassword, $passwordHash)) {
        // Generate a new password hash
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateQuery = "UPDATE $userTable SET passwordHash = ? WHERE $idField = ?";
        $db->insertData($updateQuery, [$newPasswordHash, $userId]);

        // Flash message: Password updated successfully
        $_SESSION['flashMessage'] = 'Password updated successfully.';

        // Redirect to user's profile page
        header("Location: ../profiles/{$userTable}Profile.php?{$idField}={$userId}");
        exit();
    } else {
        // Flash message: Invalid old password
        $_SESSION['flashMessage'] = 'Invalid old password.';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Password</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Update Password</h2>
        <?php if (isset($_SESSION['flashMessage'])): ?>
            <div class="message">
                <?php echo $_SESSION['flashMessage']; ?>
                <?php unset($_SESSION['flashMessage']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="password" name="oldPassword" placeholder="Old Password" required><br>
            <input type="password" name="newPassword" placeholder="New Password" required><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
