<?php
$teams = array();

$html = file_get_contents('http://www.waridtel.com/products/unlimited_internet_bucket.php'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

  $pokemon_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $pokemon_xpath = new DOMXPath($pokemon_doc);

  //get all the h2's with an id
  $pokemon_row = $pokemon_xpath->query('//table[@width="530"]/tr[@bgcolor="#F2F2F2"]/td');
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
while($i<count($teams))
{
	 $package_name=$teams[$i];
	 $Price=$teams[$i+1];
	 $Subscribe=$teams[$i+2];
	 $Check_Status=$teams[$i+3];

if($Check_Status=="Dial *200*4#" && $i<30)
{
   $bundle_name="Daily Bundles";
}
if ($Check_Status=="Dial *200*9#") 
{
  $bundle_name="Weekly Bundles";
}
if ($Check_Status=="Dial *200*3#") 
{
  $bundle_name="Monthly Bundles";
}
if($Check_Status=="Dial *200*4#" && $i>=30)
{
  $bundle_name="Daily Recursive Bundles";

}
	 
	//echo $All_Talkshawk;

	//echo $AllTalkshawk;echo "<br>";
	//echo $Subscription;echo "<br>";
	//echo $tax_subscription;echo "<br>";
	//echo $Total_SMS;echo "<br>";
	//echo $validity;echo "<br>";
	//echo $Time_Window;echo "<br>";

//	echo "<br>";


$sql = "INSERT INTO warid_internet
       (package_name,Price,Subscribe,Check_Status,Bundle_name) 
       VALUES ('$package_name','$Price','$Subscribe','$Check_Status','$bundle_name')";
$i=$i+4;


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