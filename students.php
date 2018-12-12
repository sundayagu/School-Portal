<?php require_once("includes/session.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_students(); ?>
<?php include("includes/header.php"); ?>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1 col-lg-push-4 col-sm-push-4">
    <ol class="breadcrumb">
        <li><a href="login_students.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="students.php">Students Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>

    <h2 style="color:red">Students Area</h2>
    <p style="color:blue">Welcome to Students Area: <?php  echo $_SESSION['username']; ?></p>
    <p><img src="img/uniportstudents3.png" alt="" class="pull-left img-responsive img-rounded"></p>
    <p>&nbsp;</p>
    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Authomated System is that it has a more-or-less normal distribution of entities, as opposed to using 'Content.</p><br/>
    <a href="index.php">Cancel</a>
</article>
<aside class="col-lg-4 col-sm-4 col-lg-pull-8 col-sm-pull-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body">
            <ul>
                <li><a href="login_students.php">Login / Complete Students User Account</a></li>
                <li>&nbsp;</li>
                <li><a href="editnew_user_student1.php">Edit Student's  Users Account Profile</a></li>
                <li>&nbsp;</li>
                <!--<li><a href="pwordrset1.php">Forget Password</a></li>
                <li>&nbsp;</li>-->
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
                
            </ul>
        </div>
    </div>    
</aside>

<?php include("includes/footer.php"); ?>