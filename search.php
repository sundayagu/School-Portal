<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in_hods(); ?>
<?php include("includes/header.php"); ?>

<?php
$button = $_GET ['submit'];
$search = $_GET ['search']; 

$lowBoundSession = $_GET['lowBoundSession'];
$upBoundSession = $_GET['upBoundSession'];
//$dept = $_GET['dept'];
$dept = $_SESSION['dept_code'];
$table_course = $dept . 'c';
$table_tra = $dept .'tra';

$course = get_department_course_by_coursecode2($table_course, $search);
	
	if($course = mysql_fetch_array($course)){
		$ca = 'a' . $course['course_id'];
		$exam = 'e' . $course['course_id'];
        $course_column = 'c' . $course['course_id'];  // to be used for course total
        $grade = 'g' . $course['course_id'];
        $remark = 'r' . $course['course_id'];
        $level_type = $course['level_type'];

       
		$ccode = 'ccode' . $course['course_id'];
       
	} else { // ends if($course_row)
    echo "<br/>";
		echo "* Course Code not entered or incorrect <br/><br/>";
		echo "<a href=\"searchResults1.php\">Try Again</a> <br/><br/>";

	}
  

if(strlen($search)<=0)
echo "* Search term too short <br/>";
else{
echo "<br/>You searched for <b>" . strtoupper($search) . "</b> <hr size='1'>";
 //mysql_connect("localhost", "root", "") or die ("couldnt connect");
   // mysql_select_db("enter");
$search_exploded = explode (" ", $search);

$x = "";
$construct = "";  
   
foreach($search_exploded as $search_each)
{
$x++;
if($x==1)
$construct .="$ccode = '$search_each' AND session >= '$lowBoundSession' AND session <= '$upBoundSession' AND $course_column <> 'NULL'";
  else
$construct .="AND $ccode = '$search_each' AND session >= '$lowBoundSession' AND session <= '$upBoundSession' AND $course_column <> 'NULL' ";
   
}
 
$constructs ="SELECT * FROM $table_tra WHERE $construct";
$run = mysql_query($constructs);
   
$foundnum = mysql_num_rows($run);
   
if ($foundnum==0)
echo "Sorry, there are no matching result for <b>" . strtoupper($search) . "</b>.</br></br>1. 
Please, select all the boxes appropriately.<br/> &nbsp;&nbsp;&nbsp; for example: 'From Select Session' must be less than 'To Select Session'  <br/>2. Try typing the correct course code</br>3. Check your spelling <br/><br/><a href=\"searchResults1.php\">Try Again</a>";
 
else
{ 
 
echo "$foundnum results found !<p>";
 
$per_page = 10;
$start = isset($_GET['start']) ? $_GET['start']: '';
$max_pages = ceil($foundnum / $per_page);
if(!$start)
$start=0; 
$getquery = mysql_query("SELECT * FROM $table_tra WHERE $construct LIMIT $start, $per_page");
 
  
    echo"<center>";
   // display heading
    $deptdisplay = get_department_by_deptcode($dept);
    $lowsessdisplay = get_session_by_sesscode($lowBoundSession);
    $upsessdisplay = get_session_by_sesscode($upBoundSession);
    echo "<b>" . strtoupper($search) . " " .  $course['course_title'] . ",  " . strtoupper(trim($deptdisplay['dept_name'])). " DEPARTMENT From: "
     . trim($lowsessdisplay['session_title']) . "     To:   ". trim($upsessdisplay['session_title']). "</b> <br/><br/>";
    
    $sn = 1;
     
    ?>
    <table width=90% align=center border=1>
                <tr>
                    <!--<th style=text-align:center bgcolor="FFFF00">S/N</th>-->
                    <th width=15% style=text-align:center bgcolor="FFFF00">NAME</th>
                    <th style=text-align:center bgcolor="FFFF00">REG NO.</th>
                    <th style=text-align:center bgcolor="FFFF00" >SEX</th>
                    <th style=text-align:center bgcolor="FFFF00">SESSION</th>
                    <th style=text-align:center bgcolor="FFFF00">CA</th>
                    <th style=text-align:center bgcolor="FFFF00">EXAM</th>
                    <th style=text-align:center bgcolor="FFFF00">TOTAL</th>
                    <th style=text-align:center bgcolor="FFFF00">GRADE</th>
                    <th style=text-align:center bgcolor="FFFF00">REMARK</th>
                </tr>
        <?php 
      
    while ($students = mysql_fetch_array($getquery)) {
      $sexdisplay = get_sex_by_id($students['stu_sex']);
      if ($sexdisplay['sex_id'] == 1) {
        $sex = 'M';
      } else{
        $sex = 'F';
      }
      
      if(!empty($students[$course_column])){
        echo "
          <tr>
                      <!--<td >$sn</td>-->
                      <td>{$students['stu_name']}</td>
                      <td style=text-align:center >{$students['regno']}</td>
                      <td style=text-align:center>$sex</td>
                      <td style=text-align:center>{$students['session']}</td>
                      <td style=text-align:center>{$students[$ca]}</td>
                      <td style=text-align:center>{$students[$exam]}</td>
                      <td style=text-align:center>{$students[$course_column]}</td>
                      <td style=text-align:center>{$students[$grade]}</td>
                      <td style=text-align:center>{$students[$remark]}</td>
                  </tr>

        ";
        $sn = $sn + 1; 
      }
    
    }
    echo "</table> <br/>";

    echo "</center>";

    echo "<br/><a href=\"hods.php\">Return to Hod's Menu</a>";

//Pagination Starts
echo "<center>";
 
$prev = $start - $per_page;
$next = $start + $per_page;
                      
$adjacents = 3;
$last = $max_pages - 1;
 
if($max_pages > 1)
{   
//previous button
if (!($start<=0)) 
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$prev'>Prev</a> ";    
         
//pages 
if ($max_pages < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
{
$i = 0;   
for ($counter = 1; $counter <= $max_pages; $counter++)
{
if ($i == $start){
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'><b>$counter</b></a> ";
}
else {
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'>$counter</a> ";
}  
$i = $i + $per_page;                 
}
}
elseif($max_pages > 5 + ($adjacents * 2))    //enough pages to hide some
{
//close to beginning; only hide later pages
if(($start/$per_page) < 1 + ($adjacents * 2))        
{
$i = 0;
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($i == $start){
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'><b>$counter</b></a> ";
}
else {
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'>$counter</a> ";
} 
$i = $i + $per_page;                                       
}
                         
}
//in middle; hide some front and some back
elseif($max_pages - ($adjacents * 2) > ($start / $per_page) && ($start / $per_page) > ($adjacents * 2))
{
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=0'>1</a> ";
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$per_page'>2</a> .... ";

$i = $start;                 
for ($counter = ($start/$per_page)+1; $counter < ($start / $per_page) + $adjacents + 2; $counter++)
{
if ($i == $start){
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'><b>$counter</b></a> ";
}
else {
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'>$counter</a> ";
}   
$i = $i + $per_page;                
}
                                 
}
//close to end; only hide early pages
else
{
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=0'>1</a> ";
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$per_page'>2</a> .... ";

$i = $start;                
for ($counter = ($start / $per_page) + 1; $counter <= $max_pages; $counter++)
{
if ($i == $start){
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'><b>$counter</b></a> ";
}
else {
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$i'>$counter</a> ";   
} 
$i = $i + $per_page;              
}
}
}
         
//next button
if (!($start >=$foundnum-$per_page))
echo " <a href='search.php?search=$search&dept=$dept&lowBoundSession=$lowBoundSession&upBoundSession=$upBoundSession&submit=Search+Database&start=$next'>Next</a> ";    
}   
echo "</center>";
} 
} 

?>