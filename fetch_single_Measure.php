    <?php
include('gsaldb.php');

if(isset($_POST["measID"]))
{
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM measures 
  WHERE measID = '".$_POST["measID"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["catID"] = $row["catID"];
  $output["suppID"] = $row["suppID"];
  $output["measName"] = $row["measName"];


 }
 echo json_encode($output);
}
?>