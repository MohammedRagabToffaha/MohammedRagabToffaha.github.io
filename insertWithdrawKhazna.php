   <?php
  include('gsaldb.php');
session_start();
   if(isset($_POST["withdrawAmount"])&&$_POST["withdrawAmount"] != "")
   {
  
  
          $statement1 = $connection->prepare("
         INSERT INTO withdrowfromkhazna (withdrowAmount,withdrowDate,memberID) 
         VALUES (:withdrowAmount,:withdrowDate,:memberID)
        ");
        $result1 = $statement1->execute(
         array(
          ':withdrowAmount' => intval($_POST["withdrawAmount"]),
          ':withdrowDate' => date("Ymd"),
          ':memberID' => $_SESSION["memberID"]
         )
        );
        if(!empty($result1))
        {
         echo 'تم التوريد بنجاح';

           $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:khaznaTotal");  
              $statement->bindParam(':khaznaTotal', intval($_POST["withdrawAmount"]));
            
              $statement->execute();
        }
        else{
          echo "error";
        }


        //  $statement = $connection->prepare("update orders set isPaid='true' where invoiceNo=:invoiceNo");
        //  $result = $statement->execute(
        //  array(
        //   ':invoiceNo' => $_POST["InvoiceNo"]
        //  )
        // );


  }

  ?>