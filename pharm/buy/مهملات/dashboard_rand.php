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

  
$num_rand=0;
  if(isset($_GET['submit_invo'])){
      $num_rand=rand(100,100000);
      echo $num_rand;
      
    $decrip="شراء";
    $insert_med_inv = "INSERT INTO invoice_pharm(date_invo,num_rand,decrip) values ('$date','$num_rand','$decrip')";    


    $run_video = mysqli_query($con,$insert_med_inv);
    
    if($run_video){
    
    echo "<script>alert('medicines has been inserted successfully')</script>";
    
    echo "<script>window.open('index.php','_self')</script>";
  }
  }
  if(isset($_GET['add'])){


    $id_inv=mysqli_query($con,"select id from invoice_pharm wher num_rand=$num_rand and date_invo='$date' ");
$row =mysqli_fetch_array($id_inv);
echo $row['id'];
    echo 'najm';
  }
/*

    $delegate = $_GET['delegate'];
    
    $name_med = $_GET['name_med'];
    
    $countity = $_GET['countity'];
    
    
    $expired_date = $_GET['expired_date'];
    
    
    $sale_price = $_GET['sale_price'];
    $buy_price = $_GET['buy_price'];
  
    
    $insert_med = "INSERT INTO invoice_pharm_buy(date_buy,name_delegate,exp_date,price_buy,price_sale) values ('$date','$delegate','$expired_date','$buy_price','$sale_price')";    
    
    
    $run_video = mysqli_query($con,$insert_med);
    
    if($run_video){
    
    echo "<script>alert('medicines has been inserted successfully')</script>";
    
    echo "<script>window.open('index.php','_self')</script>";
    
    }


if(isset($_POST['submit'])){
    include'includes/db.php';
    $i=0;

    foreach ($_POST['data'] as $val) {

$delegate = $val['delegate'];
$name_med = $val['name_med'];
$countity = $val['countity'];
$expired_date = $val['expired_date'];
$sale_price = $val['sale_price'];
$buy_price = $val['buy_price'];


$insert_med = "INSERT INTO buy_invpice(date_buy,delegate,name_med,countity,expired_date,sale_price,buy_price) values ('$date','$delegate','$name_med','$countity','$expired_date','$sale_price','$buy_price')";    


$run_video = mysqli_query($con,$insert_med);
if($run_video){

echo "<script>alert('medicines has been inserted successfully')</script>";

echo "<script>window.open('index.php','_self')</script>";

}

}

    }
*/

?>
 




<!--

<div class="row medinsert"> 2 row Starts 

<div class="col-xs-4 col-sm-4 col-md-4"> col-lg-12 Starts 

<div class="panel panel-default">panel panel-default Starts 

<div class="panel-body"> panel-body Starts 

<form class="form-horizontal" method="post" enctype="multipart/form-data"> form-horizontal Starts 

<div class="form-group" >< form-group Starts

<label class="col-md-3 control-label" > اسم العلاج </label>
                
<input style="text-align: center;  " name="name_med" type="input" id="myInput" onkeyup="myFunction()" placeholder="Search for Patinte.." title="Type in a name">

<table  id="myTable">
  <tr class="header">
    <th style="width:1%;"> رقم العلاج </th>
    <th style="width:1%;"> اسم العلاج  </th>
    <th style="width:1%;">الكمية بالوحدة</th>
    <th style="width:2%;">الرقم التسلسلي</th>
    
   
  </tr>

  <?php 
  /*
while($row =mysqli_fetch_array($r)){
 
    echo  "<tr>";
    echo "<td>" .$row['id_med']."</td>";
        echo "<td>" .$row['name_med']."</td>";
    echo "<td>" .$row['opcity']."</td>";
        echo "<td>" .$row['parcode']."</td>";
    echo "</tr>";
    
    
    }
*/
 
?>
  
</table>
-->


         <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>       




      <!--Jquery Link-->
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
 
 <!-- Bootstrap Styling-->
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
 
 
 <!-- custom stylesheet-->
 <link rel="stylesheet" type="text/css" href="dynamic.css" />
 
 <!-- custom javascript-->
 <script src="dynamic.js"></script>
 
</head>
 
<style>

.centered-form{
    margin-top: 100px;
}
 
.centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
    box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
}
</style>



<!-- # select -->

<?php 
/*
    $r=mysqli_query($con,"select id_med,name_med,type,parcode,opcity from mediciness");

*/

?>





<form method="get"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<input name="submit_invo" type="submit" value="انشاء فاتورة" class="btn btn-info btn-block"/>

</form>

<form method="get"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input name="add" type="submit" value="add" class="btn btn-info btn-block"/>



 <div class="container">
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2">
                <div class="panel panel-info">
 
                    <div class="panel-heading text-center">
                   
                        <h1 class="panel-title"> medicines </h1>
                    </div>
 
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                            
                            <div class="list_wrapper">  
                                <div class="row">
 


                                    <div class="col-xs-7 col-sm-7 col-md-7">
 
                                        <div class="form-group">


<table id="myTable" style="width:100%;">

  <tr class="header">
    <th style="width:10%; "> رقم الدواء </th>
        <th style="width:10%;  "> اســم الدواء  </th>
    <th style="width:10%;  "> نــوع الدواء </th>
        <th style="width:10%;  "> الرقم التسلسلي  </th>
                <th style="width:10%;  "> الكميـــة </th>
  </tr>

                                            <?php
                                             /*
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
    echo "<td>" .$row['id_med']."</td>";
    echo "<td>" .$row['name_med']."</td>";  
    echo "<td>" .$row['type']."</td>";  
    echo "<td>" .$row['parcode']."</td>";  
    echo "<td>" .$row['opcity']."</td>";  

    echo "</tr>";
}
*/
?>
  </table>                                          
                                        </div>
                                    </div>

 </div>
  </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 </form>
 </div>
 </div>


<body>
  
    <div class="container"/>
        <div class="row centered-form"/>
            <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2"/>
                <div class="panel panel-info"/>
 
                    <div class="panel-heading text-center"/>
                   
                        <h1 class="panel-title"> Buy </h1>
                    </div>
 
                    <div class="panel-body"/>
                        <form role="form" method="post" action=""/>
                            
                            <div class="list_wrapper"/>  
                                <div class="row"/>
 
                                    <div class="col-xs-4 col-sm-4 col-md-4"/>
 
                                        <div class="form-group"/>
                                            اسم العــلاج
                                            <input name="data[0][name_med]" id="list[0][]" type="text" placeholder="اســم العلاج" class="form-control"/>
                                            
                                        </div>
                                    </div>
 
                                    <div class="col-xs-7 col-sm-7 col-md-7"/>
                                        <div class="form-group"/>
                                            الكميـــة
                                            <input name="data[0][countity]" autocomplete="off" id="list[0][]" type="number" placeholder="الكميـــة" class="form-control"/>
                                        </div>
                                    </div> 
                                    <div class="col-xs-4 col-sm-4 col-md-4"/>
                                        <div class="form-group">
                                            سعر الشــراء
                                            <input name="data[0][buy_price]" autocomplete="off" id="list[0][]" type="number" placeholder=" سعر الشــراء " class="form-control"/>
                                        </div>
                                    </div> 
                                     <div class="col-xs-4 col-sm-4 col-md-4"/>
                                        <div class="form-group"/>
                                            سعر البيع
                                            <input name="data[0][sale_price]" autocomplete="off" id="list[0][]" type="number" placeholder="سعر البيــع" class="form-control"/>
                                        </div>
                                    </div> 
                                     <div class="col-xs-4 col-sm-4 col-md-4"/>
                                        <div class="form-group"/>
                                            تاريــخ الانتهاء
                                            <input name="data[0][expired_date]" autocomplete="off" id="list[0][]" type="date" placeholder="تاريــخ الانتهاء" class="form-control"/>
                                        </div>
                                    </div> 
                                     <div class="col-xs-4 col-sm-4 col-md-4"/>
                                        <div class="form-group"/>
                                            المنــدوب
                                            <input name="data[0][delegate]" autocomplete="off" id="list[0][]" type="text" placeholder="المنــــدوب" class="form-control"/>
                                        </div>
                                    </div> 
                                       <div class="col-xs-4 col-sm-4 col-md-4"/>
                                        <div class="form-group"/>
                                        <br>
                                             : تاريــخ الشــراء 
                                            <?php // echo $date; ?> 
                                        </div>
                                    </div> 

                                    
 
                                    <div class="col-xs-1 col-sm-1 col-md-1">
                                        <br>
                                       <button class="btn btn-primary list_add_button" type="button"/>+</button>
                                    </div>
                                </div>
                            </div>
                            <input name="submit" type="submit_add" value="Submit" class="btn btn-info btn-block"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function()
    {
 var x = 0; //Initial field counter
 var list_maxField = 10; //Input fields increment limitation
 
        //Once add button is clicked
 $('.list_add_button').click(function()
     {
     //Check maximum number of input fields
     if(x < list_maxField){ 
         x++; //Increment field counter
         var list_fieldHTML = '<div class="row"><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][name_med]" id="list['+x+'][]" type="text" placeholder="اســـم العلاج" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="data[0][countity]" id="list['+x+'][]" type="number" placeholder="الكميـــة" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][buy_price]" id="list['+x+'][]" type="number" placeholder="سعــر الشــراء" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][sale_price]" id="list['+x+'][]" type="number" placeholder="سعــر البيــع" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][expired_date]" id="list['+x+'][]" type="date" placeholder="تاريــخ الانتهاء" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][delegate]" id="list['+x+'][]" type="text" placeholder=" المنـــدوب" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"> تاريخ الشراء <?php echo $date;?> </div></div><div  class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);"  name="submit" class="list_remove_button btn btn-danger">-</a></div></div>'; //New input field html 
         $('.list_wrapper').append(list_fieldHTML); //Add field html
     }
        });
    
        //Once remove button is clicked
        $('.list_wrapper').on('click', '.list_remove_button', function()
        {
           $(this).closest('div.row').remove(); //Remove field html
           x--; //Decrement field counter
        });
});
</script>









</form>

</body>

</html>


<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 

