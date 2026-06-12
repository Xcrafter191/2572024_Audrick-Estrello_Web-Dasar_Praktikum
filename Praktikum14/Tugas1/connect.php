<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mybebe_guest";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected succesfully";
} catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
?>