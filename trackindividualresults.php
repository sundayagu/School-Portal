<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header_print.php"); ?>
           
    <?php
   
        $dept = $_SESSION['dept_code'];

        $deptdisplay = get_department_by_deptcode($dept);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);
        $sexdisplay = get_sex_by_id($_SESSION['stu_sex']);

        // Display main heading
        ?>
        <center>
        <h3 style="color:red">Results for all the Sessions</h3>
        <p style="color:blue">====================================</p>
        </center>
        <br/>
        <table cellspacing="2" style=width:100%;>
            <tr><td><b>Regno:</b>&nbsp;&nbsp;<?php echo $_SESSION['username'] ; ?></td>
                <td><b>Name:</b>&nbsp;&nbsp;<?php echo $_SESSION['stu_name'] ; ?></td></tr>

            <tr><td><b>Faculty:</b>&nbsp;&nbsp;<?php echo $facudisplay['faculty_name']; ?></td>
                <td><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']); ?></td>
                
            <tr><td><b>Sex:</b>&nbsp;&nbsp;<?php echo trim($sexdisplay['sex_name']); ?></td></tr>
                <td><b></b>&nbsp;&nbsp;<?php // ?></td></tr>
           
        </table> 
      

        <?php
                    
            // declare tables
            $table_course = $dept . "c";
            $table_reg = $dept . "cr";
            $table_tra = $dept . "tra";
            
            // get the student results
            $stu_tra = get_a_student_course_results_by_regno($table_tra, $_SESSION['username']);
            
            while ($student = mysql_fetch_array($stu_tra)) {
                
                // get all courses for the department
                $course_set = get_all_department_courses($table_course);
                $course_count = mysql_num_rows($course_set);
                //echo $course_count . "<br/>";


                $regno = $student['regno'];
                $session = $student['session'];
                $level = $student['level_type'];
                //echo $session . "<br/>";
                //echo $level . "<br/>";
                $sessdisplay = get_session_by_sesscode($session);
                $levedisplay = get_level_by_id($level);
                
                //Display each session headings
                echo "<table border='1' cellspacing='2'style=width:100%;>";
                echo "<tr>";
                    echo "<th style='background:blue; color:white'>Session</th>";
                    echo "<th style='background:blue; color:white'>Level</td>";
                    while($course = mysql_fetch_array($course_set)){
                        $course_id = $course['course_id'];
                        $course_column = 'c' . $course_id;
                        
                        // check if student registered for the course
                        $registered = get_student_record_by_RegnoSessionCoursecolumn($table_reg, $regno, $session, $course_column);
                        if($stureg = mysql_fetch_assoc($registered)){
                            extract($stureg); // each column now has a variable equivalent.
                            // get course code and echo it
                            $course = get_course_details($table_course, $course_id);
                            echo " <th style='background:yellow'>{$course['course_code']} </th> ";
                        }
                    }
                echo "</tr>";
                // end of session heading
                
                echo "<tr>";
                    echo " <td style='background:#ccc'><b>{$sessdisplay['session_title']}</b> </td> ";
                    echo " <td style='background:#ccc'><b>{$levedisplay['level_name']}</b> </td> ";
                    for ($i=1; $i <= $course_count; $i++) { 
                        $course_column = 'c' . $i;
                        $grade = 'g' . $i;
                        // check if student registered for the course
                        $registered = get_student_record_by_RegnoSessionCoursecolumn($table_reg, $regno, $session, $course_column);
                        if($stureg = mysql_fetch_assoc($registered)){
                            extract($stureg); // each column now has a variable equivalent.
                            // get course result and echo it
                            $course = get_course_details($table_course, $course_id);
                            if ($student[$grade] == 'F'){
                                echo " <td style='color:red'><b>{$student[$course_column]} {$student[$grade]}</b> </td> "; 
                            }else{
                               echo " <td>{$student[$course_column]} {$student[$grade]} </td> "; 
                            }
                            
                        }

                    }
                echo "</tr>";
                
             echo "</table>";
             echo "<br/><br/>";

            }

        echo "<center>" ;
            echo "<a href=\"students.php\">Return to Students Menu</a>";
        echo "</center>";
    ?> 
        	
</article>

<?php require("includes/footer.php"); ?>