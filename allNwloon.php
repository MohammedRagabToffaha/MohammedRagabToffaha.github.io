	<?php
	include('gsaldb.php');

	 $html="<option value='0'>شركة النقل والناولون</option>";
	  $statement = $connection->prepare("select * from nwloon");  
      $statement->execute();
      if ($statement->rowCount() > 0){
      	  $result = $statement->fetchAll();
	      foreach ($result as $row) {
	      	$html.="<option value='".$row["nwloonID"]."'>".$row["nwloonName"]."</option>";
	      }
	     
      }else{
      	  $statement = $connection->prepare("select * from nwloon");  
	      $statement->execute();
	      if ($statement->rowCount() > 0){
	      	  $result = $statement->fetchAll();
		      foreach ($result as $row) {
		      	$html.="<option value='".$row["nwloonID"]."'>".$row["nwloonName"]."</option>";
		      }
		    
	      }else{
	      	  $statement = $connection->prepare("select * from nwloon");  
		      $statement->execute();
		      if ($statement->rowCount() > 0){
		      	  $result = $statement->fetchAll();
			      foreach ($result as $row) {
			      	$html.="<option value='".$row["nwloonID"]."'>".$row["nwloonName"]."</option>";
			      }
			    
		      }else{
		      	  $statement = $connection->prepare("select * from nwloon");  
			      $statement->execute();
			      if ($statement->rowCount() > 0){
			      	  $result = $statement->fetchAll();
				      foreach ($result as $row) {
				      	$html.="<option value='".$row["nwloonID"]."'>".$row["nwloonName"]."</option>";
				      }
				    
			      }else{
			      	  $statement = $connection->prepare("select * from nwloon");  
				      $statement->execute();
				      if ($statement->rowCount() > 0){
				      	  $result = $statement->fetchAll();
					      foreach ($result as $row) {
					      	$html.="<option value='".$row["nwloonID"]."'>".$row["nwloonName"]."</option>";
					      }
					    
				      }else{
				      	
				      }
			      }
		      }
	      }
      }
     
 echo $html;

	
	?>