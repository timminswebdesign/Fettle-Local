<?php
session_start();
$recArray = $_SESSION['recArray'];
$fieldCount = $_SESSION['fieldCount'];
$recCount = $_SESSION['recCount'];

include_once('header.inc');
?>



<div class="row">
<div class="column grid_12">



<div class='tblPreviewTog btnTog'>Preview Data: (Click to toggle)</div>

<div class='tblPreview'>
<table>


	<tr class='trTitle'>



	<?php

	for($t=0; $t<$fieldCount; $t++){

		echo "<td>".$recArray[0][$t]."</td>";

	}

	echo "</tr>";

	//Preview Data Table Body

	for($i=1; $i<$recCount; $i++){

		echo "<tr class=\"dr\" id=\"dr".$i."\">";

		for($r=0; $r<$fieldCount; $r++){

			echo "<td class=\"dd".$r."\">".$recArray[$i][$r]."</td>";

		}

		echo "</tr>";

	}

	?>

</table>
</div>
</br>
</div>
</div>



<div class="row valError">

<div class="column grid_12">
<div class='btnTog'>Validation Errors:</div>
<textarea id="txtError" rows="10" cols="204"></textarea></div>

</div>


<form id="optionForm" action="generateXML.php" method="post"
	accept-charset="utf-8">
<div class="row">
<div class="column grid_12">


<div class='btnTog'>Mapping Data:

<div style="float:right">Validate Against <input id="vMax7" type="radio" name="vMax" checked />
<label for="vMax7">Maximo 7</label>
 <input id="vMax6" type="radio" name="vMax"/>
<label for="vMax6">Maximo 6</label>
 <input id="vMaxO" type="radio" name="vMax"/>
<label for="vMaxO">Oracle Database</label>
</div>
</div>




<table class='tblMap'>

	<tr class="trTitle">
		<td>Valid</td>
		<td>Owner Table</td>
		<td>Original Name</td>
		<td>New Name</td>
		<td>Data Type</td>
		<td>Length</td>
		<td>Required</td>
		<td>Enabled?</td>
		<td>Is GL?</td>
	</tr>

	<?php
	for($t=0; $t<$fieldCount; $t++){

		echo "<tr class='fieldRow'>";
		echo "<td><div class=\"valImg\" id=\"fnvi".$t."\"> </div></td>";
		echo "<td><input class='owntbl' name=\"owntbl".$t."\" type=\"text\"/> </td>";
		echo "<td><span class='fno' name=\"fno".$t."\">".$recArray[0][$t]."</span><input name=\"fnv".$t."\" type=\"hidden\" />"."</td>";

		echo "<td><input class='fn' name=\"fn".$t."\" type=\"text\" /> </td>";
		echo "<td><input class='fdt' name=\"fdt".$t."\" readonly=\"readonly\" type=\"readonly\"/> </td>";
		echo "<td><input class='flen' name=\"flen".$t."\" readonly=\"readonly\" type=\"readonly\"/> </td>";
		echo "<td><input class='fr' name=\"fr".$t."\"  type=\"checkbox\" DISABLED /> </td>";
		echo "<td><input class='fne' name=\"fne".$t."\"  type=\"checkbox\" checked/> </td>";
		echo "<td><input class='fngl' name=\"fngl".$t."\"  type=\"checkbox\" /> </td>";
		echo "</tr>";

	}

	?>

</table>

</div>
</div>
<div class="row">

<div class="column grid_3">
<div id="btnVal">Validate</div>
<div id="btnValData">Validate Data</div>

</div>

<div class="column grid_5"><label for="defOwner">Default Owner Table:</label>
<input name="defOwner" id="defOwner" class='owntbl required' type="text" /></div>

<div class="column grid_4">
<div id="btnEa">Enable All</div>
<div id="btnDa">Disable All</div>
<div id="btnIv">Invert</div>

</div>
</div>

<div class="row">
<div class="column grid_8"><select id="opPrevMap">
	<option value="0">Select...</option>


	<?php

	include_once('dbconnect.inc');

	$query = "select templateid, name from mappings group by templateid order by templateid";

	$results = $db->query($query);

	while ($row = $results->fetch_assoc()) {
		echo '<option value="'.$row["templateid"].'">'.$row["name"].'</option>';
	}

	$results->close();

	$db->close();


	?>

</select>
<div id="btnLm">Load Mappings</div>
<div id="btnSm">Save Changes</div>
<div id="btnSma">Save As..</div>

</div>



</div>


<div class="row">
<div class="column grid_12">
<div class='btnTog'>XML File Options:</div>
<table class="tblXMLop">
	<tr class="trTitle">
		<td>File Name Prefix</td>

		<td>Split File?</td>

		<td>Split Amount</td>
		<td>Remove Null Tags?</td>
	</tr>
	<tr>
		<td><input name="opfn" type="text" class="required" /></td>
		<td><input name="opse" type="checkbox" /></td>
		<td><input name="opsn" type="text" /></td>
		<td><input name="oprnt" type="checkbox" /></td>
	</tr>
</table>
</div>
</div>

<div class="row">
<div class="column grid_4">
<div class='btnTog'>Operation</div>
<div><input type="radio" name="mOp" value="Add" /> Add <br />
<input type="radio" name="mOp" value="AddChange" checked /> Add Change <br />
<input type="radio" name="mOp" value="Delete" /> Delete <br />
</div>
</div>

<div class="column grid_4">


<div class='btnTog'>Maximo Version</div>

<input id="mVer6" type="radio" name="mVer" value="6" checked /> Maximo
v6 <br />
<input id="mVer7" type="radio" name="mVer" value="7" /> Maximo v7 <br />
<br />
</td>

</div>


<div class="column grid_4">
<div id='m6'>
<div class='btnTog'>Maximo 6 Properties</div>

Integration Object:<input id="m6IntObj" name="m6IntObj" type="text"
	class="required" /><br />

Inbound Interface:<input id="m6InInt" name="m6InInt" type="text"
	class="required" /><br />

External System:<input id="m6ExtSys" name="m6ExtSys" type="text"
	class="required" /><br />


</div>



<div id='m7'>
<div class='btnTog'>Maximo 7 Properties</div>

Object Structure:<input id="mObjStruct" name="mObjStruct" type="text" /><br />

Enterprise Service:<input id="mPubChan" name="mPubChan" type="text" /><br />




</div>
</div>


</div>

<div class="row">
<div class="column grid_12 nav">
<div id="btnContinue" class="submit">Continue</div>
<div id="btnBack">Back</div>


</div>
</div>
</form>


<div title="Save Mapping as..." id="msgSaveMapping"><label
	for="templatename">Template Name</label> <input type="text"
	id="templatename" /></div>


	<?php

	include_once('footer.inc');

	?>