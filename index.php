<?php
	session_start();
	require_once('includes/head.inc.php');
?>

<body class="colored"> 
 
	
 
	<div id="header-container"> 
		
		<div id="header-container-content"> 
			
			<div id="top-container"> 
				<a href="/helpdesk/"> 
					<div id="header-logo"></div> 
				</a> 
			</div> 
			
			<div id="menu-container" class="helpdesk-meu-active"> 
				<ul> 
					<li id="helpdesk-menu"> 
						<a href="#"> 
							Helpdesk
						</a> 
					</li> 
					<li id="ikmat"> 
						<a href="#"> 
							IK-mat
						</a> 
					</li> 
					<li id="driftstans"> 
						<a href="#"> 
							Driftstans
						</a> 
					</li>
				</ul> 
			</div> 
			
		</div>
	
		<div id="submenu-container"> 
		
			<div id="submenu-container-content"> 
				<ul class="filter-menu"> 
					<li> 
						<a href="/helpdesk/">Registrer sak</a> 
					</li> 
					<li> 
						<a href="/helpdesk/2/">Vis saker</a> 
					</li> 
					<li> 
						<a href="/helpdesk/1/">Administrer saker</a> 
					</li>  
				</ul> 
			</div>
		
		</div>
	 
		<div style="clear: both"></div> 
		
	</div> 
	<div id="background-box"> 
		
		<div id="content-container" class=""> 
	
			<h1>Registrer sak</h1> 
			<p>
				Felter merket <span class="mandatory">*</span> er påkrevd!
			</p>
			<div id="form">
				
				<form action="#" method="post" name="reg_help" id="reg_help" class="normal">
					
					<label for="help_title">
						Problemtittel <span class="mandatory">*</span>
					</label>
					<input type="text" name="help_title" id="help_title" />
					
					<label for="emp_no">
						Ansattnummer <span class="mandatory">*</span>
					</label>
					<input type="number" name="emp_no" id="emp_no" max="9999" min="1" step="1" />
					
					<label for="help_cat">
						Problemkategori <span class="mandatory">*</span>
					</label>
					<select name="help_cat" id="help_cat">
						<option value="select_help" selected="selected">Velg en kategori...</option>
						<optgroup label="Attraksjoner">
							<option value="1">Kontrollpanel</option>
						</optgroup>
						<optgroup label="Kasser">
							<option value="2">Skjerm</option>
							<option value="3">Tastatur</option>
							<option value="4">Bongskriver</option>
							<option value="5">Kasseskuff</option>
						</optgroup>
					</select>
					
					<label for="help_desc">
						Problembeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="help_desc" id="help_desc"></textarea>
					<p class="buttons">
						<button type="submit">Registrer</button>
						<button type="reset" onclick="return confirm('Vil du tømme skjemaet?');">Tøm skjema</button>
					</p>
				</form>
				
			</div>
			
			<!-- <div id="helpdesk"> 
				
				<div class="helpdesk"> 
					
					<h2>Velkommen til Parkiaden 2010</h2> 
					<p class="helpdesk-information"> 
						Lagt ut 18. juni 2010 av Lene Lothe (i <a href="/helpdesk/2/">Arrangementer</a>)
					</p> 
				
				<div class="text"> 
					Vedlagt finner dere informasjon om årets Parkiade.
				</div> 
				
				<a href="/media/uploads/Parkiaden-2010_.ppt">Åpne vedlagt fil</a> 
				
			</div> 
	</div> -->
	
	<div style="clear: both"></div> 
	
</div> 
<div style="clear: both"></div></div> 
<div style="clear: both"></div> 
<?php
	include_once('includes/foot.inc.php');
?>