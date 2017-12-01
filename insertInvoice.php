<?php
include('gesalDB.php');
 function insertOtherFeez()
{
    if (isset($_POST["feesMony"])&&$_POST["feesMony"]!=""){
      global $dbConnection;
      global $invoiceNoPost;
      for($countFees = 0; $countFees<count($_POST["feesMony"]); $countFees++){
         $minfeeAmount = floatval($_POST['feesMony'][$countFees]);
         $minfeeReason=$_POST["feesDetails"][$countFees];
          $result= mysqli_query($dbConnection,"INSERT INTO minusFees (invoiceNo,minfeeReason,minfeeAmount) 
            VALUES ('".$invoiceNoPost."','".$minfeeReason."','".$minfeeAmount."')");
         if (!$result) {
          $flag = false;
         }


      }
    }
}
 function insertOtherServices()
{
 if (isset($_POST["seviceMony"])&&$_POST["seviceMony"]!=""){
  global $dbConnection;
  global $invoiceNoPost;
        for($countService = 0; $countService<count($_POST["seviceMony"]); $countService++){
          $plusfeeAmount = floatval($_POST['seviceMony'][$countService]);

          $plusfeeReason=$_POST["seviceDetails"][$countService];
          $result= mysqli_query($dbConnection,"INSERT INTO plusFees (invoiceNo,plusfeeReason,plusfeeAmount) 
            VALUES ('".$invoiceNoPost."','".$plusfeeReason."','".$plusfeeAmount."')");
         if (!$result) {
          $flag = false;
         }


        }
      }
}
function insertOrderDetailsItems()
{
  global $dbConnection;
  global $invoiceNoPost;
       for($count = 0; $count<count($_POST["supID"]); $count++){
        $suppID=$_POST["supID"][$count];
        $catID=$_POST["catID"][$count];
        $measID=$_POST["measID"][$count];
        $price=$_POST["price"][$count];
        $result=mysqli_query($dbConnection,"select measID,unitInStock from measures where suppID = '$suppID' AND 
          catID='$catID' AND measID='$measID'");
        $measures=mysqli_fetch_assoc($result);
        $unitInStock=$measures['unitInStock'];
        $productID=$measures['measID'];

        $quantity;
        if ($_POST["weight"][$count]=="0") {
          $quantity=($_POST["qant"][$count])*1000;
        }else{
          $quantity=$_POST["qant"][$count];
        }
        $result2= mysqli_query($dbConnection,"INSERT INTO orderDetails (invoiceNo,productID,unitPrice,Quantity) 
          VALUES ('".$invoiceNoPost."','".$productID."','".$price."','".$quantity."')
        ");
       if (!$result2) {
        $flag = false;
       }

       $unitInStock=$unitInStock-$quantity;
        $result3= mysqli_query($dbConnection,"UPDATE measures SET unitInStock='$unitInStock' WHERE measID='$productID'");
       if (!$result3) {
        $flag = false;
       }
     }
}
if(isset($_POST["invoiceNoPost"])){
  $invoiceNoPost=$_POST["invoiceNoPost"];
  $csName=$_POST["csName"];
  $memberID=$_POST["memberID"];

  $insertedDate=date('Y-m-d', strtotime($_POST['orderDate']));
  $discount = floatval($_POST['discount']);
  $custID = intval($_POST['csID']);
  $memberID = intval($_POST['memberID']);



  /* set autocommit to off */
    mysqli_autocommit($dbConnection, false);
    $flag = true;
     $result=mysqli_query($dbConnection,"
         select count(*) from orders where invoiceNo='$invoiceNoPost'");
     if (!mysqli_num_rows($result)) {
       echo "error";
       exit();
     }
      $result1=mysqli_query($dbConnection,"
         select * from customers where custName='$csName'");
     if (!mysqli_num_rows($result1)) {
       echo "error1";
       exit();
     }
     $result2=mysqli_query($dbConnection,"
         select * from members where memberID='$memberID'");
     if (!mysqli_num_rows($result2)) {
       echo "error2";
       exit();
     }
     //////Handle Agel
     if(isset($_POST["amountPaidPost"])&&($_POST["amountPaidPost"])!=""){
      $paidDate=date('Y-m-d', strtotime($_POST['amountRemainDatePost']));
      $amountPaid = floatval($_POST['amountPaidPost']);

      if (!is_numeric($discount) || $discount==0){
        $result1= mysqli_query($dbConnection,"INSERT INTO orders (invoiceNo,invoiceType,custID, memberID,orderDate,amountPaid,paidDate,discount,isPaid ) 
         VALUES ('".$invoiceNoPost."','آجل','".$custID."','".$memberID."','".$insertedDate."','".$amountPaid."','".$paidDate."',NULL,'false')
        ");
       if (!$result1) {
        $flag = false;
       }
      }else{
           $result1= mysqli_query($dbConnection,"INSERT INTO orders (invoiceNo,invoiceType,custID, memberID,orderDate,amountPaid,paidDate,discount,isPaid ) 
         VALUES ('".$invoiceNoPost."','آجل','".$custID."','".$memberID."','".$insertedDate."','".$amountPaid."','".$paidDate."','".$discount."','false')
        ");
       if (!$result1) {
        $flag = false;
       }
      }

       

       ///select products and insert order details
     insertOrderDetailsItems();
     insertOtherFeez();
     insertOtherServices();

     $result=mysqli_query($dbConnection,"select invoiceNo,sum((unitPrice*Quantity)/1000) as total from orderDetails 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $orderDetails=mysqli_fetch_assoc($result);
     $totalWithoutDiscount=$orderDetails["total"]; 

     $result=mysqli_query($dbConnection,"select invoiceNo,sum(plusfeeAmount) as plusFees from plusFees 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $plusFees=mysqli_fetch_assoc($result);
     $totalPlusFees=$plusFees["plusFees"];

     $result=mysqli_query($dbConnection,"select discount from orders where invoiceNo='$invoiceNoPost'");
     $orders=mysqli_fetch_assoc($result);
     $disc=$orders["discount"];

     $totalAfterDiscountAndPlusFees=$totalWithoutDiscount+$totalPlusFees-$disc;

     $amountRemain=$totalAfterDiscountAndPlusFees-$amountPaid;
     $totalAmountRemain=$totalAfterDiscountAndPlusFees-$amountPaid;

     $result= mysqli_query($dbConnection,"UPDATE orders SET amountRemain='$amountRemain',
      totalAmountRemain='$totalAmountRemain',total='$totalAfterDiscountAndPlusFees' where invoiceNo='$invoiceNoPost'");
     if (!$result) {
      $flag = false;
     }

     $result=mysqli_query($dbConnection,"select invoiceNo,sum(minfeeAmount) as minfeeAmount from minusFees 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $minusFees1=mysqli_fetch_assoc($result);
     $minfeeAmount=$minusFees1["minfeeAmount"];

     $addToKhazna=(intval($_POST['amountPaidPost']))-intval($minfeeAmount);

     $result= mysqli_query($dbConnection,"UPDATE khazna SET khaznaTotal=khaznaTotal+'$addToKhazna'");
     if (!$result) {
      $flag = false;
     }


  }//end Handle Agel
  else if (isset($_POST["orderType"])&&($_POST["orderType"])=="reservation"&&isset($_POST["reserve_id"])&&($_POST["reserve_id"] != "")) {
       $reserve_id= $_POST["reserve_id"];
         if (!is_numeric($discount) || $discount==0){
        $result1= mysqli_query($dbConnection,"INSERT INTO orders (invoiceNo,invoiceType,custID, memberID,orderDate,discount,isPaid,isReservation,reservID ) 
         VALUES ('".$invoiceNoPost."','حجز','".$custID."','".$memberID."','".$insertedDate."',NULL,'true','1','".$reserve_id."')
        ");
       if (!$result1) {
        $flag = false;
       }
      }else{
           $result1= mysqli_query($dbConnection,"INSERT INTO orders (invoiceNo,invoiceType,custID, memberID,orderDate,discount,isPaid,isReservation,reservID ) 
         VALUES ('".$invoiceNoPost."','حجز','".$custID."','".$memberID."','".$insertedDate."','".$discount."','true','1','".$reserve_id."')
        ");
       if (!$result1) {
        $flag = false;
       }
      }

     insertOrderDetailsItems();
     insertOtherFeez();
     insertOtherServices();

     $result=mysqli_query($dbConnection,"select invoiceNo,sum((unitPrice*Quantity)/1000) as total from orderDetails 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $orderDetails=mysqli_fetch_assoc($result);
     $totalWithoutDiscount=$orderDetails["total"]; 

     $result=mysqli_query($dbConnection,"select invoiceNo,sum(plusfeeAmount) as plusFees from plusFees 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $plusFees=mysqli_fetch_assoc($result);
     $totalPlusFees=$plusFees["plusFees"];

     $result=mysqli_query($dbConnection,"select discount from orders where invoiceNo='$invoiceNoPost'");
     $orders=mysqli_fetch_assoc($result);
     $disc=$orders["discount"];

     $totalAfterDiscountAndPlusFees=$totalWithoutDiscount+$totalPlusFees-$disc;


     $result= mysqli_query($dbConnection,"UPDATE orders SET total='$totalAfterDiscountAndPlusFees' where invoiceNo='$invoiceNoPost'");
     if (!$result) {
      $flag = false;
     }

     $result=mysqli_query($dbConnection,"select invoiceNo,sum(minfeeAmount) as minfeeAmount from minusFees 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $minusFees1=mysqli_fetch_assoc($result);
     $minfeeAmount=$minusFees1["minfeeAmount"];

      $rtd=$totalAfterDiscountAndPlusFees-$minfeeAmount;

      $result= mysqli_query($dbConnection,"UPDATE reservation SET remainToDelivered=remainToDelivered-'$rtd' where 
        reservID='$reserve_id'");
     if (!$result) {
      $flag = false;
     }
            
   
  }else{
       if (!is_numeric($discount) || $discount==0){
        $result1= mysqli_query($dbConnection,"INSERT INTO orders (invoiceNo,invoiceType,custID, memberID,orderDate,discount,isPaid) 
         VALUES ('".$invoiceNoPost."','كاش','".$custID."','".$memberID."','".$insertedDate."',NULL,'true')
        ");
       if (!$result1) {
        $flag = false;
       }
      }else{
           $result1= mysqli_query($dbConnection,"INSERT INTO orders (invoiceNo,invoiceType,custID, memberID,orderDate,discount,isPaid) 
         VALUES ('".$invoiceNoPost."','كاش','".$custID."','".$memberID."','".$insertedDate."','".$discount."','true')
        ");
       if (!$result1) {
        $flag = false;
       }
      }

     insertOrderDetailsItems();
     insertOtherFeez();
     insertOtherServices();

      $result=mysqli_query($dbConnection,"select invoiceNo,sum((unitPrice*Quantity)/1000) as total from orderDetails 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $orderDetails=mysqli_fetch_assoc($result);
     $totalWithoutDiscount=$orderDetails["total"]; 

     $result=mysqli_query($dbConnection,"select invoiceNo,sum(plusfeeAmount) as plusFees from plusFees 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $plusFees=mysqli_fetch_assoc($result);
     $totalPlusFees=$plusFees["plusFees"];

     $result=mysqli_query($dbConnection,"select discount from orders where invoiceNo='$invoiceNoPost'");
     $orders=mysqli_fetch_assoc($result);
     $disc=$orders["discount"];

     $totalAfterDiscountAndPlusFees=$totalWithoutDiscount+$totalPlusFees-$disc;

    

     $result= mysqli_query($dbConnection,"UPDATE orders SET total='$totalAfterDiscountAndPlusFees' where invoiceNo='$invoiceNoPost'");
     if (!$result) {
      $flag = false;
     }

     $result=mysqli_query($dbConnection,"select invoiceNo,sum(minfeeAmount) as minfeeAmount from minusFees 
      where invoiceNo='$invoiceNoPost' GROUP BY invoiceNo");
     $minusFees1=mysqli_fetch_assoc($result);
     $minfeeAmount=$minusFees1["minfeeAmount"];

      $khaznaNewAmountAdded=$totalAfterDiscountAndPlusFees-$minfeeAmount;
      

     $result= mysqli_query($dbConnection,"UPDATE khazna SET khaznaTotal=khaznaTotal+'$khaznaNewAmountAdded'");
     if (!$result) {
      $flag = false;
     }

  }

if ($flag) {
        mysqli_commit($dbConnection);
      }else{
        mysqli_rollback($dbConnection);
      }
 
 }

?>
