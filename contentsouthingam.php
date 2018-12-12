<?php require_once("includes/session.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_management(); ?> 
<?php include("includes/header.php"); ?>
<br/>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1 col-lg-push-4 col-sm-push-4">
    <ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="staff.php">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <br/>
    <img src="img/uniportbuilding.png" alt="Southingam gate" class="img-responsive">
</article>
<aside class="col-lg-4 col-sm-4 col-lg-pull-8 col-sm-pull-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
 <!--           <li><a href="deletecoureg.php"  onclick="return confirm('Are you sure?')">Delete Courses</a></li>    -->
                <li><a href="viewlevelcourses.php">Check Departmental Registered courses by Level</a></li>
                <li><a href="courseStatistics1.php">Check Course Registration Summary</a></li>
                <li><a href="attendants.php">Generate Attendant Sheets</a></li>
                <li><a href="searchStudents.php">Search Students Data</a></li>
                <li><a href="searchResults.php">Search Students Results</a></li>
<!--            <li><a href="editresult1.php">Edit Result</a></li>   -->
                <li><a href="viewcompositesheet.php">Check summary Results</a></li>
                <li><a href="viewsenatesheet.php">Check Senate Results</a></li>
                <li><a href="viewgroupresult_mgt.php">Check Class Result</a></li>
                <li><a href="viewindividualresult_by_mgt.php">Check Individual Result</a></li>
            </ul>
        </div>
    </div>
    <br/>
    <p><a href="managementstaff.php" class="btn btn default btn-lg"><<< Return to Menu and Logout</a></p>    
</aside>
<?php require("includes/footer.php"); ?>
