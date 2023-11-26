<?php
 // Database configuration
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "drug_dispenser";
 
 // Create a database connection
 $con = new mysqli($servername, $username, $password, $dbname);
$con - mysqli ('localhost','root','','drug_dispenser');
if($con){
    echo "DB connected";

}
else{
    echo "DB connection faiiled";
}
?>