<?php
require_once("./database.php");

$db = new Database();

if (isset($_POST['submit'])) {

    $tradeName = $_POST['tradeName'];
    $scientificName = $_POST['scientificName'];
    $formula = $_POST['formula'];
    $form = $_POST['form'];
    $dateManufactured = $_POST['dateManufactured'];
    $expiryDate = $_POST['expiryDate'];
    $supplyId = $_POST['supplyId'];
    $category = $_POST['category'];

    $imagepath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = './uploaded_images';
        $uploadFile = $uploadDir . '/' . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagepath = $uploadFile;
        }
    }

    $query = "INSERT INTO drug (tradeName, scientificName, formula, form, dateManufactured, expiryDate, supplyId, imagePath, category) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $values = [$tradeName, $scientificName, $formula, $form, $dateManufactured, $expiryDate, $supplyId, $imagepath, $category];

    $db->insertData($query, $values);
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="./css/editdrug.css">
</head>
<body>
  <h2>Drug Information Form</h2>
  <form action="" method="post" enctype="multipart/form-data">
    <label for="tradeName">Trade Name:</label>
    <input type="text" id="tradeName" name="tradeName"><br>

    <label for="scientificName">Scientific Name:</label>
    <input type="text" id="scientificName" name="scientificName"><br>

    <label for="formula">Formula:</label>
    <input type="text" id="formula" name="formula"><br>

    <label for="form">Form:</label>
    <input type="text" id="form" name="form"><br>

    <label for="dateManufactured">Date Manufactured:</label>
    <input type="datetime-local" id="dateManufactured" name="dateManufactured"><br>

    <label for="expiryDate">Expiry Date:</label>
    <input type="datetime-local" id="expiryDate" name="expiryDate"><br>

    <label for="supplyId">Supply ID:</label>
    <input type="text" id="supplyId" name="supplyId"><br>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*">

    <label for="category">Category:</label>
    <select id="category" name="category">
        <option value="Painkillers">Painkillers</option>
        <option value="Antidepressants">Antidepressants</option>
        <option value="Vaccines">Vaccines</option>
    </select><br>

    <input type="submit" value="Submit" name="submit">
</form>

</html>
