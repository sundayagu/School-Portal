<?php require_once("includes/session.php");?>
<?php
	function mysql_prep($value) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_escape_string"); // i.e. PHP >= v4.3.0
		if($new_enough_php) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if($magic_quotes_active) { $value = stripslashes($value); }
			$value = mysql_real_escape_string($value);
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if(!$magic_quotes_active) {$value = addslashes($value); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function confirm_query($result){
		if(!$result){
			echo "<br/>";
			echo "Please Return to Previous Page and Select all Information or contact Administrator<br/><br/>";
			echo " <p style='color:red'>Use the Arrow on Top to Return to the Previous Page OR <a href=\"index.php\">Return to Home Page</a> </p><br/>";
			die("Subject Database query failed" . " " . mysql_error());

		}
	}

	function redirect_to($location = NULL){
		if ($location != NULL){
			header("Location: {$location}");
			exit;
		}
	}

	/*function catch_registered_student($table, $session, $semester){ // createcoureg3.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$_SESSION['username']}' ";
		$query .= "AND session = '{$session}' ";
		$query .= "AND semester = '{$semester}' ";
		$query .= "OR semester2 = '{$semester}' ";
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		return $student;
	} */

	function catch_registered_student($table, $session, $semester){ // createcoureg3.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE (regno = '{$_SESSION['username']}' ";
		$query .= "AND session = '{$session}') ";  
		$query .= "AND (semester = '{$semester}' "; // $semester is either 1 or 2 which will be compared with the 
		$query .= "OR semester2 = '{$semester}') "; // content of semester field in the database
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		return $student;
	}

	function catch_populated_student($table, $reg, $session, $semester){ // populateTraresult2.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE (regno = '$reg' ";
		$query .= "AND session = '{$session}') ";  
		$query .= "AND (semester = '{$semester}' "; // $semester is either 1 or 2 which will be compared with the 
		$query .= "OR semester2 = '{$semester}') "; // content of semester field in the database
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		return $student;
	}

	function check_if_registered_for_semester1($table, $session, $semester1){ // createcoureg3.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$_SESSION['username']}' ";
		$query .= "AND session = '{$session}' ";
		$query .= "AND semester = '{$semester1}' ";
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		return $student;
	}

	function get_pword_answers($username, $question1, $question2){  // createcoureg3.php
		global $connection;
		$query = "SELECT id, username, email, answer1, answer2 ";
			$query .= "FROM users_student ";
			$query .= "WHERE username = '{$username}' ";
			$query .= "AND answer1 = '{$question1}' ";
			$query .= "AND answer2 = '{$question2}' ";
			$query .= "LIMIT 1";
			$result_set = mysql_query($query);
			confirm_query($result_set);
			return $result_set;
	}

	function get_pword_answers_others($table, $username, $question1, $question2){  // createcoureg3.php
		global $connection;
		$query = "SELECT id, username, email, answer1, answer2 ";
			$query .= "FROM $table ";
			$query .= "WHERE username = '{$username}' ";
			$query .= "AND answer1 = '{$question1}' ";
			$query .= "AND answer2 = '{$question2}' ";
			$query .= "LIMIT 1";
			$result_set = mysql_query($query);
			confirm_query($result_set);
			return $result_set;
	}

	function get_course_details($table, $course_id){  // createcoureg3.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE course_id=" . $course_id . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($courserow = mysql_fetch_assoc($result_set)){
			extract($courserow);
			return $courserow;
		} else{
			return NULL;	
		}
	}

	function get_a_student_user($table, $reg){ // editnew_user_student2.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE username = '{$reg}' ";
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		if($sturow = mysql_fetch_assoc($student)){
        	extract($sturow); // each column now has a variable equivalent.
        	return $sturow;
        } else{
        	return NULL;
        }
	}
	
	function get_students_who_registered_for_a_course($table_reg, $course_column){ // from createresult2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table_reg ";
		$query .= "WHERE $course_column =" . 1;
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}


	function get_all_registered_and_nonregistered_students_for_a_course($table_reg, $course_column){
		// couresStatistics2.php
		global $connection;
		$query = "SELECT $course_column ";
		$query .= "FROM $table_reg ";
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

	function get_departmental_registered_courses_by_level_type($table_reg, $level_type){ 
	// viewgroupcourses.php, createresulttra2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table_reg ";
		$query .= "WHERE level_type=" . $level_type ;
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

	function get_all_students_who_registered_for_all_courses($table_reg){ // viewindividualresult.php
		// viewlevelcourses.php, createresulttra2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table_reg ";
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

	function get_all_students_who_registered_for_all_courses_by_session_by_semester($table, $session, $semester){ // populateTraResult2.php, viewlevelcourses.php, enterca_exam2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE session = '$session' AND semester = '$semester' ";
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

	function get_student_records_session_by_semester1_OR_2($table, $session, $semester){ // populateTraResult2.php
		// revisit the preceding function if this fails for 1st semester of 2016/17
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE session = '$session' AND (semester = '$semester' OR semester2 = '$semester') ";
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

	function get_students_record_by_SessionSemester($table, $session, $semester){
		global $connection;// viewgroupresult.php
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE session = '$session' AND (semester = '$semester' OR semester2 = '$semester') ";
		$query .= " ORDER BY regno";
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

	function get_records_by_SessionSemester($table, $session, $semester){ // process_gpa_result_tra2.php, masterresultupdate1.php, courseStatistics2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE session = '$session' AND (semester = '$semester' OR semester2 = '$semester') ";
		$record_set = mysql_query($query, $connection);
		confirm_query($record_set);
		return $record_set;
	}

	function get_records_by_SessionSemesterLevel($table, $session, $semester, $level){ // masterresultupdate2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE session = '$session' AND (semester = '$semester' OR semester2 = '$semester') AND level_type < '$level' ";
		$record_set = mysql_query($query, $connection);
		confirm_query($record_set);
		return $record_set;
	}
		
	function get_all_students_who_registered_for_a_course_by_session_by_semester_by_courseColumn($table_reg, $session, $semester, $course_column){ // enterca_exam2.php, courseStatistics2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table_reg ";
		$query .= "WHERE session = '$session' AND (semester = '$semester' OR semester2 = '$semester') AND $course_column = " . 1 ;
		$query .= " ORDER BY regno";
		$student_set = mysql_query($query, $connection);
		confirm_query($student_set);
		return $student_set;
	}

		
	function get_student_examca_entry_record($table, $reg, $session, $semester){ // enterca_exam2.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$reg}' ";
		$query .= "AND session = '{$session}' ";
		$query .= "AND semester = '{$semester}' ";
		$query .= "LIMIT 1 ";  // you don't sort limit 1
		//$query .= "ORDER BY regno";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		if($sturow = mysql_fetch_assoc($student)){
        	extract($sturow); // each column now has a variable equivalent.
        	return $sturow;
        } else{
        	return NULL;
        }
	}


	function get_student_record_by_RegnoSessionSemesterCoursecolumn($table, $reg, $session, $semester, $course_column){ // processresult2.php, viewgroupresult.php, viewsenatesheet.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$reg}' ";
		$query .= "AND session = '{$session}' ";
		$query .= "AND (semester = '{$semester}' ";
		$query .= "OR semester2 = '{$semester}') ";
		$query .= "AND $course_column = 1 ";
		$query .= " LIMIT 1 ";  // you don't sort (i.e. ORDER) limit 1
		//$query .= "ORDER BY regno";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		return $student;
	}

	function get_student_record_by_RegnoSessionCoursecolumn($table, $reg, $session, $course_column){ // trackindividualresults.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$reg}' ";
		$query .= "AND session = '{$session}' ";
		$query .= "AND $course_column = 1 ";
		$query .= " LIMIT 1 ";  // you don't sort (i.e. ORDER) limit 1
		//$query .= "ORDER BY regno";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		return $student;
	}

/*	function get_student_departmental_level_registered_courses($table, $session, $semester, $course_start_id, $course_count){ // viewcompositesheet.php
		global $connection;
		$query = "SELECT * ";
            $query .= "FROM $table ";
            $query .= "WHERE ";
           // $query .= "$course_column = 1 or c2 = 1 or c3 = 1 or c4 = 1 or c5 = 1 or c6 = 1 ";
            for($i = $course_start_id; $i <= $course_count; $i++){
                $course_column = 'c' . $i;
                $query .= "$course_column =  1 ";
                if($i < $course_count){
                	$query .= "or ";
                }
            }
            $query .= " ORDER BY regno ";
            $stu_real = mysql_query($query, $connection);
            confirm_query($stu_real);
            return $stu_real;

	} */

	function get_students_who_registered_for_departmental_level_courses($table, $session, $semester, $course_start_id, $course_count){ // viewlevelcourses.php, viewcompositesheet.php
		global $connection;
		// semester is not used in the query. the course columns determine the semester courses. this is also echoed 
        // in each of the (for -- next) of the (switch/cases) of the main program- viewlevelcourses.php
		$query = "SELECT * ";
            $query .= "FROM $table ";
            $query .= "WHERE session = '$session' AND (";
            // $query .= "$course_column = 1 or c2 = 1 or c3 = 1 or c4 = 1 or c5 = 1 or c6 = 1 ";
            for($i = $course_start_id; $i <= $course_count; $i++){
                $course_column = 'c' . $i;
                $query .= "$course_column =  1 ";
                if($i < $course_count){
                	$query .= "or ";
                }
                
            }
            $query .= ")";
            $query .= " ORDER BY regno ";
            $stu_real = mysql_query($query, $connection);
            confirm_query($stu_real);
            return $stu_real;

	}

	function get_student_records_byRegnoSessionSemester($table, $reg, $session, $semester){ // enterca_exam2.php
		// editcoureg2.php, viewcourse1.php, viewindividualresult.php, viewcompositesheet.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$reg}' ";
		$query .= "AND session = '{$session}' ";
		$query .= "AND (semester = '{$semester}' ";
		$query .= "OR semester2 = '{$semester}') ";
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		if($sturow = mysql_fetch_assoc($student)){
        	extract($sturow); // each column now has a variable equivalent.
        	return $sturow;
        } else{
        	return NULL;
        }
	}

	function get_student_records_byRegnoSession($table, $reg, $session){ // enterca_exam2.php
		// editcoureg2.php, viewcourse1.php, viewindividualresult.php, viewcompositesheet.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE regno = '{$reg}' ";
		$query .= "AND session = '{$session}' ";
		//$query .= "AND (semester = 1 ";
		//$query .= "OR semester2 = 2) ";
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		if($sturow = mysql_fetch_assoc($student)){
        	extract($sturow); // each column now has a variable equivalent.
        	return $sturow;
        } else{
        	return NULL;
        }
	}

	function get_student_records_byRegnoSessionSemester1_or_2($table, $reg, $session, $semester){ // enterca_exam2.php
		// editcoureg2.php, viewcourse1.php, viewindividualresult.php, viewcompositesheet.php
		global $connection;
		$query = "SELECT * " ;
		$query .= "FROM $table ";
		$query .= "WHERE (regno = '{$reg}' ";
		$query .= "AND session = '{$session}') ";
		$query .= "AND (semester = '{$semester}' ";
		$query .= "OR semester2 = '{$semester}') ";
		$query .= "LIMIT 1";
		$student = mysql_query($query, $connection);
		confirm_query($student);
		if($sturow = mysql_fetch_assoc($student)){
        	extract($sturow); // each column now has a variable equivalent.
        	return $sturow;
        } else{
        	return NULL;
        }
	}

	function create_result($table_result){  // createresult2.php
		global $connection;
		$query = 'CREATE TABLE ' . $table_result .  ' (' ; 
		$query .= 'id     	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,';
       	$query .= 'regno 	VARCHAR(11) NOT NULL,';
       	$query .= 'ca      TINYINT(2),';            
       	$query .= 'exam    TINYINT(2),';
        $query .= 'total   TINYINT(3),';
        $query .= 'grade   VARCHAR(13),';
        $query .= 'remark  VARCHAR(24),';

       	$query .= 'PRIMARY KEY (id),';
        $query .= 'KEY regno (regno)';
        $query .= ') ';
        $query .= 'ENGINE=INNODB';
    	$result = mysql_query($query, $connection);
		confirm_query($result);
		//return $result;
	}

	function populate_result($table_result, $student_set){
		global $connection;
		while($student = mysql_fetch_array($student_set)){
            $query = "INSERT INTO " . $table_result . " (";
            $query .= "regno ";
            $query .= ") VALUES ( ";
            $query .= "{$student['regno']})";
			$result = mysql_query($query, $connection);
			confirm_query($result);
        }
	}
	
	function get_a_student_registered_courses($table, $regno){
		global $connection;
		$query = "SELECT * FROM $table WHERE regno = '$regno' LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if($regrow = mysql_fetch_assoc($result)){
        	extract($regrow); // each column now has a variable equivalent.
        	return $regrow;
        } else{
        	return NULL;
        }
	}

	function get_all_department_courses($table){ // createresult2.php, 
		// process_gpa_result_tra2.php, viewindividualresult.php, trackindividualresults.php
		global $connection;
		$query = "SELECT * 
				FROM $table ";
		// $query .= "ORDER BY level_type ASC";
        $course_set = mysql_query($query, $connection);
        confirm_query($course_set);
       	return $course_set;
	}

	function get_all_department_courses_by_semester($table, $semester){ // createcoureg2.php, process_gpa_result_tra2.php
		global $connection;
		$query = "SELECT * 
				FROM $table WHERE semester = '$semester' ";
		// $query .= "ORDER BY level_type ASC";
        $course_set = mysql_query($query, $connection);
        confirm_query($course_set);
       	return $course_set;
	}

	function get_records_by_deptsession($dept, $session){ // masterresultappend.php
		global $connection;
		$query = "SELECT * 
				FROM users_student WHERE dept_code = '$dept' AND adm_sess = '$session' ";
		// $query .= "ORDER BY level_type ASC";
        $student_set = mysql_query($query, $connection);
        confirm_query($student_set);
       	return $student_set;
	}


	function get_all_department_courses_order_by_level($table){ // viewindividualresult.php
		global $connection;
		$query = "SELECT * 
				FROM $table ";
		$query .= "ORDER BY level_type ASC";
        $course_set = mysql_query($query, $connection);
        confirm_query($course_set);
       	return $course_set;
	}

	function get_department_course_by_coursecode($table_course, $ccode){ //(enterca_exam2.php taken to next function)
	// processresult2.php, editresult1.php, viewgroupresult.php, , updateresulttra2.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE course_code = '$ccode' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($courserow = mysql_fetch_assoc($result_set)){
			extract($courserow);
			return $courserow;
		} else{
			return NULL;	
		}
	}

	function get_department_course_by_coursecode2($table_course, $ccode){ //searchResult
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE course_code = '$ccode' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		return $result_set;
	}

	function get_record_boundary_by_session($table, $lowBoundSession, $upBoundSession){
		global $connection;
		
		$query = "SELECT * 
				FROM $table WHERE session >= '$lowBoundSession' AND session <= '$upBoundSession'  ";
		//$query .= "ORDER BY regno ASC";
        $student_set = mysql_query($query, $connection);
        confirm_query($student_set);
       	return $student_set;
	}

	function get_department_course_for_enterca_exam_by_coursecode($table_course, $ccode, $username, $session){ // enterca_exam2.php, viewgroupresult.php
		global $connection;
		$user = 'username' . $session;
		$query = "SELECT * FROM $table_course 
					WHERE course_code = '$ccode' && $user = '$username' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($courserow = mysql_fetch_assoc($result_set)){
			extract($courserow);
			return $courserow;
		} else{
			echo "You are NOT the assigned lecturer for the Course <br/><br/> ";
			return NULL;	
		}
	}


	function get_department_course_for_enterca_exam_by_coursecode_for_modulator($table_course, $ccode, $username, $session){ // enterca_exam2.php, viewgroupresult_mod.php
		global $connection;
		$user = 'musername' . $session;
		$query = "SELECT * FROM $table_course 
					WHERE course_code = '$ccode' && $user = '$username' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($courserow = mysql_fetch_assoc($result_set)){
			extract($courserow);
			return $courserow;
		} else{
			echo "You are NOT the assigned lecturer for the Course <br/><br/> ";
			return NULL;	
		}
	}

	function get_department_course_for_enterca_exam_by_coursecode_for_hod($table_course, $ccode){ // enterca_exam2.php, viewgroupresult_mod.php
		global $connection;
		//$user = 'musername' . $session;
		/*$query = "SELECT * FROM $table_course 
					WHERE course_code = '$ccode' && $user = '$username' LIMIT 1"; */
		$query = "SELECT * FROM $table_course 
					WHERE course_code = '$ccode' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($courserow = mysql_fetch_assoc($result_set)){
			extract($courserow);
			return $courserow;
		} else{
			echo "You are NOT the assigned lecturer for the Course <br/><br/> ";
			return NULL;	
		}
	}

	function get_login_user($table, $username, $password){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE username = '{$username}' ";
		$query .= "AND password1 = '{$password}' ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query);
		confirm_query($result_set);
		return $result_set;
	}


	function get_department_course_by_courseid($table_course, $course_id){ // viewindividualresult.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE course_id = '$course_id' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($courserow = mysql_fetch_assoc($result_set)){
			extract($courserow);
			return $courserow;
		} else{
			return NULL;	
		}
	}

	function get_department_course_by_level_type($table_course, $level){ // from viewindividualresult.php, createresulttra2.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE level_type = '$level'";
		$course_set = mysql_query($query, $connection);
		confirm_query($course_set);
		return $course_set;
	}

	
	function get_department_course_by_level_type_by_semester($table_course, $level, $semester){ // from viewlevelcourses.php, viewindividualresult.php, createresulttra2.php, viewcompositesheet.php, viewstatementofresult.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE level_type = '$level' AND semester = '$semester' ";
		$course_set = mysql_query($query, $connection);
		confirm_query($course_set);
		return $course_set;
	}

	function get_department_course_by_level_type_by_first_semester_for_total($table_course, $level, $semester){ // from viewstatementofresult.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE level_type <= '$level' AND semester = '$semester' ";
		$course_set = mysql_query($query, $connection);
		confirm_query($course_set);
		return $course_set;
	}

	function get_department_course_by_level_type_by_second_semester_for_totals($table_course, $level, $semester2){ // from viewstatementofresult.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE ((level_type <= 6 AND semester = 1) OR (level_type <= $level AND semester = '$semester2')) ";
		$course_set = mysql_query($query, $connection);
		confirm_query($course_set);
		return $course_set;
	}

	function get_start_course_by_level_type_by_semester($table_course, $level, $semester){ // from viewlevelcourses.php, viewindividualresult.php, createresulttra2.php, viewcompositesheet.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE level_type = '$level' AND semester = '$semester' LIMIT 1 ";
		$course_set = mysql_query($query, $connection);
		confirm_query($course_set);
		if($courserow = mysql_fetch_assoc($course_set)){
			extract($courserow);
			return $courserow;
		} else{
			return NULL;	
		}
	}

	function get_start_course_by_semester($table_course, $semester){ // from viewlevelcourses.php, viewindividualresult.php, createresulttra2.php, viewcompositesheet.php, viewstatementofresult_tra.php
		global $connection;
		$query = "SELECT * FROM $table_course 
					WHERE semester = '$semester' LIMIT 1 ";
		$course_set = mysql_query($query, $connection);
		confirm_query($course_set);
		if($courserow = mysql_fetch_assoc($course_set)){
			extract($courserow);
			return $courserow;
		} else{
			return NULL;	
		}
	}

	function get_all_student_course_result($table_result){ // enterca_exam2.php, 
		//enterac_exam3.php and processresult2.php, viewgroupresult.php
		// process_gpa_result_tra2.php
		global $connection;
		$query = "SELECT * 
				FROM $table_result ";
		$query .= "ORDER BY regno ASC";
		$result_set = mysql_query($query, $connection);
        confirm_query($result_set);
       	return $result_set;
	}

	function get_a_student_course_result_by_regno($table_result, $regno){ // editresult1.php, viewindividualresult.php
		global $connection;
		$query = "SELECT * FROM $table_result 
					WHERE regno = '$regno' LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($resultrow = mysql_fetch_assoc($result_set)){
			extract($resultrow);
			return $resultrow;
		} else{
			return NULL;	
		}
	}

	function get_a_student_course_results_by_regno($table_result, $regno){ // trackindividualresults.php
		global $connection;
		$query = "SELECT * FROM $table_result 
					WHERE regno = '$regno'";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		return $result_set;
	}

	function get_record_by_username($table, $username){ //
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE username = '$username' LIMIT 1";
		$user = mysql_query($query, $connection);
		confirm_query($user);
		return $user;
	}

	function get_records_by_deptcode($table, $deptcode){ // assigncou2.php
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM $table ";
		$query .= "WHERE dept_code = '$deptcode' ";
		$users = mysql_query($query, $connection);
		confirm_query($users);
		return $users;
	}

	function get_all_faculties(){
		global $connection;
		$query = "SELECT * 
				FROM faculties ";
		$facul_set = mysql_query($query, $connection);
        confirm_query($facul_set);
       	return $facul_set;
	}

	function get_all_departments_for_faculty($facu_id){
		global $connection;
		$query = "SELECT * FROM department WHERE faculty_type = '$facu_id' ";
        $dept_set = mysql_query($query, $connection);
        confirm_query($dept_set);
        return $dept_set;
    }


    function get_faculty_by_id($faculty_id){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM faculties ";
		$query .= "WHERE faculty_id=" . $faculty_id . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($faculty = mysql_fetch_assoc($result_set)){
			return $faculty;
		} else{
			return NULL;	
		}
	}

	function get_department_by_id($department_id){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM department ";
		$query .= "WHERE dept_id=" . $department_id . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($department = mysql_fetch_assoc($result_set)){
			return $department;
		} else{
			return NULL;	
		}
	}

	function get_department_by_deptcode($dept){
		global $connection;
		$query = "SELECT * FROM department WHERE dept = '$dept' ";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($department = mysql_fetch_assoc($result_set)){
			return $department;
		} else{
			return NULL;	
		}	
	}

	function get_department_by_deptcode_for_hod_search($dept,$hodsession){ // assigncor2.php
		global $connection;
		$query = "SELECT * FROM department WHERE dept = '$dept' AND $hodsession = '{$_SESSION['username']}' ";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		return $result_set;
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		/*if($department = mysql_fetch_assoc($result_set)){
			return $department;
		} else{
			//return NULL;	
			echo "YOU ARE NOT THE ASSIGNED HOD FOR THIS DEPARTMENT OR THIS SESSION";
		}*/	
	}

	function get_session_by_sesscode($sess){
		global $connection;
		$query = "SELECT * FROM academicsessions WHERE session_code = '$sess' ";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($sess_result = mysql_fetch_assoc($result_set)){
			return $sess_result;
		} else{
			return NULL;	
		}	
	}

	function get_level_by_id($level_id){
		global $connection;
		$query = "SELECT * FROM levels WHERE level_id = '$level_id' ";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($leve_result = mysql_fetch_assoc($result_set)){
			return $leve_result;
		} else{
			return NULL;	
		}
	}

	function get_semester_by_id($semester_id){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM semesters ";
		$query .= "WHERE semester_id=" . $semester_id . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($seme_result = mysql_fetch_assoc($result_set)){
			return $seme_result;
		} else{
			return NULL;	
		}
	}

	function get_sex_by_id($sex_type){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM sex ";
		$query .= "WHERE sex_id=" . $sex_type . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($sex_result = mysql_fetch_assoc($result_set)){
			return $sex_result;
		} else{
			return NULL;	
		}
	}

	function get_stat_by_id($stat_type){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM status ";
		$query .= "WHERE flag_id=" . $stat_type . " ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMENBER:
		 // if no rows are returned, fetch_array returns false
		if($stat_result = mysql_fetch_assoc($result_set)){
			return $stat_result;
		} else{
			return NULL;	
		}
	}

    function find_selected_page(){
		global $sel_subject;
		global $sel_page;
		if(isset($_GET['subj'])){
			$sel_subject = get_subject_by_id($_GET['subj']);
			$sel_page = get_default_page($sel_subject['id']);
		} elseif(isset($_GET['page'])) {
			$sel_page = get_page_by_id($_GET['page']);
			$sel_subject = NULL;
		} else{
			$sel_subject = NULL;
			$sel_page = NULL;
		}	
	
	}

    function nav_faculties($sel_faculty){
    	$output = "<ul class=\"faculties\">";
            $facul_set = get_all_faculties();
            while($facul = mysql_fetch_array($facul_set)){
                echo "<li";
                echo "<a href=\"createcscoureg.php\"?fac= . urlencode($facul[faculty_id]) . ></a>";
                echo "\">{$facul['faculty_name']}</a></li>";
            }
        echo "</ul>";
    }
?>