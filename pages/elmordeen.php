<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>


<div class="row">

	<div class="col-md-12">
		<div class="row">
			<form method="post" id="form_Mordeen">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="moredName" class="form-control" placeholder="وكيل الشراء"/>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="moredPhone" class="form-control" placeholder="رقم التليفون"/>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="moredBankID" class="form-control" placeholder="رقم الحساب"/>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>

				<input type="submit" value="+" id="add_Mored" class="btn  btn-block" 
		       style="color: #B80303;background-color:#FBB900;">    
			</div>

			</form>
		</div>
		<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
		<div class="row">
			<div class="table-responsive">
				<table id="MordeenTable" class="table table-bordered hover" style="width:100%">
			     <thead>
			      <tr style="background-color: #B80303;color: #fff">
			       <th width="33.33%">وكيل الشراء</th>
			       <th width="33.33%" >رقم التليفون</th>
			       <th width="33.33%">رقم الحساب</th>
			      
			      </tr>
			     </thead>
			    </table>
			</div>
		</div>
	</div>
</div>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


