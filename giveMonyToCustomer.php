   <?php
  include('gsaldb.php');

   if(isset($_POST["PayAmount"])&&$_POST["PayAmount"] != "")
   {
      $statement = $connection->prepare("select custMony from customersMony where custID= :custID");  
      $statement->bindParam(':custID', $_POST["custID"]);
      $statement->execute();
      $result =$statement->fetch();

      $amount=intval($result['custMony']);
      $deliverdMony=intval($_POST['PayAmount']);

      if($deliverdMony > $amount)
      {
      echo "error";

      }else{

          $statement1 = $connection->prepare("
         INSERT INTO giveMonyToCustomer (giveMonyAmount,custID,memberID,giveMonyDate) 
         VALUES (:giveMonyAmount,:custID,:memberID,:giveMonyDate)
        ");
        $result1 = $statement1->execute(
         array(
          ':giveMonyAmount' => $_POST["PayAmount"],
          ':custID' => $_POST["custID"],
          ':memberID' => $_POST["memberID"],
          ':giveMonyDate' => date("Ymd")
         )
        );
        if(!empty($result1))
        {
          $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal-:khaznaTotal");  
          $statement->bindParam(':khaznaTotal', intval($_POST["PayAmount"]));
          $statement->execute();

          $statement = $connection->prepare("UPDATE customersMony SET custMony=custMony-:custMony");  
          $statement->bindParam(':custMony', intval($_POST["PayAmount"]));
          $statement->execute();

         echo 'تم ادخال المبلغ بنجاح';

        }
        else{
          echo "errror";
        } 

      }
  
  }else{
    echo "no set of post";
  }

  ?>