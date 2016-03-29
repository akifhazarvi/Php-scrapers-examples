<?php

//include 'telenorscraper.php';
$con=mysqli_connect("localhost","root","usbw","telenorpackages");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT * FROM mobilink_internet");

echo '<thead><tr><th>Bundle Name</th><th>Price</th><th>Data Volume</th><th>Validity</th><th>Time Window</th><th>Subscribe</th><th>Unsubscribe</th></tr></thead>
<tbody>';
while($row = mysqli_fetch_array($result1))
{
  echo '<tr><td>'. $row['package_name'] .'</td>'. '<td>'. $row['Price'].'</td>'. '<td>'.$row['data_volume'].'</td>'
   . '<td>'.$row['Validity'].'</td>'. '<td>'.$row['Time_Window'].'</td>'.
   '<td>'.$row['Subscribe'].'</td>'
.'<td>'.$row['unsubscribe'].'</tr>';
  
}
echo '</tbody>';

mysqli_close($con);
?>
