<?php
	require_once('includes/functions.inc.php');
?>
<!DOCTYPE html> 
<html lang="no" xml:lang="no"> 
<head> 
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<meta name="keywords" content=""> 
	<meta name="description" content=""> 
	<title> 
		Hjelpomat
	</title> 
	
	<link rel="stylesheet" type="text/css" href="/media/css/reset.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="/media/css/forms.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="/media/css/master.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="/media/css/hjelp.css" media="screen" />
	
	<script src="/media/javascript/jquery-1.5.min.js" type="text/javascript"></script>  
 
</head> 

<body class="colored"> 
 
	
 
	<div id="header-container"> 
		
		<div id="header-container-content"> 
			
			<div id="top-container"> 
				<a href="/"> 
					<div id="header-logo"></div> 
				</a> 
			</div> 
			
			<?php
				switch ($_GET['page']){
					case 'help':
						$active = 'helpdesk-menu';
						break;
					case 'drift':
						$active = 'drift-menu';
						break;
					case 'ikmat':
						$active = 'ikmat-menu';
						break;
					default:
						$active = 'helpdesk-menu';
				}
			?>
			
			<div id="menu-container" class="<?php echo $active; ?>-active"> 
				<ul> 
					<li id="helpdesk-menu"> 
						<a href="?page=help"> 
							Helpdesk
						</a> 
					</li> 
					<li id="ikmat-menu"> 
						<a href="?page=ikmat"> 
							IK-mat
						</a> 
					</li> 
					<li id="drift-menu"> 
						<a href="?page=drift"> 
							Driftstans
						</a> 
					</li>
				</ul> 
			</div> 
			
		</div>
	
		<div id="submenu-container"> 
		
			<div id="submenu-container-content"> 
				<ul class="filter-menu"> 
					<?php
					  	echo submenu($_GET['page']);
					?>  
				</ul> 
			</div>
		
		</div>
	 
		<div style="clear: both"></div> 
		
	</div> 
	<div id="background-box"> 
		<div id="content-container" class=""> 