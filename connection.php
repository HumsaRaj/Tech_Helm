<?php
$servername = "localhost";

$dbname = "domainio_domain_iot";
$username = "domainio_iot";
$password = "domain_iot";
 

 $conn=mysqli_connect($servername,$username,$password,$dbname);

 if($conn) {
//  	echo "Connnected Successfully";
 } else {
// 	echo "not Connected";
 }

