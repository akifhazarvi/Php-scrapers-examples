<?php
$teams = array();
$package_name=array();

$html = file_get_contents('http://www.mobilink.com.pk/prepaid/offers/sms-bundles/'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

  $pokemon_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $pokemon_xpath = new DOMXPath($pokemon_doc);
  $xpath=new DOMXPath($pokemon_doc);

  //get all the h2's with an id
  $pokemon_row = $pokemon_xpath->query('//*[@id="post-1279"]/div/table/tbody/tr/td');
  $heading_row=$xpath->query('//*[@id="post-1279"]/div/table/tbody/tr[1]/th');
//echo "<ul>";
  //if($pokemon_row->length > 0){
    //  foreach($pokemon_row as $row){
      //    echo "<li>". $row->nodeValue . "</li>";
      //}
  //}
  //echo "</ul>";


 $rows = '';


// Pull team names into array
foreach ($pokemon_row as $result_object){
   $teams[] = $result_object->nodeValue;
}
print_r($teams);
foreach ($heading_row as $result){
   $package_name[] = $result->nodeValue;
}


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

$i=1;
$j=0;

//echo count($teams);
while($i<=4)
{
	if($j<count($package_name))
	{
	 $Bundle_name=$package_name[$j+1];
	
	}
     
	 $Subscription_fee=$teams[$i];
	 $expirydate=$teams[$i+5];
	 $Validity=$teams[$i+10];
	 $Subscription_string=$teams[$i+15];
	 $unsubscription_string=$teams[$i+20];
	 $status_string=$teams[$i+25];
	 $information_string=$teams[$i+30];

	
	


//	echo "<br>";


$sql = "INSERT INTO mobilink_sms
       (Bundle_name,Subscription_fee,Validity,Subscription_string,unsubscription_string,status_string,information_string,incentive) 
       VALUES ('$Bundle_name','$Subscription_fee','$Validity','$Subscription_string','$unsubscription_string','$status_string','$information_string','$expirydate')";
$i=$i+1;
$j=$j+1;


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