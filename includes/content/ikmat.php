			<h1>Registrer IK-mat hendelse</h1> 
			<p>
				Felter merket <span class="mandatory">*</span> er påkrevd!
			</p>
			<div id="form">
				
				<form action="" method="post" name="reg_help" id="reg_ikmat" class="normal">
					
					<label for="help_title">
						Problemtittel <span class="mandatory">*</span>
					</label>
					<input type="text" name="ikmat_title" id="ikmat_title" placeholder="Overskrift" required />
					
					<label for="reg_emp_no">
						Ditt ansattnummer <span class="mandatory">*</span>
					</label>
					<input type="number" name="emp_no" id="emp_no" max="9999" min="1" step="1" required />
					
					<label for="ikmat_cat">
						Problemkategori <span class="mandatory">*</span>
					</label>
					<select name="ikmat_cat" id="ikmat_cat">
						<option value="select_ikmat" selected="selected">Velg hentelsessted...</option>
						<optgroup label="Restaurant">
							<option value="1">Vertshuset</option>
							<option value="2">Rockburgern</option>
						</optgroup>
						<optgroup label="Butikk">
							<option value="3">Toppen</option>
						</optgroup>
						<optgroup label="Sukkerland">
							<option value="4">Slushfabrikken</option>
							<option value="5">Præriekiosken</option>
							<option value="6">Poppen</option>
						</optgroup>
					</select>
										
					<label for="ikmat_desc">
						Problembeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="ikmat_desc" id="ikmat_desc" required></textarea>
					<p class="buttons">
						<button type="submit">Registrer</button>
						<button type="reset" onclick="return confirm('Vil du tømme skjemaet?');">Tøm skjema</button>
					</p>
				</form>
				
			</div>