<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-3 col-sm-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="">Populate Transaction Result Table</a></li>
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
           redirect_to("populateTraResult1.php");
        }
    
        // clean up the form data before putting it in the database
        $dept = trim(mysql_prep($_POST['dept']));
        $session = trim(mysql_prep($_POST['session']));
        $semester = trim(mysql_prep($_POST['semester']));
               
        // set the variables for Coures_Registration, Transaction Result and Course tables for the department
            $table_reg = $dept . "cr";
            $table_tra = $dept . "tra";
            
        // Query CourseRegistration table for all the students who registered for all courses for the session and semester
        $student_set = get_student_records_session_by_semester1_OR_2($table_reg, $session, $semester);
            
        // Populate Transaction Result table with the selected students for the session & semester
          
        switch ($semester) {
            case $semester == 1:
                while($student = mysql_fetch_array($student_set)){
                    // Confirm if the student has already been popluated for the session and semester
                    $regno = $student['regno'];
                    $populated = catch_populated_student($table_tra, $regno, $session, $semester);
                    if($sturow = mysql_fetch_assoc($populated)){
                        // already populated. therefore, do not populate the student
                    } else{
                        // not yet populated. therefore, populate the student.
                        $query = "INSERT INTO " . $table_tra . "( 
                                     stu_name, stu_sex, regno, session, level_type, semester
                                  ) VALUES ( 
                                    '{$student['stu_name']}','{$student['stu_sex']}', '{$student['regno']}',
                                    '{$student['session']}', '{$student['level_type']}', '{$student['semester']}' )";
                        $result = mysql_query($query, $connection);
                        confirm_query($result);
                    }
                }
       
            if($result){
                echo $dept . " department Results database successfully populated";
            }else{
                echo $dept . "department Results database could not be populated. Consult the Administrator";
            }
            break;
            case $semester == 2:
                while($student = mysql_fetch_array($student_set)){
                    // Confirm if the student has already been updated for the session and semester
                    // We are using the same function for confirming populated also for confirming updated.
                    $regno = $student['regno'];
                    $populated = catch_populated_student($table_tra, $regno, $session, $semester);
                    if($sturow = mysql_fetch_assoc($populated)){
                        // already updated. therefore, do not update the student
                    } else{
                        // not yet updated. therefore, update the student.
                    $query = "UPDATE $table_tra SET 
                                semester2 = $semester
                                WHERE regno = '$regno' AND session = '$session' ";
                    $result1 = mysql_query($query, $connection);
                    confirm_query($result1);
                    }
                }

            break;

            default:

            break;

        } //


        echo "<br/>";
        echo "<a href=\"index.php\">Return to Home</a>";
    ?>
    
</article>

<?php require("includes/footer.php"); ?>