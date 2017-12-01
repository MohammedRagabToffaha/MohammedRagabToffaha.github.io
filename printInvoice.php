

<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title></title>
	<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

</head>

<body>

 
    <div id='print-me1'>

      <div class='row con' >
        <div class='col-lg-6'>

        </div>
        <div class='col-lg-6' >
          <img  id='logo2' style='position:relative;float:left' src='img/logo.png'>  
        </div>
     </div>
      <div class='row con' >
          <div class='col-lg-6'>

        </div>
        <div class='col-lg-6' style='margin-top:50px'>
        	<div class='row con' >
          <label id='invoiceDate1' style='position:relative;float:left'></label>
          <label id='invoiceNo1' style='position:relative;float:left;margin-left:50px'></label>
      </div>
      <div class='row con' >
       <button id='btnInvoiceNo1' style='position:relative;float:left; border: 0;background:none;box-shadow:none;
  border-radius:0px;background-color:#D3D3D3;font-size:20px;width:210px;height:40'>فاتورة</button></div>
        </div>

     </div>


       <div class='row con' >
          <div class='col-lg-6'>
            <div class='row con' ><label style='text-align:justify;position:relative;float:right;font-size:19px;'>العســــــــال لتجارة الحديد</label></div>
            <div class='row con' ><label style='text-align:justify;position:relative;float:right;font-size:15px;color:gray'>فاقــــوس بجوار مفارق الغزالي</label></div>
            <div class='row con' ><label style='text-align:justify;position:relative;float:right;font-size:15px;color:gray'>01120756560 - 01019862475</label></div>
        </div>
        <div class='col-lg-6' >
         
        </div>

     </div> 
      <div class='row con' >
          <div class='col-lg-6'>
         
         </div>
        <div class='col-lg-6' style='margin-top:50px'>
          <div class='row con' ><label id='' style='position:relative;float:left;font-size:16px;margin-left:30px;width:200px'>فاتورة بأسم : </label></div>
          <div class='row con' ><label id='custNameForPrint1' style='position:relative;float:left;font-size:14px;color:gray;width:200px;margin-left:30px'></label></div>
        </div>

     </div>
         <div class='row con' >
                        <div class='col-md-12'>
                            <div class='table-responsive' style='margin-top:50px'>
                                  <table class='table table-bordered' id='catToPrint_table1'>
                                    <thead>
                                     <tr style='background-color: #FBB900;color: #B80303'>
                                      <th width='36%'>الصنف</th>
                                      <th width='20%'>الكمية</th>
                                      <th width='22%'>سعر الطن</th>
                                      <th width='22%'>سعر التكلفة</th>
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                      
                </div>
              </div>
                 <div class='row con' >
                        <div class='col-md-6'>
                            <div class='table-responsive otherFeesDiv1' style='margin-top:80px;width:100%'>
                                  <table class='table table-bordered' id='otherServicesPrint_table1'>
                                    <thead>
                                     <tr style='background-color: #FBB900;color: #B80303'>
                                      <th width='60%'>خدمات إضافيه</th>
                                      <th width='40%'>المبلغ</th>
                                      
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                      
                </div>
                  <div class='col-lg-6'style='margin-top:75px'>
                      <div class='row con' ><label id='totalWithoutDiscount1' style='position:relative;float:left;font-size:13px;color:gray;margin-left:20px;width:250px'></label></div>
                      <div class='row con' ><label id='DiscountPrinted1' style='position:relative;float:left;font-size:13px;color:gray;margin-left:20px;width:250px'></label></div>
                      <div class='row con' ><label id='totalAfterDiscount1' style='position:relative;float:left;font-size:13px;margin-left:20px;width:250px'></label></div>
                  </div>
              </div>


        <div class='row con' id='appendPhoto' >
          
     </div>
   </div>



</body>

</html>

