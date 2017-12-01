    <?php


function get_total_all_records()
{
 include('gsaldb.php');
 $statement = $connection->prepare("SELECT * FROM customers");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}
function get_total_all_records_invoices()
{
 include('gsaldb.php');
 $statement = $connection->prepare("SELECT * FROM orders");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}
function get_total_all_records_Suppliers()
{
 include('gsaldb.php');
 $statement = $connection->prepare("SELECT * FROM measures");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}

?>