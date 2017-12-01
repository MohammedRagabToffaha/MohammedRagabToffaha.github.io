  <?php
  include('gsaldb.php');
  if(isset($_POST["username"]))
  {
  	 $statement = $connection->prepare("select * from members where memberName = :memberName limit 1");  
	    $statement->bindParam(':memberName', $_POST["username"]);
	    $statement->execute();
	   $result = $statement->fetch();

	   if (($_POST["oldPass"]==$result["memberPassword"])&&$_POST["newPass"] != "") {
	   	$statement = $connection->prepare("update members set memberPassword = :memberPassword where memberName = :memberName");  
	    $statement->bindParam(':memberPassword', $_POST["newPass"]);
	    $statement->bindParam(':memberName', $_POST["username"]);
	    $result1 =$statement->execute();
	    if(!empty($result1))
	    {
	     echo "تم تغيير كلمة السر بنجاح";
	    }
	   }else{
	   	echo"كلمة السر القديمة غير صحيحة";
	   }
		 
 }else{
 	echo "error";
 }
?>