	<?php
	include('gsaldb.php');
	include('function.php');

	$query = '';
	$output = array();
	$query .= "SELECT * FROM orders ";
	$query .= 'ORDER BY orderID DESC ';
	if($_POST["length"] != -1)
	{
	 $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
	 
	 $sub_array = array();
	 
	 $sub_array[] = $row["invoiceNo"];

	      $statement = $connection->prepare("select custName  from customers where custID= :custID");  
	      $statement->bindParam(':custID', $row["custID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $custName=$result["custName"];

	 $sub_array[] = $custName;
	 $sub_array[] = $row["invoiceType"];
	 $sub_array[] =number_format($row["total"]) ;

	 $sub_array[] = '<button type="button" name="showInvoice" id="'.$row["invoiceNo"].'" class="btn btn-success btn-xs showInvoice"><i class="fa fa-eye fa-fw"></i>معاينه</button>';
	 $sub_array[] = '<button type="button" name="printInvoice" id="'.$row["invoiceNo"].'" class="btn btn-info btn-xs printInvoice"><i class="fa fa-print fa-fw"></i>طباعة</button>';
	 $sub_array[] = '<button type="button" name="erga3" id="'.$row["invoiceNo"].'" class="btn btn-danger btn-xs erga3"><i class="fa fa-arrow-left fa-fw"></i>إرجاع</button>';
	
	 $data[] = $sub_array;
	}
	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 "recordsTotal"  =>  $filtered_rows,
	 "recordsFiltered" => get_total_all_records_invoices(),
	 "data"    => $data
	);
	echo json_encode($output);
	?>