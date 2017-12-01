	<?php
	include('gsaldb.php');
	function convertTotenAndKelo($value){
			 $stockAfter;
			 $stockBefore=$value;
			 if ($stockBefore >= 1000) {
			 	$kelo=$stockBefore%1000;
			 	$ten=($stockBefore-$kelo)/1000;

			 	if ($kelo==0) {
			 		$stockAfter=$ten." طن";
			 	}else{
			 		$stockAfter=$ten." طن" ." و ".$kelo." كيلو";
			 	}

			 }else{
			 	$stockAfter=$stockBefore." كيلو";
			 }
			 return $stockAfter;
	}
if (isset($_POST['SelectMoredForReport'])&&$_POST['SelectMoredForReport']!='') {
	# code...

	$html="<div class='row' >"; 
	$html.="<div class='row' id='divCompName'><label id='companyName' style='background-color: #B80303
	;color: #fff;width:150px;height:30px;line-height: 27px;'>".$_POST['SelectMoredTextForReport']."</label></div>"; 

	$statement = $connection->prepare("select sum(quantity) as 'Totalquantity' from Tlbyat where mordID=:mordID
		and addedDate between :sDate and :eDate");
	$statement->bindParam(':mordID', $_POST["SelectMoredForReport"]);
	$statement->bindParam(':sDate', $_POST["suppReportSDate"]);
	$statement->bindParam(':eDate', $_POST["suppReportEDate"]);
	$statement->execute();
	$result = $statement->fetch();
	$Totalquantity= convertTotenAndKelo((int)$result["Totalquantity"]);
	$sD=date("d-m-Y",strtotime($_POST["suppReportSDate"]));
	$eD=date("d-m-Y",strtotime($_POST["suppReportEDate"]));

	$html.="<div class='row' id='totalQuantityDiv'><label id='totalQuantity' style='background-color: #FBB900
	;color: #B80303;height:30px;line-height: 27px;padding-right:20px;padding-left:20px'>"."  اجمالي المنتجات المسحوبه خلال الفتره من  ".$sD."  الى  ".$eD
	."  هي  ".$Totalquantity."</label></div>";


	//show total mony
	$statement = $connection->prepare("select quantity,UnitCostPrice from Tlbyat where mordID=:mordID
		and addedDate between :sDate and :eDate");
	$statement->bindParam(':mordID', $_POST["SelectMoredForReport"]);
	$statement->bindParam(':sDate', $_POST["suppReportSDate"]);
	$statement->bindParam(':eDate', $_POST["suppReportEDate"]);
	$statement->execute();
	$result = $statement->fetchAll();

	$totalMony=0;
	foreach ($result as $row) {
	 	# code...
	 	$totalMony+=($row['quantity']*$row['UnitCostPrice'])/1000;
	 } 
////////////////////////////////////////////

	$statement = $connection->prepare("select sum(quantity) as 'SupTotalquantity',suppID from Tlbyat 
		where mordID=:mordID
		and addedDate between :sDate and :eDate group by suppID");
	$statement->bindParam(':mordID', $_POST["SelectMoredForReport"]);
	$statement->bindParam(':sDate', $_POST["suppReportSDate"]);
	$statement->bindParam(':eDate', $_POST["suppReportEDate"]);
	$statement->execute();
	$result = $statement->fetchAll();

	$html.="<div class='row'><div class='table-responsive' id='alltableDiv'><table style='width:50%' id='alltable' class='table table-bordered hover'>";

	foreach($result as $row)
	{

		$statement = $connection->prepare("select suppName from suppliers where suppID=:suppID");
		$statement->bindParam(':suppID',$row["suppID"]);
		$statement->execute();
		$result = $statement->fetch();

		$stockAfter=convertTotenAndKelo((int)$row["SupTotalquantity"]);
		$html.="<tr><td>".$result["suppName"]."</td><td>".$stockAfter."</td></tr>";
		
	}
	$html.="<tr style='background-color:#B80303;color:#fff'><td colspan='2'> باجمالي مبلغ  ((  ".number_format($totalMony)." جنيه  ))</td></tr>";
	$html.="</table></div></div>";

	$html.="<div class='row' id='detailsDiv'><label id='detailsText' style='background-color: #FBB900
	;color: #B80303;margin-top:5px;height:30px;line-height: 27px;padding-right:20px;padding-left:20px'>تفاصيل عمليات الشراء</label></div>";


	$statement = $connection->prepare("select distinct addedDate from Tlbyat 
		where mordID=:mordID
		and addedDate between :sDate and :eDate order by addedDate desc");
	$statement->bindParam(':mordID', $_POST["SelectMoredForReport"]);
	$statement->bindParam(':sDate', $_POST["suppReportSDate"]);
	$statement->bindParam(':eDate', $_POST["suppReportEDate"]);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		//$inD=date("d-m-Y",strtotime($row['addedDate']);



		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<label style='margin-top:10px'>".$row['addedDate']."</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
		$html.="<tr style='background-color: #B80303;color: #fff'><th width='45%' colspan='3'>
		"."الصنف"."</th><th width='20%'>الكميه</th><th width='15%'>سعر الطن</th><th width='20%'>التكلفة</th>";
		
		$statement1 = $connection->prepare("select * from Tlbyat 
		where mordID=:mordID and addedDate=:addedDate");
		
		$statement1->bindParam(':mordID', $_POST["SelectMoredForReport"]);
		$statement1->bindParam(':addedDate',$row['addedDate']);
		$statement1->execute();
		$result1 = $statement1->fetchAll();
		foreach($result1 as $row1)
		{
			$statement2 = $connection->prepare("select suppName from suppliers 
			where suppID=:suppID ");
			$statement2->bindParam(':suppID', $row1["suppID"]);
			$statement2->execute();
			$result2 = $statement2->fetch();

			$statement3 = $connection->prepare("select catName from categories 
			where catID=:catID ");
			$statement3->bindParam(':catID', $row1["catID"]);
			$statement3->execute();
			$result3 = $statement3->fetch();

			$statement4 = $connection->prepare("select measName from measures 
			where measID=:measID ");
			$statement4->bindParam(':measID', $row1["measID"]);
			$statement4->execute();
			$result4 = $statement4->fetch();

			$qAfter=convertTotenAndKelo((int)$row1["quantity"]);
			$cost=number_format(($row1["UnitCostPrice"]*$row1["quantity"])/1000)." جنيه ";

			$html.="<tr><td width='15%'>".$result2["suppName"]."</td><td width='15%'>".$result3["catName"]."</td><td width='15%'>"
			.$result4["measName"]."</td><td width='20%'>".$qAfter."</td><td width='15%'>".number_format($row1["UnitCostPrice"])." جنيه"
			."</td><td width='20%'>".$cost."</td></tr>";
		}

		$html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
	}


	$statement = $connection->prepare("select * from deposits where mordID=:mordID order by depositID desc");
	$statement->bindParam(':mordID', $_POST["SelectMoredForReport"]);
	$statement->execute();
	$result = $statement->fetchAll();

	$html.="<div class='row' id='depositDiv'><label id='depositText' style='background-color: #FBB900
	;color: #B80303;margin-top:15px;height:30px;line-height: 27px;padding-right:20px;padding-left:20px'>تفاصيل عمليات الايداع</label></div>";


		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
		$html.="<tr style='background-color: #B80303;color: #fff'><th width='25%'>
		"."التاريخ"."</th><th width='25%'>المبلغ المستحق قبل الايداع</th><th width='25%'>ايداع مبلغ</th><th width='25%'>المبلغ المستحق بعد الايداع</th>";

	foreach($result as $row)
	{
		  
		  $mordID=$row["mordID"];
	 	  $statement = $connection->prepare("select mordName,totalAmountRemain from elmordeen where mordID=:mordID");
	 	  $statement->bindParam(':mordID', $mordID);
		  $statement->execute();
		  $result = $statement->fetch();
		
	    
	     $last=$row["lastAmountRemain"];
	     $amountPaid=$row["depositAmount"];
	     $after=$last-$amountPaid;

	     $l = number_format($last)." جنيه";
	     $m = number_format($amountPaid)." جنيه";
	     $a = number_format($after)." جنيه";

	     $d = $row["depositDate"];
		 
		 $html.="<tr><td>".$d."</td><td>".$l."</td><td>".$m."</td><td>".$a."</td></tr>";
	}
	$html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";



	$html.="</div>"; 
	echo $html;
}else{
	echo "error";
}

	
	?>