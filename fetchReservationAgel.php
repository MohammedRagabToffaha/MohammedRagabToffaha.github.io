	<?php
	include('gsaldb.php');
	 try {
          $connection->beginTransaction();

	$html="<div class='row' >"; 
	
	$statement = $connection->prepare("select * from reservation where reservRemainMony > 0 order by 
		custID desc,delivDate");
	
	$statement->execute();
	
	if ($statement->rowCount() > 0) {
		$result = $statement->fetchAll();

		$html.="<div class='row'><div class='col-lg-12 col-md-12 col-sm-12'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='20%'>
		اسم العميل</th><th width='12%'>تاريخ الحجز</th><th width='15%'>حجز بمبلغ</th>
		 <th width='15%'>متبقي عليه</th><th width='12%'>ميعاد الاستلام</th>
		 <th width='16%'>متاح للتسليم</th><th width='10%'>التفاصيل</th></tr></thead><tbody>";

		$reservRemainMony=0;
		foreach ($result as $row) {
			# code...
			$statement1 = $connection->prepare("select custName from customers 
			where custID=:custID");
			$statement1->execute(array(':custID'=>$row['custID']));
			$result1 = $statement1->fetch();

		 $btnShow= "<button type='button' name='showReservationDetails' id='".$row["reservID"]."' class='btn btn-xs showReservationDetails' style='background-color:#B80303;color:white'>التفاصيل</button>";
		 // $btnPrint= "<button type='button' name='printInvoice' id='".$row["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";
		 // $giveInvoice= "<button style='background-color: #7BA237;color:#fff' type='button' name='giveInvoice' id='".$row["invoiceNo"]."' class='btn btn-xs giveInvoice'>تسليم</button>";
		
		$reservRemainMony+=$row["reservRemainMony"];

		 $html.="<tr><td>".$result1["custName"]."</td><td>".$row["reservDate"]."</td><td>".number_format($row["reservAmount"])
		 ." جنيه</td><td>".number_format($row["reservRemainMony"])." جنيه</td><td>".$row["delivDate"]."</td><td>"
	 	.number_format($row["remainToDelivered"])." جنيه</td><td>".$btnShow."</td></tr>";

		}
		

		$html.="</tbody></table></div></div></div>";
}
	$html.="</div>"; 
	echo $html;

  $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }
	
	?>