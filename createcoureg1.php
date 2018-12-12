<?php require_once("includes/session.php");?>
<?php require_once("includes/functions.php");?>
<?php include("includes/form_functions.php"); ?>
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
        <li class="active"><a href="">Studnet Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Course Registration</h3>

    <?php
        $check = $_SESSION['sflag'];
        //echo $check;
        if ($check == 'sf') {

    ?>


    <!--<h5><b>Your Admission Session is :&nbsp;&nbsp;<?php  echo "20". $_SESSION['adm_sess']; ?></b></h5> -->
    <p style="color:blue"><b><em>Please select the current academic session and semester</em></b></p>

    <form action="createcoureg2.php" method="post">
        <?php 
           // $stu_name = "";
           page_form(); ?>
        <!--
        <p>Name:<input type="text" name="stu_name" maxlength="40" value="<?php // echo strtoupper(htmlentities($stu_name)); ?>" />
        </p>
        <p>
          Sex: 
             <select name="sex_type">
                <option value="">Select sex</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
            </select>
        </p>
        
        <p>
          Student Current Level: 
             <select name="level_type">
                <option value="">Select level</option>
                <option value="1">100</option>
                <option value="2">200</option>
                <option value="3">300</option>
                <option value="4">400</option>
                <option value="5">500</option>
                <option value="6">600</option>
                <option value="7">Spill over</option>
             </select>
        </p> -->
        <br/>
        <p><input type="submit" name="submit" value="Continue to Step 2 of 3 >>>" /></p>
    </form>
    <br/><br/>
    <a href="students.php">Return to Menu</a>

    <?php

        }else{
            echo "<br/>";
            echo "Access Denied --- Course Registration is meant for Students only !!! <br/><br/>";
            echo "<a href='lecturers.php'>Return to menu</a>";

        }
    ?>

    
</article>


<?php require("includes/footer.php"); ?>