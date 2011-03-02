<?php
	session_start();
	require_once('includes/head.inc.php');
	connect_to_tf();
?>

<body class="colored"> 
 
	<div id="header-container"> 
		
		<div id="header-container-content"> 
			
			<div id="top-container"> 
				<a href="/"> 
					<div id="header-logo"></div> 
				</a> 
			</div>
		</div>
	</div>
	<div id="background-box"> 
		<div id="content-container" class=""> 
		
			<form id="login">
				<label>Brukernavn:</label>
					<select name="username">
						<option value="eirik">Eirik</option>
						<option value="fredrik">Fredrik</option>
					</select>
				<label>Passord:</label>
					<input type="password" name="password"  />
					<input type="submit" value="Logg inn" name="submit" class="submit" />
			</form>


<?php
	include_once('includes/foot.inc.php');
?>