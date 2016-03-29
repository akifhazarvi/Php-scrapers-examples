<?php

//include 'telenorscraper.php';

$con=mysqli_connect("localhost","root","usbw","telenorpackages");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT * FROM mobilink_sms");

echo '<thead><tr><th>Bundle Name</th><th>Incentive</th><th>Subscription Fee</th><th>Validity</th><th>Subscription String</th><th>Unsubscription</th><th>Check Status</th><th>Information String</th></tr>
<tbody>';
while($row = mysqli_fetch_array($result1)) 
{
  echo '<tr><td>'. $row['Bundle_name'] .'</td>'. '<td>'. $row['incentive'].'</td>'. '<td>'.$row['Subscription_fee'].'</td>'
   . '<td>'.$row['Validity'].'</td>'. '<td>'.$row['Subscription_string'].'</td>'.
   '<td>'.$row['unsubscription_string'].'</td>'
.'<td>'.$row['status_string'].'<td>'.$row['information_string'] .'</td>'.'</td></tr>';
  
}
echo '</tbody>';

mysqli_close($con);
?>