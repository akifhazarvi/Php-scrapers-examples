<?php
$teams = array();

$html = file_get_contents('http://www.mobilink.com.pk/mobilink-mobile-internet/mobile-internet-package-plans'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

  $pokemon_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $pokemon_xpath = new DOMXPath($pokemon_doc);

  //get all the h2's with an id
  $pokemon_row = $pokemon_xpath->query('//table/tr/td/p');
    //  foreach($pokemon_row as $row){
      //    echo "<li>". $row->nodeValue . "</li>";
      //}
  //}
  //echo "</ul>";





// Pull team names into array
foreach ($pokemon_row as $result_object)
{
   $teams[] = $result_object->nodeValue;
  


}
print_r($teams);

// Extract two teams per table row

//while(count($teams)){
  // $matchup = array_splice($teams, 0, 1);
   //$rows .= '<tr><td>'.implode('</td><td>', $matchup).'</td></tr>';
    //echo "<tr>";
   //foreach ($matchup as $column) {
     // echo "<td>".$column ."</td>";
   //}
    //echo "</tr>";

//}

    


// Write out the table
//echo "<table>$rows</table>";

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'usbw';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}

$i=0;

//echo count($teams);
while($i<count($teams)-6)
{
	 $Sr=$teams[$i];
   $package_name=$teams[$i+1];
   $Price=$teams[$i+2];
	 $data_volume=$teams[$i+3];
	 $Validity=$teams[$i+4];
	 $Time_Window=$teams[$i+5];
   $Subscribe=$teams[$i+6];
   $unsubscribe=$teams[$i+7];
	 
	//echo $All_Talkshawk;

	//echo $AllTalkshawk;echo "<br>";
	//echo $Subscription;echo "<br>";
	//echo $tax_subscription;echo "<br>";
	//echo $Total_SMS;echo "<br>";
	//echo $validity;echo "<br>";
	//echo $Time_Window;echo "<br>";

//	echo "<br>";


$sql = "INSERT INTO mobilink_internet
       (Sr,package_name,Price,data_volume,Validity,Time_Window,Subscribe,unsubscribe) 
       VALUES ('$Sr','$package_name','$Price','$data_volume','$Validity','$Time_Window','$Subscribe','$unsubscribe')";
$i=$i+8;


mysql_select_db('telenorpackages');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not enter data: ' . mysql_error());
}
}

echo "Entered data successfully\n";
mysql_close($conn);
}

?>