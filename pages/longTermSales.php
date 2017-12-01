<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}

?>
<br>
<div class='row' id='divAgelTotalRemainMony'><label id='AgelTotalRemainMonyLbl' style="text-align:center;height:30px;
    width:340px;line-height: 27px;padding-right:5px;padding-left:5px" ></label></div>

<div class='row' id='divAgelTotalMonyForCust'><label id='AgelTotalMonyForCustLbl' style="text-align:center;height:30px;
    width:340px;line-height: 27px;padding-right:5px;padding-left:5px" ></label></div>     

<!-- <div class='row' id='divKshf7sab'><label id='Kshf7sabLbl' style='background-color: #B80303
  ;color: #fff;width:250px;height:30px;line-height: 27px;'>كشف حساب عميل</label></div> -->

<br>
 <div class="row">

<form method="post" id="form_customerReport">
    <div class="col-lg-4 col-md-4 col-sm-1"></div>
  <div class="col-lg-4 col-md-4">
   <div class="input-group">
      
      <input type="text" id="customerNameForAgel" placeholder="كشف حساب عميل بأسم" autocomplete="off" class="form-control" data-cnReportdata="" />
     <div id="customerNameListForAgel"></div>
      <span class="input-group-btn">
          <button  type="submit"  id="showAgelReportBtn" class="btn" 
           style="color: #fff;background-color:#B89A03;"><i class="fa fa-eye fa-fw"></i></button> 
           
      </span>
      

    
   </div>
 </div>
  <div class="col-lg-4 col-md-4 col-sm-1"></div>
 </form>

 <!-- 	<form method="post" id="form_customerReport">
		<div class="col-lg-3 col-md-3 col-sm-1">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
			<label style="display:block;visibility:hidden">ط|ل</label>
			<input type="text" id="customerNameForAgel" placeholder="اسم العميل" autocomplete="off" class="form-control" data-cnReportdata="" />
	        <div id="customerNameListForAgel"></div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
			<label style="display:block;visibility:hidden">ط|ل</label>
			<input type="submit" value="التفاصيل" id="showAgelReportBtn" class="btn  btn-block" 
			style="color: #B80303;background-color:#FBB900;"> 
		</div>
		<div class="col-lg-3 col-md-3 col-sm-1">
		</div>
	</form> -->
</div>	
<br>


	
<hr id="hrSeprator" style="display:none; width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<div class="row" id="customerPayRollDiv" style="display:none;padding-right:25px;">
    
</div>

<!-- 
<div id="longTermModal" class="modal fade" style="z-index:100000000;overflow:auto;">
 <div class="modal-dialog">
  <form method="post" id="form_PayRemainMony">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">تحصيل فاتورة</h4>
    </div>
    <div class="modal-body">

<div class="row" >
    <div class="col-lg-12" id="PayRemainMony_error" style="margin-bottom:10px;background-color:#F2DEDE;color:#C0447B"></div>
</div>
  
    <label>تحصيل الفاتورة رقم : </label>
    <br />

     <input class="form-control" name="PayRemainInvNo" id="PayRemainInvNo" type="text" readonly>
     <br />
     <label>المبلغ المتبقي</label>
    <input class="form-control" name="PayRemainAmount" id="PayRemainAmount" type="text" readonly>
     <br />
     <label>تاريخ التحصيل</label>
      <input type="text" id="PayRemainMonyDate" class="form-control" placeholder="تاريخ السداد"/>
     </div>
    <div class="modal-footer">
     <input type="hidden" id="hiddenCustID" name="hiddenCustID"/>
     <input type="hidden" id="hiddenmemberID" name="hiddenmemberID" data-memberID="<?php //echo $_SESSION["memberID"];?>"/>
     
    <input type="submit" value="تحصيل" id="payAmountBtn" class="btn  btn-block" 
			style="color: #B80303;background-color:#FBB900;">
    </div>
   </div>
  </form>
 </div>
</div>



   -->