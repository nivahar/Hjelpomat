<?php

/*
 * Hovedmeny
 */
	function page($page, $subpage){
	// Shows the page content according to the selected page

		$content_path = 'includes/content/';

		if(!isset($page)){
			$show_page = 'default.php';
		}
		elseif($page == 'help'){
			$show_page = 'help.php';
		}
		elseif($page == 'ikmat'){
			$show_page = 'ikmat.php';
		}
		else{
			$show_page = 'default.php';
		}
		
		return $content_path.$show_page;
	}

/*
 * Under meny / Del meny
 */
	function submenu($page){
	// Shows the submenu according to the selected page
		
		switch ($page){
			case 'help':
				return '<li> 
						<a href="?page=help&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=adm">Administrer saker</a> 
					</li>';
				break;
			case 'ikmat':
				return '<li> 
						<a href="?page=ikmat&amp;sub=register">Registrer hendelse</a> 
					</li> 
					<li> 
						<a href="?page=ikmat&amp;sub=show">Vis hendelser</a> 
					</li> 
					<li> 
						<a href="?page=ikmat&amp;sub=adm">Administrer saker</a> 
					</li>';
				break;
			case 'drift':
				return '<li> 
						<a href="?page=drift&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=drift&amp;sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=drift&amp;sub=adm">Administrer saker</a> 
					</li>';
				break;
			default:
				return '<li> 
						<a href="?page=help&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=adm">Administrer saker</a> 
					</li>';
		}
	}


/*
 * Database kobling info
 */
	function connect_to_tf(){
		//Login data finnes i fil:
		require 'db_secure.php';
		//Kobler til server
		$login = db_login();
		if(!($connection = mssql_connect($login['address'], $login['user'], $login['pass']))){
			return FALSE;
		}	
		else{
			return TRUE;
		}
		
		// Setter database
		mssql_select_db('hjelpomat',$login);
	}



/*
 * Funksjon for å lagre data fra skjema helpdesk
 *
 * 1. Lagre detaljer om en helpdesk sak som er unikt for helpdesk
 * 2. Hente ID til sak registrert i 1 for å kunne lagre den i felles tabellen
 * 3. lagre data om sak i hovedtabellen.
 * 
 */
	function save_help_case($title,$employee_number,$category_id,$description){

		//Database kobling
		if(!connect_to_tf()){
			return FALSE;
			exit;
		}

	      // DEL 1 tbl.help_case
	      //Sette inn data unik fo helpdesk, input fra funksjon
		  $sql = "INSERT INTO [tbl.help_case](help_case_title,case_problem_type,help_case_description) 
		  		VALUES('$title','$category_id','$description')";
		//Utføre sql kommando
		if(!mssql_query($sql)){
			return FALSE;
			exit;
		}


     	//DEL 2
     	// Trenger ID til å putte i hovedtabell
		$sql = 'SELECT SCOPE_IDENTITY() AS ID';
		
		if(!$help_id = mssql_query($sql)){
			return FALSE;
			exit;
		}
		
		if(!$id = mssql_fetch_array($help_id)){
			return FALSE;
			exit;
		}
		$help_case_id = $id["ID"];

    	
		//TEMP
		$reg_user = '1'; // må settes til aktiv bruker - session ?

    	//DEL 3
    	// tbl.main_case
		$dato = 'GETDATE()'; // lagrer timestamp server.
                $is_help_case = '1';
    	//Sette inn data unik fo helpdesk, input fra funksjon
		$sql = "INSERT INTO [tbl.main_case](created_date,reg_user,reg_employee,id_help_case,is_help_case)
				VALUES ($dato,'$reg_user','$employee_number','$help_case_id','$is_help_case')";
    	//Lagre data i tbl.man_case
		if(!mssql_query($sql)){
			return FALSE;
			exit;
		}
		return TRUE;
	}




/*
 * Funksjon save food case
 *
 * 1. Lagre food_case data
 * 2. finne id av nr 1
 * 3. Lagre food_case data i main_case
 *
 */
 function save_food_case($title,$employee_number,$id_food_problem,$description){

      	//Database kobling
		if(!connect_to_tf()){
			return FALSE;
			exit;
		}

      	// DEL 1 tbl.help_case
      	//Sette inn data unik fo helpdesk, input fra funksjon
  		$sql = "INSERT INTO [tbl.food_case](food_case_title,id_food_problem_type, food_case_description) 
  				VALUES('$title','$id_food_problem','$description')";
      	//Utføre sql kommando
  		if(!mssql_query($sql)){
  			return FALSE;
			exit;
  		}


     	//DEL 2
     	// Trenger ID til å putte i hovedtabell
		$sql = 'SELECT SCOPE_IDENTITY() AS ID';
		
		if(!$help_id = mssql_query($sql)){
			return FALSE;
			exit;
		}
		
		if(!$id = mssql_fetch_array($help_id)){
			return FALSE;
			exit;
		}
		$food_case_id = $id["ID"];


    	//Midlertidig
		$reg_user = '1'; // må settes til aktiv bruker - session ?

    	//DEL 3
    	// tbl.main_case
		$dato = 'GETDATE()'; // lagrer timestamp server.
    	//Sette inn data unik fo helpdesk, input fra funksjon
		$sql = "INSERT INTO [tbl.main_case](created_date,reg_user,reg_employee,id_help_case)
				VALUES ($dato,'$reg_user','$employee_number','$food_case_id')";
    	// Lagre data i tbl.man_case
		if(!mssql_query($sql)){
			return FALSE;
			exit;
		}
		
		// Frigjør ressursen (ikke testet enda)
		//mssql_free_result($id);
		
		// Lukker databasetilkobling (trenger en link)
		//mssql_close();
		return TRUE;
	}

	
	/*
	 * Henter alle kategorier
	 */
	 function get_categories(){
	 	connect_to_tf();
	 	$sql = "SELECT * FROM [tbl.help_problem_type]";
	 	$resultat = mssql_query($sql);
	 	$kategorier = array();
	 	while($rad = mssql_fetch_array($resultat)){
	 		$id = $rad['id_help_problem_type'];
	 		$kategorier[$id]['description'] = $rad['help_problem_type_description'];
	 		$kategorier[$id]['parent'] = $rad['parent_help_problem_id'];
	 	}
	 	return $kategorier;
	 }

?>