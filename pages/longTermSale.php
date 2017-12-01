<br>
 <div class="row">
<form method="post" id="form_customerReport">
    
  <div class="col-lg-4 col-md-4">
        
      <input type="text" id="customerNameForAgel" placeholder="أسم العميل ..." autocomplete="off" class="form-control" data-cnReportdata="" />
     <div id="customerNameListForAgel"></div>
   
 </div>
 </form>
 <div class="col-lg-4 col-md-4 col-sm-1">
    <form method='post' id='form_AddMonyToCustomer2'>
            <div class='input-group'>
                    <input type='text' id='custMonyInput2' class='form-control' placeholder='تحصيل مبلغ من العميل'/>
                    <span class='input-group-btn'>
                        <input type='submit' style='border-radius: 0px;'  id='custMonyBtn' value='+' class='btn' />
                       
                    </span>
                    
                </div>
                    <!-- <input type='hidden' id='hiddenCNametoCostomerMony2' value='' /> -->
                    <input type='hidden' id='hiddenMemberID2' data-memberID='".$_SESSION["memberID"]."'/>
                            
     </form>
 </div>
 <div class="col-lg-4 col-md-4 col-sm-1">
    <form method='post' id='form_givMonyToCustomer2'>
      <div class='input-group'>
              <input type='text' id='giveCustMonyInput2' class='form-control' placeholder='تسليم العميل مبلغ من المتبقي له'/>
              <span class='input-group-btn'>
                  <input type='submit' style='border-radius: 0px;' id='giveCustMonyBtn' value='+' class='btn' />
                 
              </span>
              
          </div>
              <!-- <input type='hidden' id='hiddenCNametoGiveMony2' value='' /> -->
              <input type='hidden' id='hiddenGiveMemberID2' data-memberID='".$_SESSION["memberID"]."'/>
              
          </form>

 </div>

 </div>  

<br>
<center>
  <label style='text-align:center;height:30px;width:350px;line-height: 27px;padding-right:30px;padding-left:30px;background-color:#FD3C40;color:#fff'>
   المبالغ المتبقيه على العملاء&nbsp&nbsp&nbsp<i class="fa fa-refresh reloadCustomersRemainMony" style='cursor:pointer' data-toggle="tooltip"
    title="إعادة تحميل"></i></label>

<br>
 <div class="row" id="customersRemainMony"></div>  
<br>
<div class="modalReloadGifAddInv"></div>  
<label style='text-align:center;height:30px;width:350px;line-height: 27px;padding-right:30px;padding-left:30px;background-color:#FD3C40;color:#fff'>
   المبالغ المتبقيه للعملاء&nbsp&nbsp&nbsp<i class="fa fa-refresh reloadCustomersMony" style='cursor:pointer' data-toggle="tooltip"
    title="إعادة تحميل"></i></label>

 <div class="row" id="customersMony"></div>  

<br>


</center>
