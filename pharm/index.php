<?php

session_start();

include '../includes/db.php';

if(!isset($_SESSION['p_name'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {

?>

<?php

$admin_session = $_SESSION['p_name'];

$get_admin = "select * from ph_admin  where p_name='$admin_session'";

$run_admin = mysqli_query($con,$get_admin);

$row_admin = mysqli_fetch_array($run_admin);

$admin_id = $row_admin['id'];

$admin_name = $row_admin['p_pass'];

$admin_email = $row_admin['p_name'];


?>


<!DOCTYPE html>
<html>

<head>

<title>Admin Panel</title>

<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">

<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" >
<link rel="shortcut icon" href="//cdn.shopify.com/s/files/1/2484/9148/files/SDQSDSQ_32x32.png?v=1511436147" type="image/png">

</head>

<body>



<?php include("dashboard.php");  ?>
<div id="page-wrapper"><!-- page-wrapper Starts -->

<div class="container-fluid"><!-- container-fluid Starts -->

<?php

if(isset($_GET['dashboard'])){

include("dashboard.php");

}
	if(isset($_GET['index'])){

include("index.php");

}


?>

</div><!-- container-fluid Ends -->

</div><!-- page-wrapper Ends -->


<script src="js/jquery.min.js"></script>

<script src="js/bootstrap.min.js"></script>


</body>


</html>

<?php } ?>