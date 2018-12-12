
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header.php"); ?>

<aside class="col-lg-3 col-sm-4 col-xs-1">
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body" id="navigation">
            <ul>
                <li><a href="editnew_user_hod1.php">Edit Hods's  User Account Profile</a></li>
                <li>&nbsp;</li>
                <!--<li><a href="assigncou1.php">Assign Courses</a></li>
                <li>&nbsp;</li>-->
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

<article class="col-lg-8 col-lg-offset-1 col-sm-8 col-xs-6">
    <ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="staff.php">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>
<h3 style="color:red;">Search Students Results</h3>

<p style="color:blue"><em>Please type the Course Code and select Session bounds to search...</em></p>
<br/>
<center>
<form method="GET" action="search.php">
<!--Department:
		<select name="dept">
			<option value="">Select Department</option>
			<option value="csc">Computer Science</option>
			<option value="mcb">Micro Biology</option>
			<option value="inc">Industrial Chemistry</option>
			<option value="bch">Bio Chemistry</option>
		</select>-->
Course Code:<input type='text' name='search' value="" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
From:<select name="lowBoundSession">
			<option value="">Select session</option>
			<option value="2016">2016/17</option>
			<option value="2017">2017/18</option> 
			<option value="2018">2018/19</option> 
			<option value="2019">2019/20</option> 
			<option value="2020">2020/21</option> 
		</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
To:<select name="upBoundSession">
		<option value="">Select session</option>
		<option value="2016">2016/17</option>
		<option value="2017">2017/18</option> 
		<option value="2018">2018/19</option> 
		<option value="2019">2019/20</option> 
		<option value="2020">2020/21</option> 
	</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" value="Search Database">
<br/>
</form>
</center>


<br/><br/><a href="hods.php">Return to Hod's Menu</a>
</article>

<?php require("includes/footer.php"); ?>