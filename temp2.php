<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
	
	//if(logged_in()){
	//echo "You are already logged in";
	//redirect_to('refresh: 20', "students.php");
	//}
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('username', 'question1', 'question2');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		//$fields_with_lengths = array('username' => 11, 'question1' => 15, 'question2' => 15);
		//$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		// Database submission only proceeds if there were NO errors.
        if(!empty($errors)){
           redirect_to("pwordrset1.php");
        }
		
		// clean up the form data before putting it in the database
		$username = trim(mysql_prep($_POST['username']));
		$question1 = trim(mysql_prep($_POST['question1']));
		$question2 = trim(mysql_prep($_POST['question2']));
		
		//echo $username . " - " . $question1 . " - " . $question2 . "<br/>";
		
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){
			//echo $question1 . "<br/>";
			//Check database to see if username and the hashed passowrd exist there.
			//$result_set = get_pword_answers($username, $question1, $question2);
			/*
			if(mysql_num_rows($result_set) == 1){
				// username/answers authenticated
				// and only 1 match
				$student = mysql_fetch_array($result_set);
				$email = $student['email'];
				$username = $student['username'];
				


			} else {
				// username / password combo was not found in the database
				$message = "Username/answers combinations incorrect OR does not exist <br />
							Please remember your caps lock keys combinations and try again.";

				$username = "";
				$question1 = "";
				$question2 = "";
			} */

		
		} // ends if(empty($error))
			
		} else{  //Form has not been submited
			if(isset($_GET['logout']) && $_GET['logout'] == 1 ){
				$message = "You are now logged out";
			}
			
			$username = " ";
			$question1 = " ";
			$question2 = " ";
					
		}
	
?>
<?php include("includes/header.php"); ?>
<div class="col-md-4">
</div>
<article class="col-md-5">
	<!--
    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="login_students.php">login in</a></li>
    </ol> -->
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
          <form action="pwordrset1.php" method="post">
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
<?php include("includes/footer.php"); ?>