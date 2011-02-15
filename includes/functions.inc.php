<?php
	function page($page, $subpage){
	// Shows the correct page according to the 

		$content_path = 'includes/content/';

		if(!isset($page)){
			$show_page = 'default.php';
		}
		elseif($page == 'help'){
			$show_page = 'help.php';
		}
		else{
			return NULL;
		}
		
		return $content_path.$show_page;
	}
?>