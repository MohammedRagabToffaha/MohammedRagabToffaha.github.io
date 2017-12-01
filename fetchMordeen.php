	<?php
	include('gsaldb.php');

	$data = array();
	$output = array();
	$statement = $connection->prepare("select * from elmordeen");
	$statement->execute();
	$result = $statement->fetchAll();

	

	foreach($result as $row)
	{
		  $sub_array = array();
		
	     $sub_array[] = $row["mordName"];
	     $sub_array[] = $row["mordPhone"];
	     $sub_array[] = $row["mordBankID"];
		 
		 $data[] = $sub_array;
	}

	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 // "recordsTotal"  =>  $filtered_rows,
	 // "recordsFiltered" => get_total_all_records_Suppliers(),
	 "data"    => $data
	);

	echo json_encode($output);


	?>