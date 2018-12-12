<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php //include("includes/header.php"); ?>
<?php // require("includes/constantsAcademicSession.php"); ?>
<aside class="col-lg-3 col-sm-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_hod1.php">Edit Hods's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="assigncou1.php">Assign Courses</a></li>
                <li>&nbsp;</li>
                <li><a href="attendants.php">Generate Attendants Sheets</a></li>
                <li>&nbsp;</li>
                <li><a href="searchStudents.php">Search Students Data</a></li>
                <li>&nbsp;</li>
                <li><a href="searchResults1.php">Search Students Results</a></li>
                <li>&nbsp;</li>
                <li><a href="viewlevelcourses.php">Check Registered Departmental Level Courses</a></li>
                <li>&nbsp;</li>
                <li><a href="viewgroupresult.php">Check Class Results</a></li>
                
            </ul>
        </div>
    </div>    
</aside>
<?php include("includes/header.php"); ?>
<article class="col-lg-8 col-lg-offset-1 col-sm-8 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Hod's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3>Course Assignments</h3>
    
    <!-- first form processing starts here (Posted from createcoureg1.php) by
        (1) Caputuring the selected info from createcoureg1.php Form
        (2) Filling a second Form by ticking the coures to register -->
    <?php
    
    include_once("includes/form_functions.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted
  
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('dept', 'session', 'semester');
        $errors = array_merge($errors, check_required_fields($required_fields));

        // Database submission only proceeds if there were NO errors.
        if(!empty($errors)){

            echo "Please select all the information!!";
            echo "<a href:\"assigncou1.php\">Try Again</a>";
            // redirect_to("assigncou1.php");
        } else{

        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
       
        $deptdisplay = get_department_by_deptcode($dept);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);
        $sessdisplay = get_session_by_sesscode($session);
        $semedisplay = get_semester_by_id($semester);
        
    ?>
        <?php include("includes/header.php"); ?>
        <Div><b>By</b>&nbsp;&nbsp;<?php echo $_SESSION['username'] ; ?>&nbsp;&nbsp;<?php echo $_SESSION['hod_name'] ; ?>
            &nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']); ?>
            &nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']); ?>
            &nbsp;&nbsp;<?php echo trim($semedisplay['semester_name']); ?> Semester
        </Div> 
        <br/> 
        <p><b>Please tick the courses and select the lecturers appropriately</b></p>    
        <table border="1" style="width:100%">
            <tr>
                <th>S/N</th>
                <th>Tick</th>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Cordinator</th>
                <th>2nd Lecturer</th>
                <th>Modulator</th>
            </tr>
    <?php
        
        
        $table_course = $dept . "c";
        $cordinator = 'cordinator' . $session;
        $cor_username = 'username' . $session;
        $second_lec = 'second_lec' . $session;
        $sec_username = 'susername' . $session;
        $modulator = 'modulator' . $session;
        $mod_username = 'musername' . $session;

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
        
        //get the courses for the semester
            $course_set = get_all_department_courses_by_semester($table_course, $semester);
            //$course_count = mysql_num_rows($course_set);

        $sn = $course_start_id;  // represents the course columns. its also used for serial number
                                  // for the 1st semester only
        $i = 1; // represents the serial number, to be used for the second semester only.

        $cordinator = 'cordinator' . $sn;  // representing the cordinators for the courses serially. i.e cordinator
                                           // for 1st courese, 2nd course and so on.
        $second_lec = 'second_lec' . $sn;
        $modulator = 'modulator' . $sn;

        switch ($semester) {
            case $semester == 1:
                while($course = mysql_fetch_array($course_set)){
                    // filter all the department lecturers
                        $table_lec = 'users_lecturer';
                        $lecturers = get_records_by_deptcode($table_lec, $dept);

                    echo " <form action=\"createcoureg3.php?course_start_id=$course_start_id&dept=$dept&session=$session&semester=$semester&course_count=$total_course_semester1_count&table_course=$table_course\" method=\"post\"> ";
                    echo " <tr>  ";
                        echo " <td>{$sn}</td> ";
                        echo " <td><input type=\"checkbox\" name=\"$sn\" />   </td>";
                        echo " <td>{$course['course_code']}</td> ";
                        echo " <td>{$course['course_title']}</td> ";
                        echo " <td>

                                    <select name='$cordinator'>";
                                            echo "<option></option>";
                                        while ( $lecturer = mysql_fetch_array($lecturers)) {
                                            echo "<option value=\"{$lecturer['lec_name']}\" >{$lecturer['lec_name']}</option>";
                                        }
                                        $cor_username = 'username' . $sn;  // 

                                    echo "</selesct>
                                
                                </td> ";

                        
                        // filter all the departments lecturers for the 2nd lecturer
                        $table_lec = 'users_lecturer';
                        $lecturers = get_records_by_deptcode($table_lec, $dept);
                        echo " <td>

                                    <select name='$second_lec'>";
                                            echo "<option></option>";
                                        while ( $lecturer = mysql_fetch_array($lecturers)) {
                                            echo "<option value=\"{$lecturer['lec_name']}\" >{$lecturer['lec_name']}</option>";
                                        }
                                        $sec_username = 'susername' . $sn;


                                    echo "</selesct>
                                
                                </td> ";


                        
                        // filter all the departments lecturers for the Modulator
                        $table_lec = 'users_lecturer';
                        $lecturers = get_records_by_deptcode($table_lec, $dept);
                        echo " <td>

                                    <select name='$modulator'>";
                                            echo "<option></option>";
                                        while ( $lecturer = mysql_fetch_array($lecturers)) {
                                            echo "<option value=\"{$lecturer['lec_name']}\">{$lecturer['lec_name']}</option>";
                                        }
                                        $mod_username = 'musername' . $sn;

                                    echo "</selesct>
                                
                                </td> ";



                    echo " </tr> ";
                    $sn = $sn + 1;
                    $cordinator = 'cordinator' . $sn;
                    $second_lec = 'second_lec' . $sn;
                    $modulator = 'modulator' . $sn;
                }
                echo " </table> ";
                echo "</br>";
                echo " <p><input type=\"submit\" name=\"submit3\" value=\"Continue to Step 3 of 3\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"hods.php\">Return to Students Menu</a></p> ";
                echo " </form> ";
                echo"<br/>";
                

            break;

            case $semester == 2:
                while($course = mysql_fetch_array($course_set)){
                    echo " <form action=\"createcoureg3.php?course_start_id=$course_start_id&level_type=$level_type&dept=$dept&session=$session&semester=$semester&course_count=$total_course_semester2_count&table_course=$table_course\" method=\"post\"> ";
                    echo " <tr>  ";
                        echo " <td>{$i}</td> ";
                        echo " <td><input type=\"checkbox\" name=\"$sn\" />   </td>";
                        echo " <td>{$course['course_code']}</td> ";
                        echo " <td>{$course['course_title']}</td> ";
                        echo " <td>{$course['credit_unit']}</td> ";
                    echo " </tr> ";
                    $sn = $sn + 1;
                    $i = $i + 1 ;
                }
                echo " </table> ";
                echo "</br>";
                echo " <p><input type=\"submit\" name=\"submit3\" value=\"Continue to Step 3 of 3\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"hods.php\">Return to Menu</a></p> ";
                echo " </form> ";

            break;

            default:
                # code...
                break;

        } // ends switch semester

    }// ends if(!empty(errors)) at line 57




    
    ?>
</article>

<?php require("includes/footer.php"); ?>