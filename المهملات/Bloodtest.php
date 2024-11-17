<html>
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Blood test </title>
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

      
           
                  <img src="img/Bloodtest.jpg" alt="image" width="100%" height="auto">




                  <table cellspacing="15" cellpadding="0" >
                    <tr>
                        <th> Invoice No. </th>
                        <th> Session No. </th>
                        <th> Patinte No. </th>
                        <th> Name of Patinte </th>
                        <th> Date  </th>
                        <th> Price </th>
                    </tr>
                    
                    <tr>
                        <td> <input type="number" id="invoice" >  </td>
                        <td> <input type="number" id="session" >  </td>
                        <td> <input type="number" id="Patinte" >  </td>
                        <td> <input type="text" id="name" >  </td>
                        <td> <input type="datetime" id="datesys" > </td>
                        <td> <input type="number" id="price" >  </td>
                        <td> <button type="submit" id="add" aria-placeholder="Add" > Book a Session </td>
                        <td> <button type="submit" id="deleate" aria-placeholder="deleate" > Delate </td>
                    
                    
                    
                    
                    
                    </tr>
                    </table>




      </main>


      <footer class="footer">

        <!--
<p id="demo"></p>

            <script>
            var d = new Date();
            document.getElementById("demo").innerHTML = d;
            </script>
        -->    
            

      </footer>

      

</body>





</html>

