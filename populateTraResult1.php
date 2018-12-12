<?php include("includes/form_functions.php"); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="">Populate Transaction Result Table</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3>Populate Transaction Result Table. </h3>
    <br/>
    <form action="populateTraResult2.php" method="post">
	    	<p><b>Select Students Information</b></p>
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
		    <p><input type="submit" name="submit" value="Continue" /></p>
		</form>
	
</article>

<?php require("includes/footer.php"); ?>