 <?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;

 if(isset($_POST["depositID"])&&$_POST["depositID"] != "")
   {
    $depositID=$_POST['depositID'];
    $result= mysqli_query($dbConnection,"select * from deposits where depositID='$depositID'");
    if (mysqli_num_rows($result)) {
      $deposits=mysqli_fetch_assoc($result);
      $depositAmount=$deposits['depositAmount'];
      $mordID=$deposits['mordID'];

       //$totalCost=$arbtaQuantity*$arbtaUnitCost;

        $result= mysqli_query($dbConnection,"delete from deposits where depositID='$depositID'");
       if (!$result) {
        $flag = false;
       }

        $result1= mysqli_query($dbConnection,"update elmordeen set totalAmountRemain=totalAmountRemain+'$depositAmount'
           where mordID='$mordID'");
         if (!$result1) {
          $flag = false;
         }

          $result2= mysqli_query($dbConnection,"update khazna set khaznaTotal=khaznaTotal+'$depositAmount'");
         if (!$result2) {
          $flag = false;
         }

      if ($flag) {
        mysqli_commit($dbConnection);
      }else{
        mysqli_rollback($dbConnection);
      }

    }

  
}
 else{
   echo "e1";
 }

  ?>
