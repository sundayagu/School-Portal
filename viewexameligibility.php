<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header.php"); ?>
<!--<aside class="col-lg-3 col-sm-2 col-xs-6">
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <ul>
                <li><a href="login_students.php">Login / Complete Students User Account</a></li>
                <li>&nbsp;</li>
                <li><a href="editnew_user_student1.php">Edit Student's  Users Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="pwordrset1.php">Forget Password</a></li>
                <li>&nbsp;</li>
                <li><a href="createcoureg1.php">Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="editcoureg1.php">Edit Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcourses1.php">View Registered courses</a></li>
                <li>&nbsp;</li>
                <li><a href="viewexameligibility.php">Check Examinations Eligibility</a></li>
                <li>&nbsp;</li>
                <li><a href="viewindividualresult.php">Check Results Per Semester</a></li>
                <li>&nbsp;</li>
                <li><a href="viewstatementofresult_tra.php">Check Results Per Sesssion</a></li>
                <li>&nbsp;</li>
                <li><a href="trackindividualresults.php">Check All Sessions Results</a></li>
                
            </ul>
            </ul>
        </div>
    </div>   
</aside>-->
<aside class="col-lg-4 col-sm-6">
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
                <li><a href="pwordrset1.php">Forget Password</a></li>
                <li>&nbsp;</li>
                <li><a href="createcoureg1.php">Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="editcoureg1.php">Edit Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcourses1.php">View Registered courses</a></li>
                <li>&nbsp;</li>
                <li><a href="viewexameligibility.php">Check Examinations Eligibility</a></li>
                <li>&nbsp;</li>
                <li><a href="viewindividualresult.php">Check Results Per Semester</a></li>
                <li>&nbsp;</li>
                <li><a href="viewstatementofresult_tra.php">Check Results Per Sesssion</a></li>
                <li>&nbsp;</li>
                <li><a href="trackindividualresults.php">Check All Sessions Results</a></li>
                
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-8 col-sm-6">
    <ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="#">Students Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
            
    <?php include_once("includes/form_functions.php"); ?>
    
    <?php 

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('session', 'semester', 'ccode');
        $errors = array_merge($errors, check_required_fields($required_fields));
       
        // clean up the form data before putting it in the database
        $dept = $_SESSION['dept_code'] ;
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        $ccode = trim(mysql_prep($_POST['ccode']));

        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){

            $deptdisplay = get_department_by_deptcode($dept);
            $sessdisplay = get_session_by_sesscode($session);
            $semedisplay = get_semester_by_id($semester);

            $table_course = $dept . "c";
            $course = get_department_course_by_coursecode($table_course, $ccode);
            $course_column = 'c' . $course['course_id'];
            $level_type = $course['level_type'];
           
            $levedisplay = get_level_by_id($level_type);
           
           echo "<center>";
            ?>
        <!-- Display Headings -->
         
         <table border="0" cellspacing="2" style=width:100%;>
            <tr>
                <td><h3 style='color:red'>Examination Eligibility:</h3>
                    <h4 style='color:blue'><?php echo $course['course_code'] ; ?>
                        &nbsp;&nbsp;<?php echo $course['course_title'] ; ?>
                    </h4>
                </td>
            </tr>
            <tr>
                <td><h4> Session:&nbsp;<?php echo trim($sessdisplay['session_title']) ; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Semester:&nbsp;<?php echo trim($semedisplay['semester_name']) ; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;<?php echo trim($levedisplay['level_name']) ; ?> Level&nbsp;Course 
                        
                    </h4>
                </td>
            </tr>
         </table>
         
        <!-- <br/>  -->
        <?php
        
                                
            $table_reg = $dept . 'cr';
                            
                echo "<table border=\"1\" style=\"width:100%\">";
                // display headings 
                    echo "<tr>";
                        echo "<th style='background:yellow'>S/N</th>";
                        echo "<th width='50%' style='background:yellow'>NAME OF CANDIDATE</th>";
                        echo "<th style='background:yellow'>REG NO.</th>";
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
                        }
                         $sn = $sn + 1;

                    }
                    
                echo "</table>";
           
            
           
           echo "</center>";




        }else{  // empty(errors)
            echo "Please select all information.<br/><br/>";
            echo "<a href=\"viewexameligibility.php\">Try Again</a>";
        } // ends empty(errors)

        echo "<br/><br/>";
            echo "<a href=\"students.php\">Return to Students Menu</a>";
            
        
    }else{
    ?>
        <form action="viewexameligibility.php" method="post">
            <h3 style='color:red'>Check your eligibility for the Course</h3>
            <p style='color:blue'><b><em>Select Departmental Information</em></b></p>
            <br/>
            <?php page_form(); ?>
           <!-- <p>
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
            </p>-->
            <br/>
            <p>Course Code:<input type="text" name="ccode" value="" /></p>
            <p><input type="submit" name="submit" value="view" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"students.php\">Return to Students Menu</a>"; ?></p>
        </form>
        <br/>
        <a href="students.php">Cancel</a>
    <?php
    } // ends if(isset($_POST['submit']))
    ?> 
 </article>

<?php require("includes/footer.php"); ?>