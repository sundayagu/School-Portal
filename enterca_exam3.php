<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_lecturers(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_lecturer1.php">Edit Lecturer's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="enterca_exam.php">Enter CA / Exam Scores</a></li>
                <li>&nbsp;</li>
                <li><a href="enterca_exam.php">Edit CA / Exam Scores</a></li>
                <li>&nbsp;</li>
                <li><a href="#.php">Modulate Result</a></li>
                <li>&nbsp;</li>
                <li><a href="viewgroupresult.php">Check Class(Level) Result</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">CA and Exam Input Form</h3>
        
    <?php
        // Capture URL GET data
            $dept = mysql_prep($_GET['dept']);
            $session = mysql_prep($_GET['session']);
            $semester = mysql_prep($_GET['semester']);
            $course_column = mysql_prep($_GET['course_column']);
            $ca = mysql_prep($_GET['ca']);
            $exam = mysql_prep($_GET['exam']);
        
        // declare tables
            $table_tra = $dept . 'tra';
            $table_reg = $dept . 'cr';

        // Get students who registered for the course for the session & semester from 
        // Course_Registration table
        $student_set = get_all_students_who_registered_for_a_course_by_session_by_semester_by_courseColumn($table_reg, $session, $semester, $course_column);

               
            $sn = 1; // used in capturing students' CAs and Exams rows as was used in enterca_exam2.php
            while($student = mysql_fetch_array($student_set)){
                
                $reg = $student['regno'];

                /* Get this student's record from Transaction Result table based on regno, session and semester,
               for posting of the student's ca and exam for the Course in question */
                //this function get_student_examca_entry_record() is replaced as below to cater for semesters 1 and 2
                $student_rec = get_student_records_byRegnoSessionSemester1_or_2($table_tra, $reg, $session, $semester);
                
                $regno = $student['regno'];
                              
                // Capture POSTed data using loop.
                $stuca_row = 'ca' . $sn;
                $stuexam_row = 'exam' . $sn;                
                $stuca_row = mysql_prep($_POST[$stuca_row]);
                $stuexam_row = mysql_prep($_POST[$stuexam_row]);

                $query = "UPDATE $table_tra SET 
                                $ca = '$stuca_row',
                                $exam = '$stuexam_row'
                            WHERE regno = '$regno' AND session = '$session' AND (semester = '$semester' OR semester2 = '$semester') ";
                $result = mysql_query($query, $connection);
                confirm_query($result);

                $sn = $sn + 1;
            }


            if($result){
                    echo "Success";
                }else{
                    echo "Failed";
                }
            echo "<br/><br/>";

            echo "<a href=\"lecturers.php\">Return to Lecturer's Menu</a>";
     
    ?>
    
</article>

<?php require("includes/footer.php"); ?>