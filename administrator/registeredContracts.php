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
    <title>Registered Contracts</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registered Contracts</h2>
        <table>
            <thead>
                <tr>
                    <th>Contract ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Period</th>
                    <th>Description</th>
                    <th>Pharmacy</th>
                    <th>Pharmaceutical Company</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Create a new instance of the Database class
                $db = new Database();

                // Query the contract, pharmacy, and pharmaceutical tables to retrieve all contract records
		$query = "SELECT c.*, p.name AS pharmacy, p.pharmacyId, ph.name AS pharmaceutical_company, " .
			"ph.pharmaceuticalId FROM contract c INNER JOIN pharmacy p ON c.pharmacyId = " .
			"p.pharmacyId INNER JOIN pharmaceutical ph ON c.pharmaceuticalId = ph.pharmaceuticalId";
                $contracts = $db->queryData($query, []);

                // Iterate over the contract records and populate the table rows dynamically
                foreach ($contracts as $contract) {
                    $contractId = $contract['contractId'];
                    $pharmacyId = $contract['pharmacyId'];
                    $pharmaceuticalId = $contract['pharmaceuticalId'];
                    $startDate = $contract['startDate'];
                    $endDate = $contract['endDate'];
                    $description = $contract['description'];
                    $pharmacy = $contract['pharmacy'];
                    $pharmaceuticalCompany = $contract['pharmaceutical_company'];

                    // Calculate the period using Moment.js
                    $startDateFormatted = date('Y-m-d H:i:s', strtotime($startDate));
                    $endDateFormatted = date('Y-m-d H:i:s', strtotime($endDate));
                    $period = "<script>moment.duration(moment('$endDateFormatted').diff(moment('$startDateFormatted'))).humanize()</script>";
                ?>
                <tr>
		    <td>
		    <a href="../profiles/contractSupplies.php?contractId=<?php echo $contractId; ?>">
		    <?php echo $contractId; ?>
		    </a>
		    </td>
		    <td>
		    <?php echo $startDate; ?>
		    </td>
		    <td>
		    <?php echo $endDate; ?>
		    </td>
		    <td>
		    <?php echo $period; ?>
		    </td>
		    <td>
		    <?php echo $description; ?>
		    </td>
		    <td>
		    <a href="../profiles/pharmacyProfile.php?pharmacyId=<?php echo $pharmacyId; ?>">
		    <?php echo $pharmacy; ?>
		    </a>
		    </td>
		    <td>
		    <a href="../profiles/pharmaceuticalProfile.php?pharmaceuticalId=<?php echo $pharmaceuticalId; ?>">
		    <?php echo $pharmaceuticalCompany; ?>
		    </a>
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
