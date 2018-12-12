<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_lecturers(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-3 col-sm-3">
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
<article class="col-lg-8 col-lg-offset-1 col-sm-8 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
            
    <?php
    include_once("includes/form_functions_processing.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted
  
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('dept', 'session', 'semester', 'ccode');
        $errors = array_merge($errors, check_required_fields($required_fields));

        $fields_with_lengths = array('ccode' => 6);
        $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
            echo "<br/>Please Select all the information !!!<br/><br/>";
            echo "<a href=\"enterca_exam.php\">Try Again</a>";
            //redirect_to("enterca_exam.php");
        } else {
    
        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        $ccode = trim(mysql_prep($_POST['ccode']));
        
        // Get this Course record ($ccode) from Course table and declaring the variables  
        // for filtering of this Course scores from Transaction Result table and
        // for entering of the same Course scores into the same Transaction Result table
            $table_course = $dept . "c";
            $course = get_department_course_for_enterca_exam_by_coursecode($table_course, $ccode, $_SESSION['username'], $session);

            $level_type = $course['level_type'];
            $ca = 'a' . $course['course_id'];
            $exam = 'e' . $course['course_id'];
            $course_column = 'c' . $course['course_id'];  // to be used for course total
            $grade = 'g' . $course['course_id'];
            $remark = 'r' . $course['course_id'];

            // use cordinator & modulator username from the course table to fetch  their names from users_lecturer table.
            $cusername = 'username' . $session;  // declare variables for fields in course table
            $musername = 'musername' . $session;

            $cor_username = $course[$cusername]; // extract the values of the fields.
            $mod_username = $course[$musername];

            //echo $cor_username;  // will give STF/16/002
            //echo $mod_username;

            $table_user = 'users_lecturer';
            
            $query = get_record_by_username($table_user, $cor_username);
            $cuser = mysql_fetch_array($query);
            $cusername = $cuser['lec_name'];    // get the name from the users table.

            $query = get_record_by_username($table_user, $mod_username);
            $muser = mysql_fetch_array($query);
            $musername = $muser['lec_name'];    // get the name from the users table.
           
           // echo $cusername;
           // echo $musername;

            $deptdisplay = get_department_by_deptcode($dept);

            $faculty_type = $deptdisplay['faculty_type'];
            $facudisplay = get_faculty_by_id($faculty_type);

            $sessdisplay = get_session_by_sesscode($session);
            $levedisplay = get_level_by_id($level_type);
            $semedisplay = get_semester_by_id($semester);


    ?>
        <h3 style="color:red">CA and Exam Input Form: &nbsp;&nbsp;<?php echo $course['course_code'] . "  " . $course['course_title'] ; ?></h3>
        <table cellspacing="2" style=width:100%;>
            <tr><td><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']) ; ?></td>
                <td><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']); ?></td>
                <td><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']); ?></td>
            </tr>
            <tr><td><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']) ; ?></td>
                <td><b>Level:</b>&nbsp;&nbsp;<?php echo trim($levedisplay['level_name']) ?></td>
                <td><b>Cordinator:</b>&nbsp;&nbsp;<?php echo $cusername ?></td>
            </tr>
            <tr><td><b>Credit Units:</b>&nbsp;&nbsp;<?php echo $course['credit_unit'] ; ?></td>
                <td>&nbsp;&nbsp;</td>
                <td><b>Moderator:</b>&nbsp;&nbsp;<?php echo $musername ?></td>
            </tr>
        </table> 
        <br/> 
        <p style="color:blue"><b><em>Please, Enter CA or Exam scores for the following students:</em></b></p>    
        
    <?php

        // declare table Course Registration & Transaction Result variables to be used
            $table_reg = $dept . "cr";
            $table_tra = $dept . "tra";

        // Get students who registered for the course for the session & semester from 
        // Course_Registration table
        $student_set = get_all_students_who_registered_for_a_course_by_session_by_semester_by_courseColumn($table_reg, $session, $semester, $course_column);
             
        echo " <form action=\"enterca_exam3.php?dept=$dept&session=$session&semester=$semester&course_column=$course_column&ca=$ca&exam=$exam   \" method=\"post\"> ";
        echo " <table border=\"1\" style=\"width:100%\"> ";
        echo " <tr>";
            echo "<th>S/N</th>";
            echo "<th>Registration Number</th>";
            echo "<th>CA</th>";
            echo "<th>Exam</th>";
            echo "<th>Total</th>";
            echo "<th>Grade</th>";
            echo "<th>Remark</th>";
        echo " </tr> ";
        
        
        // list the students who registered for the course for entering of their CAs and Exam scores.
        $sn = 1;
        while($student = mysql_fetch_array($student_set)){ 
             
             /* Declare this student's regno variable to be used in getting this student's record from 
                Transaction Result table for entering of this student's CA and Exam scores and displaying of 
                his total, grade and remarks */

            $reg = $student['regno'];
            
            /* Get this student's record from Transaction Result table based on regno, session and semester,
               and select only the regno, ca, exam, total, grade, and remarks of the Course in question */
            //this function get_student_examca_entry_record() is replaced as below to cater for semesters 1 and 2
            $student_rec = get_student_records_byRegnoSessionSemester1_or_2($table_tra, $reg, $session, $semester);
                       
            $stuca_row = 'ca' . $sn;        // $stuca_row stands for Student CA score row of the students from 1 to $sn
            $stuexam_row = 'exam' . $sn;    // $stuexam_row stands for Student Exam score row
            echo " <tr>  ";
                echo " <td>{$sn}</td> ";
            ?>  
                <td><?php echo $student_rec['regno']; ?></td>
                <td><input type="text" name="<?php echo $stuca_row; ?>" maxlength="2" value=" <?php  echo $student_rec[$ca]; ?>" /></td>
                <td><input type="text" name="<?php echo $stuexam_row; ?>" maxlength="2" value=" <?php echo $student_rec[$exam]; ?>" /></td>
               <td><?php echo $student_rec[$course_column]; ?></td>
               <td><?php echo $student_rec[$grade]; ?></td>
               <td><?php echo $student_rec[$remark]; ?></td>
                              
                <?php
            echo " </tr> ";

            $sn = $sn + 1;
        }
        echo " </table> ";
        echo "</br>";
        echo " <p><input type=\"submit\" name=\"submit2\" value=\"Continue to Step 3 of 3\" /></p> ";
        echo " </form> ";
        echo "<a href=\"enterca_exam.php\">cancel</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"lecturers.php\">Return to Lecturers Menu</a>

        ";
    } //end if(!empty($errors)) 
    ?>

</article>

<?php require("includes/footer.php"); ?>