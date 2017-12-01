	<?php
	include('gsaldb.php');

	 
	  $statement = $connection->prepare("select * from suppliers");  
      $statement->execute();
      if ($statement->rowCount() > 0) {
      	 $result = $statement->fetchAll();
      	 foreach ($result as $row) {
	      	echo "<option value='".$row["suppID"]."'>".$row["suppName"]."</option>";
	      }
      }else{
      	  $statement = $connection->prepare("select * from suppliers");  
	      $statement->execute();
	      if ($statement->rowCount() > 0) {
	      	 $result = $statement->fetchAll();
	      	 foreach ($result as $row) {
		      	echo "<option value='".$row["suppID"]."'>".$row["suppName"]."</option>";
		      }
	      }else{
	      	  $statement = $connection->prepare("select * from suppliers");  
		      $statement->execute();
		      if ($statement->rowCount() > 0) {
		      	 $result = $statement->fetchAll();
		      	 foreach ($result as $row) {
			      	echo "<option value='".$row["suppID"]."'>".$row["suppName"]."</option>";
			      }
		      }else{
		      		  $statement = $connection->prepare("select * from suppliers");  
				      $statement->execute();
				      if ($statement->rowCount() > 0) {
				      	 $result = $statement->fetchAll();
				      	 foreach ($result as $row) {
					      	echo "<option value='".$row["suppID"]."'>".$row["suppName"]."</option>";
					      }
				      }else{
				      		  $statement = $connection->prepare("select * from suppliers");  
						      $statement->execute();
						      if ($statement->rowCount() > 0) {
						      	 $result = $statement->fetchAll();
						      	 foreach ($result as $row) {
							      	echo "<option value='".$row["suppID"]."'>".$row["suppName"]."</option>";
							      }
						      }else{

						      }
				      }
		      }
	      }
      }
     


	
	?>