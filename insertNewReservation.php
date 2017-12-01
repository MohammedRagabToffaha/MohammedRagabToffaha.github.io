   <?php
  include('gsaldb.php');
  if (isset($_POST['csID'])&&$_POST['csID'] !="") {
    # code...
    $statement1 = $connection->prepare("select * from customers where custName= :csName");  
    $statement1->bindParam(':csName', $_POST["csName"]);
    $statement1->execute();
    $result =$statement1->fetch();
    if(empty($result))
    {
    echo "error1";//اسم العميل غير موجود يمكن اضافة العميل بالضغط على زر اضافة عميل جديد 
    }else if ($result['custID'] != $_POST['csID']) {
      echo "error";//اعد تحميل الصفحه مره اخرى
    }else{


      $reservRemainMony=$_POST['ReservationAddMony']-$_POST['ReservationPaidMony'];
      $delivDate=date('Y-m-d', strtotime($_POST['ReservationDeliverDate']));
       $statement = $connection->prepare("
         INSERT INTO reservation (custID,reservAmount,reservPaidMony,reservRemainMony,reservDate,delivDate,remainToDelivered) 
         VALUES (:custID,:reservAmount, :reservPaidMony,:reservRemainMony,:reservDate,:delivDate,:remainToDelivered)");
       $statement->bindParam(':custID', $_POST['csID']);
       $statement->bindParam(':reservAmount', $_POST['ReservationAddMony']);
       $statement->bindParam(':reservPaidMony', $_POST['ReservationPaidMony']);
       $statement->bindParam(':reservRemainMony', $reservRemainMony);
       $statement->bindParam(':reservDate', date("Ymd"));
       $statement->bindParam(':delivDate', $delivDate);
       $statement->bindParam(':remainToDelivered', $_POST['ReservationAddMony']);

       $statement->execute();

       $id=$connection->lastInsertId();

       for($count = 0; $count<count($_POST["supID"]); $count++){
         $quantity;
          if ($_POST["weight"][$count]=="0") {
            $quantity=($_POST["qant"][$count])*1000;
          }else{
            $quantity=$_POST["qant"][$count];
          }
          $statement = $connection->prepare("
           INSERT INTO reservationCost (reservID,suppID,catID,measID,unitPrice,quantity) 
           VALUES (:reservID, :suppID, :catID,:measID,:unitPrice,:quantity)");
             $statement->bindParam(':reservID', $id);
             $statement->bindParam(':suppID', $_POST["supID"][$count]);
             $statement->bindParam(':catID', $_POST["catID"][$count]);
             $statement->bindParam(':measID', $_POST["measID"][$count]);
             $statement->bindParam(':unitPrice', $_POST["price"][$count]);
             $statement->bindParam(':quantity', $quantity);

             $statement->execute();

       }
  $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal+:khaznaTotal");  
              $statement->bindParam(':khaznaTotal', $_POST['ReservationPaidMony']);
            
              $statement->execute(); 

    }

  }
  ?>