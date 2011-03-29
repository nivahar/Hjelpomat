<?php
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
	PDF_show_xy($minPdf, "Hurra for PDF!", 50, 750);
	PDF_show_xy($minPdf, "Dette fungerer.", 50, 730);
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
	
	// Serverer ut PDF-en til nettleseren.
	print $buffer;
	
	// Sletter PDF-en fra minnet.
	PDF_delete($minPdf);
?>