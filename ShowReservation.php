    <?php
include('gsaldb.php');
  function convertTotenAndKelo($value){
       $stockAfter;
       $stockBefore=$value;
       if ($stockBefore >= 1000) {
        $kelo=$stockBefore%1000;
        $ten=($stockBefore-$kelo)/1000;

        if ($kelo==0) {
          $stockAfter=$ten." طن";
        }else{
          $stockAfter=$ten." طن" ." و ".$kelo." كيلو";
        }

       }else{
        $stockAfter=$stockBefore." كيلو";
       }
       return $stockAfter;
  }

if(isset($_POST["reservID"])&&$_POST["reservID"]!=''){
    try {
          $connection->beginTransaction();

   $html="<div class='row' >";
   
    $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
    $html.="<thead><tr style='background-color: #B80303;color: #fff'>
    <th width='22%'>اسم العميل</th><th width='15%'>حجز بمبلغ</th><th width='12%'>المدفوع عند الحجز</th>
   <th width='17%'>سداد المتبقي</th><th width='17%'>متاح للتسليم</th><th width='17%'>تسليم نقديه</th></tr></thead><tbody>";


    $statement = $connection->prepare("select * from reservation 
    where reservID=:reservID");
    $statement->execute(array(':reservID'=>$_POST['reservID']));
    $result = $statement->fetch();

    $statement1 = $connection->prepare("select custName from customers 
    where custID=:custID");
    $statement1->execute(array(':custID'=>$result['custID']));
    $result1 = $statement1->fetch();

      $paidRemains=" <div class='input-group'>
                  <input type='text' id='p".$_POST["reservID"]."' style='min-width:120px' class='form-control' placeholder='المبلغ المدفوع'/>
                  <span class='input-group-btn'>
                      <input type='button' data-paidRemainsReservation='".$_POST["reservID"]."'  value='+' class='btn paidRemainsReservationBtn' />
                  </span>
                  
              </div>";

     $deliverMony=" <div class='input-group'>
        <input type='text' id='d".$_POST["reservID"]."' style='min-width:90px' class='form-control' placeholder='المبلغ'/>
        <span class='input-group-btn'>
            <input type='button' data-deliverMonyReservation='".$_POST["reservID"]."'  value='+' class='btn deliverMonyReservationBtn' />          
        </span>
    </div>"; 


    $html.="<tr><td>".$result1["custName"]."</td><td>".number_format($result["reservAmount"])." جنيه</td><td>".number_format($result["reservPaidMony"]).
       " جنيه</td><td>".$paidRemains.
       "</td><td>".number_format($result["remainToDelivered"])." جنيه"."</td><td>"
   .$deliverMony."</td></tr>";

   $html.="</tbody></table></div></div>";

$html.="<div class='row divShowReservedCost' ><label id='".$_POST["reservID"]."' class='ShowReservedCostLbl'
 style='text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>"."الاسعار عند الحجز"."</label></div>"; 
    
 $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
 $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
    $html.="<thead><tr style='background-color: #B80303;color: #fff'>
    <th width='40%' colspan='3'>الصنف</th><th width='20%'>الكميه</th><th width='20%'>سعر الطن</th><th width='20%'>
   الاجمالي</th></tr></thead><tbody>";


    $statement1 = $connection->prepare("select * from reservationCost 
    where reservID=:reservID");
    $statement1->execute(array(':reservID'=>$_POST["reservID"]));
    $result1 = $statement1->fetchAll();

    foreach ($result1 as $row){
      $statement = $connection->prepare("select measName from measures 
      where measID=:measID");
      $statement->execute(array(':measID'=>$row['measID']));
      $result = $statement->fetch();


        $statement2 = $connection->prepare("select suppName from suppliers 
      where suppID=:suppID ");
      $statement2->bindParam(':suppID', $row["suppID"]);
      $statement2->execute();
      $result2 = $statement2->fetch();

      $statement3 = $connection->prepare("select catName from categories 
      where catID=:catID ");
      $statement3->bindParam(':catID', $row["catID"]);
      $statement3->execute();
      $result3 = $statement3->fetch();

      $q;
      $tp;
      if ($row["quantity"]==0) {
        $q="ــــــ";
        $tp="ــــــ";
      }else{
        $q=convertTotenAndKelo($row["quantity"]);
        $tp=number_format((($row["quantity"])*($row["unitPrice"]))/1000)." جنيه";
      }

 $html.="<tr><td>".$result2["suppName"]."</td><td>".$result3["catName"]."</td><td>".$result["measName"].
       "</td><td>".$q."</td><td>".number_format($row["unitPrice"])." جنيه</td><td>".$tp."</td></tr>";

    }
    $html.="</tbody></table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";

    $html.="<div class='row divWithdrowAwzan' ><label class='WithdrowAwzanLbl' id='".$_POST["reservID"]."' 
    style='text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>"."تفاصيل عمليات سحب أوزان"."</label></div>";
  $html.="<div class='row' id='WithdrowAwzanShowDiv' style='padding-right:15px;padding-left:15px'></div>";


  $html.="<div class='row divWithdrowMony'><label class='WithdrowMonyLbl' id='".$_POST["reservID"]."' 
  style='text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>"."تفاصيل عمليات سحب نقديه"."</label></div>";
  $html.="<div class='row' id='WithdrowMonyShowDiv' style='padding-right:15px;padding-left:15px'></div>";



 $html.="<div class='row divPayRemainMony'><label class='PayRemainMonyLbl' id='".$_POST["reservID"]."'
  style='text-align:center;height:30px;width:250px;line-height: 27px;padding-right:30px;padding-left:30px'>"."تفاصيل عمليات دفع الاجل"."</label></div>";
$html.="<div class='row' id='PayRemainMonyShowDiv' style='padding-right:15px;padding-left:15px'></div>";



$html.="</div>"; 
  echo $html;
    $connection->commit();
        }
         catch (PDOException $e) {
          $connection->rollBack();
        }
 
}
?>