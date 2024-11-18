<?php 




require_once('../TCPDF-master/tcpdf.php');


include '../includes/db.php';

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

        $chose=$_GET['test'];

        $c =count($chose);
       

        $pat_id=$_GET['pat_id'];

$s=mysqli_query($conn,"select fname from patinte where pat_id = $pat_id");


     while($row =mysqli_fetch_array($s)){

        $row_fname=$row['fname'];

     }
  $pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);

  $pdf->AddPage();
  $pdf->Image('2.png',10,70,189);
  
  $pdf->SetFont('freeserif','',12);

 



        $pdf->Image('img_back_pdf.png',10,10,-300);
  
        
        /* $pdf->Image('pic2.jpg',10,2,40); */
        
        
        $pdf->Ln(27);
        
        
      
        
        $pdf->Cell(150,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date :',0,0,'C',0);
        
        $pdf->Cell(20,8,$pat_date_now,0,1,'C',0);
        $pdf->Ln();
        $pdf->Cell(318,8,'الدكتور : عمرو أحمـــد الخـــرساني ',0,0,'C',0);

                $pdf->Ln(10);
                
        $pdf->Cell(5,8,'',0,0,'C',0);
        $pdf->Cell(22,8,'Patinte ID :',1,0,'C',0);
            $pdf->Cell(15,8,$_GET['pat_id'],1,0,'C',0);
                    $pdf->Cell(30,8,'Patinte Name :',1,0,'C',0);
                        $pdf->Cell(40,8,$row_fname,1,0,'C',0);

        
        
        
        
        
        

        $pdf->Cell(70,8,' الاختبارات المختاره',1,1,'C',0);
        $pdf->SetFont('aealarabiya','',12);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
            $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,' الاختبارات السته الكل ',1,1,'C',0);
}

if($chose[$i]==2){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار وايزمان للمعتقدات  ',1,1,'C',0);
}

if($chose[$i]==3){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار ايزليك للشخصية',1,1,'C',0);
}

if($chose[$i]==4){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار تاكيد الذات ',1,1,'C',0);
}

if($chose[$i]==5){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار تقدير الذات',1,1,'C',0);
}

if($chose[$i]==6){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار وجهه الضبط',1,1,'C',0);
}

if($chose[$i]==7){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار ساكس لتكمله الجمل',1,1,'C',0);
}

if($chose[$i]==8){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الدافعية والرغفه في الادمان',1,1,'C',0);
}

if($chose[$i]==9){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'استبيان معتقدات الشخصية',1,1,'C',0);
}

if($chose[$i]==10){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار الشخصيه المتعدده الاوجه MMPI   ',1,1,'C',0);
}
if($chose[$i]==11){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,' مقياس بيك للاكتئاب',1,1,'C',0);
}

if($chose[$i]==12){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,' مقياس كولومبيا للانتحار',1,1,'C',0);
}

if($chose[$i]==13){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس تابلور للقلق',1,1,'C',0);
}

if($chose[$i]==14){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الوسواس القهري وشدته',1,1,'C',0);
}

if($chose[$i]==15){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الاسيست للادمان',1,1,'C',0);
}

if($chose[$i]==16){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الذكاء المصور',1,1,'C',0);
}

if($chose[$i]==17){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار الجشطلت',1,1,'C',0);
}

if($chose[$i]==18){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس كرب مابعد الصدمه',1,1,'C',0);
}

if($chose[$i]==19){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الهوس',1,1,'C',0);
}

if($chose[$i]==20){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار وكسلر لذكاء المراهقين والبالغين',1,1,'C',0);
}
if($chose[$i]==21){
 $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار وكسلر لذكاء الاطفال ما قبل سن المراهقه',1,1,'C',0);
}

if($chose[$i]==22){
 $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس تقييم الاعراض الانسحابيه للكحول',1,1,'C',0);
}

if($chose[$i]==23){
 $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس تقييم الاعراض الانسحابيه للبنزودياربين',1,1,'C',0);
}

if($chose[$i]==24){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس تقييم اعراض الادمان على البنزودياربين',1,1,'C',0);
}

if($chose[$i]==25){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس تقييم الاعراض الانسحابيه للافيونات',1,1,'C',0);
}

if($chose[$i]==26){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'استبيان تقييم شده الادمان على الافيونات',1,1,'C',0);
}

if($chose[$i]==27){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'استبيان تقييم الادمان غلى الكحول',1,1,'C',0);
}

if($chose[$i]==28){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'اختبار التات TAT  ',1,1,'C',0);
}

if($chose[$i]==29){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس فرط النشاط وقله الانتباه',1,1,'C',0);
}

if($chose[$i]==30){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الدور الجنسي (ذكور-اناث',1,1,'C',0);
}
if($chose[$i]==31){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الرهاب الاجتماعي',1,1,'C',0);
}

if($chose[$i]==32){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس القلق الاجتماعي',1,1,'C',0);
}

if($chose[$i]==33){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'فحص الحاله العقليه',1,1,'C',0);
}

if($chose[$i]==34){
    $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس الهلع',1,1,'C',0);
}

if($chose[$i]==35){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'استبيان التوافق الزوجي',1,1,'C',0);
}

if($chose[$i]==36){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس تشخيص اضطراب التوحد للاطفال',1,1,'C',0);
}
if($chose[$i]==37){
     $pdf->Cell(5,8,'',0,0,'C',0);
            $pdf->Cell(107,8,'',1,0,'C',0);
    $pdf->Cell(70,8,'مقياس ايلي براون',1,1,'C',0);
}

          
        }        

}
         var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('nafsi_ses_pdf.pdf', 'I');


?>