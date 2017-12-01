	<?php
	include('gsaldb.php');
	include('function.php');
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
	try {
          $connection->beginTransaction();

	$data = array();
	$output = array();
	$statement = $connection->prepare("select sum(unitInStock) as 'TotalexistinStock' from measures");
	$statement->execute();
	$result = $statement->fetch();
	$TotalexistinStock= $result['TotalexistinStock'];

	$query = "SELECT * FROM suppliers";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	

	foreach($result as $row)
	{
		  $sub_array = array();
		  $statement = $connection->prepare("select sum(unitInStock) as 'existinStock' from measures where suppID= :suppID");  
	      $statement->bindParam(':suppID', $row["suppID"]);
	      $statement->execute();
	      $result = $statement->fetch();

	      $stockAfter=convertTotenAndKelo((int)$result["existinStock"]);



	      $sub_array[] = $row["suppName"];
		 $sub_array[] = $stockAfter;
		 $data[] = $sub_array;
	}
	$Totalexist[]='أجمالي الموجود بالمخزن';
	$stockAfter=convertTotenAndKelo((int)$TotalexistinStock);
	$Totalexist[]=$stockAfter;
    array_unshift($data, $Totalexist);

	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 // "recordsTotal"  =>  $filtered_rows,
	 // "recordsFiltered" => get_total_all_records_Suppliers(),
	 "data"    => $data
	);

	echo json_encode($output);




          $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }

	
	?>