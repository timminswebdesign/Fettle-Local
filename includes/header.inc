<?php

$page = $_SERVER["PHP_SELF"];
$title = 'Vetasi Ltd ';
switch ($page){

	case '/index.php':
		$title.= '| Maximo CSV Loader | Choose a CSV File to Upload';
		break;

	case '/upload.php':
		$title.= '| Maximo CSV Loader | Validation and Configuration';
		break;

}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="Website Description" />
<link rel="stylesheet" href="css/grid.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="Stylesheet" href="css/jquery-ui-1.8.12.custom.css"
	type="text/css" />
<script type="text/javascript" src="script/jquery-1.6.min.js">
        </script>
<script type="text/javascript"
	src="script/jquery-ui-1.8.12.custom.min.js">
        </script>
        <script type="text/javascript" src="script/jquery.validateMyForm.1.5.min.js">
        </script>
<script type="text/javascript" src="script/autocomplete.js"></script>
<script type="text/javascript" src="script/script.js">
        </script>
<script type="text/javascript" src="script/validate.js"></script>
<script type="text/javascript" src="script/mappings.js"></script>
<script type="text/javascript" src="script/post.js"></script>




<title><?php echo $title;?></title>
</head>
<body>

<div id="infoBar">
<div id="infoCont">
<div id="infoImg"></div>
<div id="infoMsg"></div>
</div>
</div>

<div class="wrapper">
<div class="row">
<div class="grid_12 header"></div>

</div>