<?php 

require_once('../TCPDF-master/tcpdf.php');


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

        

        $name_ser="فحص نفسي";

   /*
        $pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);
        $pdf-> AddPage();
        
        $pdf->SetFont('aealarabiya','',16);
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(27);
        
        
        $pdf->Cell(28,8,'najm_web',1,0,'C',0);
        
        $pdf->Cell(100,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',1,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
        $pdf->Ln();
        
        */

        class PDF extends tcpdf{
            function Header(){
            $this->setfont('times','B',15);
            
            $this->cell(25);
            $this->Image('one.png',10,10,30);
            $this->cell(100,10,'',0,1);
            }
            function Footer(){
              $this->SetY(-15);
              $this->setfont('times','B',15);
              $this->cell(0,10,'page'.$this->pageNo(),0,0,'C');
              }
            
            }



$pdf =new PDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->Image('2.png',8,60,189);
$pdf->SetFont('aealarabiya','B',12);

$pdf->Image('img_back_pdf.png',10,10,-300);
//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(25);


$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
        $pdf->Cell(50,8,'سند :',1,0,'C',0);
                $pdf->Cell(50,8,$name_ser,'B',0,'C',0);


$pdf->Ln();


        $pdf->Cell(50,8,'رقم المريض ID',1,0,'C',0);
                    $pdf->Cell(50,8,$_GET['pat_id'],'B',0,'C',0);

        
$pdf->Cell(30,8,' Name :',1,0,'C',0);


            $pdf->Cell(60,8,$_GET['fname'],'B',0,'C',0);
        
        
        $pdf->Ln();

        

        $pdf->Cell(140,8,' الاختبارات المختاره',1,1,'C',0);
        $pdf->SetFont('aealarabiya','',12);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
    $total= $total+3000;
    $pdf->Cell(140,8,' الاختبارات السته الكل السعر *  3000',1,1,'C',0);
}

if($chose[$i]==2){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار وايزمان للمعتقدات السعر * 1000',1,1,'C',0);
}

if($chose[$i]==3){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار ايزليك للشخصية السعر  * 1000',1,1,'C',0);
}

if($chose[$i]==4){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار تاكيد الذات السعر *1000',1,1,'C',0);
}

if($chose[$i]==5){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار تقدير الذات السعر *1000',1,1,'C',0);
}

if($chose[$i]==6){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار وجهه الضبط السعر *1000',1,1,'C',0);
}

if($chose[$i]==7){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار ساكس لتكمله الجمل السعر *1000',1,1,'C',0);
}

if($chose[$i]==8){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس الدافعية والرغفه في الادمان السعر * 1500',1,1,'C',0);
}

if($chose[$i]==9){
    $total= $total+1500;
    $pdf->Cell(140,8,'استبيان معتقدات الشخصية السعر * 1500',1,1,'C',0);
}

if($chose[$i]==10){
    $total= $total+10000;
    $pdf->Cell(140,8,'اختبار الشخصيه المتعدده الاوجه MMPI السعر * 10000 ',1,1,'C',0);
}
if($chose[$i]==11){
    $total= $total+1000;
    $pdf->Cell(140,8,' مقياس بيك للاكتئاب  السعر * 1000',1,1,'C',0);
}

if($chose[$i]==12){
    $total= $total+1500;
    $pdf->Cell(140,8,' مقياس كولومبيا للانتحار السعر * 1500',1,1,'C',0);
}

if($chose[$i]==13){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس تابلور للقلق السعر * 1000',1,1,'C',0);
}

if($chose[$i]==14){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس الوسواس القهري وشدته السعر * 1500',1,1,'C',0);
}

if($chose[$i]==15){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس الاسيست للادمان السعر * 1500',1,1,'C',0);
}

if($chose[$i]==16){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس الذكاء المصور السعر * 1500',1,1,'C',0);
}

if($chose[$i]==17){
    $total= $total+1000;
    $pdf->Cell(140,8,'اختبار الجشطلت  السعر * 1000',1,1,'C',0);
}

if($chose[$i]==18){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس كرب مابعد الصدمه السعر * 1000',1,1,'C',0);
}

if($chose[$i]==19){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس الهوس السعر * 1000',1,1,'C',0);
}

if($chose[$i]==20){
    $total= $total+10000;
    $pdf->Cell(140,8,'اختبار وكسلر لذكاء المراهقين والبالغين السعر * 10000',1,1,'C',0);
}
if($chose[$i]==21){
    $total= $total+10000;
    $pdf->Cell(140,8,'اختبار وكسلر لذكاء الاطفال ما قبل سن المراهقه السعر * 10000',1,1,'C',0);
}

if($chose[$i]==22){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس تقييم الاعراض الانسحابيه للكحول السعر * 1500',1,1,'C',0);
}

if($chose[$i]==23){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس تقييم الاعراض الانسحابيه للبنزودياربين السعر * 1500',1,1,'C',0);
}

if($chose[$i]==24){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس تقييم اعراض الادمان على البنزودياربين السعر * 1500',1,1,'C',0);
}

if($chose[$i]==25){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس تقييم الاعراض الانسحابيه للافيونات السعر * 1500',1,1,'C',0);
}

if($chose[$i]==26){
    $total= $total+1500;
    $pdf->Cell(140,8,'استبيان تقييم شده الادمان على الافيونات السعر * 1500',1,1,'C',0);
}

if($chose[$i]==27){
    $total= $total+1500;
    $pdf->Cell(140,8,'استبيان تقييم الادمان غلى الكحول السعر * 1500',1,1,'C',0);
}

if($chose[$i]==28){
    $total= $total+2000;
    $pdf->Cell(140,8,'اختبار التات TAT السعر * 2000',1,1,'C',0);
}

if($chose[$i]==29){
    $total= $total+2000;
    $pdf->Cell(140,8,'مقياس فرط النشاط وقله الانتباه السعر * 2000',1,1,'C',0);
}

if($chose[$i]==30){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس الدور الجنسي (ذكور-اناث السعر * 1000',1,1,'C',0);
}
if($chose[$i]==31){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس الرهاب الاجتماعي السعر * 1000',1,1,'C',0);
}

if($chose[$i]==32){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس القلق الاجتماعي السعر * 1000',1,1,'C',0);
}

if($chose[$i]==33){
    $total= $total+1000;
    $pdf->Cell(140,8,'فحص الحاله العقليه السعر * 1000',1,1,'C',0);
}

if($chose[$i]==34){
    $total= $total+1000;
    $pdf->Cell(140,8,'مقياس الهلع السعر * 1000',1,1,'C',0);
}

if($chose[$i]==35){
    $total= $total+2000;
    $pdf->Cell(140,8,'استبيان التوافق الزوجي السعر * 2000',1,1,'C',0);
}

if($chose[$i]==36){
    $total= $total+2000;
    $pdf->Cell(140,8,'مقياس تشخيص اضطراب التوحد للاطفال السعر * 2000',1,1,'C',0);
}
if($chose[$i]==37){
    $total= $total+1500;
    $pdf->Cell(140,8,'مقياس ايلي براون السعر * 1500',1,1,'C',0);
}



        }
        $pdf->SetFont('aealarabiya','',16);
////////////total print /////////////////////
$pdf->Cell(40,8,' total is :',1,0,'C',0);
$pdf->Cell(40,8,$total,1,1,'C',0);

        
        $cost_ser=$total;


        $stmt = $conn->prepare("INSERT INTO invoice ( pat_id,name_ser,cost_ser,invoice_date,fname)
                VALUES (?,?,?,?,?)");
                
                $stmt->bind_param("sssss",$pat_id,$name_ser,$cost_ser,$pat_date_now,$fname) ;
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