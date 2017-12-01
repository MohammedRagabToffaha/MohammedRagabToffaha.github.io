   <?php
session_start();
$dbConnection = mysqli_connect("localhost", "id1392949_ibraheem", "P@ssw0rdS", "id1392949_gsaldb");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
 }

   if(isset($_POST["rseedAmount"])&&$_POST["rseedAmount"] != "")
   {
    /* set autocommit to off */
      mysqli_autocommit($dbConnection, false);
      $flag = true;

      $rseedAmount= intval($_POST["rseedAmount"]);
      $dateAdded=date("Ymd");
      $memberID=$_SESSION["memberID"];

      $result= mysqli_query($dbConnection,"INSERT INTO addRseesdSabkInKhzna (rseedAmount,addedDate,memberID) VALUES 
        ('".$rseedAmount."','".$dateAdded."','".$memberID."')");
      if (!$result) {
        $flag = false;
      }

        $result1= mysqli_query($dbConnection,"UPDATE khazna SET khaznaTotal=khaznaTotal+'$rseedAmount'");
        if (!$result1) {
         $flag = false;
        }
        if ($flag) {
          mysqli_commit($dbConnection);
          echo 'تم التوريد بنجاح';
        }else{
          mysqli_rollback($dbConnection);
          echo 'rolling';
        }

        /* close connection */
        $mysqli->close($dbConnection);
  

  }

  ?>