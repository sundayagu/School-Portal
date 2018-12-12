<?php require_once("includes/connection.php"); ?>
<?php
$query = "SELECT flogin FROM users_student";
$students = mysql_query($query, $connection);
while ($student = mysql_fetch_array($students)) {
	$qry = "UPDATE users_student SET 
	   flogin = 1";
	$result = mysql_query($qry, $connection);
}

?>
<?php require("includes/footer.php"); ?>