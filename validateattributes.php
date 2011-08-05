<?php
header("Content-type: text/xml");
 echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n"; 
 echo "<rows>\n"; 
 

try {
$c = oci_connect('maximo', 'maximo', '192.168.0.136/maximo');
} 
catch (PDOException $e) {

trigger_error("Could not connect to database: ". $e->getMessage(), E_USER_ERROR);
}


$attr = $_POST['attributename'];
$obj = $_POST['objectname'];

$query = oci_parse($c, "select * from maxattribute where attributename = '".$attr."' and objectname = '".$obj."'");
	
oci_execute($query, OCI_DEFAULT);



$row_cnt = 0;

while (oci_fetch($query)) {
	echo '<row>
			<valid>true</valid>
			<length>'.oci_result($query, "LENGTH").'</length>
			<maxtype>'.oci_result($query, "MAXTYPE").'</maxtype>
			<required>'.oci_result($query, "REQUIRED").'</required>
		 </row>';
	$row_cnt++;
   }
   
if ($row_cnt <1){
		echo '<row>
			<valid>false</valid>
		</row>';
	
}
   


	



oci_close($c);

?>

</rows>