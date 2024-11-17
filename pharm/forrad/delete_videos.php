<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {

?>

<?php

if(isset($_GET['delete_videos'])){

$delete_id = $_GET['delete_videos'];

$delete_video = "delete from videos where video_id='$delete_id'";

$run_delete = mysqli_query($con,$delete_video);

if($run_delete){

echo "<script>alert('One video Has been deleted')</script>";

echo "<script>window.open('index.php?view_videos','_self')</script>";

}

}

?>

<?php } ?>