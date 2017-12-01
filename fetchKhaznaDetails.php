	<?php
	include('gsaldb.php');

	$html="<div class='row' >"; 
	
	
	$statement = $connection->prepare("select khaznaTotal from khazna");
	
	$statement->execute();
	$result = $statement->fetch();


	$html.="<div class='row'><div class='table-responsive' id='khaznatableDiv'><table style='width:50%' id='khaznatablelbl' class='table table-bordered hover'>";
	$html.="<tr><td>اجمالي الموجود بالخزنه</td><td>".number_format($result['khaznaTotal'])." جنيه"."</td></tr>";
	$html.="</table></div></div>";
$html.="<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/>";

	$html.="<div class='row'><div class='col-lg-5 col-md-5'>";
	
	

	$html.="<div class='row' id='khaznatwreedDiv'><label id='khaznatwreedLbl' style='background-color: #FBB900
	;color: #B80303;margin-top:30px;height:30px;line-height: 27px;padding-right:30px;padding-left:30px;width:310px'>توريد مبلغ بحساب المخزن</label></div>"; 

	
	$html.="<div class='row'><form method='post' id='form_withdrowFromKhazna'><div class='col-lg-1 col-md-1 col-sm-1'></div>";
	$html.="<div class='col-lg-7 col-md-7 col-sm-7 col-xs-7'><input type='text' style='height:33px;width:100%;' id='withdrowInputMony' placeholder='المبلغ'/></div>";
	$html.="<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'><input type='submit' value='توريد' id='withdrowSubmit' class='btn' style='color: #fff;background-color:#B80303;'></div>";
	$html.="</form></div>";
	$html.="</div>";

	
	$html.="<div class='col-lg-1 col-md-1'></div>";

	$html.="<div class='col-lg-5 col-md-5'>";
	$html.="<div class='row' id='khaznatwreedDiv'><label id='khaznatwreedLbl' style='background-color: #FBB900
	;color: #B80303;margin-top:30px;height:30px;line-height: 27px;padding-right:30px;padding-left:30px;width:310px'>رصيد سابق</label></div>"; 
	
	$html.="<div class='row'><form method='post' id='form_rseedSabk'><div class='col-lg-1 col-md-1 col-sm-1'></div>";
	$html.="<div class='col-lg-7 col-md-7 col-sm-7 col-xs-7'><input type='text' style='height:33px;width:100%;' id='rseedSabkInput' placeholder='المبلغ'/></div>";
	$html.="<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'><input type='submit' value='ايداع' id='rseedSabkSubmit' class='btn' style='color: #fff;background-color:#B80303;'></div>";
	$html.="</form></div>";

	$html.="</div>";
	$html.="</div>";


	$html.="<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/>";

	$html.="<div class='row'><div class='col-lg-2 col-md-2 col-sm-1'></div><div class='col-lg-8 col-md-8 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='30%'>
		"."تاريخ التوريد"."</th><th width='30%'>المبلغ</th><th width='40%'>المسئول عن التوريد</th></tr></thead><tbody>";


	$statement = $connection->prepare("select withdrowAmount,withdrowDate,memberID from withdrowfromkhazna 
		order by withdrowDate desc,withdrowID desc limit 30");
	
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		# code...
		$statement1 = $connection->prepare("select memberOficialName from members 
		where memberID=:memberID");
		
		$statement1->execute(array(':memberID'=>$row['memberID']));
		$result1 = $statement1->fetch();

 		 $html.="<tr><td>".$row["withdrowDate"]."</td><td>".number_format($row["withdrowAmount"])." جنيه"."</td><td>".$result1["memberOficialName"]."</td></tr>";

	}
	$html.="</tbody></table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";

	$html.="<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/>";

	$html.="<div class='row'><div class='col-lg-2 col-md-2 col-sm-1'></div><div class='col-lg-8 col-md-8 col-sm-10'>";
		$html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
		$html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='30%'>
		"."تاريخ الاضافه"."</th><th width='30%'>اضافة رصيد</th><th width='40%'>المسئول عن الاضافه</th></tr></thead><tbody>";


	$statement = $connection->prepare("select rseedAmount,addedDate,memberID from addRseesdSabkInKhzna 
		order by addedDate desc,rseedID desc limit 30");
	
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		# code...
		$statement1 = $connection->prepare("select memberOficialName from members 
		where memberID=:memberID");
		
		$statement1->execute(array(':memberID'=>$row['memberID']));
		$result1 = $statement1->fetch();

 		 $html.="<tr><td>".$row["addedDate"]."</td><td>".number_format($row["rseedAmount"])." جنيه"."</td><td>".$result1["memberOficialName"]."</td></tr>";

	}
	$html.="</tbody></table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";


	$html.="</div>"; 
	echo $html;


	
	?>