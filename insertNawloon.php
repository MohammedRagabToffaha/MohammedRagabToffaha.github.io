  <?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;

 if(isset($_POST["nwloonName"])&&$_POST["nwloonName"] != "")
   {
    $nwloonName=$_POST['nwloonName'];
    $nwloonPhone=$_POST['nwloonPhone'];

      $result= mysqli_query($dbConnection,"INSERT INTO nwloon (nwloonName,nwloonPhone) 
         VALUES ('".$nwloonName."','".$nwloonPhone."')
        ");
     if (!$result) {
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