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

	 // $sub_array[] = '<button type="button" name="editInSuppliers" id="'.$row["measID"].'" class="btn btn-xs editInSuppliers" style="background-color:#B80303;color:white">تعديل</button>';
	 // $sub_array[] = '<button type="button" name="removeInSuppliers" id="'.$row["measID"].'" class="btn btn-warning btn-xs removeInSuppliers">مسح</button>';
	
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