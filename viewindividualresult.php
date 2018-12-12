<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header_print.php"); ?>
           
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
        if(!empty($errors)){
            echo "Please select all information and check your registration number <br/><br/>";
            echo "<a href=\"viewindividualresult.php\">Try Again</a>";
        }else{
            // declare tables
            $table_course = $dept . "c";
            $course_set = get_all_department_courses_by_semester($table_course , $semester);
            //$course_count = mysql_num_rows($course_set);
            //echo $course_count . "<br/>";

            // get the start course column from the course table and initialize the course_id to begin from.
            $cou_start = get_start_course_by_semester($table_course, $semester);
            $course_start_id = $cou_start['course_id'];
            //echo $course_start_id;
           
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
                echo "<h3 style=\"text-align:center; color:blue; text-decoration:underline;\"><b>STUDENTS RESULT</b></h3>";
                echo "</div>";
                echo "<br/>";
                echo "<center>";
                echo "<table cellspacing=\"2\" style=width:80%;>";
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
                 echo "</center>";
                echo "<br/>";
            

                echo "<center>";
                echo "
                    <table border=\"1\" style=\"width:80%\">
                        <tr>
                            <th style=\"background:yellow\">S/N</th>
                            <th style=\"background:yellow\">COURSE CODE</th>
                            <th style=\"background:yellow\">COURSE TITLE</th>
                            <th style=\"background:yellow\">CREDIT UNIT</th>
                            <th style=\"background:yellow\">GRADE</th>
                            <th style=\"background:yellow\">GRADE POINT</th>
                            <th style=\"background:yellow\">REMARK</th>
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
                                                <td style=\"color:blue\"><b><em><center>TOTAL</center></em></b></td>
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
                                                <td style=\"color:blue\"><h4><em><center>GPA @ End of $semehead Semester</center></em></h4></td>
                                                <td></td>
                                                <td></td>
                                                <td style=\"color:blue\"><h4><em>$gpa</em></h4></td>
                                                <td></td>
                                            </tr>
                                        ";
                                
                        echo "</table>";

                        echo "<br/><br/>";
                        echo "<a href=\"students.php\">Return to Students Menu</a>";

                    echo "</center>";

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
                                                <td style=\"color:blue\"><b><em><center>TOTAL</center></em></b></td>
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
                                                <td style=\"color:blue\"><h4><em><center>GPA @ End of $semehead Semester</center></em></h4></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style=\"color:blue\"><h4><em>$gpa</em></h4></td>
                                            </tr>
                                        ";
                                
                        echo "</table>";

                        echo "<br/><br/>";
                        echo "<a href=\"students.php\">Return to Students Menu</a>";

                    echo "</center>";

                    break;

                    default:

                    break;

                } // ends switch($semester)



                
            } // ends if(!$result_tra_row)

        


        } // ends if(!empty($error))

    } else {  // isset($_POST['submit'])
    
    ?> 
         <h3 style="color:red">Checking of each Semester Result</h3>   
	    <form action="viewindividualresult.php" method="post">
	    	</br>
            <p style="color:blue"><b><em>Select Session & Semester to check</em></b></p>
            </br>
			 <?php page_form(); ?>
            </br>
            <p><input type="submit" name="submit" value="view" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"students.php\">Return to Students Menu</a>"; ?></p>
		</form>
	<?php }; // ends isset($_POST['submit'] ?>
</article>

<?php require("includes/footer.php"); ?>