 <?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php //confirm_logged_in_management(); ?> 
<?php include("includes/header.php"); ?>
<?php
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('password', 'password1', 'pnum', 'email', 'answer1', 'answer2');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('password' => 30, 'password1' => 30, 'pnum' => 11);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		// clean up the form data before putting it in the database
		
		$username = $_GET['username'];
		$password = trim(mysql_prep($_POST['password']));
		$password1 = trim(mysql_prep($_POST['password1']));
		$hashed_password = sha1($password);
		$pnum = trim(mysql_prep($_POST['pnum']));
		$email = trim(mysql_prep($_POST['email']));
		$answer1 = trim(mysql_prep($_POST['answer1']));
		$answer2 = trim(mysql_prep($_POST['answer2']));

		$table_users = 'users_lecturer';
		
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){

			// validate email address
			if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$email)){

				//confirm password
				if($password == $password1){

					$result = get_record_by_username($table_users, $username);
					while ($student = mysql_fetch_array($result)) {
						$regno = $student['username'];
						
						$qry = "UPDATE users_lecturer SET hashed_password = '$hashed_password', pnum = '$pnum', email = '$email', answer1 = '$answer1', answer2 = '$answer2', flogin = 2 WHERE username = '$regno' ";
	                    $result1 = mysql_query($qry, $connection);
	                    confirm_query($result1);

                	}

					// test to see if the update occurred
					if($result1){
						// success
					?>
					<br/><br/><br/><br/><br/><br/>
					<div class="col-md-4">
					</div>
					<article class="col-md-5">
						<div class="panel panel-default">
				        <div class="panel-heading">
				           <h4>Success !!!</h4>
				        </div>
				        <div class="panel-body">
				           
				          <form action="login_lecturers.php" method="post">
				        	   <table>
				          		 <tr>
				                    <td><?php echo "Your user account was successfully created"; ?></td>
				                 </tr>
				                 <tr>
				                    <td><?php echo "You can login with your new password"; ?></td>
				                 </tr>
				                 <br/>
				                 <tr>
				                    <td style=text-align:right><br/><input type="submit" name="submit" value="OK  " /></td>
				                 </tr>
				                 	  
				              </table>
				          </form>
				        </div>
				    	</div>
				   	</article>
					<div class="col-md-3">
					</div>
			    	<?php
					} else{
						// Failed
						$message = "The user could not be created.";
						$message .= "<br/>" . mysql_error(); 
					}

					
				} else { // confirm password

					?>
					<br/><br/><br/><br/><br/><br/><br/><br/>
					<div class="col-md-4">
					</div>
					<article class="col-md-5">
						<div class="panel panel-default">
				        <div class="panel-heading">
				           <h4>Information !!!</h4>
				        </div>
				        <div class="panel-body">
				           
				          <form action="login_lecturers.php" method="post">
				        	   <table>
				          		 <tr>
				                    <td><?php echo "Password mismatch !"; ?></td>
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

				} // ends confirm password

			} else { // validate email address

				?>
					<br/><br/><br/><br/><br/><br/><br/><br/>
					<div class="col-md-4">
					</div>
					<article class="col-md-5">
						<div class="panel panel-default">
				        <div class="panel-heading">
				           <h4>Information</h4>
				        </div>
				        <div class="panel-body">
				           
				          <form action="login_lecturers.php" method="post">
				        	   <table>
				          		 <tr>
				                    <td>Please, type a valid Email address: </td>
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

			} // endss validate email address


		} else { // if(empty($errors))
			if(count($errors) == 1){
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}

		?>
		<br/><br/><br/><br/><br/><br/><br/><br/>
		<div class="col-md-4">
		</div>
		<article class="col-md-5">
			<div class="panel panel-default">
	        <div class="panel-heading">
	           <h4>Information !!!</h4>
	        </div>
	        <div class="panel-body">
	           
	          <form action="login_lecturers.php" method="post">
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
		<br/><br/><br/><br/><br/><br/><br/><br/>
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
	
	} // ends if(isset($_POST[])) i.e Form has not been submitted
?>


<?php include("includes/footer.php"); ?>