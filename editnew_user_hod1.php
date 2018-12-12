<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_hod1.php">Edit Hods's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <!--<li><a href="assigncourse.php">Assign Courses</a></li>
                <li>&nbsp;</li>-->
                <li><a href="attendants.php">Generate Attendants Sheets</a></li>
                <li>&nbsp;</li>
                <li><a href="searchStudents.php">Search Students Data</a></li>
                <li>&nbsp;</li>
                <li><a href="searchResults1.php">Search Students Results</a></li>
                <li>&nbsp;</li>
                <li><a href="viewlevelcourses.php">Check Registered Departmental Level Courses</a></li>
                <li>&nbsp;</li>
                <li><a href="viewgroupresult.php">Check Class Results</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="#">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="#">HOD's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Edit HOD's Acount User Profile:<br/>
    ==========================</h3><br/>
    <?php
        //$regno = $_SESSION['username'];
        $username = $_SESSION['username'];
        $table_user = 'users_hod';
        
        /*$query = "SELECT * ";
            $query .= "FROM users_lecturer ";
            $query .= "WHERE username = '{$regno}' ";
            $query .= "LIMIT 1";
            $result_set = mysql_query($query);
            confirm_query($result_set); */


           $user = get_record_by_username($table_user, $username);

            //$lecturer = mysql_fetch_array($user);
             $hod = mysql_fetch_array($user);

            //$pnum = $hod['pnum'];
            $sex = $hod['hod_sex'];
            $session = $hod['adm_sess'];
            $dept = $hod['dept_code'];
            
            $deptdisplay = get_department_by_deptcode($dept);
            $sexdisplay = get_sex_by_id($sex);
            $sessdisplay = get_session_by_sesscode($session);
    ?>
  
    <form action="editnew_user_hod2.php?username=<?php echo $username; ?>" method="post">
              <table>
                 <tr>
                    <td><strong>Name:</strong></td>
                    <td><?php echo $hod['hod_name']; ?></td>
                 </tr>
                 <tr>
                    <td><br /><b>Gender:</b> </td>
                    <td><br /><?php echo trim($sexdisplay['sex_name']); ?></td>
                 </tr>
                 <tr>
                    <td><br/><b>Username: </b></td>
                    <td><br /><?php echo strtoupper($username); ?></td>
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
                    <td><br /><input type="text" name="pnum" maxlength="11" value="<?php echo $hod['pnum']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>Email Address: </b></td>
                    <td><br /><input type="text" name="email" maxlength="40" value="<?php echo $hod['email']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b><p style="color:blue"><strong><em>Password recovery questions:</em></strong></p></b><b> What is your Father's middle name </b> </td>
                    <td><br /><br/><input type="text" name="answer1" maxlength="15" value="<?php echo $hod['answer1']; ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>What is the name of your mother's Father village</b> </td>
                    <td><br /><input type="text" name="answer2" maxlength="15" value="<?php echo $hod['answer2']; ?>" /></td>
                 </tr>
                 <tr>
                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"hods.php\">Return to HOD's Menu</a>"; ?></td>
                 </tr>    
              </table>
          </form>
    
</article>

<?php require("includes/footer.php"); ?>