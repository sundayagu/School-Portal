<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php include("includes/header.php"); ?>
<div class="col-md-3">
</div>
<article class="col-md-6">
	<!--
    <ol class="breadcrumb">
        <li><a href="index.php">Home</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="login_students.php">login in</a></li>
    </ol> -->
    <br/></br>
    <?php 
    	echo "<p style=\"color:red\"><em>Please, confirm your email address details and click send email.</em></p>";
    ?>
    <br/>
    <?php 
    	//$subj = "Password Recovery";
    	//$mess = "find your recovered password.";
    ?>

    <form method="post" action="">
    	<table border="1" width="25%">
    		<tr>
    			<td width="10">To:</td>
    			<td><input type="text" name="to" size="20" value="<?php echo $_REQUEST['emails'];?>"></td>
    			<!--<td><?php echo $_REQUEST['emails'];?></td>-->
    		</tr>
    		<tr>
	    		<td width="10">Subject:</td>
	    		<td><input type="text" name="subject" size="20" value="Password Recovery"></td>
	    		<!--<td><?php echo $subj;?></td>-->
    		</tr>
    		<tr>
    			<td width="10">Message:</td>
    			<td><textarea name="message" cols="30" rows="3">Find your recovery password</textarea></td>
    		</tr>	
    	</table><br/>
    	<p><input type="submit" name="submit" value="send email"></p>
    </form>

    <?php

    if(isset($_REQUEST['submit'])){

        $to = $_REQUEST['to'];
        $subject = $_REQUEST['subject'];
        $body = $_REQUEST['message'];
        $from ="southingamExams&Records";
        $headers = "From: $from";

        if($to && $subject && $body){

            // validate email address
            if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$to)){

                mail($to, $subject, $body, $headers);
                echo "Your email has been sent";

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
                           
                          <form action="login_students.php" method="post">
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
            }


        } else {

            echo "Please fill up all fields";
        }


    }

    ?>
    
</article>
<div class="col-md-3">
</div>
<?php include("includes/footer.php"); ?>