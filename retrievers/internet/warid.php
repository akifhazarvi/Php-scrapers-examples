<?php

//include 'telenorscraper.php';

$con=mysqli_connect("localhost","root","usbw","telenorpackages");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT * FROM warid_internet ");

echo '<thead><tr><th>Bundle Name</th><th>Package Name</th><th>Price</th><th>Subscribe</th><th>Check Status</th></tr>
<tbody>';
while($row = mysqli_fetch_array($result1)) 
{
  echo '<tr><td>'. $row['Bundle_name'] .'</td>'. '<td>'. $row['package_name'].'</td>'. '<td>'.$row['Price'].'</td>'
   . '<td>'.$row['Subscribe'].'</td>'. '<td>'.$row['Check_Status'].'</td>'.'</td></tr>';
  
}
echo '</tbody>';

mysqli_close($con);
?>