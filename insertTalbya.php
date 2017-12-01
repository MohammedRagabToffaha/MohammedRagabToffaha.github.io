  <?php
include('gesalDB.php');

if(isset($_POST["operationStock"])){
  if($_POST["operationStock"] == "Add"){
    if(isset($_POST["QuantAddedToStock"])&&$_POST["QuantAddedToStock"] != ""){

      /* set autocommit to off */
      mysqli_autocommit($dbConnection, false);
      $flag = true;

    $quant = ($_POST["QuantAddedToStock"]);
    $unitPriceForStock = ($_POST["unitPriceForStock"]);
    $suppID =$_POST["SelectTypeInStock"];
    $catID =$_POST["SelectCatInStock"];
    $measID =$_POST["SelectMeasInStock"];
    $mordID =$_POST["SelectMoredStock"];
    $addedDate=date('Y-m-d', strtotime($_POST['DateAddedToStock']));

    $nwloonID =$_POST["nwloonID"];
    $unitPriceForNawloonStock =$_POST["unitPriceForNawloonStock"];


     $result1= mysqli_query($dbConnection,"INSERT INTO Tlbyat (suppID,catID,measID,addedDate,quantity,mordID,UnitCostPrice,nwloonID,nwloonAmount) 
         VALUES ('".$suppID."','".$catID."','".$measID."','".$addedDate."','".$quant."','".$mordID."','".$unitPriceForStock."','".$nwloonID."','".$unitPriceForNawloonStock."')
        ");
     if (!$result1) {
      $flag = false;
     }
     $result2= mysqli_query($dbConnection,"
         update measures set unitInStock=unitInStock+'".$quant."' where suppID='".$suppID."' and catID='".$catID."' and measID='".$measID."'
        "); 
     if (!$result2) {
      $flag = false;
     }

      $QuantAddedToStock=$_POST["QuantAddedToStock"];
        $unitPriceForStock=floatval($_POST["unitPriceForStock"]);
        $newCost=floatval(($QuantAddedToStock*$unitPriceForStock)/1000);

      $result3=mysqli_query($dbConnection,"
         update elmordeen set totalAmountRemain=totalAmountRemain+'".$newCost."' where mordID='".$mordID."'");
      if (!$result3) {
       $flag = false;
      }

      if ($unitPriceForNawloonStock !="") {
        $NwloonCost=((int)$unitPriceForNawloonStock*(int)$quant)/1000;
          $result4= mysqli_query($dbConnection,"update nwloon set nwloonRemainMony=nwloonRemainMony+'$NwloonCost' where nwloonID='$nwloonID'"); 
         if (!$result4) {
          $flag = false;
         }
      }

      if ($flag) {
        mysqli_commit($dbConnection);
      }else{
        mysqli_rollback($dbConnection);
      }

      /* close connection */
      $mysqli->close($dbConnection);

    }
  }
}


?>

 