<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	global $connection;
	$query = 'CREATE TABLE csccr (' ; 
	$query .= 'coursereg_id     	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,';
   	$query .= 'stu_name  VARCHAR(40) NOT NULL,';
    $query .= 'stu_sex  TINYINT(1) NOT NULL,';
    $query .= 'regno 	VARCHAR(11) NOT NULL,';
    $query .= 'session   TINYINT(2) NOT NULL,';
   	$query .= 'level_type	TINYINT(1) NOT NULL,';
    $query .= 'semester   TINYINT(1) NOT NULL,';
   	$query .= 'c1 	TINYINT(1),';            
   	$query .= 'c2   TINYINT(1),';
    $query .= 'c3   TINYINT(1),';
    $query .= 'c4   TINYINT(1),';
    $query .= 'c5   TINYINT(1),';
    $query .= 'c6   TINYINT(1),';
    $query .= 'c7   TINYINT(1),';            
    $query .= 'c8   TINYINT(1),';
    $query .= 'c9   TINYINT(1),';
    $query .= 'c10   TINYINT(1),';
    $query .= 'c11   TINYINT(1),';
    $query .= 'c12   TINYINT(1),';
    $query .= 'c13   TINYINT(1),';            
    $query .= 'c14   TINYINT(1),';
    $query .= 'c15   TINYINT(1),';
    $query .= 'c16   TINYINT(1),';
    $query .= 'c17   TINYINT(1),';
    $query .= 'c18   TINYINT(1),';
    $query .= 'c19   TINYINT(1),';
    $query .= 'c20   TINYINT(1),';
    $query .= 'c21   TINYINT(1),';
    $query .= 'c22   TINYINT(1),';
    $query .= 'c23   TINYINT(1),';
    $query .= 'c24   TINYINT(1),';
    $query .= 'c25   TINYINT(1),';
    $query .= 'c26   TINYINT(1),';
    $query .= 'totalcredit   TINYINT(2),';
    
   	$query .= 'PRIMARY KEY (coursereg_id),';
    $query .= 'KEY (regno)';
    $query .= ') ';
    $query .= 'ENGINE=INNODB';
	$result = mysql_query($query, $connection);
	confirm_query($result);
?>

<?php         
  
?>