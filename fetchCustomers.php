
<?php
	include('gsaldb.php');
	include('function.php');
	try {
          $connection->beginTransaction();

	$query = '';
	$output = array();
	$query .= "SELECT * FROM customers order by custName";
	if(isset($_POST["search"]["value"]))
	{
	 $query .= 'WHERE custName LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
	 
	 $sub_array = array();

	 $sub_array[] = $row["custName"];
	 $sub_array[] = $row["custPhone"];
	 $sub_array[] = $row["custAddress"];
	 $sub_array[] = '<button type="button" name="update" id="'.$row["custID"].'" class="btn btn-warning btn-xs update">تعديل</button>';

	
	 $data[] = $sub_array;
	}
	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 "recordsTotal"  =>  $filtered_rows,
	 "recordsFiltered" => get_total_all_records(),
	 "data"    => $data
	);
	echo json_encode($output);




          $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }

	
	?>