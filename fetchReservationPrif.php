	<?php
	include('gsaldb.php');
	 try {
          $connection->beginTransaction();
	$html="<div class='row' >"; 
	$statement = $connection->prepare("select sum(reservRemainMony) as 'reservRemainMony' from reservation where reservRemainMony > 0");
	
	$statement->execute();
	
	
	$statement1 = $connection->prepare("select sum(remainToDelivered) as 'remainToDelivered' from reservation where remainToDelivered > 0");
	
	$statement1->execute();
	
if (($result = $statement->fetch())&&($result1 = $statement1->fetch())) {
	# code...
	 $html.="<div class='row'><div class='col-lg-3 col-md-3 col-sm-2'></div><div class='col-lg-6 col-md-6 col-sm-8'>";
	 $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";


	$html.="<tr><td style='background-color:#B80303;color: #fff'>"."أجمالي المحجوز"."</td>
		<td style='background-color:#B80303;color: #fff'>".number_format($result1['remainToDelivered'])." جنيه</td></tr>";

	$html.="<tr><td>"."أجمالي المتبقي"."</td>
		<td>".number_format($result['reservRemainMony'])." جنيه</td></tr>";

	$html.="</table></div></div><div class='col-lg-3 col-md-3 col-sm-2'></div></div>";
}
	
    


	$html.="</div>"; 
	echo $html;

  $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }
	
	?>