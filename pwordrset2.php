<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted

		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('username', 'question1', 'question2');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('username' => 11, 'question1' => 15, 'question2' => 15);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		// clean up the form data before putting it in the database
		$username = strtoupper(trim(mysql_prep($_POST['username'])));
		$question1 = trim(mysql_prep($_POST['question1']));
		$question2 = trim(mysql_prep($_POST['question2']));

		if(empty($errors)){

			//Check database to see if username and the questions exist and match.
			$result_set = get_pword_answers($username, $question1, $question2);
			if(mysql_num_rows($result_set) == 1){
				$student = mysql_fetch_array($result_set);
				$email = $student['email'];
				$username = $student['username'];

				$password1 = "";
		        $password2 = "";
		        ?>
		        <?php include("includes/header.php"); ?>
		        <div class="col-md-4">
				</div>
				<article class="col-md-5">
					<br/></br>
				    
				    <div class="panel panel-default">
				    	<div class="panel-heading">
				    		<center>
				           <h4 style="color:blue"><b>Reset Your Password</b></h4>
				           <p style="color:red"><strong><em>This will be your new password. keep it safe</em></strong></p>
				        	</center>
				        </div>
				        <div class="panel-body">
				           
				         <form action="pwordrset3.php?username=<?php echo $username;?>" method="post">
				        	   <table>
				          		 <tr>
				          		 	<td>*&nbsp;</td>
				                    <td style="color:blue"><em>Name:</em></td>
				                    <td border="1"><?php echo strtoupper(htmlentities($username)); ?></td>
				                 </tr>
				                 <tr>
				                 	<td style="color:red">*&nbsp;</td>
				                    <td style="color:blue"><br/><em>New Password:</em> </td>
				                    <td><br /><input type="password" name="password1" maxlength="15" value="<?php echo htmlentities($password1); ?>" /></td>
				                 </tr>
				                 <tr>
				                 	<td style="color:red">*&nbsp;</td>
				                    <td style="color:blue"><br/><em>Confirm Password:</em> </td>
				                    <td><br /><input type="password" name="password2" maxlength="15" value="<?php echo htmlentities($password2); ?>" /></td>
				                 </tr>
				                 <tr>
				                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit " /></td>
				                 </tr>	  
				              </table>
				          </form>
				        </div>
				    </div>

				</article>
				<div class="col-md-3">
				</div>


		        <?php

			}else{

				$message = "Username/answers combinations incorrect OR does not exist <br />
							Please remember your caps lock keys combinations and try again.";

				$username = "";
		        $question1 = "";
		        $question2 = "";

		        ?>
		        <?php include("includes/header.php"); ?>
		        <br/><br/>
		        <div class="col-md-4">
				</div>
				<article class="col-md-5">
					<br/></br>
				    <div class="panel panel-default">
				    	<div class="panel-heading">
				    		<center>
				           <h4 style="color:blue"><b>Forget Your Password</b></h4>
				           <p style="color:red"><strong><em>Please answer the following password recovery questions</em></strong></p>
				        	</center>
				        </div>
				        <div class="panel-body">
				        <?php if(!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
						  <?php if(!empty($errors)) {display_errors($errors);} ?>
				           
				          <form action="pwordrset2.php" method="post">
				        	   <table>
				          		 <tr>
				          		 	<td style="color:red">*&nbsp;</td>
				                    <td style="color:blue"><em>Enter your Username:</em></td>
				                    <td><input type="text" name="username" maxlength="11" value="<?php echo strtoupper(htmlentities($username)); ?>" /></td>
				                 </tr>
				                 <tr>
				                 	<td style="color:red">*&nbsp;</td>
				                    <td style="color:blue"><br/><em>What is your Father's middle name:</em> </td>
				                    <td><br /><input type="text" name="question1" maxlength="15" value="<?php echo htmlentities($question1); ?>" /></td>
				                 </tr>
				                 <tr>
				                 	<td style="color:red">*&nbsp;</td>
				                    <td style="color:blue"><br/><em>What is the name of your mother's Father village:</em> </td>
				                    <td><br /><input type="text" name="question2" maxlength="15" value="<?php echo htmlentities($question2); ?>" /></td>
				                 </tr>
				                 <tr>
				                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit " /></td>
				                 </tr>	  
				              </table>
				          </form>
				        </div>
				    </div>

				</article>
				<div class="col-md-3">
				</div>



		        <?php
			}

		}else{
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
			           
			          <form action="pwordrset1.php" method="post">
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
		}


	}else{
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
<?php include("includes/footer.php"); ?>