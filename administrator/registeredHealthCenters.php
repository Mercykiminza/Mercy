
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
    <title>Registered Health Centers</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registered Health Centers</h2>
        <table>
            <thead>
                <tr>
                    <th>Health Center ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Total Doctors</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Create a new instance of the Database class
                $db = new Database();

                // Query the health_center and doctor tables to retrieve all hospital records with total doctors count
                $query = "SELECT hc.healthCenterId, hc.name, hc.location, hc.emailAddress, hc.phoneNumber, COUNT(d.doctorId) AS totalDoctors 
                          FROM health_center hc 
                          LEFT JOIN doctor d ON hc.healthCenterId = d.healthCenterId 
                          GROUP BY hc.healthCenterId";
                $hospitals = $db->queryData($query, []);

                // Iterate over the hospital records and populate the table rows dynamically
                foreach ($hospitals as $hospital) {
                    $hospitalId = $hospital['healthCenterId'];
                    $name = $hospital['name'];
                    $location = $hospital['location'];
                    $emailAddress = $hospital['emailAddress'];
                    $phoneNumber = $hospital['phoneNumber'];
                    $totalDoctors = $hospital['totalDoctors'];

                    ?>
                    <tr>
			<td>
			<a href="../profiles/healthCenterProfile.php?healthCenterId=<?php echo $hospitalId; ?>">
			<?php echo $hospitalId; ?>
			</a>
			</td>
			<td>
			<a href="../profiles/healthCenterProfile.php?healthCenterId=<?php echo $hospitalId; ?>">
			<?php echo $name; ?>
			</a>
			</td>
			<td>
			<a href="mailto:<?php echo $emailAddress; ?>">
			<?php echo $emailAddress; ?>
			</a>
			</td>
			<td>
			<a href="tel:<?php echo $phoneNumber; ?>">
			<?php echo $phoneNumber; ?>
			</a>
			</td>
			<td>
			<a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($location); ?>" target="_blank">
			<?php echo $location; ?>
			</a>
			</td>
                        <td><?php echo $totalDoctors; ?></td>
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
