<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<article class="col-lg-12 col-sm-12 ">
 <?php
    include_once("includes/form_functions_processing.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted
  
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('dept', 'session', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
           redirect_to("contentsouthingam.php");
        }
    
        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        //echo $semester . "<br/>";
                
       // Initialize credit units for courses from Course table database.
            $table_course = $dept . "c";
            $course_set = get_all_department_courses_by_semester($table_course , $semester);
        
        // get the start course column from the course table and initialize the course_id to begin from.
            $cou_start = get_start_course_by_semester($table_course, $semester);
            $course_start_id = $cou_start['course_id'];
            //echo $course_start_id;

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

        
        // initialize gpa for the semester
            $gpa = "gpa" . $semester; // to be given either gpa1 or gpa2 depending on the semesters
            //echo $gpa;
                
        // Claculate Total Grade Point for each course a student took.
        // = (credit unit [of a course] * Grade Point [for each grade. eg A is 5]) 
            $table_tra = $dept . "tra" ;
            //echo $table_tra ." ";
            $result_tra_set = get_records_by_SessionSemester($table_tra, $session, $semester);
            $stu_count = mysql_num_rows($result_tra_set);
           // echo $stu_count . "<br/>" ;
            while($student = mysql_fetch_array($result_tra_set)){
           // $student = mysql_fetch_array($result_tra_set);
                $regno = $student['regno'];
                $grand_total_grade_point = 0;
                $grand_total_credit_unit = 0;
                //$i = 1;

                switch ($semester) {  // 2nd switch()
                    case $semester == 1:
                        for($i = 1; $i <= $total_course_semester1_count; $i++){ // Total Grade Point
                            // for each course per student
                            $total_grade_point = 0;
                            $total_credit_unit = 0;
                            $c_count = 'c' . $i;
                            $credit = 'credit' . $i;  // credit unit for current course to be used in var var.
                            $score = $student[$c_count] ;
                           // echo $c_count . " " .  $score .  " " . $$credit . " ->" ;
                                if(!empty($score)){
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
                                        
                                        $total_grade_point = $grade_point * $$credit;
                                       // echo $$credit . " * " . $grade_point . " = " . $total_grade_point ."<br/>";
                                        $grand_total_credit_unit += $$credit;
                                        $grand_total_grade_point += $total_grade_point;
                                        
                                    }

                        } // ends for($i). End of one course for the same student. Go to next course.

                    break;

                    case $semester == 2:
                        for($i = $course_start_id; $i <= $total_course_semester2_count; $i++){ // Total Grade Point
                           // echo $i . "<br/>";
                            // for each course per student
                            $total_grade_point = 0;
                            $total_credit_unit = 0;
                            $c_count = 'c' . $i;
                            $credit = 'credit' . $i;  // credit unit for current course to be used in var var.
                            $score = $student[$c_count] ;
                           // echo $c_count . " " .  $score .  " " . $$credit . " ->" ;
                                if(!empty($score)){
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
                                        
                                        $total_grade_point = $grade_point * $$credit;
                                       // echo $$credit . " * " . $grade_point . " = " . $total_grade_point ."<br/>";
                                        $grand_total_credit_unit += $$credit;
                                        $grand_total_grade_point += $total_grade_point;
                                        
                                    }

                        } // ends for($i). End of one course for the same student. Go to next course.

                    break;

                    default:

                    break;

                } // ends 2nd switch()

                if($grand_total_credit_unit != 0){   // Avoid division by zero error
                    $g = $grand_total_grade_point / $grand_total_credit_unit; // for current student.
                    $gradepointaverage = number_format($g, 2, '.', '');
                    // echo "===============<br/>";
                    // echo "Grand Total Credit Units = " . $grand_total_credit_unit . "   Grand Total Grade Points = " . $grand_total_grade_point . "<br/>";
                    // echo "GPA = " . $gpa ."<br/>";
                    //  echo "===============<br/>";

                    // update the current student GPA . $gradepointaverage is used instead of $gpa to avoid
                    // conflict with $gpa at the left                                         
                    $query = "UPDATE $table_tra SET 
                                $gpa = '$gradepointaverage' 
                                WHERE regno = '$regno' AND session = '$session' AND (semester = '$semester' OR semester2 = '$semester') ";
                    $result = mysql_query($query, $connection) or die('Result Processing failed' . mysql_error($connection));
                }
          
            } // end while($student). End of one student. To now go to the next student.
      
    ?>

    <p>GPA computed successfully</p>
    <a href="index.php">Return to menu</a>
</article>

<?php require("includes/footer.php"); ?>