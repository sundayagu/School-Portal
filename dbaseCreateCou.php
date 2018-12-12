<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	global $connection;
		$query = 'CREATE TABLE mcb14151c (' ; 
		$query .= 'course_id     	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,';
   	$query .= 'course_code  VARCHAR(6) NOT NULL,';
    $query .= 'course_title 	VARCHAR(50) NOT NULL,';
   	$query .= 'credit_unit	TINYINT(1) NOT NULL,';
   	$query .= 'level_type 	TINYINT(1),';            
   	$query .= 'cordinator  VARCHAR(40),';
    $query .= 'username  VARCHAR(15),';
        
   	$query .= 'PRIMARY KEY (course_id),';
    $query .= 'KEY (course_code)';
    $query .= ') ';
    $query .= 'ENGINE=INNODB';
	$result = mysql_query($query, $connection);
	confirm_query($result);
?>

<?php         
  
?>