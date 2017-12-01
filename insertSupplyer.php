   <?php
  include('gsaldb.php');

   if(isset($_POST["typeInSuppliers"])&&$_POST["typeInSuppliers"] != "")
   {
    $statement = $connection->prepare("select count(*) from suppliers where suppName= :suppName");  
    $statement->bindParam(':suppName', $_POST["typeInSuppliers"], PDO::PARAM_STR, 12);
    $statement->execute();
    if($statement->fetchColumn())
    {
    echo "error";

    }
    else{
          $statement1 = $connection->prepare("
         INSERT INTO suppliers (suppName) 
         VALUES (:suppName)
        ");
        $result1 = $statement1->execute(
         array(
          ':suppName' => $_POST["typeInSuppliers"]
         )
        );
        if(!empty($result1))
        {
         echo 'تم ادخال العميل بنجاح';
        }
    }

   }else{
    echo "erretgerhyor";
   }





  ?>