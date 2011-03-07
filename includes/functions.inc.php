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
 */
        function save_help_case($title,$employee_number,$category_id,$descrition){

            // Database kobling for å lagre.
            connect_to_tf();

        $sql = "INSERT INTO [tbl.help_case](help_case_title,case_problem_type,help_case_description) VALUES('$title','$category_id','$descrition')";


        



        }




?>