   <?php
  include('gsaldb.php');

   if(isset($_POST["SelectMsareefValue"])&&$_POST["SelectMsareefValue"] != "")
   {
  
  
          $statement1 = $connection->prepare("
         INSERT INTO msrofat (msrofatValue,msrofatName,msrofatDetails,msrofatAmount,memberID,addedDate) 
         VALUES (:msrofatValue,:msrofatName,:msrofatDetails,:msrofatAmount,:memberID,:addedDate)
        ");
        $result1 = $statement1->execute(
         array(
          ':msrofatValue' => intval($_POST["SelectMsareefValue"]),
          ':msrofatName' => $_POST["SelectMsareefText"],
          ':msrofatDetails' => $_POST["msareefDetails"],
          ':msrofatAmount' => intval($_POST["msareefAmount"]),
          ':memberID' => intval($_POST["memberID"]),
          ':addedDate' => date("Ymd"),
         )
        );
        if(!empty($result1))
        {
           $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:khaznaTotal");  
              $statement->bindParam(':khaznaTotal', intval($_POST["msareefAmount"]));
            
              $statement->execute();
         echo 'تم السحب بنجاح';
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