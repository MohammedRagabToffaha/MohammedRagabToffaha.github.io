<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}

?>

<br>
<div class='row' id='hgzDiv'><label id='hgzLbl' data-toggle="modal" data-target="#AddNewReservation" 
  style="text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >إضافة حجز جديد</label></div>

<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/>

<div class='row' id='divReservDetails'><label id='ReservDetailsLbl' style="text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >تفاصيل الحجز</label></div>        
 
<div class="row" id="ReservationPrifDiv" style="padding-right:15px;padding-left:15px">
</div>
<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/>
 
 <div class='row' id='divReservationList'><label id='ReservationListLbl' style="text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >قائمة الحجز</label></div>

 <div class="row" id="ReservationListDiv" style="padding-right:15px;padding-left:15px">
</div>  
<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/> 

<div class='row' id='divAgelResev'><label id='AgelResevLbl' style="text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >آجل الحجز</label></div>

 <div class="row" id="ReservationAgelDiv" style="padding-right:15px;padding-left:15px">
</div>
<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;'/>




 <div class='row' id='AllReservDiv'><label id='AllReservLbl' 
  style="text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >إظهار كل الحجوزات السابقه</label></div>

<div class="row" id="AllReservationDivition" style="padding-right:15px;padding-left:15px">
</div>

<div class="modalReloadGifAddInv"></div> 
  
 


<div id="AddNewReservation" class="modal fade" style="z-index:100000000;overflow:auto;">
 <div class="modal-dialog modal-lg">
  <form method="post" id="AddNewReservation_form">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">إضافة حجز جديد</h4>
    </div>
<div class="modal-body">

    <div class="row" >
        <div class="col-lg-12" id="AddNewReservation_error" style="margin-bottom:10px;background-color:#E51C23;color:#fff"></div>
    </div>
    <div class="row" style="margin-top:0px">

     <div class="control-group col-md-6" >
        <div class="form-group">
            <label>اسم العميل</label>
            <input type="text" id="custNameInReservation" autocomplete="off" data-cndata="" class="form-control" placeholder="اسم العميل" />
            <div id="customerNameListReserv"></div>
        </div>
     </div>

     <div class="control-group col-md-6" >
        <div class="form-group">
            <label>حجز بمبلغ</label>
            <input type="text" id="ReservationAddMony" class="form-control" placeholder="المبلغ" />
        </div>
     </div>

     <div class="control-group col-md-6" >
        <div class="form-group">
            <label>المبلغ المدفوع</label>
            <input type="text" id="ReservationPaidMony" class="form-control" placeholder="المبلغ" />
        </div>
     </div>

     <div class="control-group col-md-6" >
        <div class="form-group">
            <label>تاريخ الاستلام</label>
            <input type="text" id="ReservationDeliverDate" class="form-control" placeholder="التاريخ" />
        </div>
     </div>

     <div class="control-group col-md-12" id="reservationRemainMonyDiv">
        <label id="reservationRemainMony" style="padding-left:20px;padding-right:20px;border-bottom: 1px #FBB900 solid;margin: 0 auto;background-color:#B80303;color:#fff"></label>
     </div>
     <!--  -->
     <div class="controls-row row">
                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label>الأصناف</label>
                        <select id="suppliers1" class="suppliers1 form-control">
                           
                        </select>
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label style="display:block;visibility:hidden">ط|ل</label>
                        <select name="categories1" id="categories1" class="categories1 form-control">
                            <option value="3">أطوال مشرشر</option>
                            <option value="4">لفف</option>
                        </select>
                    </div>
                </div>

                <div class="control-group col-lg-2 col-md-4 col-sm-4">
                    <div class="form-group">
                        <label style="display:block;visibility:hidden">مل|لينيه</label>
                        <select id="measure1" class="measure1 form-control" >
                            <option value="">أختار</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                  
                        <div class="form-group">
                            <label>الكميه</label>
                            <div class="input-group">
                                <input type="text" id="quantity1" class="form-control" />
                                <span class="input-group-btn">
                                    <select id="weight1" class="btn">
                                        <option value="0">طن</option>
                                        <option value="1">كيلو</option>
                                    </select>
                                 </span>

                            </div>
                          </div>
                   </div>
               <div class="control-group col-lg-1">
                 
                </div> 
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>سعر حجز الطن</label>
                        <div class="input-group">
                            <input type="text" id="unitcost1" class="form-control" />
                            <span class="input-group-btn">
                                <input type="button" id="addCat1" value="+" class="btn" />
                            </span>
                           
                        </div>
                    </div>
                </div>
                                       
            </div>

     <!--  -->
<hr style="width: 100%; color: #B80303; height: 1px; background-color:#B80303;" />
                  <div class="controls-row row ">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                  <table style='width:100%' class="table table-bordered" id="addItemsToReservation_table">
                                    <thead>
                                     <tr style="background-color: #B80303;color: #fff">
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
     <!--  -->

        

    </div>

        <div class="modal-footer">
         <input type="hidden" name="Stock_id" id="Stock_id" />
         <input type="hidden" name="operationStock" id="operationStock" />
         <input type="submit" id="addNewReservation" name="addNewReservation" value="إضافه"  
         style="float:left;text-align:center;height:35px;width:200px;line-height: 30px;padding-right:35px;padding-left:30px"> 
        </div>
       </div>
      </form>
     </div>
     <div class="modalReloadGifAddInv"></div> 
    </div>     
  </div>   

  <script type="text/javascript">
$(document).ready(function(){
    $("#categories1").change(function(){
            var cat_ID=$(this).val();
            var supp_ID=$('#suppliers1').val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataTyoe:"text",
                success:function(data){
                    $("#measure1").html(data);
                }
            });
        });
        $("#suppliers1").change(function(){
            var cat_ID=$("#categories1").val();
            var supp_ID=$(this).val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataTyoe:"text",
                success:function(data){
                    $("#measure1").html(data);
                }
            });
        });

      //autocompleate text input
           $('#custNameInReservation').on('keyup',function(){  
               var query = $(this).val();  
               if(query != '')  
               {  
                    $.ajax({  
                         url:"searchInTextInputForReservation.php",  
                         method:"POST",  
                         data:{query:query},  
                         success:function(data)  
                         {  
                              $('#customerNameListReserv').fadeIn();  
                              $('#customerNameListReserv').html(data);  
                         }  
                    });  
               }  
            }); 

        $('#custNameInReservation').on('blur',function(){
          $('#customerNameListReserv').fadeOut();
            });


          $(document).on('click', 'ul.ulForReservation li', function(){  
               $('#custNameInReservation').val($(this).text());  
               $('#custNameInReservation').attr('data-cndata',$(this).attr('data-custIDForReservation'));  
               $('#customerNameListReserv').fadeOut();  
          }); 
//remain mony
$('#ReservationAddMony').on('keyup',function(){ 
    var remain;
    if ($.isNumeric($('#ReservationAddMony').val())) {
        if ($('#ReservationPaidMony').val()=="") {
             remain="المبلغ المتبقي "+Number($("#ReservationAddMony").val()).toLocaleString()+ " جنيه";
            $('#reservationRemainMony').text(remain);
        }else{
            var r=$('#ReservationAddMony').val()-$('#ReservationPaidMony').val();
             remain="المبلغ المتبقي "+Number(r).toLocaleString();+ " جنيه";
            $('#reservationRemainMony').text(remain);
        }
    }
});
$('#ReservationPaidMony').on('keyup',function(){ 
 var remain;
    if ($.isNumeric($('#ReservationPaidMony').val())) {
        if ($('#ReservationAddMony').val()=="") {
            
        }else{
            var r=$('#ReservationAddMony').val()-$('#ReservationPaidMony').val();
             remain="المبلغ المتبقي "+Number(r).toLocaleString()+ " جنيه";
            $('#reservationRemainMony').text(remain);
        }
    }
});

//reset
  $('#hgzLbl').click(function(){
        $.ajax({    
            type: "GET",
            url: "allSupp.php",             
            dataType: "html",   //expect html to be returned                
            success: function(data){                    
                $("#suppliers1").html(data); 
                //alert(response);
            }

        });
      $('#AddNewReservation_form')[0].reset();
      $("#measure1").val("");
      $("#ReservationDeliverDate").datepicker("setDate", new Date());

      $("#addItemsToReservation_table tr:gt(0)").remove();
      $("#AddNewReservation_error").html("");
      $("#reservationRemainMony").html("");
  }); 

  //add items to reservation table
             var counter = 1;
             $('#addCat1').click(function(){
                var supp=$("#suppliers1").val();
                var cat=$("#categories1").val();
                var measure=$("#measure1").val();
                var quantity=$("#quantity1").val().length;
                var unitcost=$("#unitcost1").val().length;

                if (!supp||!cat||!measure||unitcost==0) {
                   $("#AddNewReservation_error").html("يجب ادخال جميع الحقول");
                   
                }
                 else if((quantity!=0)&&(!$.isNumeric($("input#quantity1").val()))){
                    $("#AddNewReservation_error").html("ادخل الكميه ارقام وليس حروف");
                  
                }
                  else if(!$.isNumeric($("input#unitcost1").val())){
                    $("#AddNewReservation_error").html("ادخل سعر البيع للطن ارقام وليس حروف");
                    
                }
                else{
                 
                                     
                    var itemAmount;
                    var itemAmount1;
                    var q;
                    var qq;
                    if (quantity!=0) {
                        q=$("#quantity1").val();
                        qq=$("#quantity1").val();
                        if ($("#weight1 option:selected").html()=="طن") {
                         itemAmount=Number(($("#quantity1").val())*($("#unitcost1").val())).toLocaleString();
                         itemAmount1=($("#quantity1").val())*($("#unitcost1").val());
                        }else{
                            itemAmount=Number(($("#quantity1").val()/1000)*($("#unitcost1").val())).toLocaleString();
                            itemAmount1=($("#quantity1").val()/1000)*($("#unitcost1").val());
                        }
                    }else{
                        itemAmount="ـــــــ";
                        itemAmount1=0;
                        q=0;
                        qq="ـــــــ";
                    }
                  
                    var unitcost=Number($("#unitcost1").val()).toLocaleString();
                   
                   counter = counter + 1;
                   var html_code = "<tr id='row"+counter+"'>";
                   html_code += "<td  class='cat_suppliers1' data-supID='"+$("#suppliers1").val()+"'>"+$("#suppliers1 option:selected").html()+"</td>";
                   html_code += "<td  class='cat_type1' data-catID='"+$("#categories1").val()+"'>"+$("#categories1 option:selected").html()+"</td>";
                   html_code += "<td  class='cat_measure1' data-measID='"+$("#measure1").val()+"'>"+$("#measure1 option:selected").html()+"</td>";
                   html_code += "<td  class='quantatiy1' data-qant='"+q+"' >"+qq+"</td>";
                   html_code += "<td  class='quantatiy_type1' data-weight='"+$("#weight1").val()+"'>"+$("#weight1 option:selected").html()+"</td>";
                   html_code += "<td  class='unit_price1' data-price='"+$("#unitcost1").val()+"'>"+unitcost+"</td>";
                   html_code += "<td  class='All_price1' data-amount='"+itemAmount1+"'>"+itemAmount+"</td>";
                   html_code += "<td><button type='button' name='remove1' data-row='row"+counter+"' class='btn btn-danger btn-xs remove1'>-</button></td>";   
                   html_code += "</tr>";  
                   $('#addItemsToReservation_table').append(html_code);

                    $("#quantity1").val("");
                    $("#unitcost1").val("");
                  
               
               }
                

             });
             //remove row
             $(document).on('click', '.remove1', function(){
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
             
             });
 
//Add new reservation
$(document).on('submit', '#AddNewReservation_form', function(event){
    event.preventDefault();
     var csID=$('#custNameInReservation').attr('data-cndata');
     var csName=$('#custNameInReservation').val();
     var ReservationAddMony=$('#ReservationAddMony').val();
     var ReservationDeliverDate=$('#ReservationDeliverDate').val();
     var ReservationPaidMony=$('#ReservationPaidMony').val();

    if (csID==""||csName=="") {
        $("#AddNewReservation_error").html("يجب ادخال اسم العميل");
    }else if (ReservationAddMony=="") {
        $("#AddNewReservation_error").html("يجب ادخال مبلغ الحجز");
    }else if (ReservationAddMony!="" && !$.isNumeric(ReservationAddMony)) {
        $("#AddNewReservation_error").html("يجب ادخال مبلغ الحجز ارقام وليس حروف");
    }else if (ReservationDeliverDate=="") {
        $("#AddNewReservation_error").html("يجب ادخال تاريخ الاستلام");
    }else if (ReservationDeliverDate!="" && !isValidDate(ReservationDeliverDate.toString())) {
        $("#AddNewReservation_error").html("يجب ادخال تاريخ الاستلام بصيغه صحيحه");
    }else if (ReservationPaidMony=="") {
        $("#AddNewReservation_error").html("يجب ادخال المبلغ المدفوع");
    }else if (ReservationPaidMony!="" && !$.isNumeric(ReservationPaidMony)) {
        $("#AddNewReservation_error").html("يجب ادخال المبلغ المدفوع ارقام وليس حروف");
    }else if ($("#addItemsToReservation_table tr").length < 2) {
        $("#AddNewReservation_error").html("يجب ادخال الاصناف");
    }else{
        var supID=[];
        var catID=[];
        var measID=[];
        var qant=[];
        var weight=[];
        var price=[];

         $('.cat_suppliers1').each(function(){
           supID.push($(this).attr("data-supID"));
          }); 
         $('.cat_type1').each(function(){
           catID.push($(this).attr("data-catID"));
          });
           $('.cat_measure1').each(function(){
           measID.push($(this).attr("data-measID"));
          }); 
           $('.quantatiy1').each(function(){
           qant.push($(this).attr("data-qant"));
          });
           $('.quantatiy_type1').each(function(){
           weight.push($(this).attr("data-weight"));
          });
           $('.unit_price1').each(function(){
           price.push($(this).attr("data-price"));
          });

           $("body").addClass("loadingAddInv");
            $.ajax({
                url:"insertNewReservation.php",
                method:'POST',
                data:{csID:csID,csName:csName,ReservationAddMony:ReservationAddMony,ReservationPaidMony:ReservationPaidMony,
                    ReservationDeliverDate:ReservationDeliverDate,supID:supID,catID:catID,measID:measID,
                    qant:qant,weight:weight,price:price},
                success:function(data)
                {
                    if (data=="error") {
                        $("#AddNewReservation_error").html("اعد تحميل الصفحه مره اخرى");
                    }else if (data=="error1") {
                        $("#AddNewReservation_error").html("اسم العميل غير موجود يمكن اضافة العميل بالضغط على زر اضافة عميل جديد ");    
                    }else{
                        $('#AddNewReservation_form')[0].reset();
                        $('#AddNewReservation').modal('hide');

     $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchReservation.php",
        method:'POST',
        data:{'uniq_param' : (new Date()).getTime()},
        success:function(data)
        {

         $("#ReservationListDiv").html(data);                   
        },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
         
       });
                    }
                },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
 });

    }
}); 

//show reservation 
$(document).on('click', '#ReservationListLbl', function(event){
  $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchReservation.php",
        method:'POST',
        data:{'uniq_param' : (new Date()).getTime()},
        success:function(data)
        {

         $("#ReservationListDiv").html(data);                   
        },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
         
       });
});
//show reservation agel 
$(document).on('click', '#AgelResevLbl', function(event){
   $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchReservationAgel.php",
        method:'POST',
        data:{'uniq_param' : (new Date()).getTime()},
        success:function(data)
        {

         $("#ReservationAgelDiv").html(data);                   
        },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
         
       });
});

//show reservation pref 
$(document).on('click', '#ReservDetailsLbl', function(event){
  $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchReservationPrif.php",
        method:'POST',
        data:{'uniq_param' : (new Date()).getTime()},
        success:function(data)
        {

         $("#ReservationPrifDiv").html(data);                   
        },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
         
       });
});




  });  //end ready fn  

  function isValidDate(s) {
  var bits = s.split('-');
  var d = new Date(bits[0] + '-' + bits[1] + '-' + bits[2]);
  return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]));
}  
  </script>