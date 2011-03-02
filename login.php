<?php
	session_start();
	require_once('includes/head.inc.php');
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
			<?php
				connect_to_tf();

				//Spørring
				$sql = "select * from [tbl.user]";
				$brukere = array();
				$resultat = mssql_query($sql);
				while($rad = mssql_fetch_array($resultat)){
					$brukere[] = $rad['user_name'];
				}
			?>
			<form id="login">
				<label>Brukernavn:</label>
					<select name="username" onchange="showHint(this.value)">
						<option value="">Velg brukernavn...</option>
						<?php
							foreach($brukere as $brukernavn){
								echo '<option value="'.$brukernavn.'">'.$brukernavn.'</option>';
							}
						?>
					</select>
				<label>Passord:</label>
					<input type="password" name="password"  />
					<input type="submit" value="Logg inn" name="submit" class="submit" />
			</form>
			<span id="brukerInfo"></span>


<?php
	include_once('includes/foot.inc.php');
?>