 <?php  
 include('gsaldb.php'); 
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $statement = $connection->prepare("
       select custID,custName from customers where custName LIKE '%".$_POST["query"]."%'
      ");

     // $statement->bindParam(':custName',$_POST["query"]); // no need for PDO::PARAM_STR

      $statement->execute(); 

     
      $output = '<ul class="list-unstyled ulCustNameReport">';
      $cols = $statement->columnCount(); 
      if ($cols > 0) {
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $output .= '<li data-custIDReport="'.$row["custID"].'">'.$row["custName"].'</li>'; 
        }
      }else{
        $output .= '<li>لا يوجد عميل بهذا الاسم</li>'; 
      }
      $output .= '</ul>';  
      echo $output;
   

 
 }  
 ?> 