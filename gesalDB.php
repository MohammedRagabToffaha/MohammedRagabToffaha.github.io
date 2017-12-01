<?php
include("secretInfo.php");
$username =USERNAME;
$password =PASSWORD;
//$connection = new PDO( 'mysql:host=localhost;dbname=id1392949_gsaldb', $username, $password );

$dbConnection = mysqli_connect("localhost",$username, $password, "id3604768_steelnetdb");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed");
    exit();
}

?>