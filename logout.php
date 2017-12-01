<?php  
 //logout.php  
 session_start(); 
  $_SESSION['loggedin'] = false;  
 session_destroy(); 

 header('location:LoginCredintial.php');  
 ?>