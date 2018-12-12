<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php //confirm_logged_in_lecturers(); ?>
<?php include("includes/header_print.php"); ?>

<article class="col-lg-12">
           
    <?php
    include_once("includes/form_functions_viewing.php");
    
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
        
        // Prepare faculty and dapartment data for displaying headings
        $deptdisplay = get_department_by_deptcode($dept);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);

        $sessdisplay = get_session_by_sesscode($session);
        $semest = get_semester_by_id($semester); 
 
        // initialize tables
        $table_course = $dept . "c";
        $table_reg = $dept . "cr";
        $table_result = $dept . 'tra';
        ?>
        <div><p style="text-align:center;color:red"><b>DEPARTMENT OF&nbsp;&nbsp;<?php echo trim(strtoupper($deptdisplay['dept_name'])); ?></b></p>
            <p style="text-align:center; color:blue"><b>END OF&nbsp;&nbsp;<?php echo trim(strtoupper($semest['semester_name'])); ?>&nbsp;&nbsp;SEMESTER RESULTS&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ?> </b></p>
        </div>

        <?php

        // Determine and display statistics for each course
        $course_set = get_all_department_courses_by_semester($table_course, $semester);
        $course_count = mysql_num_rows($course_set);
        //echo $course_count;
            
            $sn = 1;
            ?>
                <table border="1" style="width:100%">
                <tr>
                    <th style="background:yellow">S/N</th>
                    <th style="background:yellow">CCODE</th>
                    <th style="width:25%; background:yellow">COURSE TITLE</th>
                    <th style="background:yellow">ROLL</th>
                    <th style="background:yellow">PASS</th>
                    <th style="background:yellow">FAIL</th>
                    <th style="background:yellow">A</th>
                    <th style="background:yellow">B</th>
                    <th style="background:yellow">C</th>
                    <th style="background:yellow">D</th>
                    <th style="background:yellow">E</th>
                    <th style="background:yellow">F</th>
                    <th style="background:yellow">DEF</th>
                    <th style="background:yellow">% PASS</th>
                    <th style="background:yellow">% FAIL</th>
                    <th style="background:yellow">% DEF</th>
                </tr>
            <?php

            while ($course = mysql_fetch_array($course_set)){

            $course_column = 'c' . $course['course_id'];  // initialize course_column and grade for each course
            $gra = 'g' . $course['course_id'];  // we used $gra to avoid conflicting with $grade of switch case

            //    $course_column = 'c1';
            //    $gra = 'g1';
                
                // determine statistics using Transaction Result table
                $suma=0;$sumb=0;$sumc=0;$sumd=0;$sume=0;$sumf=0;$sumdefect=0;
                
                $result_set = get_students_record_by_SessionSemester($table_result, $session, $semester);
                $student_count = mysql_num_rows($result_set);
                //echo $student_count;
                
                while($result = mysql_fetch_array($result_set)){

                    $stu_regno = $result['regno'];

                    // check if the student registered for the course. if yes, include the student in the statistics
                    // otherwise next student.
                    $regis = get_student_record_by_RegnoSessionSemesterCoursecolumn($table_reg , $stu_regno, $session, $semester, $course_column);
                    if($sturow = mysql_fetch_assoc($regis)) { // if true, include in the statistics
                        extract($sturow); // not needed though.

                        $grade = $result[$gra];
                        switch ($grade) {
                            case $grade == 'A':
                                $suma += 1;
                                break;
                            case $grade == 'B':
                                $sumb += 1;
                                break;
                            case $grade == 'C':
                                $sumc += 1;
                                break;
                            case $grade == 'D':
                                $sumd += 1;
                                break;
                            case $grade == 'E':
                                $sume += 1;
                                break;
                            case $grade == 'F':
                                $sumf += 1;
                                break;

                            default:
                                $sumdefect += 1;
                                break;
                        } // ends switch($grade)

                    } // ends if registered. otherwise

                } // ends while. Next Student Result from Transaction Result table
                
                $totalsum = $suma + $sumb +$sumc +$sumd +$sume + $sumf + $sumdefect;
                if($totalsum >= 1){
                    $percenta = $suma / $totalsum * 100;
                    $percentb = $sumb / $totalsum * 100;
                    $percentc = $sumc / $totalsum * 100;
                    $percentd = $sumd / $totalsum * 100;
                    $percente = $sume / $totalsum * 100;
                    $percentf = $sumf / $totalsum * 100;
                    $percentdefect = $sumdefect / $totalsum * 100;

                    $totalpass = $suma + $sumb +$sumc +$sumd + $sume;
                    $percentpass = $totalpass / $totalsum * 100;

                ?>
                <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $course['course_code']; ?></td>
                    <td><?php echo $course['course_title']; ?></td>
                    <td><?php echo $totalsum; ?></td>
                    <td><?php echo $totalpass; ?></td>
                    <td><?php echo $sumf; ?></td>
                    <td><?php echo $suma; ?></td>
                    <td><?php echo $sumb; ?></td>
                    <td><?php echo $sumc; ?></td>
                    <td><?php echo $sumd; ?></td>
                    <td><?php echo $sume; ?></td>
                    <td><?php echo $sumf; ?></td>
                    <td><?php echo $sumdefect; ?></td>
                    <td><?php echo number_format($percentpass, 2, '.', '' ); ?></td>
                    <td><?php echo number_format($percentf, 2, '.', ''); ?></td>
                    <td><?php echo number_format($percentdefect, 2, '.', '') ; ?></td>
                </tr>



                <?php
                } // ends if($totalsum >= 1)

                $sn += 1 ;
            } // ends while. Next Course
           
            ?>
                </table>
            <?php

        }else{  // empty(errors)
            echo "Please select all information and check your course code <br/><br/>";
            echo "<a href=\"viewsenatesheet.php\">Try Again</a>";
        } // ends empty(errors)
        echo "<br/>";
        echo "<a href=\"viewsenatesheet.php\">Check Again</a>";
        echo "<br/><br/>";

    } else {  // isset($_POST['submit'])
    ?>    
	    <form action="viewsenatesheet.php" method="post">
	    	<h3 style="color:red">Checking Summary Results. </h3>
        <p style="color:blue"><b><em>Select Departments Information</em></b></p>
        <br/>
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

    <a href="senates.php">Return to Senates Menu</a>
</article>

<?php require("includes/footer.php"); ?>