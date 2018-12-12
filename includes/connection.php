<?php
require("constants.php");
    $connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
    if(!$connection){
        die("Host Connection failed" . mysql_error());
    }
?>
<?php    
    $db_select = mysql_select_db(DB_NAME, $connection);
    if(!$db_select){
        die("Database connection failed" . mysql_error());  
    }
?>