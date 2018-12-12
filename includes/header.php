<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Southingam University</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/respond.js"></script>
</head>

<body> 
<div class="container">     
    <!-- row 1: navigation -->
    <div class="row">
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="glyphicon glyphicon-arrow-down"></span>
                    MENU
                </button>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown">Users<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="login_students.php">Login / Complete Students User Account</a></li>
                            <li><a href="editnew_user_student1.php">Edit Students User Account</a></li>
                            <li><a href="pwordrset1.php">Forget Password</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown">Courses<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="createcoureg1.php">Registration</a></li>
                            <li><a href="editcoureg1.php">Edit</a></li>
                            <li><a href="viewcourses1.php">View</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown">Eligibility<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="viewexameligibility.php">Check Examination Eligibility</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown">Results<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="viewindividualresult.php">Check Results Per Semester </a></li>
                            <li><a href="viewstatementofresult_tra.php">Check Results Per Session</a></li>
                            <li><a href="trackindividualresults.php">Check All Session Results</a></li>
                            <!--<li><a href="">Edit</a></li>
                            <li><a href="">View</a></li> -->
                        </ul>
                    </li>
         <!--           <li class="dropdown"><a href="#" data-toggle="dropdown">Tools<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="managementstaff.php">Create User Accounts</a></li>
                            <!--<li><a href="hods.php">Assign Courses</a></li>                            <li><a href="attendants.php">Generate Exam Attendants Sheets</a></li>
                            <li><a href="#.php">Capture Scores</a></li>
                            <li><a href="viewgroupresult_mod.php">Modulate Results</a></li>
                            <li><a href="hods.php">Searh Students Data</a></li>
                            <li><a href="hods.php">Search Students Results</a></li>
                            <li><a href="rsetpword1.php">Forget Password</a></li>
                            
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown">Reports<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#.php">Registered Departmental Level Courses</a></li>
                            <li><a href="courseStatistics1.php">Course Registration Summaries</a></li>
                            <li><a href="viewgroupresult_hod.php">Class Results</a></li>
                            <li><a href="viewcompositesheet.php">Composite Results</a></li>
                            <li><a href=".php">Summary Results</a></li>
                            
                        </ul>
                    </li> -->
                    <li><a href="fgetpword_staff.php">Manage</a></li>
                    <li><a href="#">Southingam Main Site</a></li>
             
                </ul>
            </div>
        </nav>
    </div>

    <!-- row 2 -->
    <header class="row" style="background:#fff;padding-bottom:4px; padding-top:0px; border: 0px solid #ccc; margin-top:0px; margin-bottom:0px">
        <div class="col-lg-3 col-sm-4">
         <a><img src="img/uniportlogo4.png" alt="Southingam University" class="img-responsive"></a>
        </div>
        <div class="col-lg-7 col-sm-6" style="background:#3300cc">
           <h2 style="color:yellow"><b>Students Course Registration and Result Management System</b></h2> 
        </div>
        <div class="col-lg-2 col-sm-2">
            <p><a href="students.php" class="btn btn-info img-responsive">Student Login</a></p>
            <p><a href="logout.php" class="btn btn-info img-responsive" class="pull-right">Logout</a></p>
            <!--
                <p><a href="lecturers.php" class="btn btn-info img-responsive">Staff Login</a>&nbsp;
                <a href="logout.php" class="btn btn-info img-responsive" class="pull-right">Out</a></p>
            -->
        </div>
    </header>
    
    <!-- <hr/> -->
    <!-- row 3 -->
    <div class="row">