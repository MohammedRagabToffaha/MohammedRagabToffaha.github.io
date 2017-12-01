  
        

            function convertTotenAndKelo(value){
               var stockAfter;
               var stockBefore=value;
               if (stockBefore >= 1000) {
                var kelo=stockBefore%1000;
                var ten=(stockBefore-kelo)/1000;

                if (kelo==0) {
                  stockAfter=ten+" طن";
                }else{
                  stockAfter=ten+" طن" +" و "+kelo+" كيلو";
                }

               }else{
                stockAfter=stockBefore+" كيلو";
               }
               return stockAfter;
          }

             function checkAvailableUnitInStock(){
                 var supp=$("#suppliers").val();
                var cat=$("#categories").val();
                var measure=$("#measure").val();
                //var quantity=$("#quantity").val().length;               
                if (supp&&cat&&measure) {
                    
                    $.ajax({
                       url:"checkAvailableInStock.php",
                       method:"POST",
                       data:{suppID:supp,catID:cat,measureID:measure},
                       dataType:"json",
                       success:function(data)
                       {
                        if (data=="") {
                          $("#unitInStockStatus").html("");
                          $("#unitInStockStatus").html("هذا المنتج غير موجود بالمخزن");
                        }else{
                          $("#unitInStockStatus").html("");
                          var datta=data;
                          if ($("#crud_table tr").length > 1) {
                            $('#crud_table tr').each(function() {
                              var supID = $(this).find('td').eq(0).attr("data-supID");
                              var catID = $(this).find('td').eq(1).attr("data-catID");
                              var measID = $(this).find('td').eq(2).attr("data-measID");
                              var qant = $(this).find('td').eq(3).attr("data-qant");
                              var weight = $(this).find('td').eq(4).attr("data-weight");
                              
                              if (supID==supp&&catID==cat&&measID==measure) {
                                if (weight==0) {
                                  datta=datta-(qant*1000);
                                }else{
                                  datta=datta-qant;
                                }
                                
                              }
                              
                            });
                             var $message="متاح "+convertTotenAndKelo(datta);
                             $("#unitInStockStatus").html($message);
                             $("#hidden").text(datta);
                          }else{
                            var $message="متاح "+convertTotenAndKelo(data);
                            $("#unitInStockStatus").html($message);
                           $("#hidden").text("");
                            $("#hidden").text(data);
                          }
                        
                        }
                          
                       }
                      });
                }else{
                  $("#unitInStockStatus").html("");
                }
             }


  $(function () {
    //reset input 
    $("#suppliers").val("");
    $("#categories").val("");
    $("#measure").val("");
    $("#discount").val("");

      $(document).on('submit', '#userdata_form', function(event){
       event.preventDefault();
      var username = $("#userdata_name").attr("data-username");
      var oldPasslength=$("#oldPass").val().length;
      var newPasslength=$("#newPass").val().length;
      var oldPass=$("#oldPass").val();
      var newPass=$("#newPass").val();

      if (oldPasslength==0||newPasslength==0) {
        
            $("#userdata_error").html("يجب ادخال كلمة السر القديمة والجديده");
        }else{
          $.ajax({
           url:"changePass.php",
           method:"POST",
           data:{username:username,oldPass:oldPass,newPass:newPass},
           success:function(data)
           {
            $("#userdata_error").html(data);
            $("#oldPass").val("");
            $("#newPass").val("");
           }
          });

        }

      
     });



     
        $('#orderDate').datepicker({
            dateFormat: 'yy-mm-dd'
        })
        $('#amountRemainDate').datepicker({
            dateFormat: 'yy-mm-dd'
        }) 
      
        $("#orderDate").datepicker("setDate", new Date());

         $('#suppReportSDate,#suppReportEDate,#custReportSDate,#custReportEDate,#msrofatReportSDate,#msrofatReportEDate,#mbe3atReportSDate,#mbe3atReportEDate,#PayRemainMonyDate').datepicker({
            dateFormat: 'yy-mm-dd'
        }) 
        
        
          var d = new Date();
          d.setMonth(d.getMonth() - 12);
          $("#suppReportSDate,#custReportSDate").datepicker('setDate',d);
         var dd = new Date();
          dd.setMonth(dd.getMonth() - 1);
          $("#msrofatReportSDate,#mbe3atReportSDate").datepicker('setDate',dd);


        $("#suppReportEDate,#custReportEDate,#msrofatReportEDate,#mbe3atReportEDate").datepicker("setDate", new Date());
        $("#PayRemainMonyDate").datepicker("setDate", new Date());

         $('#DailyReportDate').datepicker({
            dateFormat: 'yy-mm-dd'
        }) 
      
        $("#DailyReportDate").datepicker("setDate", new Date());

  var currentDate = new Date();
    var currenYear=currentDate.getFullYear();
    var currenMonth= currentDate.getMonth()+1;

//     var monthNames = ["January", "February", "March", "April", "May", "June",
//   "July", "August", "September", "October", "November", "December"
// ];


$('#SelectYearInMbe3atYearReport').val(currenYear);
$('#SelectYearInMbe3atYearMonthReport').val(currenYear);
$('#SelectMonthInMbe3atYearMonthReport').val(currenMonth);
$( "#mbe3atFtratMonthsReportLbl" ).text('الرسم البياني يوضح اكثر الشهور بيع خلال '+currenYear);
$( "#mbe3atFtratYearMonthsReportLbl" ).text('الرسم البياني يوضح اكثر الأيام بيع خلال سنة '+currenYear+" شهر "+currenMonth);
  

//////////////////////////////////////////////////////

              function check_session()
                   {
                      $.ajax({
                        url:"checkSession.php",
                        method:"POST",
                        success:function(data)
                        {
                          if(data == '1')
                          {
                            alert('سجل دخولك مرة اخرى');  
                            window.location.href="LoginCredintial.php";
                          }
                        }
                      })
                   }
            setInterval(function(){
              check_session();
            }, 10000);  //10000 means 10 seconds

   //////////////////////////////////////////////////////         

            //add categories to table
             var count = 1;
             $('#addCat').click(function(){
                var supp=$("#suppliers").val();
                var cat=$("#categories").val();
                var measure=$("#measure").val();
                var quantity=$("#quantity").val().length;
                var unitcost=$("#unitcost").val().length;

                if (!supp||!cat||!measure||quantity==0||unitcost==0) {
                   $("#myModalBody").html("يجب ادخال جميع الحقول");
                    $( "#myModal" ).modal('show');
                }
                 else if(!$.isNumeric($("input#quantity").val())){
                    $("#myModalBody").html("ادخل الكميه ارقام وليس حروف");
                    $( "#myModal" ).modal('show');
                }
                  else if(!$.isNumeric($("input#unitcost").val())){
                    $("#myModalBody").html("ادخل سعر البيع للطن ارقام وليس حروف");
                    $( "#myModal" ).modal('show');
                }
                else{
                 
                  var instock=$("#hidden").text();
                                     
                    var itemAmount;
                    if ($("#weight option:selected").html()=="طن") {
                         itemAmount=($("#quantity").val())*($("#unitcost").val());
                    }else{
                        itemAmount=($("#quantity").val()/1000)*($("#unitcost").val());
                    }
                    var unitcost=Number($("#unitcost").val()).toLocaleString();
                   
                   count = count + 1;
                   var html_code = "<tr id='row"+count+"'>";
                   html_code += "<td  class='cat_suppliers' data-supID='"+$("#suppliers").val()+"'>"+$("#suppliers option:selected").html()+"</td>";
                   html_code += "<td  class='cat_type' data-catID='"+$("#categories").val()+"'>"+$("#categories option:selected").html()+"</td>";
                   html_code += "<td  class='cat_measure' data-measID='"+$("#measure").val()+"'>"+$("#measure option:selected").html()+"</td>";
                   html_code += "<td  class='quantatiy' data-qant='"+$("#quantity").val()+"' >"+$("#quantity").val()+"</td>";
                   html_code += "<td  class='quantatiy_type' data-weight='"+$("#weight").val()+"'>"+$("#weight option:selected").html()+"</td>";
                   html_code += "<td  class='unit_price' data-price='"+$("#unitcost").val()+"'>"+unitcost+"</td>";
                   html_code += "<td  class='All_price' data-amount='"+itemAmount+"'>"+Number(itemAmount).toLocaleString()+"</td>";
                   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
                   html_code += "</tr>";  
                   $('#crud_table').append(html_code);

                    $("#quantity").val("");
                    $("#unitcost").val("");
                    $("#hidden").text("");
               
               }
                

             });
             //remove row
             $(document).on('click', '.remove', function(){
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
              checkAvailableUnitInStock();
             });


        ////check available unitinstock
             
              $("#weight").on('change',function(){
                checkAvailableUnitInStock();
              });

              $("#gard").on('click',function(){
                checkAvailableUnitInStock();
              });
             $('#quantity').on('keyup keypress blur change',function(){  
                checkAvailableUnitInStock();
              });


                //add other fees to table
             var countfees = 1;
             $('#addFees').click(function(){
                var otherfeestext=$("#otherfeestext").val().length;
                var otherfeesdetails=$("#otherfeesdetails").val().length;
                var otherfeestextcheck=$("input#otherfeestext").val();
                
                
                if (otherfeestext==0||otherfeesdetails==0) {
                   $("#myModalBody").html("ادخل المبلغ وسبب الصرف");
                    $( "#myModal" ).modal('show');
                }
                else if(!$.isNumeric(otherfeestextcheck)){
                    $("#myModalBody").html("ادخل المبلغ ارقام وليس حروف");
                    $( "#myModal" ).modal('show');
                }
                else{
                  $('#otherFees_table_div').css('display','block');
                   var otherFees=Number($("#otherfeestext").val()).toLocaleString();                
                   countfees = countfees + 1;
                   var html_code = "<tr id='rowfees"+countfees+"'>";
                   html_code += "<td  class='fees_mony' data-otherFees='"+$("#otherfeestext").val()+"'>"+otherFees+"</td>";
                   html_code += "<td  class='fees_details'>"+$("#otherfeesdetails").val()+"</td>";
                   html_code += "<td><button type='button' name='removefees' data-rowfees='rowfees"+countfees+"' class='btn btn-danger btn-xs removefees'>-</button></td>";   
                   html_code += "</tr>";  
                   $('#cotherFees_table').append(html_code);
                   $("#otherfeestext").val("");
                   $("#otherfeesdetails").val("");
                }

             
             });
             //remove row
             $(document).on('click', '.removefees', function(){
              var delete_row = $(this).data("rowfees");
              $('#' + delete_row).remove();
             });

             //add otherservices to table
             var countservice = 1;
             $('#Addotherservices').click(function(){
                var otherservicesAmount=$("#otherservicesAmount").val().length;
                var otherservicesdetails=$("#otherservicesdetails").val().length;
                var otherservicesAmountcheck=$("input#otherservicesAmount").val();
                
                
                if (otherservicesAmount==0||otherservicesdetails==0) {
                   $("#myModalBody").html("ادخل المبلغ وسبب الخدمة");
                    $( "#myModal" ).modal('show');
                }
                else if(!$.isNumeric(otherservicesAmountcheck)){
                    $("#myModalBody").html("ادخل المبلغ ارقام وليس حروف");
                    $( "#myModal" ).modal('show');
                }
                else{

                   $('#otherservices_table_div').css('display','block');
                   var otherservices=($("#otherservicesAmount").val());                   
                   countservice = countservice + 1;
                   var html_code = "<tr id='rowsevice"+countservice+"'>";
                   html_code += "<td  class='service_mony' data-otherservicesAmount='"+$("#otherservicesAmount").val()+"'>"+Number(otherservices).toLocaleString()+"</td>";
                   html_code += "<td  class='service_details'>"+$("#otherservicesdetails").val()+"</td>";
                  
                   html_code += "<td><button type='button' name='removeservice' data-rowservice='rowsevice"+countservice+"' class='btn btn-danger btn-xs rowsevice'>-</button></td>";   
                   html_code += "</tr>";  
                   $('#otherservices_table').append(html_code);
                   $("#otherservicesAmount").val("");
                   $("#otherservicesdetails").val("");
                }

             
             });
             //remove row
             $(document).on('click', '.rowsevice', function(){
              var delete_row = $(this).data("rowservice");
              $('#' + delete_row).remove();
             });

           
             //empty div
  $(document).on('click','#add_button',function(event){
    $("#cust_error").text("");
    $('#user_form')[0].reset();
    $('#operation').val("Add");
    $('.modal-title').text("إضافة عميل");
    $('#addCust').val("إضافه");


  });
   $(document).on('click','#addNewCustomer',function(event){
    $("#cust_error").text("");
    $('#user_form')[0].reset();
    $('#operation').val("Add");
    $('.modal-title').text("إضافة عميل");
    $('#addCust').val("إضافه");


  });
             
            //show datatable withen table
            var dataTable = $('#user_data').DataTable({
    "language": {
        "sProcessing":    "جاري التحميل...",
        "sLengthMenu":    "اظهار عدد :  _MENU_ عميل",
        "sZeroRecords":   "لا يوجد عملاء ادخل عميل جديد",
        "sEmptyTable":    "لا يوجد عملاء ادخل عميل جديد",
        "sInfo":          "عدد العملاء الكلي _TOTAL_ عميل",
        "sInfoEmpty":     "عدد العملاء صفر عميل",
        "sInfoFiltered":  "",
        "sInfoPostFix":   "",
        "sSearch":        "البحث عن عميل: ",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "تحميل...",
        "oPaginate": {
            "sFirst":    "الاول",
            "sLast":    "الاخير",
            "sNext":    "الصفحة التالية",
            "sPrevious": "الصفحة السابقة"
        },
        "oAria": {
            "sSortAscending":  "",
            "sSortDescending": ""
        }
    },
  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

       
    },

                "processing":true,
                
                "order":[],
               
                "ajax":{
                 url:"fetchCustomers.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3],
                  "orderable":false,
                 },
                ],

               });
  

    //////////add new customer
              $(document).on('submit', '#user_form', function(event){
              event.preventDefault();
              var custName = $('#custName').val();
              var phoneNumber = $('#phoneNumber').val();
              var custAddress = $('#custAddress').val();
            
              if(custName != '')
              {
               $.ajax({
                url:"insertCustomer.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                //alert(data);
                if ($.trim(data)==='error') {
                  $("#cust_error").text("العميل موجود بالفعل، ادخل اسم اخر");
                 
                }else if ($.trim(data)==='error1'){
                  $("#cust_error").text("العميل موجود بالفعل، ادخل اسم اخر");
                }else{
                  $('#user_form')[0].reset();
                 $('#userModal').modal('hide');
                 dataTable.ajax.reload();
                }

                 
                }
               });
              }
              else
              {
               $("#cust_error").text("يجب ادخال اسم العميل");
              }
              });

///////////////update customer
 $(document).on('click', '.update', function(){
  $("body").addClass("loadingAddInv");
  var cust_id = $(this).attr("id");
  $.ajax({
   url:"fetch_single_customer.php",
   method:"POST",
   data:{cust_id:cust_id},
   dataType:"json",
   success:function(data)
   {
    $('#userModal').modal('show');
    $('#custName').val(data.custName);
    $('#phoneNumber').val(data.custPhone);
    $('#custAddress').val(data.custAddress);

    $('.modal-title').text("تعديل بيانات عميل");
    $('#cust_id').val(cust_id);
    $('#addCust').val("تعديل");
    $('#operation').val("Edit");
    $("#cust_error").text("");
   },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
  })
 });



      //show measures datatable withen table
          var SuppliersdataTable = $('#SuppliersTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sEmptyTable":    "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },

  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

       
    },
                "processing":true,
                
                "bFilter": false,
                "bLengthChange": false,
                "bPaginate": false,
                "iDisplayLength": 200,
               
                "order":[],
               "bInfo" : false,
               
                "ajax":{
                 url:"fetchSuppliers.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2],
                  "orderable":false
                 },
                ],
                

               });
  
   //show suppNames datatable withen table
          var SuppNamesdataTable = $('#ItemsTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sEmptyTable":    "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },

  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

       
    },
               "processing":true,
               
                "bFilter": false,
                "bLengthChange": false,
                "bPaginate": false,
                "iDisplayLength": 200,
               
                "order":[],
               "bInfo" : false,
               
                "ajax":{
                 url:"fetchSuppNames.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0],
                  "orderable":false
                 },
                ],
                

               });
  

    //////////add new supplyers or compny
              $(document).on('submit', '#form_supp', function(event){
              event.preventDefault();
              var typeInSuppliers = $('#typeInSuppliers').val();
                         
              if(typeInSuppliers != '')
              {
               $.ajax({
                url:"insertSupplyer.php",
                method:'POST',
                data:{typeInSuppliers:typeInSuppliers},
                // contentType:false,
                // processData:false,
                success:function(data)
                {
                
                if (data=='error') {
                   $("#myModalBody").html("هذا الصنف موجود بالفعل أدخل صنف اخر");
                 $( "#myModal" ).modal('show');
                }else{

                 $('#typeInSuppliers').val("");
                SuppNamesdataTable.ajax.reload();
                 getSupplayers();
                 //SuppliersdataTable.ajax.reload();
                }

                 
                }
               });
              }
              else
              {
                $("#myModalBody").html("ادخل الصنف!!");
                 $( "#myModal" ).modal('show');
              }
              });


  /////////add new measure
              $(document).on('submit', '#form_meas', function(event){
              event.preventDefault();
              var SelectTypeInSuppliers = $('#SelectTypeInSuppliers').val();
              var SelectCatInSuppliers = $('#SelectCatInSuppliers').val();
              var measureInSuppliers = $('#measureInSuppliers').val();

              var oper;
              var measure_id;
              if ($('#add_CatInS').val()=="+") {
                oper="add";
                measure_id="";
              }else{
                oper="edit";
                measure_id=$('#measure_id').val();
              }


            
              if(measureInSuppliers != '')
              {
               $.ajax({
                url:"insertMeasure.php",
                method:'POST',
                data:{oper:oper,measure_id:measure_id,SelectTypeInSuppliers:SelectTypeInSuppliers,SelectCatInSuppliers:SelectCatInSuppliers,measureInSuppliers:measureInSuppliers},
              
                success:function(data)
                {
                  SuppliersdataTable.ajax.reload();
                
                if (data=='error') {
                   $("#myModalBody").html("هذا المنتج موجود بالفعل أدخل منتج اخر");
                 $( "#myModal" ).modal('show');
                }else{

                 $('#measureInSuppliers').val("");
                 $('#add_CatInS').val("+");
                 ('#measure_id').val("");
                
                
                 
                }

                 
                }
               });
              }
              else
              {
                $("#myModalBody").html("ادخل المقاس!!");
                 $( "#myModal" ).modal('show');
              }
              });




function getSupplayers(){
     $.ajax({    
        type: "GET",
        url: "allSupp.php",             
        dataType: "html",   //expect html to be returned                
        success: function(data){                    
            $("#SelectTypeInSuppliers").html(data); 
            //alert(response);
        }

    });
}
function getStockItems(){
     $.ajax({    
        type: "GET",
        url: "allSupp.php",             
        dataType: "html",   //expect html to be returned                
        success: function(data){                    
            $("#SelectTypeInStock").html(data); 
            //alert(response);
        }

    });
}
function getMortg3AwelElmodaItems(){
     $.ajax({    
        type: "GET",
        url: "allSupp.php",             
        dataType: "html",   //expect html to be returned                
        success: function(data){                    
            $("#mortg3AwelElmodasuppliers").html(data); 
            //alert(response);
        }

    });
}

function getStockMoredeen(divElemID){
     $.ajax({    
        type: "GET",
        url: "allMordeen.php",             
        dataType: "html",   //expect html to be returned                
        success: function(data){                    
            $(divElemID).html(data); 
            //alert(response);
        }

    });
}
function getStockNwloon(divElemID){
     $.ajax({    
        type: "GET",
        url: "allNwloon.php",             
        dataType: "html",   //expect html to be returned                
        success: function(data){                    
            $(divElemID).html(data); 
            //alert(response);
        }

    });
}

$("#AddStockBtn").click(function(){
    getStockItems();
    getStockMoredeen("#SelectMoredStock");
    getStockNwloon("#SelectNawloonStock");
    $("#Stock_error").html("");

    $('#AddStock_form')[0].reset();
    $('#operationStock').val("Add");
    $('.stockModalTitle').text("إضافة طلبيه");
     $("#AddedDate").attr("placeholder","تاريخ الشراء");
    $('#addStock').val("إضافه");

});


$(window).load(function () {
  getSupplayers();
getStockMoredeen("#SelectMoredName");
getStockNwloon("#SelectNawloonStock");
getMortg3AwelElmodaItems();
});


//////////////update measure

 $(document).on('click', '.editInSuppliers', function(){

  

  var measID = $(this).attr("id");
  $.ajax({
   url:"fetch_single_Measure.php",
   method:"POST",
   data:{measID:measID},
   dataType:"json",
   success:function(data)
   {
    $('#SelectTypeInSuppliers').val(data.suppID);
    $('#SelectCatInSuppliers').val(data.catID);
    $('#measureInSuppliers').val(data.measName);

    $('#measure_id').val(measID);
    $('#add_CatInS').val("تعديل");
    // $('#SelectTypeInSuppliers,#SelectCatInSuppliers,#measureInSuppliers').css('background-color','#DCDCDC');
    // $('#add_CatInS').css('background-color','#844D9E');
    // $('#add_CatInS').css('color','white');
  
   }
  })
 });

  $(document).on('click', '.removeInSuppliers', function(){
  var measID = $(this).attr("id");
 
  $('#confirm').modal({
      backdrop: 'static',
      keyboard: false
    })
    .one('click', '#delete', function(e) {

     $.ajax({
     url:"remove_single_Measure.php",
     method:"POST",
     data:{measID:measID},
     dataType:"json",
     success:function(data)
     {
      SuppliersdataTable.ajax.reload();
      if (data=="error") {
        alert("حدث خطأ في المسح، حاول مره اخري.....");
      }
   
     }
    })
     SuppliersdataTable.ajax.reload();
    });



 });





 }); 

  ///////////add invoice no. to text input in page LoadingRecords
  $(window).load(function () {
      $.ajax({
           url:"loadInvoiceNo.php",
           method:"POST",
           success:function(data)
           {
            if (data=="") {
              $('#orderNo').val('F-0000001');
            }else{
              $('#orderNo').val(data);
            }
              
           }
          })
  });

$(function(){

  var StockDatatable = $('#StockTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sEmptyTable":    "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
   "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

       
    },


                "processing":true,
               
                "bFilter": false,
                "bLengthChange": false,
                "bPaginate": false,
                "iDisplayLength": 100,
               
                "order":[],
               "bInfo" : false,
                "ajax":{
                 url:"fetchStock.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3,4],
                  "orderable":false
                 },
                ],
                

               });
  



$("#SelectCatInStock").change(function(){
            var cat_ID=$(this).val();
            var supp_ID=$('#SelectTypeInStock').val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataType:"text",
                success:function(data){
                    $("#SelectMeasInStock").html(data);
                }
            });
        });
        $("#SelectTypeInStock").change(function(){
            var cat_ID=$("#SelectCatInStock").val();
            var supp_ID=$(this).val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataType:"text",
                success:function(data){
                    $("#SelectMeasInStock").html(data);
                }
            });
        });



$('#AddedDate').datepicker({
            dateFormat: 'yy-mm-dd'
        })
$('#ReservationDeliverDate').datepicker({
            dateFormat: 'yy-mm-dd'
        })

////add new talbya
              $(document).on('submit', '#AddStock_form', function(event){
              event.preventDefault();
              var SelectTypeInStock = $('#SelectTypeInStock').val();
              var SelectCatInStock = $('#SelectCatInStock').val();
              var SelectMeasInStock = $('#SelectMeasInStock').val();
              var QuantAddedToStock = $('#quantityInStock').val();
              var DateAddedToStock = $('#AddedDate').val();
              var unitPriceForStock = $('#unitPriceForStock').val();
              var SelectMoredStock = $('#SelectMoredStock').val();

              var operationStock = $('#operationStock').val();
              var nwloonID = $('#SelectNawloonStock').val();
              var unitPriceForNawloonStock = $('#unitPriceForNawloonStock').val();
              if (nwloonID !="0" && unitPriceForNawloonStock=="") {
                $("#Stock_error").html("ادخل سعر النقل للطن الواحد! أو اجعل الأختيار هو شركة النقل والناولون");
                return;
              }
              if (unitPriceForNawloonStock!=""&& !$.isNumeric(unitPriceForNawloonStock)) {
                $("#Stock_error").html("ادخل سعر النقل للطن الواحد ارقام وليس حروف!!");
                return;
              }
              if (nwloonID =="0" && unitPriceForNawloonStock!="") {
                $("#Stock_error").html("أختار شركة النقل والناولون او أترك السعر بدون ادخال");
                return;
              }

          
               if(SelectTypeInStock != ''&&SelectCatInStock != ''&&SelectMeasInStock != ''&&QuantAddedToStock != ''&&DateAddedToStock != '')
              {
                if ($.isNumeric(QuantAddedToStock)&&$.isNumeric(unitPriceForStock)) {
                  $("body").addClass("loadingAddInv");
                   $.ajax({
                    url:"insertTalbya.php",
                    method:'POST',
                    // data:new FormData(this),
                    // contentType:false,
                    // processData:false,

                    data:{operationStock:operationStock,SelectTypeInStock:SelectTypeInStock,SelectCatInStock:SelectCatInStock,SelectMeasInStock:SelectMeasInStock
                      ,DateAddedToStock:DateAddedToStock,unitPriceForStock:unitPriceForStock,
                      SelectMoredStock:SelectMoredStock,QuantAddedToStock:QuantAddedToStock,nwloonID:nwloonID,
                      unitPriceForNawloonStock:unitPriceForNawloonStock},
                  
                      success:function(data)
                      {
                       
                         $('#AddStock_form')[0].reset();
                       $('#AddStockModal').modal('hide');
                       $("body").removeClass("loadingAddInv");
                       
                        StockDatatable.ajax.reload();
                        StockDetailsDatatable.ajax.reload();
                        AllTlbyatTable.ajax.reload();
                                    
                      }
                   });
                }
                else{
                  $("#Stock_error").html("ادخل الكمية وسعر الشراء للطن ارقام وليس حروف!!");
                }

               }
              else
              {
                $("#Stock_error").html("ادخل جميع الحقول!!");
                 
              }

           
        
           
              });

//stock Details

 var StockDetailsDatatable = $('#StockDetailsTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sEmptyTable":    "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

             switch(aData[0]){
            case 'أجمالي الموجود بالمخزن':
                $(nRow).css('color', 'red');
                $(nRow).css('background-color', '#FBB900');
                break;
            case 'BBBB':
                $(nRow).css('color', 'green')
                break;
           
        }
    },

                "processing":true,
               
                "bFilter": false,
                "bLengthChange": false,
               "bPaginate": false,
                "iDisplayLength": 200,
                "order":[],
                "bInfo" : false,
              
               
                "ajax":{
                 url:"fetchStockDetails.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1],
                  "orderable":false
                 },
                ],
                

               });

  //show tlbyat table
var AllTlbyatTable = $('#AllTlbyatTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد مبالغ تم ايداعها فى حسابات الموردين",
                    "sEmptyTable":    "لا يوجد مبالغ تم ايداعها فى حسابات الموردين",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

         },

               

                "processing":true,
                "bFilter": false,
                "bLengthChange": false,
                "iDisplayLength": 15,
                "order":[],
               "bInfo" : false,
              
               
                "ajax":{
                 url:"fetchTlbyat.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3,4,5,6,7,8],
                  "orderable":false
                 },
                ],
                

               });


 

////Add new mored
  $(document).on('submit', '#form_Mordeen', function(event){
              event.preventDefault();
              var moredName = $('#moredName').val();
              var moredPhone = $('#moredPhone').val();
              var moredBankID = $('#moredBankID').val();
          
            if(moredName!= ''&&moredBankID!= '')
              {
               $.ajax({
                url:"insertMored.php",
                method:'POST',
                // data:new FormData(this),
                // contentType:false,
                // processData:false,
                

                data:{moredName:moredName,moredPhone:moredPhone,moredBankID:moredBankID},
                
                success:function(data)
                {
                 if (data=="error") {
                     $("#myModalBody").html("هذا المورد موجود بالفعل أدخل مورد اخر");
                     $( "#myModal" ).modal('show');
                 }else{
                   $('#form_Mordeen')[0].reset();
                   MordeenDatatable.ajax.reload();
                 }
                  
                              
                }
               });
              }
              else
              {
                 $("#myModalBody").html("ادخل وكيل الشراء ورقم الحساب البنكي!!");
                 $( "#myModal" ).modal('show');
              }
           
              });
//show mordeen table
var MordeenDatatable = $('#MordeenTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sEmptyTable":    "لا يوجد موردين ادخل مورد او شركة جديدة",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

         },

                "processing":true,
               
                "bFilter": false,
                "bLengthChange": false,
               "bPaginate": false,
                "iDisplayLength": 200,
                "order":[],
                "bInfo" : false,
              
               
                "ajax":{
                 url:"fetchMordeen.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2],
                  "orderable":false
                 },
                ],
                

               });


  ////Add new Nawloon
  $(document).on('submit', '#form_Nawloon', function(event){
              event.preventDefault();
              var nwloonName = $('#nwloonName').val();
              var nwloonPhone = $('#nwloonPhone').val();
          
          if (nwloonName!= '') {
              $.ajax({
                url:"insertNawloon.php",
                method:'POST',
                // data:new FormData(this),
                // contentType:false,
                // processData:false,
                

                data:{nwloonName:nwloonName,nwloonPhone:nwloonPhone},
                
                success:function(data)
                {
                 
                   $('#form_Nawloon')[0].reset();
                   NawloonDatatable.ajax.reload();
                              
                }
               });
             
            }else{
               $("#myModalBody").html("ادخل اسم الشركة او السائق!!");
               $( "#myModal" ).modal('show');
            }
        
           
              });


  //show mordeen table
var NawloonDatatable = $('#NawloonTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد شركات نقل ادخل  شركة جديدة",
                    "sEmptyTable":    "لا يوجد شركات نقل ادخل  شركة جديدة",
                    "sInfo":          "عدد شركات نقل الكلية _TOTAL_ شركة",
                    "sInfoEmpty":     "عدد شركات نقل صفر شركة",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن شركة: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

         },

                "processing":true,
               
                "bFilter": false,
                "bLengthChange": false,
               "bPaginate": false,
                "iDisplayLength": 200,
                "order":[],
                "bInfo" : false,
              
               
                "ajax":{
                 url:"fetchNawloon.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3],
                  "orderable":false
                 },
                ],
                

               });


   ////Add new arbta
  $(document).on('submit', '#form_arbta', function(event){
              event.preventDefault();
              var arbtaCustName = $('#arbtaCustName').val();
              var arbtaQuantity = $('#arbtaQuantity').val();
              var arbtaUnitCost = $('#arbtaUnitCost').val();

              if (!$.isNumeric(arbtaQuantity)) {
               $("#myModalBody").html("ادخل الوزنه بالكيلو أرقام وليس حروف!");
               $( "#myModal" ).modal('show');
               return;
              }
               if (!$.isNumeric(arbtaUnitCost)) {
               $("#myModalBody").html("ادخل سعر البيع للكيلو أرقام وليس حروف!");
               $( "#myModal" ).modal('show');
               return;
              }
          
          if (arbtaCustName!= '') {
              $.ajax({
                url:"insertArbta.php",
                method:'POST',
               
                data:{arbtaCustName:arbtaCustName,arbtaQuantity:arbtaQuantity,arbtaUnitCost:arbtaUnitCost},
                
                success:function(data)
                {
                 
                   $('#form_arbta')[0].reset();
                   arbtaTable.ajax.reload();
                              
                }
               });
             
            }else{
               $("#myModalBody").html("ادخل اسم المشتري!");
               $( "#myModal" ).modal('show');
            }
        
           
              });

   //show rbth table
var arbtaTable = $('#arbtaTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد ربطة مباعه ادخل  ربطة جديدة",
                    "sEmptyTable":    "لا يوجد ربطة مباعه ادخل  ربطة جديدة",
                    "sInfo":          "عدد شركات نقل الكلية _TOTAL_ شركة",
                    "sInfoEmpty":     "عدد شركات نقل صفر شركة",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن شركة: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

         },

                "processing":true,
               
                "bFilter": false,
                "bLengthChange": false,
               "bPaginate": false,
                "iDisplayLength": 200,
                "order":[],
                "bInfo" : false,
              
               
                "ajax":{
                 url:"fetchRbta.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3,4],
                  "orderable":false
                 },
                ],
                

               });

//remove rbth
$(document).on('click', '.deleteRbta', function(e){
  var rbthID = $(this).attr("id");
  
//01098068587
  $('#headingRemove').text("هل تريد مسح هذه الوزنه ??");
  $('#removeFrom').val("rbta");

  $('#hiddenRemoveDepositID').val("");
  $('#hiddenRemoveDepositID').val(rbthID);
  $('#removeDepositeModal').modal('show');

});
$(document).on('click', '#CancelRemoveDepositBtn', function(e){
  
  $('#removeDepositeModal').modal('hide');

});
$(document).on('click', '#RemoveDepositBtn', function(e){
  var removeFrom=$('#removeFrom').val();
  if (removeFrom=="deposit") {
    var depositID = $('#hiddenRemoveDepositID').val();
    $("body").addClass("loadingAddInv");
  $.ajax({
    url:"deleteInsertedDeposite.php",
    method:'POST',
    data:{depositID:depositID},
    success:function(data)
    {
      if ($.trim(data) !=="e1") {
        $('#form_longTermPurchase')[0].reset();
        $.ajax({
          url:"fetchMordeenAmountRemain.php",
          method:'GET',
         
          success:function(data)
          {
           $("#elmordeenRemainsAmountTable").html(data);                   
   
          },
         complete: function() {
          $("body").removeClass("loadingAddInv");
            }
           
         });

        depositsDatatable.ajax.reload();
       
        $("body").removeClass("loadingAddInv");
        $('#removeDepositeModal').modal('hide');
         $("#myModalBody").html("تم مسح الايداع بنجاح");
        $( "#myModal" ).modal('show');
      }
     
    }
     
   });
  }else if (removeFrom=="rbta") {
    var rbthID = $('#hiddenRemoveDepositID').val();
    $("body").addClass("loadingAddInv");
  $.ajax({
    url:"deleteRebta.php",
    method:'POST',
    data:{rbthID:rbthID},
    success:function(data)
    {
      arbtaTable.ajax.reload();
       $("body").removeClass("loadingAddInv");
        $('#removeDepositeModal').modal('hide');
         $("#myModalBody").html("تم مسح الوزنه بنجاح");
        $( "#myModal" ).modal('show');
     
    }
     
   });
  }
  

});
 

  
///Add depositAmount
  $(document).on('submit', '#form_longTermPurchase', function(event){
              event.preventDefault();
              var SelectMoredName = $('#SelectMoredName').val();
              var depositAmount = $('#depositAmount').val();
              var depositType = $('#Eda3Type').val();
              $("body").addClass("loadingAddInv");
           if(SelectMoredName!= ''&&depositAmount!= ''&&depositAmount!= 0) {
             
              if ($.isNumeric(depositAmount)) {
                   $.ajax({
                    url:"insertDepositAmount.php",
                    method:'POST',
                   
                    data:{SelectMoredName:SelectMoredName,depositAmount:depositAmount,depositType:depositType},
                    
                    success:function(data)
                    {
                     
                       $('#form_longTermPurchase')[0].reset();
                        $.ajax({
                          url:"fetchMordeenAmountRemain.php",
                          method:'GET',
                         
                          success:function(data)
                          {
                           $("#elmordeenRemainsAmountTable").html(data);                   
                   
                          },
                         complete: function() {
                          $("body").removeClass("loadingAddInv");
                            }
                           
                         });

                       depositsDatatable.ajax.reload();
                    
                                  
                    }
                   });
                  }
                  else
                  {
                    $("body").removeClass("loadingAddInv");
                   $("#myModalBody").html("ادخل المبلغ المراد ايداعه ارقام وليس حروف!!");
                   $( "#myModal" ).modal('show');
                  }
            
            }else{
              $("body").removeClass("loadingAddInv");
               $("#myModalBody").html("ادخل جميع الحقول!!");
               $( "#myModal" ).modal('show');
            }
        
           
              });


  $(document).on('click', '#putMonyID', function(event){
    depositsDatatable.ajax.reload();
  });
//show deposits table
var depositsDatatable = $('#longTermPurchaseTable').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد مبالغ تم ايداعها فى حسابات الموردين",
                    "sEmptyTable":    "لا يوجد مبالغ تم ايداعها فى حسابات الموردين",
                    "sInfo":          "عدد المنتجات الكلية _TOTAL_ منتج",
                    "sInfoEmpty":     "عدد المنتجات صفر منتج",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن منتج: ",
                    "sUrl":           "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "تحميل...",
                    "oPaginate": {
                        "sFirst":    "الاول",
                        "sLast":    "الاخير",
                        "sNext":    "الصفحة التالية",
                        "sPrevious": "الصفحة السابقة"
                    },
                    "oAria": {
                        "sSortAscending":  "",
                        "sSortDescending": ""
                    }
                },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
       
         if(iDisplayIndex%2 == 0){
                $(nRow).css('background-color', '#F5F5F5');
                //$(nRow).css('color', 'red');
            }else{
                $(nRow).css('background-color', '#fff');
                 //$(nRow).css('color', 'red');
            }

         },

               

                "processing":true,
                "bFilter": false,
                "bLengthChange": false,
                "iDisplayLength": 15,
                "order":[],
               "bInfo" : false,
              
               
                "ajax":{
                 url:"fetchDeposits.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3,4,5,6,7,8],
                  "orderable":false
                 },
                ],
                

               });
  

/////////////////////////////
function isValidDate(s) {
  var bits = s.split('-');
  var d = new Date(bits[0] + '-' + bits[1] + '-' + bits[2]);
  return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]));
}

//show suppliers report
 $(document).on('click', '#showSuppReportBtn', function(e){

    var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }

    me.data('requestRunning', true);

    $("body").addClass("loadingAddInv");

    var SelectMoredForReport = $('#SelectMoredForReport').val();
    var SelectMoredTextForReport = $("#SelectMoredForReport option:selected").text();
    var suppReportSDate = $('#suppReportSDate').val();
    var suppReportEDate = $('#suppReportEDate').val();

    if (SelectMoredForReport!="" && suppReportSDate!=""&& suppReportEDate!="") {
    
      if (isValidDate(suppReportSDate.toString())&&isValidDate(suppReportEDate.toString())) {
       
           $.ajax({
                    url:"fetchSuppReport.php",
                    method:'POST',
                   
                    data:{SelectMoredTextForReport:SelectMoredTextForReport,SelectMoredForReport:SelectMoredForReport
                      ,suppReportSDate:suppReportSDate,suppReportEDate:suppReportEDate},
                    
                    success:function(data)
                    {
                     $("#AllSuppReport").html(data);                   
                                  
                    },
                      complete: function() {
                        $("body").removeClass("loadingAddInv");
                        me.data('requestRunning', false);
                     }
                   });


      }else{
        $("body").removeClass("loadingAddInv");
        $("#myModalBody").html("يجب ادخال التاريخ بصيغه صحيحه مثال 2017/5/20");
        $( "#myModal" ).modal('show');
      }
    }else{
      $("body").removeClass("loadingAddInv");
      $("#myModalBody").html("يجب ادخال جميع الحقول");
      $( "#myModal" ).modal('show');
    }


});

//show customer agel report
// $(document).on('click','#showAgelReportBtn',function(){
//   $('#customerPayRollDiv').css('display','block');
//   $('#hrSeprator').css('display','block');
// });

//  $(document).on('click', '#showAgelReportBtn', function(e){

//     e.preventDefault();

//     var csID=$('#customerNameForAgel').attr('data-cnReportdata');
//     var csName=$('#customerNameForAgel').val();
   
//     if (csID==""||csName=="") {
//        $("#myModalBody").html("يجب ادخال اسم العميل");
//        $( "#myModal" ).modal('show');
//     }else{
//       $("body").addClass("loadingAddInv");
//           $.ajax({
//                     url:"fetchCustomerPayroll.php",
//                     method:'POST',
                   
//                     data:{csID:csID,csName:csName},
                    
//                     success:function(data)
//                     {
//                      $("#customerPayRollDiv").html(data);                   
                                  
//                     },
//                      complete: function() {
//                       $("body").removeClass("loadingAddInv");
//                         }
                     
//                    });
//     }

    

// });

     //autocompleate text input
           $(document).on('keyup','#customerNameForAgel',function(){  
               var query = $(this).val();  
               if(query != '')  
               {  
                    $.ajax({  
                         url:"searchInTextInputForReport.php",  
                         method:"POST",  
                         data:{query:query},  
                         success:function(data)  
                         {  
                              $('#customerNameListForAgel').fadeIn();  
                              $('#customerNameListForAgel').html(data);  
                         }  
                    });  
               }  
            }); 

          $('#customerNameForAgel').on('blur',function(){
          $('#customerNameListForAgel').fadeOut();
            });


          $(document).on('click', 'ul.ulCustNameAgel li', function(){  
               $('#customerNameForAgel').val($(this).text());  
               $('#customerNameForAgel').attr('data-cnReportdata',$(this).attr('data-custIDForReport'));  

               $('#customerNameListForAgel').fadeOut();  
          }); 
 //autocompleate text input
           $(document).on('keyup','#customerNameForReport',function(){  
               var query = $(this).val();  
               if(query != '')  
               {  
                    $.ajax({  
                         url:"searchInTextInputForCustReport.php",  
                         method:"POST",  
                         data:{query:query},  
                         success:function(data)  
                         {  
                              $('#customerNameListForReport').fadeIn();  
                              $('#customerNameListForReport').html(data);  
                         }  
                    });  
               }  
            }); 

          $('#customerNameForReport').on('blur',function(){
          $('#customerNameListForReport').fadeOut();
            });


          $(document).on('click', 'ul.ulCustNameReport li', function(){  
               $('#customerNameForReport').val($(this).text());  
               $('#customerNameForReport').attr('data-CsNameReport',$(this).attr('data-custIDReport'));  
               $('#customerNameListForReport').fadeOut();  
          }); 
       //end search   

//pay amount fokEl7sab
 $(document).on('submit', '#form_PayMonyFokEl7sab', function(e){

    e.preventDefault();
 
  var PayAmount = $("#PayMonyInput").val();
  var PayAmount1 = Number($("#PayMonyInput").val());
  var custID=$("#hiddenCNametoPayFokEl7sab").val();
  var memberID = $("#hiddenPayFokEl7sabMemberID").attr("data-memberID");
if (PayAmount !=""&&PayAmount1 != 0) {
  if ($.isNumeric(PayAmount)) {
    $("body").addClass("loadingAddInv");
          $.ajax({
           url:"insertMonyFok7sab3mel.php",
           method:"POST",
           data:{PayAmount:PayAmount,custID:custID,memberID:memberID},
          
           success:function(data)
           {
              $('#form_PayMonyFokEl7sab')[0].reset();
              var csID=$('#customerNameForAgel').attr('data-cnReportdata');
              var csName=$('#customerNameForAgel').val();

              $.ajax({
                url:"fetchAgelTotalMonyForCust.php",
                method:'POST',
                data:{'uniq_param' : (new Date()).getTime()},
                success:function(data)
                {
                  var remainMony="اجمالي المدفوع فوق الحساب "+Number(data).toLocaleString() +" جنيه";
                 $("#AgelTotalMonyForCustLbl").text(remainMony);                   
                }
                 
               });



               $.ajax({
                  url:"fetchCustomerPayroll.php",
                  method:'POST',
                 
                  data:{csID:csID,csName:csName},
                  
                  success:function(data)
                  {
                   $("#customerPayRollDiv").html(data);

                   var custID = $("#fokEl7sabMonyLbl").attr("data-custid");
                   $.ajax({
                      url:"fetchMonyFok7sab3mel.php",
                      method:'POST',
                     
                      data:{custID:custID},
                      
                      success:function(data)
                      {
                       $("#DivfokEl7sabMony").html(data);                   
                       $('#DivfokEl7sabMony').css('display','block');             
                      },
                      complete: function() {
                        $("body").removeClass("loadingAddInv");
                      }
                       
                     });                   
                                
                  },
                   
                 });
                   
           }

          });

  }else{
       
      $("#myModalBody").html("يجب ادخال المبلغ ارقام وليس حروف");
      $( "#myModal" ).modal('show');
   }
}else{
  $("#myModalBody").html("يجب ادخال المبلغ");
      $( "#myModal" ).modal('show');
}

 });

 
  /////
  ////////////////fetch agel last customerPaidMony
$(document).on('click','#lastaCustomersMoyPaid',function(){
  if ($("#DivlastaCustomersMoyPaid").css("display")=="block") {
    $('#DivlastaCustomersMoyPaid').css('display','none');
    return;
  }
  $("body").addClass("loadingAddInv");
  var custID = $(this).attr("data-custid");
    $.ajax({
                    url:"fetchLastCustomerPaidMony.php",
                    method:'POST',
                   
                    data:{custID:custID},
                    
                    success:function(data)
                    {
                     $("#DivlastaCustomersMoyPaid").html(data);                   
                                  
                    },
                   complete: function() {
                    $("body").removeClass("loadingAddInv");
                    $('#DivlastaCustomersMoyPaid').css('display','block');
                      }
                     
                   });


});
  ////////////////fetch fokel7sab details
$(document).on('click','#fokEl7sabMonyLbl',function(){
  if ($("#DivfokEl7sabMony").css("display")=="block") {
    $('#DivfokEl7sabMony').css('display','none');
    return;
  }
  $("body").addClass("loadingAddInv");
 var custID = $("#fokEl7sabMonyLbl").attr("data-custid");
 $.ajax({
    url:"fetchMonyFok7sab3mel.php",
    method:'POST',
   
    data:{custID:custID},
    
    success:function(data)
    {
     $("#DivfokEl7sabMony").html(data);                   
                  
    },
    complete: function() {
      $("body").removeClass("loadingAddInv");
      $('#DivfokEl7sabMony').css('display','block');
    }
     
   });


});
/////fetch Deliverd as mony
$(document).on('click','#DeliverdAsMonyLbl',function(){
  if ($("#DivDeliverdAsMony").css("display")=="block") {
    $('#DivDeliverdAsMony').css('display','none');
    return;
  }
  $("body").addClass("loadingAddInv");
 var custID = $("#DeliverdAsMonyLbl").attr("data-custid");
 $.ajax({
    url:"fetchDeliverdAsMony.php",
    method:'POST',
   
    data:{custID:custID},
    
    success:function(data)
    {
     $("#DivDeliverdAsMony").html(data);                   
                  
    },
    complete: function() {
      $("body").removeClass("loadingAddInv");
      $('#DivDeliverdAsMony').css('display','block');
    }
     
   });


});
//////////////
////////////////fetch agel last customerSales
$(document).on('click','#lastCustomersSales',function(){
  if ($("#DivlastCustomersSales").css("display")=="block") {
    $('#DivlastCustomersSales').css('display','none');
  }else{
      $("body").addClass("loadingAddInv");

  var custID = $(this).attr("data-custid");

    $.ajax({
      url:"fetchLastCustomerSales.php",
      method:'POST',
     
      data:{custID:custID},
      
      success:function(data)
      {
        
       $("#DivlastCustomersSales").html(data);                   
                    
      },
      complete: function() {
        $("body").removeClass("loadingAddInv");
        $('#DivlastCustomersSales').css('display','block');
      }
       
     });
    
  }



});

 

//show customer report
 $(document).on('submit', '#form_customersReport', function(e){

    var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }
    me.data('requestRunning', true);

    var csID=$('#customerNameForReport').attr('data-CsNameReport');
    var csName=$('#customerNameForReport').val();

    //var SelectMoredTextForReport = $("#SelectMoredForReport option:selected").text();
    var custReportSDate = $('#custReportSDate').val();
    var custReportEDate = $('#custReportEDate').val();

    if (csID!="" && custReportSDate!=""&& custReportEDate!="") {
    
      if (isValidDate(custReportSDate.toString())&&isValidDate(custReportEDate.toString())) {
       $("body").addClass("loadingAddInv");
           $.ajax({
                    url:"fetchCustomersReport.php",
                    method:'POST',
                   
                    data:{csID:csID,csName:csName,custReportSDate:custReportSDate,custReportEDate:custReportEDate},
                   
                    success:function(data)
                    {
                     $("#AllCustomerReport").html(data);                   
                         // alert(data);      
                    },
                      complete: function() {
                        $("body").removeClass("loadingAddInv");
                        me.data('requestRunning', false);
                     }
                   });


      }else{
        $("#myModalBody").html("يجب ادخال التاريخ بصيغه صحيحه مثال 2017/5/20");
        $( "#myModal" ).modal('show');
      }
    }else{
      $("#myModalBody").html("يجب ادخال جميع الحقول");
      $( "#myModal" ).modal('show');
    }


});

//Load elmordeenRemainsAmountTable
// $(document).load('/index.php?page=longTermPurchase',function(){
//   alert("clicked");

// });
   $(document).on('click', '#moredamountID', function(e){
     $.ajax({
                    url:"fetchMordeenAmountRemain.php",
                    method:'POST',
                    data:{'uniq_param' : (new Date()).getTime()},
                    success:function(data)
                    {
                     $("#elmordeenRemainsAmountTable").html(data);                   
             
                    }
                     
                   });
   });

$( window ).load(function() {
    if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=longTermPurchase")) {
             $.ajax({
                    url:"fetchMordeenAmountRemain.php",
                    method:'POST',
                    data:{'uniq_param' : (new Date()).getTime()},
                    success:function(data)
                    {
                     $("#elmordeenRemainsAmountTable").html(data);                   
             
                    }
                     
                   });
    }
});
$( window ).load(function() {
    if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=nonePaidInvoices")) {
             $.ajax({
                    url:"fetchAllCustomerPayroll.php",
                    method:'POST',
                    data:{'uniq_param' : (new Date()).getTime()},
                    success:function(data)
                    {
                     $("#allcustomersAgelTable").html(data);                   
                         // alert(data);      
                    }
                     
                   });
    }else if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=msrofat")) {
        $.ajax({
                    url:"fetchmsrofat.php",
                    method:'POST',
                    data:{'uniq_param' : (new Date()).getTime()},
                    success:function(data)
                    {

                     $("#msareefDetailstable").html(data);                   
                    }
                     
                   });
    }else if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=khazna")) {
      
        $.ajax({
                    url:"fetchKhaznaDetails.php",
                    method:'POST',
                    data:{'uniq_param' : (new Date()).getTime()},
                    success:function(data)
                    {

                     $("#khznaDetailsDiv").html(data);                   
                    }
                     
                   });
    }else if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=msrofatReport")) {
      var startDate=$("#msrofatReportSDate").val();
      var endDate=$("#msrofatReportEDate").val();
       msrofatReport_pie (startDate,endDate);
    }else if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=mby3atReport")) {
      var startDate=$("#mbe3atReportSDate").val();
      var endDate=$("#mbe3atReportEDate").val();
       mbe3atReport_chart (startDate,endDate);
       mbe3atProductsReport_pie (startDate,endDate);

       var currentDate = new Date();
       var currenYear=currentDate.getFullYear();
       var currenMonth=currentDate.getMonth()+1;

       mbe3atReport_monthsInYear_chart (currenYear);

       mbe3atDayesInMonthReport_pie (currenYear,currenMonth);

    }else if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=longTermSales")) {
      
        $.ajax({
            url:"fetchAgelTotalRemainMony.php",
            method:'POST',
            data:{'uniq_param' : (new Date()).getTime()},
            success:function(data)
            {
              var remainMony="اجمالي المبالغ المتبقيه على العملاء "+Number(data).toLocaleString() +" جنيه";
             $("#AgelTotalRemainMonyLbl").text(remainMony);                   
            }
             
           });

          $.ajax({
            url:"fetchAgelTotalMonyForCust.php",
            method:'POST',
            data:{'uniq_param' : (new Date()).getTime()},
            success:function(data)
            {
              var remainMony="اجمالي المدفوع فوق الحساب "+Number(data).toLocaleString() +" جنيه";
             $("#AgelTotalMonyForCustLbl").text(remainMony);                   
            }
             
           });

    }else if ((window.location.href=="https://steelnet.000webhostapp.com/index.php?page=longTermSale")) {
      $("body").addClass("loadingAddInv");
        $.ajax({
            url:"fetchCustomersRemainMony.php",
            method:'POST',
            data:{'uniq_param' : (new Date()).getTime()},
            success:function(data)
            {
             $("#customersRemainMony").html(data);                   
            }
             
           });

          $.ajax({
            url:"fetchCustomersMony.php",
            method:'POST',
            data:{'uniq_param' : (new Date()).getTime()},
            success:function(data)
            {
              $("#customersMony").html(data);                   
            }
             
           });
           $("body").removeClass("loadingAddInv");
    }
});

$(document).on('click','#khaznaDetailsLbl',function(){
    $("body").addClass("loadingAddInv");
     $.ajax({
      url:"fetchKhaznaDetails.php",
      method:'POST',
      data:{'uniq_param' : (new Date()).getTime()},
      success:function(data)
      {

       $("#khznaDetailsDiv").html(data);                   
      },
      complete: function() 
      {
        $("body").removeClass("loadingAddInv");
      }
       
     });
});


//////////////// handle msrofat
 $(document).on('submit', '#form_msrofat', function(e){

    e.preventDefault();
  
    var SelectMsareefText = $("#SelectMsareef option:selected").text();
    var SelectMsareefValue = $("#SelectMsareef option:selected").val();
    var msareefDetails = $('#msareefDetails').val();
    var msareefAmount = $('#msareefAmount').val();
    var memberID = $("#hiddenmembID").attr("data-memberID");

    if (SelectMsareefValue!="" && msareefDetails!=""&& msareefAmount!="") {
    
      if ($.isNumeric(msareefAmount)) {
       
           $.ajax({
                    url:"insertMsrofat.php",
                    method:'POST',
                   
                    data:{SelectMsareefText:SelectMsareefText,SelectMsareefValue:SelectMsareefValue,
                      msareefDetails:msareefDetails,msareefAmount:msareefAmount,memberID:memberID},
                    
                    success:function(data)
                    {
                     if (data=="error") {
                      $("#myModalBody").html("حدث خطأ اثناء الصرف حاول تأكد من اتصال الانترنت وحاول مره اخرى");
                       $( "#myModal" ).modal('show');
                     }else{
                       $('#form_msrofat')[0].reset();
                        $.ajax({
                          url:"fetchmsrofat.php",
                          method:'GET',
                         
                          success:function(data)
                          {
                           $("#msareefDetailstable").html(data);                   
                          }
                           
                         });
                     }

                                  
                    }
                   });


      }else{
        $("#myModalBody").html("أدخل المبلغ ارقام فقط");
        $( "#myModal" ).modal('show');
      }
    }else{
      $("#myModalBody").html("يجب ادخال جميع الحقول");
      $( "#myModal" ).modal('show');
    }


});


  //withdrow from khazna
  $(document).on('submit', '#form_withdrowFromKhazna', function(e){

    e.preventDefault();
  
    var withdrawAmount = $('#withdrowInputMony').val();
    
    if (withdrawAmount!=""&&withdrawAmount!=0) {
    
      if ($.isNumeric(withdrawAmount)) {
        $("body").addClass("loadingAddInv");
           $.ajax({
                    url:"insertWithdrawKhazna.php",
                    method:'POST',
                   
                    data:{withdrawAmount:withdrawAmount},
                    
                    success:function(data)
                    {
                     if (data=="error") {
                      $("body").removeClass("loadingAddInv");
                      $("#myModalBody").html("حدث خطأ اثناء السحب تأكد من اتصال الانترنت وحاول مره اخرى");
                       $( "#myModal" ).modal('show');
                     }else{
                     
                       $('#form_withdrowFromKhazna')[0].reset();
                       $.ajax({
                        url:"fetchKhaznaDetails.php",
                        method:'GET',
                       
                        success:function(data)
                        {

                         $("#khznaDetailsDiv").html(data);                   
                        },
                        complete: function() 
                        {
                          $("body").removeClass("loadingAddInv");
                        }
                         
                       });
                     }

                                  
                    }
                   });


      }else{
        $("#myModalBody").html("أدخل المبلغ ارقام فقط");
        $( "#myModal" ).modal('show');
      }
    }else{
      $("#myModalBody").html("يجب ادخال المبلغ");
      $( "#myModal" ).modal('show');
    }


});
    //Add Rseed sabk to khazna
  $(document).on('submit', '#form_rseedSabk', function(e){

    e.preventDefault();
  
    var rseedAmount = $('#rseedSabkInput').val();
    
    if (rseedAmount!=""&&rseedAmount!=0) {
    
      if ($.isNumeric(rseedAmount)) {
        $("body").addClass("loadingAddInv");
           $.ajax({
                    url:"insertRseedSabkInKhzna.php",
                    method:'POST',
                   
                    data:{rseedAmount:rseedAmount},
                    
                    success:function(data)
                    {
                     if (data=="error") {
                      $("body").removeClass("loadingAddInv");
                      $("#myModalBody").html("حدث خطأ اثناء اضافة المبلغ تأكد من اتصال الانترنت وحاول مره اخرى");
                       $( "#myModal" ).modal('show');
                     }else{
                     
                       $('#form_rseedSabk')[0].reset();
                       $.ajax({
                        url:"fetchKhaznaDetails.php",
                        method:'GET',
                       
                        success:function(data)
                        {

                         $("#khznaDetailsDiv").html(data);                   
                        },
                        complete: function() 
                        {
                          $("body").removeClass("loadingAddInv");
                        }
                         
                       });
                     }

                                  
                    }
                   });


      }else{
        $("#myModalBody").html("أدخل المبلغ ارقام فقط");
        $( "#myModal" ).modal('show');
      }
    }else{
      $("#myModalBody").html("يجب ادخال المبلغ");
      $( "#myModal" ).modal('show');
    }


});
////////////Reservation



////////////////////////////////
//reservation Details

 $(document).on('click','.showReservationDetails', function(e){
  var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }

    me.data('requestRunning', true);
    $("body").addClass("loadingAddInv");

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

     },
     complete: function() {
      $("body").removeClass("loadingAddInv");
            me.data('requestRunning', false);
        }

  });


  }

 });
 ////end reservation Details

 //reservation Details 2

 $(document).on('click','.ShowReservedCostLbl', function(e){
  var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }

    me.data('requestRunning', true);

  var reservID = $(this).attr("id");
  if (reservID !="") {
  $("body").addClass("loadingAddInv");
   $.ajax({
     url:"ShowReservation.php",
     method:"POST",
     data:{reservID:reservID},
    
     success:function(data)
     {

      $("#ReserveInvModalMainDiv").html(data); 

      $("#deliverInvNoHidden" ).val(reservID);
      $("#giveReserveInvModal" ).modal('show');

     },
     complete: function() {
      $("body").removeClass("loadingAddInv");
      me.data('requestRunning', false);
        }

  });

  }

 });
 ////end reservation Details
 //show reservation withdrow as mony
 $(document).on('click','.WithdrowMonyLbl', function(e){
  
  var reservID = $(this).attr("id");
  if (reservID !="") {
  $("body").addClass("loadingAddInv");
   $.ajax({
     url:"ShowReservationWithdrowMony.php",
     method:"POST",
     data:{reservID:reservID},
    
     success:function(data)
     {
      $("#WithdrowMonyShowDiv").html(data); 
     },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }

  });

  }

 });
 //end show reservation withdrow as mony
 ////show reservation  pay remain mony
  $(document).on('click','.PayRemainMonyLbl', function(e){
  
  var reservID = $(this).attr("id");
  if (reservID !="") {
  $("body").addClass("loadingAddInv");
   $.ajax({
     url:"ShowReservationRemainMony.php",
     method:"POST",
     data:{reservID:reservID},
    
     success:function(data)
     {

      $("#PayRemainMonyShowDiv").html(data); 
     },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }

  });

  }

 });
 ////endshow reservation  pay remain mony
 ///show reservation withdrow awzan
   $(document).on('click','.WithdrowAwzanLbl', function(e){
  
  var reservID = $(this).attr("id");
  if (reservID !="") {
  $("body").addClass("loadingAddInv");
   $.ajax({
     url:"ShowReservationWithdrowAwzan.php",
     method:"POST",
     data:{reservID:reservID},
    
     success:function(data)
     {

      $("#WithdrowAwzanShowDiv").html(data); 
     },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }

  });

  }

 });
 ///end show reservation withdrow awzan

 //withdrow Nwloon as mony
    $(document).on('click','.deliverMonyNwloonBtn', function(e){
      var nwloonID = $(this).attr("data-deliverMonyNwloon");
      var outMony = $("input#Nwloon"+nwloonID+"").val();
      if (nwloonID !=""&& outMony !="" && $.isNumeric(outMony)) {
         $("body").addClass("loadingAddInv");
         $.ajax({
           url:"withdrowtoNwloon.php",
           method:"POST",
           data:{nwloonID:nwloonID,outMony:outMony},
           success:function(data)
           {

            if ($.trim(data)==="e1") {
               $("#myModalBody").html('تم تسليم كامل المبلغ');
               $( "#myModal" ).modal('show');
            }else if($.trim(data)==="e2"){
               $("#myModalBody").html('المبلغ المراد تسليمه اكبر من المبلغ المتبقي...ادخل مبلغ اقل.');
               $( "#myModal" ).modal('show');
            }else{
               $("#myModalBody").html('تم تسليم مبلغ وقدره '+outMony +" جنيه");
               $( "#myModal" ).modal('show');
              $("input#Nwloon"+nwloonID+"").val("");
              NawloonDatatable.ajax.reload();
            }
             $("body").removeClass("loadingAddInv");
           }
         });
      }

});

   //withdrow reservation as mony
    $(document).on('click','.deliverMonyReservationBtn', function(e){
  
  var reservID = $(this).attr("data-deliverMonyReservation");
  var outMony = $("input#d"+reservID+"").val();

  if (reservID !=""&& outMony !="" && $.isNumeric(outMony)) {
 $("body").addClass("loadingAddInv");
   $.ajax({
     url:"withdrowFromReservation.php",
     method:"POST",
     data:{reservID:reservID,outMony:outMony},
    
     success:function(d)
     {
      if ($.trim(d)==="e1") {
        $("body").removeClass("loadingAddInv");
        alert('تم تسليم كامل الكمية من هذا الحجز');
      }else if($.trim(d)==="e2"){
        $("body").removeClass("loadingAddInv");
          $("#myModalBody").html('المبلغ المراد تسليمه اكبر من المبلغ المتبقي...ادخل مبلغ اقل.');
         $( "#myModal" ).modal('show');
      }else{
         
           $.ajax({
             url:"ShowReservation.php",
             method:"POST",
             data:{reservID:reservID},
            
             success:function(data)
             {

              $("#ReserveInvModalMainDiv").html(data); 

               $.ajax({
                 url:"ShowReservationWithdrowMony.php",
                 method:"POST",
                 data:{reservID:reservID},
                
                 success:function(data)
                 {
                  $("#WithdrowMonyShowDiv").html(data); 
                 },
                 complete: function() {
                  $("body").removeClass("loadingAddInv");
                    }

              });


              $("#deliverInvNoHidden" ).val(reservID);
              $("#giveReserveInvModal" ).modal('show');

             }

          });

         ///////////////////

          /////////// 
         $.ajax({
        url:"fetchReservation.php",
        method:'POST',
        data:{'uniq_param' : (new Date()).getTime()},
        success:function(data)
        {

         $("#ReservationListDiv").html(data);                   
        }
         
       });

          ///////////// 

      
      }
}

  });
  }else{
    $("#myModalBody").html('يجب ادخال المبلغ المراد تسليمه ( ارقام وليس حروف )');
         $( "#myModal" ).modal('show');
  }

 });//end withdrow reservation as mony
  
   //pay Remains mony reservation
$(document).on('click','.paidRemainsReservationBtn', function(e){
  
  var reservID = $(this).attr("data-paidRemainsReservation");
  var PaidMony = $("input#p"+reservID+"").val();

  if (reservID !=""&& PaidMony !="" && $.isNumeric(PaidMony)) {
  $("body").addClass("loadingAddInv");
   $.ajax({
     url:"withdrowFromReservation.php",
     method:"POST",
     data:{reservID:reservID,PaidMony:PaidMony},
    
     success:function(d)
     {
      if ($.trim(d)==="e1") {
        $("body").removeClass("loadingAddInv");
       $("#myModalBody").html('لا يوجد مبلع متبقي على العميل من هذا الحجز');
         $( "#myModal" ).modal('show');

      }else if($.trim(d)==="e2"){
        $("body").removeClass("loadingAddInv");
         $("#myModalBody").html('المبلغ المتبقي المراد دفعه اكبر من المبلغ المتبقي على العميل من هذا الحجز...ادخل مبلغ اقل.');
         $( "#myModal" ).modal('show');
        
      }else{
         
         $.ajax({
             url:"ShowReservation.php",
             method:"POST",
             data:{reservID:reservID},
            
             success:function(data)
             {

              $("#ReserveInvModalMainDiv").html(data); 

               $.ajax({
               url:"ShowReservationRemainMony.php",
               method:"POST",
               data:{reservID:reservID},
              
               success:function(data)
               {

                $("#PayRemainMonyShowDiv").html(data); 
               },
                 complete: function() {
                  $("body").removeClass("loadingAddInv");
                    }

            });


              $("#deliverInvNoHidden" ).val(reservID);
              $("#giveReserveInvModal" ).modal('show');

             }

          });

         ///////////////////
         if ((window.location.href=="https://el3sal.000webhostapp.com/index.php")||(window.location.href=="https://steelnet.000webhostapp.com/index.php")){
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
         }else{
              $.ajax({
              url:"fetchReservation.php",
              method:'POST',
              data:{'uniq_param' : (new Date()).getTime()},
              success:function(data)
              {

               $("#ReservationListDiv").html(data);                   
              }
               
             });
         }

          /////////// 
        
      
      }
}

  });
  }else{
      $("#myModalBody").html('يجب ادخال المبلغ المراد دفعه ( ارقام وليس حروف )');
      $( "#myModal" ).modal('show');
  }

 });//end pay Remains mony reservation
//show all reservation
   $('#AllReservLbl').click(function(){
    $("body").addClass("loadingAddInv");
        $.ajax({
                    url:"fetchAllReservation.php",
                    method:'POST',
                    data:{'uniq_param' : (new Date()).getTime()},
                    success:function(data)
                    {

                     $("#AllReservationDivition").html(data);                   
                    },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }
                     
                   });
  });
//end show all reservation



$(document).on('click', '.AddDepositeImg', function(e){
  e.preventDefault();
  
  $('#uploadImage').val("");
  $('#preview').html("");
  $('#err').html("");
  $('#preview').html("<img  src='no-image.jpg' />");
  var depositID = $(this).attr("id");
 
  $('#hiddenDepositID').val(depositID);
  $('#AddDepositeImgModal').modal('show');
});

//print
$(document).on('click', '#printDepositeImg', function(e){
  var printWindow = window.open('', '', 'height=650,width=750');

   var divContents = $("#imgDiv").html() +
                        "<script>" +
                        "window.onload = function() {" +
                        "     window.print();" +
                        "};" +
                        "<" + "/script>";
   printWindow.document.write(divContents);
   printWindow.document.close();
   setTimeout(function(){
    printWindow.focus();
    printWindow.print();
    printWindow.close();
},1000);


});


$(document).on('click', '.ShowDepositeImg', function(e){
  e.preventDefault();
  $('#imgDiv').html("");
  var depositID = $(this).attr("id");

   $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchDepositImg.php",
        method:'POST',
        data:{depositID:depositID},
        success:function(data)
        {
          $('#hiddenDepositImgID').val(depositID);
         $("#imgDiv").html(data);
        },
     complete: function(){
      $("body").removeClass("loadingAddInv");
      $('#ShowDepositeImgModal').modal('show')
        }
         
       });
 
});

$(document).on('click', '.deleteDeposite', function(e){
  var depositID = $(this).attr("id");
   $('#headingRemove').text("هل تريد مسح هذا الايداع؟؟");
   $('#removeFrom').val("deposit");

  $('#hiddenRemoveDepositID').val("");
  $('#hiddenRemoveDepositID').val(depositID);
  $('#removeDepositeModal').modal('show');

});
// $(document).on('click', '#CancelRemoveDepositBtn', function(e){
  
//   $('#removeDepositeModal').modal('hide');

// });
// $(document).on('click', '#RemoveDepositBtn', function(e){
//   var depositID = $('#hiddenRemoveDepositID').val();
//   $("body").addClass("loadingAddInv");
//   $.ajax({
//     url:"deleteInsertedDeposite.php",
//     method:'POST',
//     data:{depositID:depositID},
//     success:function(data)
//     {
//       if ($.trim(data) !=="e1") {
//         $('#form_longTermPurchase')[0].reset();
//         $.ajax({
//           url:"fetchMordeenAmountRemain.php",
//           method:'GET',
         
//           success:function(data)
//           {
//            $("#elmordeenRemainsAmountTable").html(data);                   
   
//           },
//          complete: function() {
//           $("body").removeClass("loadingAddInv");
//             }
           
//          });

//        depositsDatatable.ajax.reload();

//         alert("تم مسح الايداع بنجاح");
//         $("body").removeClass("loadingAddInv");
//         $('#removeDepositeModal').modal('hide');
//       }
     
//     }
     
//    });
// });
 
 /////////////////////
 $(document).on('submit', '#form_DailyReport', function(e){
  e.preventDefault();
    var DailyReportDate = $('#DailyReportDate').val();
    if (DailyReportDate !="") {
      if (isValidDate(DailyReportDate.toString())) {
        $("body").addClass("loadingAddInv");
            $.ajax({
                    url:"fetchDailyReport.php",
                    method:'POST',
                   
                    data:{DailyReportDate:DailyReportDate},
                    
                    success:function(data)
                    {
                      $("#DailyReportSafyDiv").css("display","block");

                      var value=data.split(",,toffaha,,");
                      var safy=value[1].split("mohammedRagabToffaha");
                     $("#safyLbl").text(safy[1]);                   
                                        
                     $("#DailyReportPrifDiv").html(safy[0]);                   
                     $("#DailyReportDiv").html(value[0]);                   
                                  
                    },
                      complete: function() {
                        $("body").removeClass("loadingAddInv");
                     }
                   });
      }else{
       $("#myModalBody").html("يجب ادخال التاريخ بصيغه صحيحه مثال 2017/5/20");
         $( "#myModal" ).modal('show');
    }
    }else{
       $("#myModalBody").html("يجب ادخال التاريخ");
         $( "#myModal" ).modal('show');
    }
  });
/////////////////////


$("#mortg3AwelElmodacategories").change(function(){
            var cat_ID=$(this).val();
            var supp_ID=$('#mortg3AwelElmodasuppliers').val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataType:"text",
                success:function(data){
                    $("#mortg3AwelElmodameasure").html(data);
                }
            });
        });
        $("#mortg3AwelElmodasuppliers").change(function(){
            var cat_ID=$("#mortg3AwelElmodacategories").val();
            var supp_ID=$(this).val();
            $.ajax({
                url:"fetch_measures.php",
                method:"POST",
                data: {CatID:cat_ID,supp_ID:supp_ID},
                dataType:"text",
                success:function(data){
                    $("#mortg3AwelElmodameasure").html(data);
                }
            });
        });

  $(document).on('click', '#addmortg3AwelElmoda', function(e){
  
  var suppID = $("#mortg3AwelElmodasuppliers").val();
  var catID = $("#mortg3AwelElmodacategories").val();
  var measID = $("#mortg3AwelElmodameasure").val();

  var unitcost=$("#mortg3AwelElmodaunitcost").val();
  var quantity=$("#mortg3AwelElmodaQ").val();

  if (suppID ==""||catID==""||measID=="") {
    $("#myModalBody").html("يجب ادخال الصنف المراد ارجاعه");
    $( "#myModal" ).modal('show');
  }else if (unitcost=="") {
    $("#myModalBody").html("يجب ادخال سعر الطن عند الارجاع");
    $( "#myModal" ).modal('show');
  }else if (quantity=="") {
    $("#myModalBody").html("يجب ادخال الكميه المراد ارجاعها");
    $( "#myModal" ).modal('show');
  }else{
    $("body").addClass("loadingAddInv");
      $.ajax({
        url:"mrtg3AwelElmoda.php",
        method:'POST',
        data:{suppID:suppID,catID:catID,measID:measID,unitcost:unitcost,quantity:quantity},
        success:function(data)
        {
          $("body").removeClass("loadingAddInv");
          alert("تم الارجاع بنجاح");
        }
         
       });

  }

   
});

  //edit Unit In Stock

 $(document).on('click', '.editUnitInStock', function(e){
   var measID = $(this).attr("id");
   $("#editUnitInStockValue").val("");
   $("#hiddenMeasID").val("");
   $("#hiddenMeasID").val(measID);
   
   $("#editUnitInStockModal").modal("show");
});


  $(document).on('click', '#editUnitInStock_btn', function(e){
  
  var measID = $("#hiddenMeasID").val();

  var unitInStock=$("#editUnitInStockValue").val();
  var unitInStockLength=$("#editUnitInStockValue").val().length;

  if (unitInStock =="") {
    $("#myModalBody").html("يجب ادخال الوزن");
    $( "#myModal" ).modal('show');
  }else if (!$.isNumeric(unitInStock)) {
    $("#myModalBody").html("يجب ادخال الوزن ارقام وليس حروف");
    $( "#myModal" ).modal('show');
  }else if (unitInStockLength > 7) {
    $("#myModalBody").html("يجب ادخال الوزن ارقام وعددهم أقل من 7");
    $( "#myModal" ).modal('show');
  }else{
    $("body").addClass("loadingAddInv");
      $.ajax({
        url:"editUnitInStock.php",
        method:'POST',
        data:{measID:measID,unitInStock:unitInStock},
        success:function(data)
        {
           StockDatatable.ajax.reload();
           StockDetailsDatatable.ajax.reload();

          $("#editUnitInStockModal").modal("hide");
          $("body").removeClass("loadingAddInv");
        }
         
       });

  }

   
});

//fetch msrofat Report
 $(document).on('click', '#showMsrofatReportBtn', function(e){
  e.preventDefault();
  var startDate=$("#msrofatReportSDate").val();
  var endDate=$("#msrofatReportEDate").val();
  $("#msrofatReportLbl").text("تقرير مصروفات عن الفترة من" +startDate+" الى "+endDate);
  msrofatReport_pie (startDate,endDate);
 });

 //msrofat report pie function
 function msrofatReport_pie (startDate,endDate) {
   if (isValidDate(startDate.toString())&&isValidDate(endDate.toString())){
    $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchMsrofatReport.php",
        method:'POST',
        dataType:'JSON',
        data:{startDate:startDate,endDate:endDate},
        success:function(data)
        {
          

                 var x= JSON.stringify(data);
           x=x.slice(1,-1);
          var lastData=JSON.parse(x);
          if (lastData.length < 1) {
            $("#myModalBody").html("لا توجد مصروفات خلال تلك الفترة");
            $( "#myModal" ).modal('show');
            $("body").removeClass("loadingAddInv");
            $( "#msrofatReportTableDiv" ).html('');
            $( "#msrofatReportDiv" ).html('');
            return;
          }
          var table="";
          table+="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";

    table+="<thead><tr style='background-color: #FD3C40;color: #fff'><th>سحب بسبب </th><th>المبلغ</th></tr></thead><tbody>";

           for (var i in lastData) {
            var str=lastData[i].toString();
           
            var nameAndVal=str.split(',');
            var name=nameAndVal[0];
            var amount=nameAndVal[1];
            table+="<tr><td>"+name+"</td><td>"+amount+"</td></tr>";
            
          };
          table+="</tbody></table></div>";

          $("#msrofatReportTableDiv").html(table);

         // alert(x)
                  Highcharts.chart('msrofatReportDiv', {
            chart: {
                 plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                x: -150
            },
            plotOptions: {
                pie: {
                  allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b> ({point.y})',
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || '#B80303',
                        softConnector: true
                    },
                    // center: ['40%', '50%'],
                    // width: '80%'
                }
            },
               tooltip: {
                   
                     headerFormat: '<span style="font-size:13px;float:right"></span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                        '<td style="color:{series.color};padding:0"><b>{point.name}</b></td></tr><tr><td style=""></td>' +
                        '<td style="padding:0"><b>{point.y:.0f} جنيه </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                    
                },
            legend: {
                enabled: false
            },
            series: [{
                name: 'جنيه',
                data:  lastData

            }]
        });
                  $("body").removeClass("loadingAddInv");
        
          
        }
         
       });
  }else{
        $("#myModalBody").html("يجب ادخال التاريخ بصيغه صحيحه مثال 2017/5/20");
        $( "#myModal" ).modal('show');
      }
 }

 //fetch mbe3at Report
 $(document).on('click', '#showMbe3atReportBtn', function(e){
  e.preventDefault();
  var startDate=$("#mbe3atReportSDate").val();
  var endDate=$("#mbe3atReportEDate").val();
  $("#mbe3atReportLbl").text("الرسم البياني يوضح أكثر العملاء شراء عن الفترة من" +startDate+" الى "+endDate);
  $("#mbe3atProductReportLbl").text("اكثر الأصناف مبيعاً خلال الفترة من" +startDate+" الى "+endDate);
  mbe3atReport_chart (startDate,endDate);
  mbe3atProductsReport_pie (startDate,endDate);
 });

 //mbe3at report 3d chart function
 function mbe3atReport_chart (startDate,endDate) {
   if (isValidDate(startDate.toString())&&isValidDate(endDate.toString())){
    $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchMbe3atReport.php",
        method:'POST',
        dataType:'JSON',
        data:{startDate:startDate,endDate:endDate},
        success:function(data)
        {
          

                 var x= JSON.stringify(data);
           x=x.slice(1,-1);
          var lastData=JSON.parse(x);
           var cats=new Array();
          for (var i in lastData) {
            cats.push(lastData[i].custName);
          };

          if (lastData.length < 1) {
            $("#myModalBody").html("لا توجد مبيعات خلال تلك الفترة");
            $( "#myModal" ).modal('show');
            $("body").removeClass("loadingAddInv");
            $( "#mbe3atReportTableDiv" ).html('');
            $( "#mbe3atReportDiv" ).html('');
            return;
          }
          var table="";
          table+="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";

    table+="<thead><tr style='background-color: #FD3C40;color: #fff'><th>اسم العميل </th><th>الكمية المسحوبة</th></tr></thead><tbody>";

           for (var i in lastData) {
            var name=lastData[i].custName;
           
            var quantity=lastData[i].y;
           quantity= convertTotenAndKelo(quantity);
            table+="<tr><td>"+name+"</td><td>"+quantity+"</td></tr>";
            
          };
          table+="</tbody></table></div>";

          $("#mbe3atReportTableDiv").html(table);

         // alert(x)
                  Highcharts.chart('mbe3atReportDiv', {
              chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 25,
            depth: 77,
            viewDistance: 25
        }
       },
            title: {
                text: '',
                x: -150
            },
            plotOptions: {
            column: {
                depth: 25
            }
        },
         legend: {
          enabled: false,
           // layout: 'vertical',
            //align: 'right'
            //verticalAlign: 'middle'
        },
        xAxis: {
            categories:cats,
            title: {
             text: ''
          }
        },
         yAxis: {
          min: 0,
          //max: 100,
          title: {
            text: ''
          }
        },
        series: [{
               data: lastData,
            type: 'column',
            name: ''
        }],
         tooltip: {
            //  formatter: function () {
            // return 'Extra data: <b>' + this.point.emt7anDate + '</b><br><b>'+ this.point.emt7anatID +'</b>';
            //   },

             headerFormat: '<span style="color:{series.color};font-size:14px;font-weight: bold;float:right">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">الكمية : </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
            
        }
        });
                  $("body").removeClass("loadingAddInv");
        
          
        }
         
       });
  }else{
        $("#myModalBody").html("يجب ادخال التاريخ بصيغه صحيحه مثال 2017/5/20");
        $( "#myModal" ).modal('show');
      }
 }


 //mbe3at products report pie function
 function mbe3atProductsReport_pie (startDate,endDate) {
   if (isValidDate(startDate.toString())&&isValidDate(endDate.toString())){
      $.ajax({
        url:"fetchMbe3atProductReport.php",
        method:'POST',
        dataType:'JSON',
        data:{startDate:startDate,endDate:endDate},
        success:function(data)
        {
          

                 var x= JSON.stringify(data);
           x=x.slice(1,-1);
          var lastData=JSON.parse(x);
          if (lastData.length < 1) {
            $("#myModalBody").html("لا توجد أصناف مباعه خلال تلك الفترة");
            $( "#myModal" ).modal('show');
            $( "#mbe3atProductReportTableDiv" ).html('');
            $( "#mbe3atProductReportDiv" ).html('');
            return;
          }
          var table="";
          table+="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";

    table+="<thead><tr style='background-color: #FD3C40;color: #fff'><th>الآصناف </th><th>الكمية المباعة</th></tr></thead><tbody>";

           for (var i in lastData) {
            var name=lastData[i].productName;
            var quantity=lastData[i].y;
           
          var integr=Number(quantity);
           quantity= convertTotenAndKelo(integr);
            table+="<tr><td>"+name+"</td><td>"+quantity+"</td></tr>";
            
          };
          table+="</tbody></table></div>";

          $("#mbe3atProductReportTableDiv").html(table);
                Highcharts.chart('mbe3atProductReportDiv', {
            chart: {
                 plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                x: -150
            },
            plotOptions: {
                pie: {
                  allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>({point.y})</b>',
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || '#B80303',
                        softConnector: true
                    },
                    // center: ['40%', '50%'],
                    // width: '80%'
                }
            },
               tooltip: {
                   
                     headerFormat: '<span style="font-size:13px;float:right"></span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                        '<td style="color:{series.color};padding:0"><b>{point.productName}</b></td></tr><tr><td style=""></td>' +
                        '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                    
                },
            legend: {
                enabled: false
            },
            series: [{
                name: '',
                data:  lastData

            }]
        });
          
        }
         
       });
  }else{
        $("#myModalBody").html("يجب ادخال التاريخ بصيغه صحيحه مثال 2017/5/20");
        $( "#myModal" ).modal('show');
      }
 }

 //mbe3at report most month in a year
 $("#SelectYearInMbe3atYearReport").change(function (e) {
  var year=$(this).val();
   if (year != "0") {
    $( "#mbe3atFtratMonthsReportLbl" ).text('الرسم البياني يوضح اكثر الشهور بيع خلال '+year);
    mbe3atReport_monthsInYear_chart (year);
   }
 });
function mbe3atReport_monthsInYear_chart (year) {
    $("body").addClass("loadingAddInv");
      $.ajax({
        url:"fetchMbe3atReportMonthsInYear.php",
        method:'POST',
        dataType:'JSON',
        data:{year:year},
        success:function(data)
        {
          

                 var x= JSON.stringify(data);
           x=x.slice(1,-1);
          var lastData=JSON.parse(x);
           var cats=new Array();
          for (var i in lastData) {
            cats.push(lastData[i].month);
          };

          if (lastData.length < 1) {
            $("#myModalBody").html("لا توجد مبيعات خلال تلك الفترة");
            $( "#myModal" ).modal('show');
            $("body").removeClass("loadingAddInv");
            $( "#mbe3atFtratMonthsReportLbl" ).text('');
            $( "#mbe3atFtratMonthsReportTableDiv" ).html('');
            $( "#mbe3atFtratMonthsReportDiv" ).html('');
            return;
          }
          var table="";
          table+="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";

    table+="<thead><tr style='background-color: #FD3C40;color: #fff'><th>الشهر </th><th>الكمية المباعة</th></tr></thead><tbody>";

           for (var i in lastData) {
            var month=lastData[i].month;
           
            var quantity=lastData[i].y;
           quantity= convertTotenAndKelo(quantity);
            table+="<tr><td>"+month+"</td><td>"+quantity+"</td></tr>";
            
          };
          table+="</tbody></table></div>";

          $("#mbe3atFtratMonthsReportTableDiv").html(table);

         // alert(x)
                  Highcharts.chart('mbe3atFtratMonthsReportDiv', {
              chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 25,
            depth: 77,
            viewDistance: 25
        }
       },
            title: {
                text: '',
                x: -150
            },
            plotOptions: {
            column: {
                depth: 25
            }
        },
         legend: {
          enabled: false,
           // layout: 'vertical',
            //align: 'right'
            //verticalAlign: 'middle'
        },
        xAxis: {
            categories:cats,
            title: {
             text: ''
          }
        },
         yAxis: {
          min: 0,
          //max: 100,
          title: {
            text: ''
          }
        },
        series: [{
               data: lastData,
            type: 'column',
            name: ''
        }],
         tooltip: {
             headerFormat: '<span style="color:{series.color};font-size:14px;font-weight: bold;float:right">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">الكمية : </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
            
        }
        });
                  $("body").removeClass("loadingAddInv");
        
          
        }
         
       });

 }
 //mbe3at report most day in a month
 $("#SelectMonthInMbe3atYearMonthReport").change(function (e) {
  var year=$("#SelectYearInMbe3atYearMonthReport").val();
  var month=$(this).val();
   if (year != "0") {
    $( "#mbe3atFtratYearMonthsReportLbl" ).text('الرسم البياني يوضح اكثر الأيام بيع خلال سنة '+year+" شهر "+month);
    mbe3atDayesInMonthReport_pie (year,month);
   }
 });
function mbe3atDayesInMonthReport_pie (year,month) {

      $.ajax({
        url:"fetchMbe3atDayesInMonthReport.php",
        method:'POST',
        dataType:'JSON',
        data:{year:year,month:month},
        success:function(data)
        {
          

                 var x= JSON.stringify(data);
           x=x.slice(1,-1);
          var lastData=JSON.parse(x);
          if (lastData.length < 1) {
            $("#myModalBody").html("لا توجد نبيعات خلال تلك الفترة");
            $( "#myModal" ).modal('show');
            $( "#mbe3atFtratYearMonthsReportLbl" ).text('');
            $( "#mbe3atFtratYearMonthsReportTableDiv" ).html('');
            $( "#mbe3atFtratYearMonthsReportDiv" ).html('');
            return;
          }
          var table="";
          table+="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";

    table+="<thead><tr style='background-color: #FD3C40;color: #fff'><th>اليوم </th><th>الكمية المباعة</th></tr></thead><tbody>";

           for (var i in lastData) {
            var days=lastData[i].days;
            var quantity=lastData[i].y;
           
          var integr=Number(quantity);
           quantity= convertTotenAndKelo(integr);
            table+="<tr><td>"+days+"</td><td>"+quantity+"</td></tr>";
            
          };
          table+="</tbody></table></div>";

          $("#mbe3atFtratYearMonthsReportTableDiv").html(table);
                Highcharts.chart('mbe3atFtratYearMonthsReportDiv', {
            chart: {
                 plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                x: -150
            },
            plotOptions: {
                pie: {
                  allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>({point.y})</b>',
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || '#B80303',
                        softConnector: true
                    },
                    // center: ['40%', '50%'],
                    // width: '80%'
                }
            },
               tooltip: {
                   
                     headerFormat: '<span style="font-size:13px;float:right"></span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">يوم</td>' +
                        '<td style="color:{series.color};padding:0"><b>{point.days}</b></td></tr><tr><td style=""></td>' +
                        '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                    
                },
            legend: {
                enabled: false
            },
            series: [{
                name: '',
                data:  lastData

            }]
        });
          
        }
         
       });
 
 }



//handel agel elbe3
$('.reloadCustomersRemainMony').click(function(){
    $("body").addClass("loadingAddInv");
    $.ajax({
        url:"fetchCustomersRemainMony.php",
        method:'POST',
        data:{'uniq_param' : (new Date()).getTime()},
        success:function(data)
        {
         $("#customersRemainMony").html(data);                   
        } ,
        complete:function()
        {
         $("body").removeClass("loadingAddInv");                 
        }
         
       });

       
});
$(document).on('click','.reloadCustomersMony',function(event){
    $("body").addClass("loadingAddInv");
    $.ajax({
      url:"fetchCustomersMony.php",
      method:'POST',
      data:{'uniq_param' : (new Date()).getTime()},
      success:function(data)
      {
        $("#customersMony").html(data);                   
      },
        complete:function()
        {
         $("body").removeClass("loadingAddInv");                 
        }
       
     });
});

$(document).on('click','.cutomersPage',function(){
  $("body").addClass("loadingAddInv");
  var custID=$(this).attr("id");
  var custName=$(this).attr("data-custName");
  $("#customerPageNameLbl").text(custName);

    $.ajax({
      url:"fetchCustomerPage.php",
      method:'POST',
      data:{custID:custID,custName:custName},
      success:function(data)
      {

        $("#customerPageModal").modal('show');                   
        $("#customerPageDiv").html(data);                   
      },
        complete:function()
        {
         $("body").removeClass("loadingAddInv");                 
        }
       
     });
});

//pay remain mony in agel
 $(document).on('submit', '#form_AddMonyToCustomer', function(e){

    e.preventDefault();
 
  var PayAmount = $("#custMonyInput").val();
  var custID=$("#hiddenCNametoCostomerMony").val();
  var memberID = $("#hiddenMemberID").attr("data-memberID");
  var custName = $("#hiddenCNametoCostomerMony").attr("data-cn");
  customerPaingMony (PayAmount,custID,memberID,custName);

 });

function customerPaingMony (PayAmount,custID,memberID,custName) {
  if (PayAmount !=""&&PayAmount !="0") {
  if ($.isNumeric(PayAmount)) {
    $("body").addClass("loadingAddInv");
          $.ajax({
           url:"insertLongTermInvoice.php",
           method:"POST",
           data:{PayAmount:PayAmount,custID:custID,memberID:memberID},
          
           success:function(data)
           {
              
              $.ajax({
                url:"fetchCustomerPage.php",
                method:'POST',
                data:{custID:custID},
                success:function(data)
                {
                  $("#customerPageNameLbl").text(custName);
                  $("#customerPageModal").modal('show');                   
                  $("#customerPageDiv").html(data);                   
                },complete:function()
                  {
                   $("#myModalBody").html("تم إضافة المبلغ بنجاح");
                    $( "#myModal" ).modal('show');
                    $("body").removeClass("loadingAddInv");
                    $("#custMonyInput2").val("");              
                  $("#giveCustMonyInput2").val("");                
                  }
                }); 

               $.ajax({
                url:"fetchCustomersRemainMony.php",
                method:'POST',
                data:{'uniq_param' : (new Date()).getTime()},
                success:function(data)
                {
                 $("#customersRemainMony").html(data);                   
                }
               });

             $.ajax({
                url:"fetchCustomersMony.php",
                method:'POST',
                data:{'uniq_param' : (new Date()).getTime()},
                success:function(data)
                {
                  $("#customersMony").html(data);                   
                }
               });
             
           }

          });

  }else{
       
      $("#myModalBody").html("يجب ادخال المبلغ ارقام وليس حروف");
      $( "#myModal" ).modal('show');
   }
}else{
  $("#myModalBody").html("يجب ادخال المبلغ");
      $( "#myModal" ).modal('show');
}
}

   /////Deliverd As Mony
  //pay remain mony in agel
 $(document).on('submit', '#form_givMonyToCustomer', function(e){

    e.preventDefault();
 
  var PayAmount = $("#giveCustMonyInput").val();
  var custID=$("#hiddenCNametoGiveMony").val();
  var memberID = $("#hiddenGiveMemberID").attr("data-memberID");
  var custName = $("#hiddenCNametoGiveMony").attr("data-cn");
  customerDeliveredMony (PayAmount,custID,memberID,custName);


 });

 function customerDeliveredMony (PayAmount,custID,memberID,custName){
    if (PayAmount !=""&&PayAmount !="0") {
  if ($.isNumeric(PayAmount)) {
    $("body").addClass("loadingAddInv");
          $.ajax({
           url:"insertDeliverdAsMony.php",
           method:"POST",
           data:{PayAmount:PayAmount,custID:custID,memberID:memberID},
          
           success:function(data)
           {
            if ($.trim(data)==="e1"){
              $("body").removeClass("loadingAddInv");
              alert("لا يوجد مبلغ متبقي للعميل");
            }else if ($.trim(data)==="e2"){
              $("body").removeClass("loadingAddInv");
              alert("المبلغ المراد تسليمه اكبر من المبلغ المتبقي للعميل .. ادخل مبلغ اقل من او يساوي المتبقي للعميل");
            }else{
             
                  $.ajax({
                url:"fetchCustomerPage.php",
                method:'POST',
                data:{custID:custID},
                success:function(data)
                {
                  $("#customerPageNameLbl").text(custName);
                  $("#customerPageModal").modal('show');                   
                  $("#customerPageDiv").html(data);                   
                },
                complete:function()
                {
                 $("#myModalBody").html("تم تسليمه المبلغ بنجاح");
                 $("#myModal" ).modal('show');
                 $("body").removeClass("loadingAddInv");
                  $("#custMonyInput2").val("");              
                  $("#giveCustMonyInput2").val("");              
                }
                }); 

               $.ajax({
                url:"fetchCustomersRemainMony.php",
                method:'POST',
                data:{'uniq_param' : (new Date()).getTime()},
                success:function(data)
                {
                 $("#customersRemainMony").html(data);                   
                }
               });

             $.ajax({
                url:"fetchCustomersMony.php",
                method:'POST',
                data:{'uniq_param' : (new Date()).getTime()},
                success:function(data)
                {
                  $("#customersMony").html(data);                   
                }
               });

               
            }
         
                            
                      
           }

          });

  }else{
       
      $("#myModalBody").html("يجب ادخال المبلغ ارقام وليس حروف");
      $( "#myModal" ).modal('show');
   }
}else{
  $("#myModalBody").html("يجب ادخال المبلغ");
      $( "#myModal" ).modal('show');
}
  }

// $(document).on('click','#showAgelReportBtn',function(){
//   $('#customerPayRollDiv').css('display','block');
//   $('#hrSeprator').css('display','block');
// });

//  $(document).on('click', '#showAgelReportBtn', function(e){

//     e.preventDefault();

//     var csID=$('#customerNameForAgel').attr('data-cnReportdata');
//     var csName=$('#customerNameForAgel').val();
   
//     if (csID==""||csName=="") {
//        $("#myModalBody").html("يجب ادخال اسم العميل");
//        $( "#myModal" ).modal('show');
//     }else{
//       //$("body").addClass("loadingAddInv");
    
//     }

    

// });

$(document).on('submit', '#form_AddMonyToCustomer2', function(e){
   e.preventDefault();
   var PayAmount = $("#custMonyInput2").val();
   var csID=$('#customerNameForAgel').attr('data-cnReportdata');
    var csName=$('#customerNameForAgel').val();
    var memberID=$('#hiddenMemberID2').attr('data-memberID');
    customerPaingMony (PayAmount,csID,memberID,csName);
    // $("#custMonyInput2").val("");
  });

$(document).on('submit', '#form_givMonyToCustomer2', function(e){
   e.preventDefault();
   var PayAmount = $("#giveCustMonyInput2").val();
   var csID=$('#customerNameForAgel').attr('data-cnReportdata');
    var csName=$('#customerNameForAgel').val();
    var memberID=$('#hiddenGiveMemberID2').attr('data-memberID');
    customerDeliveredMony (PayAmount,csID,memberID,csName);
    // $("#custMonyInput2").val("");
  });

///end of document Ready fn
});


