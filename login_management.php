<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
	if(logged_in_management()){
	redirect_to("managementstaff.php");
	}
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('username' => 15, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		// clean up the form data before putting it in the database
		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){
			//Check database to see if username and the hashed passowrd exist there.
			$query = "SELECT id, username, mflag ";
			$query .= "FROM users_management ";
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
				$_SESSION['username'] = $found_user['username'];
				$_SESSION['mflag'] = $found_user['mflag'];
				redirect_to("managementstaff.php");
			} else {
				// username / password combo was not found in the database
				$message = "Username/password combination incorrect. <br />
							Please make sure your caps lock key is off and try again.";
			}
		}
			
		} else{  //Form has not been submited
			if(isset($_GET['logout']) && $_GET['logout'] == 1 ){
				$message = "You are now logged out";
			}
			$username = "";
			$password = "";
		
		}
	
?>
<?php include("includes/header.php"); ?>
<div class="col-md-4">
</div>
<article class="col-md-5">

    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="login_management.php">login in</a></li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
           <h4>Management Staff Login</h4>
        </div>
        <div class="panel-body">
           <?php if(!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
		  <?php if(!empty($errors)) {display_errors($errors);} ?>
          <form action="login_management.php" method="post">
        	   <table>
          		 <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" maxlength="15" value="<?php echo htmlentities($username); ?>" /></td>
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
<div class="col-md-3">
</div>
<?php include("includes/footer.php"); ?>