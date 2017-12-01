    <?php
include('gsaldb.php');
  include('function.php');

if(isset($_POST["cust_id"]))
{
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM customers 
  WHERE custID = '".$_POST["cust_id"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["custName"] = $row["custName"];
  $output["custPhone"] = $row["custPhone"];
  $output["custAddress"] = $row["custAddress"];


 }
 echo json_encode($output);
}
?>