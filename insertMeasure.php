   <?php
  include('gsaldb.php');
  if(isset($_POST["oper"])&&$_POST["oper"]=="add"){
  
     if(isset($_POST["measureInSuppliers"])&&$_POST["measureInSuppliers"] != "")
   {
    $statement = $connection->prepare("select count(*) from measures where catID= :catID AND suppID= :suppID AND measName= :measName");  
    $statement->bindParam(':catID', $_POST["SelectCatInSuppliers"]);
    $statement->bindParam(':suppID', $_POST["SelectTypeInSuppliers"]);
    $statement->bindParam(':measName', $_POST["measureInSuppliers"], PDO::PARAM_STR, 12);
    $statement->execute();
    if($statement->fetchColumn())
    {
    echo "error";

    }
    else{
          $statement1 = $connection->prepare("
         INSERT INTO measures (catID,   suppID, measName ) 
         VALUES (:catID, :suppID, :measName)
        ");
        $result1 = $statement1->execute(
         array(
          ':catID' => $_POST["SelectCatInSuppliers"],
          ':suppID' => $_POST["SelectTypeInSuppliers"],
          ':measName'  => $_POST["measureInSuppliers"]
         )
        );
        if(!empty($result1))
        {
         echo 'تم ادخال المقاس بنجاح';
        }
    }

   }else{
    echo "errrrrrror";
   }



  }

  


 if(isset($_POST["oper"])&&$_POST["oper"]=="edit"){


      $statement1 = $connection->prepare(
     "UPDATE measures 
     SET catID = :catID, suppID = :suppID, measName = :measName  
     WHERE measID = :id
     "
    );
    $result1 = $statement1->execute(
    array(
          ':catID' => $_POST["SelectCatInSuppliers"],
          ':suppID' => $_POST["SelectTypeInSuppliers"],
          ':measName'  => $_POST["measureInSuppliers"],
          ':id'  => $_POST["measure_id"]
         )
    );
    if(!empty($result1))
    {
     echo 'تم التعديل بنجاح';
    }



  }

  ?>