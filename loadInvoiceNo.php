 <?php
  include('gsaldb.php');
  $statement = $connection->prepare("select CONCAT( 'F-', LPAD(max(orderID)+1,7,'0') ) as orderno from orders ");  
    $statement->execute();
    if($last = $statement->fetch(PDO::FETCH_ASSOC))
    {
	
	     if ($last['orderno'] !="") {
        echo $last['orderno'];
      }else{
        echo ("F-0000001");
      }
      
    }else{
    	$statement = $connection->prepare("select CONCAT( 'F-', LPAD(max(orderID)+1,7,'0') ) as orderno from orders ");  
      $statement->execute();
      if($last = $statement->fetch(PDO::FETCH_ASSOC)){
         if ($last['orderno'] !="") {
          echo $last['orderno'];
        }else{
          echo ("F-0000001");
        }
      }else{
          $statement = $connection->prepare("select CONCAT( 'F-', LPAD(max(orderID)+1,7,'0') ) as orderno from orders ");  
      $statement->execute();
      if($last = $statement->fetch(PDO::FETCH_ASSOC)){
         if ($last['orderno'] !="") {
          echo $last['orderno'];
        }else{
          echo ("F-0000001");
        }
      }else{
          $statement = $connection->prepare("select CONCAT( 'F-', LPAD(max(orderID)+1,7,'0') ) as orderno from orders ");  
      $statement->execute();
      if($last = $statement->fetch(PDO::FETCH_ASSOC)){
         if ($last['orderno'] !="") {
          echo $last['orderno'];
        }else{
          echo ("F-0000001");
        }
      }else{
        
      }
      }
      }
    }

  ?>