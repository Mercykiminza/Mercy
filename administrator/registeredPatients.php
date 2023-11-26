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
    <title>Registered Patients</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registered Patients</h2>
        <table>
            <thead>
		<tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Create a new instance of the Database class
                $db = new Database();

                // Query the patient table to retrieve all patient records
                $query = "SELECT * FROM patient";
                $patients = $db->queryData($query, []);

                // Iterate over the patient records and populate the table rows dynamically
                foreach ($patients as $patient) {
                    $patientId = $patient['patientId'];
                    $firstName = $patient['firstName'];
                    $lastName = $patient['lastName'];
                    $emailAddress = $patient['emailAddress'];
                    $phoneNumber = $patient['phoneNumber'];
                    $location = $patient['location'];
                ?>
                <tr>
		    <td>
		    <a href="../profiles/patientProfile.php?patientId=<?php echo $patientId; ?>">
		    <?php echo $patientId; ?>
		    </a>
		    </td>
		    <td>
		    <a href="../profiles/patientProfile.php?patientId=<?php echo $patientId; ?>">
		    <?php echo $firstName . ' ' . $lastName; ?>
		    </a>
		    </td>
                    <td><a href="mailto:<?php echo $emailAddress; ?>"><?php echo $emailAddress; ?></a></td>
                    <td><a href="tel:<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></a></td>
                    <td><a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($location); ?>" target="_blank"><?php echo $location; ?></a></td>
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
