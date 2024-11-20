<?php



if(!isset($_SESSION['a_name'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {




?>
<?php include 'includes/templates/header.php';
	include 'includes/templates/navbar.php';
	?>

      <main >
<div class="home1">
                  
                  <img src="includes/images/home.jpg" alt="image">
      </div>

      <div class="home">

                  <img src="includes/images/backimg.jpg" alt="" >
      </div>
      


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
<?php } ?>
<script src="includes/js/jquery-3.4.1.min.js"></script>
         <script src="includes/js/bootstrap.min.js"></script>
    <script src="includes/js/fontawesome.min.js"></script> 
        <script src="includes/js/myjs.js."></script> 

