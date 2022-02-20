<!DOCTYPE html>
<html>
<head>
	<title>سامانه مانیتورینگ داتک</title>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
	<link href="css/main.css" rel="stylesheet">
</head>

<body>
<div id="Fatehchehr_api" style="width:100%;height:500px"></div>
<?php
//include 'Time.php';

$servername = "localhost";
$username = "root";
$password = "Zabbixperia";
$dbname = "Fatehchehr";


if(isset($_GET['link'])){
	//connect to db and get link data
/////////////////////////////////////////////////////////
// Create connection
$link_name = $_GET['link'] ;

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error)
	{
	die("Connection failed: " . $conn->connect_error);
	}

$sql = "SELECT * FROM `fatehchehr_map` WHERE `link-name` LIKE '%".$link_name."'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
	{

	// output data of each row

	while ($row = $result->fetch_assoc())
		{
		
	//show the map
	
echo "	
<script>
function myMap() {
  var p1 = new google.maps.LatLng(".$row["B-long"].",".$row["B-lat"].");
  var p2 = new google.maps.LatLng(".$row["D-long"].",".$row["D-lat"].");

  var mapCanvas = document.getElementById('Fatehchehr_api');
  var mapOptions = {center: p2, zoom:".$row["zoom"]."};
  var map = new google.maps.Map(mapCanvas,mapOptions);

  var flightPath = new google.maps.Polyline({
    path: [p1, p2],
    strokeColor: '#f98110',
    strokeOpacity: 0.8,
    strokeWeight: 3
  });
  flightPath.setMap(map);
}
</script>

<script src='http://maps.google.com/maps/api/js?sensor=false&callback=myMap'></script>";

		}
		$conn->close();	
	
	}else{
		echo "Error! DataBase connection...Dead";
	}
	
	//if link name is not recognize

	
}else{
	
	echo "Warning!"."</br>"."Please Enter link name";
}


?>



			<!-- Footer -->
			
			<footer id="footer">
				<p class="copyright">&copy; 2018: <a href="mailto:m.fatehchehr@datak.ir">Fatehchehr</a>.</p>
			</footer>

</body>
</html>