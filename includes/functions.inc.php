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
 * Undermeny / Delmeny
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
				if($_SESSION['user_level'] >= 2)
					{
                                        return '<li>
						<a href="?page=help&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=show">Vis dine saker</a>
					</li> 
					<li>
                                                <a href="?page=help&amp;sub=adm">Administrer saker</a>
                                        </li>';
                                        }
                                        else{
                                         return '<li> 
						<a href="?page=help&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&amp;sub=show">Vis dine saker</a>
					</li>';
                                       
                                        }
				break;
			case 'ikmat':
                                if($_SESSION['user_level'] >= 2)
					{
                                        return '<li>
						<a href="?page=ikmat&amp;sub=register">Registrer hendelse</a> 
					</li> 
					<li> 
						<a href="?page=ikmat&amp;sub=show">Vis hendelser</a> 
					</li> 
					<li> 
						<a href="?page=ikmat&amp;sub=adm">Administrer saker</a> 
					</li>';
                                        }
                                        else{
                                        return '<li>
						<a href="?page=ikmat&amp;sub=register">Registrer hendelse</a>
					</li>
					<li>
						<a href="?page=ikmat&amp;sub=show">Vis hendelser</a>
					</li>';
					}
				break;
			case 'drift':
                                if($_SESSION['user_level'] >= 2)
					{
                                        return '<li>
						<a href="?page=drift&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=drift&amp;sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=drift&amp;sub=adm">Administrer saker</a> 
					</li>';
                                        }
                                        else{
                                        return '<li>
						<a href="?page=drift&amp;sub=register">Registrer sak</a>
					</li>
					<li>
						<a href="?page=drift&amp;sub=show">Vis saker</a>
					</li>';
                                        }
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
 * 3. Lagre data om sak i hovedtabellen.
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
	function save_help_case($title,$employee_number,$category_id,$description,$user_id){

		
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
		//$reg_user = '1078'; // må settes til aktiv bruker - session ?

    	//DEL 3
    	// tbl.main_case
		$dato = 'GETDATE()'; // lagrer timestamp server.
    		$is_help_case = '1';
    	//Sette inn data unik for helpdesk, input fra funksjon
		$sql = "INSERT INTO [tbl.main_case](created_date,reg_user,reg_employee,id_help_case,is_help_case)
				VALUES ($dato,'$user_id','$employee_number','$help_case_id','$is_help_case')";
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
 * 2. Finne id av nr 1
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
 function save_food_case($title,$employee_number,$id_food_problem_location,$id_food_problem_unit,$id_food_problem_type,$food_problem_description,$is_help_case,$user_id){

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
	//	$reg_user = '1078'; // må settes til aktiv bruker - session ?

    	//DEL 3
    	// tbl.main_case
		$dato = 'GETDATE()'; // lagrer timestamp server.
    	//Sette inn data unik fo helpdesk, input fra funksjon
		$sql = "INSERT INTO [tbl.main_case](created_date,reg_user,reg_employee,id_food_case, is_food_case, is_help_case)
				VALUES ($dato,'$user_id','$employee_number','$food_case_id','1','$is_help_case')";
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
                                echo "<tr><th>Velg</th><th>".
                                "ID</th><th>".
  				"Dato</th><th>".
                      	  //    "Bruker ID</th><th>".
  				"Ansatt</th><th>".
    			  //    "HelpcaseID</th><th>".
  				"Tittel</th><th>".
    			  //    "Problemtype ID</th><th>".
  				"Problemtype</th><th>".
  				"Saksbeskrivelse</th><th>".
  				"Løsning</th><th>".
  				"Status</th><th>".
  				"Helpdesk</th><th>".
    		"</th></tr>";
		
		// For alternerende bakgrunn på radene.
		$rad = 0;
		
		while($row = mssql_fetch_array($data)){
        // Begrenser lengden på saksbeskrivelsen og setter tre prikker dersom beskrivelsen blir kuttet.
	if(strlen($row['help_case_description']) > 40)
	{
		$dotdot = "…";
	}
	else
	{
		$dotdot = "";
	}
	$beskrivelse = substr($row['help_case_description'], 0, 40).$dotdot;
        // Begrenser lengden på løsningen og setter tre prikker dersom beskrivelsen blir kuttet.
	if(strlen($row['help_case_solution']) > 40)
	{
		$dotdot = "…";
	}
	else
	{
		$dotdot = "";
	}
	$beskrivelselosning = substr($row['help_case_solution'], 0, 40).$dotdot;
                
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
   				//$row['help_case_description']."</td><td>".
                                $beskrivelse."</td><td>".
                               // $row['help_case_solution']."</td><td>".
                                $beskrivelselosning."</td><td>".
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
 * Henter ut liste over alle helpdesk saker fra view på sql server
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
	
	// Begrenser lengden på saksbeskrivelsen og setter tre prikker dersom beskrivelsen blir kuttet.
	if(strlen($row['help_case_description']) > 40)
	{
		$dotdot = "…";
	}
	else
	{
		$dotdot = "";
	}
	$beskrivelse = substr($row['help_case_description'], 0, 40).$dotdot;
	
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
   				$beskrivelse."</td><td>".
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
      ,[case_closed]
      ,[id_food_case]
      ,[food_case_title]
      ,[id_food_problem_type]
      ,[food_problem_description]
      ,[food_case_description]
      ,[food_case_solution]
      ,[food_case_status]
      ,[food_case_status_name]
      ,[id_food_case_location]
      ,[location_name]
  FROM [hjelpomat].[dbo].[v.food_case]";

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
  			
  				"Status</th><th>".
                                "Lokasjon</th><th>".
  			//	"Helpdesk ja/nei</th><th>".
                                "</th></tr>";

		// For alternerende bakgrunn pÃ¥ radene.
		$rad = 0;
		while($row = mssql_fetch_array($data)){
   	//lager tabell
     	echo "<tr class=\"row$rad\"><td>"."<input type=\"checkbox\" name=\"case_id\"value=\"".$row['id_food_case']."\" /></td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_help_case']."</td><td>".
   				$row['food_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['id_food_problem_type']."</td><td>".
   				$row['food_case_description']."</td><td>".
   			//	$row['food_case_solution']."</td><td>".
                                 "<select>".
                                 get_food_status_drop_down()."</td><td>".
   				"</select>".
   			//	$row['food_case_status']."</td><td>".
                        //  	$row['food_case_status_name']."</td><td>".
                        //        $row['id_food_case_location']."</td><td>".
                                $row['location_name']."</td><td>".
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


/*
 * Henter ut liste over alle ikmat saker fra view pÃ¥ sql server
 */
   function user_ikmat_list($user_id){
//Database kobling
  	//connect_to_tf();

 	// SpÃ¸rring
 	$sql = "SELECT [id_main_case]
	, CAST([created_date] as CHAR(10)) AS [created_date]
	,[reg_user]
      ,[reg_employee]
      ,[case_closed]
      ,[id_food_case]
      ,[food_case_title]
      ,[id_food_problem_type]
      ,[food_problem_description]
      ,[food_case_description]
      ,[food_case_solution]
      ,[food_case_status]
      ,[food_case_status_name]
      ,[id_food_case_location]
      ,[location_name]
  FROM [hjelpomat].[dbo].[v.food_case]
  where reg_user = $user_id ";

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

  				"Status</th><th>".
                                "Lokasjon</th><th>".
  			//	"Helpdesk ja/nei</th><th>".
                                "</th></tr>";

		// For alternerende bakgrunn pÃ¥ radene.
		$rad = 0;
		while($row = mssql_fetch_array($data)){
   	//lager tabell
     	echo "<tr class=\"row$rad\"><td>"."<input type=\"checkbox\" name=\"case_id\"value=\"".$row['id_food_case']."\" /></td><td>".
   				$row['created_date']."</td><td>".
    			//     $row['reg_user']."</td><td>".
   				$row['reg_employee']."</td><td>".
    			//     $row['id_help_case']."</td><td>".
   				$row['food_case_title']."</td><td>".
    			//     $row['case_problem_type']."</td><td>".
   				$row['id_food_problem_type']."</td><td>".
   				$row['food_case_description']."</td><td>".
   			//	$row['food_case_solution']."</td><td>".
                                 "<select>".
                                 get_food_status_drop_down()."</td><td>".
   				"</select>".
   			//	$row['food_case_status']."</td><td>".
                        //  	$row['food_case_status_name']."</td><td>".
                        //        $row['id_food_case_location']."</td><td>".
                                $row['location_name']."</td><td>".
   				$row['is_food_case']."</td><td>".
   				"<input type=\"button\" value=\"Endre\" name=\"edit\" /></td><td>".
    		"</td></tr>";

    		// Annenhver gang 1 og 0
    		$rad = 1 - $rad;
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
		$case['id_main_case'] = $list['id_main_case'];
		$case['created_date'] = $list['created_date'];
		$case['reg_user'] = $list['reg_user'];
		$case['reg_employee'] = $list['reg_employee'];
		$case['id_help_case'] = $list['id_help_case'];
		$case['help_case_title'] = $list['help_case_title'];
		$case['case_problem_type'] = $list['case_problem_type'];
		$case['help_problem_type_description'] = $list['help_problem_type_description'];
		$case['help_case_description'] = $list['help_case_description'];
		$case['help_case_solution'] = $list['help_case_solution'];
		$case['help_case_status'] = $list['help_case_status'];
		$case['help_case_status_description'] = $list['help_case_status_description'];
		$case['is_help_case'] = $list['is_help_case'];
	}
	return $case;
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
/**
 * get_helpdesk_status_drop_down function.
 *
 * @access public
 * @return void
 */
function get_food_status_drop_down(){

	//Spørring
	$sql = "SELECT [id_food_case_status],[food_case_status_name]
         FROM [hjelpomat].[dbo].[tbl.food_case_status]";
	//Sjekk av gjennomført spørring
	if(!$data=mssql_query($sql)){
	     return FALSE;
	    exit;
	}

	// Henter alle verdier
	$tekst = "";
	while($list=mssql_fetch_array($data)){
	$tekst.= "<option value=\"".$list['id_food_case_status']."\">".$list['food_case_status_name']."</option>";

	
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
 * Oppretter PDF med det frie biblioteket FPDF.
 */
 
/**
 * print_case_pdf function.
 * 
 * @access public
 * @param mixed $caseID
 * @return void
 */
function print_case_pdf($caseID)
{
	// Setter FPDF-konstant og inkluderer FPDF-fila.
	define('FPDF_FONTPATH','/var/www/includes/font/');
	require('fpdf.php');
	
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 16);
	$pdf->Cell(40,10,'Hello World!');
	$pdf->Output();
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
function make_case_pdf($caseID)
{
	$caseInfo = get_single_helpdesk_case($caseID);
	// Tester en variabel i PDF-en.
	$timestamp = date('j/n - Y  H.i:s');
	
	
	// Oppretter en peker til PDF-en.
	$minPdf = PDF_new();
	
	// Åpner PDFen for redigering.
	PDF_open_file($minPdf, "");
	
	// Starter på en side med A4(?)-størrelse.
	PDF_begin_page($minPdf, 595, 842);
	
	// Setter UTF-8 tegnsett.
	pdf_set_parameter($minPdf, "textformat", "utf8");
	
	// Setter fonter.
	$bodyFont = PDF_findfont($minPdf, "Times-Roman", "host", 0);
	$fatFont = PDF_findfont($minPdf, "Helvetica-Bold", "host", 0);
	$headFont = PDF_findfont($minPdf, "Helvetica-Bold", "host", 0);
	$italicBodyFont = PDF_findfont($minPdf, "Times-Italic", "host", 0);
		
		
	// Aktiverer overskriftfont.
	PDF_setfont($minPdf, $headFont, 18);
	
	// Skriver på siden
	PDF_show_xy($minPdf, $caseInfo['help_case_title'], 30, 720);
	
	
	// Aktiverer brødtekstfont.	
	PDF_setfont($minPdf, $bodyFont, 12);
	
	// Skriver til siden vi har startet, koordinater fra nederste venstre hjørne.
	PDF_show_xy($minPdf, $caseInfo['help_problem_type_description'], 30, 750);
	// Beskrivelse
	PDF_show_xy($minPdf, $caseInfo['help_case_description'], 30, 700);
	
	
	// Aktiverer fotnotefont
	PDF_setfont($minPdf, $bodyFont, 10);
	
	// Skriver på siden.
	PDF_show_xy($minPdf, $timestamp, 500, 800);	// Dato og tidspunkt for utskrift.
	PDF_show_xy($minPdf, $timestamp, 30, 800);	// Bruker som lagde saken.
	
	
	
	// Aktiverer kursiv tekst.
	PDF_setfont($minPdf, $italicBodyFont, 12);
	
	// Overskrift for tekstboks.
	PDF_show_xy($minPdf, "Kommentar", 50, 260);
	
	
	// Aktiverer fet tekst.
	PDF_setfont($minPdf, $fatFont, 14);
	
	// Skriver tekst til sjekkboksene nederst.
	PDF_show_xy($minPdf, "Fullført", 50, 73);
	PDF_show_xy($minPdf, "Ikke utført", 220, 73);
	PDF_show_xy($minPdf, "Trenger ytterligere utbedring", 380, 73);
	

	// Lager en tekstboks for utfylling av kommentar og avkryssning av (ikke) utført.
	PDF_rect($minPdf, 30, 100, 535, 150);
	PDF_rect($minPdf, 30, 70, 15,15);	//Fullført
	PDF_rect($minPdf, 200, 70, 15,15);	//Ikke utført
	PDF_rect($minPdf, 360, 70, 15,15);	//Trenger mer..
	PDF_stroke($minPdf);
	
	
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

?>
