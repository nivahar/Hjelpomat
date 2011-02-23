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
	<link rel="stylesheet" type="text/css" href="/media/css/validationEngine.jquery.css" media="screen"/>
	
	<script src="/media/javascript/jquery-1.5.min.js" type="text/javascript"></script>  
	<script src="/media/javascript/jquery.validationEngine-no.js" type="text/javascript" charset="utf-8"></script>
	<script src="/media/javascript/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#reg_help").validationEngine();
		});
		
		/**
			*
			* @param {jqObject} the field where the validation applies
			* @param {Array[String]} validation rules for this field
			* @param {int} rule index
			* @param {Map} form options
			* @return an error string if validation failed
			*/
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}

		function field1_or_field2_or_field3(field, rules, i, options) {
			if (
				($("#field1").val() == "") &&
				($("#field2").val() == "") &&
				($("#field3").val() == "")
			) {
				return "At least one field is required";
			} else {
				jQuery("#formID").validationEngine("closePrompt", $($("#field1").get(0)));
				jQuery("#formID").validationEngine("closePrompt", $($("#field2").get(0)));
				jQuery("#formID").validationEngine("closePrompt", $($("#field3").get(0)));
			}
		}
	</script>
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