	<?php
	include('gsaldb.php');
	try {
          $connection->beginTransaction();

	$query = '';
	$output = array();
	$query .= "SELECT * FROM Tlbyat order by talbyaID desc";
	
	
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
	 
	 $sub_array = array();
	 
	
      $suppID=$row["suppID"];
 	  $statement = $connection->prepare("select suppName from suppliers where suppID=:suppID");
 	  $statement->bindParam(':suppID', $suppID);
	  $statement->execute();
	  $result = $statement->fetch();


	  $catID=$row["catID"];
 	  $statement = $connection->prepare("select catName from categories where catID=:catID");
 	  $statement->bindParam(':catID', $catID);
	  $statement->execute();
	  $result1 = $statement->fetch();


	  $measID=$row["measID"];
 	  $statement = $connection->prepare("select measName from measures where measID=:measID");
 	  $statement->bindParam(':measID', $measID);
	  $statement->execute();
	  $result2 = $statement->fetch();

	  $sub_array[] =$result["suppName"]." ".$result1["catName"]." ".$result2["measName"];


	     $mordID=$row["mordID"];
	 	  $statement = $connection->prepare("select mordName from elmordeen where mordID=:mordID");
	 	  $statement->bindParam(':mordID', $mordID);
		  $statement->execute();
		  $result = $statement->fetch();
		
	     $sub_array[] = $result["mordName"];

       $sub_array[] =$row["addedDate"];

	 $stockAfter;
	 $stockBefore=(int)$row["quantity"];
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

	 $sub_array[] =number_format(intval($row["UnitCostPrice"]));

	 $cost=((int)$row["UnitCostPrice"]*(int)$row["quantity"])/1000;
	 $sub_array[] = number_format($cost);

	 $nwloonID=$row["nwloonID"];
	 if ($nwloonID=="0") {
	 	$sub_array[] ="-";
	 	$sub_array[] ="-";
	 }else{
	 	$statement = $connection->prepare("select nwloonName from nwloon where nwloonID=:nwloonID");
 	    $statement->bindParam(':nwloonID', $nwloonID);
	    $statement->execute();
	    $result3 = $statement->fetch();

	    $sub_array[] =$result3["nwloonName"];

	    $NwloonCost=((int)$row["nwloonAmount"]*(int)$row["quantity"])/1000;
	    $sub_array[] = number_format($NwloonCost);
	 }

	$sub_array[] = '<button style="background-color:#B80303" type="button" name="deleteTlbya" id="'.$row["talbyaID"].'" class="btn btn-success btn-xs deleteTlbya"><i class="fa fa-trash-o"></i>مسح</button>';

	
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