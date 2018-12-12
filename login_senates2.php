<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>

<?php
	
	/*
	if(logged_in()){
	redirect_to("hods.php");
	}
	*/
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('username' => 11, 'password' => 15);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		// clean up the form data before putting it in the database
		$username = strtoupper(trim(mysql_prep($_POST['username'])));
		$password = trim(mysql_prep($_POST['password']));
		
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){

			// check database for first login
			$table_user = 'users_senate' ;
			$user = get_login_user($table_user, $username, $password);
			$result = mysql_fetch_array($user);
			$flogin = $result['flogin'];


			if ($flogin == 1){ // its the first login

				// get the student data for display
				$name = $result['sen_name'];
				$sex = $result['sen_sex'];
				$session = $result['adm_sess'];
				$dept = $result['dept_code'];
				//$status = $result['sflag'];
				
				$deptdisplay = get_department_by_deptcode($dept);
				$sexdisplay = get_sex_by_id($sex);
				//$statdisplay = get_stat_by_id($status);
				$sessdisplay = get_session_by_sesscode($session);

			$password = "";
			$password1 = "";
			$pnum = "";
			$email = "";
			$answer1 = "";
			$answer2 = "";

			?>
			<?php include("includes/header.php"); ?>
			<br/>
			<div class="col-md-4">
			</div>
			<article class="col-md-5">
			<div class="panel panel-default">
	        <div class="panel-heading">
	        	<center>
		        	<p style="color:red"><strong><em>This is your First Login</em></strong></p>
		           <h4 style="color:blue">Change your Password and Complete your Profile</h4>
		        </center>
	        </div>
	        <div class="panel-body">
	        <!--   <?php if(!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			  <?php if(!empty($errors)) {display_errors($errors);} ?>  -->
	        <?php echo "<form action=\"login_senates3.php?username=$username\" method=\"post\"> " ?>
	        	  <table>
	          		 <tr>
	                    <td><b>Name:</b> </td>
	                    <td><?php echo $name; ?></td>
	                 </tr>
	                 <tr>
	                    <td><b>Username:</b> </td>
	                    <td><br /><?php echo strtoupper($username); ?></td>
	                 </tr>
	                 <tr>
	                    <td><br /><b>Gender:</b> </td>
	                    <td><br /><?php echo trim($sexdisplay['sex_name']); ?></td>
	                 </tr>
	          		 
	                 <tr>
	                    <td><b>New Password:</b> </td>
	                    <td><br /><input type="password" name="password" maxlength="15" value="<?php echo htmlentities($password); ?>" /></td>
	                 </tr>
	                 <tr>
	                    <td><b>Confirm Password:</b> </td>
	                    <td><br /><input type="password" name="password1" maxlength="15" value="<?php echo htmlentities($password1); ?>" /></td>
	                 </tr>
	                 <tr>
	                 	<td><b>Department:</b></td>
	                 	<td><br/><?php echo trim($deptdisplay['dept_name']) ; ?></td>
	                 </tr>
	                 <tr>
	                 	<td><b>Session:</b></td>
	                 	<td><br/><?php echo trim($sessdisplay['session_title']); ; ?></td>
	                 </tr>
	                 <tr>
	                    <td><b>Mobile Phone Number:</b> </td>
	                    <td><br /><input type="text" name="pnum" maxlength="11" value="<?php //echo htmlentities($pnum); ?>" /></td>
	                 </tr>
	                 <tr>
	                    <td><b>Email Address:</b> </td>
	                    <td><br /><input type="text" name="email" maxlength="40" value="<?php //echo htmlentities($email); ?>" /></td>
	                 </tr>
	                 <tr>
	                    <td><b><p style="color:red"><strong><em>Password recovery questions:</em></strong></P></b><b> What is your Father's middle name</b> </td>
	                    <td><br /><input type="text" name="answer1" maxlength="15" value="<?php //echo htmlentities($answer1); ?>" /></td>
	                 </tr>
	                 <tr>
	                    <td><b>What is the name of your mother's Father village</b> </td>
	                    <td><br /><input type="text" name="answer2" maxlength="15" value="<?php //echo htmlentities($answer2); ?>" /></td>
	                 </tr>
	                 <tr>
	                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit" /></td>
	                 </tr>	  
	              </table>
		          </form>
		        </div>
		    </div>
		    </article>
		<div class="col-md-3">
		</div>


    		<?php

			} else { // not first login i.e if($flogin == 1)
				
				//include("includes/header.php");

				// check for normal permission and login

				//Check database to see if username and the hashed passowrd exist there.
				$hashed_password = sha1($password);
				$query = "SELECT id, sen_name, sen_sex, username, eflag, adm_sess, dept_code, pnum, email, answer1, answer2 ";
				$query .= "FROM users_senate ";
				$query .= "WHERE username = '{$username}' ";
				$query .= "AND hashed_password = '{$hashed_password}' ";
				$query .= "LIMIT 1";
				$result_set = mysql_query($query);
				confirm_query($result_set);

				if(mysql_num_rows($result_set) == 1){
					// username/password authenticated
					// and only 1 match
					$found_user = mysql_fetch_array($result_set);
					$_SESSION['user_id'] = $found_user['id'];
					$_SESSION['sen_name'] = $found_user['sen_name'];
					$_SESSION['sen_sex'] = $found_user['sen_sex'];
					$_SESSION['username'] = $found_user['username'];
					$_SESSION['eflag'] = $found_user['eflag'];
					$_SESSION['adm_sess'] = $found_user['adm_sess'];
					$_SESSION['dept_code'] = $found_user['dept_code'];
					$_SESSION['pnum'] = $found_user['pnum'];
					$_SESSION['email'] = $found_user['email'];
					$_SESSION['answer1'] = $found_user['answer2'];
					$regno = $_SESSION['username'];
					redirect_to("senates.php?regno=$regno");
					} else { // ends if(mysql_num_rows($result_set) == 1){ 
					// username / password combo was not found in the database
					$message = "Username/password combination incorrect OR does not exist <br />
								Please make sure your caps lock key is off and try again.";

					$username = "";
					$password = "";

					?>
					<?php include("includes/header.php"); ?>
					<br/><br/><br/><br/>
					<div class="col-md-4">
					</div>
					<article class="col-md-5">
						<div class="panel panel-default">
				        <div class="panel-heading">
				           <h4>Senates Login</h4>
				        </div>
				        <div class="panel-body">
				           <?php if(!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
						  <?php if(!empty($errors)) {display_errors($errors);} ?>
				          <form action="login_senates2.php" method="post">
				        	   <table>
				          		 <tr>
				                    <td>Username: </td>
				                    <td><input type="text" name="username" maxlength="11" value="<?php echo strtoupper(htmlentities($username)); ?>" /></td>
				                 </tr>
				                 <tr>
				                    <td>Password: </td>
				                    <td><br /><input type="password" name="password" maxlength="15" value="<?php echo htmlentities($password); ?>" /></td>
				                 </tr>
				                 <tr>
				                    <td colspan="2"><br/><input type="submit" name="submit" value="Login " /></td>
				                 </tr>	  
				              </table>
				          </form>
				        </div>
				    </div>
				   	</article>
					<div class="col-md-3">
					</div>
			    	<?php

				} // ends if(mysql_num_rows($result_set) == 1){ 
		

			} // ends else of if(not first login_studentsn) i.e if($flogin == 1)



		} else { // if(empty($errors))

			if(count($errors) == 1){
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}

			?>
				<?php include("includes/header.php"); ?>
				<br/><br/><br/><br/>
				<div class="col-md-4">
				</div>
				<article class="col-md-5">
					<div class="panel panel-default">
			        <div class="panel-heading">
			           <h4>Information !!!</h4>
			        </div>
			        <div class="panel-body">
			           
			          <form action="login_senates.php" method="post">
			        	   <table>
			          		 <tr>
			                    <td><?php echo "<p class=\"message\">" . $message . "</p>"; ?></td>
			                 </tr>
			                 <tr>
			                    <td><?php echo "<p> You have to complete the form!</p>"; ?></td>
			                 </tr>
			                 <tr>
			                    <td style=text-align:right><br/><input type="submit" name="submit" value="Try again " /></td>
			                 </tr>	  
			              </table>
			          </form>
			        </div>
			    	</div>
			   	</article>
				<div class="col-md-3">
				</div>
		    <?php
		

		} // ends if(empty($errors))

		} else{  //Form has not been submited
			?>
				<?php include("includes/header.php"); ?>
				<br/><br/><br/><br/>
				<div class="col-md-4">
				</div>
				<article class="col-md-5">
					<div class="panel panel-default">
			        <div class="panel-heading">
			           <h4>Illegal Entry</h4>
			        </div>
			        <div class="panel-body">
			           
			          <form action="index.php" method="post">
			        	   <table>
			          		 <tr>
			                    <td>Sorry, you entered into this environment illegally !!!: </td>
			                 </tr>
			                 <tr>
			                    <td style=text-align:right><br/><input type="submit" name="submit" value="OK " /></td>
			                 </tr>	  
			              </table>
			          </form>
			        </div>
			    	</div>
			   	</article>
				<div class="col-md-3">
				</div>
		    <?php
		
		} // ends Form has not been submited
	
?>

<!--
<div class="col-md-4">
</div>
-->
<!--
<article class="col-md-5">

    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="login_students.php">login in</a></li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
           <h4>Students / Parents Login</h4>
        </div>
        <div class="panel-body">
           <?php if(!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
		  <?php if(!empty($errors)) {display_errors($errors);} ?>
          <form action="login_students.php" method="post">
        	   <table>
          		 <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" maxlength="11" value="<?php echo strtoupper(htmlentities($username)); ?>" /></td>
                 </tr>
                 <tr>
                    <td>Password: </td>
                    <td><br /><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></td>
                 </tr>
                 <tr>
                    <td colspan="2"><br/><input type="submit" name="submit" value="Login " /></td>
                 </tr>	  
              </table>
          </form>
        </div>
    </div>

</article>
-->
<!--
<div class="col-md-3">
</div>
-->
<?php include("includes/footer.php"); ?>