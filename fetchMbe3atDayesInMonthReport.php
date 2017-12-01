<?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;


if((isset($_POST["month"])&&$_POST["month"] != "")){
    
    $year=$_POST['year'];
    $month=$_POST['month'];

       
     $result=mysqli_query($dbConnection," SELECT sum(Quantity) as totalQuantity,DAY(orderDate) as days from 
      orders,orderDetails where YEAR(orderDate)='$year' and MONTH(`orderDate`)='$month' and 
      orders.invoiceNo=orderDetails.invoiceNo GROUP BY DAY(orderDate)");
      $daysValues = array();
      //$msrofatNames = array();
     
        while ($orders=mysqli_fetch_array($result)){
               
                $subArr1 = array();
                $days= $orders['days'];

              
                $subArr1[days] = $days;
                $subArr1[y] = $orders['totalQuantity'];

              $daysValues[] = $subArr1;
      
        }//end while
       
        
    echo json_encode(array($daysValues),JSON_NUMERIC_CHECK);


       

    

}else{
    echo "noSet";
}
 ?>