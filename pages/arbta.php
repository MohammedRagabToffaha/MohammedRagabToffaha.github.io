<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>


<div class="row">

	<div class="col-md-12">
		<div class="row">
			<form method="post" id="form_arbta">
			<div class="col-lg-1 col-md-1"></div>
			
			<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="arbtaCustName" class="form-control" placeholder="اسم المشتري"/>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="arbtaQuantity" class="form-control" placeholder="الوزنه بالكيلو"/>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="arbtaUnitCost" class="form-control" placeholder="سعر البيع للكيلو"/>
			</div>

			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>

				<input type="submit" value="+" id="add_arbta" class="btn  btn-block" 
		       style="color: #B80303;background-color:#FBB900;">    
			</div>

			</form>
		</div>
		<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
		<div class="row">
			<div class="table-responsive">
				<table id="arbtaTable" class="table table-bordered hover" style="width:100%">
			     <thead>
			      <tr style="background-color: #B80303;color: #fff">
			       <th>اسم المشتري</th>
			       <th>تاريخ البيع</th>
			       <th>الوزنه بالكيلو</th>
			       <th>سعر البيع للكيلو</th>
			       <th>أجمالي</th>
			       <th>مسح</th>
			       
			      
			      </tr>
			     </thead>
			    </table>
			</div>
		</div>
	</div>
</div>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


