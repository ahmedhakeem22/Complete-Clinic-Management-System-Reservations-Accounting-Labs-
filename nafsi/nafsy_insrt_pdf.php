<?php 


require_once('../TCPDF-master/tcpdf.php');

$pdf =new TCPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->SetFont('freeserif','',16);
$pdf->Image('img_back_pdf.png',10,10,-300);
//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "root";


// Create connection
$conn = mysqli_connect($servername, $username, $password);



    mysqli_select_db($conn,"najmdb");

    
  
      /////////////select from pay bill //////////////
     


        
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


$pdf->Ln(27);



$pdf->Ln(20);
$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Ln(20);





$pdf->Cell(40,8,'رقم المريض ',1,0,'C',0);
$pdf->Cell(80,8,'اسم الفحص ',1,0,'C',0);

$pdf->Cell(40,8,' نتيجه الفحص  ',1,0,'C',0);

$pdf->Cell(40,8,' ملاحظــه ',1,1,'C',0);
$pdf->Cell(40,8,$_GET['pat_id'],1,0,'C',0);

$choose;
$pdf->SetFont('freeserif','',12);
if($_GET['nafsy']==1){
    $choose="الاختبارات السته الكل";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="اختبار وايزمان للمعتقدات";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="اختبار ايزليك للشخصية";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="اختبار تاكيد الذات";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="اختبار تقدير الذات";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==6){
    $choose="اختبار وجهه الضبط";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==7){
    $choose="اختبار ساكس لتكمله الجمل";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==8){
    $choose="مقياس الدافعية والرغفه في الادمان";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==9){
    $choose="استبيان معتقدات الشخصية";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==10){
    $choose="اختبار الشخصيه المتعدده الاوجه MMPI";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==11){
    $choose="مقياس بيك للاكتئاب";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==12){
    $choose="مقياس كولومبيا للانتحار";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==13){
    $choose="مقياس تابلور للقلق";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==14){
    $choose="مقياس الوسواس القهري وشدته";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==15){
    $choose="مقياس الاسيست للادمان";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==16){
    $choose="مقياس الذكاء المصور";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==17){
    $choose="اختبار الجشطلت";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==18){
    $choose="مقياس كرب مابعد الصدمه";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==19){
    $choose="مقياس الهوس";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==20){
    $choose="اختبار وكسلر لذكاء المراهقين والبالغين";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==21){
    $choose="اختبار وكسلر لذكاء الاطفال ما قبل سن المراهقه";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==22){
    $choose="مقياس تقييم الاعراض الانسحابيه للكحول";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==23){
    $choose="مقياس تقييم الاعراض الانسحابيه للبنزودياربين";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==24){
    $choose="مقياس تقييم اعراض الادمان على البنزودياربين";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==25){
    $choose="مقياس تقييم الاعراض الانسحابيه للافيونات";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==26){
    $choose="استبيان تقييم شده الادمان على الافيونات";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==27){
    $choose="استبيان تقييم الادمان غلى الكحول";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==28){
    $choose="اختبار التات TAT";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==29){
    $choose="مقياس فرط النشاط وقله الانتباه";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==30){
    $choose="مقياس الدور الجنسي (ذكور-اناث";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==31){
    $choose="مقياس الرهاب الاجتماعي";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==32){
    $choose="مقياس القلق الاجتماعي";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}
if($_GET['nafsy']==33){
    $choose="فحص الحاله العقليه";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}
if($_GET['nafsy']==34){
    $choose="مقياس الهلع";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}
if($_GET['nafsy']==35){
    $choose="استبيان التوافق الزوجي";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}
if($_GET['nafsy']==36){
    $choose="مقياس تشخيص اضطراب التوحد للاطفال";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}
if($_GET['nafsy']==37){
    $choose="مقياس ايلي يراون   ";
    $pdf->Cell(80,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);

//////////////////////////////

$stmt = $conn->prepare("INSERT INTO test_psychological ( pat_id ,name_test,result,notes)
                VALUES (?,?,?,? )");
                
                $stmt->bind_param("ssss",$pat_id,$choose,$resul_pl,$note_pl) ;
                $stmt->execute();

/*
$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);


$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);


$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);


$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);


$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);


$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);


$pdf->Ln(20);

$pdf->Cell(80,8,'najm_web page 1',1,0,'C',0);

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
    $choose="tst 1";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==2){
    $choose="tst 2";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==3){
    $choose="tst 3";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==4){
    $choose="tst 4";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}

if($_GET['nafsy']==5){
    $choose="tst 5";
    $pdf->Cell(40,8,$choose,1,0,'C',0);
}


$pdf->Cell(40,8,$resul_pl,1,0,'C',0);


$pdf->Cell(40,8,$note_pl,1,1,'C',0);
*/
/*
        $stmt = $conn->prepare("INSERT INTO test_psychological ( pat_id ,name_test,result,notes)
                VALUES (?,?,?,? )");
                
                $stmt->bind_param("ssss",$pat_id,$choose,$resul_pl,$note_pl) ;
                $stmt->execute();
        
          */
          
          
          
        



$pdf->Output();


?>