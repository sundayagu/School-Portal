<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php include("includes/header.php"); ?>

<?php
	
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if(isset($_POST['submit'])){  // Form has been submitted
		
		// initialize an array to hold our errors
		$errors = array();
		
		// perform validations on the form data
		$required_fields = array('username');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('username' => 11);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
		
		// clean up the form data before putting it in the database
		$username = strtoupper(trim(mysql_prep($_POST['username'])));
				
		// Database submission only proceeds if there were NO errors.
		if(empty($errors)){

			$user = substr($username, 0, 3);
			//echo $user;
			if($user == 'STF'){
				// sucsess
				?>
				<div class="col-md-4">
				</div>
				<article class="col-md-5">
					<ol class="breadcrumb">
				        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
				        <li class="active"><a href="#.php">Manage Staff</a></li>
				    </ol>
				    <div class="panel panel-default">
				        <div class="panel-heading">
				           <h4>Select Status</h4>
				        </div>
				        <div class="panel-body">
				           
				          <form action="fgetpword_staff3.php" method="post">
				        	   <table>
				        	   	<tr>
				                    <td colspan="2" style="color:red"><b><em>Please select your Status for Password Recovery management !!!</em></b></td>
				                 </tr>	
				          		 <tr>
				                    <td style="color:blue"><br/><b><em>Status:</em></b> </td>
								        <td><br/>
								        	<select name="status">
												<option value="">Select Status</option>
												<option value="2">Lecturer</option>
												<option value="3">HOD</option>
												<option value="4">Senate</option>
												<option value="5">Mgt Staff</option>
											</select>
										</td>
									</tr>
				                 <tr>
				                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit " /></td>
				                 </tr>	  
				              </table>
				          </form>
				        </div>
				    </div>

				    <a href="fgetpword_staff.php"><<< Previous</a>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <a href="index.php">Home</a>

				</article>
				<div class="col-md-3">
				</div>
				<?php
			} else{
				echo "<br/>Access Denial";
				?>&nbsp;&nbsp;&nbsp;
				<?php 
				echo " ! ! ! <br/>";
				echo "<br/>You are not a staff";
			}

			
		} else { // if(empty($errors))

			echo "<br/>Please Enter your username ! ! ! <br/>";
			echo "<a href=\"fgetpword_staff.php\">Try Again</a>";

		} // ends if(empty($errors))

	}
	
?>

<?php include("includes/footer.php"); ?>