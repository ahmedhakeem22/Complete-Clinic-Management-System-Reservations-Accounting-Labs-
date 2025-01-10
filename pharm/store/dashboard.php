<?php



if(!isset($_SESSION['p_name'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {




?>
<?php 

include 'templats/header.php';
	include 'templats/navbar.php';
  include '../../includes/db.php';
	?>

      
      <main>

         




      <main >
<div class="home1">
                  
                  <img src="home.jpg" alt="image">
      </div>

      <div class="home">

                  <img src="backimg.jpg" alt="" >
      </div>
      


      </main>

      <footer>

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
<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 

