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
       // echo $dept . "<br/>";
       // echo $session . "<br/>" ;   
        

        // Database submission only proceeds if there were NO errors.
        if(empty($errors)){

            // initialize tables
           // $table_course = $dept . 'c';
            //$table_reg = $dept . 'cr';
            $table_tra = $dept . 'tra';
            $table_mas = $dept . 'mas';

            // append students records from users_student table to the master result table for the session
            //$adm_sess = 14;
            //$stud_set = get_records_by_deptsession($dept, $adm_sess);
            $stud_set = get_records_by_deptsession($dept, $session);
            $stud_count = mysql_num_rows($stud_set);
            echo $stud_count . "<br/>" ;
            while($student = mysql_fetch_array($stud_set)){
                /*$query = "INSERT INTO $table_mas ( 
                            stu_name, stu_sex, regno, adm_sess, dept 
                              ) VALUES ( 
                              '{$student['stu_name']}', '{$student['stu_sex']}', '{$student['username']}', 
                              '{$adm_sess}', '{$dept}' )"; */
                $query = "INSERT INTO $table_mas ( 
                            stu_name, stu_sex, regno, adm_sess, dept 
                              ) VALUES ( 
                              '{$student['stu_name']}', '{$student['stu_sex']}', '{$student['username']}', 
                              '$session', '{$dept}' )";
                $result = mysql_query($query, $connection);
                confirm_query($result);
            }
          
        }else{  // empty(errors)
            echo "Please select all information and check your course code <br/><br/>";
            echo "<a href=\"masterresultappend.php\">Try Again</a>";
        } // ends empty(errors)
       
         echo "<a href=\"index.php\">Return to Menu</a>";

    } else {  // isset($_POST['submit'])
    ?>    
	    <form action="masterresultappend.php" method="post">
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