 <?php
  include('gsaldb.php');
  if(isset($_POST["suppID"])){
      $statement = $connection->prepare("select unitInStock from measures where suppID=:suppID AND catID=:catID AND
   measID=:measID ");  
  $statement->bindParam(':suppID', $_POST["suppID"]);
  $statement->bindParam(':catID', $_POST["catID"]);
  $statement->bindParam(':measID', $_POST["measureID"]);
    $statement->execute();
    if($unit = $statement->fetch(PDO::FETCH_ASSOC))
    {
  
     echo $unit['unitInStock'];
      
    }else{
      echo "nounitInserted";
    }
  }


  ?>