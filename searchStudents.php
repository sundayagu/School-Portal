
<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header.php"); ?>
<html>
<head>
</head>

<body>
<aside class="col-lg-4 col-sm-4 col-xs-1">
    
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
<article class="col-lg-7 col-lg-offset-1 col-sm-8 col-xs-6">
    <ol class="breadcrumb">
        <li><a href="login.php">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="staff.php">Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>

<center>
<form method="GET" action="searchStudents.php">

<input type="text" name="search">
<input type="submit" name="submit" value="search database">

</form>
</center>
<hr />
<u>Results:</u>&nbsp

<?php

if (isset($_REQUEST['submit'])) {
	
	$search = $_GET['search'];
	$term = explode(" ", $search);
	$query = "SELECT * FROM users_student WHERE ";

	$i=0;
	foreach ($term as $each) {
		$i++;
		if ($i == 1) {
			$query .= "stu_name LIKE '%$each%' ";
		} else {
			$query .= "OR stu_name LIKE '%$each%' ";
		}
	}

	//require_once("includes/connection.php"); 

	$query = mysql_query($query);
	$num = mysql_num_rows($query);
	
	if ($num > 0 && $search != "") {

		echo "$num result(s) found for the <b>$search</b>";
		
		while ($row = mysql_fetch_assoc($query)) {
			
			$id = $row['id'];
			$name = $row['stu_name'];
			$regno = $row['username'];
			$session = $row['adm_sess'];
			$dept = $row['dept_code'];

			echo "<br /><h4>Name: $name(Regno: $regno)</h4>Adm Session: $session<br />Department Code: $dept";
		}
	} else {

		echo "No result found";
	}

	//require("includes/footer.php");

} else {

	echo "Please type any word...";
}

echo "<br/><br/><a href=\"hods.php\">Return to Hod's Menu</a>";



?>
</article>
</body>

</html>
<?php require("includes/footer.php"); ?>