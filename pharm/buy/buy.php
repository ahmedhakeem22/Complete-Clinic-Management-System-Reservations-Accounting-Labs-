<?php 
require_once('TCPDF-master/tcpdf.php');



$pdf =new TCPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();

include 'includes/db.php';


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

$mysqli = new mysqli($servername, $username, $password ,$dbname);
$num_rand=rand(100,1000000);


    date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


if ($mysqli->connect_errno)
    die("Connection failed: " .$mysqli->connect_error);

$s = "INSERT INTO buy_invpice (date_buy,delegate,name_med,countity,expired_date,sale_price,buy_price,name_sinc,copny_name,mad_chos,num_bact,date_do,box_id) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$date."','".$_POST['delegate']."','".$_POST['name_med'][$i]."','".$_POST['countity'][$i]."','".$_POST['expired_date'][$i]."','".$_POST['sale_price'][$i]."','".$_POST['buy_price'][$i]."','".$_POST['name_sinc'][$i]."','".$_POST['copny_name'][$i]."','".$_POST['mad_chos'][$i]."','".$_POST['num_bact'][$i]."','".$_POST['date_do'][$i]."','".$num_rand."'),";

    

}

 
$s = rtrim($s,",");
if (!$mysqli->query($s))
echo $mysqli->error;




$sum=0;
$total=0;
$pdf->SetFont('freeserif','',14);
$pdf->SetFillColor(255,230,230);
$pdf->Cell(60,8,'فاتوره شراء',1,0,'C','true');
$pdf->Cell(60,8,$num_rand,1,0,'C','true');
$pdf->Cell(40,8,'تاريخ ',1,0,'C','true');
$pdf->Cell(40,8,$date,1,1,'C','true');
$pdf->Cell(20,8,'',0,1,'C',0);
$pdf->Cell(60,8,'المــندوب',1,0,'C',0);
$pdf->Cell(60,8,$_POST['delegate'],1,1,'C',0);
$pdf->SetFont('freeserif','',10);
$pdf->SetFillColor(214,214,194);

$pdf->Cell(20,8,'م',1,0,'C','true');
$pdf->Cell(40,8,'اسم الدواء',1,0,'C','true');
$pdf->Cell(20,8,'الكمية',1,0,'C','true');
$pdf->Cell(40,8,'سعر الشراء',1,0,'C','true');
$pdf->Cell(30,8,'الصلاحية',1,0,'C','true');
$pdf->Cell(30,8,'الاجمالي',1,1,'C','true');

for ($i = 0; $i < $_POST['numbers'] ; $i++) {
    $num=$i+1; 

    $pdf->SetFont('freeserif','',10);
    $pdf->Cell(20,8,$num,1,0,'C',0);
    $pdf->Cell(40,8,$_POST['name_med'][$i],1,0,'C',0);
    $pdf->Cell(20,8,$_POST['countity'][$i],1,0,'C',0);
    $pdf->Cell(40,8,$_POST['buy_price'][$i],1,0,'C',0);
 
    $pdf->Cell(30,8,$_POST['expired_date'][$i],1,0,'C',0);
$sum=$_POST['countity'][$i]*$_POST['buy_price'][$i];
    $pdf->Cell(30,8,$sum,1,1,'C',0);
$total=$total+$sum;
  








$pdf->Cell(30,8,'',0,1,'C',0);

$pdf->Cell(40,8,$_POST['name_sinc'][$i],1,0,'C',0);
$pdf->Cell(20,8,$_POST['copny_name'][$i],1,0,'C',0);
$pdf->Cell(40,8,$_POST['mad_chos'][$i],1,1,'C',0);
$pdf->Cell(40,8,$_POST['num_bact'][$i],1,0,'C',0);
$pdf->Cell(20,8,$_POST['date_do'][$i],1,1,'C',0);

}



$pdf->SetFont('freeserif','',16);
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',0);
$pdf->Cell(30,8,$total,1,1,'C',0);


if ($mysqli->connect_errno)
    die("Connection failed: " .$mysqli->connect_error);

$name_box='فاتوره شراء';

$ss = "INSERT INTO box_bh (box_id,name_box,box_cost,box_date) VALUES ";
    $ss .="('$num_rand','$name_box','$total','$date'),";

 
    $ss = rtrim($ss,",");
    if (!$mysqli->query($ss))
    echo $mysqli->error;
    

/*
$pdf->SetFont('freeserif','',16);
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',0);
$pdf->Cell(30,8,$total,1,1,'C',0);
$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(255, 0, 0)));
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',1);
$pdf->SetLineStyle(array('width' => 1, 'cap' => 'square', 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 255)));
$pdf->Cell(60,8,' اجمالي الشراء',1,1,'C',1);


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0)));
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',1);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)));
$pdf->Cell(60,8,' اجمالي الشراء',1,1,'C',1);

$pdf->SetLineStyle(array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0)));
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',1);
$pdf->SetLineStyle(array('width' => 1, 'cap' => 'square', 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 255)));
$pdf->Cell(60,8,' اجمالي الشراء',1,1,'C',1);

$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(255, 0, 0)));
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',1);
$pdf->SetLineStyle(array('width' => 1, 'cap' => 'square', 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 255)));
$pdf->Cell(60,8,' اجمالي الشراء',1,1,'C',1);

$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'bevel', 'dash' => 0, 'color' => array(255, 0, 0)));
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',1);
$pdf->SetLineStyle(array('width' => 1, 'cap' => 'square', 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 255)));
$pdf->Cell(60,8,'  الشراء',1,1,'C',1);


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(5, 100, 60, 8, 3, '1111', 'D');
$pdf->Cell(60,8,'  الشراء',0,1,'C',0);



//$pdf->Rect(0,0,100,100,'hhhhhhhhhh');



 


$pdf-> AddPage();
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
$style4 = array('L' => 0,
                'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
                'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
                'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
$style5 = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 64, 128));
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));
$style7 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 128, 0));

$pdf->Text(5, 4, 'Line examples');
$pdf->Line(5, 10, 80, 30, $style);
$pdf->Line(5, 10, 5, 30, $style2);
$pdf->Line(5, 10, 80, 10, $style3);
*/

         var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('buy.pdf', 'I');


$mysqli->close();
?>