    <?php
    session_start();
include('gsaldb.php');

if(isset($_POST["InvoiceNo"]))
{

    $statement = $connection->prepare("update  orders set isDelivered='1',deliverEmployee=:deliverEmployee where invoiceNo=:invoiceNo");  
    $statement->bindParam(':deliverEmployee',$_SESSION["memberID"]);
    $statement->bindParam(':invoiceNo',$_POST["InvoiceNo"]);
    $statement->execute();

    $statement1 = $connection->prepare("select productID,Quantity from orderDetails 
    where invoiceNo=:invoiceNo");
    $statement1->execute(array(':invoiceNo'=>$_POST['InvoiceNo']));
    $result1 = $statement1->fetchAll();
    foreach ($result1 as $row){
      $statement = $connection->prepare("update measures set unitInStock=unitInStock-:qant where measID=:measID");  
      $statement->bindParam(':qant',$row["Quantity"]);
      $statement->bindParam(':measID',$row["productID"]);
      $statement->execute();
    }


   



 
}
?>