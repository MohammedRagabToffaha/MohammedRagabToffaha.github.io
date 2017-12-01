<?php 
session_start(); 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;


if(isset($_POST["custID"])&&$_POST["custID"] != ""){
    
    $custID=$_POST['custID'];
    $custName=$_POST['custName'];
  
    $datesArr=array();
    $result=mysqli_query($dbConnection,"SELECT DISTINCT(orderDate) from orders where custID='$custID' ");
    if (mysqli_num_rows($result)) {
        while ($orders=mysqli_fetch_array($result)){
            $datesArr[]=$orders['orderDate'];
            // array_push($datesArr, array(
            //     "selectDate"=>$orders['od']
            //     ));
        }
    }   

    $result1=mysqli_query($dbConnection,"SELECT DISTINCT(paidDate) from customerspaidMony where custID='$custID' ");
    if (mysqli_num_rows($result1)) {
        while ($customerspaidMony=mysqli_fetch_array($result1)){
            $paidDate=$customerspaidMony['paidDate'];
            if (!in_array($paidDate,$datesArr)) {
                $datesArr[]=$paidDate;
               
            }
           
        }
    }

     $result2=mysqli_query($dbConnection,"SELECT DISTINCT(deliverdDate) from customerDeliverdAsMony where custID='$custID' ");
    if (mysqli_num_rows($result2)) {
        while ($customerDeliverdAsMony=mysqli_fetch_array($result2)){
            $deliverdDate=$customerDeliverdAsMony['deliverdDate'];
            if (!in_array($deliverdDate,$datesArr)) {
                $datesArr[]=$deliverdDate;
               
            }
           
        }
    }

    function arrange($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
    usort($datesArr, "arrange");

    $datesArr = array_reverse($datesArr);

    $html="";

$html.="<div class='row'><div class='col-lg-2 col-md-2'></div>";
$html.="<div class='col-lg-3 col-md-3'> 
                    <form method='post' id='form_AddMonyToCustomer'>
                    <div class='input-group'>
                            <input type='text' id='custMonyInput' class='form-control' placeholder='تحصيل مبلغ من العميل'/>
                            <span class='input-group-btn'>
                                <input type='submit' style='border-radius: 0px;'  id='custMonyBtn' value='+' class='btn' />
                               
                            </span>
                            
                        </div>
                            <input type='hidden' id='hiddenCNametoCostomerMony' data-cn='".$custName."' value='".$custID."' />
                            <input type='hidden' id='hiddenMemberID' data-memberID='".$_SESSION["memberID"]."'/>
                            
                        </form>
                        <br>
                        </div>";
$html.="<div class='col-lg-2 col-md-2'></div>";

  $html.="<div class='col-lg-3 col-md-3'> 
                    <form method='post' id='form_givMonyToCustomer'>
                    <div class='input-group'>
                            <input type='text' id='giveCustMonyInput' class='form-control' placeholder='تسليم العميل مبلغ من المتبقي له'/>
                            <span class='input-group-btn'>
                                <input type='submit' style='border-radius: 0px;' id='giveCustMonyBtn' value='+' class='btn' />
                               
                            </span>
                            
                        </div>
                            <input type='hidden' id='hiddenCNametoGiveMony' data-cn='".$custName."' value='".$custID."' />
                            <input type='hidden' id='hiddenGiveMemberID' data-memberID='".$_SESSION["memberID"]."'/>
                            
                        </form>
                        <br>
                        </div>";                                              

$html.="<div class='col-lg-2 col-md-2'></div></div>";



$html.="<hr style='width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;' />";




    if (!empty($datesArr)) {
         foreach ($datesArr as $key => $value){
            $selectDate=$value;

            $en_Day = date("D", strtotime($selectDate));

            $en_day = date("d", strtotime($selectDate));
            $en_month = date("m", strtotime($selectDate));
            $en_year = date("Y", strtotime($selectDate));

            $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
            $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
            $ar_day = str_replace($find, $replace, $en_Day);

            $html.="<div class='row' style='background-color:#fff;margin:10px;'>";
            $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
            $html.="<label style='margin-top:10px'>$ar_day ( ".$en_day." - ".$en_month." - ".$en_year." )</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
            $html.="<br>";

            $result=mysqli_query($dbConnection,"select invoiceNo,amountPaid,paidDate,amountRemain,totalAmountRemain,total
     from orders where custID='$custID' and invoiceType='آجل' and orderDate='$selectDate'");

        if (mysqli_num_rows($result)){
            

            $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
            $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
            $html.="<tr style='background-color: #B80303;color: #fff'><th width='15%'>
            "."رقم الفاتورة"."</th><th width='15%'>اجمالي الفاتورة</th><th width='15%'>المبلغ المتبقي وقت الشراء</th>
            <th width='20%'>المبلغ المتبقي بعد التحصيل</th><th width='15%'>ميعاد سداد المتبقي</th>
            <th width='10%'>معاينة</th><th width='10%'>طباعه</th>";
            while ($orders=mysqli_fetch_array($result)){
                $totalAmountRemain;
                if ($orders['totalAmountRemain']==0) {
                    $totalAmountRemain="تم تحصيل كامل المبلغ";
                }else{
                    $totalAmountRemain=number_format($orders['totalAmountRemain'])." جنيه";
                }
                 $btnShow= "<button type='button' name='showInvoice' id='".$orders["invoiceNo"]."' class='btn btn-xs showInvoice' style='background-color:#B80303;color:white'>معاينه</button>";
                 $btnPrint= "<button type='button' name='printInvoice' id='".$orders["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";
                    
                 $html.="<tr><td>".$orders["invoiceNo"]."</td><td>".number_format($orders["total"])." جنيه</td><td>"
                  .number_format($orders["amountRemain"])." جنيه</td><td>".$totalAmountRemain."</td><td>".$orders['paidDate']."</td><td>".$btnShow
                  ."</td><td>".$btnPrint."</td></tr>";

            }
            $html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";

        }

          $result=mysqli_query($dbConnection,"select * from customerspaidMony where custID='$custID' and paidDate='$selectDate'  and remainFromLast<>0");

        if (mysqli_num_rows($result)){
            while ($customerspaidMony=mysqli_fetch_array($result)){
               $finalRemain=$customerspaidMony['remainFromLast']-$customerspaidMony['customerspaidMonyAmount'];

                $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
                    $html.="<div class='table-responsive'><table style='width:100%;background-color: #F5F5F5
                ;height:30px;line-height: 22px;padding-right:20px;padding-left:20px' class='table table-bordered hover'>";
                    
                $html.="<tr style='height:10px'><th width='40%'>
                <label>المتبقي ســــابقا ".number_format($customerspaidMony['remainFromLast'])." جنيه"."</label></th><th width='30%'><label>تنزيل مبلغ وقدره ".number_format($customerspaidMony['customerspaidMonyAmount'])." جنيه</label></th>
                <th width='30%'><label>متبقي بعد التنزيل ".number_format($finalRemain)." جنيه </label></th>";

                $html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
            }
            

        }  

            $result=mysqli_query($dbConnection,"select * from customerDeliverdAsMony where custID='$custID' and deliverdDate='$selectDate'");

        if (mysqli_num_rows($result)){
            while ($customerDeliverdAsMony=mysqli_fetch_array($result)){
             $final=$customerDeliverdAsMony['lastRemain']-$customerDeliverdAsMony['deliverdAmount'];

        $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
            $html.="<div class='table-responsive'><table style='width:100%;background-color: #C8C8C8
        ;height:30px;line-height: 22px;padding-right:20px;padding-left:20px' class='table table-bordered hover'>";
            
        $html.="<tr style='height:10px'><th width='40%'>
        <label>متبقي له ســــابقا ".number_format($customerDeliverdAsMony['lastRemain'])." جنيه"."</label></th><th width='30%'><label>سحب مبلغ وقدره ".number_format($customerDeliverdAsMony['deliverdAmount'])." جنيه</label></th>
        <th width='30%'><label>متبقي بعد السحب ".number_format($final)." جنيه </label></th>";

        $html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
            }
            

        }


        $result=mysqli_query($dbConnection,"select * from customerspaidMony where custID='$custID' and paidDate='$selectDate'  and remainFromLast=0");

        if (mysqli_num_rows($result)){
            while ($customerspaidMony=mysqli_fetch_array($result)){
               $final7sab=$customerspaidMony['totalFromLast']+$customerspaidMony['customerspaidMonyAmount'];

                $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
                    $html.="<div class='table-responsive'><table style='width:100%;background-color: #E0E0E0
                ;height:30px;line-height: 22px;padding-right:20px;padding-left:20px' class='table table-bordered hover'>";
                    
                $html.="<tr style='height:10px'><th width='40%'>
        <label>فوق الحساب ســــابقا ".number_format($customerspaidMony['totalFromLast'])." جنيه"."</label></th><th width='30%'><label>اضافة مبلغ وقدره ".number_format($customerspaidMony['customerspaidMonyAmount'])." جنيه</label></th>
        <th width='30%'><label>الاجمالي بعد الاضافه ".number_format($final7sab)." جنيه </label></th>";

        $html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
            }
            

        }       

        $html.="</div>";

        }
    }else{
        $html.="<label>لا يوجد حساب بهذا الاسم</label>";
    }
    
  
    echo $html;

}
else{
	echo "noSet";
} 

 ?>