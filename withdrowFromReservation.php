   <?php
   session_start();
  include('gsaldb.php');
   

        //delivr reservation as mony mony
          if (isset($_POST["outMony"])&&$_POST["outMony"] != ""){
          try {
          $connection->beginTransaction();
            
          $statement = $connection->prepare("select * from reservation where reservID=:reservID");
          $statement->bindParam(':reservID', $_POST["reservID"]);
          $statement->execute();
          $result = $statement->fetch();

         

           if ($result['remainToDelivered'] == 0) {
            echo "e1";//تم تسليم كامل الكمية من هذا الحجز
          }else if($_POST['outMony'] > $result['remainToDelivered']){
            echo "e2";//المبلغ المراد تسليمه اكبر من المبلغ المتبقي...ادخل مبلغ اقل.
          }else{
             
             $withdMony=intval($_POST["outMony"]);
              $statement1 = $connection->prepare("
                       INSERT INTO withdrowfromMonyReservation (withdMony,withdDate,memberID,reservID) 
                       VALUES (:withdMony, :withdDate, :memberID,:reservID)
                      ");
              $result1 = $statement1->execute(
               array(
                ':withdMony' => $withdMony,
                ':withdDate' => date("Ymd"),
                ':memberID'  => $_SESSION["memberID"],
                ':reservID'  => $_POST["reservID"]
              )
          );


          $statement2 = $connection->prepare("
           update reservation set remainToDelivered=remainToDelivered-:withdMony where reservID=:reservID");
          $result2 = $statement2->execute( array(
            ':withdMony' => $_POST["outMony"],
            ':reservID' => $_POST["reservID"]
           ));  


          $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:withdMony");  
          $statement->bindParam(':withdMony', $_POST["outMony"]);
        
          $statement->execute();           

            }
              $connection->commit();
            }
             catch (PDOException $e) {
              $connection->rollBack();
            }

          }       

   //pay remain mony
          if (isset($_POST["PaidMony"])&&$_POST["PaidMony"] != ""){
          try {
          $connection->beginTransaction();
            
          $statement = $connection->prepare("select reservRemainMony from reservation where reservID=:reservID");
          $statement->bindParam(':reservID', $_POST["reservID"]);
          $statement->execute();
          $result = $statement->fetch();

         

           if ($result['reservRemainMony'] == 0) {
            echo "e1";//لا يوجد مبلع متبقي على العميل من هذا الحجز
          }else if($_POST['PaidMony'] > $result['reservRemainMony']){
            echo "e2";//المبلغ المتبقي المراد دفعه اكبر من المبلغ المتبقي على العميل من هذا الحجز...ادخل مبلغ اقل.
          }else{
             
             $PaidMony=intval($_POST["PaidMony"]);
              $statement1 = $connection->prepare("
                       INSERT INTO reservationRemainsMony (reservID,paidMony,rrDate,memberID,remainBeforPaid) 
                       VALUES (:reservID, :paidMony, :rrDate,:memberID,:remainBeforPaid)
                      ");
              $result1 = $statement1->execute(
               array(
                ':reservID' => $_POST["reservID"],
                ':paidMony' => $PaidMony,
                ':rrDate'  => date("Ymd"),
                ':memberID'  => $_SESSION["memberID"],
                ':remainBeforPaid'  => $result['reservRemainMony']
              )
          );


          $statement2 = $connection->prepare("
           update reservation set reservRemainMony=reservRemainMony-:PaidMony where reservID=:reservID");
          $result2 = $statement2->execute( array(
            ':PaidMony' => $PaidMony,
            ':reservID' => $_POST["reservID"]
           ));  


          $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal+:PaidMony");  
          $statement->bindParam(':PaidMony', $PaidMony);
        
          $statement->execute();           

            }
              $connection->commit();
            }
             catch (PDOException $e) {
              $connection->rollBack();
            }

          }
 

  ?>