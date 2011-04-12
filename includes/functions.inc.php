<?php

/*
 * Hovedmeny
 */
	/**
	 * page function.
	 * 
	 * @access public
	 * @param mixed $page
	 * @param mixed $subpage
	 * @return void
	 */
	function page($page, $subpage){
	// Shows the page content according to the selected page

		$content_path = 'includes/content/';

		if(!isset($page))
		{
			$show_page = 'default.php';
		}
		elseif($page == 'help')
		{
			$show_page = 'help.php';
		}
		elseif($page == 'ikmat')
		{
			$show_page = 'ikmat.php';
		}
		elseif($page == 'admin')
		{
			$show_page = 'admin.php';
		}
		else
		{
			$show_page = 'default.php';
		}
		
		return $content_path.$show_page;
	}

/*
 * Under meny / Del meny
 */
 
	/**
	 * submenu function.
	 * 
	 * @access public
	 * @param mixed $page
	 * @return void
	 */
	function submenu($page){
	// Shows the submenu according to the selected page
		
		switch ($page){
			case 'help':
				return '<li> 
						<a href="?page=help&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=show">Vis dine saker</a>
					</li> 
					<li> 
						<a href="?page=help&amp;sub=adm">Administrer saker</a>
					<!--</li>
    						<li>
						<a href="?page=help_singlecase&amp;sub=adm">Admin Enkeltsak</a>
					</li>-->';
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
			/* Deaktivert standard undermeny
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
			*/
		}
	}

	


/*
 * Funksjon for å lagre data fra skjema helpdesk
 *
 * 1. Lagre detaljer om en helpdesk sak som er unikt for helpdesk
 * 2. Hente ID til sak registrert i 1 for å kunne lagre den i felles tabellen
 * 3. lagre data om sak i hovedtabellen.
 * 
 */
 
	/**
	 * save_help_case function.
	 * 
	 * @access public
	 * @param mixed $title
	 * @param mixed $employee_number
	 * @param mixed $category_id
	 * @param mixed $description
	 * @return void
	 */
	function save_help_case($title,$employee_number,$category_id,$description){

		
		// Verdi må settes for status på sak for at sak skal dukke opp
		$help_case_status = '1'; //DEFAULT må settes 1 = Registrert
		// DEL 1 tbl.help_case
		//Sette inn data unik fo helpdesk, input fra funksjon
		$sql = "INSERT INTO [tbl.help_case](help_case_title,case_problem_type,help_case_description,help_case_status)
		  		VALUES('$title','$category_id','$description','$help_case_status')";
		
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
		$reg_user = '1078'; // må settes til aktiv bruker - session ?

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
		//connect_to_tf($dbLink);
		return TRUE;
	}

/*
 * Funksjon for å oppdatere en enkeltsak basert på input
 */
 
	/**
	 * update_help_case function.
	 * 
	 * @access public
	 * @param mixed $case_id
	 * @param mixed $title
	 * @param mixed $employee_number
	 * @param mixed $category_id
	 * @param mixed $description
	 * @return void
	 */
	function update_help_case($case_id,$title,$employee_number,$category_id,$description){


		// DEL 1 tbl.help_case
		//Sette inn data unik fo helpdesk, input fra funksjon
		  $sql = "";
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
		$sql = "";
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
 
 /**
  * save_food_case function.
  * 
  * @access public
  * @param mixed $title
  * @param mixed $employee_number
  * @param mixed $id_food_problem
  * @param mixed $description
  * @return void
  */
 function save_food_case($title,$employee_number,$id_food_problem_location,$id_food_problem_unit,$id_food_problem_type,$food_problem_description,$is_help_case){

		// DEL 1 tbl.help_case
		//Sette inn data unik for matproblemer, input fra funksjon
                $status = "1";
  		$sql = "INSERT INTO [tbl.food_case](food_case_title,id_food_problem_type, food_case_description, food_case_status, id_food_case_location, id_food_case_problem_unit )
  				VALUES('$title','$id_food_problem_type','$food_problem_description','$status','$id_food_problem_location','$id_food_problem_unit')";
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
		$reg_user = '1078'; // må settes til aktiv bruker - session ?

    	//DEL 3
    	// tbl.main_case
		$dato = 'GETDATE()'; // lagrer timestamp server.
    	//Sette inn data unik fo helpdesk, input fra funksjon
		$sql = "INSERT INTO [tbl.main_case](created_date,reg_user,reg_employee,id_food_case, is_food_case, is_help_case)
				VALUES ($dato,'$reg_user','$employee_number','$food_case_id','1','$is_help_case')";
    	// Lagre data i tbl.man_case
		if(!mssql_query($sql)){
			return FALSE;
			exit;
		}
		
		return TRUE;
	}


/*
 * Henter alle kategorier
 */
 
 /**
  * get_categories function.
  * 
  * @access public
  * @return void
  */
 function get_categories(){
 	//connect_to_tf();
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


     /*
	* Henter avdelinger
	*/

     /**
      * get_department function.
      * 
      * @access public
      * @return void
      */
     function get_department(){
   	// koble til server og base
   	//connect_to_tf();
   	$sql =  "SELECT * FROM [tbl.department]";
   	$resultat = mssql_query($sql);
   	$avdelinger = array();
   	while($rad = mssql_fetch_array($resultat)){
    		$id = $rad['id_department'];
    		$avdelinger[$id]['number'] = $rad['department_number'];
    		$avdelinger[$id]['name'] = $rad['department_name'];
   	}
   	return $avdelinger;
     }


/*
 * Henter info om brukeren.
 * Tar bruker id som inndata.
 */
 
	/**
	 * user_info function.
	 * 
	 * @access public
	 * @param mixed $userId
	 * @return void
	 */
	function user_info($userId)
	{
		//connect_to_tf();
		$sql = "SELECT id_user, user_name, id_department, real_name, id_user_level, password
				FROM [tbl.user]
				WHERE id_user = $userId";
		$resultat = mssql_query($sql);
		while($rad = mssql_fetch_assoc($resultat))
		{
			$bruker['id_user'] = $rad['id_user'];
			$bruker['user_name'] = $rad['user_name'];
			$bruker['id_department'] = $rad['id_department'];
			$bruker['id_user_level'] = $rad['id_user_level'];
			$bruker['password'] = $rad['password'];
		}
		
		return $bruker;
	}	


/*
 * Sjekker bruker mot DB
 */
 
	/**
	 * user_exists function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return void
	 */
	function user_exists($username){
		$sql = "SELECT user_name, id_user FROM [tbl.user]
				WHERE user_name = '$username'";
		$resultat = mssql_query($sql);
		$bruker = array();
		while($rad = mssql_fetch_array($resultat))
		{
			$bruker['user_name'] = $rad['user_name'];
			$bruker['id_user'] = $rad['id_user'];
		}
		return $bruker;
	}



/*
 * Henter ut liste over alle heldesk saker fra view på sql server
 */
 
   /**
    * helpdesk_list function.
    * 
    * @access public
    * @return void
    */
   function helpdesk_list(){

 	// Spørring
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
	,[is_help_case]
	FROM [v.help_case]";

 	// Kjør spørring
 	$data = mssql_query($sql);
 	// Tabell Overskrift
	echo "<tr><th></th><th>
                                ID-Sak</th><th>".
  				"Dato</th><th>".
    			//    "Bruker ID</th><th>".
  				"Ansatt-ID</th><th>".
    			//    "HelpcaseID</th><th>".
  				"Tittel</th><th>".
    			//    "Problemtype ID</th><th>".
  				"Problemtype</th><th>".
  				"Saksbeskrivelse</th><th>".
  				"Løsning</th><th>".
  				"Status</th><th>".
  				"Er Helpdesk</th><th>".
    		"</th></tr>";
		
		// For alternerende bakgrunn på radene.
		$rad = 0;
		
		while($row = mssql_fetch_array($data)){
		//lager tabell
     	echo "<tr class=\"row$rad\"><td>"."<input type=\"checkbox\" name=\"case_id\" value=\"".$row['id_main_case']."\" /></td><td>".
                                $row['id_main_case']."</td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_help_case']."</td><td>".
   				$row['help_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['help_problem_type_description']."</td><td>".
   				$row['help_case_description']."</td><td>".
                                $row['help_case_solution']."</td><td>".
                                "<select>".
                                get_helpdesk_status_drop_down()."</td><td>".
   				"</select>".
                        //        $row['help_case_status']."</td><td>".
   				true_false($row['is_help_case'])."</td><td>".
   				"<input type=\"button\" value=\"Endre\" name=\"edit\" /></td><td>".
    		"</td></tr>";
    		
    		// Annenhver gang 1 og 0
    		$rad = 1 - $rad;
 	}

}

/*
 * True false svar i klartekst
 */

function true_false($input){

    if($input == '0'){
        $svar = "Nei";
    }
    if($input == '1'){
        $svar = "Ja";
    }
    return $svar;

}

/*
 * Henter ut liste over alle heldesk saker fra view på sql server
 * Input parameter brukerens id som må hentes fra session.
 *
 * Tar Alle Felter i databasen
 * $user_id
 */

	/**
	 * user_helpdesk_list function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return void
	 */
	function user_helpdesk_list($user_id){
	
	if($_SESSION['debug'])
	{
		// Setter $user_id til 1078 (Eirik) for testing
		$user_id = 1078;
	}

	// Spørring
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
	WHERE [reg_user] = '$user_id' ";

 	// Kjør spørring
 	$data = mssql_query($sql);
 	// Tabell Overskrift
  	echo "<tr><th>Velg</th><th>".
  				"ID-sak</th><th>".
  				"Dato</th><th>".
    			//    "Bruker ID</th><th>".
  				"Ansatt-ID</th><th>".
    			//    "HelpcaseID</th><th>".
  				"Tittel</th><th>".
    			//    "Problemtype ID</th><th>".
  				"Problemtype</th><th>".
  				"Saksbeskrivelse</th><th>".
    			//    "Løsning</th><th>".
    			//    "Status id</th><th>".
  				"Status</th><th>".
    			//    "Helpdesk ja/nei</th><th>".
    		"</th></tr>";
	$radnummer = 0;
 	while($row = mssql_fetch_array($data)){
   	//lager tabell
     	echo "<tr class=\"row$radnummer\"><td>"."<input type=\"checkbox\" name=\"case_id\" value=\"".$row['id_main_case']."\" /></td><td>".
   				$row['id_main_case']."</td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_help_case']."</td><td>".
   				$row['help_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['help_problem_type_description']."</td><td>".
   				$row['help_case_description']."</td><td>".
    			//     $row['help_case_solution']."</td><td>".
    			//     $row['help_case_status']."</td><td>".
   			//	$row['help_case_status_description']."</td><td>".
                               " <select name=\"help_cat\" id=\"help_cat\" class=\"validate[required]\">".
                        	get_helpdesk_status_drop_down()."</td><td>".
                                "</select>".
    			//     $row['is_help_case']."</td><td>".
    				'<a href="?page=help&sub=single&id='.$row['id_main_case'].'">Endre</a></td><td>'.
    		"</td></tr>";
    	$radnummer = 1 - $radnummer;
 	}

}


/*
 * Henter ut liste over alle ikmat saker fra view pÃ¥ sql server
 */
   function ikmat_list(){
//Database kobling
  	//connect_to_tf();

 	// SpÃ¸rring
 	$sql = "SELECT [id_main_case]
	, CAST([created_date] as CHAR(10)) AS [created_date]
	,[reg_user]
	,[reg_employee]
	,[id_food_case]
	,[food_case_title]
	,[id_food_problem_type]
	,[food_case_description]
	,[food_case_solution]
	,[food_case_status]
        ,[id_food_case_location]
	,[is_food_case]
	FROM [v.food_case]";

 	// KjÃ¸r spÃ¸rring
 	$data = mssql_query($sql);
 	// Tabell Overskrift
	echo "<tr><th>ID-Sak</th><th>".
  				"Dato</th><th>".
    			//    "Bruker ID</th><th>".
  				"Ansatt-ID</th><th>".
    			//    "FoodcaseID</th><th>".
  				"Tittel</th><th>".
    			//    "Problemtype ID</th><th>".
  				"Problemtype</th><th>".
  				"Saksbeskrivelse</th><th>".
  				"LÃ¸sning</th><th>".
  				"Status</th><th>".
                                "Lokasjon</th><th>".
  				"Helpdesk ja/nei</th><th>".
                                "</th></tr>";

		// For alternerende bakgrunn pÃ¥ radene.
		$rad = 0;
		while($row = mssql_fetch_array($data)){
   	//lager tabell
     	echo "<tr class=\"row$rad\"><td>".$row['id_food_case']."</td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_help_case']."</td><td>".
   				$row['food_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['id_food_problem_type']."</td><td>".
   				$row['food_case_description']."</td><td>".
   				$row['food_case_solution']."</td><td>".
   				$row['food_case_status']."</td><td>".
                                $row['id_food_case_location']."</td><td>".
   				$row['is_food_case']."</td><td>".
   				"<input type=\"button\" value=\"Endre\" name=\"edit\" /></td><td>".
    		"</td></tr>";

    		// Annenhver gang 1 og 0
    		$rad = 1 - $rad;
 	}

}


   function user_helpdesk_list_2(){
//Database kobling
  	//connect_to_tf();

 	// SpÃ¸rring
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
	WHERE [reg_user] = '1078' ";

 	// KjÃ¸r spÃ¸rring
 	$data = mssql_query($sql);
 	// Tabell Overskrift
  	echo "<tr><th>Velg</th><th>".
  				"ID-sak</th><th>".
  				"Dato</th><th>".
    			//    "Bruker ID</th><th>".
  				"Ansatt-ID</th><th>".
    			//    "HelpcaseID</th><th>".
  				"Tittel</th><th>".
    			//    "Problemtype ID</th><th>".
  				"Problemtype</th><th>".
  				"Saksbeskrivelse</th><th>".
    			//    "LÃ¸sning</th><th>".
    			//    "Status id</th><th>".
  				"Status</th><th>".
    			//    "Helpdesk ja/nei</th><th>".
    		"</th></tr>";

 	while($row = mssql_fetch_array($data)){
   	//lager tabell
     	echo "<tr><td>"."<input type=\"checkbox\" name=\"case_id\" value=\"case_id\" /></th><th>".
   				$row['id_main_case']."</td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_help_case']."</td><td>".
   				$row['help_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['help_problem_type_description']."</td><td>".
   				$row['help_case_description']."</td><td>".
    			//     $row['help_case_solution']."</td><td>".
    			//     $row['help_case_status']."</td><td>".
   				$row['help_case_status_description']."</td><td>".
    			//     $row['is_help_case']."</td><td>".
    				"<input type=\"button\" value=\"Endre\" name=\"edit\" /></td><td>".
    		"</td></tr>";
 	}

}
/*
 * Henter ut liste over alle ikmat saker fra view pÃ¥ sql server
 * INputt parameter brukerens id som mÃ¥ hentes fra session.
 *
 * Tar Alle Felter i databasen
 * $user_id
 */



   function user_ikmat_list(){
//Database kobling
  	//connect_to_tf();

 	// SpÃ¸rring
 	$sql = "SELECT [id_main_case]
	, CAST([created_date] as CHAR(10)) AS [created_date]
	,[reg_user]
	,[reg_employee]
	,[id_food_case]
	,[food_case_title]
	,[id_food_problem_type]
	,[food_case_description]
	,[food_case_solution]
	,[food_case_status]
        ,[id_food_case_location]
	,[is_food_case]
        FROM [v.food_case]
	WHERE [reg_user] = '1078' ";

 	// KjÃ¸r spÃ¸rring
 	$data = mssql_query($sql);
 	// Tabell Overskrift
  	echo "<tr><th>Velg</th><th>".
  				"ID-sak</th><th>".
  				"Dato</th><th>".
    			//    "Bruker ID</th><th>".
  				"Ansatt-ID</th><th>".
    			//    "HelpcaseID</th><th>".
  				"Tittel</th><th>".
    			//    "Problemtype ID</th><th>".
  				"Problemtype</th><th>".
  				"Saksbeskrivelse</th><th>".
    			//    "LÃ¸sning</th><th>".
    			//    "Status id</th><th>".
  				"Status</th><th>".
                                "Lokasjon</th><th>".
    			//    "Ikmat ja/nei</th><th>".
    		"</th></tr>";

 	while($row = mssql_fetch_array($data)){
   	//lager tabell
     	echo "<tr><td>"."<input type=\"checkbox\" name=\"case_id\" value=\"case_id\" /></th><th>".
   				$row['id_main_case']."</td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_food_case']."</td><td>".
   				$row['food_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['id_food_problem_type']."</td><td>".
   				$row['food_case_description']."</td><td>".
    			//     $row['food_case_solution']."</td><td>".
    			//     $row['food_case_status']."</td><td>".
   				$row['food_case_status']."</td><td>".
                                $row['id_food_case_location']."</td><td>".
    			//     $row['is_food_case']."</td><td>".
    				"<input type=\"button\" value=\"Endre\" name=\"edit\" /></td><td>".
    		"</td></tr>";
 	}

}


/*
 * GET MAIL ADDRESS FROM USER ID
 */
 
/**
 * get_user_email function.
 * 
 * @access public
 * @param mixed $user_id
 * @return void
 */
function get_user_email($user_id){

  	$sql="SELECT user_email from [tbl.user] where id_user = $user_id;";
  	if(!$data=mssql_query($sql)){
     	return FALSE;
     	exit;
  	}
    	$mail=mssql_fetch_array($data);
  	return $mail['user_email'];

}

/*
 * GET NUMBER OF HELPCASE CASES
 */
 
/**
 * get_count_helpdesk function.
 * 
 * @access public
 * @return void
 */
function get_count_helpdesk(){

	$sql="SELECT COUNT(id_main_case) AS helpdesk_cases from [v.help_case];";
	if(!$data=mssql_query($sql)){
	    return FALSE;
	    exit;
	}
	$mail=mssql_fetch_array($data);
	return $mail['helpdesk_cases'];

}

/*
 * GET NUMBER OF FOOD CASES
 */
 
/**
 * get_count_food function.
 * 
 * @access public
 * @return void
 */
function get_count_food(){

	$sql="SELECT COUNT(id_main_case) AS food_cases from [v.food_case];";
	if(!$data=mssql_query($sql)){
	    return FALSE;
	    exit;
	}
	$mail=mssql_fetch_array($data);
	return $mail['food_cases'];

}


/*
 * Hente ut saksstatuser for bruk i skjema
 */
 
/**
 * get_helpdesk_status function.
 * 
 * @access public
 * @return void
 */
function get_helpdesk_status(){


	
	$sql = "select * from [tbl.help_case_status]";
	if(!$data=mssql_query($sql)){
	    return FALSE;
	    exit;
	}
	$mail=mssql_fetch_array($data);
	return $mail; //['help_case_status_description'];
}



/*
 * Hente ut saksstatuser for bruk i skjema
 */
 
/**
 * get_helpdesk_status_drop_down function.
 * 
 * @access public
 * @return void
 */
function get_helpdesk_status_drop_down(){

	//Spørring
	$sql = "select id_help_case_status, help_case_status_description  from [tbl.help_case_status]";
	//Sjekk av gjennomført spørring
	if(!$data=mssql_query($sql)){
	     return FALSE;
	    exit;
	}
	
	// Henter alle verdier
	$tekst = "";
	while($list=mssql_fetch_array($data)){
	$tekst.= "<option value=\"".$list['id_help_case_status']."\">".$list['help_case_status_description']."</option>";
	
	
	}
	
	return $tekst;
}
/*
 * Hente ut saksstatuser for bruk i skjema
 */

/**
 * get_foodcase_status function.
 *
 * @access public
 * @return void
 */
function get_ikmat_status(){



	$sql = "select * from [tbl.food_case_status]";
	if(!$data=mssql_query($sql)){
	    return FALSE;
	    exit;
	}
	$mail=mssql_fetch_array($data);
	return $mail; //['ikmat_case_status_description'];
}



/*
 * Hente ut saksstatuser for bruk i skjema
 */

/**
 * get_foodcase_status_drop_down function.
 *
 * @access public
 * @return void
 */
function get_foodcase_status_drop_down(){

	//Spørring
	$sql = "select id_food_case_status, food_case_status_description  from [tbl.food_case_status]";
	//Sjekk av gjennomført spørring
	if(!$data=mssql_query($sql)){
	     return FALSE;
	    exit;
	}
	// Start av dropdown
	$start = "<select>";
	// Henter alle verdier
	$tekst = "";
	while($list=mssql_fetch_array($data)){
	$tekst.= "<option value=\"".$list['id_food_case_status']."\">".$list['food_case_status_description']."</option>";


	}
	//Slutt på dropdown
	$slutt = "</select>";

	return $start.$tekst.$slutt;
}


/*
 * Sanitering av strenger.
 */
 
/**
 * sanitize_string function.
 * 
 * @access public
 * @param mixed $string_in
 * @return void
 */
function sanitize_string($string_in)
{
	$string_out = mysql_escape_string($string_in);
	return $string_out;
}


/*
 * Henter ut drop down valg for bruk i registrering av hellpdesk saker
 */

function get_helpdesk_type_drop_down(){

    $sql = "SELECT   A.help_problem_type_description AS level_1, B.id_help_problem_type AS ID, B.help_problem_type_description AS level_2
  FROM [hjelpomat].[dbo].[tbl.help_problem_type] AS A
  INNER JOIN [hjelpomat].[dbo].[tbl.help_problem_type] AS B ON (A.id_help_problem_type = B.parent_help_problem_id)
  Order by A.parent_help_problem_id asc";
//Sjekk av gjennomført spørring
if(!$data=mssql_query($sql)){
     return FALSE;
    exit;
}


// Henter alle verdier
$option = "";
while($list=mssql_fetch_array($data)){
$option.= "<option value=\"".$list['ID']."\">".$list['level_1']." - ".$list['level_2']."</option>";


}
//print ut
return $option;
}



        
 /*
 * Henter ut drop down valg for typer ikmat avvik
 */

function get_ikmat_type_drop_down(){

    $sql = "SELECT[id_food_problem_type],[food_problem_description]      
  FROM [hjelpomat].[dbo].[tbl.food_problem_type]";
//Sjekk av gjennomført spørring
if(!$data=mssql_query($sql)){
     return FALSE;
    exit;
}


// Henter alle verdier
$option = "";
while($list=mssql_fetch_array($data)){
$option.= "<option value=\"".$list['id_food_problem_type']."\">".$list['food_problem_description']."</option>";


}
//print ut
return $option;
}

 /*
 * Henter ut drop down valg for typer ikmat avvik
 */

function get_ikmat_unit_drop_down(){

    $sql = "SELECT A.problem_unit_name AS level_1, B.id_problem_unit AS ID, B.problem_unit_name AS level_2
  FROM [hjelpomat].[dbo].[tbl.food_case_problem_unit] AS A
   INNER JOIN [hjelpomat].[dbo].[tbl.food_case_problem_unit] AS B ON (A.id_problem_unit = B.parrent_problem_unit)
  Order by A.parrent_problem_unit asc";
//Sjekk av gjennomført spørring
if(!$data=mssql_query($sql)){
     return FALSE;
    exit;
}


// Henter alle verdier
$option = "";
while($list=mssql_fetch_array($data)){
$option.= "<option value=\"".$list['ID']."\">".$list['level_1']." - ".$list['level_2']."</option>";


}
//print ut
return $option;
}



 /*
 * Henter ut drop down valg for typer ikmat avvik
 */

function get_ikmat_place_drop_down(){

	$sql = "SELECT A.location_name AS level_1, B.id_food_case_location AS ID, B.location_name AS level_2
	FROM [hjelpomat].[dbo].[tbl.food_case_location] AS A
	INNER JOIN [hjelpomat].[dbo].[tbl.food_case_location] AS B ON (A.id_food_case_location= B.parent_food_case_location)
	Order by A.parent_food_case_location asc";
	//Sjekk av gjennomført spørring
	if(!$data=mssql_query($sql)){
	     return FALSE;
	    exit;
	}
	
	
	// Henter alle verdier
	$option = "";
	while($list=mssql_fetch_array($data))
	{
		$option.= "<option value=\"".$list['ID']."\">".$list['level_1']." - ".$list['level_2']."</option>";
	}
	//print ut
	return $option;
}



/*
 * Oppretter pdf
 * Returverdien må printes ut i en ny side.
 */

/**
 * make_case_pdf function.
 * 
 * @access public
 * @return void
 */
function make_case_pdf()
{
	// Tester en variabel i PDF-en.
	$tiden = date('H.i:s');
	
	
	// Oppretter en peker til PDF-en.
	$minPdf = PDF_new();
	
	// Åpner PDFen for redigering.
	PDF_open_file($minPdf, "");
	
	// Starter på en side med A4(?)-størrelse.
	PDF_begin_page($minPdf, 595, 842);
	
	// Setter en font.
	$minFont = PDF_findfont($minPdf, "Times-Roman", "host", 0);
	PDF_setfont($minPdf, $minFont, 10);
	
	// Skriver til siden vi har startet, koordinater fra nederste venstre hjørne.
	PDF_show_xy($minPdf, "Hurra for PDF!", 50, 750);
	PDF_show_xy($minPdf, "Dette fungerer.", 50, 730);
	PDF_show_xy($minPdf, "Klokka er $tiden", 50, 710);

	// Avslutter siden.
	PDF_end_page($minPdf);
	
	// Avslitter PDF-en.
	PDF_close($minPdf);
	
	// Henter innholdet i bufferen (henter PDF-en, altså).
	$buffer = PDF_get_buffer($minPdf);
	
	// Finner størrelsen på fila.
	$lengde = strlen($buffer);
	
	// Setter filheadere så nettleseren skjønner at den får 
	// servert en PDF-fil.
	header("Content-type: application/pdf");
	header("Content-Length: $lengde");
	header("Content-Disposition: inline; filename=sak.pdf");
	
	// Sletter PDF-en fra minnet.
	PDF_delete($minPdf);
	
	// Serverer ut PDF-en til nettleseren.
	return $buffer;
}



/*
 * Returnerer info om en enkeltsak.
 */

/**
 * get_single_helpdesk_case function.
 * 
 * @access public
 * @param mixed $caseID
 * @return void
 */
function get_single_helpdesk_case($caseID)
{
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
	WHERE [id_main_case] = '$caseID' ";
	
	if(!$data=mssql_query($sql)){
		return FALSE;
		exit;
	}
	
	while($list = mssql_fetch_array($data))
	{
		$case = $list;
	}
	return $case;
}
?>