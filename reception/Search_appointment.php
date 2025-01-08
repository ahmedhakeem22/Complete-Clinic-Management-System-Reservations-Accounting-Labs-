<html>

<head>
      <title> Search the appointment </title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="includes/images/icon1.png" type="image/png" sizes="16x16">
      <link rel="stylesheet" type="text/css" href="style.css">
      <title> Home </title>
      <script src=""></script>
  </head>


<body> 
      <header class="header"> 

            <div class="linetop">
            <div class="login">
            <a href="login.html">  <h2> Login </h2> </a>
            </div>
            </div>
            <div class="">

            </div>

      </header>

<main class="main">

 <div>
      <img src="includes/images/search.jpg" alt="image" width="100%" height="47%">
      <h1 class="h1img">
             Search the appointment </h1>


      <form action="/action_page.php">
            <input style="position: relative; top: 20px; width: 42%;" class="searchinapp" type="search" id="myInput" name="gsearch" placeholder=" Search the appointment .." >
            <input style="position: relative; top: 20px; left: 25%; height: 43px;width: 100px; background-color: #b476b6; color: white;  " type="submit"  >
          </form>

 </div>

<div>

      <img src="includes/images/search.jpg" alt="image" width="100%" height="47%" style="top:2300px; position: absolute;">
      <h1></h1>

</div>



<table id="myTable">
  <tr class="header">
    <th style="width:3%;"> ID </th>
    <th style="width:13%;"> Full Name </th>
    <th style="width:2%">Age</th>
    <th style="width: 9%;">Mobile</th>
    <th style="width: 5%;" >Gender</th>
    <th style="width: 10%;" >Social status</th>
    <th style="width: 7%;" >No.Children</th>
    <th style="width: 10%;" >Date and Time</th>
  </tr>

  <tr>
        <td> 1 </td>
        <td>radfan sadek abdullah alkamel</td>
        <td>21</td>
        <td>738946710</td>
        <td>male</td>
        <td>Yemen</td>
  </tr>
  
</table>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>





</main>

     

<footer class="footer">

      <div class="line">

            <h1> Dr. Omar Al-Khursani Clinic </h1>

      </div>

</footer>




</body>
</html>