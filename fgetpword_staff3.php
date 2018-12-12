<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php //include("includes/header.php"); ?>

<?php
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('status');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		// clean up the form data before putting it in the database
		$status = mysql_prep($_POST['status']);
				
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){

			switch ($status) {
				case $status == 2:
					redirect_to("fgetpword_lec.php");
					break;

				case $status == 3:
					redirect_to("fgetpword_hod.php");
					break;

				case $status == 4:
					redirect_to("fgetpword_sen.php");
					break;
				
				default:
					# code...
					break;
			}

			
		} else { // if(empty($errors))

			echo "<br/>Please Enter username and Select your status ! ! ! <br/>";
			echo "<a href=\"fgetpword_staff.php\">Try Again</a>";

		} // ends if(empty($errors))

	} // ends Form has not been submited
	
?>

<?php include("includes/footer.php"); ?>