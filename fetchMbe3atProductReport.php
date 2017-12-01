<?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;


if((isset($_POST["startDate"])&&$_POST["startDate"] != "")){
    
    $startDate=$_POST['startDate'];
    $endDate=$_POST['endDate'];

       
     $result=mysqli_query($dbConnection,"SELECT sum(Quantity) as tq,productID from orderDetails,orders where 
      orderDetails.invoiceNo=orders.invoiceNo and orders.orderDate BETWEEN '$startDate' and '$endDate' GROUP BY
       productID order by tq desc");
      $productsValues = array();
      //$msrofatNames = array();
     
        while ($products=mysqli_fetch_array($result)){
               
                $subArr1 = array();
                $totalQuantity= $products['tq'];

                $productID= $products['productID'];
                $result1=mysqli_query($dbConnection,"select catID,suppID,measName from measures where measID='$productID'");
                $p=mysqli_fetch_assoc($result1);
                 $catID=$p['catID'];
                 $suppID=$p['suppID'];
                 $measName=$p['measName'];

                $result2=mysqli_query($dbConnection,"select catName from categories where catID='$catID'");
                $categories=mysqli_fetch_assoc($result2);
                $catName=$categories['catName'];

                $result3=mysqli_query($dbConnection,"select suppName from suppliers where suppID='$suppID'");
                $suppliers=mysqli_fetch_assoc($result3);
                $suppName=$suppliers['suppName'];

                $productName=$suppName." ".$catName." ".$measName;
              
                $subArr1[y] = $totalQuantity;
                $subArr1[productName] = $productName;

              $productsValues[] = $subArr1;
      
        }//end while
       
        
    echo json_encode(array($productsValues),JSON_NUMERIC_CHECK);


       

    

}else{
    echo "noSet";
}
 ?>