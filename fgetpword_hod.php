<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>

<?php
        $username = "";
        $question1 = "";
        $question2 = "";
    ?>



<?php include("includes/header.php"); ?>
<div class="col-md-4">
</div>
<article class="col-md-5">
	
    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="fgetpword_hod.php">Forget HOD Password</a></li>
    </ol> 
    <br/></br>
    
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<center>
           <h4 style="color:blue"><b>Forget HOD's Password</b></h4>
           <p style="color:red"><strong><em>Please answer the following password recovery questions</em></strong></p>
        	</center>
        </div>
        <div class="panel-body">
           
          <form action="fgetpword_hod2.php" method="post">
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
    include("includes/footer.php"); 
?>