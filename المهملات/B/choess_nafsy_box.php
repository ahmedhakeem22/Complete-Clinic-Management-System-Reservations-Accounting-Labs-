<html>
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Book a session </title>
            <script src=""></script>
        </head>


<body> 

      <header class="header">

            <div class="navbar">
                  <a href="Home.php">Home</a>
                  <a href="News.php">News</a>
                  <a href="contact.php">Contact</a>
                  <a href="About.php">About</a>
                  <div class="dropdown">
                    <button class="dropbtn">User 
                      <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                      <a href="Doctor.php">Doctor</a>
                      <a href="login.php">Resiption</a>
                      <a href="nafsi.php">المختبـــر النفسي</a>
                      <a href="blood.php">مختبـــر الدم</a>
                      <a href="pharm.php">الصيدليــة </a>

                    </div>
                  </div> 
                </div>

      </header>
      <main class="main">

      
           
       <form  action="choess_nafsy_box_pdf.php" method="get">
       <h1>   pation id  :  <h1>
       <input type="number" id="Patinte" name="pat_id" >
       <h1> chosse the test bloode   <h1>
       <form  action="bookses_pdf_acch.php" method="get">
       <input type="checkbox" id="test[]" value="1" > test  n1 <br/> 
       
       <input type="checkbox" id="test[]" value="2" > test  n2 <br/> 

       <input type="checkbox" id="test[]" value="3" > test n3 <br/> 

       <input type="checkbox" id="test[]" value="4" > test n4 <br/> 

       <input type="checkbox" id="test[]" value="5" > testn 5 <br/> 

       <input type="checkbox" id="test[]" value="6" > test n6 <br/> 
       
       <input type="checkbox" id="test[]" value="7" > test n7 <br/> 

       <input type="checkbox" id="test[]" value="8" > test 8 <br/> 

       <input type="checkbox" id="test[]" value="9" > test 9 <br/> 

       <input type="checkbox" id="test[]" value="10" > test 10 <br/> 

    
    <button type="submit"  aria-placeholder="Add" name="add_sess">
    


</form>





      </main>


      <footer class="footer">

 

      </footer>

      

</body>





</html>

