
<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php //confirm_logged_in_management(); ?>
<?php include("includes/header.php"); ?>
<html>
<head>
</head>

<body>
	<br/>
<center>
<form method="GET" action="searchResults.php">
Department:
		<select name="dept">
			<option value="">Select Department</option>
			<option value="csc">Computer Science</option>
			<option value="mcb">Micro Biology</option>
			<option value="inc">Industrial Chemistry</option>
			<option value="bch">Bio Chemistry</option>
		</select>
Course Code:<input type="text" name="ccode" value="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<input type="submit" name="submit" value="search database">

</form>
</center>
<hr />
<u>Results:</u>&nbsp

<?php

if (isset($_REQUEST['submit'])) {
	
	$lowBoundSession = $_GET['lowBoundSession'];
	$upBoundSession = $_GET['upBoundSession'];
	$ccode = $_GET['ccode'];
	$dept = $_GET['dept'];
	
	
	if($upBoundSession < $lowBoundSession){

		echo " Incorrect Selection. <BR/> <b>To:</b> Bound should be greater than <b>From:</b> Bound<BR/>";
		echo "<a href=\"searchResults.php\">Try Again</a>";
	} else { 

	$table_course = $dept . 'c';
	$table_tra = $dept .'tra';
	$course = get_department_course_by_coursecode2($table_course, $ccode);
	
	if($course = mysql_fetch_array($course)){
		$ca = 'a' . $course['course_id'];
		$exam = 'e' . $course['course_id'];
        $course_column = 'c' . $course['course_id'];  // to be used for course total
        $grade = 'g' . $course['course_id'];
        $remark = 'r' . $course['course_id'];
        $level_type = $course['level_type'];

        $student_set = get_record_boundary_by_session($table_tra, $lowBoundSession, $upBoundSession);
	
		$stu_count = mysql_num_rows($student_set);
	
	if ($stu_count > 0 && $ccode != "") {

		// display heading
		$deptdisplay = get_department_by_deptcode($dept);
		$lowsessdisplay = get_session_by_sesscode($lowBoundSession);
		$upsessdisplay = get_session_by_sesscode($upBoundSession);
		echo " found for <b>$ccode  " . $course['course_title'] . "  " . trim($deptdisplay['dept_name']). " From: "
		 . trim($lowsessdisplay['session_title']) . "     To:   ". trim($upsessdisplay['session_title']). "</b> <br/><br/>";
		
		$sn = 1;
		?>
		<table width=90% align=center border=1>
                <tr>
                    <th style=text-align:center bgcolor="FFFF00">S/N</th>
                    <th width=15% style=text-align:center bgcolor="FFFF00">NAME</th>
                    <th style=text-align:center bgcolor="FFFF00">REG NO.</th>
                    <th style=text-align:center bgcolor="FFFF00" >SEX</th>
                    <th style=text-align:center bgcolor="FFFF00">SESSION</th>
                    <th style=text-align:center bgcolor="FFFF00">CA</th>
                    <th style=text-align:center bgcolor="FFFF00">EXAM</th>
                    <th style=text-align:center bgcolor="FFFF00">TOTAL</th>
                    <th style=text-align:center bgcolor="FFFF00">GRADE</th>
                    <th style=text-align:center bgcolor="FFFF00">REMARK</th>
                </tr>
       	<?php	
       	$boysTotal = 0;
       	$girlsTotal = 0;
		while ($students = mysql_fetch_array($student_set)) {
			$sexdisplay = get_sex_by_id($students['stu_sex']);
			$sex = $sexdisplay['sex_name'];
			if(!empty($students[$course_column])){
				echo "
					<tr>
	                    <td >$sn</td>
	                    <td>{$students['stu_name']}</td>
	                    <td >{$students['regno']}</td>
	                    <td>$sex</td>
	                    <td>{$students['session']}</td>
	                    <td>{$students[$ca]}</td>
	                    <td>{$students[$exam]}</td>
	                    <td>{$students[$course_column]}</td>
	                    <td>{$students[$grade]}</td>
	                    <td>{$students[$remark]}</td>
	                </tr>

				";
			  $sn = $sn + 1; // over all total
			// total male and females
				if($students['stu_sex'] == 1){
					$boysTotal = $boysTotal + 1;
				}
				if($students['stu_sex'] == 2){
					$girlsTotal = $girlsTotal + 1;
				}

			}
		
		}
		echo "</table>";


		$totalStudents = $sn - 1;
		// echo "<br/>";
		echo "<center>";
        echo "<h5>=======================================================================</h5>";
        echo "<h4>Number of Males: " . $boysTotal . "</h4>";
        echo "<h4>Number of Females: " . $girlsTotal . "</h4>";
        echo "<h4>Total Number of Students: " . $totalStudents . "</h4>";
        echo "<br/>";
        echo "<a href=\"index.php\">Return to Main menu</a>";
        echo "</center";
	} else {

		echo "No result found";
	}

	require("includes/footer.php");


	} else { // ends if($course_row)

		echo " Incorrect Course Code. Please, Enter Coorrect Course Code> <br/>";
		echo "<a href=\"searchResults.php\">Try Again</a>";

	}

	} // end if(upBound) Try again


} else { // if(isset($_REQUEST))

	echo "Please type Course code and select Session bounds to search...";
}



?>

</body>
</html>