<?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;


if((isset($_POST["startDate"])&&$_POST["startDate"] != "")){
    
    $startDate=$_POST['startDate'];
    $endDate=$_POST['endDate'];
   
     $result=mysqli_query($dbConnection,"select sum(total) as total,custID 
        from orders where orderDate between '$startDate' and '$endDate' group by custID order by total desc limit 7");
      $ordersArr = array();
     
        while ($orders=mysqli_fetch_array($result)){
               

                $subArr1 = array();
              //fetch customer name
                $memberID = $orders['custID'];
                $result1=mysqli_query($dbConnection,"select custName from customers where custID='$memberID'");
                $customers=mysqli_fetch_assoc($result1);
                $custName = $customers['custName'];
              //fetch quantity
                $quantity=0;
                $outQuantity=0;
                 $result2=mysqli_query($dbConnection,"select invoiceNo
        from orders where custID='$memberID' and orderDate between '$startDate' and '$endDate'");
                 while ($orderno=mysqli_fetch_array($result2)){
                  $invoiceNo=$orderno['invoiceNo'];
                   $result3=mysqli_query($dbConnection,"select sum(Quantity) as quantity,sum(outQuantity) as outquantity from orderDetails where invoiceNo='$invoiceNo'");
                   while ($orderDetails=mysqli_fetch_array($result3)){
                    $quantity+=intval($orderDetails['quantity']);
                    $outQuantity+=intval($orderDetails['outquantity']);
                   }
                 }

                 $lastQuantity=($quantity)-($outQuantity);
                $subArr1['custName'] = $custName;
                $subArr1[y] = $lastQuantity;

              $ordersArr[] = $subArr1;
      
        }//end while
       
        
    echo json_encode(array($ordersArr),JSON_NUMERIC_CHECK);


       

    

}else{
    echo "noSet";
}
 ?>