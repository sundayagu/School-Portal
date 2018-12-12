<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_management(); ?>
<?php include("includes/header_print.php"); ?>

<!--
<aside class="col-lg-1 col-sm-1">
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="viewcourses1.php">View Student's Registered courses</a></li>
            </ul>
        </div>
    </div>  
       
</aside>
--> 

<article class="col-lg-12">
    <!--
    <ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="staff.php">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    -->
            
    <?php
    include_once("includes/form_functions.php");
    
    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted

    if(isset($_POST['submit'])){
        // initialize array to hold errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('dept', 'session', 'semester', 'ccode');
        $errors = array_merge($errors, check_required_fields($required_fields));

        $fields_with_lengths = array('ccode' => 6);
        $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

        // clean up the form data before putting it in the database
        
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
        $ccode = trim(mysql_prep($_POST['ccode']));

        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){
        
        // Prepare faculty and dapartment data for displaying headings
        
        $deptdisplay = get_department_by_deptcode($dept);

        $faculty_type = $deptdisplay['faculty_type'];
        $facudisplay = get_faculty_by_id($faculty_type);

        $sessdisplay = get_session_by_sesscode($session);
        
        // Prepare course data for displaying headings
        $table_course = $dept . "c";
        $course = get_department_course_by_coursecode($table_course, $ccode);
        $course_column = 'c' . $course['course_id'];

        // Prepare Semester data for displaying headings
        $semest = get_semester_by_id($semester); 
        
        // Prepare level data for displaying headings
        $level = $course['level_type'];
        $level_name = get_level_by_id($level); 

        //Determine statistics
        $table_result = $dept . $session . $level . $semester . $course_column . $ccode . 'res';

        $suma=0;$sumb=0;$sumc=0;$sumd=0;$sume=0;$sumf=0;$sumdefect=0;
        $result_set = get_all_student_course_result($table_result);
        while($result = mysql_fetch_array($result_set)){
            $grade = $result['grade'];
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
            }
        }
        
        $totalsum = $suma + $sumb +$sumc +$sumd +$sume + $sumf + $sumdefect;
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
        <div style="background-color:#000000"><h3 style="vertical-align:buttom; text-align:center; color:#ffffff"><b>MADONNA UNIVERSITY, ELELE</b></h3>
            <p style="text-align:center; color:#ffffff"><b>ELELE, RIVERS STATE, NIGERIA</b></p>
        </div><p style="text-align:center"><b>RESULT SCORE SHEET</b></p>
        <div>
        <h4 style="text-align:center"><?php echo $course['course_code'] . "  " . $course['course_title'] ; ?></h4>
        <table cellspacing="2" style="width:100%;">
            <tr><td style="text-align:center"><b>Faculty:</b>&nbsp;&nbsp;<?php echo trim($facudisplay['faculty_name']) ; ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr><td style="text-align:center"><b>Department:</b>&nbsp;&nbsp;<?php echo trim($deptdisplay['dept_name']); ?></td>
            </tr>
            <tr><td style="text-align:center"><b>Level:</b>&nbsp;&nbsp;<?php echo trim($level_name['level_name']) ; ?></td>
                <td style="text-align:center"><b>Credit Units:</b>&nbsp;&nbsp;<?php echo $course['credit_unit'] ; ?></td>
                <td>
                </td>
            </tr>
            <tr><td style="text-align:center"><b>Session:</b>&nbsp;&nbsp;<?php echo trim($sessdisplay['session_title']) ?></td>
                <td style="text-align:center"><b>Cordinator:</b>&nbsp;&nbsp;<?php echo $course['cordinator'] ?></td>
                <td>
                </td>
            </tr>
            <tr><td style="text-align:center"><b>Semester:</b>&nbsp;&nbsp;<?php echo trim($semest['semester_name']) ; ?></td>
                <td>
                    <table border="1" style="width:100%">
                        <tr>
                            <td>PASS</td>
                            <td>FAIL</td>
                            <td>DEFECTS</td>
                        </tr>
                        <tr>
                            <td><?php echo number_format($percentpass, 2, '.', '') . "%"; ?></td>
                            <td><?php echo number_format($percentf, 2, '.', '') . "%"; ?></td>
                            <td><?php echo number_format($percentdefect, 2, '.', '') . "%"; ?></td>
                        </tr>
                    </table>
                </td>   
            </tr>
        </table>
        <table border="1" style="width:100%">
            <tr>
                <td></td>
                <td>GRADE</td>
                <td>A</td>
                <td>B</td>
                <td>C</td>
                <td>D</td>
                <td>E</td>
                <td>F</td>
                <td>DEFECTIVE</td>
            </tr>
            <tr>
                <td style="text-align:center;"><b>RESULT ANALYSIS</b></td>
                <td>NUMBER</td>
                <td><?php echo $suma; ?></td>
                <td><?php echo $sumb; ?></td>
                <td><?php echo $sumc; ?></td>
                <td><?php echo $sumd; ?></td>
                <td><?php echo $sume; ?></td>
                <td><?php echo $sumf; ?></td>
                <td><?php echo $sumdefect; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>PERCENTAGE</td>
                <td><?php echo number_format($percenta, 2, '.', '') . "%"; ?></td>
                <td><?php echo number_format($percentb, 2, '.', '') . "%"; ?></td>
                <td><?php echo number_format($percentc, 2, '.', '') . "%"; ?></td>
                <td><?php echo number_format($percentd, 2, '.', '') . "%"; ?></td>
                <td><?php echo number_format($percente, 2, '.', '') . "%"; ?></td>
                <td><?php echo number_format($percentf, 2, '.', '') . "%"; ?></td>
                <td><?php echo number_format($percentdefect, 2, '.', '') . "%"; ?></td>
            </tr>
        </table>
        <br/>

        <table border="1" style="width:100%">
            <tr>
                <th>S/N</th>
                <th>REGISTRATION NUMBER</th>
                <th>CA SCORE</th>
                <th>EXAMINATION SCORE</th>
                <th>TOTAL</th>
                <th>GRADE</th>
                <th>REMARK</th>
            </tr>
            <?php
                $sn = 1;
                $result_set = get_all_student_course_result($table_result);
                while($result = mysql_fetch_array($result_set)){
            ?>
            <tr>
                <td><?php echo $sn; ?></td>
                <td><?php echo $result['regno']; ?></td>
                <td><?php echo $result['ca']; ?></td>
                <td><?php echo $result['exam']; ?></td>
                <td><?php echo $result['total']; ?></td>
                <td><?php echo $result['grade']; ?></td>
                <td><?php echo $result['remark']; ?></td>
            </tr>
            <?php
                    $sn += 1;
                }

            ?>
        </table>
        </div> 
        <br/> 
        <?php           
        }else{  // empty(errors)
            echo "Please select all information and check your course code <br/><br/>";
            echo "<a href=\"viewgroupresult_mgt.php\">Try Again</a>";
        } // ends empty(errors)
       
         echo "<a href=\"contentsouthingam.php\">Return to Menu</a>";

    } else {  // isset($_POST['submit'])
    ?>    
	    <form action="viewgroupresult_mgt.php" method="post">
	    	<p><b>Select Class Information</b></p>
			
        <?php page_form(); ?>
        <!-- Lecturer should know the Course Code for Security reasons (integrity) -->
        <p>Course Code:<input type="text" name="ccode" value="" /></p>
        <br/>
		    <p><input type="submit" name="submit" value="Submit" /></p>
		</form>
	<?php }; // ends isset($_POST['submit'] ?>

    <a href="contentsouthingam.php">cancel</a>
</article>

<?php require("includes/footer.php"); ?>