<?php
	session_start();
	require_once('includes/functions.inc.php');
	
	
	/*
	 * Kobling til database
	 */
	 
	//Login data finnes i fil:
	require 'db_secure.php';
	// Legger logindata i et array.
	$dbLogin = db_login();
	$dbConnection = mssql_connect($dbLogin['address'], $dbLogin['user'], $dbLogin['pass']);
	
	// Setter database
	if(!mssql_select_db('hjelpomat', $dbConnection))
	{
		die('Kunne ikke koble til database');
	}
	
	
	// Tømmer session-variabelen dersom brukeren har klikket på "logg ut"
	if(isset($_GET['logout']))
	{
		$_SESSION = array();
	}
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
	
	<script src="/media/javascript/jquery-1.5.min.js" type="text/javascript"charset="utf8"></script>  
	<script src="/media/javascript/jquery.validationEngine-no.js" type="text/javascript" charset="utf-8"></script>
	<script src="/media/javascript/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script src="/media/javascript/bruker.js" type="text/javascript" charset="utf8"></script>
	<script src="/media/javascript/input_valid.js" type="text/javascript" charset="utf8"></script>
</head> 

