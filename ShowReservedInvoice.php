    <?php
    session_start();
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

if(isset($_POST["InvoiceNo"])&&$_POST["InvoiceNo"]!='')
{
  $html="<div class='row' >";
   
    $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
    $html.="<thead><tr style='background-color: #B80303;color: #fff'>
    <th width='30%' colspan='3'>الصنف</th><th width='10%'>الكميه المحجوزه</th><th width='10%'>متبقي اوزان</th><th width='10%'>
   متبقي نقديه</th><th width='10%'>سعر الطن</th><th width='15%'>تسليم اوزان</th><th width='15%'>تسليم نقديه</th></tr></thead><tbody>";


    $statement1 = $connection->prepare("select orderDetailsID,productID,Quantity,unitPrice,outQuantity,outMony from orderDetails 
    where invoiceNo=:invoiceNo");
    $statement1->execute(array(':invoiceNo'=>$_POST['InvoiceNo']));
    $result1 = $statement1->fetchAll();

    foreach ($result1 as $row){

      $statement = $connection->prepare("select catID,suppID,measName from measures 
      where measID=:measID");
      $statement->execute(array(':measID'=>$row['productID']));
      $result = $statement->fetch();


        $statement2 = $connection->prepare("select suppName from suppliers 
      where suppID=:suppID ");
      $statement2->bindParam(':suppID', $result["suppID"]);
      $statement2->execute();
      $result2 = $statement2->fetch();

      $statement3 = $connection->prepare("select catName from categories 
      where catID=:catID ");
      $statement3->bindParam(':catID', $result["catID"]);
      $statement3->execute();
      $result3 = $statement3->fetch();

      $remainAsQuantity;
      $remainAsMony;
      if ($row['outQuantity'] != null) {
        if ($row['outMony'] != null) {
          $q=($row['outMony']/$row['unitPrice'])*1000;
          $remainAsQuantity=$row['Quantity']-$row['outQuantity']-$q;
          $remainAsMony=($remainAsQuantity*$row["unitPrice"])/1000;
        }else{
          $remainAsQuantity=$row['Quantity']-$row['outQuantity'];
          $remainAsMony=($remainAsQuantity*$row["unitPrice"])/1000;
        }
        
      }else{
        //$remainQuantity=$row['Quantity'];
        if ($row['outMony'] != null) {
          $q=($row['outMony']/$row['unitPrice'])*1000;
          $remainAsQuantity=$row['Quantity']-$q;
          $remainAsMony=($remainAsQuantity*$row["unitPrice"])/1000;
        }else{
          $remainAsQuantity=$row['Quantity'];
          $remainAsMony=($remainAsQuantity*$row["unitPrice"])/1000;
        }
      }
      if ($remainAsQuantity >1000) {
        $remainAsQuantity=intval($remainAsQuantity);
      }else{
        $remainAsQuantity=number_format($remainAsQuantity,2);
      }

      

       $inputQant=" <div class='input-group'>
                  <input type='text' id='q".$row["orderDetailsID"]."' class='form-control' placeholder='الكمية بالكيلو'/>
                  <span class='input-group-btn'>
                      <input type='button' data-invNo='".$_POST["InvoiceNo"]."' data-withdrowReservation='".$row["orderDetailsID"]."'  value='+' class='btn withdrowReservationBtn' />
                  </span>
                  
              </div>";

     $inputMony=" <div class='input-group'>
        <input type='text' id='m".$row["orderDetailsID"]."' class='form-control' placeholder='المبلغ'/>
        <span class='input-group-btn'>
            <input type='button' data-invNo='".$_POST["InvoiceNo"]."' data-withdrowReservation='".$row["orderDetailsID"]."'  value='+' class='btn withdrowReservationMonyBtn' />          
        </span>
    </div>";  


       $html.="<tr><td>".$result2["suppName"]."</td><td>".$result3["catName"]."</td><td>".$result["measName"].
       "</td><td>".convertTotenAndKelo($row["Quantity"])."</td><td>".convertTotenAndKelo($remainAsQuantity).
       "</td><td>".number_format(intval($remainAsMony))." جنيه"."</td><td>"
   .number_format(intval($row["unitPrice"]))." جنيه"."</td><td>".$inputQant."</td><td>".$inputMony."</td></tr>";

      // $statement = $connection->prepare("update measures set unitInStock=unitInStock-:qant where measID=:measID");  
      // $statement->bindParam(':qant',$row["Quantity"]);
      // $statement->bindParam(':measID',$row["productID"]);
      // $statement->execute();
    }

$html.="</tbody></table></div>";

 $html.="<div class='row' id='divShowReservedInv'><label id='ShowReservedInvLbl' style='background-color: #FBB900
  ;color: #B80303;width:300px;height:30px;line-height: 27px;'>"."تفاصيل عمليات السحب"."</label></div>";  

  $statement = $connection->prepare("select distinct withdDate from withdrowfromReservation 
    where invoiceNo=:invoiceNo order by withdDate desc,withdID desc");
    $statement->execute(array(':invoiceNo'=>$_POST['InvoiceNo']));
    $result = $statement->fetchAll();

    foreach ($result as $row){
      $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
    $html.="<label style='margin-top:10px'>".$row['withdDate']."</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

    $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
    $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
    $html.="<tr style='background-color: #B80303;color: #fff'><th width='30%' colspan='3'>
    "."الصنف"."</th><th width='15%'>الكمية المسحوبة</th><th width='15%'>متاح للارجاع</th><th width='10%'>المبلغ المسحوب</th>
    <th width='15%'>إرجاع</th><th width='15%'>إرجاع للحجز</th></tr>";

    $statement1 = $connection->prepare("select * from withdrowfromReservation 
    where invoiceNo=:invoiceNo and withdDate=:withdDate order by withdID desc");
    
    $statement1->bindParam(':invoiceNo', $_POST["InvoiceNo"]);
    $statement1->bindParam(':withdDate',$row['withdDate']);
    $statement1->execute();
    $result1 = $statement1->fetchAll();
    foreach($result1 as $row1){
        $statement = $connection->prepare("select catID,suppID,measName from measures 
      where measID=:measID");
      $statement->execute(array(':measID'=>$row1['productID']));
      $result = $statement->fetch();


        $statement2 = $connection->prepare("select suppName from suppliers 
      where suppID=:suppID ");
      $statement2->bindParam(':suppID', $result["suppID"]);
      $statement2->execute();
      $result2 = $statement2->fetch();

      $statement3 = $connection->prepare("select catName from categories 
      where catID=:catID ");
      $statement3->bindParam(':catID', $result["catID"]);
      $statement3->execute();
      $result3 = $statement3->fetch();

      $withdMortg3;
      $qAfter;
      $mAfter;
     
      $erga3Group;
      $erga3To7gz;
      if ($row1["withdQuant"]!=null) {

       $qAfter=convertTotenAndKelo($row1["withdQuant"]);
       $mAfter="ــــــ";

        $erga3Group=" <div class='input-group'>
                  <input type='text' id='mortga".$row1["withdID"]."' class='form-control withdrowMortg3Input' placeholder='مرتجع'/>
                  <span class='input-group-btn'>
                      <input type='button' data-withdrowMortg3='".$row1["withdID"]."'  value='+' class='btn withdrowMortg3Btn' />
                  </span>
              </div>"; 

        $erga3To7gz=" <div class='input-group'>
                  <input type='text' id='r".$row1["withdID"]."' class='form-control withdrow7gzInput' placeholder='حجز مرة اخرى'/>
                  <span class='input-group-btn'>
                      <input type='button' data-withdrow7gz='".$row1["withdID"]."'  value='+' class='btn withdrow7gzBtn' />
                  </span>
              </div>";      

       if ($row1["withdMortg3"]==null) {
        $withdMortg3=convertTotenAndKelo($row1["withdQuant"]);
      }else{
        $withdMortg3=convertTotenAndKelo($row1["withdQuant"]-$row1["withdMortg3"]);
      }      


      }else{
        $mAfter=number_format($row1["withdMony"])." جنيه";
        $qAfter="ــــــ";
        $erga3Group="ــــــ";
        $erga3To7gz="ــــــ";
        $withdMortg3="ــــــ";
      }


             

      $html.="<tr><td>".$result2["suppName"]."</td><td>".$result3["catName"]."</td><td>"
      .$result["measName"]."</td><td>".$qAfter."</td><td>".$withdMortg3
      ."</td><td>".$mAfter."</td><td>".$erga3Group."</td><td>".$erga3To7gz."</td></tr>";

    }
  $html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
    }

     $html.="<div class='row' id='divShowMortg3'><label id='ShowMortg3Lbl' style='background-color: #FBB900
  ;color: #B80303;width:300px;height:30px;line-height: 27px;'>"."تفاصيل عمليات الإرجاع"."</label></div>"; 

   $statement = $connection->prepare("select distinct mortg3Date from mortg3FromReservation 
    where invoiceNo=:invoiceNo order by mortg3Date desc,mortg3ID desc");
    $statement->execute(array(':invoiceNo'=>$_POST['InvoiceNo']));
    $result = $statement->fetchAll();

    foreach ($result as $row){
      $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
    $html.="<label style='margin-top:10px'>".$row['mortg3Date']."</label></div><div class='col-lg-1 col-md-1 col-sm-1'></div></div>";

    $html.="<div class='row'><div class='col-lg-1 col-md-1 col-sm-1'></div><div class='col-lg-10 col-md-10 col-sm-10'>";
    $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered hover'>";
    $html.="<tr style='background-color: #B80303;color: #fff'><th width='30%' colspan='3'>
    "."الصنف"."</th><th width='20%'>المرتجع</th><th width='15%'>سعر الطن</th><th width='15%'>سعر المرتجع</th>
    <th width='20%'>الحاله</th></tr>";

    $statement1 = $connection->prepare("select * from mortg3FromReservation 
    where invoiceNo=:invoiceNo and mortg3Date=:mortg3Date order by mortg3Date desc, mortg3ID desc");
    
    $statement1->bindParam(':invoiceNo', $_POST["InvoiceNo"]);
    $statement1->bindParam(':mortg3Date',$row['mortg3Date']);
    $statement1->execute();
    $result1 = $statement1->fetchAll();
    foreach($result1 as $row1){
        $statement = $connection->prepare("select catID,suppID,measName from measures 
      where measID=:measID");
      $statement->execute(array(':measID'=>$row1['productID']));
      $result = $statement->fetch();


        $statement2 = $connection->prepare("select suppName from suppliers 
      where suppID=:suppID ");
      $statement2->bindParam(':suppID', $result["suppID"]);
      $statement2->execute();
      $result2 = $statement2->fetch();

      $statement3 = $connection->prepare("select catName from categories 
      where catID=:catID ");
      $statement3->bindParam(':catID', $result["catID"]);
      $statement3->execute();
      $result3 = $statement3->fetch();

      $unitPrice=$row1['unitPrice'];           
      $mortg3Quantity=$row1['mortg3Quantity'];           
      $mortg3Cost=($unitPrice*$mortg3Quantity)/1000; 

      $state;
      if ($row1['mortg3ToReserve']=='1') {
        $state="حجز مرة اخرى";
      }else{
        $state="مرتجع";
      }          

      $html.="<tr><td>".$result2["suppName"]."</td><td>".$result3["catName"]."</td><td>"
      .$result["measName"]."</td><td>".convertTotenAndKelo($mortg3Quantity)."</td><td>".number_format($unitPrice)
      ."</td><td>".$mortg3Cost."</td><td>".$state."</td></tr>";

    }
  $html.="</table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
    }


$html.="</div>"; 
  echo $html;
 
}
?>