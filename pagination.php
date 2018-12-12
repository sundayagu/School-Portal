<?php require_once("includes/connection.php"); ?>
<?php 
echo "<u>Results:</u>&nbsp";
	$per_page = 6;
	$pages_query = mysql_query("SELECT COUNT('stu_id') FROM csctra ");
	$pages = ceil(mysql_result($pages_query, 0) / $per_page);

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start = ($page - 1 ) * $per_page;
	
	$qry = "SELECT regno,c1,g1,c2,g2,c3,g3,c4,g4,c5,g5,c6,g6 FROM csctra LIMIT $start, $per_page";
	$query = mysql_query($qry, $connection);
	while($query_row = mysql_fetch_assoc($query)){
		echo $query_row['regno'] . '<br/>';
	}

	$count = mysql_num_rows($query);

	echo "$count result(s) found for <b></b> <br/><br/>";

	$prev = $page - 1;
	$next = $page + 1;

	//echo "<center>";
	if(!($page<=1)){
		echo "<a href='pagination.php?page=$prev'>Prev</a> ";
	}

	if($pages >= 1){
		for($x=1; $x<=$pages; $x++){

			echo ($x == $page) ? '<b><a href="?page='.$x. '">' .$x. '</a></b> ' : '<a href="?page='.$x. '">' .$x. '</a> ';

		}
	}

	if(!($page >= $pages)){
		echo "<a href='pagination.php?page=$next'>Next</a> ";
	}
	//echo "</center>";

?>


