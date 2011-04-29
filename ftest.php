<?php
if(!isset($_REQUEST['sendpdf'])):
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
	
	echo "<br/><br/><strong>Saksinfo</strong>: ";
	print_r(get_single_helpdesk_case(20));

?>
<br/><br/>
<form action="" method="get">
	<label name="saksnummer" for="saksnummer">Saksnummer</label><br/>
	<input name="saksnummer" placeholder="Saksnummer" /><br/>
	<input type="submit" name="sendpdf" value="PDF meg!" />
</form>
<?php
	include_once('includes/foot.inc.php');

elseif(isset($_REQUEST['sendpdf'])):
	require_once('includes/functions.inc.php');
	
	/*// Setter FPDF-konstant og inkluderer FPDF-fila.
	define('FPDF_FONTPATH','/var/www/includes/font/');
	require('includes/fpdf.php');
	
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(40,10,'Hello World!');
	$pdf->Output();*/
	print_case_pdf($_GET['saksnummer']);
	
	
	/*
	 * Kobling til database
	 */
	//Login data finnes i fil:
	require 'includes/db_secure.php';
	// Legger logindata i et array.
	$dbLogin = db_login();
	$dbConnection = mssql_connect($dbLogin['address'], $dbLogin['user'], $dbLogin['pass']);
	
	// Setter database
	if(!mssql_select_db('hjelpomat', $dbConnection))
	{
		die('Kunne ikke koble til database');
	}

	require_once('includes/functions.inc.php');
	
	//print make_case_pdf($_REQUEST['saksnummer']);

	mssql_close($dbConnection);
endif;
?>