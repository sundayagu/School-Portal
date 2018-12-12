<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="login_students.php">Login / Complete Students User Account</a></li>
                <li>&nbsp;</li>
                <li><a href="editnew_user_student1.php">Edit Student's  Users Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="pwordrset1.php">Forget Password</a></li>
                <li>&nbsp;</li>
                <li><a href="createcoureg1.php">Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="editcoureg1.php">Edit Course Registration</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcourses1.php">View Registered courses</a></li>
                <li>&nbsp;</li>
                <li><a href="viewexameligibility.php">Check Examinations Eligibility</a></li>
                <li>&nbsp;</li>
                <li><a href="viewindividualresult.php">Check Results Per Semester</a></li>
                <li>&nbsp;</li>
                <li><a href="viewstatementofresult_tra.php">Check Results Per Sesssion</a></li>
                <li>&nbsp;</li>
                <li><a href="trackindividualresults.php">Check All Sessions Results</a></li>
                <li>&nbsp;</li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Student's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3>Course Registration</h3>
        
    <!-- last form processing starts here by 
        (1) Inserting the selected info from createcoureg1.php Form into database.
            Accepting the data that will be used in initializing the Course Registration table variable. (Remember that the Course Registration table was created from createcoureg2.php).
        (2) Updating Course Registration table with selected Courses that will be registered. (Remember that the selected Courses were filled in from the Form in creatcoureg2.php).-->
    <?php
        
        // Prepare variables for the POSTed Course Codes represented with $sn
        // And also the variables for the GET data of url, all from createcoureg2.php
            $totalcredit = 0;   // initialize it.
            //$totalcredit2 = 0; // not needed for the second semester. $totalcredit can serve for both semesters
            $table_course = mysql_prep($_GET['table_course']);
            $dept = mysql_prep($_GET['dept']);
            $session = mysql_prep($_GET['session']);
            $semester = mysql_prep($_GET['semester']);
            $level_type = mysql_prep($_GET['level_type']);
            $course_start_id = mysql_prep($_GET['course_start_id']); // to be used for second semester
            $course_count = mysql_prep($_GET['course_count']); // can be for semester 1 or 2 as determined by createcoureg2.php
            
            // Initialize the Course Registration Table.
            $table_reg = $dept . "cr";

            // Confirm if the student has already registered for the session and semester
            $registered = catch_registered_student($table_reg, $session, $semester);
            
            if($sturow = mysql_fetch_assoc($registered)){
                // Denial registration
                echo "You have registered for this session and semester. ";
                echo "<br/>";
                echo "<br/>Click <a href=\"editcoureg1.php\">Edit Course Registration</a>";
                echo "<br/><br/>";
                echo "<a href=\"students.php\">Return to Menu</a>";
                
            } else{
            // Allow registration

            switch ($semester) {
                case $semester == 1:

                    // Insert into database
                    $query = "INSERT INTO $table_reg (
                                    regno, stu_name, stu_sex, session, level_type, semester 
                                ) VALUES (
                                    '{$_SESSION['username']}', '{$_SESSION['stu_name']}', '{$_SESSION['stu_sex']}', '$session', '$level_type', '$semester'
                                )";
                    $result = mysql_query($query, $connection);
                    
                    if($result){
                        // Sucess and proceed with the filling of the second Form by ticking the courses to register.
                   
                        for($sn=1; $sn <= $course_count; $sn++){
                            if(isset($_POST[$sn])){                                    // if course is checked for registration
                                $course = get_course_details($table_course, $sn);      // get credit unit for the course code $sn
                                $totalcredit = $totalcredit + $course['credit_unit'];  // add credit unit to total credit unit.
                                $course_column = 'c' . $sn;                            // variable representing course field in database
                                    if($totalcredit <= 24){
                                        $query = "UPDATE $table_reg SET 
                                                    totalcredit = $totalcredit,
                                                    $course_column = 1 
                                                    WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester = $semester ";
                                        $result1 = mysql_query($query, $connection);
                                    }else{
                                        $message = "Maximum of 24 credit units only can be registered.<br/>";
                                        $message .= "Click <a href=\"students.php\">Return to Menu</a> and Click Edit button to see the courses you have registered and correctly complete the registration if need be.<br/>";
                                       // $message .= "<a href=\"editcoureg2edit.php?dept=$dept&session=$session&level_type=$level_type&semester=$semester&regno=$regno&stu_name=$stu_name\">Edit Course Registration</a>";  // variables will be passed.
                                    }
                            }else{  // isset($_POST[$sn])
                                $course_column = 'c' . $sn;
                                $query = "UPDATE $table_reg SET 
                                        $course_column = 0
                                        WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester = $semester ";
                                $result1 = mysql_query($query, $connection);
                            } // ends isset($_POST[$sn])

                        } // end for($sn=1; $sn<=$course_count; $sn++)

                                      
                        // Test and see if the updates occurred
                        if($result1){
                            //Success
                            if($totalcredit > 24){
                                $excess = $totalcredit - 24;
                                echo "<p>You attempted registering:&nbsp;&nbsp;" . $totalcredit  . "&nbsp;Credit Units.</p>";
                                echo "Excess of " . $excess . " credit units.<br/>";    
                                echo $message;
                            }else{
                                echo "<p>Course Registration completed successfully.</p>"; 
                                echo "<p>You registered a total of:&nbsp;&nbsp;" . $totalcredit  . "&nbsp;Credit Units.</p>" ;
                            echo "<br/>";
                                 echo "<br/>";
                                echo "<a href=\"students.php\">Return to Main menu</a>" ;
                            }
                       }  else{
                            // Failed
                            //$message = "The courses could not be registered.";
                            //$message .= "<br/>" . mysql_error();
                            echo "Course Registration failed mid-way. Consult Administrator"; // Admin will delete his record for fresh course registration.
                            echo "<a href=\"students.php\">Return to Main menu</a>" ;
                           // echo "Edit to see the state of your registration and complete the registration.";
                        }

                    } else{
                        // Database submission failed
                        echo "Reading personal info into Database failed---> ";
                        echo mysql_error();
                        echo "<br/>Click <a href=\"students.php\">Try Again</a>";
                    } // end the if(result) after insert query.


                break;

                case $semester == 2:
                    /* A Spill-over student may be registering only for semester 2 in this session. Therefore check if the student registered for semester1. if YES update his entire record, otherwise append.*/
                    
                    $RegisterOnlySemester2 = check_if_registered_for_semester1($table_reg, $session, 1);
                    if($stu_row = mysql_fetch_array($RegisterOnlySemester2)){
                        //echo  $stu_row['semester'] . " -> " . "semester 1 registered";
                        // update into database
                        $query = "UPDATE $table_reg SET 
                                    semester2 = $semester
                                    WHERE regno = '{$_SESSION['username']}' AND session = '$session' ";
                        $result1 = mysql_query($query, $connection);
                        for($sn=$course_start_id; $sn <= $course_count; $sn++){
                            if(isset($_POST[$sn])){                                    // if course is checked for registration
                                $course = get_course_details($table_course, $sn);      // get credit unit for the course code $sn
                                $totalcredit = $totalcredit + $course['credit_unit'];  // add credit unit to total credit unit.
                                $course_column = 'c' . $sn;                            // variable representing course field in database
                                    if($totalcredit <= 24){
                                        $query = "UPDATE $table_reg SET 
                                                    totalcredit2 = $totalcredit,
                                                    $course_column = 1 
                                                    WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester2 = $semester ";
                                        $result1 = mysql_query($query, $connection);
                                    }else{
                                        $message = "Maximum of 24 credit units only can be registered.<br/>";
                                        $message .= "Click <a href=\"students.php\">Return to Menu</a> and Click Edit button to see the courses you have registered and correctly complete the registration if need be.<br/>";
                                       // $message .= "<a href=\"editcoureg2edit.php?dept=$dept&session=$session&level_type=$level_type&semester=$semester&regno=$regno&stu_name=$stu_name\">Edit Course Registration</a>";  // variables will be passed.
                                    }
                            }else{  // isset($_POST[$sn])
                                $course_column = 'c' . $sn;
                                $query = "UPDATE $table_reg SET 
                                        $course_column = 0
                                        WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester2 = $semester ";
                                $result1 = mysql_query($query, $connection);
                            } // ends isset($_POST[$sn])

                        } // end for($sn=1; $sn<=$course_count; $sn++)

                                      
                        // Test and see if the updates occurred
                        if($result1){
                            //Success
                            if($totalcredit > 24){
                                $excess = $totalcredit - 24;
                                echo "<p>You attempted registering:&nbsp;&nbsp;" . $totalcredit  . "&nbsp;Credit Units.</p>";
                                echo "Excess of " . $excess . " credit units.<br/>";    
                                echo $message;
                            }else{
                                echo "<p>Course Registration completed successfully.</p>"; 
                                echo "<p>You registered a total of:&nbsp;&nbsp;" . $totalcredit  . "&nbsp;Credit Units.</p>" ;
                            echo "<br/>";
                                 echo "<br/>";
                                echo "<a href=\"students.php\">Return to Main menu</a>" ;
                            }
                       }  else{
                            // Failed
                            //$message = "The courses could not be registered.";
                            //$message .= "<br/>" . mysql_error();
                            echo "Course Registration failed mid-way. Consult Administrator"; // Admin will delete his record for fresh course registration.
                            echo "<a href=\"students.php\">Return to Main menu</a>" ;
                           // echo "Edit to see the state of your registration and complete the registration.";
                        }

                    } else{ // $RegisterOnlySemester2
                        // insert into database
                        $query = "INSERT INTO $table_reg (
                                    regno, stu_name, stu_sex, session, level_type, semester2 
                                ) VALUES (
                                    '{$_SESSION['username']}', '{$_SESSION['stu_name']}', '{$_SESSION['stu_sex']}', '$session', '$level_type', '$semester'
                                )";
                        $result = mysql_query($query, $connection);
                        
                        for($sn=$course_start_id; $sn <= $course_count; $sn++){
                            if(isset($_POST[$sn])){   // if course is checked for registration
                                $course = get_course_details($table_course, $sn); // get credit unit for the course code $sn
                                $totalcredit = $totalcredit + $course['credit_unit'];  // add credit unit to total credit unit.
                                $course_column = 'c' . $sn;                            // variable representing course field in database
                                    if($totalcredit <= 24){
                                        $query = "UPDATE $table_reg SET 
                                                    totalcredit2 = $totalcredit,
                                                    $course_column = 1 
                                                    WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester2 = $semester ";
                                        $result1 = mysql_query($query, $connection);
                                    }else{
                                        $message = "Maximum of 24 credit units only can be registered.<br/>";
                                        $message .= "Click <a href=\"students.php\">Return to Menu</a> and Click Edit button to see the courses you have registered and correctly complete the registration if need be.<br/>";
                                       // $message .= "<a href=\"editcoureg2edit.php?dept=$dept&session=$session&level_type=$level_type&semester=$semester&regno=$regno&stu_name=$stu_name\">Edit Course Registration</a>";  // variables will be passed.
                                    }
                            }else{  // isset($_POST[$sn])
                                $course_column = 'c' . $sn;
                                $query = "UPDATE $table_reg SET 
                                        $course_column = 0
                                        WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester2 = $semester ";
                                $result1 = mysql_query($query, $connection);
                            } // ends isset($_POST[$sn])

                        } // end for($sn=1; $sn<=$course_count; $sn++)

                                      
                        // Test and see if the updates occurred
                        if($result1){
                            //Success
                            if($totalcredit > 24){
                                $excess = $totalcredit - 24;
                                echo "<p>You attempted registering:&nbsp;&nbsp;" . $totalcredit  . "&nbsp;Credit Units.</p>";
                                echo "Excess of " . $excess . " credit units.<br/>";    
                                echo $message;
                            }else{
                                echo "<p>Course Registration completed successfully.</p>"; 
                                echo "<p>You registered a total of:&nbsp;&nbsp;" . $totalcredit  . "&nbsp;Credit Units.</p>" ;
                            echo "<br/>";
                                 echo "<br/>";
                                echo "<a href=\"students.php\">Return to Main menu</a>" ;
                            }
                       }  else{
                            // Failed
                            //$message = "The courses could not be registered.";
                            //$message .= "<br/>" . mysql_error();
                            echo "Course Registration failed mid-way. Consult Administrator"; // Admin will delete his record for fresh course registration.
                            echo "<a href=\"students.php\">Return to Main menu</a>" ;
                           // echo "Edit to see the state of your registration and complete the registration.";
                        }

                    } // ends if($RegisterOnlySemester2)

                break;

                default:
                    # code...
                break;

            } // end switch 


        } // end if $stu_row of registered. 
             
    ?>
    
</article>

<?php require("includes/footer.php"); ?>