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

    if(isset($_GET['test'])){


        $chose=$_GET['test'];

        $c =count($chose);
        $total=0.0;

        $pat_id=$_GET['pat_id'];
        $name_ser="book blood";


        $pdf =new TCPDF('p','mm','A4','UTF-8');
        $pdf-> AddPage();
        $pdf->SetFont('freeserif','',16);
        
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(27);
        
        
      
        
        $pdf->Cell(100,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',1,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
        $pdf->Ln();
        
        
        $pdf->Cell(30,8,'patione id:',1,0,'C',0);
        $pdf->Cell(40,8,'name service:',1,0,'C',0);
        $pdf->Cell(50,8,'date now service :',1,1,'C',0);
        
        
        
            $pdf->Cell(30,8,$_GET['pat_id'],'B',0,'C',0);
        
        
        $pdf->Cell(30,8,$name_ser,'B',0,'C',0);
        
        
        $pdf->Cell(40,8,$pat_date_now,'B',1,'C',0);
        

        $pdf->Cell(80,8,' اختبارات الدم المختاره',1,1,'C',0);
        $pdf->SetFont('freeserif','',12);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
    $total= $total+500;
    $pdf->Cell(80,8,'السعر 500 HB',1,1,'C',0);
}

if($chose[$i]==2){
    $total= $total+500;
    $pdf->Cell(80,8,' السعر 500 WBC',1,1,'C',0);
}

if($chose[$i]==3){
    $total= $total+0;
    $pdf->Cell(80,8,' السعر Neutrophil ',1,1,'C',0);
}

if($chose[$i]==4){
    $total= $total+0;
    $pdf->Cell(80,8,' السعر Lymphocyte',1,1,'C',0);
}

if($chose[$i]==5){
    $total= $total+0;
    $pdf->Cell(80,8,' السعر Monocyte',1,1,'C',0);
}

if($chose[$i]==6){
    $total= $total+0;
    $pdf->Cell(80,8,'السعر Eosinophil',1,1,'C',0);
}

if($chose[$i]==7){
    $total= $total+1000;
    $pdf->Cell(80,8,'السعر 1000 Urea ',1,1,'C',0);
}

if($chose[$i]==8){
    $total= $total+1000;
    $pdf->Cell(80,8,'السعر 1000 Creatinine ',1,1,'C',0);
}

if($chose[$i]==9){
    $total= $total+1000;
    $pdf->Cell(80,8,'السعر 1000 S.GOT ',1,1,'C',0);
}

if($chose[$i]==10){
    $total= $total+1000;
    $pdf->Cell(80,8,'السعر 1000 S.GPT ',1,1,'C',0);
}

if($chose[$i]==11){
    $total= $total+750;
    $pdf->Cell(80,8,' السعر 750 Total Brilirubin',1,1,'C',0);
}

if($chose[$i]==12){
    $total= $total+750;
    $pdf->Cell(80,8,'السعر 750 Direct Brilirubin',1,1,'C',0);
}

if($chose[$i]==13){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 A.S.O ',1,1,'C',0);
}

if($chose[$i]==14){
    $total= $total+1500;
    $pdf->Cell(80,8,'  السعر 1500 C.R.P',1,1,'C',0);
}

if($chose[$i]==15){
    $total= $total+1500;
    $pdf->Cell(80,8,' السعر 1500R.F ',1,1,'C',0);
}

if($chose[$i]==16){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 Widal Test Salmonella (O) ',1,1,'C',0);
}

if($chose[$i]==17){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 Widal Test Salmonella (H) ',1,1,'C',0);
}

if($chose[$i]==18){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 Widal Test Salmonella (A) ',1,1,'C',0);
}

if($chose[$i]==19){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 Widal Test Salmonella (B)',1,1,'C',0);
}

if($chose[$i]==20){
    $total= $total+8000;
    $pdf->Cell(80,8,'السعر 8000 Marijuana',1,1,'C',0);
}

if($chose[$i]==21){
    $total= $total+8000;
    $pdf->Cell(80,8,'السعر 8000 Arnphetamin ',1,1,'C',0);
}

if($chose[$i]==22){
    $total= $total+8000;
    $pdf->Cell(80,8,'السعر 8000 Cocaine',1,1,'C',0);
}

if($chose[$i]==23){
    $total= $total+8000;
    $pdf->Cell(80,8,'السعر 8000 Heroin ',1,1,'C',0);
}

if($chose[$i]==24){
    $total= $total+1500;
    $pdf->Cell(80,8,' السعر 1500 PT Patient ',1,1,'C',0);
}

if($chose[$i]==25){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 PTT Patient  ',1,1,'C',0);
}
//////
if($chose[$i]==26){
    $total= $total+0;
    $pdf->Cell(80,8,'السعر INR',1,1,'C',0);
}
////////////
if($chose[$i]==27){
    $total= $total+500;
    $pdf->Cell(80,8,'السعر 500 ESR ',1,1,'C',0);
}

if($chose[$i]==28){
    $total= $total+800;
    $pdf->Cell(80,8,' السعر 800 Malari',1,1,'C',0);
}

if($chose[$i]==29){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 Cholestrol',1,1,'C',0);
}

if($chose[$i]==30){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 Triglyceride',1,1,'C',0);
}

if($chose[$i]==31){
    $total= $total+1500;
    $pdf->Cell(80,8,'السعر 1500 HDL ',1,1,'C',0);
}

if($chose[$i]==32){
    $total= $total+1500;
    $pdf->Cell(80,8,' السعر 1500 LDL',1,1,'C',0);
}

if($chose[$i]==33){
    $total= $total+1500;
    $pdf->Cell(80,8,' السعر 1500 Ca++  ',1,1,'C',0);
}

if($chose[$i]==34){
    $total= $total+1500;
    $pdf->Cell(80,8,'  السعر 1500K+',1,1,'C',0);
}

if($chose[$i]==35){
    $total= $total+1500;
    $pdf->Cell(80,8,' السعر 1500 Na+',1,1,'C',0);
}

if($chose[$i]==36){
    $total= $total+2000;
    $pdf->Cell(80,8,' السعر 2000H.pylorl AD',1,1,'C',0);
}

if($chose[$i]==37){
    $total= $total+2000;
    $pdf->Cell(80,8,' السعر 2000HIV ',1,1,'C',0);
}

if($chose[$i]==38){
    $total= $total+2000;
    $pdf->Cell(80,8,' السعر 2000HBS-Ag  ',1,1,'C',0);
}

if($chose[$i]==39){
    $total= $total+2000;
    $pdf->Cell(80,8,'  2000 السعر  HCV ',1,1,'C',0);
}

if($chose[$i]==40){
    $total= $total+500;
    $pdf->Cell(80,8,' 500 السعر  RBS ',1,1,'C',0);
}

        }
        $pdf->SetFont('freeserif','',16);
////////////total print /////////////////////
$pdf->Cell(40,8,' total is :',1,0,'C',0);
$pdf->Cell(40,8,$total,1,1,'C',0);

        
        $cost_ser=$total;


        $stmt = $conn->prepare("INSERT INTO invoice ( pat_id ,name_ser,cost_ser,invoice_date)
                VALUES (?,?,?,? )");
                
                $stmt->bind_param("ssss",$pat_id,$name_ser,$cost_ser,$pat_date_now) ;
                $stmt->execute();
        
          
          
          
          
        
        ////////////////////////////////////////////
        
        
        
        
        


    }else{
        echo "please input  choose testes blood  and try agyan ";
    }


}else{
    echo "please input pation id and try agyan ";
}



$pdf->Output();


/*
<?php 


require_once('tcpdf.php');




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

    if(isset($_GET['test'])){


        $chose=$_GET['test'];

        $c =count($chose);
        $total=0.0;

        $pat_id=$_GET['pat_id'];
        $name_ser="book blood";


        $pdf =new TCPDF('p','mm','A4','UTF-8');
        $pdf-> AddPage();
        $pdf->SetFont('freeserif','',16);
        
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(18);
        
        
        $pdf->Cell(28,8,'najm_web',1,0,'C',0);
        
        $pdf->Cell(100,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',1,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
        $pdf->Ln();
        
        
        $pdf->Cell(30,8,'patione id:',1,0,'C',0);
        $pdf->Cell(40,8,'name service:',1,0,'C',0);
        $pdf->Cell(50,8,'date now service :',1,1,'C',0);
        
        
        
            $pdf->Cell(30,8,$_GET['pat_id'],'B',0,'C',0);
        
        
        $pdf->Cell(30,8,$name_ser,'B',0,'C',0);
        
        
        $pdf->Cell(40,8,$pat_date_now,'B',1,'C',0);
        

        $pdf->Cell(80,8,' اختبارات الدم المختاره',1,1,'C',0);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
    $total= $total+500;
    $pdf->Cell(50,8,'HB',1,1,'C',0);
}

if($chose[$i]==2){
    $total= $total+500;
    $pdf->Cell(50,8,'WBC',1,1,'C',0);
}

if($chose[$i]==3){
    $total= $total+0;
    $pdf->Cell(50,8,'Neutrophil ',1,1,'C',0);
}

if($chose[$i]==4){
    $total= $total+0;
    $pdf->Cell(50,8,'Lymphocyte',1,1,'C',0);
}

if($chose[$i]==5){
    $total= $total+0;
    $pdf->Cell(50,8,'Monocyte',1,1,'C',0);
}

if($chose[$i]==6){
    $total= $total+0;
    $pdf->Cell(50,8,'Eosinophil',1,1,'C',0);
}

if($chose[$i]==7){
    $total= $total+1000;
    $pdf->Cell(50,8,'Urea ',1,1,'C',0);
}

if($chose[$i]==8){
    $total= $total+1000;
    $pdf->Cell(50,8,'Creatinine ',1,1,'C',0);
}

if($chose[$i]==9){
    $total= $total+1000;
    $pdf->Cell(50,8,'S.GOT ',1,1,'C',0);
}

if($chose[$i]==10){
    $total= $total+1000;
    $pdf->Cell(50,8,' S.GPT ',1,1,'C',0);
}

if($chose[$i]==11){
    $total= $total+750;
    $pdf->Cell(50,8,' Total Brilirubin',1,1,'C',0);
}

if($chose[$i]==12){
    $total= $total+750;
    $pdf->Cell(50,8,'Direct Brilirubin',1,1,'C',0);
}

if($chose[$i]==13){
    $total= $total+1500;
    $pdf->Cell(50,8,'A.S.O ',1,1,'C',0);
}

if($chose[$i]==14){
    $total= $total+1500;
    $pdf->Cell(50,8,' C.R.P',1,1,'C',0);
}

if($chose[$i]==15){
    $total= $total+1500;
    $pdf->Cell(50,8,'R.F ',1,1,'C',0);
}

if($chose[$i]==16){
    $total= $total+1500;
    $pdf->Cell(50,8,' Widal Test Salmonella (O) ',1,1,'C',0);
}

if($chose[$i]==17){
    $total= $total+1500;
    $pdf->Cell(50,8,' Widal Test Salmonella (H) ',1,1,'C',0);
}

if($chose[$i]==18){
    $total= $total+1500;
    $pdf->Cell(50,8,'Widal Test Salmonella (A) ',1,1,'C',0);
}

if($chose[$i]==19){
    $total= $total+1500;
    $pdf->Cell(50,8,'Widal Test Salmonella (B)',1,1,'C',0);
}

if($chose[$i]==20){
    $total= $total+8000;
    $pdf->Cell(50,8,'Marijuana',1,1,'C',0);
}

if($chose[$i]==21){
    $total= $total+8000;
    $pdf->Cell(50,8,'Arnphetamin ',1,1,'C',0);
}

if($chose[$i]==22){
    $total= $total+8000;
    $pdf->Cell(50,8,'Cocaine',1,1,'C',0);
}

if($chose[$i]==23){
    $total= $total+8000;
    $pdf->Cell(50,8,'Heroin ',1,1,'C',0);
}

if($chose[$i]==24){
    $total= $total+1500;
    $pdf->Cell(50,8,' PT Patient ',1,1,'C',0);
}

if($chose[$i]==25){
    $total= $total+1500;
    $pdf->Cell(50,8,'PTT Patient  ',1,1,'C',0);
}
//////
if($chose[$i]==26){
    $total= $total+0;
    $pdf->Cell(50,8,'INR',1,1,'C',0);
}
////////////
if($chose[$i]==27){
    $total= $total+500;
    $pdf->Cell(50,8,'ESR ',1,1,'C',0);
}

if($chose[$i]==28){
    $total= $total+800;
    $pdf->Cell(50,8,' Malari',1,1,'C',0);
}

if($chose[$i]==29){
    $total= $total+1500;
    $pdf->Cell(50,8,'Cholestrol',1,1,'C',0);
}

if($chose[$i]==30){
    $total= $total+1500;
    $pdf->Cell(50,8,'Triglyceride',1,1,'C',0);
}

if($chose[$i]==31){
    $total= $total+1500;
    $pdf->Cell(50,8,'HDL ',1,1,'C',0);
}

if($chose[$i]==32){
    $total= $total+1500;
    $pdf->Cell(50,8,'LDL',1,1,'C',0);
}

if($chose[$i]==33){
    $total= $total+1500;
    $pdf->Cell(50,8,'Ca++  ',1,1,'C',0);
}

if($chose[$i]==34){
    $total= $total+1500;
    $pdf->Cell(50,8,' K+',1,1,'C',0);
}

if($chose[$i]==35){
    $total= $total+1500;
    $pdf->Cell(50,8,' Na+',1,1,'C',0);
}

if($chose[$i]==36){
    $total= $total+2000;
    $pdf->Cell(50,8,'H.pylorl AD',1,1,'C',0);
}

if($chose[$i]==37){
    $total= $total+2000;
    $pdf->Cell(50,8,'HIV ',1,1,'C',0);
}

if($chose[$i]==38){
    $total= $total+2000;
    $pdf->Cell(50,8,'HBS-Ag  ',1,1,'C',0);
}

if($chose[$i]==39){
    $total= $total+2000;
    $pdf->Cell(50,8,'HCV ',1,1,'C',0);
}

if($chose[$i]==40){
    $total= $total+500;
    $pdf->Cell(50,8,'RBS ',1,1,'C',0);
}

        }

////////////total print /////////////////////
$pdf->Cell(40,8,' total is :',1,0,'C',0);
$pdf->Cell(40,8,$total,1,1,'C',0);

        
        $cost_ser=$total;


        $stmt = $conn->prepare("INSERT INTO invoice ( pat_id ,name_ser,cost_ser,invoice_date)
                VALUES (?,?,?,? )");
                
                $stmt->bind_param("ssss",$pat_id,$name_ser,$cost_ser,$pat_date_now) ;
                $stmt->execute();
        
          
          
          
          
        
        ////////////////////////////////////////////
        
        
        
        
        


    }else{
        echo "please input  choose testes blood  and try agyan ";
    }


}else{
    echo "please input pation id and try agyan ";
}



$pdf->Output();


?>
*/

?>