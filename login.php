<body class="colored"> 
 
	
 
	<div id="header-container"> 
		
		<div id="header-container-content"> 
			
			<div id="top-container"> 
				<a href="/"> 
					<div id="header-logo"></div> 
				</a> 
			</div> 
			
			
			<div id="menu-container"> 
				
			</div> 
			
		</div>
	
		<div id="submenu-container"> 
		
			<div id="submenu-container-content"> 
				
			</div>
		
		</div>
	 
		<div style="clear: both"></div> 
		
	</div> 
	<div id="background-box"> 
<div id="content-container" class=""> 

<?php
	// Sjekker om "Logg inn"-knappen er trykket
	if(isset($_REQUEST['submit']))
	{
		$bruker = user_info($_POST['user_id']);
		
		if($_SESSION['debug']) // Viser all info om brukeren som er valgt, også passord.
		{
			print_r($bruker);
		}
		
		if($bruker['id_user_level'] > 1)
		{
			if($bruker['password'] == $_POST['password'])
			{
				$_SESSION['user_level'] = $bruker['id_user_level'];
				$_SESSION['user_name'] = $bruker['user_name'];
				$_SESSION['user_id'] = $bruker['id_user'];
				$_SESSION['loggedin'] = TRUE;
				
				echo '<h3>Innlogging vellykket!</h3>';
				echo '<a href="index.php">Trykk her dersom nettlesern din ikke videresender deg</a>';
				
				if(!$_SESSION['debug'])
				{
					// Sender brukeren til forsiden når innloggingen er vellykket.
					echo "<script>location.href='index.php'</script>";
				}
			}
			else
			{
				$_SESSION['loggedin'] = FALSE;
				echo '<p class="error">Feil passord</p>';
			}
		}
		elseif($bruker['id_user_level'] == 1)
		{
			$_SESSION['user_level'] = $bruker['id_user_level'];
			$_SESSION['user_name'] = $bruker['user_name'];
			$_SESSION['user_id'] = $bruker['id_user'];
			$_SESSION['loggedin'] = TRUE;	
			
			echo '<h3>Innlogging vellykket!</h3>';
			echo '<a href="index.php">Trykk her dersom nettlesern din ikke videresender deg</a>';
			
			if(!$debug)
			{
				// Sender brukeren til forsiden når innloggingen er vellykket.
				echo "<script>location.href='index.php'</script>";
			}
		}
		else
		{
			echo '<p class="notice">Velg en bruker for å gå videre</p>';	
		}
		unset($bruker);
	}
	// Hvis du er logget inn...
	if($_SESSION['loggedin']):

	echo "<p>Du er logget inn som ".$_SESSION['user_name'].".</p>";
	
	echo '<a href="index.php">Trykk her dersom nettlesern din ikke videresender deg</a>';
			
	// Sender brukeren til forsiden når innloggingen er vellykket.
	echo "<script>location.href='index.php'</script>";

	// Hvis du ikke er logget inn...
	else:				

	//Spørring som henter alle brukere
	$sql = "SELECT id_user, user_name, id_user_level FROM [tbl.user]";
	// SQL kjøres
	$resultat = mssql_query($sql);
	
	// Legger brukerinfo i array
	while($rad = mssql_fetch_array($resultat))
	{
		$bruker[$rad['user_name']] = $rad['id_user_level'];
		$id[$rad['user_name']] = $rad['id_user'];
	}
?>
<form id="login" method="POST" action="">
	<label>Brukernavn:</label>
		<select name="user_id" onchange="showPassword(this.value)">
			<option value="">Velg brukernavn...</option>
			<?php
				ksort($bruker);
				foreach($bruker as $brukernavn => $level)
				{
					if($level == 1)
					{
						echo '<option value="'.$id[$brukernavn].'">'.$brukernavn.'</option>';
					}
				}
				echo '<optgroup label="Administratorer">';
				foreach($bruker as $brukernavn => $level)
				{
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
?>