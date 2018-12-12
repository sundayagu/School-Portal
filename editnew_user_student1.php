<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="login_students.php">Login / Complete Students User Account</a></li>
                <li>&nbsp;</li>
                <li><a href="editnew_user_student1.php">Edit Student's  Users Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="createcoureg1.php">Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="editcoureg1.php">Edit Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcourses1.php">View Registered courses</a></li>
                <li>&nbsp;</li>
                <li><a href="viewindividualresult.php">View Results for One Semester</a></li>
                <li>&nbsp;</li>
                <li><a href="trackindividualresults.php">View Results for All Sessions and Semesters</a></li>
                <li>&nbsp;</li>
                <li><a href=".php">View Statement of Results</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Student's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Edit Students Acount User Profile:<br/>
    ==========================</h3><br/>
    <?php
        $regno = $_SESSION['username'];
        $query = "SELECT * ";
            $query .= "FROM users_student ";
            $query .= "WHERE username = '{$regno}' ";
            $query .= "LIMIT 1";
            $result_set = mysql_query($query);
            confirm_query($result_set);
            $student = mysql_fetch_array($result_set);

            $pnum = $student['pnum'];
            $sex = $student['stu_sex'];
            $session = $student['adm_sess'];
            $dept = $student['dept_code'];
            
            $deptdisplay = get_department_by_deptcode($dept);
            $sexdisplay = get_sex_by_id($sex);
            $sessdisplay = get_session_by_sesscode($session);
    ?>
  
    <form action="editnew_user_student2.php?username=<?php echo $regno; ?>" method="post">
              <table>
                 <tr>
                    <td><strong>Name:</strong></td>
                    <td><?php echo $student['stu_name']; ?></td>
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
                    <td><br/><b>Admission Session:</b></td>
                    <td><br/><?php echo trim($sessdisplay['session_title']); ; ?></td>
                 </tr>
                 <tr>
                    <td><br/><b>Mobile Phone Number: </b></td>
                    <td><br /><input type="text" name="pnum" maxlength="11" value="<?php echo $student['pnum']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>Email Address: </b></td>
                    <td><br /><input type="text" name="email" maxlength="40" value="<?php echo $student['email']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b><p style="color:blue"><strong><em>Password recovery questions:</em></strong></p></b><b> What is your Father's middle name </b> </td>
                    <td><br /><br/><input type="text" name="answer1" maxlength="15" value="<?php echo $student['answer1']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>What is the name of your mother's Father village</b> </td>
                    <td><br /><input type="text" name="answer2" maxlength="15" value="<?php echo $student['answer2']; ?>" /></td>
                 </tr>
                 <tr>
                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit" /></td>
                 </tr>    
              </table>
          </form>
    
</article>

<?php require("includes/footer.php"); ?>