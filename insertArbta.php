  <?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;

 if(isset($_POST["arbtaCustName"])&&$_POST["arbtaCustName"] != "")
   {
    $arbtaCustName=$_POST['arbtaCustName'];
    $arbtaQuantity=$_POST['arbtaQuantity'];
    $arbtaUnitCost=$_POST['arbtaUnitCost'];
    $arbtaDate=date("ymd");

      $result= mysqli_query($dbConnection,"INSERT INTO rbth (arbtaCustName,arbtaQuantity,arbtaUnitCost,arbtaDate) 
         VALUES ('".$arbtaCustName."','".$arbtaQuantity."','".$arbtaUnitCost."','".$arbtaDate."')
        ");
     if (!$result) {
      $flag = false;
     }

     $totalAmount=((int)$arbtaQuantity)*((int)$arbtaUnitCost);
      $result1= mysqli_query($dbConnection,"update khazna set khaznaTotal=khaznaTotal+'$totalAmount'");
               if (!$result1) {
                $flag = false;
               }

     
      if ($flag) {
        mysqli_commit($dbConnection);
      }else{
        mysqli_rollback($dbConnection);
      }


}
 else{
   echo "errrrdfgergrrror";
 }

  ?>