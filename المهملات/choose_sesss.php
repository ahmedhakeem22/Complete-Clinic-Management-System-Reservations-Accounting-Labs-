
<?php 



//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);


mysqli_select_db($conn,"najmdb");

?>

<!DOCTYPE html>
<html>
<head>
    <title> Psychological examination  </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body> 


    <main class="main">
    <form  action="report_ses_choen_pdf.php" method="get">


          <select name="ses_id">
<?php
$query=mysqli_query($conn,"select * from session");
while($array_ses_id=mysqli_fetch_array($query)){
echo"  <option value='".$array_ses_id['id_session']."'> ".$array_ses_id['id_session']." </option>  ";
}
/*
$query=mysqli_query($conn,"select * from session
where pat_id='".$_GET['pat_id']."'");
*/
?>
</select>

<input type="submit" value="Submit" name="Submit_pation">
   </form>


   </main>
            
           <footer class="footer">
            

           </footer> 
        
</body>

</html>

