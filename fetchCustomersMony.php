	<?php
	include('gsaldb.php');

	$counter=1;
	$html="<div class='row' >"; 
	
	$statement = $connection->prepare("SELECT custID,custMony from customersMony where custMony<>0 order by custMony desc");
	
	 $statement->execute();


	$result = $statement->fetchAll();
	if ($result) {
		
		$html.="<div class='row'></div><div class='col-lg-12 col-md-12 col-sm-12'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #FD3C40;color: #fff'><th>
		"."م"."</th><th>اسم العميل</th><th>دائن بمبلغ (متبقي له)</th><th>صفحته</th></tr></thead><tbody>";

		$total=0;
		foreach($result as $row)
		{
			  $statement1 = $connection->prepare("select custName
			 from customers where custID=:custID");

			$statement1->bindParam(':custID', $row["custID"]);

			$statement1->execute();
			$result1 = $statement1->fetch();

			 $custPage="<i class='fa fa-list-alt cutomersPage' data-custName='".$result1["custName"]."' 
			 id='".$row["custID"]."' aria-hidden='true'></i>";
			 
			 $html.="<tr><td>".$counter."</td><td>".$result1["custName"]."</td><td>"
			 .number_format($row["custMony"])." جنيه</td><td>".$custPage."</td></tr>";
			 $counter+=1;

			 $total+=$row["custMony"];
		}
		$html.="<tr><td></td><td></td><td style='color:#FD3C40'>".number_format($total)." جنيه</td><td></td></tr>";

		$html.="</tbody></table></div></div>";

	}else{
		$html.="<label>لا يوجد مبالغ متبقيه للعملاء</label>"; 
	}



	
	$html.="</div>"; 
	echo $html;
	
	?>