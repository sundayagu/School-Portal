<?php require_once("includes/session.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in_senates(); ?>
<?php include("includes/header.php"); ?>
<article class="col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1 col-lg-push-4 col-sm-push-4">
    <ol class="breadcrumb">
        <li><a href="">Login</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
        <li class="active"><a href="">Senates Area</a><span class="glyphicon glyphicon-circle-arrow-right"></span></li>
    </ol>

    <h2 style='color:red'>Senates Area</h2>
    <p style='color:blue'>Welcome to Senates Area: <?php  echo $_SESSION['username']; ?></p>
    <p><img src="img/senate.png" alt="" class="pull-left img-responsive img-rounded"></p>
    <p>&nbsp;</p>
    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Authomated System is that it has a more-or-less normal distribution of entities, as opposed to using 'Content.</p><br/>
    <a href="index.php">Cancel</a>
</article>
<aside class="col-lg-4 col-sm-4 col-lg-pull-8 col-sm-pull-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Please select what you want to do</h4>
        </div>
        <div class="panel-body">
            <ul>
                
                <li><a href="courseStatistics1.php">Check Course Registration Summaries</a></li>
                <li>&nbsp;</li>
                <li><a href="viewcompositesheet.php">Check Composite Results</a></li>
                <li>&nbsp;</li>
                <li><a href="viewsenatesheet.php">Check Summary Results</a></li>
                              
            </ul>
        </div>
    </div>    
</aside>
<?php include("includes/footer.php"); ?>