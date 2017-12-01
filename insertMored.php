   <?php
  include('gsaldb.php');
 if(isset($_POST["moredName"])&&$_POST["moredName"] != "")
   {
    $statement = $connection->prepare("select count(*) from elmordeen where mordName=:mordName");
    $statement->bindParam(':mordName', $_POST["moredName"], PDO::PARAM_STR, 12);
   
    $statement->execute();
    if($statement->fetchColumn())
    {
    echo "error";

    }else{
        $statement1 = $connection->prepare("
                   INSERT INTO elmordeen (mordName,mordPhone,mordBankID) 
                   VALUES (:mordName, :mordPhone, :mordBankID)
                  ");
                  $result1 = $statement1->execute(
                   array(
                    ':mordName' => $_POST["moredName"],
                    ':mordPhone' => $_POST["moredPhone"],
                    ':mordBankID'  => $_POST["moredBankID"]

                  )
              );
          
    }

}
 else{
              echo "errrrdfgergrrror";
 }

  ?>