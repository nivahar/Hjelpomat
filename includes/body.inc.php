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
						$active = NULL;
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