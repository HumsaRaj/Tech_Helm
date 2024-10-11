<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            /* margin-top: 10px; */
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
            /* overflow: hidden; */
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

<!-- Dashboard Card -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <h2 class="text-center text-primary py-3 font-weight-bold">Settings</h2>
                <form action="" method="post" class="p-3">
                    <div class="form-group">
                        <label for=""><b>Emergency Contacts</b></label>
                        <input type="text" class="form-control" placeholder="Add Contacts">
                    </div>
                    <div class="form-group">
                        <label for=""><b>Eye-Blink Sensor Threshold:</b></label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Low Sensitivity (less frequent blinks)</option>
                            <option>Medium Sensitivity (balanced)</option>
                            <option>High Sensitivity (more frequent blinks)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Alcohol Sensor Threshold:</b></label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>0.02% BAC (Very Low)</option>
                            <option>0.05% BAC (Low)</option>
                            <option>0.08% BAC (Standard Limit)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Helmet Detection Sensitivity:</b></label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Low (Less Strict Detection)</option>
                            <option>Medium (Balanced)</option>
                            <option>High (Strict Detection)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Accident Detection Sensitivity:</b></label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Low (Detect Only Strong Impacts)</option>
                            <option>Medium (Balanced Sensitivity)</option>
                            <option>High (Detect even minor impacts)</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-success btn-block" value="Save Settings">
                </form>
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
