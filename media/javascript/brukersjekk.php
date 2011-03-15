<?php
//Login data finnes i fil:
include ('../../includes/functions.inc.php');
include('../../includes/db_secure.php');
$login = db_login();

//Kobler til server
mssql_connect($login['address'], $login['user'], $login['pass']);


// Setter database
mssql_select_db('hjelpomat',$login);


//Spørring
$sql = "select * from [tbl.user]";

// Initialiserer array
$a = array();

// Fyller arrayet
$resultat = mssql_query($sql);

while($rad = mssql_fetch_array($resultat)){
	$a[] = $rad['user_name'];
	$level[$rad['user_name']] = $rad['id_user_level'];
}

//get the q parameter from URL
$q=$_GET["q"];

// Sjekker brukernivået til brukeren
if(in_array($q, $a)){
	if($level[$q] > 1)
	{
		echo '<label>Passord:</label><input type="password" name="password"  />';
	}
	//echo '<p class="success">Dittbrukernivå er '.$level[$q].'</p>';
}else{
	echo '<p class="error">Noe gikk galt.</p>';
}

?>