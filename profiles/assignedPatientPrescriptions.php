<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
  header('Location: ../authentication/login.php');
  exit();
}

// Check if the user is administrator
if ($_SESSION['user'] !== 'Administrator' && $_SESSION['user'] !== 'Patient') {
  header('Location: ../permissionDenied.php');
  exit();
}

if ($_GET['patientId'])
{
	$patientId = $_GET['patientId'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescriptions</title>
    <link rel="stylesheet" type="text/css" href="../administrator/styles.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="pagination.js"></script>
</head>
<body>
    <div class="container">
        <h2>Prescriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Doctor</th>
                    <th>Drug</th>
                    <th>Dosage</th>
                    <th>Quantity</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Create a new instance of the Database class
                $db = new Database();

                // Query the prescription, consultation, doctor, patient, and drug tables to retrieve relevant data
                $query = "SELECT p.prescriptionId, d.firstName AS doctorFirstName, d.doctorId, d.lastName AS doctorLastName, 
                          dr.tradeName AS drugTradeName, p.dosage, p.quantity, p.startDate, p.endDate, p.dateCreated 
                          FROM prescription p 
                          INNER JOIN consultation c ON p.consultationId = c.consultationID 
                          INNER JOIN patient_doctor pd ON c.patientDoctorId = pd.patientDoctorId 
                          INNER JOIN doctor d ON pd.doctorId = d.doctorId 
                          INNER JOIN patient pt ON pd.patientId = pt.patientId
                          INNER JOIN drug dr ON p.drugId = dr.drugId WHERE pd.patientId = $patientId";
                $prescriptions = $db->queryData($query, []);

                // Iterate over the prescriptions and populate the table rows dynamically
                foreach ($prescriptions as $prescription) {
                    $prescriptionId = $prescription['prescriptionId'];
                    $doctorFirstName = $prescription['doctorFirstName'];
                    $doctorLastName = $prescription['doctorLastName'];
                    $drugTradeName = $prescription['drugTradeName'];
                    $dosage = $prescription['dosage'];
                    $quantity = $prescription['quantity'];
                    $startDate = $prescription['startDate'];
                    $endDate = $prescription['endDate'];
                    $dateCreated = $prescription['dateCreated'];
                    $doctorId = $prescription['doctorId'];

                    ?>
                    <tr>
                        <td><?php echo $prescriptionId; ?></td>
                        <td><a href="../profiles/doctorProfile.php?doctorId=<?php echo $doctorId; ?>"><?php echo $doctorFirstName . ' ' . $doctorLastName; ?></a></td>
                        <td><?php echo $drugTradeName; ?></td>
                        <td><?php echo $dosage; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $startDate; ?></td>
                        <td><?php echo $endDate; ?></td>
                        <td><?php echo $dateCreated; ?></td>
                    </tr>
                    <?
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
