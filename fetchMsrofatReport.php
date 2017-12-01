<?php 
include('gesalDB.php');
/* set autocommit to off */
mysqli_autocommit($dbConnection, false);
$flag = true;


if((isset($_POST["startDate"])&&$_POST["startDate"] != "")){
    
    $startDate=$_POST['startDate'];
    $endDate=$_POST['endDate'];
   
     $result=mysqli_query($dbConnection,"select sum(msrofatAmount) as Amount,msrofatName 
        from msrofat where addedDate between '$startDate' and '$endDate' group by msrofatName,msrofatValue 
        order by Amount desc");
      $msrofatValues = array();
      //$msrofatNames = array();
     
        while ($msrofat=mysqli_fetch_array($result)){
               

                $subArr1 = array();
              
                $subArr1[] = $msrofat['msrofatName'];
                $subArr1[] = $msrofat['Amount'];

              $msrofatValues[] = $subArr1;
      
        }//end while
       
        
    echo json_encode(array($msrofatValues),JSON_NUMERIC_CHECK);


       

    

}else{
    echo "noSet";
}
 ?>