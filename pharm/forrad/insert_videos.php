<?php

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {

?>
<!DOCTYPE html>

<html>

<head>

<title> Insert videos </title>


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'#video_desc,#video_features' });</script>

</head>

<body>

<div class="row"><!-- row Starts -->

<div class="col-lg-12"><!-- col-lg-12 Starts -->

<ol class="breadcrumb"><!-- breadcrumb Starts -->

<li class="active">

<i class="fa fa-dashboard"> </i> Dashboard / Insert videos

</li>

</ol><!-- breadcrumb Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- row Ends -->


<div class="row"><!-- 2 row Starts --> 

<div class="col-lg-12"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->

<div class="panel-heading"><!-- panel-heading Starts -->

<h3 class="panel-title">

<i class="fa fa-money fa-fw"></i> Insert videos

</h3>

</div><!-- panel-heading Ends -->

<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Title </label>

<div class="col-md-6" >

<input type="text" name="video_title" class="form-control" required >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Url </label>

<div class="col-md-6" >

<input type="text" name="video_url" class="form-control" required >

<br>

<p style="font-size:15px; font-weight:bold;">

video Url Example : navy-blue-t-shirt

</p>

</div>

</div><!-- form-group Ends -->




<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Category </label>

<div class="col-md-6" >

<select name="video_cat" class="form-control" >

<option> Select  a video Category </option>


<?php

$get_p_cats = "select * from product_categories";

$run_p_cats = mysqli_query($conn,$get_p_cats);

while ($row_p_cats=mysqli_fetch_array($run_p_cats)) {

$p_cat_id = $row_p_cats['p_cat_id'];

$p_cat_title = $row_p_cats['p_cat_title'];

echo "<option value='$p_cat_id' >$p_cat_title</option>";

}


?>


</select>

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > Category </label>

<div class="col-md-6" >


<select name="cat" class="form-control" >

<option> Select a Category </option>

<?php

$get_cat = "select * from categories ";

$run_cat = mysqli_query($conn,$get_cat);

while ($row_cat=mysqli_fetch_array($run_cat)) {

$cat_id = $row_cat['cat_id'];

$cat_title = $row_cat['cat_title'];

echo "<option value='$cat_id'>$cat_title</option>";

}

?>


</select>

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Image 1 </label>

<div class="col-md-6" >

<input type="file" name="video_img1" class="form-control" required >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" >html file</label>

<div class="col-md-6" >

<input type="file" name="video_img2" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Image 3 </label>

<div class="col-md-6" >

<input type="file" name="video_img3" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > التاريخ</label>

<div class="col-md-6" >

<input type="text" name="video_price" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" >تاريخ الضهور</label>

<div class="col-md-6" >

<input type="text" name="psp_price" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Keywords </label>

<div class="col-md-6" >

<input type="text" name="video_keywords" class="form-control" required >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Tabs </label>

<div class="col-md-6" >

<ul class="nav nav-tabs"><!-- nav nav-tabs Starts -->

<li class="active">

<a data-toggle="tab" href="#description"> video Description </a>

</li>

<li>

<a data-toggle="tab" href="#features"> video Features </a>

</li>

<li>

<a data-toggle="tab" href="#video"> Sounds And Videos </a>

</li>

</ul><!-- nav nav-tabs Ends -->

<div class="tab-content"><!-- tab-content Starts -->

<div id="description" class="tab-pane fade in active"><!-- description tab-pane fade in active Starts -->

<br>

<textarea name="video_desc" class="form-control" rows="15" id="video_desc">


</textarea>

</div><!-- description tab-pane fade in active Ends -->


<div id="features" class="tab-pane fade in"><!-- features tab-pane fade in Starts -->

<br>

<textarea name="video_features" class="form-control" rows="15" id="video_features">


</textarea>

</div><!-- features tab-pane fade in Ends -->


<div id="video" class="tab-pane fade in"><!-- video tab-pane fade in Starts -->

<br>

<textarea name="video_video" class="form-control" rows="15">


</textarea>

</div><!-- video tab-pane fade in Ends -->


</div><!-- tab-content Ends -->

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > video Label </label>

<div class="col-md-6" >

<input type="text" name="video_label" class="form-control" required >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" ></label>

<div class="col-md-6" >

<input type="submit" name="submit" value="Insert video" class="btn btn-primary form-control" >

</div>

</div><!-- form-group Ends -->

</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends --> 




</body>

</html>

<?php

if(isset($_POST['submit'])){

$video_title = $_POST['video_title'];
$video_cat = $_POST['video_cat'];
$cat = $_POST['cat'];

$video_price = $_POST['video_price'];
$video_desc = $_POST['video_desc'];
$video_keywords = $_POST['video_keywords'];

$psp_price = $_POST['psp_price'];

$video_label = $_POST['video_label'];

$video_url = $_POST['video_url'];

$video_features = $_POST['video_features'];

$video_video = $_POST['video_video'];

$status = "video";

$video_img1 = $_FILES['video_img1']['name'];
$video_img2 = $_FILES['video_img2']['name'];
$video_img3 = $_FILES['video_img3']['name'];

$temp_name1 = $_FILES['video_img1']['tmp_name'];
$temp_name2 = $_FILES['video_img2']['tmp_name'];
$temp_name3 = $_FILES['video_img3']['tmp_name'];

move_uploaded_file($temp_name1,"video_images/$video_img1");
move_uploaded_file($temp_name2,"../video/video/$video_img2");
move_uploaded_file($temp_name3,"video_images/$video_img3");

$insert_video = "insert into videos (p_cat_id,cat_id,date,video_title,video_url,video_img1,video_img2,video_img3,video_price,video_psp_price,video_desc,video_features,video_video,video_keywords,video_label,status) values ('$video_cat','$cat',NOW(),'$video_title','$video_url','$video_img1','$video_img2','$video_img3','$video_price','$psp_price','$video_desc','$video_features','$video_video','$video_keywords','$video_label','$status')";

$run_video = mysqli_query($conn,$insert_video);

if($run_video){

echo "<script>alert('video has been inserted successfully')</script>";

echo "<script>window.open('index.php?view_videos','_self')</script>";

}

}

?>

<?php } ?>
