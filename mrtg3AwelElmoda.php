   <?php
  include('gsaldb.php');
  if (isset($_POST["measID"])&&$_POST["measID"] != ""){

   

    $unitcost=intval($_POST["unitcost"]);
              $statement1 = $connection->prepare("
                       INSERT INTO mortg3 (invoiceNo,productID,mortg3Date,unitPrice,mortg3Quant) 
                       VALUES (:invoiceNo,:productID ,:mortg3Date, :unitPrice,:mortg3Quant)
                      ");
              $result1 = $statement1->execute(
               array(
                ':invoiceNo' => "ارجاع بدون فاتوره",
                ':productID' => $_POST["measID"],
                ':mortg3Date' => date("Ymd"),
                ':unitPrice'  => $unitcost,
                ':mortg3Quant'  => $_POST["quantity"]
              )
          );

          $statement3 = $connection->prepare("
             update measures set unitInStock=unitInStock+:outQuantity where measID=:measID");
            $result3 = $statement3->execute( array(
              ':outQuantity' => $_POST["quantity"],
              ':measID' => $_POST["measID"]
             ));

            $erga3quant=intval($_POST["quantity"]);

            $cost=($erga3quant* $unitcost)/1000;

           $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:cost");  
           $statement->bindParam(':cost', $cost);
           $statement->execute();
                  

  }
   
     

  ?>