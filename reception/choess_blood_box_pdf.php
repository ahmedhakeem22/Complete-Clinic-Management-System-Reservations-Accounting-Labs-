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
        $pat_id=$_GET['pat_id'];
       $fname=$_GET['fname'];

    if(isset($_GET['test'])){


        $chose=$_GET['test'];

        $c =count($chose);
        $total=0.0;

        $name_ser="book blood";


$s=mysqli_query($conn,"select fname from patinte where pat_id = $pat_id");


     while($row =mysqli_fetch_array($s)){

        $row_fname=$row['fname'];

     }
        $pdf =new TCPDF('p','mm','A4','UTF-8');
        $pdf-> AddPage();
        $pdf->SetFont('freeserif','',13);
                $pdf->Ln();
                                $pdf->Ln();
                $pdf->Ln();


        $pdf->Image('img_back_pdf.png',10,10,-300);
        
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(27);
        
        
      
        
        $pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(20,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,0,1,'C',0);
        $pdf->Ln();


                $pdf->Cell(300,8,'الدكتور : عمرو أحمـــد الخـــرساني ',0,0,'C',0);

                        $pdf->Ln();


          $pdf->SetFillColor(247, 224, 211);
        $pdf->Cell(25,8,'Patinte ID',1,0,'C','true');
                $pdf->Cell(60,8,'Patinte Name',1,0,'C','true');

        $pdf->Cell(40,8,'Service',1,0,'C','true');
                $pdf->Cell(60,8,' اختبارات الدم المختاره',1,1,'C','true');
        $pdf->SetFont('freeserif','',12);

            $pdf->Cell(25,8,$_GET['pat_id'],1,0,'C',0);
            $pdf->Cell(60,8,$row_fname,1,0,'C',0);
        $pdf->Cell(40,8,$name_ser,'B',0,'C',0);

        
        for($i=0;$i<$c;$i++){

if($chose[$i]==1){
    $total= $total+1500;
    $pdf->Cell(60,8,'C.B.C',1,1,'C',0);
    $pdf->Cell(125,8,'',1,0,'C',0);

}


if($chose[$i]==101){
        $total= $total+500;
            $pdf->Cell(60,8,'HB',1,1,'C',0);
              $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==102){
        $total= $total+500;
              $pdf->Cell(125,8,'',1,0,'C',0);
    $pdf->Cell(50,8,'ًWBC',1,1,'C',0);
}

if($chose[$i]==2){
    $total= $total+500;
    $pdf->Cell(60,8,'  platelats ',1,1,'C',0);
                            $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==3){
    $total= $total+500;
    $pdf->Cell(60,8,'ESR',1,1,'C',0);
                            $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==4){
    $total= $total+1000;
    $pdf->Cell(60,8,'Malaria',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==7){
    $total= $total+400;
    $pdf->Cell(60,8,'CT',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==8){
    $total= $total+1500;
    $pdf->Cell(60,8,' PT ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}


if($chose[$i]==9){
    $total= $total+400;
    $pdf->Cell(60,8,'BT',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==10){
    $total= $total+1000;
    $pdf->Cell(60,8,' RETICULOCYTE',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==11){
    $total= $total+2000;
    $pdf->Cell(60,8,' Sickling test ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==12){
    $total= $total+1500;
    $pdf->Cell(60,8,'PTT',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==13){
    $total= $total+8000;
    $pdf->Cell(60,8,' D_Dimer ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==14){
    $total= $total+600;
    $pdf->Cell(60,8,' F.B.S',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==15){
    $total= $total+600;
    $pdf->Cell(60,8,' R.B.S',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==16){
    $total= $total+600;
    $pdf->Cell(60,8,' P.PBS ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==17){
    $total= $total+4000;
    $pdf->Cell(60,8,' HBA 1C ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}


if($chose[$i]==18){
    $total= $total+2000;
    $pdf->Cell(60,8,' KFT',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==104){
    $total= $total+1000;
    $pdf->Cell(60,8,'Urea',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==105){
    $total= $total+1000;
    $pdf->Cell(60,8,'Creatinine',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==19){
    $total= $total+3500;
    $pdf->Cell(60,8,' LFT',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==106){
    $total= $total+900;
    $pdf->Cell(60,8,'S.Got',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==107){
    $total= $total+900;
    $pdf->Cell(60,8,'S.Gpt',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==108){
    $total= $total+900;
    $pdf->Cell(60,8,'Total Bilirubin',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==109){
    $total= $total+900;
    $pdf->Cell(60,8,'Dirict Bilirubin',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==20){
    $total= $total+1000;
    $pdf->Cell(60,8,' ALK.Phospats ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==21){
    $total= $total+1000;
    $pdf->Cell(60,8,' Albumin',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==22){
    $total= $total+7500;
    $pdf->Cell(60,8,' Electrolytes ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==110){
    $total= $total+1500;
    $pdf->Cell(60,8,' Ca++ ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==111){
    $total= $total+1500;
    $pdf->Cell(60,8,' K++ ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==112){
    $total= $total+1500;
    $pdf->Cell(60,8,' Na++ ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==113){
    $total= $total+1500;
    $pdf->Cell(60,8,' Cl++ ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==114){
    $total= $total+1500;
    $pdf->Cell(60,8,' Mg++ ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==23){
    $total= $total+6000;
    $pdf->Cell(60,8,' Cardiac Enzyme',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==115){
    $total= $total+2000;
    $pdf->Cell(60,8,'C.K',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==116){
    $total= $total+2000;
    $pdf->Cell(60,8,'CM-MB',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==117){
    $total= $total+2000;
    $pdf->Cell(60,8,'L.D.H',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==24){
    $total= $total+7000;
    $pdf->Cell(60,8,' Lipid  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==118){
    $total= $total+1800;
    $pdf->Cell(60,8,' Cholesterol  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==119){
    $total= $total+1800;
    $pdf->Cell(60,8,' Triglyceride  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==120){
    $total= $total+1800;
    $pdf->Cell(60,8,' LDL  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==121){
    $total= $total+1800;
    $pdf->Cell(60,8,' HDL  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==25){
    $total= $total+1500;
    $pdf->Cell(60,8,'  Uric Acid',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==39){
    $total= $total+1500;
    $pdf->Cell(60,8,'T.Protine',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}


if($chose[$i]==26){
    $total= $total+1500;
    $pdf->Cell(60,8,' ASO ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==27){
    $total= $total+1500;
    $pdf->Cell(60,8,' C.R.P',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==28){
    $total= $total+1500;
    $pdf->Cell(60,8,' RF',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==29){
    $total= $total+1500;
    $pdf->Cell(60,8,' Widal test',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==30){
    $total= $total+1500;
    $pdf->Cell(60,8,' Brucella A+M  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==31){
    $total= $total+600;
    $pdf->Cell(60,8,'  BLOOD Group',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==32){
    $total= $total+2000;
    $pdf->Cell(60,8,' TB  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==33){
    $total= $total+6000;
    $pdf->Cell(60,8,'Viral Marker',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==122){
    $total= $total+2000;
    $pdf->Cell(60,8,' HIV ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==123){
    $total= $total+2000;
    $pdf->Cell(60,8,'  HCV',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==124){
    $total= $total+2000;
    $pdf->Cell(60,8,'  HBS-Ag',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==36){
    $total= $total+2000;
    $pdf->Cell(60,8,'  VDRL ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==37){
    $total= $total+2500;
    $pdf->Cell(60,8,'  H.PYLORI RB  ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);

}

if($chose[$i]==38){
    $total= $total+3500;
    $pdf->Cell(60,8,'   H.PYLORI AG ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==40){
    $total= $total+8000;
    $pdf->Cell(60,8,'Ethanol ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==41){
    $total= $total+8000;
    $pdf->Cell(60,8,'Diazepam',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==42){
    $total= $total+8000;
    $pdf->Cell(60,8,'Marijuana ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==43){
    $total= $total+8000;
    $pdf->Cell(60,8,'Tramedol ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==44){
    $total= $total+8000;
    $pdf->Cell(60,8,'Heroin ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==45){
    $total= $total+8000;
    $pdf->Cell(60,8,'Pethidine ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==46){
    $total= $total+8000;
    $pdf->Cell(60,8,'Cocaine ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==47){
    $total= $total+8000;
    $pdf->Cell(60,8,'Amphetamine ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==48){
    $total= $total+3000;
    $pdf->Cell(60,8,'T3 ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==49){
    $total= $total+3000;
    $pdf->Cell(60,8,'T4 ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==50){
    $total= $total+3000;
    $pdf->Cell(60,8,'TSH ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==51){
    $total= $total+3000;
    $pdf->Cell(60,8,'Prolactin ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==52){
    $total= $total+4000;
    $pdf->Cell(60,8,'PSA Free ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}
if($chose[$i]==53){
    $total= $total+4000;
    $pdf->Cell(60,8,'PSA Total ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==54){
    $total= $total+4000;
    $pdf->Cell(60,8,'Vit-B12 ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==55){
    $total= $total+12000;
    $pdf->Cell(60,8,'Vit-D3 ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==56){
    $total= $total+5000;
    $pdf->Cell(60,8,'CA 153 ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

if($chose[$i]==57){
    $total= $total+5000;
    $pdf->Cell(60,8,'CA 125 ',1,1,'C',0);
                                $pdf->Cell(125,8,'',1,0,'C',0);
}

        }
        
        $pdf->SetFont('freeserif','',16);
                  $pdf->SetFillColor(240, 240, 239);
$pdf->Cell(30,8,'Total',1,0,'C','true');
$pdf->Cell(30,8,$total,1,1,'C','true');

        
        $cost_ser=$total;


        $stmt = $conn->prepare("INSERT INTO invoice ( pat_id ,name_ser,cost_ser,invoice_date)
                VALUES (?,?,?,?)");
                
                $stmt->bind_param("ssss",$pat_id,$name_ser,$cost_ser,$pat_date_now) ;
                $stmt->execute();
        
          
          
          
          
        
        ////////////////////////////////////////////
        
        
        
        
        
        

    }else{
        echo "please input  choose testes blood  and try agyan ";
    }


}else{
    echo "please input pation id and try agyan ";
}


         var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('choess_blood_box.pdf', 'I');

?>