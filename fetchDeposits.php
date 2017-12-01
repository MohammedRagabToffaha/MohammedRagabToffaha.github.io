	<?php
	include('gsaldb.php');

	$data = array();
	$output = array();
	$statement = $connection->prepare("select * from deposits order by depositID desc");
	$statement->execute();
	$result = $statement->fetchAll();

	

	foreach($result as $row)
	{
		  $sub_array = array();

		  $mordID=$row["mordID"];
	 	  $statement = $connection->prepare("select mordName,totalAmountRemain from elmordeen where mordID=:mordID");
	 	  $statement->bindParam(':mordID', $mordID);
		  $statement->execute();
		  $result = $statement->fetch();
		
	     $sub_array[] = $result["mordName"];

	     $last=$row["lastAmountRemain"];
	     $amountPaid=$row["depositAmount"];
	     $after=$last-$amountPaid;

	     $sub_array[] = number_format(floatval($last))." جنيه";
	     $sub_array[] = number_format(floatval($amountPaid))." جنيه";
	     $sub_array[] = number_format(floatval($after))." جنيه";

	     if ($row["depositType"]==1) {
	     	$sub_array[]="ايداع";
	     }else if ($row["depositType"]==2) {
	     	$sub_array[]="نقدي";
	     }else if ($row["depositType"]==3) {
	     	$sub_array[]="عهده";
	     } 
	     $sub_array[] = $row["depositDate"];
	     
$sub_array[] = '<button type="button" name="AddDepositeImg" id="'.$row["depositID"].'" class="btn btn-success btn-xs AddDepositeImg"><i class="fa fa-plus fa-fw"></i>اضافة</button>';
$sub_array[] = '<button type="button" name="ShowDepositeImg" id="'.$row["depositID"].'" class="btn btn-success btn-xs ShowDepositeImg"><i class="fa fa-eye fa-fw"></i>معاينة</button>';
$sub_array[] = '<button type="button" name="deleteDeposite" id="'.$row["depositID"].'" class="btn btn-success btn-xs deleteDeposite"><i class="fa fa-trash-o"></i>مسح</button>';


	     
		 
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