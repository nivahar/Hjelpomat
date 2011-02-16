<?php
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
	
	function submenu($page){
	// Shows the submenu according to the selected page
		
		switch ($page){
			case 'help':
				return '<li> 
						<a href="?page=help&sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=help&sub=adm">Administrer saker</a> 
					</li>';
				break;
			case 'ikmat':
				return '<li> 
						<a href="?page=ikmat&sub=register">Registrer hendelse</a> 
					</li> 
					<li> 
						<a href="?page=ikmat&sub=show">Vis hendelser</a> 
					</li> 
					<li> 
						<a href="?page=ikmat&sub=adm">Administrer saker</a> 
					</li>';
				break;
			case 'drift':
				return '<li> 
						<a href="?page=drift&sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=drift&sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=drift&sub=adm">Administrer saker</a> 
					</li>';
				break;
			default:
				return '<li> 
						<a href="?page=help&sub=register">Registrer sak</a> 
					</li> 
					<li> 
						<a href="?page=help&sub=show">Vis saker</a> 
					</li> 
					<li> 
						<a href="?page=help&sub=adm">Administrer saker</a> 
					</li>';
		}
	}
?>