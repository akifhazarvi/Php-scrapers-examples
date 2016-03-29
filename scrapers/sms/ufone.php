<?php

$urltoget = "http://www.ufone.com/prepaid/Bundle-Offers/SMS-Bundle-Offer/";
$html = file_get_contents($urltoget); //get the html returned from the following url

$sms_ufone_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned


  $sms_ufone_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $sms_ufone_xpath = new DOMXPath($sms_ufone_doc);

  //get all the h2's with an id
 $xpath_res_ufone = $sms_ufone_xpath->query('//span[@class="package-desc03-fa"]');

  $dbhandle = mysql_connect('localhost:3307', 'root', 'usbw') 
  or die("Unable to connect to MySQL");
  echo "Connected to MySQL<br>";

  $selected = mysql_select_db("telenorpackages",$dbhandle) 
  or die("Could not select database");

  $xpath_res_array = array();

  foreach ($xpath_res_ufone as $first) {
    $xpath_res_array[]= $first->nodeValue;
  }

  $array_without_nulls = array();

  $array_without_nulls = array_filter($xpath_res_array);

  $rowcontainer = array();

  if($xpath_res_ufone->length > 0){
      $rowcount=0;
      print $xpath_res_ufone->length;
      $arr = array();

      foreach($array_without_nulls as $row){

          $rowcontainer[]= $row;

          $rowcount++;
          if ($rowcount%5 ==0){

            $arr = explode("+", $rowcontainer[1], 2);
            $first = $arr[0];
            $second = substr($first, 3);
            $third = (float)$second;

            $r = mysql_query("INSERT INTO ufone_sms(package, cost, number, validity, code) VALUES ('$rowcontainer[0]', $third, '$rowcontainer[2]', '$rowcontainer[3]', '$rowcontainer[4]')");
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