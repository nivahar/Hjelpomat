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
			//Database
                        connect_to_tf();

				//Spørring
				$sql = "select * from [tbl.user]";
				$brukere = array();
                                $auth_level = array();
				$resultat = mssql_query($sql);
				while($rad = mssql_fetch_array($resultat)){
					$bruker[$rad['user_name']] = $rad['id_user_level'];
                    $auth_level[] = $rad['id_user_level'];
				}
			?>
			<form id="login" method="POST" action="">
				<label>Brukernavn:</label>
					<select name="username" onchange="showHint(this.value)">
						<option value="">Velg brukernavn...</option>
						<?php
							asort($bruker);
							foreach($bruker as $brukernavn => $level){
								if($level == 1)
								{
									echo '<option value="'.$brukernavn.'">'.$brukernavn.'</option>';
								}
							}
							echo '<optgroup label="Administratorer">';
							foreach($bruker as $brukernavn => $level){
								if($level > 1)
								{
									echo '<option value="'.$brukernavn.'">'.$brukernavn.'</option>';
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
	include_once('includes/foot.inc.php');
?>