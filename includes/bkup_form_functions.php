<?php
function check_required_fields($required_array){
	$field_errors = array();
	foreach($required_array as $fieldname){
		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
			$field_errors[] = $fieldname;
		}
	}
	return $field_errors;	
}

function check_max_field_lengths($field_length_array){
	$field_errors = array();
	foreach($field_length_array as $fieldname => $maxlength){
		if(strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength){
			$field_errors[] = $fieldname;
		}
	}
	return $field_errors;
}

function check_integer_fields($integer_array){  // new_user_student.php
	$field_errors = array();
	foreach($integer_array as $fieldname){
		if(is_int($fieldname)){
			$field_errors[] = $fieldname;
		}
	}
	return $field_errors;
}

function display_errors($error_array){
	echo "<p class=\"errors\">";
	echo "Please review the following fields:<br />";
	foreach($error_array as $error){
		echo " - " . $error . "<br />";
	}
	echo "</p>";
}

function page_form(){
	?>
	<!--<p>
	  Department:
		<select name="dept">
			<option value="">Select Department</option>
			<option value="csc">Computer Science</option>
			<option value="mcb">Micro Biology</option>
			<option value="inc">Industrial Chemistry</option>
			<option value="bch">Bio Chemistry</option>
		</select></p>-->
	 <p>
	  Session: 
	     <select name="session">
			<!--<option value="">Select session</option>-->
			<!--<option value="2016">2016/17</option>-->
			<!--<option value="2017">2017/18</option>-->
			<!--<option value="2018">2018/19</option>-->
			<option value="2019">2019/20</option>
		</select></p>
	<p>
	  Semester:
	  	<select name="semester">
	  		<!--<option value="">Select semester...</option>-->
			<!--<option value="1">First Semester</option>-->
			<option value="2">Second Semester</option>
		</select>
	</p>
<?php
}
?>