<?php
	$tiden = date('H.i:s');
	
	$minPdf = PDF_new();
	PDF_open_file($minPdf, "");
	PDF_begin_page($minPdf, 595, 842);
	$minFont = PDF_findfont($minPdf, "Times-Roman", "host", 0);
	PDF_setfont($minPdf, $minFont, 10);
	
	PDF_show_xy($minPdf, "Hurra for PDF!", 50, 750);
	PDF_show_xy($minPdf, "Dette fungerer.", 50, 730);
	PDF_show_xy($minPdf, "Klokka er $tiden", 50, 710);

	
	PDF_end_page($minPdf);
	PDF_close($minPdf);
	
	$buffer = PDF_get_buffer($minPdf);
	$lengde = strlen($buffer);
	header("Content-type: application/pdf");
	header("Content-Length: $lengde");
	header("Content-Disposition: inline; filename=sak.pdf");
	print $buffer;
	
	PDF_delete($minPdf);
?>