<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php
	if(logged_in_senates()){
	redirect_to("senates.php");
	}

    include_once("includes/form_functions.php");
	$username = "";
	$password = "";
?>
<?php include("includes/header.php"); ?>
<div class="col-md-4">
</div>
<article class="col-md-5">

    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="login_senates.php">login in</a></li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
           <h4>Senates Login</h4>
        </div>
        <div class="panel-body">
           
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

<?php include("includes/footer.php"); ?>