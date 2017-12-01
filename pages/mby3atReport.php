<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
}else{
    header("location:LoginCredintial.php");
}


?>
  <div class="row">
	<div class="col-md-12">
		
	<form method="post" id="">
		<div class="row">
			<div class="col-lg-1 col-md-1"></div>
			<div class="col-lg-4 col-md-4 control-group">
				 <label>تقرير خلال الفتره من </label>
				 <input type="text" id="mbe3atReportSDate" class="form-control"/>
			</div>
			<div class="col-lg-4 col-md-4 control-group">
				<label>الى </label>
				<input type="text" id="mbe3atReportEDate" class="form-control"/>
				
			</div>	
			<div class="col-lg-2 col-md-2 control-group">
				<label style="display:block;visibility:hidden;">ط|ل</label>
				<input type="submit" value="تقرير" id="showMbe3atReportBtn" class="btn  btn-block" 
			       style="color: #B80303;background-color:#FBB900;"> 
			</div>
			<div class="col-lg-1 col-md-1"></div>	
		</div>

		</form>

	</div>
	
</div>
	
<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />

<center>
			<label id="mbe3atReportLbl" style="background-color:#EEEEEE;color:#B80303;padding-left:17px;padding-right:17px;">
				الرسم البياني يوضح أكثر العملاء شراء اخر شهر
			</label>
		</center>
<center>
	<br>
<div class="row">
<div class="col-lg-4 col-md-4" id="mbe3atReportTableDiv"></div>
 <div class="col-lg-8 col-md-8" id="mbe3atReportDiv" style="min-width: 310px; height: 400px;float:right">
 	
</div>
</div>
</center>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />

<center>
			<label id="mbe3atProductReportLbl" style="background-color:#EEEEEE;color:#B80303;padding-left:17px;padding-right:17px;">
				الرسم البياني يوضح اكثر الاصناف مبيعا اخر شهر
			</label>
		</center>
<center>
	<br>
<div class="row">
<div class="col-lg-5 col-md-5" id="mbe3atProductReportTableDiv"></div>
 <div class="col-lg-7 col-md-7" id="mbe3atProductReportDiv" style="min-width: 310px; height: 400px;float:right">
 	
</div>
</div>
</center>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<center>
  <div class="row">
	<div class="col-md-12">
		<div class="row">
			 <select id="SelectYearInMbe3atYearReport" style="max-width:300px;margin-bottom:7px;" class="form-control">
                <option value="0">تقرير خلال عام</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2034">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option>
                <option value="2040">2040</option>
                <option value="2041">2041</option>
                <option value="2042">2042</option>
                <option value="2043">2043</option>
                <option value="2044">2044</option>
                <option value="2045">2045</option>
                <option value="2046">2046</option>
                <option value="2047">2047</option>
                <option value="2048">2048</option>
                <option value="2049">2049</option>
                <option value="2050">2050</option>
                <option value="2051">2051</option>
                <option value="2052">2052</option>
                <option value="2053">2053</option>
                <option value="2054">2054</option>
                <option value="2055">2055</option>
                <option value="2056">2056</option>
              </select>
				
		</div>


	</div>
	
</div>
</center>


<center>
			<label id="mbe3atFtratMonthsReportLbl" style="background-color:#EEEEEE;color:#B80303;padding-left:17px;padding-right:17px;">
				
			</label>
		</center>
<center>
	<br>
<div class="row">
<div class="col-lg-4 col-md-4" id="mbe3atFtratMonthsReportTableDiv"></div>
 <div class="col-lg-8 col-md-8" id="mbe3atFtratMonthsReportDiv" style="min-width: 310px; height: 400px;float:right">
 	
</div>
</div>
</center>

<hr style="width: 100%; color: #FBB900; height: 1px; background-color:#FBB900;" />
<center>
  <div class="row">
	<div class="col-md-12">
		<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-4 col-md-4">
			 <select id="SelectYearInMbe3atYearMonthReport" style="max-width:300px;margin-bottom:7px;" class="form-control">
                <option value="0">سنة</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2034">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option>
                <option value="2040">2040</option>
                <option value="2041">2041</option>
                <option value="2042">2042</option>
                <option value="2043">2043</option>
                <option value="2044">2044</option>
                <option value="2045">2045</option>
                <option value="2046">2046</option>
                <option value="2047">2047</option>
                <option value="2048">2048</option>
                <option value="2049">2049</option>
                <option value="2050">2050</option>
                <option value="2051">2051</option>
                <option value="2052">2052</option>
                <option value="2053">2053</option>
                <option value="2054">2054</option>
                <option value="2055">2055</option>
                <option value="2056">2056</option>
              </select>
				
		</div>

			<div class="col-lg-4 col-md-4">
			 <select id="SelectMonthInMbe3atYearMonthReport" style="max-width:300px;margin-bottom:7px;" class="form-control">
                <option value="0">شهر</option>
                <option value="1">يناير</option>
                <option value="2">فبراير</option>
                <option value="3">مارس</option>
                <option value="4">أبريل</option>
                <option value="5">مايو</option>
                <option value="6">يونية</option>
                <option value="7">يوليو</option>
                <option value="8">أغسطس</option>
                <option value="9">سبتمبر</option>
                <option value="10">أكتوبر</option>
                <option value="11">نوفمبر</option>
                <option value="12">ديسمبر</option>
                
              </select>
				
		</div>
		<div class="col-lg-2 col-md-2"></div>


	</div>
	
</div>
</center>


<center>
			<label id="mbe3atFtratYearMonthsReportLbl" style="background-color:#EEEEEE;color:#B80303;padding-left:17px;padding-right:17px;">
				
			</label>
		</center>
<center>
	<br>
<div class="row">
<div class="col-lg-4 col-md-4" id="mbe3atFtratYearMonthsReportTableDiv"></div>
 <div class="col-lg-8 col-md-8" id="mbe3atFtratYearMonthsReportDiv" style="min-width: 310px; height: 400px;float:right">
 	
</div>
</div>
</center>
