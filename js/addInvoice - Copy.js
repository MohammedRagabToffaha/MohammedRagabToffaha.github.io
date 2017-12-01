function isValidDate(s) {
  var bits = s.split('-');
  var d = new Date(bits[0] + '-' + bits[1] + '-' + bits[2]);
  return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]));
}

$(function(){

  //show datatable withen table
            var InvoicedataTable = $('#invoice_table').DataTable({
                "language": {
                    "sProcessing":    "جاري التحميل...",
                    "sLengthMenu":    "اظهار عدد :  _MENU_ فاتورة",
                    "sZeroRecords":   "لا يوجد فواتير ادخل فاتورة جديدة",
                    "sEmptyTable":    "لا يوجد فواتير ادخل فاتورة جديدة",
                    "sInfo":          "عدد الفواتير الكلية _TOTAL_ فاتورة",
                    "sInfoEmpty":     "عدد الفواتير صفر فاتورة",
                    "sInfoFiltered":  "",
                    "sInfoPostFix":   "",
                    "sSearch":        "البحث عن فاتورة: ",
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

                "serverSide":true,
                "processing":true,
                "bFilter": false,
                "bLengthChange": false,
                "iDisplayLength": 15,
                "order":[],
                "bInfo" : false,
               
                "ajax":{
                 url:"fetchInvoices.php",
                 type:"POST"
                },
                "columnDefs":[
                 {
                  "targets":[0,1,2,3,4,5,6],
                  "orderable":false,
                 },
                ],
                

               });
  

    //////////add new order
              $(document).on('submit', '#AddInvoiceForm', function(event){
              event.preventDefault();
              

              var csID=$('#customerName').attr('data-cndata');
              var invoiceNoPost=$("#orderNo").val();
              var memberID = $("#userdata_name").attr("data-memberID");
              var orderDate=$("#orderDate").val();
              var orderType=$("#invoicetype").val()
              var discount=$("#discount").val()

              var invoiceNoLength=$("#orderNo").val().length;
              
              var customerName=$("#customerName").val().length;

              var amountPaid=$("#amountPaid").val().length;
             
              var invType=$("#invoicetype").val();

              var amountPaidPost=$("#amountPaid").val();
              var amountRemainDatePost=$("#amountRemainDate").val();

              var totalOfInvoice=0;
              var otherservices=0;
              var remainToDelivered;

              var $checked = $('#reservToCustTable').find(":radio:checked");
               if((invType=="reservation")){
                    $('.All_price').each(function(){
                    totalOfInvoice+=Number($(this).attr("data-amount"));
                  });

                    if ($("#otherservices_table tr").length > 1){
                        
                       $('.service_mony').each(function(){
                        otherservices+=Number($(this).attr("data-otherservicesAmount"));
                       });

                    }
                    if ($checked.length){
                      remainToDelivered = $checked[0].value;
                      // var r_id = $checked[0].id;
                    }
              
                 
               }

              if (invoiceNoLength == 0) {
                $("#myModalBody").html("يجب ادخال رقم الفاتورة");
                $( "#myModal" ).modal('show');
              }else if (!isValidDate(orderDate.toString())) {
                $("#myModalBody").html("يجب ادخال تاريخ البيع بصيغه صحيحه");
                $( "#myModal" ).modal('show');
              }else if (customerName ==0) {
                $("#myModalBody").html("يجب ادخال اسم العميل");
                $( "#myModal" ).modal('show');
              }else if ($("#crud_table tr").length < 2) {
                $("#myModalBody").html("يجب ادخال الاصناف المراد بيعها");
                $( "#myModal" ).modal('show');
              }else if ((invType=="agel")&&(amountPaid==0||!isValidDate(amountRemainDatePost.toString()))) {
                $("#myModalBody").html("يجب ادخال المبلغ المدفوع وميعاد السداد بصيغه صحيحه");
                $( "#myModal" ).modal('show');
              }else if ((invType=="agel")&&(amountPaidPost > getTotalOfInv() )) {
                $("#myModalBody").html("المبلغ المدفوع اكبر من اجمالي الفاتوره.. ادخل رقم اقل");
                $( "#myModal" ).modal('show');
              }else if ((invType=="reservation")&& !($("table#reservToCustTable").length)){
                  $("#myModalBody").html("لا يوجد حجز بهذا الاسم");
                $( "#myModal" ).modal('show');     
              }else if ((invType=="reservation")&& !($checked.length)){
                  $("#myModalBody").html("اختار الحجز الذي تريد السحب منه");
                $( "#myModal" ).modal('show');     
              }else if ((invType=="reservation")&& remainToDelivered==0){
                  $("#myModalBody").html("تم تسليم كامل المبلغ");
                $( "#myModal" ).modal('show');     
              }else if((invType=="reservation")&&(totalOfInvoice+otherservices-discount) > remainToDelivered){
                $("#myModalBody").html("المبلغ المتاح للتسليم اقل من المطلوب بيعه");
                $( "#myModal" ).modal('show');
              }else if($("#otherfeestext").val() !=""||$("#otherfeesdetails").val() !=""){
                $("#myModalBody").html("اضغط على زر الاضافه في مصاريف تخصم من الخزنه او افرغ الحقول");
                $( "#myModal" ).modal('show');
              }else if($("#otherservicesAmount").val() !=""||$("#otherservicesdetails").val() !=""){
                $("#myModalBody").html("اضغط على زر الاضافه في خدمات تضاف الى الفاتوره او افرغ الحقول");
                $( "#myModal" ).modal('show');
              }else{
              
                var csName=$('#customerName').val();
                var supID=[];
                var catID=[];
                var measID=[];
                var qant=[];
                var weight=[];
                var price=[];

                 $('.cat_suppliers').each(function(){
                   supID.push($(this).attr("data-supID"));
                  }); 
                 $('.cat_type').each(function(){
                   catID.push($(this).attr("data-catID"));
                  });
                   $('.cat_measure').each(function(){
                   measID.push($(this).attr("data-measID"));
                  }); 
                   $('.quantatiy').each(function(){
                   qant.push($(this).attr("data-qant"));
                  });
                   $('.quantatiy_type').each(function(){
                   weight.push($(this).attr("data-weight"));
                  });
                   $('.unit_price').each(function(){
                   price.push($(this).attr("data-price"));
                  });

                   var seviceMony=[];
                   var seviceDetails=[];
                   if ($("#otherservices_table tr").length > 1){
                      
                      $('.service_mony').each(function(){
                        seviceMony.push($(this).attr("data-otherservicesAmount"));
                       });
                      $('.service_details').each(function(){
                       seviceDetails.push($(this).text());
                      });
                   }
                   var feesMony=[];
                   var feesDetails=[];
                   if ($("#cotherFees_table tr").length > 1){
                      
                      $('.fees_mony').each(function(){
                       feesMony.push($(this).attr("data-otherFees"));
                      });
                      $('.fees_details').each(function(){
                       feesDetails.push($(this).text());
                      });
                   }
                   var reserve_id;
                    if (invType=="reservation"){
                     reserve_id = $checked[0].id;
                    }
                    $("body").addClass("loadingAddInv");
               $.ajax({
                url:"insertInvoice.php",
                method:'POST',
                data:{invoiceNoPost:invoiceNoPost,csID:csID,memberID:memberID,supID:supID,catID:catID,measID:measID,qant:qant,weight:weight,price:price,
                  seviceMony:seviceMony,seviceDetails:seviceDetails,feesMony:feesMony,feesDetails:feesDetails,orderDate:orderDate,
                  orderType:orderType,discount:discount,csName:csName,amountPaidPost:amountPaidPost,
                  amountRemainDatePost:amountRemainDatePost,reserve_id:reserve_id},
                
                success:function(data)
                {

                if (data=="error") {
                  $("#myModalBody").html("الفاتورة التي تحاول ادخالها موجوده بالفعل");
                $( "#myModal" ).modal('show');
                }else if (data=="error1") {
                    $("#myModalBody").html("اسم العميل غير موجود يمكن اضافة العميل بالضغط على زر اضافة عميل جديد");
                    $( "#myModal" ).modal('show');
                }
                else if (data=="error2") {
                    $("#myModalBody").html("مشكلة في اسم المستخدم سجل الدخول للبرنامج مره اخرى");
                    $( "#myModal" ).modal('show');
                }else{
                  $('#AddInvoiceForm')[0].reset();
                  $("#measure").val("");
                   $("#orderDate").datepicker("setDate", new Date());
                   

                  $("#agelDev").css("display","none");
                  $("#ReservationDev").css({"display":"none"});
                  $("#reservAndAgelHr").css({"display":"none"});
                   
                   $("#crud_table tr:gt(0)").remove();
                   $("#otherservices_table tr:gt(0)").remove();
                   $("#cotherFees_table tr:gt(0)").remove();
                   $("#unitInStockStatus").html("");

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
                    });
                    InvoicedataTable.ajax.reload();


                }

               
                },
                  complete: function() {
                  $("body").removeClass("loadingAddInv");
                  alert('تم اضافة الفاتوره بنجاح');
              }
               });

              }

              });

///////////////update customer
 // $(document).on('click', '.update', function(){
 //  var cust_id = $(this).attr("id");
 //  $.ajax({
 //   url:"fetch_single_customer.php",
 //   method:"POST",
 //   data:{cust_id:cust_id},
 //   dataType:"json",
 //   success:function(data)
 //   {
 //    $('#userModal').modal('show');
 //    $('#custName').val(data.custName);
 //    $('#phoneNumber').val(data.custPhone);
 //    $('#custAddress').val(data.custAddress);

 //    $('.modal-title').text("تعديل بيانات عميل");
 //    $('#cust_id').val(cust_id);
 //    $('#addCust').val("تعديل");
 //    $('#operation').val("Edit");
 //   }
 //  })
 // });


///show added invoice
var count = 1;
var count2 = 1;
var count1 = 1;
 $(document).on('click', '.showInvoice', function(e){

    var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }

    me.data('requestRunning', true);

    $("body").addClass("loadingPrivew");

    $("#DiscountPrinted").text("");
    $("#totalAfterDiscount").text("");
    $("#totalWithoutDiscount").text("");
    $("#amountPaidID").text("");
    $("#amountRemainID").text("");
    $("#paidDateID").text("");

   $("#catToPrint_table tr:gt(0)").remove();
   $("#otherServicesPrint_table tr:gt(0)").remove();
  var InvoiceNo = $(this).attr("id");
  $.ajax({
   url:"fetch_single_Invoice.php",
   method:"POST",
   data:{InvoiceNo:InvoiceNo},
   dataType:"json",
   success:function(data)
   {
   // alert(JSON.stringify(data));

    $('#invoiceModal').modal('show');
    $("#invoiceNo").text(InvoiceNo);
         
       $.each(data, function(idx, d){
         $("#invoiceDate").text(d.orderDate);
         $("#custNameForPrint").text(d.custName);
       

         if (d.discount != null) {
          $("#DiscountPrinted").css({"display":"block"});
          $("#totalWithoutDiscount").css({"display":"block"});

          var disc=parseInt(d.discount,10);
          disc=Number(disc).toLocaleString();
          $("#DiscountPrinted").text("خصم : "+disc +" جنيه");

          var total=parseInt(d.total,10);
          var t=Number(total).toLocaleString();
          $("#totalAfterDiscount").text("الأجمالي بعد الخصم : "+t+" جنيه");

          var totalBeforDisc=parseInt(d.total,10)+parseInt(d.discount,10);
          totalBeforDisc=Number(totalBeforDisc).toLocaleString();
          $("#totalWithoutDiscount").text("الأجمالي قبل الخصم : "+totalBeforDisc+" جنيه");
         }else{
          $("#DiscountPrinted").css({"display":"none"});
          $("#totalWithoutDiscount").css({"display":"none"});
          var total=parseInt(d.total,10);
          var t=Number(total).toLocaleString();
          $("#totalAfterDiscount").text("أجمالي الفاتوره : "+t+" جنيه");
         }
         if (d.amountPaid != null) {
          $("#amountPaidID").css({"display":"block"});
          $("#amountRemainID").css({"display":"block"});
          $("#paidDateID").css({"display":"block"});

          var amountPaid=parseInt(d.amountPaid,10);
          var amountRemain=parseInt(d.amountRemain,10);
          $("#amountPaidID").text("المبلغ المدفوع من الفاتورة : "+Number(amountPaid).toLocaleString() +" جنيه");
          $("#amountRemainID").text("المبلغ المتبقي من الفاتورة : "+Number(amountRemain).toLocaleString() +" جنيه");
          $("#paidDateID").text("ميعاد سداد المتبقي : "+d.paidDate);
         }else{
          $("#amountPaidID").css({"display":"none"});
          $("#amountRemainID").css({"display":"none"});
          $("#paidDateID").css({"display":"none"});
         }
       

         var measNameItems=d.measName;

          $.each(measNameItems, function(i, ork) {
            var html_code = "<tr id='row"+count+"'>";
            html_code += "<td>"+d.suppName[i]+"  "+d.catName[i]+"  "+d.measName[i]+"</td>";

            var qant;
           if ((d.Quantity[i])%1000==0) {
            qant=(d.Quantity[i])/1000 +" طن";
           }else{
            qant=d.Quantity[i] +" كيلو";
           }

            html_code += "<td>"+qant+"</td>";
            html_code += "<td>"+Number(d.unitPrice[i]).toLocaleString()+" "+"جنيه"+"</td>";

            var cost=((d.Quantity[i]*d.unitPrice[i])/1000);
            var cost1=parseInt(cost,10);

            html_code += "<td>"+Number(cost1).toLocaleString()+"  "+"جنيه"+"</td>";
            html_code += "</tr>";
            $('#catToPrint_table').append(html_code);
            count = count + 1;
          });

          var plusfeeAmountItems=d.plusfeeAmount;

          if (plusfeeAmountItems == null) {
            $(".otherFeesDiv").css({"display":"none"});
          }else{
            $(".otherFeesDiv").css({"display":"block"});
          }

          $.each(plusfeeAmountItems, function(i, ork) {
            var html_code = "<tr id='row"+count2+"'>";
            html_code += "<td>"+d.plusfeeReason[i]+"</td>";
            html_code += "<td>"+Number(d.plusfeeAmount[i]).toLocaleString()+" "+"جنيه"+"</td>";
            html_code += "</tr>";
            $('#otherServicesPrint_table').append(html_code);
            count2 = count2 + 1;
          });


       
       }); 
   },
   complete: function() {
            me.data('requestRunning', false);
            $("body").removeClass("loadingPrivew");
        }

  });
 });





//print invoice
 $(document).on('click', '.printInvoice', function(e){

    var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }

    me.data('requestRunning', true);
    $("body").addClass("loadingPrint");

    $("#DiscountPrinted1").text("");
    $("#totalAfterDiscount1").text("");
    $("#totalWithoutDiscount1").text("");
     $("#amountPaidID1").text("");
    $("#amountRemainID1").text("");
    $("#paidDateID1").text("");

   $("#catToPrint_table1 tr:gt(0)").remove();
   $("#otherServicesPrint_table1 tr:gt(0)").remove();
  var InvoiceNo = $(this).attr("id");

  $.ajax({
   url:"fetch_single_Invoice.php",
   method:"POST",
   data:{InvoiceNo:InvoiceNo},
   dataType:"json",
   success:function(data)
   {
   // alert(JSON.stringify(data));

  var win=  window.open("", "",
     "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
  var htmlelemnt="<div class='row'><div class='col-md-12'><img  style='width:180px;height:105px;margin-left: auto;margin-right: auto;display: block;' src='/img/logoToPrint.png'/> </div></div>"; 
  
   win.document.write('<html><head><title>Print it!</title><link href="css/bootstrap.min.css" rel="stylesheet" /><script src="js/jquery-2.2.4.min.js"></script><link rel="stylesheet" type="text/css" href="css/printer.css"></head><body>');     
       htmlelemnt +="<div class='row con'  style='margin-top:35px'><div class='col-md-6'>";

       $.each(data, function(idx, d){
         // $("#custNameForPrint1").text(d.custName);

        
   var measNameItems=d.measName;

   htmlelemnt +="<div class='row con'><label id='invoiceDate1' style='position:relative;float:left'>"+d.orderDate+"</label><label id='invoiceNo1' style='float:left;margin-left:100px'>"+InvoiceNo+"</label></div>";
   htmlelemnt +="<div class='row con' ><button id='btnInvoiceNo1' style='float:left; border: 0;background:none;box-shadow:none;border-radius:0px;background-color:#D3D3D3;font-size:20px;width:250px;height:40'>بيـــــــان</button></div></div>"
   
   htmlelemnt +="<div class='col-md-6'><div class='row con' ><label style='text-align:justify;float:right;font-size:19px;'>العســــــــــــــــــــــــــــــــــــــــال لتجارة الحديد</label></div>";

   htmlelemnt +="<div class='row con' ><label style='margin-right:70px;text-align:justify;float:right;font-size:15px;color:gray'>حمدي العسال</label></div>";
   htmlelemnt +="<div class='row con' ><label style='margin-right:20px;text-align:justify;float:right;font-size:15px;color:gray'>الشرقيه - فاقــــوس - أول مدخل فاقوس</label></div>";
   htmlelemnt +=" <div class='row con' ><label style='text-align:justify;float:right;font-size:15px;color:gray'>0553980800 - 01095555561 - 01095555562</label></div></div>";
   htmlelemnt +="</div>";

    htmlelemnt +="<div class='row con' ><div class='col-lg-6'></div><div class='col-lg-6' style='margin-top:3px'><div class='row con' >";
    htmlelemnt +="<label id='' style='position:relative;float:left;font-size:16px;margin-left:30px;width:200px'>بيـــان بأسم : </label></div>";
    htmlelemnt +=" <div class='row con' ><label id='custNameForPrint1' style='position:relative;float:left;font-size:14px;color:gray;width:200px;margin-left:30px'>"+d.custName+"</label></div></div></div>";
    htmlelemnt +="<div class='row con' > <div class='col-md-12'><div class='table-responsive' style='margin-top:30px'><table class='table table-bordered' id='catToPrint_table1'><thead><tr style='background-color: #FBB900;color: #B80303'><th width='45%'>الصنف</th><th width='22%'>الكمية</th><th width='16%'>سعر الطن</th><th width='17%'>سعر التكلفة</th></tr></thead>";



          $.each(measNameItems, function(i, ork) {
            //var html_code = "<tr id='row"+count+"'>";
            htmlelemnt +="<tr id='row"+count+"'>";
            htmlelemnt +="<td>"+d.suppName[i]+"  "+d.catName[i]+"  "+d.measName[i]+"</td>";
           // html_code += "<td>"+d.suppName[i]+"  "+d.catName[i]+"  "+d.measName[i]+"</td>";

            var qant;
           if ((d.Quantity[i])%1000==0) {
            qant=(d.Quantity[i])/1000 +" طن";
           }else{
            qant=d.Quantity[i] +" كيلو";
           }  

            htmlelemnt += "<td>"+qant+"</td>";
            htmlelemnt += "<td>"+Number(d.unitPrice[i]).toLocaleString()+" "+"جنيه"+"</td>";
            
             var cost=((d.Quantity[i]*d.unitPrice[i])/1000);
            var cost1=parseInt(cost,10);

            htmlelemnt += "<td>"+Number(cost1).toLocaleString()+"  "+"جنيه"+"</td>";
            htmlelemnt += "</tr>";
            //$('#catToPrint_table1').append(html_code);
            count1 = count1 + 1;
          });


          var plusfeeAmountItems=d.plusfeeAmount;

            htmlelemnt += "</table></div></div></div>";
           htmlelemnt +="<div class='row con' ><div class='col-md-6'>";

          if (plusfeeAmountItems != null) {
            $(".otherFeesDiv1").css({"display":"none"});
           htmlelemnt +="<div class='table-responsive otherFeesDiv1' style='margin-top:30px;width:50%'><table class='table table-bordered' id='otherServicesPrint_table1'><thead><tr style='background-color: #FBB900;color: #B80303'><th width='60%'>خدمات إضافيه</th><th width='40%'>المبلغ</th></tr></thead>"
          }
         



         

          $.each(plusfeeAmountItems, function(i, ork) {
            htmlelemnt += "<tr id='row"+count2+"'>";
            htmlelemnt += "<td>"+d.plusfeeReason[i]+"</td>";
            htmlelemnt += "<td>"+Number(d.plusfeeAmount[i]).toLocaleString()+" "+"جنيه"+"</td>";
            htmlelemnt += "</tr>";
            //$('#otherServicesPrint_table1').append(html_code);
            count1= count1 + 1;
          });

          var DiscountPrinted;
          var totalAfterDiscount;
          var totalWithoutDiscount;

           if (d.discount != null) {
            $("#DiscountPrinted1").css({"display":"block"});
            $("#totalWithoutDiscount1").css({"display":"block"});
            var desc=parseInt(d.discount,10);
              DiscountPrinted="خصم : "+Number(desc).toLocaleString() +" جنيه";
              var total=parseInt(d.total,10);
              totalAfterDiscount="الأجمالي بعد الخصم : "+Number(total).toLocaleString()+" جنيه";
              var totalBeforDisc=parseInt(d.total,10)+parseInt(d.discount,10);
              totalWithoutDiscount="الأجمالي قبل الخصم : "+Number(totalBeforDisc).toLocaleString()+" جنيه";
         }else{
         $("#DiscountPrinted1").css({"display":"none"});
            $("#totalWithoutDiscount1").css({"display":"none"});

          DiscountPrinted="";
          totalWithoutDiscount="";
          var total=parseInt(d.total,10);
          totalAfterDiscount="أجمالي الفاتوره : "+Number(total).toLocaleString()+" جنيه";
         }

            var amountPaidID1="";
            var amountRemainID1="";
            var paidDateID1="";

            if (d.amountPaid != null) {
                $("#amountPaidID1").css({"display":"block"});
                $("#amountRemainID1").css({"display":"block"});
                $("#paidDateID1").css({"display":"block"});
                var amount=parseInt(d.amountPaid,10);
              amountPaidID1="المبلغ المدفوع من الفاتورة : "+Number(amount).toLocaleString()+" جنيه";
              amountRemainID1="المبلغ المتبقي من الفاتورة : "+Number(d.amountRemain).toLocaleString() +" جنيه";
              paidDateID1="ميعاد سداد المتبقي : "+d.paidDate;
           }else{
           
             $("#amountPaidID1").css({"display":"none"});
              $("#amountRemainID1").css({"display":"none"});
              $("#paidDateID1").css({"display":"none"});
           }


        htmlelemnt +="</table></div></div><div class='col-lg-6'style='margin-top:35px'><div class='row con' ><label id='totalWithoutDiscount1' style='position:relative;float:left;font-size:13px;color:gray;width:250px'>"+totalWithoutDiscount+"</label></div>";
        htmlelemnt +="<div class='row con' ><label id='DiscountPrinted1' style='position:relative;float:left;font-size:13px;color:gray;width:250px'>"+DiscountPrinted+"</label></div>";
        htmlelemnt +="<div class='row con' ><button id='btnTotal' style='padding-left:0px;position:relative;float:left;text-align:right; border: 0;background:none;box-shadow:none;border-radius:0px;background-color:#D3D3D3;font-size:14px;width:250px;height:40'>"+totalAfterDiscount+"</button></div>";
        htmlelemnt +="<div class='row con' ><label id='amountPaidID1' style='position:relative;float:left;font-size:13px;color:gray;width:250px'>"+amountPaidID1+"</label></div>";
        htmlelemnt +="<div class='row con' ><label id='amountRemainID1' style='position:relative;float:left;font-size:13px;color:gray;width:250px'>"+amountRemainID1+"</label></div>";
        htmlelemnt +="<div class='row con' ><label id='paidDateID1' style='position:relative;float:left;font-size:13px;color:gray;width:250px'>"+paidDateID1+"</label></div>";
        htmlelemnt +="</div></div>";
      

       


       }); 
win.document.write(htmlelemnt);
win.document.write("<div class='row' style='position: fixed;bottom:10px;width: 100%;'><label style='margin-left: auto;margin-right: auto;float:left;position:relative;font-size:11px;color:gray;width:400px'>"+"الاستبدال لا يتم إلا بالفاتوره خلال 5 ايام من تاريخ الشراء"+"</label></div></body></html>"); 
win.document.close();
setTimeout(function(){
    win.focus();
    win.print();
    win.close();
},1000);
    
   },
   complete: function() {
            me.data('requestRunning', false);
            $("body").removeClass("loadingPrint");
        }
       

  });


 });

//show invoice before print
$(document).on('click', '#showInvoice', function(e){

var RemainDate=$("#amountRemainDate").val();
if ($("#invoicetype").val()=="agel" &&($("#amountPaid").val()==""||$("#amountRemainDate").val()=="")) {
$("#myModalBody").html("لمعاينة الفاتورة يجب ادخال المبلغ المدفوع وميعاد سداد المتبقي");
 $( "#myModal" ).modal('show');
 return;
}else if (($("#invoicetype").val() == "agel")&&($("#amountPaid").val() == ""||!isValidDate(RemainDate.toString()) )) {
  $("#myModalBody").html("لمعاينة الفاتورة يجب ادخال المبلغ المدفوع وتاريخ سداد المتبقي بصيغه صحيحه");
   $( "#myModal" ).modal('show');
   return;
}else if (($("#invoicetype").val() == "agel")&&($("#amountPaid").val() > getTotalOfInv() )) {
  $("#myModalBody").html("المبلغ المدفوع اكبر من اجمالي الفاتوره.. ادخل رقم اقل");
   $( "#myModal" ).modal('show');
   return;
}
if ($("#crud_table tr").length > 1){

    $("#DiscountPrinted").text("");
    $("#totalAfterDiscount").text("");
    $("#totalWithoutDiscount").text("");

    $("#amountPaidID").text("");
    $("#amountRemainID").text("");
    $("#paidDateID").text("");


    $("#catToPrint_table tr:gt(0)").remove();
    $("#otherServicesPrint_table tr:gt(0)").remove();
    

    $('#invoiceModal').modal('show');
    $("#invoiceNo").text($("#orderNo").val());

    $("#invoiceDate").text($("#orderDate").val());
    $("#custNameForPrint").text($("#customerName").val());

 

   var totalAmountOfItems=0;
   var tr = document.getElementById('crud_table').rows;
   var td = null;
      
   for (var i = 1; i < tr.length; ++i) {    
    var html_code = "<tr id='row"+i+"'>";

    td = tr[i].cells;

    var unitcost = $('#crud_table tr').find(td).eq(5).attr("data-price");
    var itemAmount=$('#crud_table tr').find(td).eq(6).attr("data-amount");

       
    html_code += "<td>"+td[0].innerHTML+"  "+td[1].innerHTML+"  "+td[2].innerHTML+"</td>";
    html_code += "<td>"+td[3].innerHTML+" "+td[4].innerHTML+"</td>";
    html_code += "<td>"+Number(unitcost).toLocaleString()+" "+"جنيه"+"</td>";

    html_code += "<td>"+Number(itemAmount).toLocaleString()+"  "+"جنيه"+"</td>";
    
    html_code += "</tr>"; 
   $('#catToPrint_table').append(html_code);

   totalAmountOfItems+=Number(itemAmount);

  }

var tr2 = document.getElementById('otherservices_table').rows;
var td2 = null;
var totalOterServices=0;
if ($("#otherservices_table tr").length > 1){
  $(".otherFeesDiv").css({"display":"block"});
    for (var i = 1; i < tr2.length; ++i) {
      td2 = tr2[i].cells; 
      var html_code = "<tr id='row"+i+"'>";
            
      var otherservicesAmount = $('#otherservices_table tr').find(td2).eq(0).attr("data-otherservicesAmount");

     html_code += "<td>"+td2[1].innerHTML+"</td>";
     html_code += "<td>"+otherservicesAmount+" جنيه</td>";
       
     html_code += "</tr>"; 
    $('#otherServicesPrint_table').append(html_code);

    totalOterServices+=Number(otherservicesAmount);
}

}else{
  $(".otherFeesDiv").css({"display":"none"});
}


    var totalBeforDisc=parseInt(totalAmountOfItems,10)+parseInt(totalOterServices,10);
    var total;
  
  if ($("#discount").val() != "") {

     total =parseInt(totalBeforDisc,10)-parseInt($("#discount").val(),10);
    $("#DiscountPrinted").text("خصم : "+Number($("#discount").val()).toLocaleString() +" جنيه");
    $("#totalAfterDiscount").text("الأجمالي بعد الخصم : "+Number(total).toLocaleString()+" جنيه");
    
    $("#totalWithoutDiscount").text("الأجمالي قبل الخصم : "+Number(totalBeforDisc).toLocaleString()+" جنيه");
 }else{
  total=totalBeforDisc;
  $("#totalAfterDiscount").text("أجمالي الفاتوره : "+Number(totalBeforDisc).toLocaleString()+" جنيه");
 }


 
 if(($("#invoicetype").val() == "agel")&&($("#amountPaid").val() != ""&& $("#amountRemainDate").val() !="")){
          
          var amountRemain=parseInt((total-($("#amountPaid").val())),10);

          $("#amountPaidID").text("المبلغ المدفوع من الفاتورة : "+Number($("#amountPaid").val() ).toLocaleString()+" جنيه");

          $("#amountRemainID").text("المبلغ المتبقي من الفاتورة : "+Number(amountRemain).toLocaleString() +" جنيه");
          $("#paidDateID").text("ميعاد سداد المتبقي : "+$("#amountRemainDate").val());
}


}else{

 $("#myModalBody").html("لمعاينة الفاتورة يجب ادخال الاصناف المراد بيعها");
 $( "#myModal" ).modal('show');

}


 });
/////////////////get total of invoice before added
function getTotalOfInv(){
  if ($("#crud_table tr").length > 1){
    var totalAmountOfItems=0;
   var tr = document.getElementById('crud_table').rows;
   var td = null;
      
   for (var i = 1; i < tr.length; ++i){
    td = tr[i].cells;
     var itemAmount=$('#crud_table tr').find(td).eq(6).attr("data-amount");
     totalAmountOfItems+=Number(itemAmount);
   }
 }

  var tr2 = document.getElementById('otherservices_table').rows;
  var td2 = null;
  var totalOterServices=0;
  if ($("#otherservices_table tr").length > 1){
    for (var i = 1; i < tr2.length; ++i){
      td2 = tr2[i].cells; 
      var otherservicesAmount = $('#otherservices_table tr').find(td2).eq(0).attr("data-otherservicesAmount");
      totalOterServices+=Number(otherservicesAmount);
    }
    
  }
   var totalBeforDisc=parseInt(totalAmountOfItems,10)+parseInt(totalOterServices,10);
    var total;
    if ($("#discount").val() != ""){
      total =parseInt(totalBeforDisc,10)-parseInt($("#discount").val(),10);
    }else{
      total=totalBeforDisc;
    }

  return total;
}

////////////////Handle Mortg3///////////////////////////////
///show erga3 model
var count8 = 1;
 $(document).on('click', '.erga3', function(e){

    var me = $(this);
    e.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }

    me.data('requestRunning', true);
    $("body").addClass("loadingErga3");

    $("#invoiceNoInMortg3Lbl").text("");
    $("#custNameInMortg3Lbl").text("");
    $("#erga3InvoiceNoHidden").val("");
    $("#itemsToErga3_table tr:gt(0)").remove();
    $("#LastErga3_table tr:gt(0)").remove();

  var InvoiceNo = $(this).attr("id");
  $.ajax({
   url:"fetch_single_Invoice_for_erga3.php",
   method:"POST",
   data:{InvoiceNo:InvoiceNo},
   dataType:"json",
   success:function(data)
   {
   // alert(JSON.stringify(data));

    $('#erga3Modal').modal('show');
    $("#erga3InvoiceNoHidden").val(InvoiceNo);
    $("#invoiceNoInMortg3Lbl").text("رقم الفاتوره : "+InvoiceNo);
         
       $.each(data, function(idx, d){

         $("#custNameInMortg3Lbl").text("اسم العميل : "+d.custName);
       

         var measNameItems=d.measName;

          $.each(measNameItems, function(i, ork) {
            var html_code = "<tr id='mortg3row"+count8+"'>";
            html_code += "<td>"+d.suppName[i]+"  "+d.catName[i]+"  "+d.measName[i]+"</td>";

            var qant;
           if ((d.Quantity[i])%1000==0) {
            qant=(d.Quantity[i])/1000 +" طن";
           }else{
            qant=d.Quantity[i] +" كيلو";
           }

            html_code += "<td>"+qant+"</td>";
            html_code += "<td>"+Number(d.unitPrice[i]).toLocaleString()+" "+"جنيه"+"</td>";

            var cost=((d.Quantity[i]*d.unitPrice[i])/1000);
            var cost1=parseInt(cost,10);

            html_code += "<td>"+Number(cost1).toLocaleString()+"  "+"جنيه"+"</td>";

            var availbleToErga3;
            if ((d.outQuantity[i]) != null) {
              availbleToErga3=d.Quantity[i]-d.outQuantity[i];
            }else{
              availbleToErga3=d.Quantity[i];
            }

            if (availbleToErga3%1000==0) {
              availbleToErga3=availbleToErga3/1000 +" طن";
             }else{
              availbleToErga3=availbleToErga3+" كيلو";
             }

             html_code += "<td>"+availbleToErga3+"</td>";

 var erga3Price="<div class='input-group'><input type='text' id='ergP"+d.orderDetailsID[i]+"' class='form-control' placeholder='سعر الطن'/></div>";

 var erga3Quant=" <div class='input-group'><input type='text' id='ergQ"+d.orderDetailsID[i]+"' class='form-control' placeholder='الكميه بالكيلو'/><span class='input-group-btn'><input type='button' data-erga3Quant='"+d.orderDetailsID[i]+"' value='+' class='btn erga3QuantBtn'/></span></div>"; 

            html_code += "<td>"+erga3Price+"</td>";
            html_code += "<td>"+erga3Quant+"</td>";

            html_code += "</tr>";
            $('#itemsToErga3_table').append(html_code);
            count8 = count8 + 1;
          });
////////////////////fetch last mortga3//////////////////////////////

         var measNameItems1;
         if (d.measName1 != null) {
          measNameItems1=d.measName1;
          
          $('#lastMortg3TableDiv').css('display','block');

          $.each(measNameItems1, function(j, lst) {
            var html_code = "<tr>";
            html_code += "<td>"+d.suppName1[j]+"  "+d.catName1[j]+"  "+d.measName1[j]+"</td>";

            var mortg3Quant;
           if ((d.mortg3Quant[j])%1000==0) {
            mortg3Quant=(d.mortg3Quant[j])/1000 +" طن";
           }else{
            mortg3Quant=d.mortg3Quant[j] +" كيلو";
           }

            html_code += "<td>"+d.mortg3Date[j]+"</td>";
            html_code += "<td>"+mortg3Quant+"</td>";
            html_code += "<td>"+Number(d.unitPrice1[j]).toLocaleString()+" "+"جنيه"+"</td>";

            var cost=((d.mortg3Quant[j]*d.unitPrice1[j])/1000);
            var cost1=parseInt(cost,10);

            html_code += "<td>"+Number(cost1).toLocaleString()+"  "+"جنيه"+"</td>";

            html_code += "</tr>";
            $('#LastErga3_table').append(html_code);
            
          });

         }else{
          $('#lastMortg3TableDiv').css('display','none');
         }

////////////////////fetch last mortga3//////////////////////////////
        
      
       }); 
   },
   complete: function() {
            me.data('requestRunning', false);
            $("body").removeClass("loadingErga3");
        }

  });
 });

///end show erga3 model

//erga3 operation
var count9=1;
 $(document).on('click','.erga3QuantBtn', function(e){
  
 
  var orderDetailsID = $(this).attr("data-erga3Quant");

  var erga3UnitPrice = $("input#ergP"+orderDetailsID+"").val();
  var erga3Quant = $("input#ergQ"+orderDetailsID+"").val();

  var InvoiceNo =$("#erga3InvoiceNoHidden").val();

  if (erga3UnitPrice =="") {
    alert("يجب ادخال سعر الطن");
  }else if(erga3Quant ==""){
    alert("يجب ادخال الكميه المراد ارجاعها");
  }else if (!$.isNumeric(erga3UnitPrice)) {
    alert("يجب ادخال سعر الطن ارقام وليس حروف");
  }else if(!$.isNumeric(erga3Quant)){
    alert("يجب ادخال الكميه المراد ارجاعها ارقام وليس حروف");
  }else{
$("body").addClass("loadingAddInv");
   $.ajax({
     url:"mortg3.php",
     method:"POST",
     data:{erga3UnitPrice:erga3UnitPrice,erga3Quant:erga3Quant,orderDetailsID:orderDetailsID,InvoiceNo:InvoiceNo},
    
     success:function(data)
     {
     
      if ($.trim(data)==="e1") {
       alert("تم إرجاع كامل الكمية من هذا المنتج");
      }else if ($.trim(data)==="e2") {
       alert("الكمية المراد إرجاعها اكبر من المتاح للارجاع !! ادخل كميه اقل او تساوي المتاح للارجاع.");
       
      }else if ($.trim(data)==="e3"){
       alert("لم يتم الارجاع حدث الصفحه وحاول مره اخرى");
      }else{
  /////////////////// ///////////////////

    $("#invoiceNoInMortg3Lbl").text("");
    $("#custNameInMortg3Lbl").text("");
    $("#itemsToErga3_table tr:gt(0)").remove();
    $("#LastErga3_table tr:gt(0)").remove();

  
  
  $.ajax({
   url:"fetch_single_Invoice_for_erga3.php",
   method:"POST",
   data:{InvoiceNo:InvoiceNo},
   dataType:"json",
   success:function(data)
   {
   
    $('#erga3Modal').modal('show');
    $("#invoiceNoInMortg3Lbl").text("رقم الفاتوره : "+InvoiceNo);
         
       $.each(data, function(idx, d){

         $("#custNameInMortg3Lbl").text("اسم العميل : "+d.custName);
       


         var measNameItems=d.measName;

          $.each(measNameItems, function(i, ork) {
            var html_code = "<tr id='mortg3row"+count9+"'>";
            html_code += "<td>"+d.suppName[i]+"  "+d.catName[i]+"  "+d.measName[i]+"</td>";

            var qant;
           if ((d.Quantity[i])%1000==0) {
            qant=(d.Quantity[i])/1000 +" طن";
           }else{
            qant=d.Quantity[i] +" كيلو";
           }

            html_code += "<td>"+qant+"</td>";
            html_code += "<td>"+Number(d.unitPrice[i]).toLocaleString()+" "+"جنيه"+"</td>";

            var cost=((d.Quantity[i]*d.unitPrice[i])/1000);
            var cost1=parseInt(cost,10);

            html_code += "<td>"+Number(cost1).toLocaleString()+"  "+"جنيه"+"</td>";

            var availbleToErga3;
            if ((d.outQuantity[i]) != null) {
              availbleToErga3=d.Quantity[i]-d.outQuantity[i];
            }else{
              availbleToErga3=d.Quantity[i];
            }

            if (availbleToErga3%1000==0) {
              availbleToErga3=availbleToErga3/1000 +" طن";
             }else{
              availbleToErga3=availbleToErga3+" كيلو";
             }

             html_code += "<td>"+availbleToErga3+"</td>";

 var erga3Price="<div class='input-group'><input type='text' id='ergP"+d.orderDetailsID[i]+"' class='form-control' placeholder='سعر الطن'/></div>";

 var erga3Quant=" <div class='input-group'><input type='text' id='ergQ"+d.orderDetailsID[i]+"' class='form-control' placeholder='الكميه بالكيلو'/><span class='input-group-btn'><input type='button' data-erga3Quant='"+d.orderDetailsID[i]+"' value='+' class='btn erga3QuantBtn'/></span></div>"; 

            html_code += "<td>"+erga3Price+"</td>";
            html_code += "<td>"+erga3Quant+"</td>";

            html_code += "</tr>";
            $('#itemsToErga3_table').append(html_code);
            count9 = count9 + 1;
          });
  ////////////////////fetch last mortga3//////////////////////////////

         var measNameItems1;
         if (d.measName1 != null) {
          measNameItems1=d.measName1;
          
          $('#lastMortg3TableDiv').css('display','block');

          $.each(measNameItems1, function(j, lst) {
            var html_code = "<tr>";
            html_code += "<td>"+d.suppName1[j]+"  "+d.catName1[j]+"  "+d.measName1[j]+"</td>";

            var mortg3Quant;
           if ((d.mortg3Quant[j])%1000==0) {
            mortg3Quant=(d.mortg3Quant[j])/1000 +" طن";
           }else{
            mortg3Quant=d.mortg3Quant[j] +" كيلو";
           }

            html_code += "<td>"+d.mortg3Date[j]+"</td>";
            html_code += "<td>"+mortg3Quant+"</td>";
            html_code += "<td>"+Number(d.unitPrice1[j]).toLocaleString()+" "+"جنيه"+"</td>";

            var cost=((d.mortg3Quant[j]*d.unitPrice1[j])/1000);
            var cost1=parseInt(cost,10);

            html_code += "<td>"+Number(cost1).toLocaleString()+"  "+"جنيه"+"</td>";

            html_code += "</tr>";
            $('#LastErga3_table').append(html_code);
            
          });

         }else{
          $('#lastMortg3TableDiv').css('display','none');
         }

////////////////////fetch last mortga3//////////////////////////////
        
      
       }); 
   },
     complete: function() {
      $("body").removeClass("loadingAddInv");
        }

  });
/////////////////// ///////////////////

      }
    }

  });
 }
 
 });
//end erga3 operation





});//end ready fn


