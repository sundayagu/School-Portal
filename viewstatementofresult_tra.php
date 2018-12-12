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
        $required_fields = array('session');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // clean up the form data before putting it in the database
        $dept = $_SESSION['dept_code'];
        $session = trim(mysql_prep($_POST['session']));
                    
        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
            echo "Please select all information and check your registration number <br/><br/>";
            echo "<a href=\"viewstatementofresult_tra.php\">Try Again</a>";
        }else{
            // declare tables
            $table_course = $dept . "c";
            
            // get all departmental courses for the two semesters. fs stands for 1st semester, ss for 2nd semester
            $fs_course_set = get_all_department_courses_by_semester($table_course , 1);
            $ss_course_set = get_all_department_courses_by_semester($table_course , 2);
            /*$fs_course_count = mysql_num_rows($fs_course_set);
            $ss_course_count = mysql_num_rows($ss_course_set);
            echo $fs_course_count . "<br/>";
            echo $ss_course_count . "<br/>";*/

            // get the start courses for the two semesters from the course table and initialize the course_id to begin from.
            $fs_course_start = get_start_course_by_semester($table_course, 1);
            $fs_course_start_id = $fs_course_start['course_id'];
            $ss_course_start = get_start_course_by_semester($table_course, 2);
            $ss_course_start_id = $ss_course_start['course_id'];
            //echo $fs_course_start_id . "<br/>" ;
            //echo $ss_course_start_id . "<br/>" ;
           
            // Initialize credit units for courses for the two semesters from Course table database.
                // for 1st semester
                $sn = 1;
                while($course = mysql_fetch_array($fs_course_set)){
                    $credit = 'credit' . $sn;
                    $$credit = $course['credit_unit'] ;
                    //echo $credit . " ==> " . $$credit . "<br/>";
                    $sn += 1;
                }

                // for 2nd semester
                $sn = $ss_course_start_id;
                while($course = mysql_fetch_array($ss_course_set)){
                    $credit = 'credit' . $sn;
                    $$credit = $course['credit_unit'] ;
                    //echo $credit . " ==> " . $$credit . "<br/>";
                    $sn += 1;
                }

            // finding where the total of each of the two semester's courses will end.
                $fs_course_set = get_all_department_courses_by_semester($table_course, 1);
                $fs_course_count = mysql_num_rows($fs_course_set);
                $ss_course_set = get_all_department_courses_by_semester($table_course, 2);
                $ss_course_count = mysql_num_rows($ss_course_set);

                $fs_total_course_count = $fs_course_count;
                //echo $fs_total_course_count . "<br/>";
                $ss_total_course_count = $fs_total_course_count + $ss_course_count;
                //echo $ss_total_course_count . "<br/>";

            //*************************************************************************************************************
            // First semester starts here.
            $table_tra = $dept . "tra";
            if(!$result_tra_row = get_student_records_byRegnoSession($table_tra, $_SESSION['username'], $session)){
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
                  $durationOfCourse = trim($deptdisplay['mword']);
                  $courseOfStudy = trim($deptdisplay['courseofstudy']);
                  $depthead = strtoupper(trim($deptdisplay['dept_name'])); // to be echoed bcos echo doesn't echo super global array object
                
                $faculty_type = $deptdisplay['faculty_type'];
                $facudisplay = get_faculty_by_id($faculty_type);    
                  $facuhead = trim($facudisplay['faculty_name']);

                $sessdisplay = get_session_by_sesscode($session);
                  $sesshead = trim($sessdisplay['session_title']); //  "      "     "      "       "       "     "     "     "   "
                $levedisplay = get_level_by_id($stu_level_type);
                  //$levehead = trim($levedisplay['level_name']);
                  $levehead = trim($levedisplay['lword']);
                $semedisplay = get_semester_by_id(1);
                  $semehead1 = trim($semedisplay['semester_name']);
                $semedisplay = get_semester_by_id(2);
                  $semehead2 = trim($semedisplay['semester_name']);

                $sexdisplay = get_sex_by_id($_SESSION['stu_sex']);
                $sex = trim($sexdisplay['sex_name']);

                // Display heading
                echo "<div>";
                echo "<h6 style=\"text-align:center; color:red\"><b>SOUTHINGAM UNIVERSITY, EDO STATE, NIGERIA.</b></h6>";
                echo "<h6 style=\"text-align:center; color:red\"><b>EXAMINATIONS DEPARTMENT</b></h6>";
                echo "<h4 style=\"text-align:center; color:blue; text-decoration:underline;\"><b>STUDENTS RESULT</b></h4>";
                echo "<p style=\"text-align:center; color:black;\"><b>FIRST / SECOND SEMESTER</b></p>";
                echo "</div>";
                echo "<br/>";
                echo "<center>";
                echo "<table cellspacing=\"2\" style=width:80%;>";
                    echo "<tr>";
                        echo "<td width='15%'><b>Name of Candidate:</td>";
                        echo "<td style='text-decoration:underline;'>$stu_name</td>";
                        echo "<td><b>Reg. N0.:</td>";
                        echo "<td style='text-decoration:underline'>$regno </td>";
                        echo "<td width='4%'><b>Sex:</b></td>";
                        echo "<td style='text-decoration:underline'>{$sex}</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><b>Course of Study: </td>"; 
                        echo "<td width='40%'; style='text-decoration:underline' >{$courseOfStudy}&nbsp;IN&nbsp;{$depthead} </td>"; 
                        echo "<td>&nbsp;&nbsp;</td>";
                        echo "<td>&nbsp;&nbsp;</td>";
                    echo "</tr>";
                    echo "<tr>";
                       echo "<td><b>Duration of Course:</b></td>"; 
                       echo "<td style='text-decoration:underline'>{$durationOfCourse}&nbsp;YEARS </td>"; 
                       echo "<td width='11%'><b>Year of Study:</b></td>"; 
                       echo "<td style='text-decoration:underline'>$levehead</b></td>"; 
                    echo "</tr>";
                 echo "</table> ";
                 echo "</center>";
                echo "<br/>";
                echo "<p style=\"text-align:center; color:black;\"><b>FIRST SEMESTER&nbsp;$sesshead</b></p>";
            
                echo "<center>";
                echo "
                    <table border=\"1\" style=\"width:80%\">
                        <tr>
                            <th style='background:yellow'>S/N</th>
                                <th style='background:yellow'>COURSE CODE</th>
                                <th style='background:yellow'>COURSE TITLE</th>
                                <th style='background:yellow'>CREDIT UNIT</th>
                                <th style='background:yellow'>GRADE</th>
                                <th style='background:yellow'>GRADE POINT</th>
                                <th style='background:yellow'>REMARK</th>
                        </tr>
                    ";
                        
                        $grand_total_grade_point = 0;
                        $grand_total_credit_unit = 0;

                        $GradePointAverage = 'gpa' . 1;   // gpa field for the semester
                        $gpa1 = $result_tra_row[$GradePointAverage];  // variable for the real gpa

                        $sr = 1; // $sr represents serial numbers of the courses taken by the student
                        
                        // fisrt semester
                        for($sn = 1; $sn <= $fs_total_course_count; $sn++ ){   // $sn represents course_columns                         
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
                                            ";
                                                if($grade=='F'){
                                                    echo "<td style='color:red'>$grade</td>";
                                                }else{
                                                    echo "<td>$grade</td>";
                                                }
                                             
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
                                       /* echo "
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
                                                <td><h4>GPA @ End of $semehead1 Semester</h4></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><h4>$gpa1</h4></td>
                                            </tr>
                                        "; */
                                
                        echo "</table>";
                        echo "</center>";

                    
                    //*************************************************************************************************************
                    // Second semester starts here. 
                    echo "<br/>";
                    echo "<p style=\"text-align:center; color:black;\"><b>SECOND SEMESTER&nbsp;$sesshead</b></p>";
                
                    echo "<center>";
                    echo "
                        <table border=\"1\" style=\"width:80%\">
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

                            $GradePointAverage = 'gpa' . 2;   // gpa field for the semester
                            $gpa2 = $result_tra_row[$GradePointAverage];  // variable for the real gpa                   

                        $sr = 1; // reinitialize serial number
                        for($sn = $ss_course_start_id; $sn <= $ss_total_course_count; $sn++ ){   // $sn represents course_columns                         
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
                                            ";
                                                if($grade=='F'){
                                                    echo "<td style='color:red'>$grade</td>";
                                                }else{
                                                    echo "<td>$grade</td>";
                                                }     
                                       
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
                                       /* echo "
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
                                                <td><h4>GPA @ End of $semehead2 Semester</h4></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><h4>$gpa2</h4></td>
                                            </tr>
                                        "; */
                                
                        echo "</table>";
                    echo "</center>";

                    $cgpa = ($gpa1 + $gpa2)/2;
                    echo "<br/>";
                    echo "<center>";
                    echo "<table>
                        <tr>
                            <td style='color:blue'><b>1st Semester Grade Point Average:&nbsp;</b></td>
                            <td style='text-decoration:underline'><b>$gpa1</b></td>
                        </tr>
                        <tr>
                            <td style='color:blue'><b>2nd Semester Grade Point Average:&nbsp;</b></td>
                            <td style='text-decoration:underline'><b>$gpa2</b></td>
                        </tr>
                        <tr>
                            <td style='color:blue'><b>Cumulative Grade Point Average:&nbsp;</b></td>
                            <td style='text-decoration:underline'><b>$cgpa</b></td>
                        </tr>
                    </table>";

                    echo "<br/>";
                    echo "<a href=\"students.php\">Return to Students Menu</a>";

                echo "</center>";
   
                
            } // ends if(!$result_tra_row)

        


        } // ends if(!empty($error))

    } else {  // isset($_POST['submit'])
    
    ?> 
         <h3 style="color:red">Checking of Results for a Session</h3>   
	    <form action="viewstatementofresult_tra.php" method="post">
	    	<!--<br/>-->
            <p style="color:blue"><b><em>Select the Session to check</em></b></p>
			 <?php //page_form(); ?>
             <br/>
             <p>
              Session: 
                 <select name="session">
                    <option value="">Select session</option>
                    <option value="2016">2016/17</option>
                    <option value="2017">2017/18</option> 
                    <option value="2018">2018/19</option> 
                    <option value="2019">2019/20</option> 
                    <option value="2020">2020/21</option> 
                </select>
            </p>
            <br/>
            <p><input type="submit" name="submit" value="view" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"students.php\">Return to Students Menu</a>"; ?></p>
		</form>
	<?php }; // ends isset($_POST['submit'] ?>
</article>

<?php require("includes/footer.php"); ?>