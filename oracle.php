<?php 



try {
$c = oci_connect('maximo', 'maximo', '192.168.0.136/maximo');
} 
catch (PDOException $e) {

trigger_error("Could not connect to database: ". $e->getMessage(), E_USER_ERROR);
}

 $s = oci_parse($c, "select * from workorder");
   oci_execute($s, OCI_DEFAULT);
   echo oci_num_rows($s);
   while (oci_fetch($s)) {
     echo oci_result($s, "WONUM") .
        "," . oci_result($s, "STATUS") . "<br>\n";
   }



?>