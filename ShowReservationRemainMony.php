    <?php
include('gsaldb.php');

if(isset($_POST["reservID"])&&$_POST["reservID"]!=''){

  try {
          $connection->beginTransaction();
          
   $html="<div class='row' >";
   
    $statement1 = $connection->prepare("select * from reservationRemainsMony 
    where reservID=:reservID order by rrID desc");
    $statement1->execute(array(':reservID'=>$_POST["reservID"]));
    $result1 = $statement1->fetchAll();

    if ($statement1->rowCount() > 0){


    $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
    $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
    $html.="<thead><tr style='background-color: #B80303;color: #fff'>
    <th width='20%'>تاريخ الدفع</th><th width='20%'>متبقي فبل الدفع</th><th width='20%'>المبلغ المدفوع</th>
    <th width='20%'>متبقي بعد الدفع</th><th width='20%'>مستلم المبلغ</th></tr></thead><tbody>";

      foreach ($result1 as $row){
      $statement1 = $connection->prepare("select memberOficialName from members 
      where memberID=:memberID");
      
      $statement1->execute(array(':memberID'=>$row['memberID']));
      $result1 = $statement1->fetch();

      $rb=$row['remainBeforPaid'];
      $ra=$rb-$row['paidMony'];

      $html.="<tr><td>".$row["rrDate"]."</td><td>".number_format($rb)." جنيه</td><td>".number_format($row['paidMony'])
      ." جنيه</td><td>".number_format($ra)." جنيه</td><td>".$result1['memberOficialName']."</td></tr>";
    }
    $html.="</tbody></table></div></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";
    }else{
     
      $html.="<div class='row' id='parentDiv'><div class='col-lg-2 col-md-2 col-sm-1'></div><div id='chilDiv' class='col-lg-8 col-md-8 col-sm-10'>";
       $html.="لا يوجد عمليات دفع اجل سابقه</div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
    }

$html.="</div>"; 
  echo $html;
 $connection->commit();
    }
     catch (PDOException $e) {
      $connection->rollBack();
    } 
 
}
?>