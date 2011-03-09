<?php
	require_once('includes/functions.inc.php');
	foreach(get_categories() as $key => $value){
		echo "ID er $key<br/>";
		//print_r $value;
	}