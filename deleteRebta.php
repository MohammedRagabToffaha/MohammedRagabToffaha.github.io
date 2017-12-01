  <?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;

 if(isset($_POST["rbthID"])&&$_POST["rbthID"] != "")
   {
    $rbthID=$_POST['rbthID'];
    $result= mysqli_query($dbConnection,"select * from rbth where rbthID='$rbthID'");
    if (mysqli_num_rows($result)) {
      $rbth=mysqli_fetch_assoc($result);
      $arbtaQuantity=$rbth['arbtaQuantity'];
      $arbtaUnitCost=$rbth['arbtaUnitCost'];

       $totalCost=$arbtaQuantity*$arbtaUnitCost;

        $result= mysqli_query($dbConnection,"delete from rbth where rbthID='$rbthID'");
       if (!$result) {
        $flag = false;
       }

        $result1= mysqli_query($dbConnection,"update khazna set khaznaTotal=khaznaTotal-'$totalCost'");
         if (!$result1) {
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
   echo "errrrdfgergrrror";
 }

  ?>