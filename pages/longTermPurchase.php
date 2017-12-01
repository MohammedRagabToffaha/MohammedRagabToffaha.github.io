<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>
<br>
<div class='row' id='divmoredamount'>
	<label id='moredamountID' style='background-color: #FBB900
	;color:#B80303;width:300px;height:30px;line-height: 27px;'>ايداع مبلغ فى حساب وكيل
	</label>
</div>

<div class="row">
			<form method="post" id="form_longTermPurchase">
				<div class="col-lg-1 col-md-1 control-group"></div>

			<div class="col-lg-3 col-md-3  control-group">
				 <select id="SelectMoredName" class="SelectTypeInStock form-control">
	         	 </select>
			</div>

			<div class="col-lg-3 col-md-3 control-group">
				 <select id="Eda3Type" class="Eda3Type form-control">
				 	<option value="1">ايداع</option>
				 	<option value="2">نقدي</option>
				 	<option value="3">عهده</option>
	         	 </select>
			</div>

			
			 <div class="col-lg-3 col-md-3 input-group">
                
				<input type="text" id="depositAmount"  class="form-control" placeholder="ايداع مبلغ"/>

                <span class="input-group-btn">
                    <input type="submit" id="add_longTermPurchase" value="+" class="btn" />
                </span>
               
            </div>
            <div class="col-lg-1 col-md-1  control-group"></div>
			</form>
</div>
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<div class="row" id="elmordeenRemainsAmountTable">


</div>

 
<div class="row">

	<div class="col-md-12">
		
		<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
		<div class='row' id='putMonyDiv'>
			<label id='putMonyID' style='background-color: #FBB900
			;color: #B80303;width:300px;height:30px;line-height:27px;padding-right:20px;padding-left:20px'>
			تفاصيل عمليات الايداع 
			</label>
		</div>

		<div class="row">
			<div class="table-responsive">
				<table id="longTermPurchaseTable" class="table table-bordered hover" style="width:100%">
			     <thead>
			      <tr style="background-color: #B80303;color: #fff">
			       <th>الوكيل</th>
			       <th>المبلغ المستحق قبل الايداع</th>
			       <th>ايداع مبلغ</th>
			       <th>المبلغ المستحق بعد الايداع</th>
			       <th>نوع الايداع</th>
			       <th>تاريخ الايداع</th>
			       <th>اضافة صورة</th>
			       <th>معاينة الصوره</th>
			       <th>مسح</th>
			      </tr>
			     </thead>
			    </table>
			</div>
		</div>
	</div>
</div>



