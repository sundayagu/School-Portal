<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-3 col-sm-3">
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
<article class="col-lg-8 col-lg-offset-1 col-sm-8 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Student Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
            
    <?php
    include_once("includes/form_functions.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted
  
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('session', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
           redirect_to("editcoureg1.php");
        }
    
        // clean up the form data before putting it in the database
        $dept = $_SESSION['dept_code'];
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        
        $deptdisplay = get_department_by_deptcode($dept);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);
        
        $sessdisplay = get_session_by_sesscode($session);
        $semedisplay = get_semester_by_id($semester);

        // Retrieve student records from course registration table database.
            $table_reg = $dept . "cr";
            $table_course = $dept . "c";

        
            $regrow = get_student_records_byRegnoSessionSemester1_or_2($table_reg, $_SESSION['username'], $session, $semester);

            $sex_type = $regrow['stu_sex'];
            $level_type = $regrow['level_type'];
            $levedisplay = get_level_by_id($level_type);
            $sexdisplay = get_sex_by_id($sex_type);
                                   
    ?>
        <h3>Edit Course Registration: &nbsp;&nbsp;<?php echo $_SESSION['username'] ; ?></h3>
        <table cellspacing="2" style=width:100%;>
            <tr><td><b>Name:</b>&nbsp;&nbsp;<?php echo trim($_SESSION['stu_name']); ?></td>
                <td><b>Sex:</b>&nbsp;&nbsp;<?php echo $sexdisplay['sex_name']; ?></td>
                <td><b>Level:</b>&nbsp;&nbsp;<?php echo trim($levedisplay['level_name']); ?> </td></tr>
            <tr><td><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']); ?></td>
                <td><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']); ?></td>
                <td><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ?></td>
                <td><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']); ?></td>
            </tr>
        </table> 
        <br/> 
        <p>Correct course registration by re_tick the correct courses</p>    
        
    <?php
        
        /* get the selected departmental courses (to be used in creating the Courses Form to be filled. The counter $sn represents the course fields and serial number .) */

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

            $sn = $course_start_id;  // represents the course columns. its also used for serial number
                                  // for the 1st semester only
            $i = 1; // represents the serial number, to be used for the second semester only.
    
        switch ($semester) {
            case $semester == 1:
                echo " <form action=\"editcoureg3.php?course_start_id=$course_start_id&table_reg=$table_reg&course_count=$total_course_semester1_count&table_course=$table_course&session=$session&semester=$semester   \" method=\"post\"> ";  
       
                echo " <table border=\"1\" style=\"width:100%\"> ";
                echo " <tr>";
                        echo "<th>S/N</th>";
                        echo "<th>Tick</th>";
                        echo "<th>Course Code</th>";
                        echo "<th>Course Title</th>";
                        echo "<th>Credit Units</th>";
                echo " </tr> ";
                while($course = mysql_fetch_array($course_set)){
                    $course_column = 'c' . $sn;
                    echo " <tr>  ";
                        echo " <td>{$sn}</td> ";
                        echo " <td><input type=\"checkbox\" name=\"$sn\"  ";
                             if($regrow[$course_column] == 1){
                                  echo " checked"; 
                               } 
                        echo "/></td> ";
                        echo " <td>{$course['course_code']}</td> ";
                        echo " <td>{$course['course_title']}</td> ";
                        echo " <td>{$course['credit_unit']}</td> ";
                    echo " </tr> ";
                    $sn = $sn + 1;
                }
                echo " </table> ";
                echo "</br>";
                echo " <p><input type=\"submit\" name=\"submit2\" value=\"Continue to Step 3 of 3\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"students.php\">Return to Menu</a></p> ";
                echo " </form> ";

            break;

            case $semester == 2:
                echo " <form action=\"editcoureg3.php?course_start_id=$course_start_id&table_reg=$table_reg&course_count=$total_course_semester2_count&table_course=$table_course&session=$session&semester=$semester   \" method=\"post\"> ";  
       
                echo " <table border=\"1\" style=\"width:100%\"> ";
                echo " <tr>";
                        echo "<th>S/N</th>";
                        echo "<th>Tick</th>";
                        echo "<th>Course Code</th>";
                        echo "<th>Course Title</th>";
                        echo "<th>Credit Units</th>";
                echo " </tr> ";
                while($course = mysql_fetch_array($course_set)){
                    $course_column = 'c' . $sn;
                    echo " <tr>  ";
                        echo " <td>{$i}</td> ";
                        echo " <td><input type=\"checkbox\" name=\"$sn\"  ";
                             if($regrow[$course_column] == 1){
                                  echo " checked"; 
                               } 
                        echo "/></td> ";
                        echo " <td>{$course['course_code']}</td> ";
                        echo " <td>{$course['course_title']}</td> ";
                        echo " <td>{$course['credit_unit']}</td> ";
                    echo " </tr> ";
                    $sn = $sn + 1;
                    $i = $i + 1;
                }
                echo " </table> ";
                echo "</br>";
                echo " <p><input type=\"submit\" name=\"submit2\" value=\"Continue to Step 3 of 3\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"students.php\">Return to Menu</a></p> ";
                echo " </form> ";

            break;

            default:
                # code...
                break;

        }
       
    ?>
</article>

<?php require("includes/footer.php"); ?>