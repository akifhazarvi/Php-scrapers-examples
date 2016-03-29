<?php

$urltoget = "http://www.ufone.com/vas/Browsing/Mobile-Internet-and-MMS/";
$html = file_get_contents($urltoget); //get the html returned from the following url

$internet_warid_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned


  $internet_warid_doc->loadHTML($html);
  libxml_clear_errors(); //remove errors for yucky html
  
  $internet_warid_xpath = new DOMXPath($internet_warid_doc);

  //get all the h2's with an id
  $xpath_res_warid = $internet_warid_xpath->query('//table[2]/tr[position() mod 2 = 0]/td');

  $dbhandle = mysql_connect('localhost:3307', 'root', 'usbw') 
  or die("Unable to connect to MySQL");
  echo "Connected to MySQL<br>";

  $selected = mysql_select_db("telenorpackages",$dbhandle) 
  or die("Could not select database");

  $xpath_res_array = array();
  $rowcount = 0;

  foreach ($xpath_res_warid as $first) {
    if ($rowcount < 60){
  			$xpath_res_array[]= $first->nodeValue;
  		}

  		$rowcount++;
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
          if ($rowcount%6 ==0){

            // $arr = explode("+", $rowcontainer[1], 2);
            // $first = $arr[0];
            // $second = substr($first, 3);
            // $third = (float)$second;

            $r = mysql_query("INSERT INTO ufone_internet(package, cost, volume, validity, code) VALUES ('$rowcontainer[1]', '$rowcontainer[3]', '$rowcontainer[2]', '$rowcontainer[4]', '$rowcontainer[5]')");
            //print "Inserting into database <br>";
            // foreach ($rowcontainer as $noice) {
            // 	echo $noice . "<br>";
            // }
            // print_r($rowcontainer);
            // echo "<br>";
            $rowcontainer = array();
            $arr = array();
          }
      }
  }

  mysql_close($dbhandle);
}
?>