<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech-Helm Dashboard - Track</title>
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
        }
        .card h2 {
            font-size: 28px;
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
</head>
<body>

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

<!-- Tracking Card -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <h2 class="text-center text-primary pt-3 font-weight-bold">Track</h2>
                <?php
                include("connection.php");
                $sql="SELECT * FROM vellore_smart_helmet2 ORDER BY id DESC LIMIT 1";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $value6 = $row["value6"];
                $value7 = $row["value7"];
                $lat = $row["lat"];
                $long = $row["long"];
                ?>
                <iframe class="p-4" 
                        src="https://maps.google.com/maps?q=<?php echo ($value6 > 0 && $value7 > 0) ? $value6 . ',' . $value7 : $lat . ',' . $long; ?>&hl=es;z=14&output=embed" 
                        style="width:100%; height:400px; border:0;"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
