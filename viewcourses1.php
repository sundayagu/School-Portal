<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
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
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Student's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">View Registered Courses</h3>


    <?php

        $check = $_SESSION['sflag'];
        //echo $check;
        if ($check == 'sf') {

    ?>

        
    <?php
    include_once("includes/form_functions_viewing.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('session', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // clean up the form data before putting it in the database
        $dept = $_SESSION['dept_code'];
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));

        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){

            // get student's record for registered courses
            $table = $dept . "cr";
            if($regrow = get_student_records_byRegnoSessionSemester1_or_2($table, $_SESSION['username'], $session, $semester)){
                $level_type = $regrow['level_type'];
                $sex_type = $regrow['stu_sex'];

            // change path to match image directory
            $dir = 'http://localhost/southingam/img/' . $table . '/';
            
            $deptdisplay = get_department_by_deptcode($dept);

            $faculty_type = $deptdisplay['faculty_type'];
            $facudisplay = get_faculty_by_id($faculty_type);

            $sessdisplay = get_session_by_sesscode($session);
            $levedisplay = get_level_by_id($level_type);
            $semedisplay = get_semester_by_id($semester);
            $sexdisplay = get_sex_by_id($sex_type);
            ?>
            <!-- Display Headings -->
             <table cellspacing="2" style=width:100%;>
                <?php // echo '<tr><img src="' . $dir . $regrow['coursereg_id'] . '.jpg" /></tr>' ; ?>
                <tr><td><p><b>Regno:</b>&nbsp;&nbsp;<?php echo $regrow['regno']; ?></p>
                        <p><b>Name:</b>&nbsp;&nbsp;<?php echo $regrow['stu_name']; ?></p>
                        <p><b>Sex:</b>&nbsp;&nbsp;<?php echo $sexdisplay['sex_name']; ?></p>
                    </td>
                    <td>
                        <p><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']) ; ?></p>
                        <p><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']) ; ?></p>
                        <p><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ; ?></p>

                    </td>
                    <td>
                        <p><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']) ; ?></p>
                        <p><b>Level:</b>&nbsp;&nbsp;<?php echo trim($levedisplay['level_name']) ; ?></p>

                    </td>
                    <?php echo '<td><img src="' . $dir . $regrow['coursereg_id'] . '.jpg" /></td>' ; ?>
                </tr>
                
                </table> 
                 <br/>
            <table border="1" style="width:100%">
                <tr>
                    <th style="background:yellow">S/N</th>
                    <th style="background:yellow">Course Code</th>
                    <th style="background:yellow">Course Title</th>
                    <th style="background:yellow">Credit Units</th>
                </tr> 


            <?php  
            // get all departmental courses for the semester (to help get total number of courses for loop)
            $table_course = $dept . "c";

            // finding where the total of a semester's courses will end.
           $course_set = get_all_department_courses_by_semester($table_course, 1);
           $course_semester1_count = mysql_num_rows($course_set);
           $course_set = get_all_department_courses_by_semester($table_course, 2);
           $course_semester2_count = mysql_num_rows($course_set);

           $total_course_semester1_count = $course_semester1_count;
           //echo $total_course_semester1_count . "<br/>";
           $total_course_semester2_count = $total_course_semester1_count + $course_semester2_count;
           //echo $total_course_semester2_count . "<br/>";

            // get the start course column from the course table and initialize the course_id to begin from.
            $cou_start = get_start_course_by_semester($table_course, $semester);
            $course_start_id = $cou_start['course_id'];
            //echo $course_start_id;
        
            //get the courses for the semester
            $course_set = get_all_department_courses_by_semester($table_course, $semester);
            $course_count = mysql_num_rows($course_set);

            $sn = $course_start_id;  // represents the starting course column for each semester. its also used for serial number for the 1st semester only
            $i = 1; // represents the serial number, to be used for the second semester only.

            switch ($semester){
                case $semester == 1:
            
                    for($count=$sn; $count <= $total_course_semester1_count; $count++){
                        $course_column = "c" . $count;
                        if($regrow[$course_column] == 1){
                            $courserow = get_course_details($table_course, $count);
                            ?>
                            <tr>
                                <td><?php echo $sn; ?></td>
                                <td><?php echo $courserow['course_code']; ?></td>
                                <td><?php echo $courserow['course_title']; ?></td>
                                <td>&nbsp;&nbsp;&nbsp;<?php echo $courserow['credit_unit']; ?></td>
                            </tr>
                            <?php
                            $sn = $sn + 1;
                        }
                    } // ends forloop

                    ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color:blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Credit units</b> </td>
                            <td>&nbsp;&nbsp;&nbsp;<b><?php echo $regrow['totalcredit']; ?></b></td>
                        </tr>
                    </table>

                    <?php 

                break;

                case $semester == 2:
                    for($count=$course_start_id; $count <= $total_course_semester2_count; $count++){
                        $course_column = "c" . $count;
                        if($regrow[$course_column] == 1){
                            $courserow = get_course_details($table_course, $count);
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $courserow['course_code']; ?></td>
                                <td><?php echo $courserow['course_title']; ?></td>
                                <td>&nbsp;&nbsp;&nbsp;<?php echo $courserow['credit_unit']; ?></td>
                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                    } // ends forloop

                    ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color:blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Credit units</b> </td>
                            <td><b>&nbsp;&nbsp;&nbsp;<?php echo $regrow['totalcredit2']; ?></b></td>
                        </tr>
                    </table>

                    <?php 

                break;

                default:
                    #code;
                break;

            } //ends switch ($semester)

                    ?>

            <br/>
            <p>Click <a href="students.php">Return to Menu</a></p>
            <!--          <p>Click <a href="deletecoureg.php?table=<?php echo $table; ?>&r=<?php echo urlencode($regrow['regno']); ?>" 
            onclick="return confirm('Are you sure?');">Delete</a> to delete the record</p> -->
        <?php
        }else{
            echo "Registration Number does not exist or the Student has not registered courses <br/><br/>";
            echo "<a href=\"viewcourses1.php\">Try again</a>";
        }
          
        }else{  // empty(errors)
            echo "Please select all information and check your registration number <br/><br/>";
            echo "<a href=\"viewcourses1.php\">Try Again</a>";
        } // ends empty(errors)

    } else {  // isset($_POST['submit'])
    ?>    
	    <form action="viewcourses1.php" method="post">
	    	<br/>
            <p style="color:blue"><b><em>Please select academic session and semester</em></b></p>
            <br/>
            <?php page_form(); ?>
            <br/>
            <p><input type="submit" name="submit" value="view" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"students.php\">Return to Students Menu</a>"; ?></p>
		</form>
	<?php }; // ends isset($_POST['submit'] ?>
</article>

<?php

        }else{
            //echo "<br/>";
            echo "Access Denied --- Checking of Registered Courses is meant for Students only !!! <br/><br/>";
            echo "<a href='lecturers.php'>Return to menu</a>";

        }
    ?>

<?php require("includes/footer.php"); ?>