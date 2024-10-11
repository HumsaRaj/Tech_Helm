<?php

include "connection.php";
$value1 = $_POST['value1'];
$value2 = $_POST['value2'];
$value3 = $_POST['value3'];
$value4 = $_POST['value4'];
$value5 = $_POST['value5'];
$value6 = $_POST['value6'];
$value7 = $_POST['value7'];

$coordinates = [
    ["lat" => "12.969828", "long" => "79.155014"], // VIT Main Building
    ["lat" => "12.971340", "long" => "79.160150"], // Technology Tower
    ["lat" => "12.970540", "long" => "79.160420"], // VIT Library
    ["lat" => "12.971686", "long" => "79.161301"], // SJT Building
    ["lat" => "12.969291", "long" => "79.157667"]  // Outdoor Stadium
];

// Shuffle the array and select the first pair
shuffle($coordinates);
$selectedCoordinate = $coordinates[0];

$lat = $selectedCoordinate['lat'];
$long = $selectedCoordinate['long'];

date_default_timezone_set('Asia/Kolkata');
$timestamp = date("Y-m-d H:i:s");

$sql = "INSERT INTO vellore_smart_helmet2 (value1, value2, value3, value4, value5, value6, value7, lat, `long`, reading_time)
VALUES ('$value1', '$value2', '$value3', '$value4', '$value5', '$value6', '$value7', '$lat', '$long', '$timestamp')";


$result = mysqli_query($conn, $sql);

if ($result) {
    echo "New record created successfully";
} else {
    // Display the error
    echo "Values Are Not Entered. MySQL Error: " . mysqli_error($conn);
}

$sql4 = "SELECT * FROM vellore_smart_helmet2";
$result4 = mysqli_query($conn, $sql4);

if ($result4 && mysqli_num_rows($result4) > 200) {
    $sql51 = "DELETE FROM vellore_smart_helmet2 ORDER BY id ASC LIMIT 1";
    $result51 = mysqli_query($conn, $sql51);
    
    if ($result51) {
        echo "Deleted Successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

?>
