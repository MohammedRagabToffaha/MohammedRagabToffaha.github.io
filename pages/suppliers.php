<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>


<div class="row">
	<div class="col-md-4">
		<div class="row">
			<form method="post" id="form_supp">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
					<input type="text" id="typeInSuppliers",name="typeInSuppliers" class="form-control" placeholder="الصنف"/>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
					<input type="submit" id="add_Supp" value="+" class="btn  btn-block" 
			       style="color: #B80303;background-color:#FBB900;">    
				</div>

			</form>
		</div>
		<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
		<div class="row">
			<div class="table-responsive">
				<table id="ItemsTable" class="table table-bordered hover" style="width:100%">
			     <thead>
			      <tr style="background-color: #B80303;color: #fff">
			       <th width="100%">الاصناف</th>
			      </tr>
			     </thead>
			    </table>
			</div>
		</div>
	</div>
<div class="col-md-1"></div>
	<div class="col-md-7">
		<div class="row">
			<form method="post" id="form_meas">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				 <select id="SelectTypeInSuppliers" class="SelectTypeInSuppliers form-control">
		            <option value="">أختار</option>
		            
		         </select>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<select id="SelectCatInSuppliers" class="SelectCatInSuppliers form-control">
			        <option value="3">أطوال مشرشر</option>
			        <option value="4">لفف</option>
			    </select>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-8 col-xs-8 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>
				<input type="text" id="measureInSuppliers" class="form-control" placeholder="مقاس"/>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 control-group">
				<label style="display:block;visibility:hidden;height:5px">ط|ل</label>

				<input type="hidden" name="measure_id" id="measure_id" />
		        <input type="hidden" name="operationToMeas" id="operationToMeas" />

				<input type="submit" value="+" id="add_CatInS" class="btn  btn-block" 
		       style="color: #B80303;background-color:#FBB900;">    
			</div>

			</form>
		</div>
		<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
		<div class="row">
			<div class="table-responsive">
				<table id="SuppliersTable" class="table table-bordered hover" style="width:100%">
			     <thead>
			      <tr style="background-color: #B80303;color: #fff">
			       <th width="33.33%">الصنف</th>
			       <th width="33.33%" >الفئة</th>
			       <th width="33.33%">مقاس</th>
			      
			      </tr>
			     </thead>
			    </table>
			</div>
		</div>
	</div>
</div>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />

<div class="row" style="margin-top:0px" id="cat_dark">

</div>


     <div class="modal fade popup" id="confirm" role="dialog" style="overflow:auto;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                           
                            <button type="button"  class="close" data-dismiss="modal" >x</button>
                        </div>
                        <div class="modal-body" id="ConfirmModalBody">
                             هل تريد مسح الصنف؟؟
                        </div>
                      <div class="modal-footer">
                      	<button type="button" data-dismiss="modal"  style="float:left;margin-left:30px" class="btn btn-warning">إلغاء</button>
					    <button type="button" data-dismiss="modal" style="float:left;margin-left:30px" class="btn btn-danger" id="delete">مسح</button>
					    
					  </div>
                    </div>

                </div>
            </div>