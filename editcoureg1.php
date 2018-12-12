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
    <h3>Edit Registered Courses:</h3>
    <br/>
    <?php

        $check = $_SESSION['sflag'];
        //echo $check;
        if ($check == 'sf') {

    ?>
    <form action="editcoureg2.php" method="post">
	    	<p><b>Select Students Information</b></p>
			<?php page_form(); ?>
            <br/>
			<p><input type="submit" name="submit" value="Continue" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href=\"students.php\">Return to Students Menu</a>"; ?></p>
		</form>
	
</article>

<?php

        }else{
            //echo "<br/>";
            echo "Access Denied --- Course Editing is meant for Students only !!! <br/><br/>";
            echo "<a href='lecturers.php'>Return to menu</a>";

        }
    ?>



<?php require("includes/footer.php"); ?>