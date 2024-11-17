
<?php 


require_once('TCPDF-master/tcpdf.php');




//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);



    mysqli_select_db($conn,"najmdb");

    
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    
if(isset($_GET['pat_id'])){
       $fname=$_GET['fname'];

    if(isset($_GET['test'])){


        $chose=$_GET['test'];

        $c =count($chose);
       
       
        $pat_id=$_GET['pat_id'];
    

$s=mysqli_query($conn,"select fname from patinte where pat_id = $pat_id");


     while($row =mysqli_fetch_array($s)){

        $row_fname=$row['fname'];

     }

        $pdf =new TCPDF('p','mm','A4','UTF-8',false);
        $pdf-> AddPage();
        $pdf->SetFont('freeserif','',14);
 
        
        $pdf->Image('img_back_pdf.png',10,10,-300);
        
        
        $pdf->Ln(27);
        
    
        $pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,0,1,'C',0);
                        $pdf->Ln();


$pdf->Cell(300,8,'الدكتور : عمرو أحمـــد الخـــرساني ',0,0,'C',0);

                        $pdf->Ln();

                $pdf->Cell(5,8,'',0,0,'C',0);

        $pdf->Cell(25,8,'Patinte ID :',1,0,'C',0);
            $pdf->Cell(15,8,$_GET['pat_id'],1,0,'C',0);
                $pdf->Cell(35,8,'Patinte Name :',1,0,'C',0);
                            $pdf->Cell(50,8,$row_fname,1,0,'C',0);


        $pdf->Cell(50,8,' اختبارات الدم المختاره',1,1,'C',0);

        
        for($i=0;$i<$c;$i++){

if($chose[$i]==1){
        $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'C.B.C',1,1,'C',0);
}

if($chose[$i]==101){
        $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'HB',1,1,'C',0);
}
if($chose[$i]==102){
        $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'ًWBC',1,1,'C',0);
}

if($chose[$i]==2){
        $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Platelats',1,1,'C',0);
}

if($chose[$i]==3){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'ESR ',1,1,'C',0);
}

if($chose[$i]==4){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Malaria',1,1,'C',0);
}


if($chose[$i]==7){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'CT ',1,1,'C',0);
}

if($chose[$i]==8){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'PT ',1,1,'C',0);
}
/*
if($chose[$i]==103){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'INR',1,1,'C',0);
}
*/
if($chose[$i]==9){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'BT',1,1,'C',0);
}

if($chose[$i]==10){
              $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Reticulocyte ',1,1,'C',0);
}

if($chose[$i]==11){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Sickling test',1,1,'C',0);
}

if($chose[$i]==12){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'PTT',1,1,'C',0);
}

if($chose[$i]==13){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'D_Dimer',1,1,'C',0);
}

if($chose[$i]==14){
              $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'F.B.S',1,1,'C',0);
}

if($chose[$i]==15){
              $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'R.B.S ',1,1,'C',0);
}

if($chose[$i]==16){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' P.PBS ',1,1,'C',0);
}

if($chose[$i]==17){
              $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' HBA 1C ',1,1,'C',0);
}

if($chose[$i]==18){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'KFT',1,1,'C',0);
}

if($chose[$i]==104){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Urea',1,1,'C',0);
}

if($chose[$i]==105){
               $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Creatinine',1,1,'C',0);
}

if($chose[$i]==19){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'LFT',1,1,'C',0);
}

if($chose[$i]==106){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'S.Got',1,1,'C',0);
}


if($chose[$i]==107){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'S.Gpt',1,1,'C',0);
}

if($chose[$i]==108){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Total Bilirubin',1,1,'C',0);
}

if($chose[$i]==109){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Dirict Bilirubin',1,1,'C',0);
}

if($chose[$i]==20){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'ALK.Phospats',1,1,'C',0);
}

if($chose[$i]==21){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Albumin ',1,1,'C',0);
}

if($chose[$i]==22){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Electrolytes',1,1,'C',0);
}

if($chose[$i]==110){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Ca++',1,1,'C',0);
}

if($chose[$i]==111){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'K+',1,1,'C',0);
}

if($chose[$i]==112){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Na+',1,1,'C',0);
}

if($chose[$i]==113){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Cl-',1,1,'C',0);
}

if($chose[$i]==114){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Mg++',1,1,'C',0);
}

if($chose[$i]==23){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Cardiac Enzyme  ',1,1,'C',0);
}

if($chose[$i]==115){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'C.K',1,1,'C',0);
}

if($chose[$i]==116){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'CK-MG',1,1,'C',0);
}

if($chose[$i]==117){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'L.D.H',1,1,'C',0);
}

if($chose[$i]==118){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Cholesterol',1,1,'C',0);
}

if($chose[$i]==119){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Triglyceride',1,1,'C',0);
}

if($chose[$i]==120){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'LDL',1,1,'C',0);
}

if($chose[$i]==121){
                $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'HDL',1,1,'C',0);
}

if($chose[$i]==24){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Lipid ',1,1,'C',0);
}

if($chose[$i]==25){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Uricacid  ',1,1,'C',0);
}

if($chose[$i]==26){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'ASO',1,1,'C',0);
}
if($chose[$i]==27){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'C.R.P ',1,1,'C',0);
}

if($chose[$i]==28){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' RF',1,1,'C',0);
}

if($chose[$i]==29){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Widal Test',1,1,'C',0);
}

if($chose[$i]==30){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'Brucella',1,1,'C',0);
}

if($chose[$i]==31){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'BLOOD Group ',1,1,'C',0);
}

if($chose[$i]==32){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'TB',1,1,'C',0);
}

if($chose[$i]==122){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'HIV  ',1,1,'C',0);
}

if($chose[$i]==123){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' HCV',1,1,'C',0);
}

if($chose[$i]==124){
                  $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'HBS-Ag',1,1,'C',0);
}

if($chose[$i]==36){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'VDRL',1,1,'C',0);
}

if($chose[$i]==37){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'H.PYLORI RB',1,1,'C',0);
}

if($chose[$i]==38){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'H.PYLORI AG  ',1,1,'C',0);
}

if($chose[$i]==39){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'T.Patinte ',1,1,'C',0);
}

if($chose[$i]==40){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Ethanol ',1,1,'C',0);
}

if($chose[$i]==41){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Diazepam  ',1,1,'C',0);
}


if($chose[$i]==42){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Marijuana ',1,1,'C',0);
}

if($chose[$i]==43){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Tramedol ',1,1,'C',0);
}

if($chose[$i]==44){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Heroin ',1,1,'C',0);
}

if($chose[$i]==45){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Pethidine ',1,1,'C',0);
}

if($chose[$i]==46){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Cocaine ',1,1,'C',0);
}

if($chose[$i]==47){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Amphetamine ',1,1,'C',0);
}


if($chose[$i]==48){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' T3 ',1,1,'C',0);
}

if($chose[$i]==49){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' T4 ',1,1,'C',0);
}

if($chose[$i]==50){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' TSH ',1,1,'C',0);
}

if($chose[$i]==51){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Prolactin ',1,1,'C',0);
}

if($chose[$i]==52){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' PSA ',1,1,'C',0);
}

if($chose[$i]==53){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' PS3 ',1,1,'C',0);
}


if($chose[$i]==54){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Vit-B12 ',1,1,'C',0);
}

if($chose[$i]==55){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' Vit-D3 ',1,1,'C',0);
}

if($chose[$i]==56){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' CA 153 ',1,1,'C',0);
}

if($chose[$i]==57){
                 $pdf->Cell(5,8,'',0,0,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,' CA 125 ',1,1,'C',0);
}




        }

       


          
          
        
        
        
        


    }else{
        echo "please input  choose testes blood  and try agyan ";
    }


}else{
    echo "please input Patinte ID and try agyan ";
}

var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('blood_choosen_dctor_pdf.pdf', 'I');

?>