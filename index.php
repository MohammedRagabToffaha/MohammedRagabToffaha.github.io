<?php 
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
 
}else{
  
    header("location:LoginCredintial.php");
  
}
// if ((! @file_get_contents("el3sal.000webhostapp.com/dailyOrders.php")&& ! @file_get_contents("el3sal.000webhostapp.com/LoginCredintial.php")))
//     {
//         header("location:https://gesal.000webhostapp.com");
//     }
// if (isset($_POST['upload_image'])) {
//   # code...
//   echo "<script>alert(".$_FILES["image_file"]["name"].")</script>";
//   echo "<script>alert("."fkfo".")</script>";
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="محافظة الشرقيه - فاقوس - أول مدخل فاقوس - التواصل عن طريق رقم تليفون 0553980800 - 01095555561 - 01095555562">

    <title>
        <?php
        if (isset($_GET["page"])) {
          if ($_GET["page"]=="dailyOrders") {
            echo "يومية البيع";
          }else if ($_GET["page"]=="longTermSales") {
            echo "آجل بيع";
          }else if ($_GET["page"]=="customersReport") {
            echo "كشف حسابات عملاء البيع";
          }else if ($_GET["page"]=="nonePaidInvoices") {
            echo "فواتير مستحقة التحصيل";
          }else if ($_GET["page"]=="longTermPurchase") {
            echo "آجل شراء";
          }else if ($_GET["page"]=="supplierReport") {
            echo "كشف حساب عملاء الشراء";
          }else if ($_GET["page"]=="msrofat") {
            echo "مصروفات مستحقة الدفع";
          }else if ($_GET["page"]=="customers") {
            echo "قائمة العملاء";
          }else if ($_GET["page"]=="suppliers") {
            echo "قائمة المنتجات";
          }else if ($_GET["page"]=="elmordeen") {
            echo "قائمة وكلاء الشراء";
          }else if ($_GET["page"]=="stock") {
            echo "جرد المخزن";
          }else if ($_GET["page"]=="khazna") {
            echo "الخزنة الرئيسيه";
          }else if ($_GET["page"]=="reservation") {
            echo "دفتر الحجز";
          }else if ($_GET["page"]=="mortg3AwelElmoda") {
            echo "مرتجع بدون فاتوره";
          }else if ($_GET["page"]=="dailyReport") {
            echo "تقرير يومي";
          }else if ($_GET["page"]=="msrofatReport") {
            echo "تقرير المصروفات";
          }else if ($_GET["page"]=="mby3atReport") {
            echo "تقرير المبيعات";
          }else if ($_GET["page"]=="nawloon") {
            echo "شركات النقل والناولون";
          }else if ($_GET["page"]=="arbta") {
            echo "بيع ربطة للخرده";
          }
            
        }else{
           echo "يومية البيع";
        }
       ?>
    </title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet" />
   <link href="css/sb-admin-2.css" rel="stylesheet" />
    <link href="css/font-awesome/font-awesome.min.css" rel="stylesheet" />
    
      <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
       <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
      
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link href="css/bootstrap-override.css" rel="stylesheet"/>
        <script type="text/javascript" src="js/printPreview.js"></script>
        <script type="text/javascript" src="js/html2canvas.js"></script>
        <script type="text/javascript" src="js/dom-to-image.js"></script>
        <script type="text/javascript" src="js/domvas.js"></script>


    <link rel="stylesheet" href="style.css" type="text/css" />
  <script type="text/javascript" src="js/insertDepositImgScript.js"></script>

         
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar .navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            
            <a class="navbar-brand " id="logoutbtn"  style="color:#FAB900" 
              onmouseover="this.style.color='#400403'" onmouseout="this.style.color='#FAB900'"
             rel="logout" href="logout.php" data-toggle="tooltip" title="تسجيل الخروج"><i class="fa fa-power-off fa-fw"></i> </a>
            <a class="navbar-brand " id="user" style="color:white;padding-right:0px"
                onmouseover="this.style.color='#400403'" onmouseout="this.style.color='#FFF'"
             rel="username" href="#"  data-toggle="modal" data-target="#userdataModal"  title="<?php echo ($_SESSION["name"]);?>"><i class="fa fa-user fa-fw"></i> </a>
           
            <a class=" "style="color:white;float:left" rel="home" href="/" ><img  id="logo"  src="img/logo.png"></a>
            

            </div>
           
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav collapse navbar-collapse">
                    <ul class="nav" id="side-menu">
                       
                         <li >
                            <a href="?page=dailyOrders"  <?php if ((isset($_GET["page"]) && ($_GET["page"]== "dailyOrders"))||!isset($_GET["page"])) { ?> class="active" <?php } ?>><i class="fa fa-table fa-fw"></i> يومية البيع</a>
                        </li>
                         <li >
                            <a href="?page=longTermSales" <?php if (isset($_GET["page"]) && ($_GET["page"]== "longTermSales")) { ?> class="active" <?php } ?>><i class="fa fa-users fa-fw"></i> آجل بيع</a>
                        </li> 

                         <li >
                            <a href="?page=longTermSale" <?php if (isset($_GET["page"]) && ($_GET["page"]== "longTermSale")) { ?> class="active" <?php } ?>><i class="fa fa-users fa-fw"></i> آجل بيع</a>
                        </li> 

                        <li >
                            <a href="?page=mby3atReport" <?php if (isset($_GET["page"]) && ($_GET["page"]== "mby3atReport")) { ?> class="active" <?php } ?>><i class="fa fa-area-chart fa-fw"></i>تقرير المبيعات</a>
                        </li>
                        
                         <li>
                            <a href="?page=customersReport"  <?php if (isset($_GET["page"]) && ($_GET["page"]== "customersReport")) { ?> class="active" <?php } ?>><i class="fa  fa-database fa-fw"></i>كشف حسابات عملاء البيع</a>
                        </li> 
                        <li>
                            <a href="?page=nonePaidInvoices"  <?php if (isset($_GET["page"]) && ($_GET["page"]== "nonePaidInvoices")) { ?> class="active" <?php } ?>><i class="fa  fa-database fa-fw"></i>فواتير مستحقة التحصيل</a>
                        </li> 
                         <li>
                            <a  href="?page=longTermPurchase" <?php if (isset($_GET["page"]) && ($_GET["page"]== "longTermPurchase")) { ?> class="active" <?php } ?>><i class="fa fa-sort-amount-asc fa-fw"></i>آجل شراء</a>
                        </li>
                         <li>
                            <a href="?page=supplierReport"  <?php if (isset($_GET["page"]) && ($_GET["page"]== "supplierReport")) { ?> class="active" <?php } ?>><i class="fa  fa-database fa-fw"></i>كشف حساب عملاء الشراء</a>
                        </li> 
                        <li >
                            <a href="?page=msrofat" <?php if (isset($_GET["page"]) && ($_GET["page"]== "msrofat")) { ?> class="active" <?php } ?>><i class="fa fa-users fa-fw"></i>مصروفات مستحقة الدفع</a>
                        </li>
                        <li >
                            <a href="?page=msrofatReport" <?php if (isset($_GET["page"]) && ($_GET["page"]== "msrofatReport")) { ?> class="active" <?php } ?>><i class="fa fa-area-chart fa-fw"></i>تقرير المصروفات</a>
                        </li>
                        <li >
                            <a href="?page=customers" <?php if (isset($_GET["page"]) && ($_GET["page"]== "customers")) { ?> class="active" <?php } ?>><i class="fa fa-users fa-fw"></i>قائمة العملاء</a>
                        </li>
                         <li>
                            <a href="?page=suppliers" <?php if (isset($_GET["page"]) && ($_GET["page"]== "suppliers")) { ?> class="active" <?php } ?>><i class="fa fa-dashboard fa-fw"></i>قائمة المنتجات</a>
                        </li>
                         <li>
                            <a href="?page=elmordeen" <?php if (isset($_GET["page"]) && ($_GET["page"]== "elmordeen")) { ?> class="active" <?php } ?>><i class="fa fa-dashboard fa-fw"></i>قائمة وكلاء الشراء</a>
                        </li> 

                         <li>
                            <a href="?page=nawloon" <?php if (isset($_GET["page"]) && ($_GET["page"]== "nawloon")) { ?> class="active" <?php } ?>><i class="fa fa-bus fa-fw"></i>شركات النقل والناولون</a>
                        </li>
                        
                       
                        <li>
                            <a href="?page=stock"  <?php if (isset($_GET["page"]) && ($_GET["page"]== "stock")) { ?> class="active" <?php } ?>><i class="fa  fa-database fa-fw"></i>جرد المخزن</a>
                        </li>
                         <li>
                            <a id="khazna" href="?page=khazna" <?php if (isset($_GET["page"]) && ($_GET["page"]== "khazna")) { ?> class="active" <?php } ?>><i class="fa fa-gavel fa-fw"></i>الخزنة الرئيسيه</a>
                        </li>
                        <li>
                            <a href="?page=reservation" <?php if (isset($_GET["page"]) && ($_GET["page"]== "reservation")) { ?> class="active" <?php } ?>><i class="fa  fa-spinner fa-fw"></i>دفتر الحجز</a>
                        </li>

                         <li>
                            <a href="?page=mortg3AwelElmoda" <?php if (isset($_GET["page"]) && ($_GET["page"]== "mortg3AwelElmoda")) { ?> class="active" <?php } ?>><i class="fa fa-area-chart fa-fw"></i>مرتجع بدون فاتوره</a>
                        </li>

                        <li>
                            <a href="?page=dailyReport" <?php if (isset($_GET["page"]) && ($_GET["page"]== "dailyReport")) { ?> class="active" <?php } ?>><i class="fa fa-area-chart fa-fw"></i>تقرير يومي</a>
                        </li> 

                        <li>
                            <a href="?page=arbta" <?php if (isset($_GET["page"]) && ($_GET["page"]== "arbta")) { ?> class="active" <?php } ?>><i class="fa fa-area-chart fa-fw"></i>بيع ربطة للخرده</a>
                        </li>


                      <!--   <li>
                            <a href="?page=monthlyReports"><i class="fa fa-line-chart fa-fw"></i> تقرير شهري</a>

                        </li>
                        <li>
                            <a href="?page=anualReports"><i class="fa fa-bar-chart fa-fw"></i> تقرير سنوي</a>

                        </li> -->
                       

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" >
            <div class="row" style="padding-left:7px;padding-right:7px;">
                <div class="col-lg-12">
                   <?php
                    if (isset($_GET["page"])) {
                        include('pages/'.($_GET["page"]).'.php');
                    }else{
                        include('pages/dailyOrders.php');
                    }
                   ?>

                </div>
                <!-- /.col-lg-12 -->
            </div>
               <div class="modal fade popup" id="myModal" role="dialog" style="overflow:auto;z-index:1000000000;">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                           
                            <button type="button"  class="close" data-dismiss="modal" >x</button>
                        </div>
                        <div class="modal-body" id="myModalBody">
                           
                           
                        </div>
                      
                    </div>

                </div>
            </div>
            
        </div>
        <!-- /#page-wrapper -->
       <div class="modalReloadGifPrivew"></div> 
       <div class="modalReloadGifPrint"></div> 
       <div class="modalReloadGifErga3"></div> 
       <div class="modalReloadGifAddInv"></div> 

<div id="userModal" class="modal fade" style="z-index:100000000;overflow:auto;">
 <div class="modal-dialog">
  <form method="post" id="user_form">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">إضافة عميل</h4>
    </div>
    <div class="modal-body">

<div class="row" >
    <div class="col-lg-12" id="cust_error" style="margin-bottom:10px;background-color:#F2DEDE;color:#C0447B"></div>
</div>


     <input class="form-control" placeholder="اسم العميل" id="custName" name="custName" type="text" autofocus>
     <br />
    <input class="form-control" placeholder="رقم التليفون" id="phoneNumber" name="phoneNumber" type="text" autofocus>
     <br />
      <input class="form-control" placeholder="العنوان" id="custAddress" name="custAddress" type="text" autofocus>
     </div>
    <div class="modal-footer">
     <input type="hidden" name="cust_id" id="cust_id" />
     <input type="hidden" name="operation" id="operation" />
     <input type="submit" id="addCust" name="addCust" value="إضافه" class="btn btn-lg btn-block" style="color: #fff;background-color:#B80303;max-width:400px;margin: 0 auto;float: none;" > 
    </div>
   </div>
  </form>
 </div>
</div>




<div id="userdataModal" class="modal fade" style="overflow:auto;">
 <div class="modal-dialog">
  <form method="post" id="userdata_form">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">بيانات المستخدم</h4>
    </div>
    <div class="modal-body">

      <div class="row" >
          <div class="col-lg-12" id="userdata_error" style="margin-bottom:10px;background-color:#F2DEDE;color:#C0447B"></div>
      </div>
       <div class="row" >
          <div class="col-lg-12" id="userdata_name" data-memberID="<?php echo $_SESSION["memberID"];?>" data-username="<?php echo $_SESSION["name"];?>" style="margin-bottom:10px;background-color:#DFF0D8;color:green">
            <?php echo "أسم المستخدم : ".$_SESSION["name"];?>
          </div>
      </div>

        <label>تغيير كلمة السر</label>
      <br />
     <input class="form-control" placeholder="كلمة السر الحالية" id="oldPass" name="oldPass" type="password" autofocus >
     <br />
     <input class="form-control" placeholder="كلمة السر الجديده" id="newPass" name="newPass" type="password" >
     <br />
     </div>
    <div class="modal-footer">
     
     <input type="submit" id="changePass" name="changePass" value="تغيير" class="btn btn-lg btn-block" style="color: #fff;background-color:#B80303;max-width:400px;margin: 0 auto;float: none;" > 
    </div>
   </div>
  </form>
 </div>
</div>
<!-- invoice Modal -->
<div id="invoiceModal" class="modal fade printable autoprint" style="z-index:100000;overflow:auto;">
 <div class="modal-dialog modal-lg">
   <div class="modal-content invoicemodelContent">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">معاينة فاتورة بيع</h4>
    </div>
    <div class="modal-body invoicePrintedArea" id="print-me">

      <div class="row con" id="centerImgInvoiceDiv" >
        <img  id="centerImgInvoiceimg" style="width:180px;height:105px"  src="img/logoToPrint.png">  
        
     </div>
      <div class="row con" >
          <div class="col-lg-6">

        </div>
        <div class="col-lg-6" style="margin-top:50px">
          <label id="invoiceDate" style="position:relative;float:left"></label>
          <label id="invoiceNo" style="position:relative;float:left;margin-left:85px"></label>
        </div>

     </div>


       <div class="row con" >
          <div class="col-lg-6">
            <div class="row con" ><label style="text-align:justify;position:relative;float:right;font-size:19px;">العســـــــــــال لتجارة الحديد</label></div>
            <div class="row con" ><label style="margin-right:30px;text-align:justify;position:relative;float:right;font-size:19px;">حمدي العسال</label></div>
            <div class="row con" ><label style="text-align:justify;position:relative;float:right;font-size:15px;color:gray">فاقــــوس - أول مدخل فاقوس</label></div>
            <div class="row con" ><label style="text-align:justify;position:relative;float:right;font-size:15px;color:gray">01095555561 - 01095555562</label></div>
        </div>
        <div class="col-lg-6" >
          <button id="btnInvoiceNo" style="position:relative;float:left; border: 0;background:none;box-shadow:none;
           border-radius:0px;background-color:#D3D3D3;font-size:22px;width:240px;height:57">بيــــــــــــان</button>
        </div>

     </div> 
      <div class="row con" >
          <div class="col-lg-6">
         
         </div>
        <div class="col-lg-6" style="margin-top:50px">
          <div class="row con" ><label id="" style="position:relative;float:left;font-size:16px;margin-left:30px;width:200px">بيـــان بأسم : </label></div>
          <div class="row con" ><label id="custNameForPrint" style="position:relative;float:left;font-size:14px;color:gray;width:200px;margin-left:30px"></label></div>
        </div>

     </div>
         <div class="row con" >
                        <div class="col-md-12">
                            <div class="table-responsive" style="margin-top:50px">
                                  <table class="table table-bordered" id="catToPrint_table">
                                    <thead>
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="50%">الصنف</th>
                                      <th width="20%">الكمية</th>
                                      <th width="15%">سعر الطن</th>
                                      <th width="15%">سعر التكلفة</th>
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                      
                </div>
              </div>
                 <div class="row con" >
                        <div class="col-md-6">
                            <div class="table-responsive otherFeesDiv" style="margin-top:80px;width:100%">
                                  <table class="table table-bordered" id="otherServicesPrint_table">
                                    <thead>
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="75%">خدمات إضافيه</th>
                                      <th width="25%">المبلغ</th>
                                      
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                      
                </div>
                  <div class="col-lg-6"style="margin-top:75px">
                      <div class="row con" ><label id="totalWithoutDiscount" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>
                      <div class="row con" ><label id="DiscountPrinted" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>
                      <div class="row con" ><label id="totalAfterDiscount" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>
                      <div class="row con" ><label id="amountPaidID" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>
                      <div class="row con" ><label id="amountRemainID" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>
                      <div class="row con" ><label id="paidDateID" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>
                      <div class="row con" ><label id="reserveDate" style="display:none;position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label></div>

                  </div>
              </div>


        <div class="row con" id="appendPhoto"  style="margin-top:100px">
          
     </div>
    <div class="modal-footer">
     
    </div>
   </div>
 </div>
</div>
</div>

  <div class="modal fade popup" id="giveReserveInvModal" role="dialog" style="overflow:auto;">
                <div class="modal-dialog" style="width: 90%;height: 90%">

                    <div class="modal-content" style="height: auto;min-height: 100%;border-radius: 0;">
                        <div class="modal-header">
                           تفاصيل بضاعة محجوزة
                            <button type="button"  class="close" data-dismiss="modal" >x</button>
                        </div>
                        <div class="modal-body" id="s">
                           <div id="ReserveInvModalMainDiv"></div>
                           
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" val="" name="deliverInvNoHidden" id="deliverInvNoHidden" />
                        </div>
                      
                    </div>

                </div>
       <div class="modalReloadGifPrivew"></div> 
       <div class="modalReloadGifPrint"></div> 
       <div class="modalReloadGifErga3"></div>
       <div class="modalReloadGifAddInv"></div>  
  </div>

    <div class="modal fade popup" id="erga3Modal" role="dialog" style="overflow:auto;">
                <div class="modal-dialog" style="width: 90%;height: 90%">

                    <div class="modal-content" style="height: auto;min-height: 100%;border-radius: 0;">
                        <div class="modal-header">
                           إرجاع من الفاتورة
                            <button type="button"  class="close" data-dismiss="modal" >x</button>
                        </div>
                        <div class="modal-body" id="mb">
                          <div class="row con" id="invoiceNoInMortg3Div" >
                                <label id="invoiceNoInMortg3Lbl" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label>                       
                         </div> 
                         <div class="row con" id="custNameInMortg3Div" >
                                <label id="custNameInMortg3Lbl" style="position:relative;float:left;font-size:13px;margin-left:20px;width:250px"></label>                       
                         </div>
                        <div class="row con" >
                          <div class="col-md-12">
                            <div class="table-responsive" style="margin-top:30px">
                                  <table class="table table-bordered" id="itemsToErga3_table">
                                    <thead>
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="25%">الصنف</th>
                                      <th width="13%">الكمية</th>
                                      <th width="10%">سعر الطن</th>
                                      <th width="10%">الاجمالي</th>
                                      <th width="13%">متاح للارجاع</th>
                                      <th width="14%">سعر الطن عند الارجاع</th>
                                      <th width="15%">الكميه المراد ارجاعها</th>
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                          </div>
                        </div>

                        <div class='row' id="lastMortg3TableDiv" style="display:none">
                           <div class='row' id='lastErtga3Div'><label id='lastErtga3Lbl' style="text-align:center;height:30px;
    width:250px;line-height: 27px;padding-right:30px;padding-left:30px" >عمليات الارجاع السابقه</label></div>

                          <div class="row con" >
                            <div class="col-lg-2 col-md-2 col-sm-1"></div>
                          <div class="col-lg-8 col-md-8 col-sm-10">
                            <div class="table-responsive" style="margin-top:20px">
                                  <table class="table table-bordered" id="LastErga3_table">
                                    <thead>
                                     <tr style="background-color: #FBB900;color: #B80303">
                                      <th width="35%">الصنف</th>
                                      <th width="15%">تاريخ الارجاع</th>
                                      <th width="20%">ارجاع كميه</th>
                                      <th width="15%">سعر الطن عند الارجاع</th>
                                      <th width="15%">بمبلغ</th>
                                      
                                     </tr>
                                     </thead>
                                  </table>
                            </div>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-1"></div>
                        </div>
                       </div> 



                           
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" val="" name="erga3InvoiceNoHidden" id="erga3InvoiceNoHidden" />
                        </div>
                      
                    </div>

                </div>
                <div class="modalReloadGifAddInv"></div> 
  </div>


  <!-- deposite image -->
  <div id="AddDepositeImgModal" class="modal fade printable autoprint" style="z-index:100000;overflow:auto;">
  <div class="modal-dialog modal-lg">
   <div class="modal-content invoicemodelContent">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">اضافة صورة الايداع البنكي</h4>
    </div>
    <div class="modal-body">
      
      <div class="row con" >
        <div class="col-lg-2 col-md-2 col-sm-1"></div>
        <div class="col-lg-8 col-md-8 col-sm-1" id="uploadDepoiteImgDiv">
          <form id="form" action="inserDepositImage.php" method="post" enctype="multipart/form-data">
            <input id="uploadImage" type="file" accept="image/*" name="image" />
            <br>
            <div id="preview"><img  src="no-image.jpg" /></div>            

            <br>
            
            
            <input name="hiddenDeposit" id="hiddenDepositID" type="hidden" value="">
            <input id="buttonUpload"  type="submit" value="تحميل الصوره">
          </form>
           <div id="err"></div>
       </div>
       <div class="col-lg-2 col-md-2 col-sm-1"></div>
      </div>
      
      <div class="modalReloadGifAddInv"></div>

     </div>
 </div>
</div>
</div>

  <div id="ShowDepositeImgModal" class="modal fade printable autoprint" style="z-index:100000;overflow:auto;">
  <div class="modal-dialog modal-lg">
   <div class="modal-content invoicemodelContent">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">معاينة صورة الايداع البنكي</h4>
    </div>
    <div class="modal-body">
      
      <div class="row con" >
        <div class="col-lg-1 col-md-1 "></div>
        <div class="col-lg-10 col-md-10 " id='imgDiv1'>
          <div id='imgDiv'>
            <img id="deposImgShowing"  src="no-image.jpg" />
          </div>

         <input name="hiddenDepositImg" id="hiddenDepositImgID" type="hidden" value="">
         <button id="printDepositeImg" ><i class="fa fa-print"></i> طباعه</button>
       </div>
       <div class="col-lg-1 col-md-1 "></div>
      </div>
     </div>
 </div>
</div>
</div>
  <!-- end deposite image -->
  <!--remove deposite  -->
    <div id="removeDepositeModal" class="modal fade printable autoprint" style="z-index:100000;overflow:auto;">
  <div class="modal-dialog">
   <div class="modal-content invoicemodelContent">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title"></h4>
    </div>
    <div class="modal-body">
      
      <div class="row con" >
        <div class="col-lg-1 col-md-1 "></div>
        <div class="col-lg-10 col-md-10 ">
          <div ><h2 id="headingRemove"></h2></div>
         <input name="hiddenRemoveDepositID" id="hiddenRemoveDepositID" type="hidden" value="">
         <input name="removeFrom" id="removeFrom" type="hidden" value="">
       </div>

       <div class="col-lg-1 col-md-1"></div>
      </div>
      <br>
      <br>

       <div class="row con" >
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
         <button style="float:left" id="RemoveDepositBtn" >مسح</button>
       </div>
       <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
         <button style="min-width:100px;" id="CancelRemoveDepositBtn" >الغاء المسح</button>
        </div>
       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
      </div>
     </div>
 </div>
</div>
</div>
  <!-- end removing deposite  -->

 <div id="editUnitInStockModal" class="modal fade" style="z-index:100000;overflow:auto;">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">تعديل بضاعة موجودة بالمخزن</h4>
    </div>
    <div class="modal-body">
      <center>
      <div class="row con" >
        <div class="col-lg-1 col-md-1 "></div>
        <div class="col-lg-10 col-md-10 ">
          <div class="input-group">
            <input type="text" id="editUnitInStockValue" class="form-control" placeholder="الوزن بالكيلو"/>
            <span class="input-group-btn">
                <input type="button" id="editUnitInStock_btn" value="+"  class="btn" style="background-color:#B80303;color:white" />
            </span>
          </div>
          
         <input name="hiddenMeasID" id="hiddenMeasID" type="hidden" value="">
       </div>
       <div class="col-lg-1 col-md-1 "></div>
      </div>
      </center>
     </div>
 </div>
</div>
</div>



  <div class="modal fade popup" id="customerPageModal" role="dialog" style="overflow:auto;">
                <div class="modal-dialog" style="width: 98%;height: 90%;">

                    <div class="modal-content" style="height: auto;min-height: 100%;border-radius: 0;background-color:#F5F5F5">
                        <div class="modal-header">
                          كشف حساب عميل
                            <button type="button"  class="close" data-dismiss="modal" >x</button>
                        </div>
                        <div class="modal-body">
                          <center><label id="customerPageNameLbl" style="background-color:#FBB900;color:#B80303;
                            padding-left:17px;padding-right:17px"></label></center>
                           <div id="customerPageDiv"></div>
                           
                        </div>
                        <div class="modal-footer">
                          
                        </div>
                      
                    </div>

                </div>
      
       <div class="modalReloadGifAddInv"></div>  
  </div>



 </div>   <!-- /#wrapper -->
   
   
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  

    <script type="text/javascript" src="js/myscript.js"></script>
    <script type="text/javascript" src="js/addInvoice.js"></script>
    <script type="text/javascript" src="js/print.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="js/sb-admin-2.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


    <script>
      function fileUpload() {
       $("#myFile").click();
      }
    </script>

    <style>
        .input-group-glue {
          width: 0;
          display: table-cell;
        }

        .input-group-glue + .form-control {
          border-left: none;
        }
        #otherfeestext{
            width:55px;
            margin-right: 0;
        }
    .border-left{
        border-left: 1px solid #FBB900;
    }
  

    </style>
</body>

</html>
