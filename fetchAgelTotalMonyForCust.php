	<?php
	include('gsaldb.php');

	
	$statement = $connection->prepare("select COALESCE(sum(custMony),0) as 'custMony' from customersMony");
	$statement->execute();
	$result = $statement->fetch();
	$TotalAmount= ($result['custMony']);


	echo $TotalAmount;



	
	?>