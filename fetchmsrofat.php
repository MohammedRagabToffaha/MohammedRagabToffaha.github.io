	<?php
	include('gsaldb.php');


	$html="<div class='row' >"; 
	$html.="<div class='row' id='divMsrofat'><label id='MsrofatLbl' style='background-color: #FD3C40
	;color: #fff;width:300px;height:30px;line-height: 27px;'>"."مصروفات مستحقة الدفع"."</label></div>"; 

	$statement = $connection->prepare("select msrofatName,msrofatDetails,msrofatAmount,memberID,addedDate
	 from msrofat where addedDate > DATE_SUB(NOW(), INTERVAL 1 MONTH) order by addedDate desc,msrofatID desc");
	
	 $statement->execute();


	$result = $statement->fetchAll();


		$html.="<div class='row'></div><div class='col-lg-12 col-md-12 col-sm-12'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #FD3C40;color: #fff'><th width='20%'>
		"."إذن صرف"."</th><th width='15%'>تاريخ الصرف</th><th width='30%'>التفاصيل</th><th width='15%'>
		المبلغ المدفوع</th><th width='20%'>مسئول الصرف</th></tr></thead><tbody>";

	foreach($result as $row)
	{
		  $statement1 = $connection->prepare("select memberOficialName
		 from members where memberID=:memberID");

		$statement1->bindParam(':memberID', $row["memberID"]);

		$statement1->execute();
		$result1 = $statement1->fetch();

		 
		 $html.="<tr><td>".$row["msrofatName"]."</td><td>".$row["addedDate"]."</td><td>".$row["msrofatDetails"]."</td><td>"
		 .number_format($row["msrofatAmount"])."</td><td>".$result1["memberOficialName"]."</td></tr>";
	}
	$html.="</tbody></table></div></div>";


	
	$html.="</div>"; 
	echo $html;
	
	?>