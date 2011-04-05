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
?>
<br/><br/>
<form action="" method="get">
	<label for="linje1">1. linje</label><br/>
	<input name="linje1" placeholder="Første linje" /><br/>
	<label for="linje2">2. linje</label><br/>
	<input name="linje2" placeholder="Andre linje" /><br/>
	<input type="submit" name="sendpdf" value="PDF meg!" />
</form>
<?php
	include_once('includes/foot.inc.php');

elseif(isset($_REQUEST['sendpdf'])):
	// Tester en variabel i PDF-en.
	$tiden = date('H.i:s');
	
	
	// Oppretter en peker til PDF-en.
	$minPdf = PDF_new();
	
	// Åpner PDFen for redigering.
	PDF_open_file($minPdf, "");
	
	// Starter på en side med A4(?)-størrelse.
	PDF_begin_page($minPdf, 595, 842);
	
	// Setter en font.
	$minFont = PDF_findfont($minPdf, "Times-Roman", "host", 0);
	PDF_setfont($minPdf, $minFont, 10);
	
	// Skriver til siden vi har startet, koordinater fra nederste venstre hjørne.
	PDF_show_xy($minPdf, $_REQUEST['linje1'], 50, 750);
	PDF_show_xy($minPdf, $_REQUEST['linje2'], 50, 730);
	PDF_show_xy($minPdf, "Klokka er $tiden", 50, 710);

	// Avslutter siden.
	PDF_end_page($minPdf);
	
	// Avslitter PDF-en.
	PDF_close($minPdf);
	
	// Henter innholdet i bufferen (henter PDF-en, altså).
	$buffer = PDF_get_buffer($minPdf);
	
	// Finner størrelsen på fila.
	$lengde = strlen($buffer);
	
	// Setter filheadere så nettleseren skjønner at den får 
	// servert en PDF-fil.
	header("Content-type: application/pdf");
	header("Content-Length: $lengde");
	header("Content-Disposition: inline; filename=sak.pdf");
	
	// Sletter PDF-en fra minnet.
	PDF_delete($minPdf);
	
	// Serverer ut PDF-en til nettleseren.
	print $buffer;

endif;
?>