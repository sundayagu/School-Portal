<?php include("includes/form_functions.php"); ?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="">Processing GPAs</a></li>
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Analyst Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
    <h3>Processing GPAs</h3>

    <form action="process_gpa_result_tra2.php" method="post">
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
        <p><input type="submit" name="submit" value="Continue to Step 2 of 3 >>>" /></p>
    </form>
    <br/><br/>
    <a href="index.php">cancel</a>
    
</article>

<?php require("includes/footer.php"); ?>