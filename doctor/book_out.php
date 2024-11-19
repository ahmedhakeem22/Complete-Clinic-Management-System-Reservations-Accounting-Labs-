<?php include 'includes/templats/header.php';
include 'includes/templats/navbar.php';
?> 

      <main>
<form  action="book_out_ach_pdf_insrt.php" method="get">
       
<table id="myTable2" cellspacing="" cellpadding="0" >
<tr>
    <th>  name service </th>
    <th> how match money </th>
</tr>

<tr>

<td><input type="text" id="" name="recip_name">  </td>
    <td> <input  type="number" id="" name="amount" >  </td>
    
</tr>
<tr>
<td> <pre></pre> <button type="submit" id="add" aria-placeholder="Add" name="add_sess"> أمــر صـرف  </td>
</form>

<td>

<form  action="book_all_out_pdf.php" method="get">

<button type="submit" id="add" aria-placeholder="Add" name="preint"> طباعه كل المصروفات  </button>
</td>
</tr>
</form>

</table>

      </main>


      <footer>

 

      </footer>

      

</body>





</html>

