<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}


?>
  <div class="row">
	<div class="col-md-12">
		
	<form method="post" id="">
		<div class="row">
			<div class="col-lg-1 col-md-1"></div>
			<div class="col-lg-4 col-md-4 control-group">
				 <label>تقرير خلال الفتره من </label>
				 <input type="text" id="msrofatReportSDate" class="form-control"/>
			</div>
			<div class="col-lg-4 col-md-4 control-group">
				<label>الى </label>
				<input type="text" id="msrofatReportEDate" class="form-control"/>
				
			</div>	
			<div class="col-lg-2 col-md-2 control-group">
				<label style="display:block;visibility:hidden;">ط|ل</label>
				<input type="submit" value="تقرير" id="showMsrofatReportBtn" class="btn  btn-block" 
			       style="color: #B80303;background-color:#FBB900;"> 
			</div>
			<div class="col-lg-1 col-md-1"></div>	
		</div>

		</form>

	</div>
	
</div>
	
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />

<center>
			<label id="msrofatReportLbl" style="background-color:#EEEEEE;color:#B80303;padding-left:17px;padding-right:17px;">
				تقرير مصروفات اخر شهر
			</label>
		</center>
<center>
	<br>
<div class="row">
<div class="col-lg-4 col-md-4" id="msrofatReportTableDiv"></div>
 <div class="col-lg-8 col-md-8" id="msrofatReportDiv" style="min-width: 310px; height: 400px;float:right">
 	
</div>
</div>
</center>
