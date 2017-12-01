	<?php
	include('gsaldb.php');

	$html="<div class='row' >"; 
	$html.="<div class='col-md-1'></div>";
	$html.="<div class='col-md-5'>";
	$html.="<div class='row' id='divmoredName'><label id='moredNameID' style='background-color: #B80303
	;color: #fff;width:300px;height:30px;line-height: 27px;'>"."المبالغ المتبقيه للوكلاء"."</label></div>"; 

	$statement = $connection->prepare("select mordName,totalAmountRemain from elmordeen where totalAmountRemain > 0");
	
	$statement->execute();
	$result = $statement->fetchAll();
	
	$html.="<div class='row'><div class='table-responsive' id='mordeenTableDiv'><table style='width:100%' id='mordeenTableID' class='table table-bordered hover'>";
	$total=0;
	foreach ($result as $row) {
		# code...
		$total+=($row['totalAmountRemain']);
		$html.="<tr><td>".$row['mordName']."</td><td>".number_format(($row['totalAmountRemain']))." جنيه"."</td></tr>";	

	}
	
$html.="<tr style='background-color:#B80303;color:#fff'><td colspan='2'> إجمالي المبالغ المتبقيه للوكلاء (( ".number_format($total)." جنيه  ))"."</td></tr>";	
	
	$html.="</table></div></div>";
	$html.="</div>"; 
	$html.="<div class='col-md-1'></div>";

	$html.="<div class='col-md-5'>";
	$html.="<div class='row' id='divmoredName'><label id='moredNameID' style='background-color: #B80303
	;color: #fff;width:300px;height:30px;line-height: 27px;'>"."المبالغ المتبقيه على الوكلاء"."</label></div>"; 

	$statement = $connection->prepare("select mordName,totalAmountRemain from elmordeen where totalAmountRemain < 0");
	
	$statement->execute();
	$result = $statement->fetchAll();
	
	$html.="<div class='row'><div class='table-responsive' id='mordeenTableDiv'><table style='width:100%' id='mordeenTableID' class='table table-bordered hover'>";
	$totalPlus=0;
	foreach ($result as $row) {
		# code...
		$totalPlus+=($row['totalAmountRemain']);
		$html.="<tr><td>".$row['mordName']."</td><td>".number_format(abs($row['totalAmountRemain']))." جنيه"."</td></tr>";	

	}
	
$html.="<tr style='background-color:#B80303;color:#fff'><td colspan='2'> إجمالي المبالغ المتبقيه على الوكلاء (( ".number_format(abs($totalPlus))." جنيه  ))"."</td></tr>";	
	
	$html.="</table></div></div>";
	$html.="</div>";
	$html.="<div class='col-md-1'></div>"; 


	$html.="</div>"; 
	echo $html;



	
	?>