   <?php
   session_start();
  include('gsaldb.php');
 if(isset($_POST["depositAmount"])&&$_POST["depositAmount"] != "")
   {

     $mordID=$_POST["SelectMoredName"];
      $statement = $connection->prepare("select totalAmountRemain from elmordeen where mordID=:mordID");
      $statement->bindParam(':mordID', $mordID);
      $statement->execute();
      $result = $statement->fetch();
      $lastTotal=$result['totalAmountRemain'];


       $statement1 = $connection->prepare("
                   INSERT INTO deposits (mordID,depositAmount,depositDate,lastAmountRemain,memberID,depositType) 
                   VALUES (:mordID, :depositAmount, :depositDate,:lastAmountRemain,:memberID,:depositType)
                  ");
                  $result1 = $statement1->execute(
                   array(
                    ':mordID' => $mordID,
                    ':depositAmount' => $_POST["depositAmount"],
                    ':depositDate'  => date("Ymd"),
                    ':lastAmountRemain'  => $lastTotal,
                    ':memberID'  => $_SESSION["memberID"],
                    ':depositType'  => $_POST["depositType"]
                    

                  )
              );


      $statement = $connection->prepare("
         update elmordeen set totalAmountRemain=totalAmountRemain-:newCost where mordID=:mordID");
        $result = $statement->execute( array(
          ':newCost' => $_POST["depositAmount"],
          ':mordID' => $_POST["SelectMoredName"]
         ));


    $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:khaznaTotal");  
    $statement->bindParam(':khaznaTotal', intval($_POST["depositAmount"]));
  
    $statement->execute();     
                     
}
else{
  echo "errrrdfgergrrror";
 }

  ?>