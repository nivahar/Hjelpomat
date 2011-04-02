<?php 
	// Hvis en sak er registrert:
	if(isset($_POST['reg_help_submit'])):
			$title = $_POST['help_title'];
			$employee_number = $_POST['emp_no'];
			$category_id = $_POST['help_cat'];
			$description = $_POST['help_desc'];

			// Save POST data to database
			if(save_help_case($title,$employee_number,$category_id,$description)){
				echo '<p class="success">Saken ble registrert.</p>
					<h1>'.$_POST['help_title'].'</h1>
					<p>Ansattnr. '.$_POST['emp_no'].', kategori '.$_POST['help_cat'].'</p>
					<h2>Beskrivelse</h2>
					<p>'.$_POST['help_desc'].'</p>';
			}else{
				echo '<p class="error">Saken ble ikke registrert. Pokker.</p>';
			}
		
		
		
		// Hvis man har valgt å vise sine saker:
		elseif($_GET['sub'] == "show"):
?>
		<form action="index.php?page=help&sub=show" method="get">
			<table id="helpdesk_list">
				<?php user_helpdesk_list($_SESSION['user_id']); ?>
			</table>
			<select name="action">
				<option id="print">Skriv ut</option>
				<option id="delete">Slett</option>
			</select>
			<input type="submit" name="helplist_do" value="Utfør" />
		 </form>
	
	
	<?php
		// Hvis man har valgt administrasjon:
		elseif($_GET['sub'] == "adm"):
	?>
		<table id="helpdesk_list">
			<?php helpdesk_list(); ?>
		</table>


	<?php
		// Hvis man skal endre en enkeltsak:
		elseif($_GET['sub'] == "single"):
		
		$saksID = $_GET['id'];
		
		// Hent sakens detaljer.
		$sql = "SELECT [id_main_case]
		, CAST([created_date] as CHAR(10)) AS [created_date]
		,[reg_user]
		,[reg_employee]
		,[id_help_case]
		,[help_case_title]
		,[case_problem_type]
		,[help_problem_type_description]
		,[help_case_description]
		,[help_case_solution]
		,[help_case_status]
		,[help_case_status_description]
		,[is_help_case]
		FROM [v.help_case]
		WHERE [id_main_case] = '$saksID' ";
		
		$resultat = mssql_query($sql);
		
		while($row = mssql_fetch_array($resultat))
		{
   			$id_main_case = $row['id_main_case'];
   			$created_date = $row['created_date'];
   			$reg_employee = $row['reg_employee'];
   			$help_case_title = $row['help_case_title'];
   			$help_problem_type_description = $row['help_problem_type_description'];
   			$help_case_description = $row['help_case_description'];
   			$help_case_status_description = $row['help_case_status_description'];
 	}

		
		echo '<h1>Endre sak</h1> 
			<p>
				Felter merket <span class="mandatory">*</span> er påkrevd!
			</p>
			<div id="form">
				
				<form action="" method="post" name="update_help" id="update_help" class="normal">
					
					<label for="help_title">
						Problemtittel <span class="mandatory">*</span>
					</label>
					<input type="text" name="help_title" id="help_title" placeholder="Overskrift" value="'.$help_case_title.'" required class="validate[required]" />
					
					<label for="emp_no">
						Ditt ansattnummer <span class="mandatory">*</span>
					</label>
					<input type="number" name="emp_no" id="emp_no" max="9999" min="1" step="1" value="'.$reg_employee.'" required class="validate[required,custom[empNumber],maxSize[4]] text-input" />
					
					<label for="help_cat">
						Problemkategori <span class="mandatory">*</span>
					</label>
					<select name="help_cat" id="help_cat" class="validate[required]">
						<option value="" selected="selected">Velg en kategori...</option>
						'.get_helpdesk_status_drop_down().'
					</select>
					
					<label for="help_desc">
						Problembeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="help_desc" id="help_desc" required class="validate[required]">'.$help_case_description.'</textarea>
					<p class="buttons">
						<input type="submit" name="reg_help_submit" value="Oppdatér" />
					</p>
				</form>';
				
		
		// Default: å registrere sak. 
		else: 
	?>
			<h1>Registrer sak</h1> 
			<p>
				Felter merket <span class="mandatory">*</span> er påkrevd!
			</p>
			<div id="form">
				
				<form action="" method="post" name="reg_help" id="reg_help" class="normal">
					
					<label for="help_title">
						Problemtittel <span class="mandatory">*</span>
					</label>
					<input type="text" name="help_title" id="help_title" placeholder="Overskrift" required class="validate[required]" />
					
					<label for="emp_no">
						Ditt ansattnummer <span class="mandatory">*</span>
					</label>
					<input type="number" name="emp_no" id="emp_no" max="9999" min="1" step="1" required class="validate[required,custom[empNumber],maxSize[4]] text-input" />
					
					<label for="help_cat">
						Problemkategori <span class="mandatory">*</span>
					</label>
					<select name="help_cat" id="help_cat" class="validate[required]">
						<?php echo get_helpdesk_type_drop_down() ?>
					</select>
					
					<label for="help_desc">
						Problembeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="help_desc" id="help_desc" required class="validate[required]"></textarea>
					<p class="buttons">
						<input type="submit" name="reg_help_submit" value="Registrer" />
						<button type="reset" onclick="return confirm('Vil du tømme skjemaet?');">Tøm skjema</button>
					</p>
				</form>
				
			</div>
<?php  endif; ?>