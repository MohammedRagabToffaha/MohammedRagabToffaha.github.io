<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>


<div class="row">

	<div class="col-md-12">
		<div class="row">
			<form method="post" id="form_Nawloon">
			<div class="col-lg-2 col-md-2"></div>
			
			<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="nwloonName" class="form-control" placeholder="اسم الشركة او السائق"/>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="nwloonPhone" class="form-control" placeholder="رقم التليفون"/>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>

				<input type="submit" value="+" id="add_Nawloon" class="btn  btn-block" 
		       style="color: #B80303;background-color:#FBB900;">    
			</div>

			</form>
		</div>
		<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
		<div class="row">
			<div class="table-responsive">
				<table id="NawloonTable" class="table table-bordered hover" style="width:100%">
			     <thead>
			      <tr style="background-color: #B80303;color: #fff">
			       <th>اسم الشركة</th>
			       <th>رقم التليفون</th>
			       <th>متبقي له</th>
			       <th>تسليم مبلغ</th>
			      
			      </tr>
			     </thead>
			    </table>
			</div>
		</div>
	</div>
</div>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


