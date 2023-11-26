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
  <title>Administrator Dashboard</title>
  <link rel = "stylesheet" type = "text/css" href = "administratorDashboard.css">
</head>
<body>
  <div class="container">
    <a href="prescriptions.php">
      <div class="card">
	<h2>Prescriptions</h2>
      </div>
    </a>
    <a href="registeredContracts.php">
      <div class="card">
	<h2>Registered Contracts</h2>
      </div>
    </a>
    <a href="registeredDoctors.php">
      <div class="card">
	<h2>Registered Doctors</h2>
      </div>
    </a>
    <a href="registeredHealthCenters.php">
      <div class="card">
	<h2>Registered Health Centers</h2>
      </div>
    </a>
    <a href="registeredPatients.php">
      <div class="card">
	<h2>Registered Patients</h2>
      </div>
    </a>
    <a href="registeredPharmaceuticals.php">
      <div class="card">
	<h2>Registered Pharmaceuticals</h2>
      </div>
    </a>
    <a href="registeredPharmacies.php">
      <div class="card">
	<h2>Registered Pharmacies</h2>
      </div>
    </a>
    <a href="registeredPharmacists.php">
      <div class="card">
	<h2>Registered Pharmacists</h2>
      </div>
    </a>
    <a href="registeredSupervisors.php">
      <div class="card">
	<h2>Registered Supervisors</h2>
      </div>
    </a>
    <!--<a href="../add_drug.php">
      <div class="card">
	<h2>Drugs</h2>
      </div>
    </a>
  </div>-->

  <div class="container">
    <a href="../registration/registerDoctor.php" class="add-record-link">Add Doctor</a>
    <a href="../registration/registerHospital.php" class="add-record-link">Add Hospital</a>
    <a href="../registration/registerPatient.php" class="add-record-link">Add Patient</a>
    <a href="../registration/registerPharmaceutical.php" class="add-record-link">Add Pharmaceutical</a>
    <a href="../registration/registerPharmacist.php" class="add-record-link">Add Pharmacist</a>
    <a href="../registration/registerPharmacy.php" class="add-record-link">Add Pharmacy</a>
    <a href="../registration/registerSupervisor.php" class="add-record-link">Add Supervisor</a>
    <a href="../add_drug.php" class="add-record-link">Add Drugs</a>
  </div>

  <div class="logout-button">
    <a href="../authentication/logout.php">Logout</a>
  </div>
</body>
</html>

