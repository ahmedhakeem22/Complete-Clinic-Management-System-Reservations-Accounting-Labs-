<?php

session_start();

include '../includes/db.php';

?>
<!DOCTYPE HTML>
<html>

<head>

<title>Admin Login</title>

<link rel="stylesheet" href="css/bootstrap.min.css" >

<link rel="stylesheet" href="login.css" >

</head>

<body>

<div class="container" ><!-- container Starts -->

<form class="form-login" action="" method="post" ><!-- form-login Starts -->

<h2 class="form-login-heading" >Admin Login</h2>

<input type="text" class="form-control" name="a_name" placeholder="Email Address" required >

<input type="password" class="form-control" name="u_pass" placeholder="Password" required >

<button class="btn btn-lg btn-primary btn-block" type="submit" name="blood_admin" >

Log in

</button>


</form><!-- form-login Ends -->

</div><!-- container Ends -->



</body>

</html>

<?php

if(isset($_POST['a_name'])){

$admin_email = mysqli_real_escape_string($conn,$_POST['a_name']);

$admin_pass = mysqli_real_escape_string($conn,$_POST['u_pass']);

$get_admin = "select * from admin where a_name='$admin_email' AND u_pass='$admin_pass'";

$run_admin = mysqli_query($conn,$get_admin);

$count = mysqli_num_rows($run_admin);

if($count==1){

$_SESSION['a_name']=$admin_email;

echo "<script>alert('You are Logged in into admin panel')</script>";

echo "<script>window.open('index.php','_self')</script>";

}
else {

echo "<script>alert('Email or Password is Wrong')</script>";

}

}

?>