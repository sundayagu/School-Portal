<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header_print.php"); ?>
           
    <?php
    include_once("includes/form_functions_viewing.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted
    // Execution is done by levels

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('level');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // clean up the form data before putting it in the database
        $dept = $_SESSION['dept_code'];
        $level = trim(mysql_prep($_POST['level']));

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
            echo "Please select all information and check your registration number <br/><br/>";
            echo "<a href=\"viewstatementofresult.php\">Try Again</a>";
        }else{
            // declare tables
            $table_course = $dept . "c";

            // get the start_level_course and total_level_course for the two semesters from the course table
            // and initialize them.
            // to be used in course_reg.
            $first_semester_course_start_id = get_department_course_by_level_type_by_semester($table_course, $level, 1);
            $first_semester_cou_start_id = mysql_fetch_array($first_semester_course_start_id);
            $first_semester_course_level_start_id = $first_semester_cou_start_id['course_id'];
            $first_semester_course_set_for_total = get_department_course_by_level_type_by_first_semester_for_total($table_course, $level, 1);
            $first_semester_course_level__count = mysql_num_rows($first_semester_course_set_for_total);
            echo $first_semester_course_level_start_id ."<br/>";
            echo $first_semester_course_level__count ."<br/>";

            $second_semester_course_start_id = get_department_course_by_level_type_by_semester($table_course, $level, 2);
            $second_semester_cou_start_id = mysql_fetch_array($second_semester_course_start_id);
            $second_semester_course_level_start_id = $second_semester_cou_start_id['course_id'];
            $second_semester_course_set_for_total = get_department_course_by_level_type_by_second_semester_for_totals($table_course, $level, 2);
            $second_semester_course_level__count = mysql_num_rows($second_semester_course_set_for_total);
            echo $second_semester_course_level_start_id ."<br/>";
            echo $second_semester_course_level__count ."<br/>";

            // Initialize credit units for courses from Course table database.
            switch ($semester){ // 1st switch()
                case $semester == 1:
                    $sn = 1;
                    while($course = mysql_fetch_array($course_set)){
                        $credit = 'credit' . $sn;
                        $$credit = $course['credit_unit'] ;
                       // echo $credit . " ==> " . $$credit . "<br/>";
                        $sn += 1;
                    }

                break;

                case $semester == 2:
                    $sn = $course_start_id;
                    while($course = mysql_fetch_array($course_set)){
                        $credit = 'credit' . $sn;
                        $$credit = $course['credit_unit'] ;
                       // echo $credit . " ==> " . $$credit . "<br/>";
                        $sn += 1;
                    }

                break;

                default:

                break;

            }  // ends 1st switch()

            $course_set = get_all_department_courses_by_semester($table_course , 1);
            $sn = $first_semester_course_level_start_id;
            while($course = mysql_fetch_array($course_set)){
                $credit = 'credit' . $sn;
                $$credit = $course['credit_unit'] ;
               // echo $credit . " ==> " . $$credit . "<br/>";
                $sn += 1;
            }

            $course_set = get_all_department_courses_by_semester($table_course , 2);
            $sn = $course_start_id;
            while($course = mysql_fetch_array($course_set)){
                $credit = 'credit' . $sn;
                $$credit = $course['credit_unit'] ;
               // echo $credit . " ==> " . $$credit . "<br/>";
                $sn += 1;
            }




            // finding where the total of a semester's courses will end.
                $course_set = get_all_department_courses_by_semester($table_course, 1);
                $course_semester1_count = mysql_num_rows($course_set);
                $course_set = get_all_department_courses_by_semester($table_course, 2);
                $course_semester2_count = mysql_num_rows($course_set);

                $total_course_semester1_count = $course_semester1_count;
                //echo $total_course_semester1_count . "<br/>";
                $total_course_semester2_count = $total_course_semester1_count + $course_semester2_count;
                //echo $total_course_semester2_count . "<br/>";


            $table_tra = $dept . "tra";
            if(!$result_tra_row = get_student_records_byRegnoSessionSemester($table_tra, $_SESSION['username'], $session, $semester)){
                echo "Registration Number does not exist. <br/><br/>";
                echo "<a href=\"login_students.php\">Try again</a>";
            }else{ // of if(!$result_tra_row)
                $stu_level_type = $result_tra_row['level_type'];   // declare student level
                $stu_name = $result_tra_row['stu_name'];           // declare student name
                $regno = $result_tra_row['regno'];           // declare student regno
                // echo $stu_name;              // for debug remove !! 
                // echo $stu_level_type;        // for debug remove !!

                // get info for display of heading
                $deptdisplay = get_department_by_deptcode($dept);
                  $depthead = trim($deptdisplay['dept_name']);     // to be echoed bcos echo doesn't echo super global array object
                
                $faculty_type = $deptdisplay['faculty_type'];
                $facudisplay = get_faculty_by_id($faculty_type);    
                  $facuhead = trim($facudisplay['faculty_name']);

                $sessdisplay = get_session_by_sesscode($session);
                  $sesshead = trim($sessdisplay['session_title']); //  "      "     "      "       "       "     "     "     "   "
                $levedisplay = get_level_by_id($stu_level_type);
                  $levehead = trim($levedisplay['level_name']);
                $semedisplay = get_semester_by_id($semester);
                  $semehead = trim($semedisplay['semester_name']);

                // Display heading
                echo "<div>";
                echo "<h4 style=\"text-align:center; color:red\"><b>SOUTHINGAM UNIVERSITY, EDO STATE, NIGERIA.</b></h4>";
                echo "<h4 style=\"text-align:center; color:red\"><b>EXAMINATIONS DEPARTMENT</b></h4>";
               // echo "<br/>";
                echo "<h2 style=\"text-align:center; color:blue; text-decoration:underline;\"><b>STUDENTS RESULT</b></h2>";
                echo "</div>";
                echo "<br/>";
                echo "<table cellspacing=\"2\" style=width:100%;>";
                    echo "<tr>";
                        echo "<td><b>Faculty</b>&nbsp;&nbsp; {$facuhead} </td>"; // you can put { } or not as in $sesshead below
                        echo "<td><b>Department</b>&nbsp;&nbsp; {$depthead} </td>"; // you can put { } or not as in $sesshead below
                        echo "<td><b>Session:</b>&nbsp;&nbsp; $sesshead </td>";
                        //echo "<td style=\"text-align:right\"><b>Semester:</b>&nbsp;&nbsp; $semehead </td>";
                        echo "<td><b>Semester:</b>&nbsp;&nbsp; $semehead </td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><b>Registration Number:</b>&nbsp;&nbsp; $regno </td>";
                        echo "<td><b>Name:</b>&nbsp;&nbsp; $stu_name </td>";
                        //echo "<td style=\"text-align:right\"><b>Level:</b>&nbsp;&nbsp; $levehead </td>";
                        echo "<td><b>Level:</b>&nbsp;&nbsp; $levehead </td>";
                        echo "<td>&nbsp;&nbsp;</td>"; // you can put { } or not as in $sesshead below
                    echo "</tr>";
                 echo "</table> ";
                echo "<br/>";
            

                echo "
                    <table border=\"1\" style=\"width:100%\">
                        <tr>
                            <th>S/N</th>
                            <th>COURSE CODE</th>
                            <th>COURSE TITLE</th>
                            <th>CREDIT UNIT</th>
                            <th>GRADE</th>
                            <th>GRADE POINT</th>
                            <th>REMARK</th>
                        </tr>
                    ";
                        
                        $grand_total_grade_point = 0;
                        $grand_total_credit_unit = 0;

                        $GradePointAverage = 'gpa' . $semester;   // gpa field for the semester
                        $gpa = $result_tra_row[$GradePointAverage];  // variable for the real gpa

                        $sr = 1; // $sr represents serial numbers of the courses taken by the student
                        
                                
                        switch ($semester) {
                            case $semester == 1:

                                for($sn = 1; $sn <= $total_course_semester1_count; $sn++ ){   // $sn represents course_columns                         
                                    $total_grade_point = 0;
                                    $total_credit_unit = 0;
                                    $credit = 'credit' . $sn;  // credit unit for current course to be used in var var.
                                    $course_column = 'c' . $sn; // total score field for the current course.
                                    $gra = 'g' . $sn;   // grade field for the current course
                                    $rem = 'r' . $sn;   // remark field for the current course
                                    $score = $result_tra_row[$course_column];  // variable for the real total score
                                    $grade = $result_tra_row[$gra];  // variable for the real grade
                                    $remark = $result_tra_row[$rem];  // variable for the real remark
                                    if(!empty($score)){
                                        // get data from Courses table about the current course
                                        $course = get_department_course_by_courseid($table_course, $sn);
                                        //echo $course['course_code'];

                                       echo "
                                            <tr>
                                                <td>$sr</td>
                                                <td>{$course['course_code']}</td>
                                                <td>{$course['course_title']}</td>
                                                <td>{$course['credit_unit']}</td>
                                                <td>$grade</td>
                                            ";     
                                       
                                                // Calculate Grade Point
                                                switch ($score){
                                                    case $score>69:
                                                        $grade_point = 5;  // A
                                                        break;
                                                    case $score>59:
                                                        $grade_point = 4;  // B
                                                        break;
                                                    case $score>49:
                                                        $grade_point = 3;  // C
                                                        break;
                                                    case $score>44:
                                                        $grade_point = 2;  // D
                                                        break;
                                                    case $score>39:
                                                        $grade_point = 1;  // E
                                                        break;
                                                    case $score>0:
                                                        $grade_point = 0;  // F
                                                        break;

                                                    default:
                                                        $grade_point = 0;  //  NULL or Empty
                                                        break;

                                                } // ends switch($score)

                                                $total_grade_point += $grade_point * $$credit;
                                                $grand_total_credit_unit += $$credit;
                                                $grand_total_grade_point += $total_grade_point;


                                        echo "  <td>$total_grade_point</td>
                                                <td>$remark</td>
                                            </tr>
                                        ";


                                       $sr += 1;
                                    } // if(!empty)

                                } // for($sn = 1). trying the delimit them 
                                        echo "
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><b>TOTAL</b></td>
                                                <td><b>$grand_total_credit_unit</b></td>
                                                <td></td>
                                                <td><b>$grand_total_grade_point</b></td>
                                                <td></td>
                                            </tr>
                                        ";

                                        echo "
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><h4>GPA @ End of $semehead Semester</h4></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><h4>$gpa</h4></td>
                                            </tr>
                                        ";
                                
                        echo "</table>";

                    break;


                    case $semester == 2:
                        for($sn = $course_start_id; $sn <= $total_course_semester2_count; $sn++ ){   // $sn represents course_columns                         
                                    $total_grade_point = 0;
                                    $total_credit_unit = 0;
                                    $credit = 'credit' . $sn;  // credit unit for current course to be used in var var.
                                    $course_column = 'c' . $sn; // total score field for the current course.
                                    $gra = 'g' . $sn;   // grade field for the current course
                                    $rem = 'r' . $sn;   // remark field for the current course
                                    $score = $result_tra_row[$course_column];  // variable for the real total score
                                    $grade = $result_tra_row[$gra];  // variable for the real grade
                                    $remark = $result_tra_row[$rem];  // variable for the real remark
                                    if(!empty($score)){
                                        // get data from Courses table about the current course
                                        $course = get_department_course_by_courseid($table_course, $sn);
                                        //echo $course['course_code'];

                                       echo "
                                            <tr>
                                                <td>$sr</td>
                                                <td>{$course['course_code']}</td>
                                                <td>{$course['course_title']}</td>
                                                <td>{$course['credit_unit']}</td>
                                                <td>$grade</td>
                                            ";     
                                       
                                                // Calculate Grade Point
                                                switch ($score){
                                                    case $score>69:
                                                        $grade_point = 5;  // A
                                                        break;
                                                    case $score>59:
                                                        $grade_point = 4;  // B
                                                        break;
                                                    case $score>49:
                                                        $grade_point = 3;  // C
                                                        break;
                                                    case $score>44:
                                                        $grade_point = 2;  // D
                                                        break;
                                                    case $score>39:
                                                        $grade_point = 1;  // E
                                                        break;
                                                    case $score>0:
                                                        $grade_point = 0;  // F
                                                        break;

                                                    default:
                                                        $grade_point = 0;  //  NULL or Empty
                                                        break;

                                                } // ends switch($score)

                                                $total_grade_point += $grade_point * $$credit;
                                                $grand_total_credit_unit += $$credit;
                                                $grand_total_grade_point += $total_grade_point;


                                        echo "  <td>$total_grade_point</td>
                                                <td>$remark</td>
                                            </tr>
                                        ";


                                       $sr += 1;
                                    } // if(!empty)

                                } // for($sn = 1). trying to delimit them 
                                        echo "
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><b>TOTAL</b></td>
                                                <td><b>$grand_total_credit_unit</b></td>
                                                <td></td>
                                                <td><b>$grand_total_grade_point</b></td>
                                                <td></td>
                                            </tr>
                                        ";

                                        echo "
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><h4>GPA @ End of $semehead Semester</h4></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><h4>$gpa</h4></td>
                                            </tr>
                                        ";
                                
                        echo "</table>";



                    break;

                    default:

                    break;

                } // ends switch($semester)



                echo "<br/><br/>";
                echo "<a href=\"index.php\">Return to Home</a>";
            } // ends if(!$result_tra_row)

        


        } // ends if(!empty($error))

    } else {  // isset($_POST['submit'])
    
    ?> 
         <h3>Student's Result</h3>   
	    <form action="viewstatementofresult.php" method="post">
	    	<p><b>Select Students Information</b></p>
			 <?php //page_form(); ?>
             <p>
              Department:
                <select name="level">
                    <option value="">Select Level</option>
                    <option value="1">100</option>
                    <option value="2">200</option>
                    <option value="3">300</option>
                    <option value="4">400</option>
                    <option value="5">500</option>
                    <option value="6">600</option>
                </select></p>
            <p><input type="submit" name="submit" value="view" /></p>
		</form>
	<?php }; // ends isset($_POST['submit'] ?>
</article>

<?php require("includes/footer.php"); ?>