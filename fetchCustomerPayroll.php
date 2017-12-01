	<?php
	include('gsaldb.php');
	session_start();
	
if (isset($_POST['csID'])&&$_POST['csID']!='') {
	// code...

	$html="<div class='row' >"; 
	$html.="<div class='row' id='divCustName'><label id='custNameLbl' style='background-color: #B80303
	;color: #fff;width:150px;height:30px;line-height: 27px;'>".$_POST['csName']."</label></div>"; 

	$statement = $connection->prepare("select COALESCE(sum(totalAmountRemain),0) as 'TotalAmount' from orders where custID=:custID
		and isPaid='false'");
	$statement->bindParam(':custID', $_POST["csID"]);
	$statement->execute();
	$result = $statement->fetch();
	$TotalAmount= floatval($result['TotalAmount']);

	$statement1 = $connection->prepare("select COALESCE(SUM(remainMony),0) as 'remainMony' from
	 awlElmodaCustRemainMony where custID=:custID");
	$statement1->bindParam(':custID', $_POST["csID"]);
	$statement1->execute();
	$result1 = $statement1->fetch();

	$totalRemain=$TotalAmount+$result1["remainMony"];



	$statement3 = $connection->prepare("select custMony from customersMony where custID=:custID");
	$statement3->bindParam(':custID', $_POST["csID"]);
	
	$statement3->execute();
	$result3 = $statement3->fetch();
	$custMony=number_format($result3['custMony']);


		$html.="<div class='row'><div class='col-lg-3 col-md-3 col-sm-3'></div><div class='col-lg-6 col-md-6 col-sm-6'>";

		$html.="<div class='table-responsive'><table style='width:100%;border-collapse:separate;border-spacing:0 5px
		;height:30px;line-height: 27px;padding-right:20px;padding-left:20px' class='table table-bordered'>";
		$html.="<tbody>";
		$html.="<tr style='background-color:#B89A03;color: #fff'><td><label>مدين بمبلغ (متبقي عليه)</label></td><td>".number_format(intval($totalRemain))." جنيه"."</td></tr>";
		$html.="<tr style='background-color:#B89A03;color: #fff'><td><label>دائن بمبلغ (متبقي له)</label></td><td>".$custMony." جنيه"."</td></tr>";
		$html.="</tbody></table></div></div>";

		$html.="<div class='col-lg-3 col-md-3 col-sm-3'></div></div>";
$html.="<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;' />";

$html.="<div class='row'><div class='col-lg-1 col-md-1'></div>";
$html.="<div class='col-lg-3 col-md-3'> 
					<form method='post' id='form_AddMonyToCustomer'>
					<div class='input-group'>
                            <input type='text' id='custMonyInput' class='form-control' placeholder='تحصيل مبلغ من المتبقي عليه'/>
                            <span class='input-group-btn'>
                                <input type='submit' style='border-radius: 0px;'  id='custMonyBtn' value='+' class='btn' />
                               
                            </span>
                            
                        </div>
 							<input type='hidden' id='hiddenCNametoCostomerMony' value='".$_POST['csID']."' />
                            <input type='hidden' id='hiddenMemberID' data-memberID='".$_SESSION["memberID"]."'/>
                            
                        </form>
                        <br>
                        </div>";

 $html.="<div class='col-lg-3 col-md-3'> 
					<form method='post' id='form_PayMonyFokEl7sab'>
					<div class='input-group'>
                            <input type='text' id='PayMonyInput' class='form-control' placeholder='دفع مبلغ فوق الحساب'/>
                            <span class='input-group-btn'>
                                <input type='submit' style='border-radius: 0px;'  id='PayMonyBtn' value='+' class='btn' />
                               
                            </span>
                            
                        </div>
 							<input type='hidden' id='hiddenCNametoPayFokEl7sab' value='".$_POST['csID']."' />
                            <input type='hidden' id='hiddenPayFokEl7sabMemberID' data-memberID='".$_SESSION["memberID"]."'/>
                            
                        </form>
                        <br>
                        </div>"; 

  $html.="<div class='col-lg-3 col-md-3'> 
					<form method='post' id='form_givMonyToCustomer'>
					<div class='input-group'>
                            <input type='text' id='giveCustMonyInput' class='form-control' placeholder='تسليم العميل مبلغ من المتبقي له'/>
                            <span class='input-group-btn'>
                                <input type='submit' style='border-radius: 0px;' id='giveCustMonyBtn' value='+' class='btn' />
                               
                            </span>
                            
                        </div>
 							<input type='hidden' id='hiddenCNametoGiveMony' value='".$_POST['csID']."' />
                            <input type='hidden' id='hiddenGiveMemberID' data-memberID='".$_SESSION["memberID"]."'/>
                            
                        </form>
                        <br>
                        </div>";                                              

$html.="<div class='col-lg-2 col-md-2'></div></div>";



$html.="<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;' />";



	$statement = $connection->prepare("select distinct orderDate from orders where custID=:custID and 
		invoiceType='آجل' order by orderDate desc");

	$statement->bindParam(':custID', $_POST["csID"]);

	$statement->execute();
	$result = $statement->fetchAll();


	$html.="<div class='row' id='lastaCustomersMoyPaidDiv'><label id='lastaCustomersMoyPaid' data-custid='".$_POST["csID"]."' style='text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>تفاصيل عمليات سداد المتبقي</label></div>";
	
	$html.="<div class='row' id='DivlastaCustomersMoyPaid' style='display:none;padding-right:15px;padding-left:15px'></div>";
	

	$html.="<div class='row' id='fokEl7sabMonyDiv'><label id='fokEl7sabMonyLbl' data-custid='".$_POST["csID"]."' style='text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>المبالغ المدفوعة فوق الحساب</label></div>";

	$html.="<div class='row' id='DivfokEl7sabMony' style='display:none;padding-right:15px;padding-left:15px'></div>";

	$html.="<div class='row' id='DeliverdAsMonyDiv'><label id='DeliverdAsMonyLbl' data-custid='".$_POST["csID"]."' style='text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>المبالغ المسلمه نقديه</label></div>";

	$html.="<div class='row' id='DivDeliverdAsMony' style='display:none;padding-right:15px;padding-left:15px'></div>";

	$html.="<div class='row' id='lastCustomersSalesDiv'><label id='lastCustomersSales' data-custid='".$_POST["csID"]."' style='text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>تفاصيل عمليات شراء الاجل</label></div>";

    $html.="<div class='row' id='DivlastCustomersSales' style='display:none;padding-right:15px;padding-left:15px'></div>";


	


	$html.="</div>"; 
	echo $html;
}else{
	echo "error";
}

	
	?>