<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
 function load_moredden(){
        $con=mysqli_connect("localhost","id1392949_ibraheem","P@ssw0rdS","id1392949_gsaldb");
        $moredden='';
        $sql="select * from elmordeen";
        $result=mysqli_query($con,$sql);
        while ($row=mysqli_fetch_array($result)) {
            $moredden .='<option value= "'.$row["mordID"].'">'.$row["mordName"].'</option>';
        }
        return $moredden;
    }

?>
  <div class="row">
	<div class="col-md-12">
	<form method="post" id="form_supplierReport">
		<br>
		<div class="row">
			<div class="col-lg-3 col-md-3 control-group">
				 <label>اسم وكيل الشراء </label>
				 <select id="SelectMoredForReport" class="form-control">
				 	<?php echo load_moredden();?>
	         	 </select>
			</div>	
			<div class="col-lg-3 col-md-3 control-group">
				 <label>كشف حساب خلال الفتره من </label>
				 <input type="text" id="suppReportSDate" class="form-control"/>
			</div>
			<div class="col-lg-3 col-md-3 control-group">
				<label>الى </label>
				<input type="text" id="suppReportEDate" class="form-control"/>
				
			</div>	
			<div class="col-lg-2 col-md-2 control-group">
				<label style="display:block;visibility:hidden;">ط|ل</label>
				<input type="submit" value="كشف الحساب" id="showSuppReportBtn" class="btn  btn-block" 
			       style="color: #B80303;background-color:#FBB900;"> 
			</div>	
		</div>

		</form>

	</div>
	
</div>
	
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />


 <div class="row" id="AllSuppReport" style="padding-right:25px;">
 	
</div>

