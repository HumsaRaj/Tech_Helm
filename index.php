<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech-Helm Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecf1;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #007bff;
            border-radius: 15px;
            margin: 10px 15px 0px 15px;
        }
        .navbar a {
            position: relative;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: white;
            bottom: 3px;
            left: 50%;
            transition: width 0.4s ease, left 0.4s ease;
        }
        .navbar a:hover::after {
            width: 100%;
            left: 0;
        }

        /* Card Styling */
        .card {
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            overflow: hidden;
        }
        .card h2 {
            font-size: 28px;
        }
        .col-md-6, .col-md-12 {
            background-color: rgb(248, 250, 249);
            padding: 20px;
            margin-bottom: 15px; /* Adds space between columns */
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }
        .col-md-6:hover, .col-md-12:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        /* Padding for Button */
        .btn-primary {
            display: block;
            margin: 20px;
            padding: 10px 0;
        }

        .text-primary {
            color: #007bff;
        }
    </style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
      sessionStorage.setItem("a", position.coords.latitude);
      sessionStorage.setItem("b", position.coords.longitude);
      var a = position.coords.latitude;
      var b = position.coords.longitude;
      document.cookie = "a=" + a;
      document.cookie = "b=" + b;
    }

    $(document).ready(function() {
      getLocation();
    });
</script>
</head>
<body onload="getLocation()">
<?php
include("connection.php");
$sql="SELECT * FROM vellore_smart_helmet2 ORDER BY id DESC LIMIT 1";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$value1=$row["value1"];
$value2=$row["value2"];
$value3=$row["value3"];
$value4=$row["value4"];
$value5=$row["value5"];
$value6=$row["value6"];
$value7=$row["value7"];
$lat=$row["lat"];
$long=$row["long"];
$reading_time=$row["reading_time"];

if($value1 == 0) { $value1 = "Alcohol Detected"; } else { $value1 = "Normal"; }
if($value2 == 0) { $value2 = "Helmet Worn"; } else { $value2 = "Normal"; }
if($value3 == 0) { $value3 = "Drowsiness Detected"; } else { $value3 = "Normal"; }
if($value4 >= 5.00 || $value4 <= -5.00) { $value4 = "Movement Detected"; } else { $value4 = "Normal"; }
if($value5 == 0) { $value5 = "Emergency"; } else { $value5 = "Normal"; }
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <ul class="navbar-nav w-100 d-flex justify-content-between">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="setting.php">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="log.php">Logs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="track.php">Track</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Dashboard Card -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h2 class="text-center text-primary py-3 font-weight-bold">Tech-Helm Dashboard</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-center text-primary"><b>Helmet Status</b></h5>
                        <p class="text-center"><b><?=$value2?></b></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-center text-primary"><b>Drowsiness Status</b></h5>
                        <p class="text-center"><b><?=$value3?></b></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-center text-primary"><b>Alcohol Detection</b></h5>
                        <p class="text-center"><b><?=$value1?></b></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-center text-primary"><b>Bike Status</b></h5>
                        <p class="text-center"><b><?=$value4?></b></p>
                    </div>
                    <div class="col-md-12">
                        <h5 class="text-center text-primary"><b>GPS Location</b></h5>
                        <?php if ($value6 > 0 && $value7 > 0): ?>
                            <p class="text-center"><b>Value6: <?=$value6?> && Value7: <?=$value7?></b></p>
                        <?php else: ?>
                            <p class="text-center"><b>Latitude: <?=$_COOKIE['a']?> && Longitude: <?=$_COOKIE['b']?></b></p>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="btn btn-primary" style="width: 180px;" onclick="location.reload();">Refresh Data</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
