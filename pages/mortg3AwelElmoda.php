	<?php
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	   
	}else{
	    header("location:LoginCredintial.php");
	}
	?>
<br>
	 <div class="controls-row row">
                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label>الأصناف</label>
                        <select id="mortg3AwelElmodasuppliers" class="mortg3AwelElmodasuppliers form-control">
                            <option value="">أختار</option>
                           
                        </select>
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label style="display:block;visibility:hidden">ط|ل</label>
                        <select id="mortg3AwelElmodacategories" class="mortg3AwelElmodacategories form-control">
                            <option value="">أختار</option>
                            <option value="3">أطوال مشرشر</option>
                            <option value="4">لفف</option>
                        </select>
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label style="display:block;visibility:hidden">مل|لينيه</label>
                        <select id="mortg3AwelElmodameasure" class="mortg3AwelElmodameasure form-control" >
                            <option value="">أختار</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-4">
                  
                        <div class="form-group">
                            <label>الكميه</label>
                            <div class="input-group">
                                <input type="text" id="mortg3AwelElmodaQ" placeholder="الكميه بالكيلو" class="form-control" />
                              
                            </div>
                          </div>
                   </div>
               
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label>سعر الارجاع للطن</label>
                        <div class="input-group">
                            <input type="text" id="mortg3AwelElmodaunitcost" placeholder="السعر" class="form-control" />
                            <span class="input-group-btn">
                                <input type="button" style="background-color:#B80303;color:#fff" id="addmortg3AwelElmoda" value="+" class="btn" />
                            </span>
                           
                        </div>
                    </div>
                </div>
                  <div class="col-lg-3 ">
                  
                        <div class="form-group">
                            <label style="display:block;visibility:hidden">ط|ل</label>
                            <div class="input-group">
                                <label id="mortg3AwelElmodaCostLbl"></label>
                              
                            </div>
                          </div>
                   </div>
                                       
            </div>


<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />

	<!-- <div class="row">
		<div class="col-lg-1 col-md-1"></div>
		<div class="col-lg-10 col-md-10">
	  	 <div class="table-responsive">
			<table id="AllTlbyatTable" class="table table-bordered hover" style="width:100%">
		     <thead>
		      <tr style="background-color: #B80303;color: #fff">
		       <th width="30%">الصنف</th>
		       <th width="20%" >اسم المورد</th>
		       <th width="10%">تاريخ الشراء</th>
		       <th width="10%">الكميه</th>
		       <th width="10%">سعر الطن</th>
		       <th width="10%">باجمالي مبلغ</th>
		       <th width="10%">مسح</th>
		       
		      </tr>
		     </thead>
		    </table>
		</div>
	    </div>
	    <div class="col-lg-1 col-md-1"></div>  
	</div> -->

