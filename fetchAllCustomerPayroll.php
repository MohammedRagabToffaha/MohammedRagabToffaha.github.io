	<?php
	include('gsaldb.php');


	$html="<div class='row' >"; 
	$html.="<div class='row' id='divCustinvoice'><label id='CustinvoiceLbl' style='background-color: #FBB900
	;color: #B80303;width:300px;height:30px;line-height: 27px;'>"."فواتير عملاء مستحقة التحصيل"."</label></div>"; 

	$statement = $connection->prepare("select invoiceNo,custID,orderDate,amountPaid,paidDate,amountRemain,total
	 from orders where isPaid='false'");
	$statement->execute();
	$result = $statement->fetchAll();


		$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='10%'>
		"."رقم الفاتورة"."</th><th width='20%'>اسم العميل</th><th width='12%'>تاريخ البيع</th><th width='15%'>اجمالي الفاتورة</th><th width='12%'>
		المبلغ المتبقي</th><th width='15%'>ميعاد سداد المتبقي</th><th width='8%'>معاينة</th><th width='8%'>طباعه</th></tr></thead><tbody>";

		$total=0;
	foreach($result as $row)
	{
		  

	 $btnShow= "<button type='button' name='showInvoice' id='".$row["invoiceNo"]."' class='btn btn-xs showInvoice' style='background-color:#B80303;color:white'>معاينه</button>";
	 $btnPrint= "<button type='button' name='printInvoice' id='".$row["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";
	 $payInvoice= "<button type='button' name='payInvoice' id='".$row["invoiceNo"]."' class='btn btn-xs payInvoice'>تحصيل</button>";
	
	 $statement1 = $connection->prepare("select custName from customers where custID=:custID");
	 	
	 $statement1->execute(array('custID'=>$row['custID']));
	 $result1 = $statement1->fetch();

		 $total+=intval($row["amountRemain"]);

	 $html.="<tr><td>".$row["invoiceNo"]."</td><td>".$result1["custName"]."</td><td>".$row["orderDate"]."</td><td>".number_format(intval($row["total"]))." جنيه"."</td><td>"
	 .number_format(intval($row["amountRemain"]))." جنيه"."</td><td>".$row["paidDate"]."</td><td>".$btnShow."</td><td>".$btnPrint."</td></tr>";
	}
	$html.="</tbody></table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";

$html.="<div class='row' id='divCustinvoiceTotal'><label id='CustinvoiceTotalLbl' style='background-color: #FBB900
	;color: #B80303;width:300px;height:30px;line-height: 27px;'>"."اجمالي المبلغ ".number_format($total)." جنيه"."</label></div>";
	
	$html.="</div>"; 
	echo $html;
	
	?>