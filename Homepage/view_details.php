<?php
// Check if the drug_id is provided as a query parameter
if (isset($_GET["drugId"])) {
    $drugId = $_GET["drugId"];}

    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "drug_dispenser";
    
    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Function to fetch drug details
    function fetchDrugDetails($conn, $drugId) {
        $sql = "SELECT * FROM drug WHERE drug_id = ?";
        
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $drugId);
        
        // Execute the query
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        
        // Fetch drug details as an associative array
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null; // Drug not found
        }
        
        // Close the statement
        $stmt->close();
    }
    
    // Fetch drug details based on $drugId
    $drugId = $_GET["drugId"]; // Assuming you receive drug_id as a query parameter
    $drugDetails = fetchDrugDetails($conn, $drugId);
    
    // Close the database connection
    $conn->close();
    ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>Drug Details</title>
    </head>
    <body>
        <h1>Drug Details</h1>
        <?php
        if ($drugDetails) {
            echo "<h2>{$drugDetails['drug_name']}</h2>";
            echo "<p>Description: {$drugDetails['description']}</p>";
            echo "<p>Price: {$drugDetails['price']}</p>";
            // Add more drug details as needed
        } else {
            echo "<p>Drug details not found.</p>";
        }
        ?>
    </body>
    </html>
    

?>

<!DOCTYPE html>
<html>
<head>
    <title>Drug Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Drug Details</h1>
    </header>
    <main>
        <div class="drug-details">
            <?php
            if (isset($drugDetails)) {
                // Display drug details here, e.g., name, description, price, etc.
                echo "<h2>Drug Name: {$drugDetails['name']}</h2>";
                echo "<p>Description: {$drugDetails['description']}</p>";
                // Add more drug details as needed
            } else {
                echo "<p>Drug details not found.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
