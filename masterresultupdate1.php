<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php //confirm_logged_in_lecturers(); ?>
<?php include("includes/header_print.php"); ?>

<article class="col-lg-12">
           
    <?php
    include_once("includes/form_functions.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('dept', 'session', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));

        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){

            // initialize tables
            $table_course = $dept . 'c';
            $table_reg = $dept . 'cr';
            $table_tra = $dept . 'tra';
            $table_mas = $dept . 'mas';

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

            //get results of the dept for the session and semester from Transaction Result table
            $stud_tra = get_records_by_SessionSemester($table_tra, $session, $semester);
            
            // update each student courses in the master result table from transaction result table
            while ($student = mysql_fetch_array($stud_tra)) {
                $regno = $student['regno'];
                //echo $regno . "-> ";
                $level = $student['level_type'];
                switch ($semester) {
                    case $semester == 1:
                        // update courses
                        for ($i = $course_start_id; $i <= $total_course_semester1_count ; $i++) { 
                            $course_column = 'c' . $i;
                            //echo $course_column . "->";
                            // check if the student registered for the course
                            $stud_reg_set = get_student_record_by_RegnoSessionSemesterCoursecolumn($table_reg, $regno, $session, $semester, $course_column);
                            if ($stud_row = mysql_fetch_array($stud_reg_set)) {
                                //echo $stud_row[$course_column] . ", ";
                                //echo $student[$ca] . ", ";
                                $ca = 'a' . $i;
                                $exam = 'e' . $i;
                                $grade = 'g' . $i;
                                $remark = 'r' . $i;
                                $sess = 's' .$i;
                                $query = "UPDATE $table_mas SET 
                                        $ca = '$student[$ca]',
                                        $exam = '$student[$exam]',
                                        $course_column = '$student[$course_column]',
                                        $grade = '$student[$grade]',
                                        $remark = '$student[$remark]',
                                        $sess = '$session' 
                                    WHERE regno = '$regno' ";
                                $result1 = mysql_query($query, $connection);
                                confirm_query($result1);
                            }   
                        }
                        
                        break;
                    
                        case $semester == 2:
                        // update courses
                        for ($i = $course_start_id; $i <= $total_course_semester2_count ; $i++) { 
                            $course_column = 'c' . $i;
                            //echo $course_column . "->";
                            // check if the student registered for the course
                            $stud_reg_set = get_student_record_by_RegnoSessionSemesterCoursecolumn($table_reg, $regno, $session, $semester, $course_column);
                            if ($stud_row = mysql_fetch_array($stud_reg_set)) {
                                //echo $stud_row[$course_column] . ", ";
                                //echo $student[$ca] . ", ";
                                $ca = 'a' . $i;
                                $exam = 'e' . $i;
                                $grade = 'g' . $i;
                                $remark = 'r' . $i;
                                $sess = 's' .$i;
                                $query = "UPDATE $table_mas SET 
                                        $ca = '$student[$ca]',
                                        $exam = '$student[$exam]',
                                        $course_column = '$student[$course_column]',
                                        $grade = '$student[$grade]',
                                        $remark = '$student[$remark]',
                                        $sess = '$session' 
                                    WHERE regno = '$regno' ";
                                $result1 = mysql_query($query, $connection);
                                confirm_query($result1);
                            }   
                        }
                        
                        break;

                    default:
                        # code...
                        break;
                }
               // echo "<br/>";
            }
        
        }else{  // empty(errors)
            echo "Please select all information and check your course code <br/><br/>";
            echo "<a href=\"masterresultupdate1.php\">Try Again</a>";
        } // ends empty(errors)
       
         echo "<a href=\"index.php\">Return to Menu</a>";

    } else {  // isset($_POST['submit'])
    ?>    
        <form action="masterresultupdate1.php" method="post">
            <p><b>Select Departmental Information</b></p>
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
            <br/>
            <p><input type="submit" name="submit" value="Submit" /></p>
        </form>
    <?php }; // ends isset($_POST['submit'] ?>

    <a href="index.php">cancel</a>
</article>

<?php require("includes/footer.php"); ?>