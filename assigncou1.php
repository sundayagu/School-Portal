<?php require_once("includes/session.php");?>
<?php require_once("includes/functions.php");?>
<?php include("includes/form_functions.php"); ?>
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
        <li class="active"><a href="">Hod Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Assigning Courses to Lecturers:&nbsp;&nbsp;<?php  echo $_SESSION['username']; ?></h3>
    <p style="color:blue"><b><em>Please, Enter all the information below</em></b></p>
    </br>
    <form action="assigncou2.php" method="post">
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
        
        <br/>
        <p><input type="submit" name="submit" value="Continue to Step 2 of 3 >>>" /></p>
    </form>
    <br/><br/>
    <a href="students.php">Return to Menu</a>

       
</article>


<?php require("includes/footer.php"); ?>