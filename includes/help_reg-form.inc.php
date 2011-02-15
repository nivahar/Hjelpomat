﻿			<h1>Registrer sak</h1> 
			<p>
				Felter merket <span class="mandatory">*</span> er påkrevd!
			</p>
			<div id="form">
				
				<form action="#" method="post" name="reg_help" id="reg_help" class="normal">
					
					<label for="help_title">
						Problemtittel <span class="mandatory">*</span>
					</label>
					<input type="text" name="help_title" id="help_title" placeholder="Overskrift" required />
					
					<label for="emp_no">
						Ansattnummer <span class="mandatory">*</span>
					</label>
					<input type="number" name="emp_no" id="emp_no" max="9999" min="1" step="1" required />
					
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
					<textarea name="help_desc" id="help_desc" required></textarea>
					<p class="buttons">
						<button type="submit">Registrer</button>
						<button type="reset" onclick="return confirm('Vil du tømme skjemaet?');">Tøm skjema</button>
					</p>
				</form>
				
			</div>