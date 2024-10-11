<!DOCTYPE html>
<html lang="en">
<head>
  <title>Smart Helmet IoT System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar {
      margin-bottom: 20px;
    }
    .table-container {
      margin-top: 20px;
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

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Smart Helmet IoT</a>
  </nav>

  <div class="container-fluid">
    <h2 class="text-center text-primary my-3">Smart Helmet Sensor Data (Last 50 Records)</h2>

    <div class="table-container">
      <table class="table table-bordered table-hover">
        <thead class="table-primary">
          <tr>
            <th>S.No</th>
            <th>Alcohol Detection</th>
            <th>Helmet Status</th>
            <th>Eye Blink Detection</th>
            <th>Movement Detection</th>
            <th>Emergency Button</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Reading Time</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include("connection.php");
            $sql = "SELECT * FROM vellore_smart_helmet2 ORDER BY id DESC LIMIT 50"; // Query to fetch last 50 records
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
                $latitude = isset($_COOKIE['a']) ? $_COOKIE['a'] : 'N/A';
                $longitude = isset($_COOKIE['b']) ? $_COOKIE['b'] : 'N/A';

                echo "
                <tr>
                  <td>{$i}</td>
                  <td>{$value1}</td>
                  <td>{$value2}</td>
                  <td>{$value3}</td>
                  <td>{$value4}</td>
                  <td>{$value5}</td>
                  <td>{$latitude}</td>
                  <td>{$longitude}</td>
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

    <div class="col-md-12">
      <iframe class="mt-4" src="https://maps.google.com/maps?q=<?=$_COOKIE['a']?>,<?=$_COOKIE['b']?>&hl=es;z=14&output=embed" style="width:100%; height:400px; border:0;"></iframe>
    </div>
  </div>
</body>
</html>
