<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}


?>


<br>
<div class='row' id='khaznaDetailsDiv'><label id='khaznaDetailsLbl' style='text-align:center;height:30px;width:350px;
	line-height: 27px;padding-right:30px;padding-left:30px'>تفاصيل النقديه الموجوده داخل الخزنه&nbsp&nbsp&nbsp<i class="fa fa-refresh"></i></label>
	</div> 

 <div class="row" id="khznaDetailsDiv" style="padding-right:25px;">
</div>





