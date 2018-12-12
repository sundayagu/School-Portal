<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	global $connection;
	$query = 'CREATE TABLE csctra (' ; // change csc for other departments
	$query .= 'stu_id     	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,';
   	$query .= 'stu_name  VARCHAR(40) NOT NULL,';
    $query .= 'stu_sex  TINYINT(1) NOT NULL,';
    $query .= 'regno 	VARCHAR(11) NOT NULL,';
    $query .= 'session   TINYINT(2) NOT NULL,';
    $query .= 'level_type   TINYINT(1) NOT NULL,';  // for the student, not for the courses
    $query .= 'semester   TINYINT(1) NOT NULL,';
    $query .= 'a1   TINYINT(2),';    // for first course CA scores according to course table
    $query .= 'e1   TINYINT(2),';    //  "    "      "   Exam  "      "      "    "      "
    $query .= 'c1   TINYINT(3),';    //  "    "      "   Total of CA and Exam scores according to course table
    $query .= 'g1   VARCHAR(13),';   //  "    "       "   Grades   
    $query .= 'r1   VARCHAR(24),';   //  "    "       "   Remarks
    $query .= 'a2   TINYINT(2),';    // for second course CA scores according to course table
    $query .= 'e2   TINYINT(2),';    //  "    "      "   Exam  "      "      "    "      "
    $query .= 'c2   TINYINT(3),';    //  "    "      "   Total of CA and Exam scores according to course table
    $query .= 'g2   VARCHAR(13),';   //  "    "       "   Grades   
    $query .= 'r2   VARCHAR(24),';   //  "    "       "   Remarks
    $query .= 'a3   TINYINT(2),';    // 
    $query .= 'e3   TINYINT(2),';    // 
    $query .= 'c3   TINYINT(3),';    //     and so on
    $query .= 'g3   VARCHAR(13),';   // 
    $query .= 'r3   VARCHAR(24),';   // 
    $query .= 'a4   TINYINT(2),';     
    $query .= 'e4   TINYINT(2),';     
    $query .= 'c4   TINYINT(3),';    
    $query .= 'g4   VARCHAR(13),';    
    $query .= 'r4   VARCHAR(24),';
    $query .= 'a5   TINYINT(2),';     
    $query .= 'e5   TINYINT(2),';     
    $query .= 'c5   TINYINT(3),';    
    $query .= 'g5   VARCHAR(13),';    
    $query .= 'r5   VARCHAR(24),';
    $query .= 'a6   TINYINT(2),';     
    $query .= 'e6   TINYINT(2),';     
    $query .= 'c6   TINYINT(3),';    
    $query .= 'g6   VARCHAR(13),';    
    $query .= 'r6   VARCHAR(24),';    
    $query .= 'a7   TINYINT(2),';     
    $query .= 'e7   TINYINT(2),';     
    $query .= 'c7   TINYINT(3),';    
    $query .= 'g7   VARCHAR(13),';    
    $query .= 'r7   VARCHAR(24),';
    $query .= 'a8   TINYINT(2),';     
    $query .= 'e8   TINYINT(2),';     
    $query .= 'c8   TINYINT(3),';    
    $query .= 'g8   VARCHAR(13),';    
    $query .= 'r8   VARCHAR(24),';
    $query .= 'a9   TINYINT(2),';     
    $query .= 'e9   TINYINT(2),';     
    $query .= 'c9   TINYINT(3),';    
    $query .= 'g9   VARCHAR(13),';    
    $query .= 'r9   VARCHAR(24),';
    $query .= 'a10   TINYINT(2),';     
    $query .= 'e10   TINYINT(2),';     
    $query .= 'c10   TINYINT(3),';    
    $query .= 'g10   VARCHAR(13),';    
    $query .= 'r10   VARCHAR(24),';
    $query .= 'a11   TINYINT(2),';     
    $query .= 'e11   TINYINT(2),';     
    $query .= 'c11   TINYINT(3),';    
    $query .= 'g11   VARCHAR(13),';    
    $query .= 'r11   VARCHAR(24),';
    $query .= 'a12   TINYINT(2),';     
    $query .= 'e12   TINYINT(2),';     
    $query .= 'c12   TINYINT(3),';    
    $query .= 'g12   VARCHAR(13),';    
    $query .= 'r12   VARCHAR(24),';
    $query .= 'a13   TINYINT(2),';     
    $query .= 'e13   TINYINT(2),';     
    $query .= 'c13   TINYINT(3),';    
    $query .= 'g13   VARCHAR(13),';    
    $query .= 'r13   VARCHAR(24),';
    $query .= 'a14   TINYINT(2),';     
    $query .= 'e14   TINYINT(2),';     
    $query .= 'c14   TINYINT(3),';    
    $query .= 'g14   VARCHAR(13),';    
    $query .= 'r14   VARCHAR(24),';
    $query .= 'a15   TINYINT(2),';     
    $query .= 'e15   TINYINT(2),';     
    $query .= 'c15   TINYINT(3),';    
    $query .= 'g15   VARCHAR(13),';    
    $query .= 'r15   VARCHAR(24),';

    $query .= 'gpa1   DECIMAL(3,2),';   // 1st semester gpa
    
    $query .= 'a16   TINYINT(2),';     
    $query .= 'e16   TINYINT(2),';     
    $query .= 'c16   TINYINT(3),';    
    $query .= 'g16   VARCHAR(13),';    
    $query .= 'r16   VARCHAR(24),';
    $query .= 'a17   TINYINT(2),';     
    $query .= 'e17   TINYINT(2),';     
    $query .= 'c17   TINYINT(3),';    
    $query .= 'g17   VARCHAR(13),';    
    $query .= 'r17   VARCHAR(24),';
    $query .= 'a18   TINYINT(2),';     
    $query .= 'e18   TINYINT(2),';     
    $query .= 'c18   TINYINT(3),';    
    $query .= 'g18   VARCHAR(13),';    
    $query .= 'r18   VARCHAR(24),';
    $query .= 'a19   TINYINT(2),';     
    $query .= 'e19   TINYINT(2),';     
    $query .= 'c19   TINYINT(3),';    
    $query .= 'g19   VARCHAR(13),';    
    $query .= 'r19   VARCHAR(24),';
    $query .= 'a20   TINYINT(2),';     
    $query .= 'e20   TINYINT(2),';     
    $query .= 'c20   TINYINT(3),';    
    $query .= 'g20   VARCHAR(13),';    
    $query .= 'r20   VARCHAR(24),';
    $query .= 'a21   TINYINT(2),';     
    $query .= 'e21   TINYINT(2),';     
    $query .= 'c21   TINYINT(3),';    
    $query .= 'g21   VARCHAR(13),';    
    $query .= 'r21   VARCHAR(24),';
    $query .= 'a22   TINYINT(2),';     
    $query .= 'e22   TINYINT(2),';     
    $query .= 'c22   TINYINT(3),';    
    $query .= 'g22   VARCHAR(13),';    
    $query .= 'r22   VARCHAR(24),';
    $query .= 'a23   TINYINT(2),';     
    $query .= 'e23   TINYINT(2),';     
    $query .= 'c23   TINYINT(3),';    
    $query .= 'g23   VARCHAR(13),';    
    $query .= 'r23   VARCHAR(24),';
    $query .= 'a24   TINYINT(2),';     
    $query .= 'e24   TINYINT(2),';     
    $query .= 'c24   TINYINT(3),';    
    $query .= 'g24   VARCHAR(13),';    
    $query .= 'r24   VARCHAR(24),';
    $query .= 'a25   TINYINT(2),';     
    $query .= 'e25   TINYINT(2),';     
    $query .= 'c25   TINYINT(3),';    
    $query .= 'g25   VARCHAR(13),';    
    $query .= 'r25   VARCHAR(24),';
    $query .= 'a26   TINYINT(2),';     
    $query .= 'e26   TINYINT(2),';     
    $query .= 'c26   TINYINT(3),';    
    $query .= 'g26   VARCHAR(13),';    
    $query .= 'r26   VARCHAR(24),';

    $query .= 'gpa2   DECIMAL(3,2),';  // 2nd semester gpa.

   	$query .= 'PRIMARY KEY (stu_id),';
    $query .= 'KEY regno (regno)';
    $query .= ') ';
    $query .= 'ENGINE=INNODB';
	$result = mysql_query($query, $connection);
	confirm_query($result);
?>