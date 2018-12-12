<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-1 col-sm-1 col-xs-1">
    <!--
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="viewcourses1.php">View Student's Registered courses</a></li>
            </ul>
        </div>
    </div> -->   
</aside>
<article class="col-lg-10 col-sm-10 col-xs-6">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">HOD's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Departmental Level Registered Courses:</h3>
        
    <?php include_once("includes/form_functions_viewing.php"); ?>
    
    <?php 

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('session', 'level_type', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));
       
        // clean up the form data before putting it in the database
        //$dept = trim(mysql_prep($_POST['dept']));
        $dept = $_SESSION['dept_code'];
        $session = trim(mysql_prep($_POST['session']));
        $level_type = trim(mysql_prep($_POST['level_type']));
        $semester = trim(mysql_prep($_POST['semester']));
               
        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){

            $deptdisplay = get_department_by_deptcode($dept);

            $faculty_type = $deptdisplay['faculty_type'];
            $facudisplay = get_faculty_by_id($faculty_type);

            $sessdisplay = get_session_by_sesscode($session);
            $levedisplay = get_level_by_id($level_type);
            $semedisplay = get_semester_by_id($semester);

            ?>
        <!-- Display Headings -->
         <table cellspacing="2" style=width:100%;>
            <tr>
                <td><p><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']) ; ?></p>
                    <p><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ; ?></p>
                </td>
                <td>
                    <p><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']) ; ?></p>
                    <p><b>Level:</b>&nbsp;&nbsp;<?php echo trim($levedisplay['level_name']) ; ?></p>
                </td>
                <td><p>&nbsp;&nbsp;</p>
                    <p><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']) ; ?></p>
                </td>
            </tr>
         </table> 
        <br/>
        <?php
            $table_course = $dept . "c";
                   
            // finding where the total of a level's course_column will end.
            // to be used in course_reg.
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
              $cou_start = get_start_course_by_level_type_by_semester($table_course, $level_type, $semester);
              $course_start_id = $cou_start['course_id'];
              
              $course_set = get_department_course_by_level_type_by_semester($table_course, $level_type, $semester);
              
              $table_reg = $dept . 'cr';
            
              $level = $level_type ;
                
                echo "<table border=\"1\" style=\"width:100%\">";
                // display headings 
                    echo "<tr>";
                        echo "<th style='background:yellow'>S/N</th>";
                        echo "<th style='background:yellow'>NAME OF CANDIDATE</th>";
                        echo "<th style='background:yellow'>REGISTRATION NUMBER</th>";
                
                switch ($level) {
                    case $level == 1 AND $semester == 1:
                            while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev1_semester1_count);
                            $sno = 1;
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev1_semester1_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";

                                echo "</tr>";
                                $sno = $sno + 1;
                            }
                        echo "</table>";
                        break;
                            
                    case $level == 2 AND $semester == 1:
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev2_semester1_count);
                            $sno = 1;
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev2_semester1_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";

                                echo "</tr>";
                                $sno = $sno + 1;
                            }
                        echo "</table>";
                        break;

                        case $level == 3 AND $semester == 1:
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev3_semester1_count);
                            $sno = 1;
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev3_semester1_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";

                                echo "</tr>";
                                $sno = $sno + 1;
                            }
                        echo "</table>";
                        break;
                    
                    case $level == 4 AND $semester == 1:
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev4_semester1_count);
                            $sno = 1;
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev4_semester1_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";

                                echo "</tr>";
                                $sno = $sno + 1;
                            }
                        echo "</table>";
                        break;
                    
                    case $level == 5 AND $semester == 1:
                        if ($dept != 'med'){
                          echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewlevelcourses.php\">Try Again</a>";
                        } else {
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev5_semester1_count);
                            $sno = 1;
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev5_semester1_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";

                                echo "</tr>";
                                $sno = $sno + 1;
                            }
                        echo "</table>";

                        } // end if ($dept != 'med')
                        
                        break;

                    case $level == 6 AND $semester == 1:

                        if ($dept != 'med'){
                            echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewlevelcourses.php\">Try Again</a>";
                        } else {

                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev6_semester1_count);
                            $sno = 1;
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev6_semester1_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";

                                echo "</tr>";
                                $sno = $sno + 1;
                            }
                        echo "</table>";

                        } // end if ($dept != 'med')
                        
                        break;

                    case $level == 1 AND $semester == 2:
                            while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev1_semester2_count);
                            $sno = 1;
                            //echo $course_start_id . "<br/>" ;
                            
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev1_semester2_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit2']} </td>";
                                echo "</tr>";
                                $sno += 1;
                            }
                        echo "</table>";

                        break;

                        case $level == 2 AND $semester == 2:
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev2_semester2_count);
                            $sno = 1;
                            //echo $course_start_id . "<br/>" ;
                            
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev2_semester2_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";
                                echo "</tr>";
                                $sno += 1;
                            }
                        echo "</table>";
                        break;

                        case $level == 3 AND $semester == 2:
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev3_semester2_count);
                            $sno = 1;
                            //echo $course_start_id . "<br/>" ;
                            
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev3_semester2_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";
                                echo "</tr>";
                                $sno += 1;
                            }
                        echo "</table>";
                        break;

                        case $level == 4 AND $semester == 2:
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev4_semester2_count);
                            $sno = 1;
                            //echo $course_start_id . "<br/>" ;
                            
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev4_semester2_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";
                                echo "</tr>";
                                $sno += 1;
                            }
                        echo "</table>";
                        break;

                        case $level == 5 AND $semester == 2:
                        if ($dept != 'med'){
                            echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewlevelcourses.php\">Try Again</a>";
                        } else {
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev5_semester2_count);
                            $sno = 1;
                            //echo $course_start_id . "<br/>" ;
                            
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev5_semester2_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";
                                echo "</tr>";
                                $sno += 1;
                            }
                        echo "</table>";

                        } // end if ($dept != 'med')
                        break;

                        case $level == 6 AND $semester == 2:
                        if ($dept != 'med'){
                            echo "The " . trim($levedisplay['level_name']) . " level you selected for the department does not exist<br/>";
                            echo "Please select correct information.<br/><br/>";
                            echo "<a href=\"viewlevelcourses.php\">Try Again</a>";
                        } else {
                        while($course = mysql_fetch_array($course_set)){
                                echo "<th style='background:yellow'> {$course['course_code']} </th> ";
                            }
                            echo "<th style='background:yellow'>Total Credit Units</th>";
                            echo "</tr>";
                        // display the body
                            $student_set = get_students_who_registered_for_departmental_level_courses($table_reg, $session, $semester, $course_start_id, $total_course_lev6_semester2_count);
                            $sno = 1;
                            //echo $course_start_id . "<br/>" ;
                            
                            while($student = mysql_fetch_array($student_set)){
                                echo "<tr>";
                                    echo "<td> $sno </td>";
                                    echo "<td> {$student['stu_name']} </td>";
                                    echo "<td> {$student['regno']} </td>";
                                    for($sn = $course_start_id; $sn <= $total_course_lev6_semester2_count; $sn++){
                                        $course_column = 'c' . $sn;   
                                        echo "<td> {$student[$course_column]} </td>";
                                    }
                                    echo "<td> {$student['totalcredit']} </td>";
                                echo "</tr>";
                                $sno += 1;
                            }
                        echo "</table>";

                        } // end if ($dept != 'med')
                        break;

                    default:
                       
                        break;
                } // ends switch()


        }else{  // empty(errors)
            echo "Please select all information.<br/><br/>";
            echo "<a href=\"viewlevelcourses.php\">Try Again</a>";
        } // ends empty(errors)
        echo "<br/><br/>";
        echo "<a href=\"hods.php\">Return to HOD's Menu</a>";
    }else{
    ?>
        <form action="viewlevelcourses.php" method="post">
            <p style="color:blue"><b><em>Select Departmental Information</em></b></p>
            <br/>
            <!--<p>
              Department:
                <select name="dept">
                    <option value="">Select Department</option>
                    <option value="csc">Computer Science</option>
                    <option value="mcb">Micro Biology</option>
                    <option value="inc">Industrial Chemistry</option>
                    <option value="bch">Bio Chemistry</option>
                </select></p>-->
            <?php page_form(); ?>
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
            <br/>
            <p><input type="submit" name="submit" value="view" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"hods.php\">Return to Hod's Menu</a>"; ?></p>

        </form> 
    <?php
    } // ends if(isset($_POST['submit']))
    ?> 
 </article>

<?php require("includes/footer.php"); ?>