<?php
	if (function_exists('mssql_connect')){ 
		echo "Ok, funksjonen er der<br>------------------<br>"; 
	} else { 
		echo "Funksjonen er ikke her<br>------------------<br>"; 
	} 
	
	if(extension_loaded("mssql")) { 
		echo "MSSQL er lastet<br>"; 
	} 
	else { 
		echo "MSSQL ikke lastet<br>"; 
	} 
	
	if(extension_loaded("msql")) { 
		echo "MSQL er lastet<br>"; 
	} 
	else { 
		echo "MSQL ikke lastet<br>"; 
	} 
	echo '<br><br>'; 
	
	$ext = get_loaded_extensions(); 
	if(in_array('mssql', $ext)) 
		echo 'mssql er installert<br><br>'; 
	else 
		echo 'mssql er IKKE installert!<br><br>'; 
?>