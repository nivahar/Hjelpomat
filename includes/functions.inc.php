<?php

/*
 * Hovedmeny
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
        elseif($page == 'help_list')
        {
			$show_page = 'help_list.php';
		}
        elseif($page == 'help_admin')
        {
			$show_page = 'help_admin.php';
		}
        elseif($page == 'help_singlecase')
        {
			$show_page = 'help_singlecase.php';
		}
		elseif($page == 'ikmat')
		{
			$show_page = 'ikmat.php';
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
	function submenu($page){
	// Shows the submenu according to the selected page
		
		switch ($page){
			case 'help':
				return '<li> 
						<a href="?page=help&amp;sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help_list&amp;sub=show">Vis Brukers Saker</a>
					</li> 
					<li> 
						<a href="?page=help_admin&amp;sub=adm">Administrer saker</a>
					</li>
                                        <li>
						<a href="?page=help_singlecase&amp;sub=adm">Admin Enkeltsak</a>
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
		return TRUE;
	}

/*
 * Funksjon for å oppdatere en enkeltsak bassert på input
 */
	function update_help_case($case_id,$title,$employee_number,$category_id,$description){

		//Database kobling
		if(!connect_to_tf()){
			return FALSE;
			exit;
		}

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
		$reg_user = '1078'; // må settes til aktiv bruker - session ?

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


         /*
          * Henter avdelinger
          */

         function get_department(){
             // koble til server og base
             connect_to_tf();
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
 * Henter ut liste over alle heldesk saker fra view på sql server
 */
   function helpdesk_list(){
//Database kobling
        connect_to_tf();

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
        echo "<tr><th>ID Sak</th><th>".
                          "Dato</th><th>".
                      //    "Bruker ID</th><th>".
                          "Ansatt ID</th><th>".
                      //    "HelpcaseID</th><th>".
                          "tittel</th><th>".
                      //    "Problemtype ID</th><th>".
                          "Problemtype</th><th>".
                          "SaksBeskrivelse</th><th>".
                          "Løsning</th><th>".
                          "Status</th><th>".
                          "Helpdesk ja/nei</th><th>".
                "</th></tr>";

       while($row = mssql_fetch_array($data)){
         //lager tabell
           echo "<tr><td>".$row['id_main_case']."</td><td>".
                           $row['created_date']."</td><td>".
                      //     $row['reg_user']."</td><td>".
                           $row['reg_employee']."</td><td>".
                      //     $row['id_help_case']."</td><td>".
                           $row['help_case_title']."</td><td>".
                      //     $row['case_problem_type']."</td><td>".
                           $row['help_problem_type_description']."</td><td>".
                           $row['help_case_description']."</td><td>".
                           $row['help_case_solution']."</td><td>".
                           $row['help_case_status']."</td><td>".
                           $row['is_help_case']."</td><td>".
                           "<input type=\"button\" value=\"Endre\" name=\"edit\" /></td><td>".
                "</td></tr>";
       }

}

/*
 * Henter ut liste over alle heldesk saker fra view på sql server
 * INputt parameter brukerens id som må hentes fra session.
 *
 * Tar Alle Felter i databasen
 * $user_id
 */



   function user_helpdesk_list(){
//Database kobling
        connect_to_tf();

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
      WHERE [reg_user] = '1078' ";

       // Kjør spørring
       $data = mssql_query($sql);
       // Tabell Overskrift
        echo "<tr><th>Velg</th><th>".
                          "ID sak</th><th>".
                          "Dato</th><th>".
                      //    "Bruker ID</th><th>".
                          "Ansatt ID</th><th>".
                      //    "HelpcaseID</th><th>".
                          "tittel</th><th>".
                      //    "Problemtype ID</th><th>".
                          "Problemtype</th><th>".
                          "SaksBeskrivelse</th><th>".
                      //    "Løsning</th><th>".
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



?>