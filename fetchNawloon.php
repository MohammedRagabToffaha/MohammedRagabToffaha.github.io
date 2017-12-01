	<?php
	include('gsaldb.php');

	$data = array();
	$output = array();
	$statement = $connection->prepare("select * from nwloon");
	$statement->execute();
	$result = $statement->fetchAll();

	

	foreach($result as $row)
	{
		  $sub_array = array();
		
	     $sub_array[] = $row["nwloonName"];
	     $sub_array[] = $row["nwloonPhone"];
	     $nwloonRemainMony= $row["nwloonRemainMony"];
	     $nwloonRemainMony=number_format($nwloonRemainMony)." جنية";
	     $sub_array[] = $nwloonRemainMony;

	     $deliverMony=" <div class='input-group' style='max-width:250px'>
        <input type='text' id='Nwloon".$row["nwloonID"]."' style='min-width:90px' class='form-control' placeholder='المبلغ'/>
        <span class='input-group-btn'>
            <input type='button' data-deliverMonyNwloon='".$row["nwloonID"]."'  value='+' class='btn deliverMonyNwloonBtn' 
            style='background-color: #B80303;color:white' />          
        </span>
    </div>"; 
		$sub_array[] = $deliverMony;
		 
		 $data[] = $sub_array;
	}

	$output = array(
	 "draw"    => intval($_POST["draw"]),
	 // "recordsTotal"  =>  $filtered_rows,
	 // "recordsFiltered" => get_total_all_records_Suppliers(),
	 "data"    => $data
	);

	echo json_encode($output);


	?>