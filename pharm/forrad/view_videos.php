<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {

?>


<div class="row"><!--  1 row Starts -->

<div class="col-lg-12" ><!-- col-lg-12 Starts -->

<ol class="breadcrumb" ><!-- breadcrumb Starts -->

<li class="active" >

<i class="fa fa-dashboard"></i> Dashboard / View videos

</li>

</ol><!-- breadcrumb Ends -->

</div><!-- col-lg-12 Ends -->

</div><!--  1 row Ends -->

<div class="row" ><!-- 2 row Starts -->

<div class="col-lg-12" ><!-- col-lg-12 Starts -->

<div class="panel panel-default" ><!-- panel panel-default Starts -->

<div class="panel-heading" ><!-- panel-heading Starts -->

<h3 class="panel-title" ><!-- panel-title Starts -->

<i class="fa fa-money fa-fw" ></i> View videos

</h3><!-- panel-title Ends -->


</div><!-- panel-heading Ends -->

<div class="panel-body" ><!-- panel-body Starts -->

<div class="table-responsive" ><!-- table-responsive Starts -->

<table class="table table-bordered table-hover table-striped" ><!-- table table-bordered table-hover table-striped Starts -->

<thead>

<tr>
<th>video ID</th>
<th>video Title</th>
<th>video Image</th>
<th>video Price</th>
<th>video sold</th>
<th>video Keywords</th>
<th>video Date</th>
<th>video Delete</th>
<th>video Edit</th>



</tr>

</thead>

<tbody>

<?php

$i = 0;

$get_video = "select * from videos where status='video'";

$run_video = mysqli_query($con,$get_video);

while($row_video=mysqli_fetch_array($run_video)){

$video_id = $row_video['video_id'];

$video_title = $row_video['video_title'];

$video_image = $row_video['video_img1'];

$video_price = $row_video['video_price'];

$video_keywords = $row_video['video_keywords'];

$video_date = $row_video['date'];

$i++;

?>

<tr>

<td><?php echo $i; ?></td>

<td><?php echo $video_title; ?></td>

<td><img src="video_images/<?php echo $video_image; ?>" width="60" height="60"></td>

<td>update.. <?php echo $video_price; ?></td>

<td>
<?php

$get_sold = "select * from pending_orders where video_id='$video_id'";
$run_sold = mysqli_query($con,$get_video);
$count = mysqli_num_rows($run_video);
echo $count;
?>
</td>

<td> <?php echo $video_keywords; ?> </td>

<td><?php echo $video_date; ?></td>

<td>

<a href="index.php?delete_videos=<?php echo $video_id; ?>">

<i class="fa fa-trash-o"> </i> Delete

</a>

</td>

<td>

<a href="index.php?edit_videos=<?php echo $video_id; ?>">

<i class="fa fa-pencil"> </i> Edit

</a>

</td>

</tr>

<?php } ?>


</tbody>


</table><!-- table table-bordered table-hover table-striped Ends -->

</div><!-- table-responsive Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends -->




<?php } ?>