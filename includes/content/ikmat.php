<?php 
        if(isset($_POST['delete'])):

        $test = delete_case($_POST['case_id']);
              if($test != true){
                  echo "Feil under sletting av sak";
              }
        endif;

        //Hvis sak er registrert
        if(isset($_POST['reg_ikmat_submit'])):
			$title = $_POST['ikmat_title'];
			$employee_number = $_POST['emp_no'];
			$ikmat_location = $_POST['ikmat_location'];
                        $ikmat_unit = $_POST['ikmat_unit'];
                        $ikmat_problem_type = $_POST['ikmat_problem_type'];
                        $is_help_case = $_POST['is_help_case'];
			$description = $_POST['ikmat_desc'];
                        $user_id = $_SESSION['user_id'];
                        // Save POST data to database
			if(save_food_case($title,$employee_number,$ikmat_location,$ikmat_unit,$ikmat_problem_type,$description,$is_help_case,$user_id)){
				echo '<p class="success">Saken ble registrert.</p>
					<h1>'.$_POST['ikmat_title'].'</h1>
					<p>Ansattnr. '.$_POST['emp_no'].', kategori '.$_POST['ikmat_location'].', enhet '.$_POST['ikmat_unit'].'</p>
                                        <h2>Beskrivelse</h2>
					<p>'.$_POST['ikmat_desc'].'</p>';
			}else{
				echo '<p class="error">Saken ble ikke registrert.</p>';
			}
			


        
          
		// Hvis man har valgt å vise sine saker:
		elseif($_GET['sub'] == "show"):
?>
		<form action="index.php?page=help&sub=show" method="get">
			<table id="ikmat_list">
				<?php #user_ikmat_list($_SESSION['user_id']);
                                user_ikmat_list($_SESSION['user_id']);?>
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
		<table id="ikmat_list">
			<?php ikmat_list(); ?>
		</table>

<?php
	// Default: å registrere sak.
		else:
	?>
<script>
  function toggle(checkboxID, toggleID) {
  var checkbox = document.getElementById(checkboxID);
  var toggle = document.getElementById(toggleID);
  updateToggle = checkbox.checked ? toggle.disabled=true : toggle.disabled=false;
}</script>
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
						Lokasjon<span class="mandatory">*</span>
					</label>
					<select name="ikmat_location" id="ikmat_location">
						<option value="select_ikmat" selected="selected">Velg hendelsessted...</option>
						<?php echo get_ikmat_place_drop_down(); ?>
					</select>

                                         <label for="ikmat_unit">
                                                Hvilken enhet er det feil med <span class="mandatory">*</span>
                                        </label>
                                        <select name="ikmat_unit" id="ikmat_unit">
                                            <option value="select_ikmat_unit" selected="selected_unit">Velg enhet...</option>
                                            <?php echo get_ikmat_unit_drop_down();?>
                                        </select>
                                         <label for="ikmat_problem_type">
                                                Hva slags type ikmat avvik er dette <span class="mandatory">*</span>
                                        </label>
                                        <select name="ikmat_problem_type" id="ikmat_problem_type">
                                            <option value="select_ikmat_unit" selected="selected_unit">Velg type problem...</option>
                                            <?php echo get_ikmat_type_drop_down();?>
                                           
                                        </select>


										
					<label for="ikmat_desc">
						Problembeskrivelse <span class="mandatory">*</span>
					</label>
					<textarea name="ikmat_desc" id="ikmat_desc" required></textarea>

                                        <label for="is_help_case">
                                            <input type="checkbox" name="is_help_case" value="1">Huk av om denne saken trenger teknisk oppfølging
                                        </label>
                                        <input type="hidden" id="user_id" name="user_id" value="<?php $_SESSION['user_id']?>" />

                                       


					<p class="buttons">
						<button type="submit" name="reg_ikmat_submit" value="Register" />Registrer
						<button type="reset" onclick="return confirm('Vil du tømme skjemaet?');">Tøm skjema</button>
					</p>
				</form>
				
			</div>
                        <?php  endif; ?>
