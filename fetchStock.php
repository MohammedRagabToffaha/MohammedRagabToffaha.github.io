	<?php
	include('gsaldb.php');
	include('function.php');
	try {
          $connection->beginTransaction();

	$query = '';
	$output = array();
	$query .= "SELECT * FROM measures order by suppID";
	
	
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
	 
	 $sub_array = array();
	 
	$statement = $connection->prepare("select suppName from suppliers where suppID= :suppID");  
      $statement->bindParam(':suppID', $row["suppID"]);
      $statement->execute();
      $result = $statement->fetch();


	 $sub_array[] = $result["suppName"];

      $statement = $connection->prepare("select catName  from categories where catID= :catID");  
      $statement->bindParam(':catID', $row["catID"]);
      $statement->execute();
      $result = $statement->fetch();


	 $sub_array[] = $result["catName"];

	 $sub_array[] = $row["measName"];

	 $stockAfter;
	 $stockBefore=(int)$row["unitInStock"];
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


	 $sub_array[] = $stockAfter;

$editUnitInStock="<i id='".$row["measID"]."' class='editUnitInStock fa fa-pencil-square-o' style='font-size:22px;color: #B80303;'></i>";

	 $sub_array[] = $editUnitInStock;
	
	 $data[] = $sub_array;
	}
	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 "recordsTotal"  =>  $filtered_rows,
	 "recordsFiltered" => get_total_all_records_Suppliers(),
	 "data"    => $data
	);
	echo json_encode($output);




          $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }

	
	?>