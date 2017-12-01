	<?php
	include('gsaldb.php');

	
	$statement = $connection->prepare("select COALESCE(sum(totalAmountRemain),0) as 'TotalAmount' from orders where 
		isPaid='false'");
	$statement->execute();
	$result = $statement->fetch();
	$TotalAmount= ($result['TotalAmount']);

	$statement1 = $connection->prepare("select COALESCE(SUM(remainMony),0) as 'remainMony' from
	 awlElmodaCustRemainMony");
	$statement1->execute();
	$result1 = $statement1->fetch();

	$totalRemain=$TotalAmount+$result1["remainMony"];

	echo $totalRemain;



	
	?>