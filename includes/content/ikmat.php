<?php 
        //Hvis sak er registrert
        if(isset($_POST['reg_ikmat_submit'])):
			$title = $_POST['ikmat_title'];
			$employee_number = $_POST['emp_no'];
			$category_id = $_POST['ikmat_location'];
                        $unit = $_POST['ikmat_unit'];
			$description = $_POST['ikmat_desc'];

                        // Save POST data to database
			if(save_food_case($title,$employee_number,$category_id,$unit,$description)){
				echo '<p class="success">Saken ble registrert.</p>
					<h1>'.$_POST['ikmat_title'].'</h1>
					<p>Ansattnr. '.$_POST['emp_no'].', kategori '.$_POST['ikmat_location'].', enhet '.$_POST['ikmat_unit'].'</p>
                                        <h2>Beskrivelse</h2>
					<p>'.$_POST['ikmat_desc'].'</p>';
			}else{
				echo '<p class="error">Saken ble ikke registrert.</p>';
			}
			
		else: ?>
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
					
					<label for="ikmat_place">
						Problemkategori <span class="mandatory">*</span>
					</label>
					<select name="ikmat_place" id="ikmat_place">
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

                                         <label for="ikmat_unit">
                                                Hvilken enhet er det feil med <span class="mandatory">*</span>
                                        </label>
                                        <select name="ikmat_unit" id="ikmat_unit">
                                            <option value="select_ikmat_unit" selected="selected_unit">Velg enhet...</option>
                                            <optgroup label="Isbitmaskin">
                                                    <option value="1">Kompressor</option>
                                                    <option value="2">Vanntilkobling</option>
                                            </optgroup>
                                            <optgroup label="Kjøleskap">
                                                    <option value="3">Nr1</option>
                                                    <option value="4">Nr2</option>
                                                    <option value="5">Nr3</option>
                                            </optgroup>
                                        </select>
                                         <label for="ikmat_problem_type">
                                                Hvilken enhet er det feil med <span class="mandatory">*</span>
                                        </label>
                                        <select name="ikmat_problem_type" id="ikmat_problem_type">
                                            <option value="select_ikmat_unit" selected="selected_unit">Velg enhet...</option>
                                            
                                           
                                        </select>


										
					<label for="ikmat_desc">
						Problembeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="ikmat_desc" id="ikmat_desc" required></textarea>

                                        <label for="is_helpcase">
                                            <input type="checkbox" name="is_helpcase">Huk av om denne saken trenger teknisk oppfølging
                                        </label>


					<p class="buttons">
						<button type="submit">Registrer</button>
						<button type="reset" onclick="return confirm('Vil du tømme skjemaet?');">Tøm skjema</button>
					</p>
				</form>
				
			</div>
                        <?php  endif; ?>
