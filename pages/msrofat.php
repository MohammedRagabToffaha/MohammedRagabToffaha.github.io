<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}


?>
  <div class="row">
	<div class="col-md-12">
	<form method="post" id="form_msrofat">
		<br>
		<div class="row">
			<div class="col-lg-3 col-md-3 control-group">
				 <label>إذن صرف خاص بــ </label>
				 <select id="SelectMsareef" class="form-control">
				 	<option value="0">مصروفات تشغيليه</option>
				 	<option value="1">اجور عمال</option>
				 	<option value="2">مسحوبات شخصيه</option>
				 	<option value="3">اشتراك انترنت</option>
				 	<option value="4">وصل كهرباء</option>
				 	<option value="5">وصل مياه شرب</option>
				 	<option value="5">ضرائب</option>
				 	<option value="5">مصاريف اخرى</option>
	         	 </select>
			</div>	
			<div class="col-lg-5 col-md-5 control-group">
				 <label>التفاصيل </label>
				 <input type="text" id="msareefDetails" class="form-control"/>
			</div>
			<div class="col-lg-2 col-md-2 control-group">
				<label>المباغ </label>
				<input type="text" id="msareefAmount" class="form-control"/>
				
			</div>	
			<div class="col-lg-1 col-md-1 control-group">
				<label style="display:block;visibility:hidden;">ط|ل</label>
				<input type="hidden" id="hiddenmembID" name="hiddenmembID" data-memberID="<?php echo $_SESSION["memberID"];?>"/>
				<input type="submit" value="سحب" id="msareefSubmit" class="btn  btn-block" 
			       style="color: #B80303;background-color:#FBB900;"> 
			</div>	
		</div>

		</form>

	</div>
	
</div>
	
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


 <div class="row" id="msareefDetailstable" style="padding-right:25px;">
 	
</div>

