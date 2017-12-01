<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>

<br>
<div class="row" >
	<div class="col-lg-2 col-md-1 col-sm-1"></div>
	<div class="col-lg-8 col-md-10 col-sm-10">
       <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-block" 
       style="color: #B80303;background-color:#FBB900;max-width:250px;height:40px;margin: 0 auto;float: none;">إضافه عميل جديد</button>
	</div>
	<div class="col-lg-2 col-md-1 col-sm-1"></div>
</div>

<br>
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<br>

<div class="row">
	<div class="col-md-12 ">
		<div class="table-responsive">
		<table style='width:100%' id="user_data" class="table table-bordered hover">
	     <thead>
	      <tr style="background-color: #B80303;color: #fff">
	       <th width="35%">اسم العميل</th>
	       <th width="20%">رقم التليفون</th>
	       <th width="35%">العنوان</th>
	       <th width="10%">تعديل</th>
	       
	      </tr>
	     </thead>
	    </table>
	</div>
	</div>
</div>
<div class="modalReloadGifAddInv"></div> 
