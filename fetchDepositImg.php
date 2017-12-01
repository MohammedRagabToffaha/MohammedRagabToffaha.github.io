<?php 
if (isset($_POST['depositID'])&&$_POST['depositID'] !="") {
 $imgSorce;
  $src="https://gesal.000webhostapp.com/uploads/".$_POST['depositID'].".jpg";
  if (getimagesize($src) === false) {
    $src1="https://gesal.000webhostapp.com/uploads/".$_POST['depositID'].".png";
    if (getimagesize($src1) === false){
      $src2="https://gesal.000webhostapp.com/uploads/".$_POST['depositID'].".jpeg";
      if (getimagesize($src2) === false){
        /////////////////////////////////
          $src0="https://el3sal.000webhostapp.com/uploads/".$_POST['depositID'].".jpg";
          if (getimagesize($src0) == false) {
            $src11="https://el3sal.000webhostapp.com/uploads/".$_POST['depositID'].".png";
            if (getimagesize($src11) == false){
              $src21="https://el3sal.000webhostapp.com/uploads/".$_POST['depositID'].".jpeg";
              if (getimagesize($src21) == false){
                /////////////////////////////////
                $imgSorce="no-image.jpg";
                /////////////////////////////////

              }else{
              $imgSorce=$src21;
              }
            }else{
            $imgSorce=$src11;
            }
          }else{
            $imgSorce=$src0;
          }
        /////////////////////////////////

      }else{
      $imgSorce=$src2;
      }
    }else{
    $imgSorce=$src1;
    }
  }else{
    $imgSorce=$src;
  }

echo '<img id="deposImgShowing"  src="'.$imgSorce.'" />';

}

?>