<?php 


require_once('tcpdf.php');

//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);



    mysqli_select_db($conn,"najmdb");
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
   

$pdf =new PDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->Image('2.png',10,60,189);

$pdf->SetFont('freeserif','',16);


        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $note_pl=$_GET['note_pl'];
  $pat_id=$_GET['pat_id'];
  $resul_pl=$_GET['resul_pl'];


$pdf->Ln(20);

$pdf->Cell(80,8,'NM_CLINIC',1,0,'C',0);

$pdf->Ln(20);
$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Ln(20);

$pdf->Cell(80,8,'date now ',1,0,'C',0);

$pdf->Cell(80,8,$pat_date_now,1,1,'C',0);

$pdf->Cell(40,8,'رقم المريض ',1,0,'C',0);
$pdf->Cell(40,8,'اسم الفحص ',1,0,'C',0);

$pdf->Cell(40,8,' نتيجه الفحص  ',1,0,'C',0);

$pdf->Cell(40,8,' ملاحظــه ',1,1,'C',0);
$pdf->Cell(40,8,$_GET['pat_id'],1,0,'C',0);

$choose;
if($_GET['nafsy']==1){
    $choose="test 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="test 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="test 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="test 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="test 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);

        $stmt = $conn->prepare("INSERT INTO test_psychological ( pat_id ,name_test,result,notes)
                VALUES (?,?,?,? )");
                
                $stmt->bind_param("ssss",$pat_id,$choose,$resul_pl,$note_pl) ;
                $stmt->execute();
        
          
          
          
          
        



$pdf->Output();


?>