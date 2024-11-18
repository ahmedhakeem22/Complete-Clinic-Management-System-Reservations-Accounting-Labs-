<?php

require_once('tcpdf.php');


$pdf =new TCPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();

include '../includes/db.php';

 date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



$s = "INSERT INTO medical (pat_id,med_name,usee,countity,date_t) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$_POST['pat_id']."','".$_POST['med_name'][$i]."','".$_POST['usee'][$i]."','".$_POST['countity'][$i]."','".$date."'),";
}

$s = rtrim($s,",");
if (!$mysqli->query($s))
echo $mysqli->error;

         $pat_id=$_POST['pat_id'];

     $s=mysqli_query($conn,"select fname from patinte where pat_id=$pat_id");


     while($row =mysqli_fetch_array($s)){

        $row_fname=$row['fname'];

     }


        $chose=$_POST['usee'];

        $c =count($chose);
       
       
      
    


        $pdf =new TCPDF('p','mm','A4','UTF-8',false);
        $pdf-> AddPage();
        $pdf->SetFont('freeserif','',14);
 
 
 $pdf->Cell(50,8,' وصفـــة طبيـــة ',1,0,'C',0);


$pdf->Cell(40,8,'تاريخ ',1,0,'C',0);
$pdf->Cell(40,8,$date,1,1,'C',0);
$pdf->Cell(20,8,'',0,1,'C',0);
   
$pdf->SetFont('freeserif','',10);



$pdf->Cell(40,8,'رقم المريض',1,0,'C',0);
$pdf->Cell(40,8,'اسم المريض',1,0,'C',0);
$pdf->Cell(40,8,'اسم الدواء',1,0,'C',0);
$pdf->Cell(20,8,'الكمية',1,0,'C',0);
$pdf->Cell(40,8,'طريقة الاستخدام',1,1,'C',0);


 $pdf->Cell(40,8,$_POST['pat_id'],1,0,'C',0);
       $pdf->Cell(40,8,$row_fname,1,0,'C',0);


  



                     
 

for ($i = 0; $i < $_POST['numbers'] ; $i++) {

    $pdf->SetFont('freeserif','',10);

    $pdf->Cell(40,8,$_POST['med_name'][$i],1,0,'C',0);
    $pdf->Cell(20,8,$_POST['countity'][$i],1,0,'C',0);
    $pdf->Cell(40,8,$_POST['usee'][$i],1,1,'C',0);
    $pdf->Cell(80,8,'',0,0,'C',0);

}



 var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('sale.pdf', 'I');

?>