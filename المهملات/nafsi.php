<!DOCTYPE html>
<html>
<head>
    <title> Psychological examination  </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body> 


    <main class="main">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          
          <table id="mytable" cellspacing="15" cellpadding="0" >
          
          <tr>

            <td>
            <label for="no.p">  Patient No: <pre></pre></label>
            <input type="number" id="nosession" name="pat_id">
            </td>
          

          
              <td>
              <label for="no.p">Patient name: <pre></pre></label>
              </td>
              <td>
              <text> اسم المريض هنا </text>
              </td>

              <td>
              <input type="submit" value="Submit" name="Submit_pation">
              </td>

          </tr>
     
          </table>
          

<table class="borderjalsa2">

<tr>
<td>
<label class="container">Test 1
  <input type="radio" checked="checked" name="radio">
  <span class="checkmark"></span>

<td>
<input for="wbc" > النتيجة :<pre></pre></input>
</td>

<td>
<label> النتيجة الطبعية :</label>
<text> ماهي النتيجة الطبيعية </text>
</td>

<td>
<input style="width:200px" > ملاحظات :<pre></pre></input>
</td>

</label>
</td>
</tr>

<tr>
<td>
<label class="container">Test 2
  <input type="radio" name="radio">
  <span class="checkmark"></span>
</label>
</td>

<td>
<input for="wbc" > النتيجة :<pre></pre></input>
</td>

<td>
<label > النتيجة الطبعية :</label>
<text> ماهي النتيجة الطبيعية </text>
</td>

<td>
<input style="width:200px" > ملاحظات :<pre></pre></input>
</td>

</tr>

<tr>
<td>
<label class="container">Test 3
  <input type="radio" name="radio">
  <span class="checkmark"></span>
</label>
</td>

<td>
<input for="wbc" > النتيجة :<pre></pre></input>
</td>

<td>
<label > النتيجة الطبعية :</label>
<text> ماهي النتيجة الطبيعية </text>
</td>

<td>
<input style="width:200px" > ملاحظات :<pre></pre></input>
</td>


</tr>

<tr>
<td>
<label class="container">Test 4
  <input type="radio" name="radio">
  <span class="checkmark"></span>
</label>
</td>

<td>
<input for="wbc" > النتيجة :<pre></pre></input>
</td>

<td>
<label > النتيجة الطبعية :</label>
<text> ماهي النتيجة الطبيعية </text>
</td>

<td>
<input style="width:200px" > ملاحظات :<pre></pre></input>
</td>


</tr>

<tr>
<td>
<input type="submit" value="Submit" name="Submit">
 </td>
</tr>

</table>

   </form>


   </main>
            
           <footer class="footer">
            

           </footer> 
        
</body>

</html>

