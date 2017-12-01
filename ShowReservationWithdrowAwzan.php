    <?php

include('gsaldb.php');

if(isset($_POST["reservID"])&&$_POST["reservID"]!=''){
    try {
          $connection->beginTransaction();


   $html="<div class='row' >";
   
    $statement1 = $connection->prepare("select invoiceNo,orderDate,total from orders 
    where reservID=:reservID");
    $statement1->execute(array(':reservID'=>$_POST["reservID"]));
    $result1 = $statement1->fetchAll();
    if ($statement1->rowCount() > 0){


      $html.="<div class='row'><div class='col-lg-2 col-md-2 col-sm-1'></div><div class='col-lg-8 col-md-8 col-sm-10'>";
      $html.="<div class='table-responsive'><table style='width:100%' class='table table-bordered'>";
      $html.="<thead><tr style='background-color: #B80303;color: #fff'><th width='15%'>
    "."رقم الفاتورة"."</th><th width='20%'>تاريخ الاستلام</th><th width='20%'>أجمالي الفاتوره</th><th width='15%'>
    تفاصيل الفاتوره</th><th width='15%'>طباعه</th><th width='15%'>ارحاع</th></tr></thead><tbody>";
      foreach ($result1 as $row){
       
        $btnShow= "<button type='button' name='showInvoiceCustReport' id='".$row["invoiceNo"]."' class='btn btn-xs showInvoice' style='background-color:#B80303;color:white'>معاينه</button>";
        $btnPrint= "<button type='button' name='printInvoice' id='".$row["invoiceNo"]."' class='btn btn-warning btn-xs printInvoice'>طباعة</button>";

        $btnShow = '<button type="button" name="showInvoice" id="'.$row["invoiceNo"].'" class="btn btn-success btn-xs showInvoice"><i class="fa fa-eye fa-fw"></i>معاينه</button>';
        $btnPrint = '<button type="button" name="printInvoice" id="'.$row["invoiceNo"].'" class="btn btn-info btn-xs printInvoice"><i class="fa fa-print fa-fw"></i>طباعة</button>';
        $erga3 = '<button type="button" name="erga3" id="'.$row["invoiceNo"].'" class="btn btn-danger btn-xs erga3"><i class="fa fa-arrow-left fa-fw"></i>إرجاع</button>';
        


        $html.="<tr><td>".$row["invoiceNo"]."</td><td>".$row["orderDate"]."</td><td>".number_format($row["total"])." جنيه</td><td>"
        .$btnShow."</td><td>".$btnPrint."</td><td>".$erga3."</td></tr>";
    }
    $html.="</tbody></table></div></div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";

    }else{
      $html.="<div class='row' id='AwzancontainrowDiv'><div class='col-lg-2 col-md-2 col-sm-1'></div><div id='AwzanchildDiv' class='col-lg-8 col-md-8 col-sm-10'>";
       $html.="لم يتم سحب اية اوزان</div><div class='col-lg-2 col-md-2 col-sm-1'></div></div>";
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