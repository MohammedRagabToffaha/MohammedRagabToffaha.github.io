    <?php
include('gsaldb.php');

if(isset($_POST["InvoiceNo"]))
{
 $output = array();
 $json_response = array();

  try {
          $connection->beginTransaction();


          $statement = $connection->prepare(
		  "SELECT * FROM orders 
		  WHERE invoiceNo = '".$_POST["InvoiceNo"]."' 
		  LIMIT 1"
		  );
		 $statement->execute();
		 $result = $statement->fetchAll();

		 foreach($result as $row)
		 {
		  $output["custID"] = $row["custID"];
      $output["orderDate"] = $row["orderDate"];
      $output["amountPaid"] = $row["amountPaid"];
      $output["amountRemain"] = floatval($row["amountRemain"]);

      $pD=date("d-m-Y",strtotime($row["paidDate"]));
		  $output["paidDate"] = $pD;

		  $output["discount"] = $row["discount"];
		  $output["total"] = floatval($row["total"]);

      $output["isReservation"] = $row["isReservation"];
     
		 }


		      $statement = $connection->prepare("select custName from customers where custID = :custID");  
          $statement->bindParam(':custID',$output["custID"]);
          $statement->execute();
          $result = $statement->fetch();

          $output["custName"]=$result["custName"];



		      $statement = $connection->prepare("select plusfeeReason,plusfeeAmount from plusFees 
           where invoiceNo= :InvoiceNo");  
          $statement->bindParam(':InvoiceNo', $_POST["InvoiceNo"]);
          $statement->execute();
          $result = $statement->fetchAll();
          foreach($result as $row)
      		 {
      		  $output["plusfeeReason"][] = $row["plusfeeReason"];
      		  $output["plusfeeAmount"][] = floatval($row["plusfeeAmount"]);
      		 } 

		      $statement = $connection->prepare("select productID,unitPrice,Quantity from orderDetails 
           where invoiceNo= :InvoiceNo");  
          $statement->bindParam(':InvoiceNo', $_POST["InvoiceNo"]);
          $statement->execute();
         // $result = $statement->fetch();
         
          
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

          //echo $row["productID"];

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

          // $output["items"][]= array('suppName' =>$result2["suppName"],
          // 	'catName' =>$result3["catName"],
          // 	'measName' =>$result4["measName"]
          //  );
          $output["unitPrice"][]= floatval($row["unitPrice"]);
          $output["Quantity"][]= $row["Quantity"];
          

		 }
		 array_push($json_response, $output);
// 		 echo json_encode(array("items"=>$outputCategories, "orderdate"=> $orderDate
// //output
// 		 	));

		 //echo json_encode($output);
		 echo json_encode($json_response);
		// echo json_encode(array('result1'=>$output,'result2'=>$outputCategories));

         $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }

 
}
?>