    <?php
include('gsaldb.php');

if(isset($_POST["InvoiceNo"]))
{
 $output = array();
 $json_response = array();

  try {
          $connection->beginTransaction();


          $statement = $connection->prepare(
		  "SELECT custID FROM orders 
		  WHERE invoiceNo = '".$_POST["InvoiceNo"]."' 
		  LIMIT 1"
		  );
		 $statement->execute();
		 $result = $statement->fetch();
     $output["custID"] = $result["custID"];


    $statement = $connection->prepare("select custName from customers where custID = :custID");  
    $statement->bindParam(':custID',$output["custID"]);
    $statement->execute();
    $result = $statement->fetch();

    $output["custName"]=$result["custName"];



    $statement = $connection->prepare("select orderDetailsID,productID,unitPrice,Quantity,outQuantity from orderDetails 
     where invoiceNo= :InvoiceNo");  
    $statement->bindParam(':InvoiceNo', $_POST["InvoiceNo"]);
    $statement->execute();
  
     while ($row = $statement->fetch(PDO::FETCH_ASSOC))
		 {


		   $statement1 = $connection->prepare("select suppID,catID,measID from measures 
           where measID= :productID");  
          $statement1->bindParam(':productID', $row["productID"]);
          $statement1->execute();
          $result1 = $statement1->fetch();
          $suppID=$result1["suppID"];
          $catID=$result1["catID"];
          $measID=$result1["measID"];

          $statement2 = $connection->prepare("select suppName from suppliers 
           where suppID= :suppID");  
          $statement2->bindParam(':suppID',$suppID);
          $statement2->execute();
          $result2 = $statement2->fetch();
          $output["suppName"][]= $result2["suppName"];

          $statement3 = $connection->prepare("select catName from categories 
           where catID= :catID");  
          $statement3->bindParam(':catID',$catID);
          $statement3->execute();
          $result3 = $statement3->fetch();
          $output["catName"][]= $result3["catName"];

          $statement4 = $connection->prepare("select measName from measures 
           where measID= :measID and catID= :catID ");  
          $statement4->bindParam(':measID',$measID);
          $statement4->bindParam(':catID',$catID);
          $statement4->execute();
          $result4 = $statement4->fetch();
          $output["measName"][]= $result4["measName"];

          $output["unitPrice"][]= floatval($row["unitPrice"]);
          $output["Quantity"][]= $row["Quantity"];
          $output["outQuantity"][]= $row["outQuantity"];
          $output["orderDetailsID"][]= $row["orderDetailsID"];
       
		 }

    $statement = $connection->prepare("select productID,mortg3Date,unitPrice,mortg3Quant from mortg3 
     where invoiceNo= :InvoiceNo");  
    $statement->bindParam(':InvoiceNo', $_POST["InvoiceNo"]);
    $statement->execute();
  
     while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

          $statement1 = $connection->prepare("select suppID,catID,measID from measures 
           where measID= :productID");  
          $statement1->bindParam(':productID', $row["productID"]);
          $statement1->execute();
          $result1 = $statement1->fetch();
          $suppID=$result1["suppID"];
          $catID=$result1["catID"];
          $measID=$result1["measID"];

          $statement2 = $connection->prepare("select suppName from suppliers 
           where suppID= :suppID");  
          $statement2->bindParam(':suppID',$suppID);
          $statement2->execute();
          $result2 = $statement2->fetch();
          $output["suppName1"][]= $result2["suppName"];

          $statement3 = $connection->prepare("select catName from categories 
           where catID= :catID");  
          $statement3->bindParam(':catID',$catID);
          $statement3->execute();
          $result3 = $statement3->fetch();
          $output["catName1"][]= $result3["catName"];

          $statement4 = $connection->prepare("select measName from measures 
           where measID= :measID and catID= :catID ");  
          $statement4->bindParam(':measID',$measID);
          $statement4->bindParam(':catID',$catID);
          $statement4->execute();
          $result4 = $statement4->fetch();
          $output["measName1"][]= $result4["measName"];

          $output["unitPrice1"][]= floatval($row["unitPrice"]);
          $output["mortg3Date"][]= $row["mortg3Date"];
          $output["mortg3Quant"][]= $row["mortg3Quant"];

     }

		 array_push($json_response, $output);

		 echo json_encode($json_response);

         $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }

 
}
?>