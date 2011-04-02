<?php
	require_once('includes/head.inc.php');
?>
		
<?php
	if($_SESSION['loggedin'])
	{
		include_once('includes/body.inc.php');
		include_once(page($_GET['page'], $_GET['sub']));
		
		// Utfører ønsket handling fra helpdesk-liste
		if(isset($_GET['helplist_do'])) // debug
		//if(isset($_POST['helplist_do']))
		{
			echo "Her gjør jeg noe med sakene dine!";
		}
	}
	else
	{
		include_once('login.php');
	}
?>

<?php
	include_once('includes/foot.inc.php');
?>