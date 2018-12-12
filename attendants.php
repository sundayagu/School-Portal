<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header_print.php"); ?>
<!--<aside class="col-lg-4 col-sm-4 col-xs-1">
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_hod1.php">Edit Hods's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <!--<li><a href="assigncou1.php">Assign Courses</a></li>
                <li>&nbsp;</li>
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
-->
<div class="col-sm-2">
</div>
<!--<article class="col-lg-10 col-sm-6 col-xs-6">-->
<article class="col-lg-8">
    <!--<ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="staff.php">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>-->
            
    <?php include_once("includes/form_functions.php"); ?>
    
    <?php 

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        //$required_fields = array('dept', 'session', 'level_type', 'semester', 'ccode');
        $required_fields = array('session', 'level_type', 'semester', 'ccode');
        $errors = array_merge($errors, check_required_fields($required_fields));
       
        // clean up the form data before putting it in the database
        //$dept = trim(mysql_prep($_POST['dept']));
        $dept = $_SESSION['dept_code'];
        $session = trim(mysql_prep($_POST['session']));
        $level_type = trim(mysql_prep($_POST['level_type']));
        $semester = trim(mysql_prep($_POST['semester']));
        $ccode = trim(mysql_prep($_POST['ccode']));

        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){

            $deptdisplay = get_department_by_deptcode($dept);
            $sessdisplay = get_session_by_sesscode($session);
            $levedisplay = get_level_by_id($level_type);
            $semedisplay = get_semester_by_id($semester);

            $table_course = $dept . "c";
            $course = get_department_course_by_coursecode($table_course, $ccode);
            $course_column = 'c' . $course['course_id'];
           

           
            ?>
        <!-- Display Headings -->
         <center>
         <table cellspacing="2" style=width:70%;>
            <tr>
                <td><h4 style="color:red">Attendants Form:&nbsp;&nbsp;<?php echo $course['course_code']  ?>
                        &nbsp;&nbsp;<?php echo $course['course_title'] ; ?>
                    </h4>
                </td>
            </tr>
            <tr>
                <td><h4 style="color:blue"> Session:&nbsp;<?php echo trim($sessdisplay['session_title']) ; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Semester:&nbsp;<?php echo trim($semedisplay['semester_name']) ; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Level:&nbsp;<?php echo trim($levedisplay['level_name']) ; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                    </h4>
                </td>
            </tr>
         </table>
         </center> 
        <!-- <br/>  -->
        <?php
                                
            $table_reg = $dept . 'cr';
                            
                echo "<table border=\"1\" style=\"width:100%\">";
                // display headings 
                    echo "<tr>";
                        echo "<th style='background:yellow'>S/N</th>";
                        echo "<th style='width:30%; background:yellow'>NAME OF CANDIDATE</th>";
                        echo "<th style='width:20%; background:yellow'>REG NO.</th>";
                        echo "<th style='background:yellow'>Sign in</th>";
                        echo "<th style='background:yellow'>Sign out</th>";
                    echo "</tr>";
                // display the body
                    //$student_set = get_students_who_registered_for_a_course($table_reg, $course_column);
                    $student_set = get_all_students_who_registered_for_a_course_by_session_by_semester_by_courseColumn($table_reg, $session, $semester, $course_column);
                    $sn = 1;

             
                    while($student = mysql_fetch_array($student_set)){
                        
                        if($student[$course_column] == 1){
                            echo "<tr>";
                                echo "<td> $sn </td>";
                                echo "<td> {$student['stu_name']} </td>";
                                echo "<td> {$student['regno']} </td>";
                                echo "<td></td>";
                                echo "<td></td>";
                        }
                         $sn = $sn + 1;

                    }
                    
                echo "</table>";
                

        }else{  // empty(errors)
            echo "Please select all information.<br/><br/>";
            echo "<a href=\"attendants.php\">Try Again</a>";
        } // ends empty(errors)
        echo "<br/><br/>";
        echo "<a href=\"hods.php\">Return to Hod's Menu</a>";
    }else{
    ?>
        <form action="attendants.php" method="post">
            <h3 style="color:red">Generate Attendants Form</h3>
            <p style="color:blue"><b><em>Select Departmental Information</em></b></p>
            <br/>
           <!-- <p>
            Department:
            
                <select name="dept">
                    <option value="">Select Department</option>
                    <option value="csc">Computer Science</option>
                    <option value="mcb">Micro Biology</option>
                    <option value="inc">Industrial Chemistry</option>
                    <option value="bch">Bio Chemistry</option>
                </select>
            </p>-->
            <?php page_form(); ?>
            <br/>
            <p>
              Level: 
                 <select name="level_type">
                    <option value="">Select level</option>
                    <option value="1">100</option>
                    <option value="2">200</option>
                    <option value="3">300</option>
                    <option value="4">400</option>
                    <option value="5">500</option>
                    <option value="6">600</option>
                 </select>
            </p>
            <p>Course Code:<input type="text" name="ccode" value="" /></p>
            <br/>
            <p><input type="submit" name="submit" value="view" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"hods.php\">Return to Hod's Menu</a>"; ?></p>
        </form> 
    <?php
    } // ends if(isset($_POST['submit']))
    ?> 
 </article>
 <div class="col-sm-2">
</div>

<?php require("includes/footer.php"); ?>