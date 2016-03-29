<?php

//include 'telenorscraper.php';

$con=mysqli_connect("localhost","root","usbw","telenorpackages");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT * FROM ufone_sms");

echo '<thead><tr><th>Bundle Name</th><th>Price</th><th>Volume</th><th>Expiry</th><th>Activation String</th></tr>
<tbody>';
while($row = mysqli_fetch_array($result1)) 
{
  echo '<tr><td>'. $row['package'] .'</td>'. '<td>'.$row['cost'].'</td>'
   . '<td>'.$row['number'].'</td>'. '<td>'.$row['validity'].'</td>'
.'<td>'. $row['code'].'</td></tr>';
  
}
echo '</tbody>';

mysqli_close($con);
?>