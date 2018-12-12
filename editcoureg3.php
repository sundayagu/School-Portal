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
        (1) Accepting the data that will be used in initializing the Course Registration table variable. (Remember that the Course Registration table was created from createcoureg2.php).
        (2) Updating Course Registration table with selected Courses that will be registered. (Remember that the selected Courses were filled in from the Form in creatcoureg2.php).-->
    <?php
        
        // Prepare variables for the POSTed Course Codes represented with $sn
        // And also the variables for the GET data of url, all from createcoureg2.php
            $totalcredit = 0;   // initialize it.
            $table_reg = mysql_prep($_GET['table_reg']);
            $table_course = mysql_prep($_GET['table_course']);
            $session = mysql_prep($_GET['session']);
            $semester = mysql_prep($_GET['semester']);
            $course_count = mysql_prep($_GET['course_count']);
            $course_start_id = mysql_prep($_GET['course_start_id']); // to be used for second semester
           // echo $course_start_id . "<br/>";
           // echo $table_reg . "<br/>";
            
            switch ($semester) {
                case $semester == 1:

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
                                    //$message .= "<a href=\"editcoureg1.php\">Edit Course Registration</a>";  // variables will be passed.
                                }
                        }else{  // isset($_POST[$sn])
                            $course_column = 'c' . $sn;
                            $query = "UPDATE $table_reg SET 
                                    $course_column = 0
                                    WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester = $semester ";
                            $result1 = mysql_query($query, $connection);
                        } // ends isset($_POST[$sn])

                    } // end for($sn=1; $sn<=$course_count; $sn++)

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
                            echo "Click <a href=\"students.php\">Return to Menu</a>";
                        }
                        
                        
                    } else{
                        // Failed
                        //$message = "The courses could not be registered.";
                        //$message .= "<br/>" . mysql_error();
                        echo "Course Registration failed";
                        echo "Edit to see the state of your registration and complete the registration.";
                    }

                break;

                case $semester == 2:
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
                                    //$message .= "<a href=\"editcoureg1.php\">Edit Course Registration</a>";  // variables will be passed.
                                }
                        }else{  // isset($_POST[$sn])
                            $course_column = 'c' . $sn;
                            $query = "UPDATE $table_reg SET 
                                    $course_column = 0
                                    WHERE regno = '{$_SESSION['username']}' AND session = $session AND semester2 = $semester ";
                            $result1 = mysql_query($query, $connection);
                        } // ends isset($_POST[$sn])

                    } // end for($sn=1; $sn<=$course_count; $sn++)

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
                            echo "Click <a href=\"students.php\">Return to Menu</a>";
                        }
                        
                        
                    } else{
                        // Failed
                        //$message = "The courses could not be registered.";
                        //$message .= "<br/>" . mysql_error();
                        echo "Course Registration failed";
                        echo "Edit to see the state of your registration and complete the registration.";
                    }



                break;

                default:
                    #code;
                break;

            }


             
    ?>
    
</article>

<?php require("includes/footer.php"); ?>