<?php
	require_once('includes/head.inc.php');
	include_once('includes/body.inc.php');
	
	echo "<strong>Innhold i session:</strong><br/>";
	echo $_SESSION['user_name'];
	
	
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
	
	echo "<br/><strong>Sjekk om bruker eksisterer:</strong><br/>";
	$bruker = user_exists('fredrik');
	if($bruker)
	{
		echo "Ja! Info:<br/>";
		print_r(user_info($bruker['id_user']));	
	}
	else
	{
		echo "Nei.";	
	}

	include_once('includes/foot.inc.php'); 
?>