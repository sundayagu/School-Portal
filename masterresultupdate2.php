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
            $table_tra = $dept . 'tra';
            $table_mas = $dept . 'mas';
            
            // determine maximun level for the department
            //$level = 5 ; // to be used removing spillover students. 
            $deptmt = get_department_by_deptcode($dept);
            $max_lev = $deptmt['max_level'];
            
            switch ($max_lev) {
                case $max_lev == 4: // for departments which maximum level is 400.
            
                    //get results of the dept for the session and semester from Transaction Result table
                    $stud_tra = get_records_by_SessionSemesterLevel($table_tra, $session, $semester, $max_lev+1);
                    $stud_count = mysql_num_rows($stud_tra);
                    //echo $stud_count . "<br/>" ;
                    
                    // update each student gpa in the master result table from transaction result table
                    while ($student = mysql_fetch_array($stud_tra)) {
                        $regno = $student['regno'];
                        $level = $student['level_type'];
                       // if ($level < 5) {  // taken care of in the function to avoid getting filtering spill over 
                                            // students here and wasting cpu time

                        // No checking of registered courses because we are dealing with GPAs only, not courses

                        $gpa_tra = 'gpa' . $semester;
                        $gpa_mas = 'gpa' . $level . $semester;  // handles both semesters
                        
                        $query = "UPDATE $table_mas SET 
                                    $gpa_mas = '$student[$gpa_tra]' 
                                WHERE regno = '$regno'";
                        $result1 = mysql_query($query, $connection);
                        confirm_query($result1);
                                                  
                    } // ends while($student) 

                break; // breaks 400 level

                case $max_lev == 5:
                    //get results of the dept for the session and semester from Transaction Result table
                    $stud_tra = get_records_by_SessionSemesterLevel($table_tra, $session, $semester, $max_lev+1);
                    $stud_count = mysql_num_rows($stud_tra);
                    //echo $stud_count . "<br/>" ;
                    
                    // update each student gpa in the master result table from transaction result table
                    while ($student = mysql_fetch_array($stud_tra)) {
                        $regno = $student['regno'];
                        $level = $student['level_type'];
                       // if ($level < 5) {  // taken care of in the function to avoid getting filtering spill over 
                                            // students here and wasting cpu time

                        // No checking of registered courses because we are dealing with GPAs only, not courses

                        $gpa_tra = 'gpa' . $semester;
                        $gpa_mas = 'gpa' . $level . $semester;  // handles both semesters
                        
                        $query = "UPDATE $table_mas SET 
                                    $gpa_mas = '$student[$gpa_tra]' 
                                WHERE regno = '$regno'";
                        $result1 = mysql_query($query, $connection);
                        confirm_query($result1);
                                                  
                    } // ends while($student) 


                break;

                case $max_lev == 6:
                    //get results of the dept for the session and semester from Transaction Result table
                    $stud_tra = get_records_by_SessionSemesterLevel($table_tra, $session, $semester, $max_lev+1);
                    $stud_count = mysql_num_rows($stud_tra);
                    //echo $stud_count . "<br/>" ;
                    
                    // update each student gpa in the master result table from transaction result table
                    while ($student = mysql_fetch_array($stud_tra)) {
                        $regno = $student['regno'];
                        $level = $student['level_type'];
                       // if ($level < 5) {  // taken care of in the function to avoid getting filtering spill over 
                                            // students here and wasting cpu time

                        // No checking of registered courses because we are dealing with GPAs only, not courses

                        $gpa_tra = 'gpa' . $semester;
                        $gpa_mas = 'gpa' . $level . $semester;  // handles both semesters
                        
                        $query = "UPDATE $table_mas SET 
                                    $gpa_mas = '$student[$gpa_tra]' 
                                WHERE regno = '$regno'";
                        $result1 = mysql_query($query, $connection);
                        confirm_query($result1);
                                                  
                    } // ends while($student) 

                break;


                default:

                break;


            } // ends switch($max_lev)
        
        
        }else{  // empty(errors)
            echo "Please select all information and check your course code <br/><br/>";
            echo "<a href=\"masterresultupdate2.php\">Try Again</a>";
        } // ends empty(errors)
       
         echo "<a href=\"index.php\">Return to Menu</a>";

    } else {  // isset($_POST['submit'])
    ?>    
	    <form action="masterresultupdate2.php" method="post">
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