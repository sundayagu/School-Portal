<?php
        if ($_FILES['csv']['size'] > 0) { 
            $file = $_FILES['csv']['tmp_name'];

            //get the csv file 
            $file = $_FILES['csv']['tmp_name']; 
            $handle = fopen($file,"r"); 
             
            //loop through the csv file and insert into database 
            $data = array();
            do { 
                if ($handle[0]) { 
                    mysql_query("INSERT INTO users_student (id, stu_name, stu_sex, username, sflag, flogin, password1, hashed_password, adm_sess, dept_code, pnum, email, answer1, answer2) VALUES 
                        ( 
                            '".addslashes($data[0])."', 
                            '".addslashes($data[1])."', 
                            '".addslashes($data[2])."', 
                            '".addslashes($data[3])."', 
                            '".addslashes($data[4])."', 
                            '".addslashes($data[5])."', 
                            '".addslashes($data[6])."', 
                            '".addslashes($data[7])."', 
                            '".addslashes($data[8])."', 
                            '".addslashes($data[9])."', 
                            '".addslashes($data[10])."', 
                            '".addslashes($data[11])."', 
                            '".addslashes($data[12])."', 
                            '".addslashes($data[13])."', 
                            '".addslashes($data[14])."' 
                        ) 
                    "); 
                } 
            } while ($data = fgetcsv($handle,1000,",","'")); 
            // 

            //redirect 
           // header('Location: import1.php?success=1'); die; 
           // echo "<a href=\"#\">OK</a>";

        } 


    ?>

    <?php if (!empty($_handle)) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 