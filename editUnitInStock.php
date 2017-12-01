  <?php
$dbConnection = mysqli_connect("localhost", "id1392949_ibraheem", "P@ssw0rdS", "id1392949_gsaldb");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


  if(isset($_POST["measID"])&&$_POST["measID"] != ""){

      /* set autocommit to off */
      mysqli_autocommit($dbConnection, false);
      $flag = true;

    $measID =$_POST["measID"];
    $unitInStock =$_POST["unitInStock"];
   
     $result1= mysqli_query($dbConnection,"update measures set unitInStock='$unitInStock' where measID='$measID'");
     if (!$result1) {
      $flag = false;
     }
  
      if ($flag) {
        mysqli_commit($dbConnection);
      }else{
        mysqli_rollback($dbConnection);
      }

      /* close connection */
      $mysqli->close($dbConnection);

    }


?>

 