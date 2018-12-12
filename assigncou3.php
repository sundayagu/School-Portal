<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
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
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Student's Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Course Assignments</h3>
        
<?php
        
// Prepare variables for the POSTed Course Codes represented with $sn
// And also the variables for the GET data of url, all from assigncou2.php and other variables for updating course table
    $table_course = mysql_prep($_GET['table_course']);
    $dept = mysql_prep($_GET['dept']);
    $session = mysql_prep($_GET['session']);
    $semester = mysql_prep($_GET['semester']);
    $course_start_id = mysql_prep($_GET['course_start_id']); // to be used for second semester
    $course_count = mysql_prep($_GET['course_count']); // can be for semester 1 or 2 as determined by assigncou2.php

    //$cor_sess = 'cordinator' . $session;
    $username = 'username' . $session;
    //$slec_sess = 'second_lec' . $session;
    $susername = 'susername' . $session;
    //$mod_sess = 'modulator' . $session;
    $musername = 'musername' . $session;
                          
    switch ($semester) {
        case $semester == 1:
            $total_assigned_course = 0;
            for($sn=1; $sn <= $course_count; $sn++){
                if(isset($_POST[$sn])){ // if course is checked for assigning it to a lecturer
                    
                    // Initialize lectuers variables and capture them
                    $username = 'username' . $sn;  // variables holding usernames to be assigned to the course $sn
                    $susername = 'susername' . $sn;  // which is in consonance with the variables in assigncor2.php  
                    $musername = 'musername' . $sn;  

                    $username_cap = $_POST[$username];
                    $susername_cap = $_POST[$username];
                    $musername_cap = $_POST[$musername];
                    
                    $query = "UPDATE $table_course SET 
                        $username = $username_cap,
                        $susername = $susername_cap,
                        $musername = $musername_cap
                        WHERE course_id = $sn ";
                    $result1 = mysql_query($query, $connection);
                    $total_assigned_course += 1;
                       
                }else{  // isset($_POST[$sn])
                    // don't assign lecturer yet
                } // ends isset($_POST[$sn])

            } // end for($sn=1; $sn<=$course_count; $sn++)
                                      
            // Test and see if the updates occurred
            if($result1){
                //Success
                $remaining = $course_count - $total_assigned_course;
                if ($remaining == 0){
                    echo "<p>Course Assignments Completed successfully.</p>"; 
                    echo "<p>You assigned a total of:&nbsp;&nbsp;" . $course_count  . "&nbsp;Courses.</p>" ;
                }else{
                    echo "<p>Course(s) Assigned successfully.</p>"; 
                    echo "<p>You assigned a total of:&nbsp;&nbsp;" . $remaining  . "&nbsp;Course(s) Out of ". $course_count ." Courses.</p>" ;
                echo "<br/>";
                     echo "<br/>";
                    echo "<a href=\"hods.php\">Return to HODs menu</a>" ;
                }
                
           }  else{
                // Failed
                //$message = "The courses could not be registered.";
                //$message .= "<br/>" . mysql_error();
                echo "Course Assignments failed mid-way. Consult Administrator <br/><br/>"; // Admin will delete his record for fresh course registration.
                echo "<a href=\"hods.php\">Return to HODs menu</a>" ;
               // echo "Edit to see the state of your registration and complete the registration.";
            }

       
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


        
             
    ?>
    
</article>

<?php require("includes/footer.php"); ?>