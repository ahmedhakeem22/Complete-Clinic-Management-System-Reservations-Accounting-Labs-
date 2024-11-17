<?php 




require_once('../TCPDF-master/tcpdf.php');



    
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    

  $pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);

  $pdf->AddPage();
  
  
  $pdf->SetFont('freeserif','',12);

        $chose=$_GET['test'];

        $c =count($chose);
       

        $pat_id=$_GET['pat_id'];
        

        $pdf->Image('img_back_pdf.png',10,10,-300);
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(27);
        
        
        
        
        $pdf->Cell(100,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',1,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
        $pdf->Ln();
        
        
        $pdf->Cell(30,8,'PATIENTE id:',1,0,'C',0);
    
        
        
        
        
            $pdf->Cell(30,8,$_GET['pat_id'],'B',0,'C',0);
        
        
        
        
       
        

        $pdf->Cell(50,8,' chossen tests  ',1,1,'C',0);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
 
    $pdf->Cell(50,8,' test (1) / 1500 ',1,1,'C',0);
}

if($chose[$i]==2){
  
    $pdf->Cell(50,8,' test (2) /500',1,1,'C',0);
}

if($chose[$i]==3){
   
    $pdf->Cell(50,8,' test (3) /500',1,1,'C',0);
}

if($chose[$i]==4){
   
    $pdf->Cell(50,8,' test (4) /1000',1,1,'C',0);
}

if($chose[$i]==5){
  
    $pdf->Cell(50,8,' test (5) /600',1,1,'C',0);
}

if($chose[$i]==6){
    
    $pdf->Cell(50,8,' test (6) /400',1,1,'C',0);
}

if($chose[$i]==7){
   
    $pdf->Cell(50,8,' test (7) /400',1,1,'C',0);
}

if($chose[$i]==8){
  
    $pdf->Cell(50,8,' test (8) /1500 ',1,1,'C',0);
}

if($chose[$i]==9){
  
    $pdf->Cell(50,8,' test (9) /1500',1,1,'C',0);
}

if($chose[$i]==10){
   
    $pdf->Cell(50,8,' test (10) /1000',1,1,'C',0);
}

        }
          
          
          
        
        ////////////////////////////////////////////
        
        
        
        
        


  


$pdf->Output();


?>