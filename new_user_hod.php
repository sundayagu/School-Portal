<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_management(); ?> 
<?php
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('session', 'name', 'sex', 'username', 'dept');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('username' => 11);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		// clean up the form data before putting it in the database
		$name = trim(mysql_prep($_POST['name']));
		$name = strtoupper($name);
		$sex = trim(mysql_prep($_POST['sex']));
		$username = trim(mysql_prep($_POST['username']));
		$username = strtoupper($username);
		$dept = trim(mysql_prep($_POST['dept']));
		$session = trim(mysql_prep($_POST['session']));
		
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){

			$query = "INSERT INTO users_hod (
						hod_name, hod_sex, username, flogin, password1, dept_code, adm_sess, hflag
					) VALUES (
						'{$name}','{$sex}', '{$username}', '1', '1234', '{$dept}', '{$session}', '1'
					)";
			$result = mysql_query($query, $connection);
			// test to see if the update occurred
			if($result){
				// success
				$message = "The user was successfully created";
			} else{
				// Failed
				$message = "The user could not be created.";
				$message .= "<br/>" . mysql_error(); 
			}
		



		} else {
			if(count($errors) == 1){
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were" . count($errors) . "errors in the form.";
			}
		}


	} else{  //Form has not been submited
		$name = "";
		$username = "";
		//$pnum = "";
		//$email = "";
		//$answer1 = "";
		//$answer2 = "";
	
	}
?>
<?php include("includes/header.php"); ?>
<aside class="col-lg-4 col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body">
            
            <ul>
                <li><a href="new_user_student.php">Add Student User</a></li>
                <li>&nbsp;</li>
                <li><a href="new_user_lecturer.php">Add Lecturer User</a></li>
                <li>&nbsp;</li>
                <li><a href="new_user_hod.php">Add HOD User</a></li>
                <li>&nbsp;</li>
                <li><a href="new_user_senate.php">Add Senate User</a></li>
                <li>&nbsp;</li>
                <li><a href=".php">Edit Student User</a></li> <!-- by mgt staff, Different from one by student. yet to be written  -->
                <li>&nbsp;</li>
                <li><a href="new_user_lecturer.php">Edit Lecturer User</a></li>
                <li>&nbsp;</li>
                <li><a href="#.php">Edit HOD User</a></li>
                <li>&nbsp;</li>
                <li><a href="#.php">Edit Senate User</a></li>

                <!--<li><a href="viewindividualresult.php">Generate Exams Attendants sheets</a></li>
                <li><a href="viewstatementofresult_tra.php">Search Students Data</a></li>
                <li><a href="trackindividualresults.php">Search Students Result</a></li>-->
            </ul>
        </div>
    </div>    
</aside>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">

    <ol class="breadcrumb">
        <li><a href="managementstaff.php">Management Staff Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="new_user_hod.php">Create HOD user</a></li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
           <center>
		      <h4 style="color:blue">Create New HOD's User Account</h4>
		   </center>
        </div>
        <div class="panel-body">
           <?php if(!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
		  <?php if(!empty($errors)) {display_errors($errors);} ?>
          <form action="new_user_hod.php" method="post">
        	  <table>
          		 <tr>
                    <td><b>Name: </b></td>
                    <td><input type="text" name="name" maxlength="40" value="<?php echo htmlentities($name); ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>Username: </b></td>
                    <td><br /><input type="text" name="username" maxlength="11" value="<?php echo htmlentities($username); ?>" /></td>
                 </tr>
                 <tr>
                    <td><br /><b>Gender:</b> </td>
                    <td><br /><select name="sex">
						  		<option value="">Select gender...</option>
								<option value="1">Male</option>
								<option value="2">Female</option>
							</select></td>
                 </tr>
          		 <tr>
                    <td><br/><b> initial Password: </b></td>
                    <td><br /><?php echo '1234'; ?></td>
                 </tr>
                 <tr>
                 	<td><br/><b>Department:</b></td>
                 	<td><br/><select name="dept">
							<option value="">Select Department</option>
							<option value="csc">Computer Science</option>
							<option value="mcb">Micro Biology</option>
							<option value="inc">Industrial Chemistry</option>
							<option value="bch">Bio Chemistry</option>
						</select></td>
                 </tr>
                 <tr>
                 	<td><br/><b>Session:</b></td>
                 	<td><br/><select name="session">
								<!--<option value="">Select session</option>-->
								<option value="2016">2016/17</option>
								<!--<option value="2017">2017/18</option>-->
								<!--<option value="2018">2018/19</option>-->
								<!--<option value="2019">2019/20</option>-->
							</select></td>
                 </tr>
         <!--        <tr>
                    <td><br/><b>Mobile Phone Number: </b></td>
                    <td><br /><input type="text" name="pnum" maxlength="11" value="<?php //echo htmlentities($pnum); ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>Email Address: </b></td>
                    <td><br /><input type="text" name="email" maxlength="40" value="<?php //echo htmlentities($email); ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b><p style="color:red"><strong><em>Password recovery questions:</em></strong></P></b><b> What is your Father's middle name </b> </td>
                    <td><br/><br /><input type="text" name="answer1" maxlength="15" value="<?php //echo htmlentities($answer1); ?>" /></td>
                 </tr>
                 <tr>
                    <td><br/><b>What is the name of your mother's Father village</b> </td>
                    <td><br/><br /><input type="text" name="answer2" maxlength="15" value="<?php //echo htmlentities($answer2); ?>" /></td>
                 </tr>
                 <tr>     -->
                    <td colspan="2"><br/><input type="submit" name="submit" value="Create User" /></td>
                 </tr>	  
              </table>
          </form>
        </div>
    </div>
   
    <br/>
    <p><a href="managementstaff.php" class="btn btn default btn-lg"><<< Return to Menu and Logout</a></p>

</article>

<?php include("includes/footer.php"); ?>