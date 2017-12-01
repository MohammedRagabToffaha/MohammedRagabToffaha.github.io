   <?php
include('gesalDB.php');

   if(isset($_POST["PayAmount"])&&$_POST["PayAmount"] != "")
   {
      $custID=$_POST["custID"];
      $PayAmount=$_POST["PayAmount"];

      mysqli_autocommit($dbConnection, false);
      $flag = true;

      $result=mysqli_query($dbConnection,"select COALESCE(SUM(custMony),0) as 'custMony' from customersMony
        where custID='$custID'");
      $custMonyRows=mysqli_fetch_assoc($result);

       $custMony=$custMonyRows["custMony"];

        if ($custMony == 0) {
          # code...
          echo "e1";//لا يوجد مبلغ متبقي للعميل
        }else if($PayAmount > $custMony){
          echo "e2";//المبلغ المراد تسليمه اكبر من المبلغ المتبقي للعميل .. ادخل مبلغ اقل من او يساوي المتبقي للعميل
        }else{
          $result1= mysqli_query($dbConnection,"INSERT INTO customerDeliverdAsMony (custID,deliverdAmount,deliverdDate,memberID,lastRemain) 
             VALUES ('".$custID."','".$PayAmount."','".date("Ymd")."','".$_POST["memberID"]."','".$custMony."')
            ");
         if (!$result1) {
          $flag = false;
         } 
         $result=mysqli_query($dbConnection,"UPDATE khazna SET khaznaTotal=khaznaTotal-'$PayAmount'");
         if (!$result) {
          $flag = false;
         }
         $result=mysqli_query($dbConnection,"UPDATE customersMony SET custMony=custMony-'$PayAmount' where custID='$custID'");
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

  /////////////////////////////
        

  ?>