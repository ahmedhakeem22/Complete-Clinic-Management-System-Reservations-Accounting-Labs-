
<?php 


require_once __DIR__ . '/../vendor/autoload.php';




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
       
       
        $pat_id=$_GET['pat_id'];
    


        $pdf =new TCPDF('p','mm','A4','UTF-8',false);
        $pdf-> AddPage();
        $pdf->SetFont('freeserif','',16);
 
        
        //$pdf->Image('pic2.jpg',10,2,40);
        
        
        $pdf->Ln(27);
        
        
        $pdf->Cell(28,8,'najm_web',1,0,'C',0);
        
        $pdf->Cell(100,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',1,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
        $pdf->Ln();
        
        
        $pdf->Cell(30,8,'patione id:',1,0,'C',0);
     
        $pdf->Cell(50,8,'date now service :',1,1,'C',0);
        
        
        
            $pdf->Cell(30,8,$_GET['pat_id'],'B',0,'C',0);
        
        
      
        
        
        $pdf->Cell(40,8,$pat_date_now,'B',1,'C',0);
        

        $pdf->Cell(80,8,' اختبارات الدم المختاره',1,1,'C',0);
        for($i=0;$i<$c;$i++){
if($chose[$i]==1){
   
    $pdf->Cell(50,8,'HB',1,1,'C',0);
}

if($chose[$i]==2){
   
    $pdf->Cell(50,8,'WBC',1,1,'C',0);
}

if($chose[$i]==3){

    $pdf->Cell(50,8,'Neutrophil ',1,1,'C',0);
}

if($chose[$i]==4){

    $pdf->Cell(50,8,'Lymphocyte',1,1,'C',0);
}

if($chose[$i]==5){

    $pdf->Cell(50,8,'Monocyte',1,1,'C',0);
}

if($chose[$i]==6){

    $pdf->Cell(50,8,'Eosinophil',1,1,'C',0);
}

if($chose[$i]==7){

    $pdf->Cell(50,8,'Urea ',1,1,'C',0);
}

if($chose[$i]==8){

    $pdf->Cell(50,8,'Creatinine ',1,1,'C',0);
}

if($chose[$i]==9){

    $pdf->Cell(50,8,'S.GOT ',1,1,'C',0);
}

if($chose[$i]==10){

    $pdf->Cell(50,8,' S.GPT ',1,1,'C',0);
}

if($chose[$i]==11){
 
    $pdf->Cell(50,8,' Total Brilirubin',1,1,'C',0);
}

if($chose[$i]==12){
 
    $pdf->Cell(50,8,'Direct Brilirubin',1,1,'C',0);
}

if($chose[$i]==13){

    $pdf->Cell(50,8,'A.S.O ',1,1,'C',0);
}

if($chose[$i]==14){

    $pdf->Cell(50,8,' C.R.P',1,1,'C',0);
}

if($chose[$i]==15){

    $pdf->Cell(50,8,'R.F ',1,1,'C',0);
}

if($chose[$i]==16){

    $pdf->Cell(50,8,' Widal Test Salmonella (O) ',1,1,'C',0);
}

if($chose[$i]==17){

    $pdf->Cell(50,8,' Widal Test Salmonella (H) ',1,1,'C',0);
}

if($chose[$i]==18){

    $pdf->Cell(50,8,'Widal Test Salmonella (A) ',1,1,'C',0);
}

if($chose[$i]==19){
  
    $pdf->Cell(50,8,'Widal Test Salmonella (B)',1,1,'C',0);
}

if($chose[$i]==20){
  
    $pdf->Cell(50,8,'Marijuana',1,1,'C',0);
}

if($chose[$i]==21){
  
    $pdf->Cell(50,8,'Arnphetamin ',1,1,'C',0);
}

if($chose[$i]==22){
  
    $pdf->Cell(50,8,'Cocaine',1,1,'C',0);
}

if($chose[$i]==23){
   
    $pdf->Cell(50,8,'Heroin ',1,1,'C',0);
}

if($chose[$i]==24){
   
    $pdf->Cell(50,8,' PT Patient ',1,1,'C',0);
}

if($chose[$i]==25){
   
    $pdf->Cell(50,8,'PTT Patient  ',1,1,'C',0);
}
//////
if($chose[$i]==26){
   
    $pdf->Cell(50,8,'INR',1,1,'C',0);
}
////////////
if($chose[$i]==27){
   
    $pdf->Cell(50,8,'ESR ',1,1,'C',0);
}

if($chose[$i]==28){
  
    $pdf->Cell(50,8,' Malari',1,1,'C',0);
}

if($chose[$i]==29){
   
    $pdf->Cell(50,8,'Cholestrol',1,1,'C',0);
}

if($chose[$i]==30){
   
    $pdf->Cell(50,8,'Triglyceride',1,1,'C',0);
}

if($chose[$i]==31){
   
    $pdf->Cell(50,8,'HDL ',1,1,'C',0);
}

if($chose[$i]==32){
   
    $pdf->Cell(50,8,'LDL',1,1,'C',0);
}

if($chose[$i]==33){
   
    $pdf->Cell(50,8,'Ca++  ',1,1,'C',0);
}

if($chose[$i]==34){
   
    $pdf->Cell(50,8,' K+',1,1,'C',0);
}

if($chose[$i]==35){
   
    $pdf->Cell(50,8,' Na+',1,1,'C',0);
}

if($chose[$i]==36){
  
    $pdf->Cell(50,8,'H.pylorl AD',1,1,'C',0);
}

if($chose[$i]==37){
  
    $pdf->Cell(50,8,'HIV ',1,1,'C',0);
}

if($chose[$i]==38){
  
    $pdf->Cell(50,8,'HBS-Ag  ',1,1,'C',0);
}

if($chose[$i]==39){
  
    $pdf->Cell(50,8,'HCV ',1,1,'C',0);
}

if($chose[$i]==40){
   
    $pdf->Cell(50,8,'RBS ',1,1,'C',0);
}

        }

       


          
          
        
        
        
        


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
$pdf->Output('blood_choosen_dctor_pdf.pdf', 'I');



?>