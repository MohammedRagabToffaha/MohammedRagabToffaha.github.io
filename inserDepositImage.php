<?php

$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
$path = 'uploads/'; // upload directory

if(isset($_FILES['image']))
{
	$img = $_FILES['image']['name'];
	$tmp = $_FILES['image']['tmp_name'];
		
	// get uploaded file's extension
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	
	// can upload same image using rand function
	//$final_image = rand(1000,1000000).$img;
	
	// check's valid format
	if(in_array($ext, $valid_extensions)) 
	{					
		$path = $path.$_POST['hiddenDeposit'].".".$ext;	
			
		if(move_uploaded_file($tmp,$path)) 
		{
			echo "<img src='$path' />";
		}
	} 
	else 
	{
		echo 'invalid';
	}
}


?>