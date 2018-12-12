<?php require_once("includes/session.php");?>
<?php include("includes/form_functions.php"); ?>
<?php confirm_logged_in_lecturers(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_lecturer1.php">Edit Lecturer's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <li><a href="enterca_exam.php">Enter CA / Exam Scores</a></li>
                <li>&nbsp;</li>
                <li><a href="enterca_exam.php">Edit CA / Exam Scores</a></li>
                <li>&nbsp;</li>
                <li><a href="#.php">Modulate Result</a></li>
                <li>&nbsp;</li>
                <li><a href="viewgroupresult.php">Check Class(Level) Result</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:blue">Ca/Exam scores input form:&nbsp;&nbsp;<?php  echo $_SESSION['lec_name']; ?></h3>
    <p style="color:red"><b><em>Please, Enter all the information below</em></b></p>

    <form action="enterca_exam2.php" method="post">

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
        <!-- Lecturer should know the Course Code for Security reasons (integrity) -->
        <br/>
        <p>Course Code:<input type="text" name="ccode" value="" /></p>
        <br/>
        <p><input type="submit" name="submit" value="Continue to Step 2 of 3 >>>" /></p>
    </form>
    
    <a href="lecturers.php">cancel</a>
    
</article>

<?php require("includes/footer.php"); ?>