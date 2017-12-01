<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   header("location:index.php");
} else {
    $message="";
   
}
include('gesalDB.php');
if (!$dbConnection) {
    $message="";
    $message= "خطأ في التصال بقاعدة البيانات";
}


if (isset($_POST["login"])) {
    
    $uname=mysqli_real_escape_string($dbConnection,$_POST['uname']);
    $pass=mysqli_real_escape_string($dbConnection,$_POST['password']);
    $uname = stripslashes($uname);
    $pass = stripslashes($pass);

    $result=mysqli_query($dbConnection,"select * from members where memberName='$uname' and memberPassword='$pass'");
    $user=mysqli_fetch_array($result);
    if ($user) {
        # code...
        if (!empty($_POST["remember"])) {
            setcookie("member_login",$_POST["uname"],time()+(10*365*24*60*60));
            setcookie("member_password",$_POST["password"],time()+(10*365*24*60*60));
            }
        else{
            if (isset($_COOKIE["member_login"])) {
                setcookie("member_login","");
            }
            if (isset($_COOKIE["member_password"])) {
                setcookie("member_password","");
            }

        }
        $_SESSION['loggedin'] = true;
        $_SESSION["name"] = $_POST["uname"];
        $_SESSION["memberID"] = $user["memberID"];
        header("location:index.php");

    }
    else{
        $message="";
        $message="خطأ في أسم المستخدم او كلمة السر";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="محافظة الشرقيه - فاقوس - أول مدخل فاقوس - التواصل عن طريق رقم تليفون 01095555561 - 01095555562">
    <title>العسال لتجارة الحديد - الحاج/حمدي العسال</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
   <link href="css/sb-admin-2.css" rel="stylesheet" />
    <link href="css/font-awesome/font-awesome.min.css" rel="stylesheet" />
    
      <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
       <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
   
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link href="css/bootstrap-override.css" rel="stylesheet"/>
      
   <style type="text/css">
   body{
    background:url('img/cover.jpg') no-repeat center center fixed;
   background-size: cover;
   width: 100%;
    height: 100%;
  
    
   }

   </style>
     

</head>

<body>
 <nav class="navbar navbar-default navbar-static-top" role="navigation" style="background-color:#464E5A;margin-bottom:0px">
<div class="navbar-header">
 <a class="navbar-brand " id="loginbtn"  style="color:#FAB900" 
              onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#FAB900'"
             rel="logout" href="#" data-toggle="modal" data-target="#loginModal" title="تسجيل الدخول"><i class="fa  fa-sign-in fa-fw"></i> </a>

<!-- <a class=" "style="color:white;float:left" rel="home" href="/" ><img  id="l"  src="img/logo.png"></a> -->
</div>
</nav>
 <div class="container">
    <br>
    <br>
      <div class="col-lg-4 col-md-4 col-sm-2"></div>
      <div class="col-lg-4 col-md-4 col-sm-8"><a rel="home" href="/" ><img  id="ll"  src="img/logoToPrint.png"></a></div>
      <div class="col-lg-4 col-md-4 col-sm-2"></div>
 </div>

 <!-- jQuery Version 1.11.0 -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> 

    <!-- Bootstrap Core JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
   

</body>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  


    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="js/sb-admin-2.js"></script>

</html>

<div id="loginModal" class="modal fade" style="z-index:100000000;overflow:auto;">
 <div class="modal-dialog">
 <form role="form" action="" method="post" id="frmLogin">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">تسجيل الدخول</h4>
    </div>
    <div class="modal-body">

 
                    <div class="panel-heading" style="color: #fff;background-color:#B80303;">
                        <h3 class="panel-title">شركة العسال لتجارة الحديد<img src="https://steelnet.000webhostapp.com/img/loging.png" id="loginImg"  class="pull-left"/></span></h3>
                    </div>
                    <div class="panel-body">
                       
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="أسم المستخدم" id="uname" name="uname" type="text" value="<?php if (isset($_COOKIE["member_login"])) {
                                        echo $_COOKIE["member_login"];
                                    }?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="كلمة السر" id="password" name="password" type="password" value="<?php if (isset($_COOKIE["member_password"])) {
                                        echo $_COOKIE["member_password"];
                                    }?>">
                                </div>
                                   <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"
                                        <?php if (isset($_COOKIE["member_login"])) { ?>
                                            checked
                                       <?php } ?> >حفظ كلمة السر
                                    </label>
                                </div>
                                <div class="text-danger"><?php if (isset($message)) {
                   echo $message;
                }?></div>
                                <!-- Change this to a button or input when using this as a form -->
                                
                                <input type="submit" id="loginbtn" name="login" value="تسجيل الدخول" class="btn btn-lg  btn-block" style="color: #fff;background-color:#B80303;" > 
                            </fieldset>
                        
                    </div>
              




     </div>

   </div>
  </form>
 </div>
</div>







