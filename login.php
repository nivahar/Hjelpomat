<?php
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
				// Sjekker om "Logg inn"-knappen er trykket
				if(isset($_REQUEST['submit']))
				{
					//$_SESSION['user_level'] = $user_level;
					//$_SESSION['user_name'] = $user_name;
					//$_SESSION['user_id'] = $user_id;
					echo "Her skal du logges inn :)";
				}
				
				// Hvis du er logget inn...
				if($_SEESION['loggedin']):
			?>
			<p>Du er logget inn.</p>
			<?php
				// Hvis du ikke er logget inn...
				else:
				// Koble til database
				connect_to_tf();

				//Spørring som henter alle brukere
				$sql = "SELECT id_user, user_name, id_user_level FROM [tbl.user]";
				// SQL kjøres
				$resultat = mssql_query($sql);
				
				// Legger brukerinfo i array
				while($rad = mssql_fetch_array($resultat)){
					$bruker[$rad['user_name']] = $rad['id_user_level'];
					$id[$rad['user_name']] = $rad['id_user'];
				}
			?>
			<form id="login" method="GET" action="">
				<label>Brukernavn:</label>
					<select name="user_id" onchange="showHint(this.value)">
						<option value="">Velg brukernavn...</option>
						<?php
							ksort($bruker);
							foreach($bruker as $brukernavn => $level){
								if($level == 1)
								{
									echo '<option value="'.$id[$brukernavn].'">'.$brukernavn.'</option>';
								}
							}
							echo '<optgroup label="Administratorer">';
							foreach($bruker as $brukernavn => $level){
								if($level > 1)
								{
									echo '<option value="'.$id[$brukernavn].'">'.$brukernavn.'</option>';
								}
							}
							echo '</optgroup>';
						?>
					</select>
				<span id="passField">
					
				</span>
					<input type="submit" value="Logg inn" name="submit" class="submit" />
			</form>
			<span id="brukerInfo"></span>


<?php
	endif;
	include_once('includes/foot.inc.php');
?>