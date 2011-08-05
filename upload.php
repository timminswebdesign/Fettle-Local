<?php

session_start();


unset($_SESSION['recArray']);
unset($_SESSION['fieldCount']);
unset($_SESSION['recCount']);


if ($_FILES['userfile']['error'] > 0)
{
	echo 'Problem: ';
	switch ($_FILES['userfile']['error'])
	{
		case 1:	echo 'File too large';
		break;
		case 2:	echo 'File too large';
		break;
		case 3:	echo 'File only partially uploaded';
		break;
		case 4:	echo 'No file uploaded';
		break;
		case 6:   echo 'Cannot upload file: No temp directory specified.';
		break;
		case 7:   echo 'Upload failed: Cannot write to disk.';
		break;
	}
	exit;
}


$upfile = $_FILES['userfile']['tmp_name'];


if (($handle = fopen($upfile, "r")) !== FALSE) {

	$row = 0;

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){

		$num = count($data);
			
		for ($c=0; $c < $num; $c++) {
			$recArray[$row][$c] = htmlspecialchars($data[$c]);

		}
			
		$row++;
	}

	fclose($handle);
}



$_SESSION['recArray'] = $recArray;
$_SESSION['fieldCount'] = count($recArray[0]);
$_SESSION['recCount'] = count($recArray);

header("Location: fettle.php");

?>
