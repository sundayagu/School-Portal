<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_senates(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-3 col-sm-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="courseStatistics1.php">Check Course Registration Summaries</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcompositesheet.php">Check Composite Results</a></li>
                <li>&nbsp;</li>
                <li><a href="viewsenatesheet.php">Check Summary Results</a></li>
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
        $required_fields = array('dept', 'session', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
          echo "<br/>Please Select all the information !!!<br/><br/>";
          echo "<a href=\"courseStatistics1.php\">Try Again</a>";
          // redirect_to("courseStatistics1.php");
        } else{
    
        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));

        $deptdisplay = get_department_by_deptcode($dept);
        $sessdisplay = get_session_by_sesscode($session);
        $semedisplay = get_semester_by_id($semester);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);
               
        // set the variables for Coures_Registration and Course tables for the department
            $table_reg = $dept . "cr";
            $table_course = $dept . "c";

        // Dispaly Heading
           echo "<h4 style=\"color:red\">SUMMARY OF STUDENTS COURSE REGISTRATION:</h4>";
           echo "<h5><b>Faculty: </b>" . trim($facudisplay['faculty_name']) . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <b>Session: </b>" . trim($sessdisplay['session_title']) . "
                </h5>" ;
           echo "<h5><b>Department: </b>" . trim($deptdisplay['dept_name']) . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Semester: </b>" . trim($semedisplay['semester_name']) . "</h5>" ;
           echo "<h5 style=\"color:blue\">==============================================================================================</h5>";
           //echo "<br/>";

        $course_set = get_all_department_courses_by_semester($table_course, $semester);
        echo "<table border=\"1\" style=\"width:100%\">";
                 echo "<tr>";
                    echo "<th>S/N</th>";
                    echo "<th>COURSE CODE</th>";
                    echo "<th>COURSE TITLE</th>";
                    echo "<th>NO. OF STUDENTS</th>";
                 echo "</tr>";;  
        $i = 1; // replaced $sn for serial number to cater for second semester
        while($course = mysql_fetch_array($course_set)){ // To count students for each course.
           $sn = $course['course_id'];  // id for each course used in forming course_column
           $course_column = 'c' . $sn; /* to be used in Course_Reg table in determining those
                                             that registered the course. Also used in createresulttra2.php
                                             in forming the name of the Result tables that will be generated
                                             in the program, which will help us in identifying 
                                             the Result tables to be used updating the 
                                             Result Transaction tables. until then   */

            // Query CourseRegistration table for all the students who registered for the current course for the session and semester
            //$student_set = get_all_registered_and_nonregistered_students_for_a_course($table_reg, $course_column);
              $student_set = get_all_students_who_registered_for_a_course_by_session_by_semester_by_courseColumn($table_reg, $session, $semester, $course_column);
            

            // Count Students who registered for the current course in the loop
                $nc = 0;  //  initialize the number of students that 
                          //registered for the current Course in the loop
                while($student = mysql_fetch_array($student_set)){
                   
                    if($student[$course_column] == 1){
                       $nc += 1; 
                    }   
                }
                echo " <tr> ";
                    echo "<td> {$i} </td>";
                    echo "<td> {$course['course_code']} </td>";
                    echo "<td> {$course['course_title']} </td>";
                    echo "<td> {$nc} </td>";  // number of students
                echo " </tr> ";
                $i += 1;
        }
        echo " </table> ";
       
        $student_set = get_records_by_SessionSemester($table_reg, $session, $semester);
        $student_count = mysql_num_rows($student_set);
        $course_count = mysql_num_rows($course_set);
       // echo "<br/>";
        echo "<h5 style=\"color:blue\">==============================================================================================</h5>";
        echo "<h4>Total Number of Courses: " . $course_count . "</h4>";
        // echo "<br/>";
        echo "<h4>Total Number of Students: " . $student_count . "</h4>";
        echo "<br/>";
         echo "<a href=\"courseStatistics1.php\">Check Again</a>";
         echo "<br/>";
        echo "<a href=\"senates.php\">Return to Senates menu</a>";
    }
    ?>
    
</article>

<?php require("includes/footer.php"); ?>