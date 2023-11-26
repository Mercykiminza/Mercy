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
    <title>Registered Pharmaceuticals</title>
    <link href = "styles.css" rel = "stylesheet">
    <script>
        // JavaScript for pagination
        function changePage(page) {
            var rows = document.getElementsByClassName('row');
            var itemsPerPage = 10;
            var startIndex = (page - 1) * itemsPerPage;
            var endIndex = startIndex + itemsPerPage;

            for (var i = 0; i < rows.length; i++) {
                if (i >= startIndex && i < endIndex) {
                    rows[i].style.display = 'table-row';
                } else {
                    rows[i].style.display = 'none';
                }
            }

            var paginationLinks = document.getElementsByClassName('pagination-link');
            for (var j = 0; j < paginationLinks.length; j++) {
                paginationLinks[j].classList.remove('active');
            }
            paginationLinks[page - 1].classList.add('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Registered Pharmaceuticals</h2>
        <table>
            <thead>
                <tr>
                    <th>Pharmaceutical ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../database.php';

                // Fetch the registered pharmaceuticals from the database
                $db = new Database();
                $query = "SELECT * FROM pharmaceutical";
                $pharmaceuticals = $db->queryData($query, array());

                foreach ($pharmaceuticals as $pharmaceutical) {
                    echo "<tr class='row'>";
                    echo "<td>" . $pharmaceutical['pharmaceuticalId'] . "</td>";
                    echo "<td><a href='../profiles/pharmaceuticalProfile.php?pharmaceuticalId=" . $pharmaceutical['pharmaceuticalId'] . "'>" . $pharmaceutical['name'] . "</a></td>";
                    echo "<td><a href='https://maps.google.com/?q=" . $pharmaceutical['location'] . "' target='_blank'>" . $pharmaceutical['location'] . "</a></td>";
                    echo "<td><a href='mailto:" . $pharmaceutical['emailAddress'] . "'>" . $pharmaceutical['emailAddress'] . "</a></td>";
                    echo "<td><a href='tel:" . $pharmaceutical['phoneNumber'] . "'>" . $pharmaceutical['phoneNumber'] . "</a></td>";
                    echo "</tr>";
                }
                $db->disconnect();
                ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php
            $totalPharmaceuticals = count($pharmaceuticals);
            $itemsPerPage = 10;
            $totalPages = ceil($totalPharmaceuticals / $itemsPerPage);

            for ($page = 1; $page <= $totalPages; $page++) {
                echo "<a class='pagination-link" . ($page === 1 ? " active" : "") . "' onclick='changePage($page)'>$page</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>
