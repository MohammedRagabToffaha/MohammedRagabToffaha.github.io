	<?php
	include('gsaldb.php');
	include('function.php');
	try {
          $connection->beginTransaction();

	$output = array();
	
	
	$statement = $connection->prepare("select suppName from suppliers");
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
	 
	  $sub_array = array();
	  $sub_array[] = $row["suppName"];

	 $data[] = $sub_array;
	}
	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 "recordsTotal"  =>  $filtered_rows,
	 "recordsFiltered" => $filtered_rows,
	 "data"    => $data
	);
	echo json_encode($output);




          $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }

	
	?>