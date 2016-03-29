<?php
$teams = array();

$html = file_get_contents('http://www.telenor.com.pk/telenor-sms-full-time'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

  $pokemon_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $pokemon_xpath = new DOMXPath($pokemon_doc);

  //get all the h2's with an id
  $pokemon_row = $pokemon_xpath->query('//*[@id="tbl_generic"]/tbody/tr/td');
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
//print_r($teams);

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
	 $AllTalkshawk=$teams[$i];
	 $Subscription=$teams[$i+1];
	 $tax_subscription=$teams[$i+2];
	 $Total_SMS=$teams[$i+3];
	 $validity=$teams[$i+4];
	 $Time_Window=$teams[$i+5];
	//echo $All_Talkshawk;

	//echo $AllTalkshawk;echo "<br>";
	//echo $Subscription;echo "<br>";
	//echo $tax_subscription;echo "<br>";
	//echo $Total_SMS;echo "<br>";
	//echo $validity;echo "<br>";
	//echo $Time_Window;echo "<br>";

//	echo "<br>";


$sql = "INSERT INTO smspackages
       (All_Talkshawk,Subscription,tax_subscription,Total_SMS,validity,Time_Window) 
       VALUES ('$AllTalkshawk','$Subscription','$tax_subscription','$Total_SMS','$validity','$Time_Window')";
$i=$i+6;


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