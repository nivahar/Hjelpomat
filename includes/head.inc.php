<?php
	session_start();
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
	<script src="/media/javascript/bruker.js" type="text/javascript"></script>

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
				return "Minst ett felt er påkrevd";
			} else {
				jQuery("#formID").validationEngine("closePrompt", $($("#field1").get(0)));
				jQuery("#formID").validationEngine("closePrompt", $($("#field2").get(0)));
				jQuery("#formID").validationEngine("closePrompt", $($("#field3").get(0)));
			}
		}
	</script>
</head> 

