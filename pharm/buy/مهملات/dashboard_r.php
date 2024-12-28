
<?php 
include'templats/header.php';
include'templats/navbar.php';
include'../includes/db.php';
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


if(isset($_POST['submit'])){
    

    for ( $i=0 ; $i <= 0 ; $i++ ) {

$delegate = 'delegate'.[$i];
$name_med = 'name_med'.[$i];
$countity = 'countity'.[$i];
$expired_date = 'expired_date'.[$i];
$sale_price = 'sale_price'.[$i];
$buy_price = 'buy_price'.[$i];


$insert_med = "INSERT INTO buy_invpice(date_buy,delegate,name_med,countity,expired_date,sale_price,buy_price) values ('$date','$delegate','$name_med','$countity','$expired_date','$sale_price','$buy_price')";    


$run_video = mysqli_query($conn,$insert_med);
if($run_video){

echo "<script>alert('medicines has been inserted successfully')</script>";

echo "<script>window.open('index.php','_self')</script>";

}

}

    }


?>
 
 
<?php
 
    $r=mysqli_query($conn,"select id_med,name_med,opcity,parcode from mediciness");


?>




<!--

<div class="row medinsert"> 2 row Starts 

<div class="col-xs-4 col-sm-4 col-md-4"> col-lg-12 Starts 

<div class="panel panel-default">panel panel-default Starts 

<div class="panel-body"> panel-body Starts 

<form class="form-horizontal" method="post" enctype="multipart/form-data"> form-horizontal Starts 

<div class="form-group" >< form-group Starts

<label class="col-md-3 control-label" > ??? ?????? </label>
                
<input style="text-align: center;  " name="name_med" type="input" id="myInput" onkeyup="myFunction()" placeholder="Search for Patinte.." title="Type in a name">

<table  id="myTable">
  <tr class="header">
    <th style="width:1%;"> ??? ?????? </th>
    <th style="width:1%;"> ??? ??????  </th>
    <th style="width:1%;">?????? ???????</th>
    <th style="width:2%;">????? ????????</th>
    
   
  </tr>

  <?php 
  
while($row =mysqli_fetch_array($r)){
 
    echo  "<tr>";
    echo "<td>" .$row['id_med']."</td>";
        echo "<td>" .$row['name_med']."</td>";
    echo "<td>" .$row['opcity']."</td>";
        echo "<td>" .$row['parcode']."</td>";
    echo "</tr>";
    
    
    }

 
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
body{
    background-color: #525252;
}
.centered-form{
    margin-top: 100px;
}
 
.centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
    box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
}
</style>
<body>
  
    <div class="container">
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2">
                <div class="panel panel-info">
 
                    <div class="panel-heading text-center">
                   
                        <h1 class="panel-title">Add Content</h1>
                    </div>
 
                    <div class="panel-body">
                        <form role="form" method="post" action="">
                            
                            <div class="list_wrapper">  
                                <div class="row">
 
                                    <div class="col-xs-4 col-sm-4 col-md-4">
 
                                        <div class="form-group">
                                            ??? ????????
                                            <input name="data[0][name_med]" id="list[0][]" type="text" placeholder="????? ??????" class="form-control"/>
                                            
                                        </div>
                                    </div>
 
                                    <div class="col-xs-7 col-sm-7 col-md-7">
                                        <div class="form-group">
                                            ?????????
                                            <input name="data[0][countity]" autocomplete="off" id="list[0][]" type="number" placeholder="?????????" class="form-control"/>
                                        </div>
                                    </div> 
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            ??? ????????
                                            <input name="data[0][buy_price]" autocomplete="off" id="list[0][]" type="number" placeholder=" ??? ???????? " class="form-control"/>
                                        </div>
                                    </div> 
                                     <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            ??? ?????
                                            <input name="data[0][sale_price]" autocomplete="off" id="list[0][]" type="number" placeholder="??? ???????" class="form-control"/>
                                        </div>
                                    </div> 
                                     <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            ??????? ????????
                                            <input name="data[0][expired_date]" autocomplete="off" id="list[0][]" type="date" placeholder="??????? ????????" class="form-control"/>
                                        </div>
                                    </div> 
                                     <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            ?????????
                                            <input name="data[0][delegate]" autocomplete="off" id="list[0][]" type="text" placeholder="???????????" class="form-control"/>
                                        </div>
                                    </div> 
                                       <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                        <br>
                                             : ??????? ???????? 
                                            <?php echo $date; ?> 
                                        </div>
                                    </div> 

                                    
 
                                    <div class="col-xs-1 col-sm-1 col-md-1">
                                        <br>
                                       <button class="btn btn-primary list_add_button" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                            <input name="submit" type="submit" value="Submit" class="btn btn-info btn-block">
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
         var list_fieldHTML = '<div class="row"><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][name_med]" id="list['+x+'][]" type="text" placeholder="?????? ??????" class="form-control"/></div></div><div class="col-xs-7 col-sm-7 col-md-7"><div class="form-group"><input name="data[0][countity]" id="list['+x+'][]" type="number" placeholder="?????????" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][buy_price]" id="list['+x+'][]" type="number" placeholder="????? ????????" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][sale_price]" id="list['+x+'][]" type="number" placeholder="????? ???????" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][expired_date]" id="list['+x+'][]" type="date" placeholder="??????? ????????" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"><input name="data[0][delegate]" id="list['+x+'][]" type="text" placeholder=" ??????????" class="form-control"/></div></div><div class="col-xs-4 col-sm-4 col-md-4"><div class="form-group"> ????? ?????? <?php echo $date;?> </div></div><div  class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);" class="list_remove_button btn btn-danger">-</a></div></div>'; //New input field html 
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

