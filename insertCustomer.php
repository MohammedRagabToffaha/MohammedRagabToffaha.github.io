     <?php
    include('gsaldb.php');
    if(isset($_POST["operation"]))
    {
     if($_POST["operation"] == "Add")
     {
      $statement = $connection->prepare("select count(*) from customers where custName= :CN");  
      $statement->bindParam(':CN', $_POST["custName"], PDO::PARAM_STR, 12);
      $statement->execute();
      if($statement->fetchColumn())
      {
      echo "error";

      }
      else{
            $statement1 = $connection->prepare("
           INSERT INTO customers (custName,   custAddress, custPhone ) 
           VALUES (:custName, :custAddress, :custPhone)
          ");
          $result1 = $statement1->execute(
           array(
            ':custName' => $_POST["custName"],
            ':custAddress' => $_POST["custAddress"],
            ':custPhone'  => $_POST["phoneNumber"]
           )
          );
          if(!empty($result1))
          {
           echo 'تم ادخال العميل بنجاح';
          }
      }

     }



     //edit
     if($_POST["operation"] == "Edit")
     {

      $statement = $connection->prepare("select count(*) from customers where custID<>:id and custName= :CN");  

      $statement->execute( array(
        ':CN' => $_POST["custName"],
        ':id'   => $_POST["cust_id"]
       ));
      if($statement->fetchColumn())
      {
         echo "error1";
      }
      else{
        $statement1 = $connection->prepare(
       "UPDATE customers 
       SET custName = :custName, custAddress = :custAddress, custPhone = :custPhone  
       WHERE custID = :id
       "
      );
      $result1 = $statement1->execute(
       array(
        ':custName' => $_POST["custName"],
        ':custAddress' => $_POST["custAddress"],
        ':custPhone'  => $_POST["phoneNumber"],
        ':id'   => $_POST["cust_id"]
       )
      );
      if(!empty($result1))
      {
       echo 'تم التعديل بنجاح';
      }

      }



    
      
     }
    }

    ?>