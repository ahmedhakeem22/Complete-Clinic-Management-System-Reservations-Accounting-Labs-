<?php include 'templats/header.php';
include 'templats/navbar.php';
include '../includes/db.php';


$pat_idd = 0;
if (isset($_POST['show_det'])) {
  $pat_idd = $_POST['pat_id'];

  /////////////////////////search jqury users//////////////////////////

  $r = mysqli_query($conn, "select fname,age,phone,soc_sts,chel_num from patinte where pat_id=$pat_idd ");

}

date_default_timezone_set("Asia/Aden");
$pat_date = date("Y-m-d ");
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}




if (isset($_POST['addsess'])) {



  $pat_id = $_POST['pat_id'];

  // $date_now=$_POST['date_now'];

  $date_pev = $_POST['date_pev'];

  $date_next = $_POST['date_next'];

  $main_com = $_POST['main_com'];

  $period_ill = $_POST['period_ill'];

  $curr_hist = $_POST['curr_hist'];

  $last_hist = $_POST['last_hist'];

  $fam_hist = $_POST['fam_hist'];

  $work_hist = $_POST['work_hist'];

  $sex_hist = $_POST['sex_hist'];

  $person_hist = $_POST['person_hist'];

  $appear = $_POST['appear'];

  $behav = $_POST['behav'];

  $speech = $_POST['speech'];

  $mood = $_POST['mood'];

  $killer = $_POST['killer'];

  $thin_shep = $_POST['thin_shep'];

  $thin_con = $_POST['thin_con'];

  $percep = $_POST['percep'];

  $memory = $_POST['memory'];

  $ability = $_POST['ability'];

  $insight = $_POST['insight'];

  $fores = $_POST['fores'];

  $degree = $_POST['degree'];


  $basic_dig = $_POST['basic_dig'];

  $diff_dig = $_POST['diff_dig'];

  if (empty($_POST["pat_id"])) {
    $Pat_fname = " Patinte ID is Required";
    echo $Pat_fname;
  } else {

    $stmt = $conn->prepare("INSERT INTO session (pat_id,date_now,date_pev,date_next,main_com,period_ill,sex_hist,person_hist,curr_hist,last_hist,fam_hist,work_hist,basic_dig,diff_dig,appear,behav,mood,killer,thin_shep,thin_con,percep,memory,ability,insight,fores,degree,speech)
        VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param("sssssssssssssssssssssssssss", $pat_id, $pat_date, $date_pev, $date_next, $main_com, $period_ill, $sex_hist, $person_hist, $curr_hist, $last_hist, $fam_hist, $work_hist, $basic_dig, $diff_dig, $appear, $behav, $mood, $killer, $thin_shep, $thin_con, $percep, $memory, $ability, $insight, $fores, $degree, $speech);
    $stmt->execute();
  }
}
$conn->close();

?>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <main>

    <div>

      <table class="table table-striped table-bordered table-hover " cellspacing="15" cellpadding="0">

        <tr>
          <td> <label for="no.p1" style="background-color:#009933;" class=" form-control "> <strong
                style="color:white;"> No. Patient: </strong> </label>
            <label> <input type="number" name="pat_id" class=" form-control " /></label>

            <label> <input style=" width:100px; background-color:orange; " class="btn btn-primary form-control "
                type="submit" value="إستعـلام" title="معلومات المريض" name="show_det" /></label>
          </td>

          <td colspan='4'>
          </td>
        </tr>
        <tr>
          <?php
          if ($pat_idd > 0) {
            while ($row = mysqli_fetch_array($r)) {

              echo "<tr>";
              echo "<td> Name : " . $row['fname'] . "</td>";
              echo "<td> Age : " . $row['age'] . "</td>";
              echo "<td> Social status : " . $row['soc_sts'] . "</td>";
              echo "<td> Phone : " . $row['phone'] . "</td>";
              echo "<td> No.Children : " . $row['chel_num'] . "</td>";
              echo "</tr>";


            }
          }

          ?>
        </tr>

        <tr>
          <td>
            <label for="current" style="background-color:#4d4d4d;" class=" form-control "> <strong style="color:white;">
                The current session date:</strong> </label>
            <label style="color:black;"> <?php echo $pat_date; ?> </label>
          </td>

          <td>
            <label for="previous" style="background-color:#4d4d4d;" class=" form-control "> <strong
                style="color:white;"> Date of the previous session:</strong> </label>
            <input type="date" id="previousdate" name="date_pev" class="form-control" />
          </td>


          <td colspan='3'>
            <label for="next" style="background-color:#4d4d4d;" class=" form-control "> <strong style="color:white;">
                Date of the next session: </strong> </label>
            <input type="date" id="nextdate" name="date_next" class=" form-control " />
          </td>
        </tr>
      </table>
    </div>


    <table class="table table-striped table-bordered table-hover table-active" cellspacing="15" cellpadding="0">


      <tr>
        <td colspan='2'>
          <label style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;"> The main
              complaint : </strong></label>
          <textarea id="complaint" cols="125" rows="3" name="main_com" class="form-control"></textarea>
        </td>
        <td colspan='2'>
          <label for="illness" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              The period of illness:</strong></label>
          <textarea id="illness" cols="123" rows="3" name="period_ill" class="form-control"></textarea>
        </td>

      </tr>


      <tr>

        <td colspan='2'>
          <label for="disease" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              History of present illness:</strong></label>
          <textarea id="" cols="125" rows="3" name="curr_hist" class="form-control"></textarea>
        </td>
        <td colspan='2'>
          <label for="last" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;"> Past
              History:</strong></label>
          <textarea id="" cols="123" rows="3" name="last_hist" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
      </tr>
      <tr>
        <td>
          <label for="family" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Family History :</strong> </label>
          <textarea id="family" cols="55" rows="3" name="fam_hist"></textarea>
        </td>
        <td>
          <label for="work" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Occupational History:</strong></label>
          <textarea id="work" cols="55" rows="3" name="work_hist" class="form-control"></textarea>
        </td>
        <td>
          <label for="Sexual" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Sexual history:</strong></label>
          <textarea id="" cols="55" rows="3" name="sex_hist" class="form-control"></textarea>
        </td>

        <td>
          <label for="Personal" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Personal history:</strong></label>
          <textarea id="" cols="55" rows="3" name="person_hist" class="form-control"></textarea>
        </td>
      </tr>

      <tr>
        <td colspan='4'>
          <label class="form-control" style="background-color:#196619;" class=" form-control "> <strong
              style="color:white;"> Mental status examination :</strong></label>
        </td>
      </tr>
      <tr>
        <td>
          <label for="appearance" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;"> Appearance:</strong></label>
          <textarea id="" cols="55" rows="3" name="appear" class="form-control"></textarea>
        </td>
        <td>
          <label for="behavior" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Behavior:</strong></label>
          <textarea id="" cols="55" rows="3" name="behav" class="form-control"></textarea>
        </td>
        <td>
          <label for="speech" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Speech:</strong></label>
          <textarea id="" cols="55" rows="3" name="speech" class="form-control"></textarea>
        </td>

        <td>
          <label for="Mood and affect" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Mood/Affect:</strong></label>
          <textarea id="" cols="55" rows="3" name="mood" class="form-control"></textarea>
        </td>
      </tr>

      <tr>

      </tr>




      <tr>

        <td>
          <label for="killing" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Suicidal/Homicidal thoughts/plans:</strong></label>
          <textarea id="" cols="55" rows="3" name="killer" class="form-control"></textarea>
        </td>

        <td>
          <label for="Thinking" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Think Form:</strong></label>
          <textarea id="" cols="55" rows="3" name="thin_shep" class="form-control"></textarea>
        </td>

        <td>
          <label for="content" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Think Content:</strong></label>
          <textarea id="" cols="55" rows="3" name="thin_con" class="form-control"></textarea>
        </td>

        <td>
          <label for="perception" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Perception:</strong></label>
          <textarea id="" cols="55" rows="3" name="percep" class="form-control"></textarea>
        </td>



      </tr>

      <tr>

        <td>
          <label for="Memory" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Memory:</strong></label>
          <textarea id="" cols="55" rows="3" name="memory" class="form-control"></textarea>
        </td>

        <td>
          <label for="judge" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Judgement :</strong></label>
          <textarea id="" cols="55" rows="3" name="ability" class="form-control"></textarea>
        </td>

        <td>
          <label for="insight" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Insight :</strong></label>
          <textarea id="" cols="55" rows="3" name="insight" class="form-control"></textarea>
        </td>

        <td>
          <label for="Foresight" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Cognition:</strong></label>
          <textarea id="" cols="55" rows="3" name="fores" class="form-control"></textarea>
        </td>
      </tr>


      <tr>

        <td style="width:200px;">
          <label for="degree" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;">Folstein's degree:</strong>
            <pre></pre>
          </label>
          <input type="number" id="degree" name="degree" class=" form-control " />
        </td>

        <td>
          <label for="Basic" style="background-color:#007ce2;" class=" form-control "> <strong style="color:white;">
              Provisional diagnosis:</strong></label>
          <textarea id="" cols="55" rows="3" name="basic_dig" class="form-control"></textarea>
        </td>

        <td colspan='2'>
          <label for="Differential" style="background-color:#007ce2;" class=" form-control "> <strong
              style="color:white;"> Differential diagnosis:</strong></label>
          <textarea id="" cols="125" rows="3" name="diff_dig" class="form-control"></textarea>
        </td>
      </tr>






    </table>

    <table class="table table-striped table-bordered table-hover table-active table-dark" cellspacing="15"
      cellpadding="0">
      <tr>

        <td>
          <input class="btn btn-success form-control " type="submit" value="Add session" title="اضافة جلسة"
            name="addsess" />
        </td>
        <td>
          <input class="btn btn-danger form-control " name="btn" type="button"
            onclick="window.location.href='dctor_blood_chooes.php'" title=" مختبر الدم " value="Blood" />
        </td>
        <td>
          <input class="btn btn-info form-control " name="btn" type="button"
            onclick="window.location.href='dctor_chosse_nafsy.php'" title=" المختبر النفسي " value="Psychological" />
        </td>
        <td>
          <input class="btn btn-warning form-control " name="btn" type="button"
            onclick="window.location.href='medi.php'" title=" وصفة طبية " value="Medical Description" />
        </td>
      </tr>
    </table>

  </main>
</form>
<footer>

</footer>

</body>

</html>