<?php
session_start();

include_once('header.inc');

?>
<div class="row">

<div class="column grid_12">


<div id="btnBack">Back</div>


</div>

</div>

<div class="row"><div class="column grid_4"><fieldset>
<legend>Download Files</legend>

<?php

//Functions


function fnGLformat($gl){

	$sgl = "\n\t\t\t<VALUE>".$gl."</VALUE>";

	$gl = explode('-',$gl);

	$glc = count($gl);

	for($a=0; $a < $glc; $a++){

			
		if(strpos($gl[$a],"?") !== false ){


		}else{

			$sgl = $sgl."\n\t\t\t<GLCOMP glorder=\"".$a."\">".$gl[$a]."</GLCOMP>";

		}

	}

	return $sgl;

}

function compare($x, $y) {
	if ($x[1] == $y[1]) {
		return 0;
	} else if ($x[1] < $y[1]){
		return -1;
	} else {
		return 1;
	}
}


$recArray =  $_SESSION['recArray'];
$mVer = $_POST['mVer'];
$mOp  = $_POST['mOp'];
$defOwner = $_POST['defOwner'];

//Maximo 7

$mPubChan = $_POST['mPubChan'];
$mObjStruct = $_POST['mObjStruct'];



//Maximo 6

$m6IntObj = $_POST['m6IntObj'];
$m6InInt = $_POST['m6InInt'];
$m6ExtSys = $_POST['m6ExtSys'];

//File Options

$opfn = $_POST['opfn'];
$opsn = $_POST['opsn'];
$oprnt = $_POST['oprnt'];
$recCount = $_SESSION['recCount'];
$fieldCount = $_SESSION['fieldCount'];
$XMLcontent = "";
$enFields;
$enFieldsID =0;
$glFields;
$glFieldsID =0;


for($n=0; $n < $fieldCount; $n++){

	//Change Field Names
	$fname = "fn".$n;

	if ($_POST[$fname] !== ""){
			
		$recArray[0][$n] = $_POST[$fname];
			
	}


	//Populate Enabled Array
	$fname = "fne".$n;

	if ($_POST[$fname] == "on"){
			
		$enFields[$enFieldsID][0] = $n;


		$fname = "owntbl".$n;

		if ($_POST[$fname] !== ""){

			$enFields[$enFieldsID][1] = $_POST[$fname];

		}else{

			$enFields[$enFieldsID][1] = $defOwner;

		}



		$enFieldsID++;
			
	}




	//Populate GL Accounts
	$fname = "fngl".$n;

	if ($_POST[$fname] == "on"){
			
		$glFields[$glFieldsID] = $n;

		$glFieldsID++;
			
	}




}

$fieldCount =count($enFields);
$glCount =count($glFields);

//Sort Enables Fields Array



usort($enFields, 'compare');

//Create 6 Script

$XML6header = "<?xml version=\"1.0\"?>\n"
."<".$m6InInt." xmlns=\"http://www.mro.com/mx/integration\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" language=\"EN\">\n"
."<Header operation=\"Notify\" event=\"0\">\n"
."<SenderID type=\"MAXIMO\">".$m6ExtSys."</SenderID>\n"
."<CreationDateTime>2010-12-02T10:46:59+00:00</CreationDateTime>\n"
."<RecipientID>MX</RecipientID>\n"
."<MessageID>12345678901240514</MessageID>\n"
."</Header>\n"
."<Content>\n";

$XML6footer = "</Content>\n"
."</".$m6InInt.">";



//Create 7 Script

$XML7header  ='<?xml version="1.0"?><Sync'.$mObjStruct.' creationDateTime="2010-11-23T11:39:17+00:00" transLanguage="EN" baseLanguage="EN" event="0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.ibm.com/maximo">'.
				'<'.$mObjStruct.'Set>';			
$XML7footer='</'.$mObjStruct.'Set>'.'</Sync'.$mObjStruct.'>';






//Create Content




$fileNo=0;
$rStart = 1;
$rEnd=1;
$loading = true;
$files;

while($loading == true){

	$fileNo++;
	$XMLcontent=" ";

	if($_POST['opse'] == "on"){

		$rEnd = $rStart + $opsn;


		if($rEnd >= $recCount ){


			$rEnd = $recCount;
			$loading = false;

		}
	}else{
			
			
		$rEnd = $recCount;
		$loading = false;
	}




	for($i=$rStart; $i<$rEnd; $i++){


		for($s=0; $s<$glCount; $s++){


			$recArray[$i][$glFields[$s]] = fnGLformat($recArray[$i][$glFields[$s]]);

		}

		
	if($mVer == '7'){

	$XMLcontent.=	"<".$defOwner." action=\"".$mOp."\">\n";
		

	}else{

		$XMLcontent.= "<".$m6IntObj.">\n\t";
		$XMLcontent.=	"<".$defOwner." action=\"".$mOp."\">\n";

	}
		
		


		for($r=0; $r<$fieldCount; $r++){

			
			//Remove Tag if Null Value
			if($oprnt == "on" && $recArray[$i][$enFields[$r][0]] == ""){
				
				
				
			}else{
				
			if($defOwner !== $enFields[$r][1]){
					
					
				if($enFields[$r][1] !== $enFields[$r-1][1]){

					$XMLcontent.= "\t<".$enFields[$r][1].">\n";

				}
					
					
					
				$XMLcontent.="\t\t<".$recArray[0][$enFields[$r][0]].">".$recArray[$i][$enFields[$r][0]]. "</".$recArray[0][$enFields[$r][0]].">\n";
					
					
				if($enFields[$r][1] !== $enFields[$r+1][1]){

					$XMLcontent.= "\t</".$enFields[$r][1].">\n";

				}
					
					
					
					
			}else{

				//Format Fields
				$XMLcontent.="\t\t<".$recArray[0][$enFields[$r][0]].">".$recArray[$i][$enFields[$r][0]]. "</".$recArray[0][$enFields[$r][0]].">\n";

			}
			
			
		}
			$rStart=$i+1;
		}

		
		if($mVer == '7'){

$XMLcontent.= "\t</".$defOwner.">\n";
		

	}else{

		$XMLcontent.= "\t</".$defOwner.">\n</".$m6IntObj.">\n";

	}
		
		


	}

	//Form Output

	if($mVer == '7'){

		$XMLoutput =  $XML7header.$XMLcontent.$XML7footer;

	}else{

		$XMLoutput =  $XML6header.$XMLcontent.$XML6footer;

	}



	//Write Output File

	$DOCUMENT_ROOT =  './XML/'.$opfn.$fileNo.".xml";
	$files[$fileNo] = $opfn.$fileNo.".xml";

	$fp = fopen($DOCUMENT_ROOT, 'w');


	if(!$fp){


		echo "Error Has Occured";

	}

	fwrite($fp, $XMLoutput);


	fclose($fp);



	//Create Download Link PHP

	$PHPoutput=	'<?php '
	.'header(\'Content-disposition: attachment; filename='.$opfn.$fileNo.'.xml\');'
	.'header(\'Content-type: text/xml\');'
	.'readfile(\'.'.$DOCUMENT_ROOT.'\');'
	.'?>';



	$DOCUMENT_ROOT =  './PHP/'.$opfn.$fileNo.".php";
	$fd = fopen($DOCUMENT_ROOT, 'w');

	if(!$fd){
			
			
		echo "Error Has Occured";
			
	}

	fwrite($fd, $PHPoutput);


	fclose($fd);





	echo '<div> <div class="btnDownload">'.$opfn.$fileNo.'.xml<a href="'.'./PHP/'.$opfn.$fileNo.".php".'">'.'</a></div></div>';
}



$zip = new ZipArchive();
$DOCUMENT_ROOT = './ZIP/'.$opfn.'.zip';
$zip->open($DOCUMENT_ROOT, ZipArchive::OVERWRITE);
foreach ($files as $file) {
	$zip->addFile( './XML/'.$file,$file);
}
$zip->close();


//Create Download Link PHP

$PHPoutput=	'<?php '
.'header(\'Content-disposition: attachment; filename='.$opfn.'.zip\');'
.'header(\'Content-type: application/zip\');'
.'readfile(\'.'.$DOCUMENT_ROOT.'\');'
.'?>';



$DOCUMENT_ROOT =  './PHP/'.$opfn.".php";
$fd = fopen($DOCUMENT_ROOT, 'w');

if(!$fd){


	echo "Error Has Occured";

}

fwrite($fd, $PHPoutput);


fclose($fd);


echo '</fieldset></div><div class="column grid_4">
<fieldset><legend>Download Archive</legend><div> <div class="btnDownloadArc">'.$opfn.'.zip <a href="'.'./PHP/'.$opfn.".php".'">'.'</a></div></div>';


//Write Text Area

?>
</fieldset>
</div>
<div class="column grid_4">
<fieldset><legend>Post To Server</legend>
<div class="postField"><label for="postLoc">Server Address:</label> <input
	id="postLoc" type="text" /></div>
<div class="postField"><label for="postLoc">Post Delay (Minutes):</label>
<input id="postDelay" type="text" /></div>
<div class="postField">


<div id="btnPost">Post To Server</div>
</div>
</fieldset>
</div>
</div>




<div title="Post Status" id="msgPostStat"></div>


<?php



include_once('footer.inc');
?>
