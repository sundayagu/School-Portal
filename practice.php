
<?php
	$getstring = "STF/16/001";
	
	// return a portion of a string starting from the characters found in character_list
	$strreturn1 = strpbrk($getstring, "STF");  
	echo $strreturn1 . "<br/>";

	// returns a portion of a string
	$strreturn2 = substr($getstring, 0, 3);
	echo $strreturn2;

?>