	<?php
	include('gsaldb.php');
	session_start();
	
if (isset($_POST['custID'])&&$_POST['custID']!='') {
	
$html="<div class='row' >";
	$statement7 = $connection->prepare("select distinct paidDate from customerspaidMony where custID=:custID
	and remainFromLast=0 order by customerspaidMonyID desc limit 100");

	$statement7->bindParam(':custID', $_POST["custID"]);
	
	$statement7->execute();
	$result7 = $statement7->fetchAll();
	foreach($result7 as $row)
	{

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<label style='margin-top:10px'>".$row['paidDate']."</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

		$statement4 = $connection->prepare("select * from customerspaidMony where custID=:custID and paidDate=:paidDate
		 and remainFromLast=0 order by customerspaidMonyID desc");

		$statement4->bindParam(':custID', $_POST["custID"]);
		$statement4->bindParam(':paidDate', $row['paidDate']);

		$statement4->execute();
		$result4 = $statement4->fetchAll();

		foreach($result4 as $row4){

			$final7sab=$row4['totalFromLast']+$row4['customerspaidMonyAmount'];

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
			$html.="<div class='table-responsive'><table style='width:100%;background-color: #F5F5F5
		;height:30px;line-height: 22px;padding-right:20px;padding-left:20px' class='table table-bordered hover'>";
			
		$html.="<tr style='height:10px'><th width='40%'>
		<label>فوق الحساب ســــابقا ".number_format($row4['totalFromLast'])." جنيه"."</label></th><th width='30%'><label>اضافة مبلغ وقدره ".number_format($row4['customerspaidMonyAmount'])." جنيه</label></th>
		<th width='30%'><label>الاجمالي بعد الاضافه ".number_format($final7sab)." جنيه </label></th>";

		$html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";


		}

	}


	$html.="</div>"; 
	echo $html;
}else{
	echo "error";
}

	
	?>