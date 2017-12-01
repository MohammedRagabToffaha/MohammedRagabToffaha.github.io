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
if (isset($_POST['csID'])&&$_POST['csID']!='') {
	# code...

	$html="<div class='row' >"; 
	$table="";

	$html.="<div class='row' id='divCustName'><label id='CustNameID' style='background-color: #B80303
	;color: #fff;width:150px;height:30px;line-height: 27px;'>".$_POST['csName']."</label></div>"; 

	$statement = $connection->prepare("select invoiceNo from orders where custID=:custID
		and orderDate between :sDate and :eDate");
	$statement->bindParam(':custID', $_POST["csID"]);
	$statement->bindParam(':sDate', $_POST["custReportSDate"]);
	$statement->bindParam(':eDate', $_POST["custReportEDate"]);
	$statement->execute();
	$result = $statement->fetchAll();
	$totalQuant=0;
	
	$output = array();

	foreach ($result as $row) {
		# code...
		$statement = $connection->prepare("select productID,sum(Quantity) as 'quant' from orderDetails
			where invoiceNo=:invoiceNo group by productID");
		$statement->bindParam(':invoiceNo', $row["invoiceNo"]);
		$statement->execute();
		$result1 = $statement->fetchAll();
		foreach ($result1 as $row1) {

			$totalQuant+=intval($row1['quant']);
		
			$statement2 = $connection->prepare("select suppID from products
			where productID=:productID");
			$statement2->bindParam(':productID', $row1["productID"]);
			$statement2->execute();
			$result2 = $statement2->fetch();

			$statement3 = $connection->prepare("select suppName from suppliers
			where suppID=:suppID");
			$statement3->bindParam(':suppID', $result2["suppID"]);
			$statement3->execute();
			$result3 = $statement3->fetch();

			
			if (array_key_exists($result3["suppName"], $output)) {
				# code...
				$output[$result3["suppName"]]=(int)($output[$result3["suppName"]])+(int)$row1['quant'];
			}else{
				$output[$result3["suppName"]]=(int)$row1['quant'];
			}

		}	

	}
	foreach ($output as $key => $value) {
		$qantit=convertTotenAndKelo((int)$value);
	 $table.="<tr><td>".$key."</td><td>".$qantit."</td></tr>";
	}
	$Totalquantity= convertTotenAndKelo((int)$totalQuant);
	$sD=date("d-m-Y",strtotime($_POST["custReportSDate"]));
	$eD=date("d-m-Y",strtotime($_POST["custReportEDate"]));

	$html.="<div class='row' id='totalCustQuantityDiv'><label id='totalCustQuantityID' style='background-color: #FBB900
	;color: #B80303;height:30px;line-height: 27px;padding-right:20px;padding-left:20px'>"."  اجمالي المنتجات المسحوبه خلال الفتره من  ".$sD."  الى  ".$eD
	."  هي  ".$Totalquantity."</label></div>"; 

	$html.="<div class='row'><div class='table-responsive' id='custTableDiv'><table style='width:50%' id='custTableID' class='table table-bordered hover'>";
	$html.=$table;
	$html.="</table></div></div>";

	$html.="<div class='row' id='custdetailsDiv'><label id='custdetailsText' style='background-color: #FBB900
	;color: #B80303;margin-top:5px;height:30px;line-height: 27px;padding-right:20px;padding-left:20px'>تفاصيل عمليات الشراء حلال تلك الفترة</label></div>";




	$statement = $connection->prepare("select invoiceNo,orderDate,invoiceType,isPaid,total
	 from orders where custID=:custID order by orderDate desc limit 50");

	$statement->bindParam(':custID', $_POST["csID"]);

	$statement->execute();
	$result = $statement->fetchAll();

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='15%'>
		"."رقم الفاتورة"."</th><th width='20%'>تاريخ الشراء</th><th width='20%'>نوع الفاتوره</th><th width='20%'>أجمالي الفاتوره</th><th width='15%'>
		تفاصيل الفاتوره</th><th width='10%'>طباعه</th></tr></thead><tbody>";

	foreach($result as $row)
	{
		
		$kind;
		if ($row["invoiceType"]=="آجل") {
			# code...
			if ($row["isPaid"]=="false") {
				# code...
				$kind="آجل"." ( لم يتم التحصيل )";
			}else{
				$kind="آجل"." ( تم التحصيل )";
			}
		}else if ($row["invoiceType"]=="حجز") {
			$kind="حجز";
		}else {
			$kind="كاش";
		}

		 $btnShow= "<button type='button' name='showInvoiceCustReport' id='".$row["invoiceNo"]."' class='btn btn-xs showInvoice' style='background-color:#B80303;color:white'>معاينه</button>";
		 $btnPrint= "<button type='button' name='printInvoice' id='".$row["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";

		 
	    $html.="<tr><td>".$row["invoiceNo"]."</td><td>".$row["orderDate"]."</td><td>".$kind."</td><td>".intval($row["total"])." جنيه"."</td><td>"
	   .$btnShow."</td><td>".$btnPrint."</td></tr>";
	}
	$html.="</tbody></table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";





	$html.="</div>"; 
	echo $html;
	//echo ($output);
}else{
	echo "error";
}

	
	?>