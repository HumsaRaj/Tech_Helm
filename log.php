<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
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
        <div class="col-md-12">
            <div class="card mb-4">
                <h2 class="text-center text-primary py-3 font-weight-bold">Logs/History</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Helmet Status</th>
                            <th>Drowsiness Status</th>
                            <th>Alcohol Detection</th>
                            <th>Bike Status</th>
                            <th>Reading Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        include("connection.php");
                        $sql = "SELECT * FROM vellore_smart_helmet2 ORDER BY id DESC LIMIT 200"; // Query to fetch last 50 records
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              // Assign sensor data to variables
                              $value1 = $row["value1"] == 0 ? "Alcohol Detected" : "Normal";
                              $value2 = $row["value2"] == 0 ? "Helmet Worn" : "Normal";
                              $value3 = $row["value3"] == 0 ? "Drowsiness Detected" : "Normal";
                              $value4 = ($row["value4"] >= 5.00 || $row["value4"] <= -5.00) ? "Movement Detected" : "Normal";
                              $value5 = $row["value5"] == 0 ? "Emergency" : "Normal";
                              $reading_time = $row["reading_time"];
                              
              
                              echo "
                              <tr>
                                <td>{$i}</td>
                                <td>{$value2}</td>
                                <td>{$value3}</td>
                                <td>{$value1}</td>
                                <td>{$value4}</td>
                                <td>{$reading_time}</td>
                              </tr>";
                              $i++;
                            }
                          } else {
                            echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                          }
                        ?>
                    </tbody>
                </table>
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
