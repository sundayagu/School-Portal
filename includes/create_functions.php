<?php

/* There will be upto 50 courses to accomodate different
   departments. The number of courses can be adjusted if
   need be. 
*/
/* Remember that each table has unique name for each level
   of the department. we shall use Course table for each
   departmet to determine the couse codes of  c1 .. cn's
   when generating report and we  also filter only
   the courses we need.
*/
/* Remember too that each student takes only the courses for his 
   level and carry-over courses. Hence he can take about 8 to 15 
   courses out of the 50 courses. Therefore there is one gpa.
*/

	function create_result($table_result){  // createresult2.php
		global $connection;
		$query = 'CREATE TABLE ' . $table_result .  ' (' ; 
		$query .= 'id     	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,';
       	$query .= 'regno 	VARCHAR(11) NOT NULL,';
       	$query .= 'level_type	TINYINT(1),';
       	$query .= 'c1 	TINYINT(1),';
       	$query .= 'ca1      TINYINT(2),';            
       	$query .= 'exam1    TINYINT(2),';
        $query .= 'total1   TINYINT(3),';
        $query .= 'grade1   VARCHAR(13),';
        $query .= 'remark1  VARCHAR(24),';

        $query .= 'c2 	TINYINT(1),';
       	$query .= 'ca2      TINYINT(2),';            
       	$query .= 'exam2    TINYINT(2),';
        $query .= 'total2   TINYINT(3),';
        $query .= 'grade2   VARCHAR(13),';
        $query .= 'remark2  VARCHAR(24),';

        $query .= 'c3 	TINYINT(1),';
       	$query .= 'ca3      TINYINT(2),';            
       	$query .= 'exam3    TINYINT(2),';
        $query .= 'total3   TINYINT(3),';
        $query .= 'grade3   VARCHAR(13),';
        $query .= 'remark3  VARCHAR(24),';

        $query .= 'c4 	TINYINT(1),';
       	$query .= 'ca4      TINYINT(2),';            
       	$query .= 'exam4    TINYINT(2),';
        $query .= 'total4   TINYINT(3),';
        $query .= 'grade4   VARCHAR(13),';
        $query .= 'remark4  VARCHAR(24),';

        $query .= 'c5 	TINYINT(1),';
       	$query .= 'ca5     TINYINT(2),';            
       	$query .= 'exam5    TINYINT(2),';
        $query .= 'total5   TINYINT(3),';
        $query .= 'grade5   VARCHAR(13),';
        $query .= 'remark5  VARCHAR(24),';

        $query .= 'c6 	TINYINT(1),';
       	$query .= 'ca6      TINYINT(2),';            
       	$query .= 'exam6    TINYINT(2),';
        $query .= 'total6   TINYINT(3),';
        $query .= 'grade6   VARCHAR(13),';
        $query .= 'remark6  VARCHAR(24),';

        $query .= 'c7 	TINYINT(1),';
       	$query .= 'ca7      TINYINT(2),';            
       	$query .= 'exam7    TINYINT(2),';
        $query .= 'total7   TINYINT(3),';
        $query .= 'grade7   VARCHAR(13),';
        $query .= 'remark7  VARCHAR(24),';

        $query .= 'c8 	TINYINT(1),';
       	$query .= 'ca8      TINYINT(2),';            
       	$query .= 'exam8    TINYINT(2),';
        $query .= 'total8   TINYINT(3),';
        $query .= 'grade8   VARCHAR(13),';
        $query .= 'remark8  VARCHAR(24),';

        $query .= 'c9 	TINYINT(1),';
       	$query .= 'ca9      TINYINT(2),';            
       	$query .= 'exam9    TINYINT(2),';
        $query .= 'total9   TINYINT(3),';
        $query .= 'grade9   VARCHAR(13),';
        $query .= 'remark9  VARCHAR(24),';

        $query .= 'c10 	TINYINT(1),';
       	$query .= 'ca10      TINYINT(2),';            
       	$query .= 'exam10    TINYINT(2),';
        $query .= 'total10   TINYINT(3),';
        $query .= 'grade10   VARCHAR(13),';
        $query .= 'remark10  VARCHAR(24),';

        $query .= 'c11 	TINYINT(1),';
       	$query .= 'ca11      TINYINT(2),';            
       	$query .= 'exam11    TINYINT(2),';
        $query .= 'total11  TINYINT(3),';
        $query .= 'grade11   VARCHAR(13),';
        $query .= 'remark11  VARCHAR(24),';

        $query .= 'c12 	TINYINT(1),';
       	$query .= 'ca12      TINYINT(2),';            
       	$query .= 'exam12    TINYINT(2),';
        $query .= 'total12   TINYINT(3),';
        $query .= 'grade12   VARCHAR(13),';
        $query .= 'remark12  VARCHAR(24),';

        $query .= 'c13 	TINYINT(1),';
       	$query .= 'ca13      TINYINT(2),';            
       	$query .= 'exam13    TINYINT(2),';
        $query .= 'total13   TINYINT(3),';
        $query .= 'grade13   VARCHAR(13),';
        $query .= 'remark13  VARCHAR(24),';

        $query .= 'c14 	TINYINT(1),';
       	$query .= 'ca14      TINYINT(2),';            
       	$query .= 'exam14    TINYINT(2),';
        $query .= 'total14   TINYINT(3),';
        $query .= 'grade14   VARCHAR(13),';
        $query .= 'remark14  VARCHAR(24),';

        $query .= 'c15 	TINYINT(1),';
       	$query .= 'ca15      TINYINT(2),';            
       	$query .= 'exam15    TINYINT(2),';
        $query .= 'total15   TINYINT(3),';
        $query .= 'grade15   VARCHAR(13),';
        $query .= 'remark15  VARCHAR(24),';

        $query .= 'c16 	TINYINT(1),';
       	$query .= 'ca16      TINYINT(2),';            
       	$query .= 'exam16    TINYINT(2),';
        $query .= 'total16   TINYINT(3),';
        $query .= 'grade16   VARCHAR(13),';
        $query .= 'remark16  VARCHAR(24),';

        $query .= 'c17 	TINYINT(1),';
       	$query .= 'ca17      TINYINT(2),';            
       	$query .= 'exam17    TINYINT(2),';
        $query .= 'total17   TINYINT(3),';
        $query .= 'grade17   VARCHAR(13),';
        $query .= 'remark17  VARCHAR(24),';

        $query .= 'c18 	TINYINT(1),';
       	$query .= 'ca18      TINYINT(2),';            
       	$query .= 'exam18    TINYINT(2),';
        $query .= 'total18   TINYINT(3),';
        $query .= 'grade18   VARCHAR(13),';
        $query .= 'remark18  VARCHAR(24),';

        $query .= 'c19 	TINYINT(1),';
       	$query .= 'ca19      TINYINT(2),';            
       	$query .= 'exam19    TINYINT(2),';
        $query .= 'total19   TINYINT(3),';
        $query .= 'grade19   VARCHAR(13),';
        $query .= 'remark19  VARCHAR(24),';

        $query .= 'c20 	TINYINT(1),';
       	$query .= 'ca20      TINYINT(2),';            
       	$query .= 'exam20    TINYINT(2),';
        $query .= 'total20   TINYINT(3),';
        $query .= 'grade20   VARCHAR(13),';
        $query .= 'remark20  VARCHAR(24),';

       	$query .= 'PRIMARY KEY (id),';
        $query .= 'KEY regno (regno)';
        $query .= ') ';
        $query .= 'ENGINE=INNODB';
    	$result = mysql_query($query, $connection);
		confirm_query($result);
		//return $result;
	}


?>