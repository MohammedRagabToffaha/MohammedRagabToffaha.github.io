<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}


?>
  <div class="row">
	<div class="col-md-12">
	<form method="post" id="form_DailyReport">
		<br>
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-1"></div>	
			<div class="col-lg-4 col-md-4 col-sm-6 control-group">
				 <label>تقرير يوميه عن تاريخ</label>
				 <input type="text" id="DailyReportDate" class="form-control"/>
			</div>
				
			<div class="col-lg-2 col-md-2 col-sm-4 control-group">
				<label style="display:block;visibility:hidden;">ط|ل</label>
				<input type="submit" value="التقرير" id="DailyReportBtn" class="btn  btn-block" 
			       style="color: #fff;background-color:#B89A03;"> 
			</div>	
			<div class="col-lg-3 col-md-3 col-sm-1"></div>	
		</div>

		</form>

	</div>
	
</div>
	
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


 <div class="row" id="DailyReportSafyDiv" style="padding-right:25px;display:none">
 	<div class='row' id='safyDiv'>
 		<label id='safyLbl' style='background-color: #B89A03
	;color: #fff;text-align:center;height:30px;width:320px;line-height: 27px;padding-right:10px;padding-left:10px'>
	</label>
 	</div>
</div>
<div class="row" id="DailyReportPrifDiv" style="padding-right:25px;">	
</div>
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<div class="row" id="DailyReportDiv" style="padding-right:25px;margin-top:50px">
 	
</div>



