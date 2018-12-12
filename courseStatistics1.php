<?php require_once("includes/session.php");?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/form_functions_viewing.php"); ?>
<?php confirm_logged_in_senates(); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="courseStatistics1.php">Check Course Registration Summaries</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcompositesheet.php">Check Composite Results</a></li>
                <li>&nbsp;</li>
                <li><a href="viewsenatesheet.php">Check Summary Results</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3 style="color:red">Checking Course Registration Summary. </h3>
    
    <form action="courseStatistics2.php" method="post">
	    	<p style="color:blue"><b><em>Select Departments Information</em></b></p>
            <br/>
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
		    <p><input type="submit" name="submit" value="Continue" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="senates.php">Return to Senates menu</a></p>
		</form>
	
</article>

<?php require("includes/footer.php"); ?>