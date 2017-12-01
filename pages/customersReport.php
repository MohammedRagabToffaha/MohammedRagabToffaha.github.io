<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}


?>
  <div class="row">
	<div class="col-md-12">
	<form method="post" id="form_customersReport">
		<br>
		<div class="row">
			<div class="col-lg-3 col-md-3 control-group">
				 <label>اسم العميل </label>
				 <input type="text" id="customerNameForReport" autocomplete="off" class="form-control" data-CsNameReport="" />
	        		<div id="customerNameListForReport"></div>
			</div>	
			<div class="col-lg-3 col-md-3 control-group">
				 <label>كشف حساب خلال الفتره من </label>
				 <input type="text" id="custReportSDate" class="form-control"/>
			</div>
			<div class="col-lg-3 col-md-3 control-group">
				<label>الى </label>
				<input type="text" id="custReportEDate" class="form-control"/>
				
			</div>	
			<div class="col-lg-2 col-md-2 control-group">
				<label style="display:block;visibility:hidden;">ط|ل</label>
				<input type="submit" value="كشف الحساب" id="showCustReportBtn" class="btn  btn-block" 
			       style="color: #B80303;background-color:#FBB900;"> 
			</div>	
		</div>

		</form>

	</div>
	
</div>
	
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


 <div class="row" id="AllCustomerReport" style="padding-right:25px;">
 	
</div>

