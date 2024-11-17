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
       
      <main>

      
           
                  <img src="booksession.jpg" alt="image" width="100%" height="auto">

<form  action="book_sess_print_ach_pdf.php" method="get">

<table cellspacing="15" cellpadding="0" >
<tr>
 
    <th> Patinte No. </th>
 
    <td> <input  type="number" id="Patinte" name="pat_id" title="Patinte NO." placeholder="">  </input>  </td>
    
    <td> <button type="submit" id="add" aria-placeholder="Add" name="add_sess"> Book a Session </button> </td>
    





</tr>
</form>
</table>




      </main>


      <footer>


      </footer>

      

</body>





</html>

