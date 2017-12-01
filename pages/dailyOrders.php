
<?php 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}
?>
<?php 
    
    function load_suppliers(){
        $con=mysqli_connect("localhost","id1392949_ibraheem","P@ssw0rdS","id1392949_gsaldb");
        $suppliers='';
        $sql="select * from suppliers order by suppName";
        $result=mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
           while ($row=mysqli_fetch_array($result)) {
            $suppliers .='<option value= "'.$row["suppID"].'">'.$row["suppName"].'</option>';
        }
        }else{
            $sql="select * from suppliers order by suppName";
            $result=mysqli_query($con,$sql);
            if (mysqli_num_rows($result) > 0) {
               while ($row=mysqli_fetch_array($result)) {
                $suppliers .='<option value= "'.$row["suppID"].'">'.$row["suppName"].'</option>';
            }
            }else{
                $sql="select * from suppliers order by suppName";
                $result=mysqli_query($con,$sql);
                if (mysqli_num_rows($result) > 0) {
                   while ($row=mysqli_fetch_array($result)) {
                    $suppliers .='<option value= "'.$row["suppID"].'">'.$row["suppName"].'</option>';
                }
                }else{

                }
            }
        }
       
        return $suppliers;
    }


?>
<div class="row">
    
        <form role="form" method="post" id="AddInvoiceForm">
          
            <div class="controls-row row">

                <div class="control-group col-lg-2 col-md-4 col-sm-4" >
                    <div class="form-group">
                        <label>رقم الفاتوره</label>
                        <input type="text" id="orderNo" class="form-control" readonly />

                    </div>
                </div>
                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label>نوع الفاتورة</label>
                        <select id="invoicetype" class="invoicetype form-control">
                            <option value="cach">كاش</option>
                            <option value="agel">أجل</option>
                            <option value="reservation">حجز</option>
                        </select>
                        
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                <div class="form-group">
                    <label>تاريخ البيع</label>
                    <input type="text" id="orderDate" class="form-control" />
                </div>
                </div>
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    
                         <div class="content row">
                            <div class="col-lg-6 col-md-7 col-sm-7">
                                <label>اسم العميل</label>
                                <input type="text" id="customerName" autocomplete="off" class="form-control" data-cndata="" />
                                <div id="customerNameList"></div>
                            </div>
                            <div class="col-lg-2 " id="emptyCol">
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-5">
                                <label style="display:block;visibility:hidden">ط|ل</label>
                                <button type="button" id="addNewCustomer" data-toggle="modal" data-target="#userModal"  class="btn form-control" />
                                    إضافة عميل جديد
                                </button>
                            </div>
                         </div>
                    
                </div>
               
                                                                 
            </div>     
        
         
            <div class="controls-row row">
                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label>الأصناف</label>
                        <select id="suppliers" class="suppliers form-control" onchange="LoadSuppliers(this)">
                            <option value="">أختار</option>
                            <?php echo load_suppliers();?>
                        </select>
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label style="display:block;visibility:hidden">ط|ل</label>
                        <select name="categories" id="categories" class="categories form-control">
                            <option value="">أختار</option>
                            <option value="3">أطوال مشرشر</option>
                            <option value="4">لفف</option>
                        </select>
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label style="display:block;visibility:hidden">مل|لينيه</label>
                        <select id="measure" class="measure form-control" >
                            <option value="">أختار</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 ">
                  
                        <div class="form-group">
                            <label>الكميه</label>
                            <div class="input-group">
                                <input type="text" id="quantity" class="form-control" />
                                <span class="input-group-btn">
                                    <select id="weight" class="btn">
                                        <option value="0">طن</option>
                                        <option value="1">كيلو</option>
                                    </select>
                                   <input type="button" id="gard" value="جرد"  class="btn" style="margin-right:4px" />
                                 </span>

                            </div>
                          </div>
                   </div>
               <div class="control-group col-lg-1 ">
                   <div class="form-group">
                      <label id="hidden" style="display:block;visibility:hidden"></label>
                      <div id="unitInStockStatus" style="background-color:#DFF0D8;color:green;margin:0">

                      </div>
                   </div>
                </div> 
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>سعر البيع للطن</label>
                        <div class="input-group">
                            <input type="text" id="unitcost" class="form-control" />
                            <span class="input-group-btn">
                                <input type="button" id="addCat" value="+" class="btn" />
                            </span>
                           
                        </div>
                    </div>
                </div>
                                       
            </div>
           
            <hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
           
            <div class="controls-row row ">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="controls-row row ">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="crud_table">
                                    <thead>
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="45%" colspan="3">الصنف</th>
                                      <th width="15%" colspan="2">الكمية</th>
                                      <th width="15%">سعر الطن</th>
                                      <th width="15%">الأجمالي</th>
                                      <th width="5%"></th>
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                      
                </div>
              </div>

                   <div class="controls-row row"  style="z-index:1000">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                           <div class="form-group">
                                <label>خدمات تضاف الى الفاتوره </label>
                                <div class="input-group">
                                    <input type="text" id="otherservicesAmount" style="width:100px" class="form-control" placeholder="مبلغ" />
                                    <span class="input-group-glue"></span>
                                    <input type="text" id="otherservicesdetails"  class="form-control" placeholder="سبب الخدمة"/>
                                    <span class="input-group-btn">
                                        <input type="button" id="Addotherservices" value="+"  class="btn" />
                                    </span>
                                  
                                 </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="otherservices_table_div" style="display:none">
                            <label style="display:block;visibility:hidden">ط|ل</label>
                              <div class="table-responsive">
                               <table class="table table-bordered" id="otherservices_table">
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="15%" >المبلغ</th>
                                      <th width="85%" >سبب الخدمة</th>
                                      
                                      <th width="5%"></th>
                                     </tr>
                                </table>
                              </div>
                        </div> 
                    </div>
                 

            </div>


                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="controls-row row ">
                        <div class="col-md-12 col-sm-12">
                           <div class="form-group">
                                <label>مصاريف تخصم من الخزنه</label>
                                <div class="input-group">
                                    <input type="text" id="otherfeestext" class="form-control" placeholder="مبلغ" />
                                    <span class="input-group-glue"></span>
                                    <input type="text" id="otherfeesdetails" class="form-control" placeholder="سبب الصرف"/>
                                    <span class="input-group-btn">
                                        <input type="button" id="addFees" value="+"  class="btn" />
                                    </span>
                                  
                                 </div>
                            </div>
                        </div>
                          
                    </div>
                    <div class="controls-row row" id="otherFees_table_div" style="display:none">
                        <div class="col-md-12 col-sm-12">
                              <div class="table-responsive">
                               <table class="table table-bordered" id="cotherFees_table">
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="15%" >المبلغ</th>
                                      <th width="85%" >سبب الصرف</th>
                                      
                                      <th width="5%"></th>
                                     </tr>
                                </table>
                              </div>
                        </div> 
                           
                    </div>

                    <div class="controls-row row ">
                        
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="button" id="showInvoice" value="معاينة الفاتورة"  class="btn form-control" />
                            </div> 
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="hidden" name="invoice_id" id="invoice_id" />
                                <input type="hidden" name="operationtoinvoice" id="operationtoinvoice" />
                                <input type="submit" id="sellInvoice" value="بيع الفاتورة"  class="btn form-control" />
                            </div>
                       
                            
                    </div>
                     <div class="controls-row row ">
                        
                             <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" style="margin-top:6px" id="discount" class="form-control" placeholder="خصم مبلغ وقدره" />
                            </div>
                       
                            
                    </div>

             
                </div>

            </div>
            
            <hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
            
            <div class="controls-row row" id="agelDev" style="display:none">
                
                  <div class="control-group col-md-2">
                    <div class="form-group">
                        <input type="text" id="amountPaid" class="form-control" placeholder="المبلغ المدفوع" />
                                                
                    </div>
                </div>
              

            <div class="control-group col-md-2" >
                <div class="form-group">
                   <input type="text" id="amountRemainDate" placeholder="ميعاد سداد المتبقي" class="form-control"/>
                </div>
            </div>
         </div>

          <div class="controls-row row" id="ReservationDev" style="display:none;padding-right:15px;padding-left:15px">

           <!--   <div class="control-group col-md-2" style="z-index:10000">
                <div class="form-group">
                   <input type="text" id="reservationDate" placeholder="ميعاد الاستلام" class="form-control"/>
                </div>
            </div> -->
         </div>
         <hr id="reservAndAgelHr" style="display:none;width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />

             
  </form>
</div>
<!-- add invoice to dataTable -->
<div class="row">
  <div class="col-md-12 ">
    <div class="table-responsive">
    <table style='width:100%' id="invoice_table" class="table table-bordered hover">
       <thead>
        <tr style="background-color: #B80303;color: #fff">
         <th width="15%">رقم الفاتورة</th>
         <th width="25%">اسم العميل</th>
         <th width="10%">نوع الفاتورة</th>
         <th width="20%">أجمالي الفاتورة</th>
         <th width="10%">معاينة</th>
         <th width="10%">طباعة</th>
         <th width="10%">إرجاع</th>
         
        </tr>
       </thead>
      </table>
  </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        //autocompleate text input
           $('#customerName').on('keyup',function(){  
               var query = $(this).val();  
               if(query != '')  
               {  
                    $.ajax({  
                         url:"searchInTextInput.php",  
                         method:"POST",  
                         data:{query:query},  
                         success:function(data)  
                         {  
                              $('#customerNameList').fadeIn();  
                              $('#customerNameList').html(data);  
                         }  
                    });  
               }  
            }); 

        $('#customerName').on('blur',function(){
          $('#customerNameList').fadeOut();
            });


          $(document).on('click', 'ul.list-unstyled li', function(){  
               $('#customerName').val($(this).text());  
               $('#customerName').attr('data-cndata',$(this).attr('data-custIDForText'));  
               $('#customerNameList').fadeOut(); 
               if ($("#invoicetype").val()=="reservation") {
                    var custID=$('#customerName').attr('data-cndata');
                   $.ajax({
                   url:"ShowReservationForOneCust.php",
                   method:'POST',
                    data:{custID:custID},
                  
                   success:function(data)
                   {

                    $("#ReservationDev").html(data); 

                   }

                });
               }
          }); 


    $("#categories").change(function(){
            var cat_ID=$(this).val();
            var supp_ID=$('#suppliers').val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataTyoe:"text",
                success:function(data){
                    $("#measure").html(data);
                }
            });
        });
        $("#suppliers").change(function(){
            var cat_ID=$("#categories").val();
            var supp_ID=$(this).val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataTyoe:"text",
                success:function(data){
                    $("#measure").html(data);
                }
            });
        });
    


           $("#invoicetype").change(function(){
            var inv_type=$(this).val();
            if (inv_type=="cach") {
                $("#agelDev").css({"display":"none"});
                $("#ReservationDev").css({"display":"none"});
                $("#reservAndAgelHr").css({"display":"none"});
            }else if(inv_type=="reservation"){
                $("#agelDev").css({"display":"none"});
                $("#ReservationDev").css({"display":"block"});
                $("#reservAndAgelHr").css({"display":"block"});

                var custID=$('#customerName').attr('data-cndata');
                if (custID !="") {
                   $.ajax({
                   url:"ShowReservationForOneCust.php",
                   method:'POST',
                    data:{custID:custID},
                  
                   success:function(data)
                   {

                    $("#ReservationDev").html(data); 

                   }

                });
              }     

            }else{
                $("#agelDev").css({"display":"block"});
                $("#ReservationDev").css({"display":"none"});
                $("#reservAndAgelHr").css({"display":"block"});
            }
        });
         
//reservation Details

 $(document).on('click','.showReservationDetails', function(e){
  
  var reservID = $(this).attr("id");
  if (reservID !="") {
  
   $.ajax({
     url:"ShowReservation.php",
     method:"POST",
     data:{reservID:reservID},
    
     success:function(data)
     {

      $("#ReserveInvModalMainDiv").html(data); 

      $("#deliverInvNoHidden" ).val(reservID);
      $("#giveReserveInvModal" ).modal('show');

     }

  });


  }

 });
 ////end reservation Details
$(document).on("click","#reservToCustTable tr",function() {
     $(this).find('td input[type=radio]').prop('checked', true);
    
});



    });//end ready fn
</script>