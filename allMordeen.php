	<?php
	include('gsaldb.php');

	 
	  $statement = $connection->prepare("select * from elmordeen");  
      $statement->execute();
      if ($statement->rowCount() > 0){
      	  $result = $statement->fetchAll();
	      foreach ($result as $row) {
	      	echo "<option value='".$row["mordID"]."'>".$row["mordName"]."</option>";
	      }
      }else{
      	  $statement = $connection->prepare("select * from elmordeen");  
	      $statement->execute();
	      if ($statement->rowCount() > 0){
	      	  $result = $statement->fetchAll();
		      foreach ($result as $row) {
		      	echo "<option value='".$row["mordID"]."'>".$row["mordName"]."</option>";
		      }
	      }else{
	      	  $statement = $connection->prepare("select * from elmordeen");  
		      $statement->execute();
		      if ($statement->rowCount() > 0){
		      	  $result = $statement->fetchAll();
			      foreach ($result as $row) {
			      	echo "<option value='".$row["mordID"]."'>".$row["mordName"]."</option>";
			      }
		      }else{
		      	  $statement = $connection->prepare("select * from elmordeen");  
			      $statement->execute();
			      if ($statement->rowCount() > 0){
			      	  $result = $statement->fetchAll();
				      foreach ($result as $row) {
				      	echo "<option value='".$row["mordID"]."'>".$row["mordName"]."</option>";
				      }
			      }else{
			      	  $statement = $connection->prepare("select * from elmordeen");  
				      $statement->execute();
				      if ($statement->rowCount() > 0){
				      	  $result = $statement->fetchAll();
					      foreach ($result as $row) {
					      	echo "<option value='".$row["mordID"]."'>".$row["mordName"]."</option>";
					      }
				      }else{
				      	
				      }
			      }
		      }
	      }
      }
     


	
	?>