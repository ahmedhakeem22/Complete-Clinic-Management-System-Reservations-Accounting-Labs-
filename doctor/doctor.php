
<?php include 'templats/header.php';
	include 'templats/navbar.php';
	?>

      <main>

        <img src="../img/home.jpg" alt="image" width="100%" height="45%">
        

      </main>


      <footer>
        <p align="center">
            <marquee bgcolor="#FFFFFF" width="468">  WELCOME  </marquee></p>

            <div class="container" id="content">
	<div class="loginicon">
		<div class="row">
		<div class="  col-md-3 col-sm-3"><!-- col-lg-12 Starts -->
		
<div class="form-group" ><!-- form-group Starts -->
<div><img  src="jalsa1.PNG" alt="">
	  <a href="newsession.php" class="col-md-12 "> New session </a></div>

</div><!-- form-group Ends -->
		
	  
	<div class="form-group" ><!-- form-group Starts -->
<div>
		<img  src="IMG4.png" alt="">
		<a href="book_all_out_pdf.php"> مخرجات كشف الصندوق </a>
			</div>

</div><!-- form-group Ends -->
    </div>
		<div class="  col-md-3 col-sm-3"><!-- col-lg-12 Starts -->	
		<div class="form-group" ><!-- form-group Starts -->
    <div>
    <img  src="img7.png" alt="">
		 <a href="book_nafsy_pdf_ach_db.php">  فواتير الفحوص النفسية </a>
       </div>
      

</div><!-- form-group Ends -->

		<div class="form-group" ><!-- form-group Starts -->
 <div> <img  src="IMG5.png" alt="">
       <a href="book_pdf_ach_db.php"> فواتير الجلسات </a>
        </div>
</div><!-- form-group Ends -->

			</div>
            <div class="  col-md-3 col-sm-3"><!-- col-lg-12 Starts -->		
<div class="form-group" ><!-- form-group Starts -->
<div><img  src="img9.png" alt="">
		<a href="select_file_pation.php"> تقارير المرضى </a></div>

</div><!-- form-group Ends -->
<div class="form-group" ><!-- form-group Starts -->
<div><img  src="img8.png" alt="">
		<a href="book_blood_pdf_ach_db.php"> فواتير فحص الدم</a></div>

</div><!-- form-group Ends -->
			</div>

		
    <div class="form-group" ><!-- form-group Starts -->
<div><img  src="img3.png" alt="">
		<a href="book_out.php"> سند صرف </a>
    </div>
        </div>


   

<div class="  col-md-3 col-sm-3"><!-- col-lg-12 Starts -->		
<div class="form-group" ><!-- form-group Starts -->
<div><img  src="img3.png" alt="">
		<a href="report_box_all.php"> جميع فواتير الصندوق </a>
    </div>
</div><!-- form-group Ends -->

			</div>


       <div class="form-group" ><!-- form-group Starts -->
<div><img  src="img3.png" alt="">
		<a href="provider.php">  دعم المركز  </a>
    </div>
        </div>

      <div class="  col-md-3 col-sm-3"><!-- col-lg-12 Starts -->		
<div class="form-group" ><!-- form-group Starts -->
<div><img  src="img3.png" alt="">
		<a href="prov_all_pdf.php"> كشف الداعمين </a>
    </div>
</div><!-- form-group Ends -->
			</div>






 </div>
	    </div>
</div>


        
<p id="demo"></p>

            <script>
            var d = new Date();
            document.getElementById("demo").innerHTML = d;
            </script>  


          
<script LANGUAGE="JavaScript">

     This script and many more are available online from
     The JavaScript Source!! http://javascriptsource.com
    
     Begin
    var day="";
    var month="";
    var myweekday="";
    var year="";
    mydate = new Date();
    myday = mydate.getDay();
    mymonth = mydate.getMonth();
    myweekday= mydate.getDate();
    weekday= myweekday;
    myyear= mydate.getYear();
    year = myyear
    if(myday == 0)
    day = " الأحد, "
    else if(myday == 1)
    day = " الأثنين, "
    else if(myday == 2)
    day = " الثلاثاء, "
    else if(myday == 3)
    day = " الاربعاء, "
    else if(myday == 4)
    day = " الخميس, "
    else if(myday == 5)
    day = " الجمعة, "
    else if(myday == 6)
    day = " السبت, "
    if(mymonth == 0) {
    month = "يناير "}
    else if(mymonth ==1)
    month = "فبراير "
    else if(mymonth ==2)
    month = "مارس "
    else if(mymonth ==3)
    month = "ابريل "
    else if(mymonth ==4)
    month = "مايو "
    else if(mymonth ==5)
    month = "يونيو "
    else if(mymonth ==6)
    month = "يوليو "
    else if(mymonth ==7)
    month = "اغسطس "
    else if(mymonth ==
    month = "سبتمبر "
    else if(mymonth ==9)
    month = "اكتوبر "
    else if(mymonth ==10)
    month = "نوفمبر "
    else if(mymonth ==11)
    month = "ديسمبر "
    
    
    document.write("<b><font face=Arial size=3> " + day + " " + myweekday + " - " );
    document.write(month + " - "+ year + "</font></b>");
    
    </script>

<footer>

      </footer>

      <script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 
     

</body>





</html>

