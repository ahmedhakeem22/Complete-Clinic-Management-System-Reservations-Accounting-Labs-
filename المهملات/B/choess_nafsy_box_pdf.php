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

        $name_ser="فاتوره فحص نفسي ";

   
        $pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);
        $pdf-> AddPage();
        
        $pdf->SetFont('aealarabiya','',16);
        
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
        

        $pdf->Cell(50,8,' chossen tests  ',1,1,'C',0);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
    $total= $total+1000;
    $pdf->Cell(50,8,' test nnn (1) / 1000 ',1,1,'C',0);
}

if($chose[$i]==2){
    $total= $total+2000;
    $pdf->Cell(50,8,' test (2) nnn/2000',1,1,'C',0);
}

if($chose[$i]==3){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (3) /1500',1,1,'C',0);
}

if($chose[$i]==4){
    $total= $total+1000;
    $pdf->Cell(50,8,' test (4) /1000',1,1,'C',0);
}

if($chose[$i]==5){
    $total= $total+3000;
    $pdf->Cell(50,8,' test (5) /3000',1,1,'C',0);
}

if($chose[$i]==6){
    $total= $total+1700;
    $pdf->Cell(50,8,' test (6) /1700',1,1,'C',0);
}

if($chose[$i]==7){
    $total= $total+1200;
    $pdf->Cell(50,8,' test (7) /1200',1,1,'C',0);
}

if($chose[$i]==8){
    $total= $total+2200;
    $pdf->Cell(50,8,' test (8) /2200 ',1,1,'C',0);
}

if($chose[$i]==9){
    $total= $total+900;
    $pdf->Cell(50,8,' test (9) /900',1,1,'C',0);
}

if($chose[$i]==10){
    $total= $total+1500;
    $pdf->Cell(50,8,' test (10) /1500',1,1,'C',0);
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