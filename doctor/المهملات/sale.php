<?php
require_once __DIR__ . '/../vendor/autoload.php';



$pdf =new TCPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();

include '../includes/db.php';

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

$mysqli = new mysqli($servername, $username, $password ,$dbname);

 date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }




if ($mysqli->connect_errno)
    die("Connection failed: " .$mysqli->connect_error);
 

$s = "INSERT INTO medical (pat_id,med_name,usee,countity,date_t) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$_POST['pat_id']."','".$_POST['med_name'][$i]."','".$_POST['usee'][$i]."','".$_POST['countity'][$i]."','".$date."'),";
}

  


 
$s = rtrim($s,",");
if (!$mysqli->query($s))
echo $mysqli->error;

$pat_id=$_POST['pat_id'];
$med_name=$_POST['med_name'];

     $s=mysqli_query($conn,"select fname from patinte where pat_id = $pat_id");


     while($row =mysqli_fetch_array($s)){

        $row_fname=$row['fname'];

     }

$pdf->SetFont('freeserif','',14);
$pdf->Cell(50,8,' وصفـــة طبيـــة ',1,0,'C',0);


$pdf->Cell(40,8,'تاريخ ',1,0,'C',0);
$pdf->Cell(40,8,$date,1,1,'C',0);
$pdf->Cell(20,8,'',0,1,'C',0);
   
$pdf->SetFont('freeserif','',14);



$pdf->Cell(40,8,'رقم المريض',1,0,'C',0);
 $pdf->Cell(40,8,$_POST['pat_id'],1,0,'C',0);

$pdf->Cell(40,8,'اسم المريض',1,0,'C',0);
       $pdf->Cell(40,8,$row_fname,1,1,'C',0);

        $pdf->Ln(10);

$pdf->Cell(60,8,'اســـم الـــدواء',1,0,'C',0);
$pdf->Cell(20,8,'الكميـــة',1,0,'C',0);
$pdf->Cell(80,8,'طريقـــة الاستخـــدام',1,1,'C',0);

for ($i = 0; $i < $_POST['numbers'] ; $i++) {

    $pdf->Cell(60,8,$_POST['med_name'][$i],0,0,'C',0);
    $pdf->Cell(20,8,$_POST['countity'][$i],0,0,'C',0);
    $pdf->MultiCell(62,8,$_POST['usee'][$i],"\n",1,'',1);

$pdf->Ln(5);
}





             

        

    $pdf->SetFont('freeserif','',14);


   /* 
           for($j=1;$j<$c;$j++){

if($i==0 && $med_name==0){

            if($chose[1]){
    $pdf->Cell(40,8,'ONE ',1,1,'C',0);
        }
        
         if( $chose[2]){
                  $pdf->Cell(60,8,'',1,0,'C',0);
    $pdf->Cell(40,8,' TOW',1,1,'C',0);


        }

               if($chose[3]){
                  $pdf->Cell(60,8,'',1,0,'C',0);
    $pdf->Cell(40,8,' THREE',1,1,'C',0);


        }

}

if ($i==1 && $med_name==1) {

 if($chose==1){
    $pdf->Cell(40,8,'1',1,1,'C',0);


        }

if($chose==2){
   $pdf->Cell(40,8,'2',1,1,'C',0);
       }

if($chose==3){
   $pdf->Cell(40,8,'3',1,1,'C',0);
       }

}
        }
}*/
    


 
         var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('sale.pdf', 'I');


?>