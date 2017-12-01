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
	if (isset($_POST['DailyReportDate'])&&$_POST['DailyReportDate']!='') {
		$html="<div class='row' >"; 
//show mby3at cach
	$html.="<div class='row' id='mby3atCachDiv'><label id='mby3atCachLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مبيعات كاش</label></div>";
	
	$statement= $connection->prepare("select * from orders 
		where orderDate=:orderDate and invoiceType='كاش'");
	$statement->bindParam(':orderDate', $_POST["DailyReportDate"]);
	$statement->execute();
	$result= $statement->fetchAll();

	$cachTotalMony=0;
	if ($statement->rowCount() > 0) {
		

	$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='15%'>
	"."رقم الفاتورة"."</th><th width='25%'>اسم العميل</th><th width='15%'>اجمالي الفاتوره</th><th width='15%'>معاينه</th>
	<th width='15%'>طباعه</th><th width='15%'>ارجاع</th>";

	
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $cachTotalMony+=intval($row["total"]);

	 $showInvoice = '<button type="button" name="showInvoice" id="'.$row["invoiceNo"].'" class="btn btn-success btn-xs showInvoice"><i class="fa fa-eye fa-fw"></i>معاينه</button>';
	 $printInvoice = '<button type="button" name="printInvoice" id="'.$row["invoiceNo"].'" class="btn btn-info btn-xs printInvoice"><i class="fa fa-print fa-fw"></i>طباعة</button>';
	 $erga3 = '<button type="button" name="erga3" id="'.$row["invoiceNo"].'" class="btn btn-danger btn-xs erga3"><i class="fa fa-arrow-left fa-fw"></i>إرجاع</button>';
		
	$html.="<tr><td width='15%'>".$row["invoiceNo"]."</td><td width='25%'>".$custName."</td><td width='15%'>"
	.number_format($row["total"])." جنيه</td><td width='15%'>".$showInvoice."</td><td width='15%'>".$printInvoice.
	"</td><td width='15%'>".$erga3."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>باجمالي مبلغ  ((  ".number_format($cachTotalMony)." جنيه  ))</label></td></tr>";

		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
	}else{
		$html.="<div id='totalAmountDRDiv'><label style='margin-bottom: 10px;' id='totalAmountDRLbl'>لا يوجد مبيعات كاش</label></div>";
	}

//end mby3at cach

	//show mby3at rebth
	$html.="<div class='row' id='mby3atRebtaDiv'><label id='mby3atRebtaLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مبيعات ربطه للخرده</label></div>";
	
	$statement= $connection->prepare("select * from rbth 
		where arbtaDate=:orderDate");
	$statement->bindParam(':orderDate', $_POST["DailyReportDate"]);
	$statement->execute();
	$result= $statement->fetchAll();

	$rebtaTotalMony=0;
	if ($statement->rowCount() > 0) {
		

	$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th>
	"."اسم المشتري"."</th><th>الوزنه بالكيلو</th><th>سعر البيع للكيلو</th><th>أجمالي</th>";

	
		foreach($result as $row)
		{
			$totalCost=$row["arbtaQuantity"]*$row["arbtaUnitCost"];
			$rebtaTotalMony+=$totalCost;

	        $totalCost=number_format($totalCost)." جنية";
		 
		    $html.="<tr><td>".$row["arbtaCustName"]."</td><td>".$row["arbtaQuantity"]." كيلو</td><td>"
				.$row["arbtaUnitCost"]." جنيه</td><td>".$totalCost."</td></tr>";
 
	        
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>باجمالي مبلغ  ((  ".number_format($rebtaTotalMony)." جنيه  ))</label></td></tr>";

		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
	}else{
		$html.="<div id='totalAmountRebtaDiv'><label style='margin-bottom: 10px;' id='totalAmountRebtaLbl'>لا يوجد بيع ربطه</label></div>";
	}

//end mby3at rebta


//show mby3at agel
		$html.="<div class='row' id='mby3atAgelDiv'><label id='mby3atAgelLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مبيعات اجل</label></div>";

		$statement= $connection->prepare("select * from orders 
		where orderDate=:orderDate and invoiceType='آجل'");
		
		$statement->bindParam(':orderDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalamountPaid=0;
		$totalamountRemain=0;

		if ($statement->rowCount() > 0) {

			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='15%'>
	"."رقم الفاتورة"."</th><th width='25%'>اسم العميل</th><th width='15%'>اجمالي الفاتوره</th><th width='15%'>معاينه</th>
	<th width='15%'>طباعه</th><th width='15%'>ارجاع</th>";

	
		
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $totalamountPaid+=intval($row["amountPaid"]);
	      $totalamountRemain+=intval($row["amountRemain"]);

	 $showInvoice = '<button type="button" name="showInvoice" id="'.$row["invoiceNo"].'" class="btn btn-success btn-xs showInvoice"><i class="fa fa-eye fa-fw"></i>معاينه</button>';
	 $printInvoice = '<button type="button" name="printInvoice" id="'.$row["invoiceNo"].'" class="btn btn-info btn-xs printInvoice"><i class="fa fa-print fa-fw"></i>طباعة</button>';
	 $erga3 = '<button type="button" name="erga3" id="'.$row["invoiceNo"].'" class="btn btn-danger btn-xs erga3"><i class="fa fa-arrow-left fa-fw"></i>إرجاع</button>';
		
	$html.="<tr><td width='15%'>".$row["invoiceNo"]."</td><td width='25%'>".$custName."</td><td width='15%'>"
	.number_format($row["total"])." جنيه</td><td width='15%'>".$showInvoice."</td><td width='15%'>".$printInvoice.
	"</td><td width='15%'>".$erga3."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المدفوع  ((  ".number_format($totalamountPaid)." جنيه  ))</label></td></tr>";

		$html.="<tr  style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المتبقي  ((  ".number_format($totalamountRemain)." جنيه  ))</label></td></tr>";

		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalamountRemainDRDiv'><label style='margin-bottom: 10px;' id='totalamountRemainDRLbl'>لا يوجد مبيعات آجل</label></div>";
		}
		//end mby3at agel

		//show mby3at 7gz
	$html.="<div class='row' id='mby3at7gzDiv'><label id='mby3at7gzLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مبيعات حجز</label></div>";
	
	$statement= $connection->prepare("select * from orders 
		where orderDate=:orderDate and invoiceType='حجز'");
	$statement->bindParam(':orderDate', $_POST["DailyReportDate"]);
	$statement->execute();
	$result= $statement->fetchAll();

	$total7gzMony=0;

	if ($statement->rowCount() > 0) {
		

	$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='15%'>
	"."رقم الفاتورة"."</th><th width='25%'>اسم العميل</th><th width='15%'>اجمالي الفاتوره</th><th width='15%'>معاينه</th>
	<th width='15%'>طباعه</th><th width='15%'>ارجاع</th>";

	
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $total7gzMony+=intval($row["total"]);

	 $showInvoice = '<button type="button" name="showInvoice" id="'.$row["invoiceNo"].'" class="btn btn-success btn-xs showInvoice"><i class="fa fa-eye fa-fw"></i>معاينه</button>';
	 $printInvoice = '<button type="button" name="printInvoice" id="'.$row["invoiceNo"].'" class="btn btn-info btn-xs printInvoice"><i class="fa fa-print fa-fw"></i>طباعة</button>';
	 $erga3 = '<button type="button" name="erga3" id="'.$row["invoiceNo"].'" class="btn btn-danger btn-xs erga3"><i class="fa fa-arrow-left fa-fw"></i>إرجاع</button>';
		
	$html.="<tr><td width='15%'>".$row["invoiceNo"]."</td><td width='25%'>".$custName."</td><td width='15%'>"
	.number_format($row["total"])." جنيه</td><td width='15%'>".$showInvoice."</td><td width='15%'>".$printInvoice.
	"</td><td width='15%'>".$erga3."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>باجمالي مبلغ  ((  ".number_format($total7gzMony)." جنيه  ))</label></td></tr>";

		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
	}else{
		$html.="<div id='total7gzDRDiv'><label style='margin-bottom: 10px;' id='total7gzDRLbl'>لا يوجد مبيعات حجز</label></div>";
	}

//end mby3at 7gz

		//show  7gz
	$html.="<div class='row' id='Div7gz'><label id='Lbl7gz' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'> حجز</label></div>";
	
	$statement= $connection->prepare("select * from reservation 
		where reservDate=:reservDate");
	$statement->bindParam(':reservDate', $_POST["DailyReportDate"]);
	$statement->execute();
	$result= $statement->fetchAll();

	 $totalReservAmount=0;

	if ($statement->rowCount() > 0) {
		

	$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='20%'>
		اسم العميل</th><th width='12%'>تاريخ الحجز</th><th width='15%'>حجز بمبلغ</th>
		 <th width='15%'>متبقي عليه</th><th width='12%'>ميعاد الاستلام</th>
		 <th width='16%'>متاح للتسليم</th><th width='10%'>التفاصيل</th></tr></thead><tbody>";

	
		foreach($result as $row)
		{
		  $statement1 = $connection->prepare("select custName from customers 
		where custID=:custID");
		$statement1->execute(array(':custID'=>$row['custID']));
		$result1 = $statement1->fetch();

	 $btnShow= "<button type='button' name='showReservationDetails' id='".$row["reservID"]."' class='btn btn-xs showReservationDetails' style='background-color:#B80303;color:white'>التفاصيل</button>";
	 // $btnPrint= "<button type='button' name='printInvoice' id='".$row["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";
	 // $giveInvoice= "<button style='background-color: #7BA237;color:#fff' type='button' name='giveInvoice' id='".$row["invoiceNo"]."' class='btn btn-xs giveInvoice'>تسليم</button>";
	
	 $totalReservAmount+=$row["reservAmount"];

 $html.="<tr><td>".$result1["custName"]."</td><td>".$row["reservDate"]."</td><td>".number_format($row["reservAmount"])
 ." جنيه</td><td>".number_format($row["reservRemainMony"])." جنيه</td><td>".$row["delivDate"]."</td><td>"
 .number_format($row["remainToDelivered"])." جنيه</td><td>".$btnShow."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>باجمالي الحجوزات  ((  ".number_format($totalReservAmount)." جنيه  ))</label></td></tr>";

		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
	}else{
		$html.="<div id='total7gzDRDiv'><label style='margin-bottom: 10px;' id='total7gzDRLbl'>لا يوجد حجوزات</label></div>";
	}

//end show 7gz


		//show t7seel el agel by3
		$html.="<div class='row' id='t7selAgelDiv'><label id='t7selAgelLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>تحصيل الآجل ( بيع )</label></div>";

		$statement= $connection->prepare("select * from customerspaidMony 
		where paidDate=:paidDate and remainFromLast > 0");
		
		$statement->bindParam(':paidDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalamountPaidAgel=0;

		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='25%'>
	"."اسم العميل"."</th><th width='20%'>المبلغ المتبقي سابقا</th><th width='15%'>المبلغ المدفوع</th>
	<th width='20%'>متبقي بعد الدفع</th><th width='20%'>مستلم المبلغ</th>";

	
		
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $amountPaid=intval($row["customerspaidMonyAmount"]);
	      $remainFromLast=intval($row["remainFromLast"]);

	      $reaminAfterPaid=$remainFromLast-$amountPaid;

	      $totalamountPaidAgel+=$amountPaid;

	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["employeeID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];



	$html.="<tr><td>".$custName."</td><td>".number_format($remainFromLast)." جنيه</td><td>"
	.number_format($amountPaid)." جنيه</td><td>".number_format($reaminAfterPaid)." جنيه</td><td>".$memberOficialName."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المبالغ المحصله  ((  ".number_format($totalamountPaidAgel)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalamountPaidDRDiv'><label style='margin-bottom: 10px;' id='totalamountPaidDRLbl'>لا يوجد تحصيل آجل ( بيع )</label></div>";
		}
		//end t7seel el agel by3

		//show t7seel el agel 7gz
		$html.="<div class='row' id='t7selAgel7gzDiv'><label id='t7selAgel7gzLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>تحصيل الآجل ( حجز )</label></div>";

		$statement= $connection->prepare("select * from reservationRemainsMony 
		where rrDate=:rrDate order by rrID desc");
		
		$statement->bindParam(':rrDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalamountPaid7gz=0;

		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='25%'>
	"."اسم العميل"."</th><th width='20%'>المبلغ المتبقي سابقا</th><th width='15%'>المبلغ المدفوع</th>
	<th width='20%'>متبقي بعد الدفع</th><th width='20%'>مستلم المبلغ</th>";

	
		
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custID  from reservation where reservID= :reservID");  
	      $statement->bindParam(':reservID', $row["reservID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custID=$result["custID"];
	      	

		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $custID);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $amountPaid=intval($row["paidMony"]);
	      $remainFromLast=intval($row["remainBeforPaid"]);

	      $reaminAfterPaid=$remainFromLast-$amountPaid;

	      $totalamountPaid7gz+=$amountPaid;

	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["memberID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];


	$html.="<tr><td>".$custName."</td><td>".number_format($remainFromLast)." جنيه</td><td>"
	.number_format($amountPaid)." جنيه</td><td>".number_format($reaminAfterPaid)." جنيه</td><td>".$memberOficialName."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المبالغ المحصله  ((  ".number_format($totalamountPaid7gz)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalamountPaidDRDiv'><label style='margin-bottom: 10px;' id='totalamountPaidDRLbl'>لا يوجد تحصيل آجل ( حجز )</label></div>";
		}
		//end t7seel el agel 7gz

			//show fetch fokEl7sab Mony
		$html.="<div class='row' id='fokEl7sabDiv'><label id='fokEl7sabLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مبالغ مدفوعه فوق الحساب</label></div>";

		$statement= $connection->prepare("select * from customerspaidMony 
		where paidDate=:paidDate and remainFromLast = 0");
		
		$statement->bindParam(':paidDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalamountPaidFokEl7sab=0;
		
		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='25%'>
	"."اسم العميل"."</th><th width='20%'>فوق الحساب سابقا</th><th width='15%'>اضافة مبلغ</th>
	<th width='20%'>الاجمالي بعد الاضافه</th><th width='20%'>مستلم المبلغ</th>";

	
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $amountPaid=intval($row["customerspaidMonyAmount"]);
	      $totalFromLast=intval($row["totalFromLast"]);

	      $totalAfterPaid=$totalFromLast+$amountPaid;

	      $totalamountPaidFokEl7sab+=$amountPaid;

	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["employeeID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];


	$html.="<tr><td>".$custName."</td><td>".number_format($totalFromLast)." جنيه</td><td>"
	.number_format($amountPaid)." جنيه</td><td>".number_format($totalAfterPaid)." جنيه</td><td>".$memberOficialName."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المدفوع فوق الحساب  ((  ".number_format($totalamountPaidFokEl7sab)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalfokel7sabDRDiv'><label style='margin-bottom: 10px;' id='totalfokel7sabDRLbl'>لا يوجد مبالغ مدفوعه فوق الحساب</label></div>";
		}
		//end fetch fokEl7sab Mony

				//show fetch deliverd as Mony
		$html.="<div class='row' id='deliverdAsMDiv'><label id='deliverdAsMLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:20px;padding-left:20px'>مبالغ مسلمه (من فوق الحساب)</label></div>";

		$statement= $connection->prepare("select * from customerDeliverdAsMony 
		where deliverdDate=:deliverdDate order by dasID desc");
		
		$statement->bindParam(':deliverdDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalamountdeliverdAsMony=0;
		
		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='25%'>
	"."اسم العميل"."</th><th width='20%'>متبقي له سابقا</th><th width='15%'>تسليمه مبلغ</th>
	<th width='20%'>متبقي له بعد التسليم</th><th width='20%'>مسئول التسليم</th>";

	
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $deliverdAmount =intval($row["deliverdAmount"]);
	      $totalFromLast=intval($row["lastRemain"]);

	      $totalAfterDelivered=$totalFromLast-$deliverdAmount;

	      $totalamountdeliverdAsMony+=$deliverdAmount;

	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["memberID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];


	$html.="<tr><td>".$custName."</td><td>".number_format($totalFromLast)." جنيه</td><td>"
	.number_format($deliverdAmount)." جنيه</td><td>".number_format($totalAfterDelivered)." جنيه</td><td>".$memberOficialName."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المبالغ المسلمه ( من فوق الحساب )  ((  ".number_format($totalamountdeliverdAsMony)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalfokel7sabDRDiv'><label style='margin-bottom: 10px;' id='totalfokel7sabDRLbl'>لا يوجد مبالغ مسلمه ( من فوق الحساب )</label></div>";
		}
		//end fetch deliverd as Mony

		//show fetch deliverd as Mony reservation
		$html.="<div class='row' id='deliverdAsM7gzDiv'><label id='deliverdAsM7gzLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:20px;padding-left:20px'>مبالغ مسلمه ( حجز )</label></div>";

		$statement= $connection->prepare("select * from withdrowfromMonyReservation 
		where withdDate=:withdDate order by withdID desc");
		
		$statement->bindParam(':withdDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalwithdMony=0;
		
		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='25%'>
	"."اسم العميل"."</th><th width='20%'>تاريخ الحجز</th><th width='20%'>سحب مبلغ</th>
	<th width='20%'>مسئول التسليم</th><th width='15%'>التفاصيل</th>";

	
		foreach($result as $row)
		{
		  $statement = $connection->prepare("select custID,reservDate from reservation where reservID= :reservID");  
	      $statement->bindParam(':reservID', $row["reservID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custID=$result["custID"];
	      $reservDate=$result["reservDate"];
	      	

		  $statement = $connection->prepare("select custName from customers where custID= :custID");  
	      $statement->bindParam(':custID', $custID);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	      $withdMony =intval($row["withdMony"]);

	      $totalwithdMony+=$withdMony;

	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["memberID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];
	 $btnShow= "<button type='button' name='showReservationDetails' id='".$row["reservID"]."' class='btn btn-xs showReservationDetails' style='background-color:#B80303;color:white'>التفاصيل</button>";


	$html.="<tr><td>".$custName."</td><td>".$reservDate."</td><td>"
	.number_format($withdMony)." جنيه</td><td>".$memberOficialName."</td><td>".$btnShow."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المبالغ المسلمه ( حجز )  ((  ".number_format($totalwithdMony)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalfokel7sabDRDiv'><label style='margin-bottom: 10px;' id='totalfokel7sabDRLbl'>لا يوجد مبالغ مسلمه ( حجز )</label></div>";
		}
		//end fetch deliverd as Mony reservation


			//show fetch erga3
		$html.="<div class='row' id='erga3ReportDiv'><label id='erga3ReportLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مرتجع</label></div>";

		$statement= $connection->prepare("select * from mortg3 
		where mortg3Date=:mortg3Date order by mortg3ID desc");
		
		$statement->bindParam(':mortg3Date', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalMortgeCost=0;
		
		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='20%'>
	"."اسم العميل"."</th><th width='15%'>رقم الفاتوره</th><th width='20%'>الصنف</th>
	<th width='15%'>سعر الارجاع</th><th width='15%'>ارجاع كميه</th><th width='15%'>المستلم</th>";

	
		foreach($result as $row)
		{

		  $statement = $connection->prepare("select custID  from orders where invoiceNo= :invoiceNo");  
	      $statement->bindParam(':invoiceNo', $row["invoiceNo"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custID=$result["custID"];

		  $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $custID);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	       $statement = $connection->prepare("select  catID,suppID,measName from measures where measID= :measID");  
	      $statement->bindParam(':measID', $row["productID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $measName=$result["measName"];

	      $statement1 = $connection->prepare("select  catName from categories where catID= :catID");  
	      $statement1->bindParam(':catID', $result["catID"]);
	      $statement1->execute();
	      $result1 = $statement1->fetch();

	      $catName=$result1["catName"];

	      $statement2 = $connection->prepare("select  suppName from suppliers where suppID= :suppID");  
	      $statement2->bindParam(':suppID', $result["suppID"]);
	      $statement2->execute();
	      $result2 = $statement2->fetch();

	      $suppName=$result2["suppName"];

	      $prodName=$suppName." ".$catName." ".$measName;

	      $MortgeCost=($row["mortg3Quant"]*$row["unitPrice"])/1000;
	      $totalMortgeCost+=$MortgeCost;


	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["memberID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];


	$html.="<tr><td>".$custName."</td><td>".$row["invoiceNo"]."</td><td>".$prodName."</td><td>".number_format($row["unitPrice"])
	." جنيه</td><td>".convertTotenAndKelo($row["mortg3Quant"])."</td><td>".$memberOficialName."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي مرتجع بمبلغ  ((  ".number_format($totalMortgeCost)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalfokel7sabDRDiv'><label style='margin-bottom: 10px;' id='totalfokel7sabDRLbl'>لا يوجد مرتجع</label></div>";
		}
		//end fetch erga3

			//show fetch eda3at
		$html.="<div class='row' id='eda3atDiv'><label id='eda3atLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>ايداعات</label></div>";

		$statement= $connection->prepare("select * from deposits 
		where depositDate=:depositDate order by depositID desc");
		
		$statement->bindParam(':depositDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totaleda3at=0;
		
		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='20%'>
	"."اسم الوكيل"."</th><th width='20%'>المبلغ المستحق قبل الايداع</th><th width='15%'>ايداع مبلغ</th>
	<th width='20%'>المبلغ المستحق بعد الايداع</th><th width='15%'>المسئول</th><th width='10%'>معاينة الصوره</th>";

	
		foreach($result as $row)
		{
		  $mordID=$row["mordID"];
	 	  $statement = $connection->prepare("select mordName,totalAmountRemain from elmordeen where mordID=:mordID");
	 	  $statement->bindParam(':mordID', $mordID);
		  $statement->execute();
		  $result = $statement->fetch();
		  $mordName=$result["mordName"];

		  $last=$row["lastAmountRemain"];
	      $amountPaid=$row["depositAmount"];
	      $after=$last-$amountPaid;

	      $totaleda3at+=intval($amountPaid);

	      $lastAmountRemain = number_format(floatval($last))." جنيه";
	      $amountPaid = number_format(floatval($amountPaid))." جنيه";
	      $Remainafter= number_format(floatval($after))." جنيه";

		 $ShowDepositImg = '<button type="button" name="ShowDepositeImg" id="'.$row["depositID"].'" class="btn btn-success btn-xs ShowDepositeImg"><i class="fa fa-eye fa-fw"></i>معاينة</button>';


	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["memberID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];


	$html.="<tr><td>".$mordName."</td><td>".$lastAmountRemain."</td><td>"
	.$amountPaid."</td><td>".$Remainafter."</td><td>".$memberOficialName."</td><td>".$ShowDepositImg."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي ايداعات البنوك  ((  ".number_format($totaleda3at)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalfokel7sabDRDiv'><label style='margin-bottom: 10px;' id='totalfokel7sabDRLbl'>لا يوجد ايداعات</label></div>";
		}
		//end fetch eda3at
			//show fetch msrofat
		$html.="<div class='row' id='msrofatDiv'><label id='msrofatLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>مصروفات</label></div>";

		$statement= $connection->prepare("select msrofatName,msrofatDetails,msrofatAmount,memberID,addedDate
	 from msrofat where addedDate=:addedDate order by msrofatID desc");
		
		$statement->bindParam(':addedDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalMsrofat=0;
		
		if ($statement->rowCount() > 0) {
			$html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html.="<tr style='background-color: #B80303;color: #fff'><th width='20%'>
	"."إذن صرف"."</th><th width='35%'>التفاصيل</th><th width='25%'>المبلغ المنصرف</th>
	<th width='20%'>مسئول الصرف</th>";

	
		foreach($result as $row)
		{
		  $totalMsrofat+=$row['msrofatAmount'];

	      $statement = $connection->prepare("select memberOficialName  from members where memberID= :memberID");  
	      $statement->bindParam(':memberID', $row["memberID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $memberOficialName=$result["memberOficialName"];


	$html.="<tr><td>".$row['msrofatName']."</td><td>".$row['msrofatDetails']."</td><td>"
	.number_format($row['msrofatAmount'])." جنيه</td><td>".$memberOficialName."</td></tr>";
		}
	

		$html.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المصروفات  ((  ".number_format($totalMsrofat)." جنيه  ))</label></td></tr>";

		
		$html.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
		}else{
			$html.="<div id='totalfokel7sabDRDiv'><label style='margin-bottom: 10px;' id='totalfokel7sabDRLbl'>لا يوجد مصروفات</label></div>";
		}
		//end fetch msrofat
	$html.="</div>"; 

	$html2="<div class='row' >";
	$html2.="<div class='row' id='totalAddedDiv'><label id='totalAddedLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:260px;line-height: 27px;padding-right:15px;padding-left:15px'>مبالغ مضافه للخزنه</label></div>";

	$html2.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html2.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html2.="<tr style='background-color: #B80303;color: #fff'>";
	if ($cachTotalMony > 0) {
		$html2.="<th>مبيعات كاش</th>";
	}
	if ($rebtaTotalMony > 0) {
		$html2.="<th>مبيعات ربطه للخرده</th>";
	}
	if ($totalamountPaid > 0) {
		$html2.="<th>مبيعات اجل(المدفوع)</th>";
	}
	if ($totalReservAmount > 0) {
		$html2.="<th>حجز</th>";
	}
	if ($totalamountPaidAgel > 0) {
		$html2.="<th>تحصيل اجل بيع</th>";
	}
	if ($totalamountPaid7gz > 0) {
		$html2.="<th>تحصيل اجل حجز</th>";
	}
	if ($totalamountPaidFokEl7sab > 0) {
		$html2.="<th>مدفوع فوق الحساب</th>";
	}
	$html2.="</tr>";

	$html2.="<tr>";
	if ($cachTotalMony > 0) {
		$html2.="<th>".number_format($cachTotalMony)." جنيه</th>";
	}
	if ($rebtaTotalMony > 0) {
		$html2.="<th>".number_format($rebtaTotalMony)." جنيه</th>";
	}
	if ($totalamountPaid > 0) {
		$html2.="<th>".number_format($totalamountPaid)." جنيه</th>";
	}
	if ($totalReservAmount > 0) {
		$html2.="<th>".number_format($totalReservAmount)." جنيه</th>";
	}
	if ($totalamountPaidAgel > 0) {
		$html2.="<th>".number_format($totalamountPaidAgel)." جنيه</th>";
	}
	if ($totalamountPaid7gz > 0) {
		$html2.="<th>".number_format($totalamountPaid7gz)." جنيه</th>";
	}
	if ($totalamountPaidFokEl7sab > 0) {
		$html2.="<th>".number_format($totalamountPaidFokEl7sab)." جنيه</th>";
	}
	$html2.="</tr>";
	$t=$cachTotalMony+$rebtaTotalMony+$totalamountPaid+$totalReservAmount+$totalamountPaidAgel+$totalamountPaid7gz+$totalamountPaidFokEl7sab;

		//rseed Sabek
		$statement= $connection->prepare("select rseedAmount from addRseesdSabkInKhzna where addedDate=:addedDate");
		
		$statement->bindParam(':addedDate', $_POST["DailyReportDate"]);
		$statement->execute();
		$result= $statement->fetchAll();

		$totalResseSabek=0;
		
		if ($statement->rowCount() > 0) {
			foreach($result as $row){
				$totalResseSabek+=intval($row["rseedAmount"]);
			}
		}


		$html2.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المبالغ المضافه للخزنه  ((  ".number_format($t)." جنيه  )) + ".number_format($totalResseSabek)." جنيه - عباره عن رصيد سابق</label></td></tr>";

	$html2.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

	$html2.="<div class='row' >";
	$html2.="<div class='row' id='totalSubTractedDiv'><label id='totalSubTractedLbl' style='background-color: #FBB900
	;color: #B80303;text-align:center;height:30px;width:260px;line-height: 27px;padding-right:15px;padding-left:15px'>مبالغ مخصومة من الخزنه</label></div>";

	$html2.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
	$html2.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
	$html2.="<tr style='background-color: #B80303;color: #fff'>";

	if ($totalamountdeliverdAsMony > 0) {
		$html2.="<th>مبالغ مسلمة(فوق الحساب)</th>";
	}
	if ($totalwithdMony > 0) {
		$html2.="<th>مبالغ مسلمة(حجز)</th>";
	}
	if ($totalMortgeCost > 0) {
		$html2.="<th>مرتجع</th>";
	}
	if ($totaleda3at > 0) {
		$html2.="<th>ايداعات</th>";
	}
	if ($totalMsrofat > 0) {
		$html2.="<th>مصروفات</th>";
	}
	$html2.="</tr>";

	$html2.="<tr>";
	if ($totalamountdeliverdAsMony > 0) {
		$html2.="<th>".number_format($totalamountdeliverdAsMony)." جنيه</th>";
	}if ($totalwithdMony > 0) {
		$html2.="<th>".number_format($totalwithdMony)." جنيه</th>";
	}if ($totalMortgeCost > 0) {
		$html2.="<th>".number_format($totalMortgeCost)." جنيه</th>";
	}if ($totaleda3at > 0) {
		$html2.="<th>".number_format($totaleda3at)." جنيه</th>";
	}if ($totalMsrofat > 0) {
		$html2.="<th>".number_format($totalMsrofat)." جنيه</th>";
	}
	$html2.="</tr>";

	$tt=$totalamountdeliverdAsMony+$totalwithdMony+$totalMortgeCost+$totaleda3at+$totalMsrofat;
	$html2.="<tr style='line-height: 14px;background-color:#F5F5F5;color:#B80303'><td colspan='6'>
		<label>اجمالي المبالغ المخصومة من الخزنه  ((  ".number_format($tt)." جنيه  ))</label></td></tr>";

	$safy=$t+$totalResseSabek-$tt;	

	$html2.="</table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

	$html2.="</div>"; 


	$safyFinal=" صافي ".number_format($safy)." جنيه"; 
	
	

	echo $html.",,toffaha,,".$html2."mohammedRagabToffaha".$safyFinal;

	}//end isset



	?>