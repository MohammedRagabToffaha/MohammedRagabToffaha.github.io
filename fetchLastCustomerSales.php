	<?php
	include('gsaldb.php');
	session_start();
	
if (isset($_POST['custID'])&&$_POST['custID']!='') {
	# code...

	$html="<div class='row'>"; 
	
	$statement = $connection->prepare("select distinct orderDate from orders where custID=:custID and 
		invoiceType='آجل' order by orderDate desc limit 100");

	$statement->bindParam(':custID', $_POST["custID"]);

	$statement->execute();
	$result = $statement->fetchAll();

	foreach ($result as $row) {
		
		$statement1 = $connection->prepare("select invoiceNo,amountPaid,paidDate,amountRemain,totalAmountRemain,total
	 from orders where custID=:custID and invoiceType='آجل' and orderDate=:orderDate");

		$statement1->bindParam(':custID', $_POST["custID"]);
		$statement1->bindParam(':orderDate',$row['orderDate']);
		$statement1->execute();
		$result1 = $statement1->fetchAll();


		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<label style='margin-top:10px'>".$row['orderDate']."</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
		$html.="<tr style='background-color: #B80303;color: #fff'><th width='15%'>
		"."رقم الفاتورة"."</th><th width='15%'>اجمالي الفاتورة</th><th width='15%'>المبلغ المتبقي وقت الشراء</th>
		<th width='20%'>المبلغ المتبقي بعد التحصيل</th><th width='15%'>ميعاد سداد المتبقي</th>
		<th width='10%'>معاينة</th><th width='10%'>طباعه</th>";

		foreach($result1 as $row1)
		{
		
		$totalAmountRemain;
		if ($row1['totalAmountRemain']==0) {
			$totalAmountRemain="تم تحصيل كامل المبلغ";
		}else{
			$totalAmountRemain=number_format($row1['totalAmountRemain'])." جنيه";
		}

		 $btnShow= "<button type='button' name='showInvoice' id='".$row1["invoiceNo"]."' class='btn btn-xs showInvoice' style='background-color:#B80303;color:white'>معاينه</button>";
		 $btnPrint= "<button type='button' name='printInvoice' id='".$row1["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";
			
		$html.="<tr><td>".$row1["invoiceNo"]."</td><td>".number_format($row1["total"])." جنيه</td><td>"
		.number_format($row1["amountRemain"])." جنيه</td><td>".$totalAmountRemain."</td><td>".$row1['paidDate']."</td><td>".$btnShow
		."</td><td>".$btnPrint."</td></tr>";
		}

		$html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";


	}



	$html.="</div>"; 
	echo $html;
}else{
	echo "error";
}

	
	?>