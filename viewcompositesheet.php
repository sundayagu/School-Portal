<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_senates(); ?>`
<?php include("includes/header_print.php"); ?>



<article class="col-lg-12">
<style>
    table{
       font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
    }
</style>                
    <?php
    include_once("includes/form_functions_viewing.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('dept', 'session', 'semester', 'level');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        $level = trim(mysql_prep($_POST['level']));

        $deptdisplay = get_department_by_deptcode($dept);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);
        
        $sessdisplay = get_session_by_sesscode($session);
        $semedisplay = get_semester_by_id($semester);
        $levedisplay = get_level_by_id($level);

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
            echo "Please select all information <br/><br/>";
            echo "<a href=\"viewcompositesheet.php\">Try Again</a>";
        }else{
            
            // declare tables
            $table_course = $dept . 'c';
            $table_reg = $dept . 'cr';
            $table_tra = $dept . 'tra';

            // finding where the total of a level's course_column will end.
               $course_set = get_department_course_by_level_type_by_semester($table_course, 1, 1);
               $course_lev1_semester1_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 2, 1);
               $course_lev2_semester1_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 3, 1);
               $course_lev3_semester1_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 4, 1);
               $course_lev4_semester1_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 5, 1);
               $course_lev5_semester1_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 6, 1);
               $course_lev6_semester1_count = mysql_num_rows($course_set);
               
               $course_set = get_department_course_by_level_type_by_semester($table_course, 1, 2);
               $course_lev1_semester2_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 2, 2);
               $course_lev2_semester2_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 3, 2);
               $course_lev3_semester2_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 4, 2);
               $course_lev4_semester2_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 5, 2);
               $course_lev5_semester2_count = mysql_num_rows($course_set);
               $course_set = get_department_course_by_level_type_by_semester($table_course, 6, 2);
               $course_lev6_semester2_count = mysql_num_rows($course_set);

               $total_course_lev1_semester1_count = $course_lev1_semester1_count;
               $total_course_lev2_semester1_count = $total_course_lev1_semester1_count + $course_lev2_semester1_count;
               $total_course_lev3_semester1_count = $total_course_lev2_semester1_count + $course_lev3_semester1_count;
               $total_course_lev4_semester1_count = $total_course_lev3_semester1_count + $course_lev4_semester1_count;
               $total_course_lev5_semester1_count = $total_course_lev4_semester1_count + $course_lev5_semester1_count;
               $total_course_lev6_semester1_count = $total_course_lev5_semester1_count + $course_lev6_semester1_count;

               $total_course_lev1_semester2_count = $total_course_lev6_semester1_count + $course_lev1_semester2_count;       
               $total_course_lev2_semester2_count = $total_course_lev1_semester2_count + $course_lev2_semester2_count;
               $total_course_lev3_semester2_count = $total_course_lev2_semester2_count + $course_lev3_semester2_count;
               $total_course_lev4_semester2_count = $total_course_lev3_semester2_count + $course_lev4_semester2_count;
               $total_course_lev5_semester2_count = $total_course_lev4_semester2_count + $course_lev5_semester2_count;
               $total_course_lev6_semester2_count = $total_course_lev5_semester2_count + $course_lev6_semester2_count;
            
            // get the start course column from the course table and initialize the course_id to begin from.
            $cou_start = get_start_course_by_level_type_by_semester($table_course, $level, $semester);
            $course_start_id = $cou_start['course_id'];
            //echo $course_start_id;
            
            // Display headings
            ?>
            <table style="width:100%">
            
            <tr><td colspan="3" style="text-align:center; color:red"><h4><b>SOUTHINGAM UNIVERSITY, NIGERIA</b></h4></td>
            </tr>
            <tr><td colspan="3" style="text-align:center; color:blue"><h5><b>COMPOSITE RESULT SHEET</b></h5></td>
            </tr>
            <tr><td><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']) ; ?></td>
                <td><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']); ?></td>
                <td><b>Level:</b>&nbsp;&nbsp;<?php echo trim($levedisplay['level_name']) ; ?></td>
            </tr>
            <tr>
                <td><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ?></td>
                <td><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']) ?></td>
                <td></td>
            </tr>
            </table>
            <br/>

            <?php

            switch ($level) {
                case $level == 1 AND $semester == 1:
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;
                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev1_semester1_count);
                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {
                        $regno = $students['regno'];
                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);
                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";
                            for($i = $course_start_id; $i <= $total_course_lev1_semester1_count; $i++){
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>"; // include {$student[$grade]} if neede.
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                }

                        echo " </tr> ";
                            $sn = $sn  + 1;  // increment serial number
                    }
                                       
                    echo " </table> ";
                break;

                case $level == 2 AND $semester == 1:
                
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev2_semester1_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev2_semester1_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number

                    }

                                        
                    echo " </table> ";
                    
                break;

                case $level == 3 AND $semester == 1:
                
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev3_semester1_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev3_semester1_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number

                    }

                                        
                    echo " </table> ";
                    
                break;

                case $level == 4 AND $semester == 1:
                
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev4_semester1_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev4_semester1_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number
                    }
                                        
                    echo " </table> ";
                    
                break;

                case $level == 5 AND $semester == 1:
                  if ($dept != 'med'){
                          echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewcompositesheet.php\">Try Again</a>";
                        } else {
                
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev5_semester1_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev5_semester1_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number
                    }
                                        
                    echo " </table> ";
                   } // end if ($dept != 'med') 
                break;

                case $level == 6 AND $semester == 1:
                  if ($dept != 'med'){
                          echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewcompositesheet.php\">Try Again</a>";
                        } else {
                
                    $course_set = get_students_who_registered_for_departmental_level_courses($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_student_departmental_level_registered_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev6_semester1_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev6_semester1_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number
                    }
                                        
                    echo " </table> ";
                   } // end if ($dept != 'med') 
                break;

                case $level == 1 AND $semester == 2:

                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev1_semester2_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev1_semester2_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number

                    }
                                        
                    echo " </table> ";
                    
                break;

                case $level == 2 AND $semester == 2:

                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev2_semester2_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev2_semester2_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number

                    }
                                        
                    echo " </table> ";
                    
                break;
                
                case $level == 3 AND $semester == 2:

                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev3_semester2_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev3_semester2_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number

                    }
                                        
                    echo " </table> ";
                
                break;

                case $level == 4 AND $semester == 2:

                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev4_semester2_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev4_semester2_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number

                    }
                                        
                    echo " </table> ";
                    
                break;

                case $level == 5 AND $semester == 2:
                  if ($dept != 'med'){
                          echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewcompositesheet.php\">Try Again</a>";
                        } else {
                
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev5_semester2_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev5_semester2_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number
                    }
                                        
                    echo " </table> ";
                   } // end if ($dept != 'med') 
                break;

                case $level == 6 AND $semester == 2:
                  if ($dept != 'med'){
                          echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewcompositesheet.php\">Try Again</a>";
                        } else {
                
                    $course_set = get_department_course_by_level_type_by_semester($table_course, $level, $semester);
                    $course_count = mysql_num_rows($course_set);
                    //echo $course_count;

                    echo " <table border=\"1\" style=\"width:100%\"> ";
                    echo " <tr>";
                            echo "<th style=\"background:yellow\">S/N</th>";
                            echo "<th style=\"background:yellow\">Name</th>";
                            echo "<th style=\"background:yellow\">Regno</th>";
                            while ($course = mysql_fetch_array($course_set) ) {
                                echo "<th style=\"background:yellow\">{$course['course_code']}</th>";
                            }
                            //echo "<th>GPA</th>";
                    echo " </tr> ";

                    
                    $stu_records = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev6_semester2_count);

                    $stu_count = mysql_num_rows($stu_records);
                    //echo $stu_count;
                    $sn = 1;
                    while ($students = mysql_fetch_array($stu_records)) {

                        $regno = $students['regno'];

                        // Get Students result from Transaction Result table for the session and semester
                        $student = get_student_records_byRegnoSessionSemester($table_tra, $regno, $session, $semester);

                        echo " <tr>";
                            echo "<td>$sn</td>";
                            echo "<td>{$student['stu_name']}</td>";
                            echo "<td>{$student['regno']}</td>";

                            for($i = $course_start_id; $i <= $total_course_lev6_semester2_count; $i++){
                                    
                                    $course_column = 'c' . $i;
                                    $grade = 'g' . $i;   // to be included if needed.

                                    if($students[$course_column] == 1){
                                        echo "<td>{$student[$course_column]}{$student[$grade]}</td>";
                                    } else {
                                       echo "<td>-</td>"; 
                                    }
                                   
                                }

                        echo " </tr> ";

                            $sn = $sn  + 1;  // increment serial number
                    }
                                        
                    echo " </table> ";
                   } // end if ($dept != 'med') 
                break;

                default:
                    # code...
                    break;
            

            
            } // ends switch ($level)
                
                echo "<br/>";
                echo "<a href=\"viewcompositesheet.php\">Check Again</a>";
                echo " | ";
                echo "<a href=\"senates.php\">Return to Senate's Menu</a>";


            } // ends error()
        
    } else {  // isset($_POST['submit'])
    ?>    
      <form action="viewcompositesheet.php" method="post">
        <h3 style="color:red">Checking Composite Results. </h3>
        <p style="color:blue"><b><em>Select Departments Information</em></b></p>
        <br/>
            <p>
              Department:
                <select name="dept">
                    <option value="">Select Department</option>
                    <option value="csc">Computer Science</option>
                    <option value="mcb">Micro Biology</option>
                    <option value="inc">Industrial Chemistry</option>
                    <option value="bch">Bio Chemistry</option>
                </select></p>
            <?php page_form(); ?>
            <p>
              Level: 
                 <select name="level">
                    <option value="">Select level</option>
                    <option value="1">100</option>
                    <option value="2">200</option>
                    <option value="3">300</option>
                    <option value="4">400</option>
                    <option value="5">500</option>
                    <option value="6">600</option>
                 </select>
            </p>
            <br/>
            <p><input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="senates.php">Return to Senate's Menu</a></p>
    </form>
  <?php }; // ends isset($_POST['submit'] ?>

</article>

<?php require("includes/footer.php"); ?>