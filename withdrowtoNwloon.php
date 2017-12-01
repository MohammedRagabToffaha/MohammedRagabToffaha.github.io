    <?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;
        //delivr Nwloon as mony mony
   if (isset($_POST["outMony"])&&$_POST["outMony"] != ""){
    $nwloonID=$_POST["nwloonID"];
    $outMony=$_POST["outMony"];

          $result= mysqli_query($dbConnection,"select * from nwloon where nwloonID='$nwloonID'");
          $nwloon=mysqli_fetch_assoc($result);
          if ($nwloon['nwloonRemainMony'] == 0) {
            echo "e1";//تم تسليم كامل المبلغ
          }else if($_POST['outMony'] > $nwloon['nwloonRemainMony']){
            echo "e2";//المبلغ المراد تسليمه اكبر من المبلغ المتبقي...ادخل مبلغ اقل.
          }else{
              $result= mysqli_query($dbConnection,"update nwloon set nwloonRemainMony=nwloonRemainMony-'$outMony' 
                where nwloonID='$nwloonID'");
               if (!$result) {
                $flag = false;
               }

               $result1= mysqli_query($dbConnection,"update khazna set khaznaTotal=khaznaTotal-'$outMony'");
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
               


  ?>