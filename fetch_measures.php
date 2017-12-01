<?php 
$con=mysqli_connect("localhost","id1392949_ibraheem","P@ssw0rdS","id1392949_gsaldb");
$measurs='';
$sql="select * from measures where catID='".$_POST['CatID']."'&&suppID='".$_POST['supp_ID']."'order by measID";
 $result=mysqli_query($con,$sql);
        while ($row=mysqli_fetch_array($result)) {
            $measurs .='<option value= "'.$row["measID"].'">'.$row["measName"].'</option>';
        }
        echo $measurs;
?>