<?php

//include 'telenorscraper.php';

$con=mysqli_connect("localhost","root","usbw","telenorpackages");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT * FROM smspackages");

echo '<thead><tr><th>Bundle Name</th><th>Total SMS</th><th>Validity</th><th>Cost with Tax</th><th>Subscribe</th><th>Check Status</th></tr>
<tbody>';
while($row = mysqli_fetch_array($result1)) 
{
  echo '<tr><td>'. $row['All_Talkshawk'] .'</td>'. '<td>'.$row['Total_SMS'].'</td>'
   . '<td>'.$row['validity'].'</td>'. '<td>'.$row['tax_subscription'].'</td>'.
   '<td> Dial 555, press 5, followed by 1, and select appropriate option</td>'
.'<td> Dial *111# </td></tr>';
  
}
echo '</tbody>';

mysqli_close($con);
?>