<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-3 col-sm-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="">Result Processing</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-8 col-lg-offset-1 col-sm-8 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Analyst Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
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
           redirect_to("processresult1.php");
        }
    
        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        $ccode = trim(mysql_prep($_POST['ccode']));
        
       // Retrieve and Display Course info from Course table database.
            $table_course = $dept . "c";
            $course = get_department_course_by_coursecode($table_course, $ccode);
            $ca = 'a' . $course['course_id'];
            $exam = 'e' . $course['course_id'];
            $course_column = 'c' . $course['course_id'];  // to be used for course total
            $grade = 'g' . $course['course_id'];
            $remark = 'r' . $course['course_id'];
            $level_type = $course['level_type'];

            $deptdisplay = get_department_by_deptcode($dept);

            $faculty_type = $deptdisplay['faculty_type'];
            $facudisplay = get_faculty_by_id($faculty_type);

            $sessdisplay = get_session_by_sesscode($session);
            $levedisplay = get_level_by_id($level_type);
            $semedisplay = get_semester_by_id($semester);

            $cordinator = 'cordinator' . $session;


    ?>
        <h3>Result Processing for the Course: &nbsp;&nbsp;<?php echo $course['course_code'] . "  " . $course['course_title'] ; ?></h3>
        <table cellspacing="2" style=width:100%;>
            <tr><td><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']) ; ?></td>
                <td><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']) ; ?></td>
                <td><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ?></td>
                <td><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']) ?></td>
            </tr>
            <tr><td><b>Credit Units:</b>&nbsp;&nbsp;<?php echo $course['credit_unit'] ; ?></td>
                <td><b>Level:</b>&nbsp;&nbsp;<?php echo trim($levedisplay['level_name']) ?></td>
                <td><b>Cordinator:</b>&nbsp;&nbsp;<?php echo $course[$cordinator] ?></td>
            </tr>
        </table> 
        <br/> 
        <p>Result Processing in progress, Please wait:</p>    

    <?php
        // Procesing Result for a Course starts here.
        // initialize tables
        $table_reg = $dept . 'cr';
        $table_result = $dept . 'tra';
        
        /* course_id from course table which has been retrieved willbe used in identifying the course in the 
           Transaction Result table.*/

        // (1) Retrieve Result records from the Transaction Result table for the session and semester 
            $student_set = get_records_by_SessionSemester($table_result, $session, $semester);
                                    
        // (2)  Determine Totalscore, Grade, Remark for each student in the Course Result and update their records.
            while($student = mysql_fetch_array($student_set)){
                $stu_regno = $student['regno'];

                // check if the student registered for the course. if yes process otherwise next student
                $regis = get_student_record_by_RegnoSessionSemesterCoursecolumn($table_reg, $stu_regno, $session, $semester, $course_column);
                if($sturow = mysql_fetch_assoc($regis)) { // if true
                    extract($sturow); // not needed though.

                        // process for the student
                        $total = $student[$ca] + $student[$exam];
                        $c = $student[$ca];  // to avoid over writing $ca. to be used in the 
                        $e = $student[$exam]; // to avoid over writing $exam. to be used in the last case structure
                        
                        switch ($total) {
                            case $total>69:
                                $gra = "A"; $rem = "EXCELLENT";
                                break;
                            case $total>59:
                                $gra = "B"; $rem = "GOOD";
                                break;
                            case $total>49:
                                $gra = "C"; $rem = "CREDIT";
                                break;
                            case $total>44:
                                $gra = "D"; $rem = "PASS";
                                break;
                            case $total>39:
                                $gra = "E"; $rem = "PASS";
                                break;
                            case ($total>=1) && (($e>0) && ($c>0)):
                                $gra = "F"; $rem = "FAIL";
                                break;

                            default:
                                $gra = "Review Scores"; $rem = "CHECK CA and EXAM SCORE";
                                break;
                        }
                        $query = "UPDATE $table_result SET 
                                    $course_column = '$total',
                                    $grade = '$gra',
                                    $remark = '$rem'
                                   WHERE regno = '$stu_regno' AND session = '$session' AND (semester = '$semester' OR semester2 = '$semester') ";
                        $result = mysql_query($query, $connection) or die('Result Processing failed' . mysql_error($connection));
            
                } // otherwise  


            } // next student.
            echo "<br/>Processing completed successfully<br/><br/>";
            echo "<a href=\"processresult1.php\">Continue with processing results</a><br/><br/>";
            echo "<a href=\"index.php\">Return to Home</a>";
            // total = '{$student['ca']}' + '{$student['exam']}',
    ?>
</article>

<?php require("includes/footer.php"); ?>