	<?php
	include('gsaldb.php');
	
if (isset($_POST['custID'])&&$_POST['custID']!='') {
	
$html="<div class='row' >";
	$statement7 = $connection->prepare("select distinct deliverdDate from customerDeliverdAsMony where custID=:custID 
		order by dasID desc limit 100");

	$statement7->bindParam(':custID', $_POST["custID"]);
	
	$statement7->execute();
	$result7 = $statement7->fetchAll();
	foreach($result7 as $row)
	{

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<label style='margin-top:10px'>".$row['deliverdDate']."</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

		$statement4 = $connection->prepare("select * from customerDeliverdAsMony where custID=:custID and 
			deliverdDate=:deliverdDate order by dasID desc");

		$statement4->bindParam(':custID', $_POST["custID"]);
		$statement4->bindParam(':deliverdDate', $row['deliverdDate']);

		$statement4->execute();
		$result4 = $statement4->fetchAll();

		foreach($result4 as $row4){

			$final=$row4['lastRemain']-$row4['deliverdAmount'];

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
			$html.="<div class='table-responsive'><table style='width:100%;background-color: #F5F5F5
		;height:30px;line-height: 22px;padding-right:20px;padding-left:20px' class='table table-bordered hover'>";
			
		$html.="<tr style='height:10px'><th width='40%'>
		<label>متبقي له ســــابقا ".number_format($row4['lastRemain'])." جنيه"."</label></th><th width='30%'><label>سحب مبلغ وقدره ".number_format($row4['deliverdAmount'])." جنيه</label></th>
		<th width='30%'><label>متبقي بعد السحب ".number_format($final)." جنيه </label></th>";

		$html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";


		}

	}


	$html.="</div>"; 
	echo $html;
}else{
	echo "error";
}

	
	?>