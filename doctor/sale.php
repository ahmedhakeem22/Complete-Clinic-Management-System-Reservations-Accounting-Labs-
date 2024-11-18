<?php

require_once('../TCPDF-master/tcpdf.php');


$pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();
        $pdf->Ln(42);
          $pdf->SetFillColor(165, 225, 166);

        $pdf->Image('img_back_pdf.png',10,10,-300);

  include '../includes/db.php';


 date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }




$pat_id=$_POST['pat_id'];
$med_name=$_POST['med_name'];








     $s=mysqli_query($conn,"select fname from patinte where pat_id = $pat_id");


     while($row =mysqli_fetch_array($s)){

        $row_fname=$row['fname'];

     }

$pdf->SetFont('dejavusans','',22);
          $pdf->Cell(55,8,'',0,0,'C',0);
$pdf->Cell(80,12,'وصفـــة طبيـــة',1,1,'C','true');
$pdf->SetFont('dejavusans','',12);
$pdf->Cell(20,8,'',0,1,'C',0);
  $pdf->SetFillColor(165, 225, 166);
  $pdf->Cell(5,8,'',0,0,'C',0);

$pdf->Cell(25,8,'رقم المريض',1,0,'C','true');
 $pdf->Cell(15,8,$_POST['pat_id'],1,0,'C','true');

$pdf->Cell(25,8,'اسم المريض',1,0,'C','true');
       $pdf->Cell(60,8,$row_fname,1,0,'C','true');

$pdf->Cell(15,8,'تاريخ',1,0,'C','true');
$pdf->Cell(35,8,$date,1,1,'C','true');
        $pdf->Ln(10);
/*
$a = mysqli_query($conn, " select usee from medical where pat_id=$pat_id ");

while ($row = mysqli_fetch_array($a)){
    
     $row_usee=$row['usee'];


}*/
          $pdf->Cell(28,8,'',0,0,'C',0);
            $pdf->SetFillColor(171, 209, 254);
$pdf->Cell(80,8,'اســـم الـــدواء',1,0,'C','true');
$pdf->Cell(50,8,'الكميـــة',1,1,'C','true');

$s = "INSERT INTO medical (pat_id,med_name,usee,countity,date_t) VALUES ";

for ($j = 0; $j < $_POST['numbers'] ; $j++) {
          $pdf->Cell(28,8,'',0,0,'C',0);
                        $pdf->SetFillColor(177, 232, 178);

    $pdf->Cell(80,8,$_POST['med_name'][$j],1,0,'C','true');
    $pdf->Cell(50,8,$_POST['countity'][$j],1,1,'C','true');

  $pdf->SetFillColor(211, 247, 212);

$medcal_skills='';
$chose=0;
$chose=$_POST['fr_skills'];
$c =count($chose[$j]);

for($i=0;$i<$c;$i++){
    $num_i=1;
                      $pdf->Cell(28,8,'',0,0,'C',0);
    if($chose[$j][$i]==1){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبـة قبـل الفطــور';
        $pdf->Cell(80,8,'حبـة قبـل الفطــور',1,1,'C');
    }
    
    if($chose[$j][$i]==2){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نـــص حبـة قبـل الفطــور';
        $pdf->Cell(80,8,'نـــص حبـة قبـل الفطــور',1,1,'C');
    }
    
    if($chose[$j][$i]==3){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبة بعد الفطور';
        $pdf->Cell(80,8,'حبة بعد الفطور',1,1,'C');
    }
    
    if($chose[$j][$i]==4){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نــص حبة بعد الفطور';
        $pdf->Cell(80,8,'نــص حبة بعد الفطور',1,1,'C');
    }
    
    if($chose[$j][$i]==5){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبــة قبل الغداء';
        $pdf->Cell(80,8,'حبة قبل الغداء',1,1,'C');
    }
    
    if($chose[$j][$i]==6){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبة بعد الغداء';
        $pdf->Cell(80,8,'حبة بعد الغداء',1,1,'C');
    }
    
    if($chose[$j][$i]==7){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نـص حبة بعد الغداء';
        $pdf->Cell(80,8,'نص حبة بعد الغداء',1,1,'C');
    }
    
    if($chose[$j][$i]==8){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نـص حبة قبل الغداء';
        $pdf->Cell(80,8,'نص حبة قبل الغداء',1,1,'C');
    }
    
    if($chose[$j][$i]==9){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبة قبل العشاء';
        $pdf->Cell(80,8,'حبة قبل العشاء',1,1,'C');
    }
    
    if($chose[$j][$i]==10){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نـص حبة قبل العشاء';
        $pdf->Cell(80,8,'نص حبة قبل العشاء',1,1,'C');
    }
    
    if($chose[$j][$i]==11){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبــة بعد العشاء';
        $pdf->Cell(80,8,'حبة بعد العشاء',1,1,'C');
    }
    
    if($chose[$j][$i]==12){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نـص حبة بعد العشاء';
        $pdf->Cell(80,8,'نص حبة بعد العشاء',1,1,'C');
    }
    
    if($chose[$j][$i]==13){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبــة قبل النوم';
        $pdf->Cell(80,8,'حبة قبل النوم',1,1,'C');
    }
    
    if($chose[$j][$i]==14){

        $medcal_skills=$medcal_skills.'  '.$num_i.'نـص حبة قبل النوم';
        $pdf->Cell(80,8,'نص حبة قبل النوم',1,1,'C');
    }
    
    if($chose[$j][$i]==15){

        $medcal_skills=$medcal_skills.'  '.$num_i.'حبـة كل اسبوع';
        $pdf->Cell(80,8,'حبة كل اسبوع',1,1,'C');
    }
    
    if($chose[$j][$i]==16){

        $medcal_skills=$medcal_skills.'  '.$num_i.'مرتين في الاسبوع';
        $pdf->Cell(80,8,'مرتين في الاسبوع',1,1,'C');
    }
    
    $num_i++;
            }


           
 $s .="('".$_POST['pat_id']."','".$_POST['med_name'][$j]."','".$medcal_skills."','".$_POST['countity'][$j]."','".$date."'),";

  


 
            


}


            $s = rtrim($s,",");
            if (!$mysqli->query($s))
            echo $mysqli->error;



             

        

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