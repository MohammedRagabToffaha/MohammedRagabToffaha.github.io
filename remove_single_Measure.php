    <?php
include('gsaldb.php');

if(isset($_POST["measID"]))
{
 $output = array();
 $statement = $connection->prepare(
  "delete FROM measures 
  WHERE measID = '".$_POST["measID"]."' 
  LIMIT 1"
 );

if (!$statement->execute()) {
	echo "error";
}else{
	echo "success";
}
 
}
?>