<?php 

$xmlurl  = $_POST['xmlurl'];
$maxurl  = $_POST['maxurl'];
$timeout = "30";


//Get XML


$xmlResponse = file_get_contents($xmlurl,true);





$ch = curl_init(); //initiate the curl session 
curl_setopt($ch, CURLOPT_URL, $maxurl); //set to url to post to 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // tell curl to return data in a variable 
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlResponse); // post the xml 
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/xml')); 
curl_setopt($ch, CURLOPT_TIMEOUT, (int)$timeout); // set timeout in seconds 
$xmlResponse = curl_exec ($ch); 

if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}
else
{
    echo 'Operation completed without any errors';
}


echo $xmlResponse;

curl_close ($ch); 


?>