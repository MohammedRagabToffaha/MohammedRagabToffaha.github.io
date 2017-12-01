   <?php
  include('gsaldb.php');

        if (isset($_POST["PayAmount"])&&$_POST["PayAmount"] != "") {
          # code...
          $statement = $connection->prepare("select custMony from customersMony where custID=:custID");  
          $statement->bindParam(':custID', $_POST["custID"]);
          $statement->execute();
          $result = $statement->fetch();
          $custmony;
          if ($result['custMony'] ==null) {
            $custmony=0;
          }else{
            $custmony=$result['custMony'];
          }

          $statement1 = $connection->prepare("
             INSERT INTO customerspaidMony (custID,customerspaidMonyAmount,paidDate,employeeID,remainFromLast,totalFromLast) 
             VALUES (:custID,:customerspaidMonyAmount,:paidDate,:employeeID,0,:totalFromLast)
            ");
            $result1 = $statement1->execute(
             array(
              ':custID' => $_POST["custID"],
              ':customerspaidMonyAmount' => $_POST["PayAmount"],
              ':paidDate' => date("Ymd"),
              ':employeeID' => $_POST["memberID"],
              ':totalFromLast' => $custmony
             )
            );
            if(!empty($result1))
            {

               $statement = $connection->prepare("select count(*) from customersMony where custID=:custID");  
               $statement->bindParam(':custID', $_POST["custID"]);
               $statement->execute();
              if($statement->fetchColumn())
              {
                  $statement = $connection->prepare("update customersMony set custMony=custMony+:custMony where custID=:custID");
                   $result= $statement->execute(
                   array(
                    ':custID' => $_POST["custID"],
                    ':custMony' => $_POST["PayAmount"]
                   ));

              }
              else{
                $statement = $connection->prepare("INSERT into customersMony (custID,custMony) values (:custID,:custMony)");
                   $result= $statement->execute(
                   array(
                    ':custID' => $_POST["custID"],
                    ':custMony' => $_POST["PayAmount"]
                   ));
              }

                $statement = $connection->prepare("UPDATE khazna SET khaznaTotal=khaznaTotal+:khaznaTotal");  
                $statement->bindParam(':khaznaTotal', intval($_POST["PayAmount"]));
                $statement->execute();
            }
            else{
              echo "error";
            }

       

    }




  ?>