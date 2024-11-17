<?php 

include'templats/header.php';
include'templats/navbar.php';
include'includes/db.php';
?>
<?php

date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
$conntant="";

if(isset($_GET['submit'])){


$delegate = $_GET['delegate'];

$name_med = $_GET['name_med'];

$countity = $_GET['countity'];


$expired_date = $_GET['expired_date'];


$sale_price = $_GET['sale_price'];
$buy_price = $_GET['buy_price'];
$conntant=' \r \n '.$conntant."المندوب ".$delegate." سعر الشراء ".$buy_price."سعر البيع ".$sale_price." اسم العلاج".$_GET['name_med'];

$insert_med = "INSERT INTO invoice_pharm_buy(buy_date,name_delegate,exp_date,price_buy,price_sale) values ('$date','$delegate','$expired_date','$buy_price','$sale_price')";    


$run_video = mysqli_query($conn,$insert_med);

if($run_video){

echo "<script>alert('medicines has been inserted successfully')</script>";

echo "<script>window.open('index.php','_self')</script>";

}

if(isset($_GET['submit_prn'])){
    $decrip="شراء";
    $insert_med_inv = "INSERT INTO invoice_pharm(date_invo,typeinvoice,decrip) values ('$date','$conntant','$decrip')";    


    $run_video = mysqli_query($conn,$insert_med_inv);
    
    if($run_video){
    
    echo "<script>alert('medicines has been inserted successfully')</script>";
    
    echo "<script>window.open('index.php','_self')</script>";
    
    }

}
}

?>

