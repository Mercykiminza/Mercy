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
    <title>Registered Doctors</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registered Doctors</h2>
        <table>
            <thead>
                <tr>
                    <th>Doctor ID</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Health Center</th>
                    <th>Specialization</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Create a new instance of the Database class
                $db = new Database();

                // Query the doctor table to retrieve all doctor records
		$query = "SELECT doctor.*, hc.healthCenterId, hc.name FROM doctor " .
			"INNER JOIN health_center as hc USING (healthCenterId)";
                $doctors = $db->queryData($query, []);

                // Iterate over the doctor records and populate the table rows dynamically
                foreach ($doctors as $doctor) {
                    $doctorId = $doctor['doctorId'];
                    $firstName = $doctor['firstName'];
                    $lastName = $doctor['lastName'];
                    $emailAddress = $doctor['emailAddress'];
                    $phoneNumber = $doctor['phoneNumber'];
                    $specialization = $doctor['specialization'];
                    $healthCenter = $doctor['name'];
                    $healthCenterId = $doctor['healthCenterId'];
                ?>
                <tr>
		    <td>
		    <a href="../profiles/doctorProfile.php?doctorId=<?php echo $doctorId; ?>">
		    <?php echo $doctorId; ?>
		    </a>
		    </td>
		    <td>
		    <a href="../profiles/doctorProfile.php?doctorId=<?php echo $doctorId; ?>">
		    <?php echo $firstName . ' ' . $lastName; ?>
		    </a>
		    </td>
                    <td><a href="mailto:<?php echo $emailAddress; ?>"><?php echo $emailAddress; ?></a></td>
                    <td><a href="tel:<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></a></td>
		    <td>
		    <a href="../profiles/healthCenterProfile.php?healthCenterId=<?php echo $healthCenterId; ?>">
		    <?php echo $healthCenter; ?>
		    </a>
		    </td>
                    <td><?php echo $specialization; ?></td>
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
