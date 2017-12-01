	<?php
	include('gsaldb.php');

	$data = array();
	$output = array();
	$statement = $connection->prepare("select * from rbth order by rbthID desc");
	$statement->execute();
	$result = $statement->fetchAll();

	

	foreach($result as $row)
	{
		  $sub_array = array();
		
	     $sub_array[] = $row["arbtaCustName"];
	     $sub_array[] = $row["arbtaDate"];
	     $sub_array[]= $row["arbtaQuantity"]." كيلو";
	     $sub_array[]= $row["arbtaUnitCost"]." جنية";

	     $totalCost=$row["arbtaQuantity"]*$row["arbtaUnitCost"];

	     $totalCost=number_format($totalCost)." جنية";
	     $sub_array[] = $totalCost;

$sub_array[] = '<button style="background-color:#B80303" type="button" name="deleteRbta" id="'.$row["rbthID"].'" class="btn btn-success btn-xs deleteRbta"><i class="fa fa-trash-o"></i>مسح</button>';

	     
		 
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