   <?php
   session_start();
  include('gsaldb.php');
   
        //out awzan
        if (isset($_POST["orderDetailsID"])&&$_POST["orderDetailsID"] != "") {

           try {
              $connection->beginTransaction();

          $statement = $connection->prepare("select * from orderDetails where orderDetailsID=:orderDetailsID");
          $statement->bindParam(':orderDetailsID', $_POST["orderDetailsID"]);
          $statement->execute();
          $result = $statement->fetch();

          $remainQuantity;
          if ($result['outQuantity'] != null) {
            $remainQuantity=$result['Quantity']-$result['outQuantity'];
          }else{
            $remainQuantity=$result['Quantity'];
          }


           if ($remainQuantity==0) {
            echo "e1";//تم إرجاع كامل الكمية من هذا المنتج
          }else if($remainQuantity < $_POST["erga3Quant"]){
            echo "e2";//الكمية المراد إرجاعها اكبر من الكميه المباعه !! ادخل كميه اقل او تساوي الكميه المباعه.
          }else{
              $unitPrice=intval($_POST["erga3UnitPrice"]);
              $statement1 = $connection->prepare("
                       INSERT INTO mortg3 (invoiceNo,productID,mortg3Date,unitPrice,mortg3Quant,memberID) 
                       VALUES (:invoiceNo,:productID ,:mortg3Date, :unitPrice,:mortg3Quant,:memberID)
                      ");
              $result1 = $statement1->execute(
               array(
                ':invoiceNo' => $_POST["InvoiceNo"],
                ':productID' => $result["productID"],
                ':mortg3Date' => date("Ymd"),
                ':unitPrice'  => $unitPrice,
                ':mortg3Quant'  => $_POST["erga3Quant"],
                ':memberID'  => $_SESSION["memberID"]
                
              )
          );



          $statement2 = $connection->prepare("
             update orderDetails set outQuantity= IFNULL(outQuantity, 0)+:outQuantity where orderDetailsID=:orderDetailsID");
            $result2 = $statement2->execute( array(
              ':outQuantity' => $_POST["erga3Quant"],
              ':orderDetailsID' => $_POST["orderDetailsID"]
             ));   

          $statement3 = $connection->prepare("
             update measures set unitInStock=unitInStock+:outQuantity where measID=:measID");
            $result3 = $statement3->execute( array(
              ':outQuantity' => $_POST["erga3Quant"],
              ':measID' => $result["productID"]
             ));

            $erga3quant=intval($_POST["erga3Quant"]);

            $cost=($erga3quant* $unitPrice)/1000;

           $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:cost");  
           $statement->bindParam(':cost', $cost);
           $statement->execute();   

          }

        $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }


 }else{
  echo "e3";//لم يتم الارجاع حدث الصفحه وحاول مره اخرى
 }

        

  ?>