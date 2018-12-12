<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_lecturers(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_lecturer1.php">Edit Lecturer's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="enterca_exam.php">Enter CA / Exam Scores</a></li>
                <li>&nbsp;</li>
                <li><a href="enterca_exam.php">Edit CA / Exam Scores</a></li>
                <li>&nbsp;</li>
                <li><a href="#.php">Modulate Result</a></li>
                <li>&nbsp;</li>
                <li><a href="viewgroupresult.php">Check Class(Level) Result</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="#">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="#">Lecturer's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Edit Lecturer's Acount User Profile:<br/>
    ==========================</h3><br/>
    <?php
        $regno = $_SESSION['username'];
        $query = "SELECT * ";
            $query .= "FROM users_lecturer ";
            $query .= "WHERE username = '{$regno}' ";
            $query .= "LIMIT 1";
            $result_set = mysql_query($query);
            confirm_query($result_set);
            $lecturer = mysql_fetch_array($result_set);

            $pnum = $lecturer['pnum'];
            $sex = $lecturer['lec_sex'];
            $session = $lecturer['adm_sess'];
            $dept = $lecturer['dept_code'];
            
            $deptdisplay = get_department_by_deptcode($dept);
            $sexdisplay = get_sex_by_id($sex);
            $sessdisplay = get_session_by_sesscode($session);
    ?>
  
    <form action="editnew_user_lecturer2.php?username=<?php echo $regno; ?>" method="post">
              <table>
                 <tr>
                    <td><strong>Name:</strong></td>
                    <td><?php echo $lecturer['lec_name']; ?></td>
                 </tr>
                 <tr>
                    <td><br /><b>Gender:</b> </td>
                    <td><br /><?php echo trim($sexdisplay['sex_name']); ?></td>
                 </tr>
                 <tr>
                    <td><br/><b>Username: </b></td>
                    <td><br /><?php echo strtoupper($regno); ?></td>
                 </tr>
                 <tr>
                    <td><br/><b>Department:</b></td>
                    <td><br/><?php echo trim($deptdisplay['dept_name']) ; ?></td>
                 </tr>
                 <tr>
                    <td><br/><b>Year of Appointment:</b></td>
                    <td><br/><?php echo trim($sessdisplay['session_title']); ; ?></td>
                 </tr>
                 <tr>
                    <td><br/><b>Mobile Phone Number: </b></td>
                    <td><br /><input type="text" name="pnum" maxlength="11" value="<?php echo $lecturer['pnum']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>Email Address: </b></td>
                    <td><br /><input type="text" name="email" maxlength="40" value="<?php echo $lecturer['email']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b><p style="color:blue"><strong><em>Password recovery questions:</em></strong></p></b><b> What is your Father's middle name </b> </td>
                    <td><br /><br/><input type="text" name="answer1" maxlength="15" value="<?php echo $lecturer['answer1']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>What is the name of your mother's Father village</b> </td>
                    <td><br /><input type="text" name="answer2" maxlength="15" value="<?php echo $lecturer['answer2']; ?>" /></td>
                 </tr>
                 <tr>
                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"lecturers.php\">Return to Students Menu</a>"; ?></td>
                 </tr>    
              </table>
          </form>
    
</article>

<?php require("includes/footer.php"); ?>