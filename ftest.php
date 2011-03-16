<?php
	require_once('includes/functions.inc.php');
	
	echo "<strong>Innhold i session:</strong><br/>";
	echo $_SESSION['user_name'];
	
	/*
	echo "<strong>Sjekk av avdelinger :</strong><br/>";
	foreach(get_categories() as $key => $value){
		echo "ID: $key<br/>";
		echo "Beskrivelse: ".$value['description']."<br/>";
		echo "Forelder: ".$value['parent'],"<br/>";
		echo "<br/>";
	}
	
	//connect_to_tf();
	$sql =  "SELECT * FROM [tbl.user]";
	$resultat = mssql_query($sql);
	$bruker = array();
	while($rad = mssql_fetch_array($resultat))
	{
		$bruker[] = $rad['user_name'];
	}
	echo "Listing av brukere: ";
	print_r($bruker);
	
	//echo "<br/><strong>Sjekk om bruker eksisterer:<strong/> ";
	//$bruker = user_exists('Eirik');
	//echo $bruker."nei";
	
	connect_to_tf("close");
	*/
	
	echo "<br/><br/><strong>Test av brukerinfohenter:</strong><br/>";
	print_r(user_info(1));
?>