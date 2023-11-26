<?php
require_once("./database.php");

$db = new Database();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&D PHARMACY</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <nav class="dashboard">
        <div><img src="" alt="IMAGE"> </div>
        <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact us</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </nav>
    <section class="banner">
        <div class="bannertext">
            <h1>HEALTHCARE MADE FAST</h1>
            <p>offer online consultations and <br/> sell fast moving drugs to our clients</p>
        </div>
        <img src="./images/banner.png" alt=" Banner image">
    </section>

    <div class="call-to-action">
        <a href="./registration/registerPatient.php">
            <button class="call-btn">Register</button>
        </a>
        <a href="./authentication/login.php">
            <button class="call-btn">Login</button>
        </a>
        <a href="#">
            <button class="call-btn">Learn more</button>

        </a>
    </div>


    <section class="drug">
    <h1>DRUGS CATEGORIES</h1>

    <?php
    $categoriesAndQueries = [
        "Pain killers" => "SELECT * FROM drug WHERE category = 'Painkillers' LIMIT 3",
        "Anti-depressants" => "SELECT * FROM drug WHERE category = 'Antidepressants' LIMIT 3",
        "Vaccines" => "SELECT *FROM drug WHERE category = 'Vaccines' LIMIT 3"
    ];

    foreach ($categoriesAndQueries as $category => $query) {
        $result = $db->selectData($query);
    
        echo '<h2>' . htmlspecialchars($category) . '</h2>';
    
        if ($result) {
            echo '<div class="card-row">';
            foreach ($result as $row) {
                echo '<div class="card">';
                echo '<p>' . htmlspecialchars($row['tradeName']) . '</p>';
                echo '<img src="' . htmlspecialchars($row['imagePath']) . '" alt="' . htmlspecialchars($row['tradeName']) . '">';
                echo '<a href="drug.php?id=' . $row['drugId'] . '" class="btn">View More</a>'; // Corrected link
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No drugs available in this category.</p>';
        }
    }
    
    ?>
</section>

    <?php
    require_once('./templates/footer.php');
    ?>
</body>
</html>
