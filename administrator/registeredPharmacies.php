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
    <title>Registered Pharmacies</title>
    <link href = "styles.css" rel = "stylesheet">
</head>
<body>
    <div class="container">
        <h2>Registered Pharmacies</h2>
        <table>
            <thead>
                <tr>
                    <th>Pharmacy ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Fetch the registered pharmacies from the database
                $db = new Database();
                $query = "SELECT * FROM pharmacy";
                $pharmacies = $db->queryData($query, array());

                foreach ($pharmacies as $pharmacy) {
                    echo "<tr class='row'>";
                    echo "<td>" . $pharmacy['pharmacyId'] . "</td>";
                    echo "<td><a href='../profiles/pharmacyProfile.php?pharmacyId=" . $pharmacy['pharmacyId'] . "'>" . $pharmacy['name'] . "</a></td>";
                    echo "<td><a href='https://maps.google.com/?q=" . $pharmacy['location'] . "' target='_blank'>" . $pharmacy['location'] . "</a></td>";
                    echo "<td><a href='mailto:" . $pharmacy['emailAddress'] . "'>" . $pharmacy['emailAddress'] . "</a></td>";
                    echo "<td><a href='tel:" . $pharmacy['phoneNumber'] . "'>" . $pharmacy['phoneNumber'] . "</a></td>";
                    echo "</tr>";
                }
                $db->disconnect();
                ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php
            $totalPharmacies = count($pharmacies);
            $itemsPerPage = 10;
            $totalPages = ceil($totalPharmacies / $itemsPerPage);

            for ($page = 1; $page <= $totalPages; $page++) {
                echo "<a class='pagination-link" . ($page === 1 ? " active" : "") . "' onclick='changePage($page)'>$page</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>
