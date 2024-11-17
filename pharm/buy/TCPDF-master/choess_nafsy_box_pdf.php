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
  class PDF extends FPDF{
    function Header(){
    $this->setfont('Arial','B',15);
    
    $this->cell(25);
    $this->Image('one.png',10,10,30);
    $this->cell(100,10,'',0,1);
    }
    function Footer(){
      $this->SetY(-15);
      $this->setfont('Arial','B',15);
      $this->cell(0,10,'page'.$this->pageNo(),0,0,'C');
      }
    
    }
    
if(isset($_GET['pat_id'])){

    if(isset($_GET['test'])){


        $chose=$_GET['test'];

        $c =count($chose);
        $total=0.0;

        $pat_id=$_GET['pat_id'];

        $name_ser="فاتوره فحص نفسي";

   
        $pdf= new PDF('p','mm','A4',true,'UTF-8',false);
        $pdf-> AddPage();
        $pdf->Image('2.png',10,60,189);

        $pdf->SetFont('aealarabiya','',16);
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(18);
        
        
        $pdf->Cell(28,8,'NM_CLINIC',1,0,'C',0);
        
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
        

        $pdf->Cell(50,8,' الاختبارات المختاره',1,1,'C',0);
///////////////////// تغيير اسماء الفحوصات
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
    $total= $total+3000;
    $pdf->Cell(50,8,' حط اسما الاختبارات هنا/ 1000 ',1,1,'C',0);
}

if($chose[$i]==2){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (2) nnn/2000',1,1,'C',0);
}

if($chose[$i]==3){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (3) /1500',1,1,'C',0);
}

if($chose[$i]==4){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (4) /1000',1,1,'C',0);
}

if($chose[$i]==5){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (5) /3000',1,1,'C',0);
}

if($chose[$i]==6){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (6) /1700',1,1,'C',0);
}

if($chose[$i]==7){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (7) /1200',1,1,'C',0);
}

if($chose[$i]==8){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (8) /2200 ',1,1,'C',0);
}

if($chose[$i]==9){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (9) /900',1,1,'C',0);
}

if($chose[$i]==10){
    $total= $total+2000;
    $pdf->Cell(50,8,' test (10) /1500',1,1,'C',0);
}
if($chose[$i]==11){
    $total= $total+1000;
    $pdf->Cell(50,8,' test nnn (1) / 1000 ',1,1,'C',0);
}

if($chose[$i]==12){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (2) nnn/2000',1,1,'C',0);
}

if($chose[$i]==13){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (3) /1500',1,1,'C',0);
}

if($chose[$i]==14){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (4) /1000',1,1,'C',0);
}

if($chose[$i]==15){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (5) /3000',1,1,'C',0);
}

if($chose[$i]==16){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (6) /1700',1,1,'C',0);
}

if($chose[$i]==17){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (7) /1200',1,1,'C',0);
}

if($chose[$i]==18){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (8) /2200 ',1,1,'C',0);
}

if($chose[$i]==19){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (9) /900',1,1,'C',0);
}

if($chose[$i]==20){
    $total= $total+3000;
    $pdf->Cell(50,8,' test (10) /1500',1,1,'C',0);
}
if($chose[$i]==21){
    $total= $total+3000;
    $pdf->Cell(50,8,' test nnn (1) / 1000 ',1,1,'C',0);
}

if($chose[$i]==22){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (2) nnn/2000',1,1,'C',0);
}

if($chose[$i]==23){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (3) /1500',1,1,'C',0);
}

if($chose[$i]==24){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (4) /1000',1,1,'C',0);
}

if($chose[$i]==25){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (5) /3000',1,1,'C',0);
}

if($chose[$i]==26){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (6) /1700',1,1,'C',0);
}

if($chose[$i]==27){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (7) /1200',1,1,'C',0);
}

if($chose[$i]==28){
    $total= $total+2000;
    $pdf->Cell(50,8,' test (8) /2200 ',1,1,'C',0);
}

if($chose[$i]==29){
    $total= $total+2000;
    $pdf->Cell(50,8,' test (9) /900',1,1,'C',0);
}

if($chose[$i]==30){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (10) /1500',1,1,'C',0);
}
if($chose[$i]==31){
    $total= $total+1000;
    $pdf->Cell(50,8,' test nnn (1) / 1000 ',1,1,'C',0);
}

if($chose[$i]==32){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (2) nnn/2000',1,1,'C',0);
}

if($chose[$i]==33){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (3) /1500',1,1,'C',0);
}

if($chose[$i]==34){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (4) /1000',1,1,'C',0);
}

if($chose[$i]==35){
    $total= $total+2000;
    $pdf->Cell(50,8,' test (5) /3000',1,1,'C',0);
}

if($chose[$i]==36){
    $total= $total+2000;
    $pdf->Cell(50,8,' test (6) /1700',1,1,'C',0);
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