<?php
session_start();

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Pharmacists</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registered Pharmacists</h2>
        <table>
            <thead>
		<tr>
                    <th>Pharmacist ID</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Pharmacy</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Create a new instance of the Database class
                $db = new Database();

                // Query the pharmacist and pharmacy tables to retrieve all pharmacist records
		$query = "SELECT p.*, ph.name AS pharmacy_name, ph.pharmacyId FROM pharmacist p " .
			"INNER JOIN pharmacy ph ON p.pharmacyId = ph.pharmacyId";
                $pharmacists = $db->queryData($query, []);

                // Iterate over the pharmacist records and populate the table rows dynamically
                foreach ($pharmacists as $pharmacist) {
                    $pharmacistId = $pharmacist['pharmacistId'];
                    $pharmacyId = $pharmacist['pharmacyId'];
                    $firstName = $pharmacist['firstName'];
                    $lastName = $pharmacist['lastName'];
                    $emailAddress = $pharmacist['emailAddress'];
                    $phoneNumber = $pharmacist['phoneNumber'];
                    $pharmacyName = $pharmacist['pharmacy_name'];
                ?>
                <tr>
		    <td>
		    <a href="../profiles/pharmacistProfile.php?pharmacistId=<?php echo $pharmacistId; ?>">
		    <?php echo $pharmacistId; ?>
		    </a>
		    </td>
		    <td>
		    <a href="../profiles/pharmacistProfile.php?pharmacistId=<?php echo $pharmacistId; ?>">
		    <?php echo $firstName . ' ' . $lastName; ?>
		    </a>
		    </td>
		    <td>
		    <a href="mailto:<?php echo $emailAddress; ?>"><?php echo $emailAddress; ?>
		    </a>
		    </td>
		    <td>
		    <a href="tel:<?php echo $phoneNumber; ?>">
		    <?php echo $phoneNumber; ?>
		    </a>
		    </td>
		    <td>
		    <a href="../profiles/pharmacyProfile.php?pharmacyId=<?php echo $pharmacyId; ?>">
		    <?php echo $pharmacyName; ?>
		    </td>
                </tr>
                <?php
                }

                // Disconnect from the database
                $db->disconnect();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
