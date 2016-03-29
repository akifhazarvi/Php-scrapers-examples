<?php

$urltoget = "http://www.waridtel.com/prepaid/sms_bundle.php";
$html = file_get_contents($urltoget); //get the html returned from the following url

$sms_warid_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned


  $sms_warid_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $sms_warid_xpath = new DOMXPath($sms_warid_doc);

  //get all the h2's with an id
 $xpath_res_warid = $sms_warid_xpath->query('//td[@bgcolor="#F2F2F2" and @height="20"]');

  $dbhandle = mysql_connect('localhost:3307', 'root', 'usbw') 
  or die("Unable to connect to MySQL");
  echo "Connected to MySQL<br>";

  $selected = mysql_select_db("telenorpackages",$dbhandle) 
  or die("Could not select database");

  $xpath_res_array = array();

  foreach ($xpath_res_warid as $first) {
    $xpath_res_array[]= $first->nodeValue;
  }

  $array_without_nulls = array();

  $array_without_nulls = array_filter($xpath_res_array);

  $rowcontainer = array();

  if($xpath_res_warid->length > 0){
      $rowcount=0;
      print $xpath_res_warid->length;
      $arr = array();

      foreach($array_without_nulls as $row){

          $rowcontainer[]= $row;
          

          $rowcount++;
          if ($rowcount%4 == 0){

            if ($rowcount == 4){
              $code = 'sms "DS" to 3333';
            }

            if ($rowcount == 8){
              $code = 'sms "WS" to 3333';
            } 

            $arr = explode("+", $rowcontainer[1], 2);
            $first = $arr[0];
            $second = substr($first, 3);
            $third = (float)$second;

            $r = mysql_query("INSERT INTO warid_sms(package, cost, number, validity, code) VALUES ('$rowcontainer[0]', $third, '$rowcontainer[2]', '$rowcontainer[3]', '$code')");
            //print "Inserting into database <br>";
            //print_r($rowcontainer);
            $rowcontainer = array();
            $arr = array();
          }
      }
  }

  mysql_close($dbhandle);
}
?>