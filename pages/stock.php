	<?php
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	   
	}else{
	    header("location:LoginCredintial.php");
	}
	?>

	<br>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
	  		<button type="button" id="AddStockBtn"  data-toggle="modal" data-target="#AddStockModal"  class="btn form-control" />
	             إضافة طلبية جديدة
	        </button>
	    </div>
	    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2"></div>   
	</div>


	<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />



	<div class="row">

		<div class="col-md-4 ">
		<div class="table-responsive">
			<table id="StockDetailsTable" class="table table-bordered hover" style="width:100%">
		     <thead>
		      <tr style="background-color: #B80303;color: #fff">
		       <th width="55%">الصنف</th>
		       <th width="45%" >موجود بالمخزن</th>
		       
		       
		      </tr>
		     <thead>
		    </table>
		</div>
		</div>
		<div class="col-md-8 ">
			<div class="table-responsive">
			<table id="StockTable" class="table table-bordered hover" style="width:100%">
		     <thead>
		      <tr style="background-color: #B80303;color: #fff">
		       <th>الصنف</th>
		       <th>الفئة</th>
		       <th>مقاس</th>
		      
		       <th>موجود بالمخزن</th>
		       <th>تعديل</th>
		       
		      </tr>
		     </thead>
		    </table>
		</div>
		</div>
	</div>
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<div class='row' id='divTlbyatDetails'><label id='TlbyatDetailsLbl' style="text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >الطلبيات</label></div> 
	<div class="row">
		<div class="col-lg-12 col-md-12">
	  	 <div class="table-responsive">
			<table id="AllTlbyatTable" class="table table-bordered hover" style="width:100%">
		     <thead>
		      <tr style="background-color: #B80303;color: #fff">
		       <th>الصنف</th>
		       <th>اسم المورد</th>
		       <th>تاريخ الشراء</th>
		       <th>الكميه</th>
		       <th>سعر الطن</th>
		       <th>باجمالي</th>
		       <th>ناولون بأسم</th>
		       <th>ناولون بمبلغ</th>
		       <th>مسح</th>
		       
		      </tr>
		     </thead>
		    </table>
		</div>
	    </div>
	</div>


	 <div id="AddStockModal" class="modal fade" style="z-index:100000000;overflow:auto;">
	 <div class="modal-dialog modal-lg">
	  <form method="post" id="AddStock_form">
	   <div class="modal-content">
	    <div class="modal-header">
	     <button type="button" class="close" data-dismiss="modal">&times;</button>
	     <h4 class="modal-title stockModalTitle">إضافة طلبيه</h4>
	    </div>
	    <div class="modal-body">

	<div class="row" >
	    <div class="col-lg-12" id="Stock_error" style="margin-bottom:10px;background-color:#F2DEDE;color:#C0447B"></div>
	</div>
	<div class="row" style="margin-top:0px">
		<form method="post" id="form_AddStock">
			

	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-6 control-group">
			<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
			 <select id="SelectTypeInStock" class="SelectTypeInStock form-control">
	         </select>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 control-group">
			<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
			<select id="SelectCatInStock" class="SelectCatInStock form-control">
		        <option value="3">أطوال مشرشر</option>
		        <option value="4">لفف</option>
		    </select>
		</div>
			<div class="col-lg-4 col-md-4 col-sm-6 control-group">
			<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
			 <select id="SelectMeasInStock" class="SelectMeasInStock form-control">
	            <option value="">أختار</option>
	            
	         </select>
		</div>
	</div>
	<br>
	<div class="row">
		  <div class="col-lg-4 col-md-4 col-sm-6 control-group">
		    <div class="form-group">
		       <label style="display:block;visibility:hidden;height:5px">ط|ل</label>
		        <input type="text" id="AddedDate" class="form-control" placeholder="تاريخ الشراء" />
		    </div>
	      </div>

		<div class="col-lg-4 col-md-4 col-sm-6  control-group">
			<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
			<input type="text" id="quantityInStock" class="form-control" placeholder="الكمية بالكيلو"/>
		</div>


		<div class="col-lg-4 col-md-4 col-sm-12 control-group">
			<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
	 	<input type="text" id="unitPriceForStock" class="form-control" placeholder="سعر الشراء للطن"/>
		</div>
	</div>
		<br>
	<div class="row">
		  <div class="col-lg-4 col-md-4 col-sm-6 control-group">
		    <select id="SelectMoredStock" class="SelectMoredStock form-control">
	           
	         </select>
	      </div>

		<div class="col-lg-4 col-md-4 col-sm-12 control-group">
			 <select id="SelectNawloonStock" class="SelectNawloonStock form-control">
	           
	         </select>
		</div>


		<div class="col-lg-4 col-md-4 col-sm-6 control-group">
			
	 		<input type="text" id="unitPriceForNawloonStock" class="form-control" placeholder="سعر النقل للطن الواحد"/>

		</div>
	</div>

	</form>
	</div>








	    <div class="modal-footer">
	     <input type="hidden" name="Stock_id" id="Stock_id" />
	     <input type="hidden" name="operationStock" id="operationStock" />
	     <input type="submit" id="addStock" name="addStock" value="إضافه" class="btn btn-lg btn-block" style="color: #fff;background-color:#B80303;max-width:400px;margin: 0 auto;float: none;" > 
	    </div>

	    <div class="modalReloadGifAddInv"></div>
	    
	   </div>
	  </form>
	 </div>
	</div>     