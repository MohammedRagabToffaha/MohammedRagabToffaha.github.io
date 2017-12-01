<?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;


if((isset($_POST["year"])&&$_POST["year"] != "")){
    
    $year=$_POST['year'];
      
     $result=mysqli_query($dbConnection,"SELECT sum(Quantity) as totalQuantity,MONTH(`orderDate`) as month 
      from orders,orderDetails where YEAR(orderDate)='$year' and orders.invoiceNo=orderDetails.invoiceNo 
      GROUP BY MONTH(orderDate)");
      $ordersArr = array();
     
        while ($orders=mysqli_fetch_array($result)){
               

                $subArr1 = array();
                $arabicMonth;
                $month= $orders['month'];
                if ($month=="1") 
                  $arabicMonth="يناير";
                else if ($month=="2")
                  $arabicMonth="فبراير";
                else if ($month=="3")
                  $arabicMonth="مارس";
                else if ($month=="4")
                  $arabicMonth="أبريل";
                else if ($month=="5")
                  $arabicMonth="مايو";
                else if ($month=="6")
                  $arabicMonth="يونية";
                else if ($month=="7")
                  $arabicMonth="يوليو";
                else if ($month=="8")
                  $arabicMonth="أغسطس";
                else if ($month=="9")
                  $arabicMonth="سبتمبر";
                else if ($month=="10")
                  $arabicMonth="أكتوبر";
                else if ($month=="11")
                  $arabicMonth="نوفمبر";
                else if ($month=="12")
                  $arabicMonth="ديسمبر";
           
                $subArr1[month] = $arabicMonth;
                $subArr1[y] = $orders['totalQuantity'];

              $ordersArr[] = $subArr1;
      
        }//end while
       
        
    echo json_encode(array($ordersArr),JSON_NUMERIC_CHECK);


       

    

}else{
    echo "noSet";
}
 ?>