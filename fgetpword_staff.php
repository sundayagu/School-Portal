<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
	include_once("includes/form_functions.php");
	$username = "";
?>
<?php include("includes/header.php"); ?>
<div class="col-md-4">
</div>
<article class="col-md-5">

    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="fgetpword_staff.php">Manage Staff</a></li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
           <h4>Staff Management</h4>
        </div>
        <div class="panel-body">
           
          <form action="fgetpword_staff2.php" method="post">
        	   <table>
          		 <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" maxlength="11" value="<?php echo strtoupper(htmlentities($username)); ?>" /></td>
                 </tr>
                 <tr>
                    <td colspan="2"><br/><input type="submit" name="submit" value="Submit " /></td>
                 </tr>	  
              </table>
          </form>
        </div>
    </div>
    
    <a href="index.php">Cancel</a>

</article>
<div class="col-md-3">
</div>

<?php include("includes/footer.php"); ?>