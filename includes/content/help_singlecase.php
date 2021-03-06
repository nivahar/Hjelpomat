<?php if(isset($_POST['reg_help_submit'])):

			$title = $_POST['help_title'];
			$employee_number = $_POST['emp_no'];
			$category_id = $_POST['help_cat'];
			$description = $_POST['help_desc'];

			if(update_help_case($title,$employee_number,$category_id,$description)){
				echo '<p class="success">Saken ble registrert.</p>
					<h1>'.$_POST['help_title'].'</h1>
					<p>Ansattnr. '.$_POST['emp_no'].', kategori '.$_POST['help_cat'].'</p>
					<h2>Beskrivelse</h2>
					<p>'.$_POST['help_desc'].'</p>';
			}else{
				echo '<p class="error">Saken ble ikke registrert. Pokker.</p>';
			}

		else: ?>
			<h1>Sak - her må alle felter fylles ut av systemet når en kommer fra tabelloversikten</h1>
			
			<div id="form">

				<form action="" method="post" name="reg_help" id="reg_help" class="normal">

					<label for="help_title">
						Problemtittel <span class="mandatory">*</span>
					</label>
					<input type="text" name="help_title" id="help_title" placeholder="Overskrift" required class="validate[required]" />
                                        Status:<select name="help_case_status" id="help_case_status" >
						<option value="" selected="selected">Velg Status</option>
							<option value="1">Lest</option>
							<option value="2">Under utarbeidelse</option>
							<option value="3">Venter på deler</option>
							<option value="4">Ferdig</option>
						</select>
					<label for="emp_no">
						Ansattnummer <span class="mandatory">*</span>
					</label>
					<input type="number" name="emp_no" id="emp_no" max="9999" min="1" step="1" required class="validate[required,custom[empNumber],maxSize[4]] text-input" />

					<label for="help_cat">
						Problemkategori <span class="mandatory">*</span>
					</label>
					<select name="help_cat" id="help_cat" class="validate[required]">
						<option value="" selected="selected">Velg en kategori...</option>
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
					<textarea name="help_desc" id="help_desc" required class="validate[required]"></textarea>

                                        <label for="help_solution">
						Løsningsbeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="help_soultion" id="help_desc" required class="validate[required]"></textarea>
					<p class="buttons">
						<input type="submit" name="reg_help_submit" value="Oppdater sak" />
						
					</p>
				</form>

			</div>
<?php  endif; ?>