<?php
require_once("./database.php");

$db = new Database();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $drugId = $_GET['id'];

    // Query to retrieve drug details based on the provided drugId
    $query = "SELECT * FROM drug WHERE drugId = ?";
    $values = [$drugId];
    $result = $db->selectData($query, $values);

    if ($result && count($result) > 0) {
        $drug = $result[0]; // Assuming only one record is found
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/drug.css">
    <title>Document</title>
</head>
<body>
    <div class="drug-details-container">
        <h1>Drug Details</h1>
        <?php
        if ($drug) {
            echo '<p><span class="label">Trade Name:</span> ' . htmlspecialchars($drug['tradeName']) . '</p>';
            echo '<p><span class="label">Scientific Name:</span> ' . htmlspecialchars($drug['scientificName']) . '</p>';
            echo '<p><span class="label">Formula:</span> ' . htmlspecialchars($drug['formula']) . '</p>';
            echo '<p><span class="label">Form:</span> ' . htmlspecialchars($drug['form']) . '</p>';
            echo '<p><span class="label">Date Manufactured:</span> ' . htmlspecialchars($drug['dateManufactured']) . '</p>';
            echo '<p><span class="label">Expiry Date:</span> ' . htmlspecialchars($drug['expiryDate']) . '</p>';
            echo '<p><span class="label">Supply ID:</span> ' . htmlspecialchars($drug['supplyId']) . '</p>';
            echo '<p><span class="label">Category:</span> ' . htmlspecialchars($drug['category']) . '</p>';
            echo '<br/>';
            echo '<img src="' . htmlspecialchars($drug['imagePath']) . '" alt="' . htmlspecialchars($drug['tradeName']) . '">';
        } else {
            echo '<p class="error-message">Drug not found.</p>';
        }
        ?>
        <br>
        <br>
        <a href="javascript:history.back()" class="back-button">Back</a>
    </div>
</body>
</html>

<?php
    } else {
       
        echo 'Drug not found.';
    }
} else {
    
    echo 'Invalid or missing drug ID.';
}
?>
