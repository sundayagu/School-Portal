<?php include("includes/form_functions.php"); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="createcscoureg.php">Course Registration</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="staff.php">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3>Course Registration</h3>

    <form action="processresult2.php" method="post">
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
        <!-- Analyst should know the Course Code for Security reasons (integrity) -->
        <p>Course Code:<input type="text" name="ccode" value="" /></p>
        <br/>
        <p><input type="submit" name="submit" value="Continue to Step 2 of 2 >>>" /></p>
    </form>
    <br/><br/>
    <a href="index.php">cancel</a>
    
</article>

<?php require("includes/footer.php"); ?>