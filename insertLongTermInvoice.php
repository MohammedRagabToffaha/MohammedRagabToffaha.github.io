   <?php
include('gesalDB.php');
   if(isset($_POST["PayAmount"])&&$_POST["PayAmount"] != "")
   {
    $custID=$_POST['custID'];
    $PayAmount1=$_POST['PayAmount'];
    $PayAmount;
     mysqli_autocommit($dbConnection, false);
      $flag = true;

        $result=mysqli_query($dbConnection,"select COALESCE(SUM(totalAmountRemain),0) as 'totalamount' from orders where custID='$custID'
         and isPaid='false' order by paidDate");
        $orders=mysqli_fetch_assoc($result);

        $result=mysqli_query($dbConnection,"select COALESCE(SUM(totalAmountRemain),0) as 'remainMony' from
         awlElmodaCustRemainMony where custID='$custID'");
        $awlElmodaCustRemainMony=mysqli_fetch_assoc($result);

        $totalRemain=$orders["totalamount"]+$awlElmodaCustRemainMony["remainMony"];

        $amountAddedToFokEl7sab;
        if ($totalRemain < $PayAmount1){
          $amountAddedToFokEl7sab=$PayAmount1-$totalRemain;
          $PayAmount=$totalRemain;
        }else{
          $amountAddedToFokEl7sab=0;
          $PayAmount=$_POST['PayAmount'];
        }

        if ($totalRemain > 0) {
          # code...
          $result1= mysqli_query($dbConnection,"INSERT INTO customerspaidMony (custID,customerspaidMonyAmount,paidDate,employeeID,remainFromLast) 
             VALUES ('".$custID."','".$PayAmount."','".date("Ymd")."','".$_POST["memberID"]."','".$totalRemain."')
            ");
         if (!$result1) {
          $flag = false;
         }  

         $result=mysqli_query($dbConnection,"UPDATE khazna SET khaznaTotal=khaznaTotal+'$PayAmount'");
         if (!$result) {
          $flag = false;
         }

         $total=$PayAmount;
          if ($awlElmodaCustRemainMony["remainMony"] > 0) {
          # code...
          if ($total >= intval($awlElmodaCustRemainMony['remainMony'])){
            $result=mysqli_query($dbConnection,"UPDATE awlElmodaCustRemainMony SET totalAmountRemain='0' where custID='$custID'");
             if (!$result) {
              $flag = false;
             }

             $total=$total-intval($awlElmodaCustRemainMony["remainMony"]);

          }else if ($total < intval($awlElmodaCustRemainMony['remainMony'])){
             $result=mysqli_query($dbConnection,"UPDATE awlElmodaCustRemainMony SET 
              totalAmountRemain=totalAmountRemain-'$total' where custID='$custID'");
             if (!$result) {
              $flag = false;
             }

             $total=0;
          }
           
        }

        if ($total > 0) {
             $result=mysqli_query($dbConnection,"select invoiceNo,totalAmountRemain,total from orders where 
              custID='$custID' and isPaid='false' order by paidDate");
            if (mysqli_num_rows($result)) {
                while ($orders=mysqli_fetch_array($result)){
                    if ($total > 0){
                      $invoiceNo=$orders['invoiceNo'];
                      if ($total >= intval($orders['totalAmountRemain'])){
                         $result=mysqli_query($dbConnection,"UPDATE orders set totalAmountRemain='0',
                          isPaid='true' where invoiceNo='$invoiceNo'");
                         if (!$result) {
                          $flag = false;
                         }
                         $total=$total-intval($orders['totalAmountRemain']);
                      }else if($total < intval($orders['totalAmountRemain'])){
                       $t= intval($orders["totalAmountRemain"])-$total;
                         $result=mysqli_query($dbConnection,"UPDATE orders set totalAmountRemain='$t' where invoiceNo='$invoiceNo'");
                         if (!$result) {
                          $flag = false;
                         }
                         $total=0;
                      }
                    }else{
                        break;
                    }
                }
            } 
               
            }

          }  
            //fok el7sab
            if ($amountAddedToFokEl7sab > 0) {
              $result=mysqli_query($dbConnection,"select custMony from customersMony where custID='$custID'");
              $customersMony=mysqli_fetch_assoc($result);
              $custmony;
              if ($customersMony['custMony'] ==null) {
                $custmony=0;
              }else{
                $custmony=$customersMony['custMony'];
              }
              $result1= mysqli_query($dbConnection,"INSERT INTO customerspaidMony (custID,customerspaidMonyAmount,paidDate,employeeID,remainFromLast,totalFromLast) 
                 VALUES ('".$custID."','".$amountAddedToFokEl7sab."','".date("Ymd")."','".$_POST["memberID"]."','0','".$custmony."')
                ");
             if (!$result1) {
              $flag = false;
             } 
             $result=mysqli_query($dbConnection,"select count(*) cun from customersMony where custID='$custID'");
              $customersMony=mysqli_fetch_assoc($result);
              if ($customersMony['cun'] > 0) {
                $result=mysqli_query($dbConnection,"update customersMony set custMony=custMony+'$amountAddedToFokEl7sab' where custID='$custID'");
                 if (!$result) {
                  $flag = false;
                 }
              }else{
                  $result1= mysqli_query($dbConnection,"INSERT INTO customersMony (custID,custMony) 
                     VALUES ('".$custID."','".$amountAddedToFokEl7sab."')
                    ");
                 if (!$result1) {
                  $flag = false;
                 }
              }
               $result=mysqli_query($dbConnection,"update khazna set khaznaTotal=khaznaTotal+'$amountAddedToFokEl7sab'");
                 if (!$result) {
                  $flag = false;
                 }

            }


if ($flag) {
        mysqli_commit($dbConnection);
      }else{
        mysqli_rollback($dbConnection);
      }
  
}else{
  echo "noset";
}
/////////////////////////
  
  ?>